<?php

namespace App\Filament\Resources;

use App\{
    Exports\FilmProjectsExport,
    Filament\Resources\CreatorProposalResource\Pages,
    Models\CreatorProfile,
    Models\CreatorProposal,
    Models\FilmGenre,
    Models\FilmTopic,
    Models\ProposalStatus,
    Models\SponsorProfile
};
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\{
    Forms\Components\Card,
    Forms\Components\DatePicker,
    Forms\Components\Select,
    Forms\Components\SpatieMediaLibraryFileUpload,
    Forms\Components\TagsInput,
    Forms\Components\Textarea,
    Forms\Components\TextInput,
    Forms\Form,
    Forms\Get,
    Resources\Resource,
    Tables,
    Tables\Actions\Action,
    Tables\Columns\TextColumn,
    Tables\Enums\FiltersLayout,
    Tables\Filters\Filter,
    Tables\Filters\SelectFilter,
    Tables\Table
};
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use function auth;
use function collect;
use function config;

class CreatorProposalResource extends Resource implements HasShieldPermissions
{

    protected static ?string $model = CreatorProposal::class;

    protected static ?string $modelLabel = 'Film Project';

    public static ?string $slug = 'film-projects';

    protected static ?string $navigationIcon = 'heroicon-s-film';

    protected static ?string $navigationLabel = 'Film Projects';

    public ?array $data = [];


    
    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'delete_any',
            'change_status',
            'assign_sponsor'
        ];
    }

    public static function canCreate(): bool
    {
        return self::profileComplete();
    }

    public static function profileComplete()
    {
        if (auth()->user()->hasRole('creator')) {
            $profile = CreatorProfile::where(['user_id' => auth()->id()])->first();
            if ($profile) {
                $nc = collect($profile)->except('deleted_at', 'created_at', 'updated_at')
                        ->filter(fn($i) => is_null($i) || $i = "" || strlen($i) == 0)
                        ->count();
                if ($nc == 0) {
                    return true;
                }
            }
            return false;
        }
        return true;
    }

    public static function form(Form $form): Form
    {

        $can_change_status = auth()->user()->can('change_status_creator::proposal');
        $can_assign_sponsor = auth()->user()->can('assign_sponsor_creator::proposal');
        $can_create_proposal = self::profileComplete();
        return $form
                        ->disabled(!$can_create_proposal)
                        ->schema([
                            Card::make()->schema([
                                TextInput::make('working_title')->label('Working Title')->columnSpan(4),
                                TagsInput::make('topics')
                                ->separator(',')
                                ->suggestions(FilmTopic::all()->pluck('topic_name'))
                                ->label('Topics (Select All Related Topics)')->columnSpan(4)->nullable(),
                                Textarea::make('synopsis')->label('Synopsis')->columnSpanFull()->nullable(),
                                TextInput::make('film_budget')
                                ->type('number')
                                ->numeric()
                                ->label('Film Budget (KES)')
                                ->columnSpan(4)->nullable(),
                                TextInput::make('film_length')
                                ->type('number')
                                ->numeric()
                                ->label('Film Length (Minutes)')->columnSpan(4)->nullable(),
                                TextInput::make('production_time')
                                ->type('number')
                                ->numeric()
                                ->label('Production Time (Days)')->columnSpan(4)->nullable(),
                                Select::make('film_genre')
                                ->label('Film Genre  (Leave blank if optional)')
                                ->options(FilmGenre::all()->pluck('genre_name', 'id'))->columnSpan(4)->nullable(),
                                Select::make('film_type')
                                ->live()
                                ->label('Film Type (Free or Premium)')->options([
                                    'free' => 'Free',
                                    'premium' => 'Premium',
                                ])->columnSpan(4)->nullable(),
                                TextInput::make('premium_file_price')
                                ->disabled(fn(Get $get) => $get('film_type') == 'free')
                                ->label('Premium Film Price per view (KES)')
                                ->type('number')->columnSpan(4)->nullable(),
                                SpatieMediaLibraryFileUpload::make('attachments')
                                ->collection('scripts')
                                ->acceptedFileTypes(['application/pdf'])
                                ->columnSpan(4)->nullable(),
//                                --
                                SpatieMediaLibraryFileUpload::make('contracts')
                                ->collection('contracts')
                                ->acceptedFileTypes(['application/pdf'])
                                ->columnSpan(4)->nullable(),
//                                --
                                SpatieMediaLibraryFileUpload::make('trailer_upload')
                                ->collection('trailers')
                                ->acceptedFileTypes(['video/*'])
                                ->maxSize(config('media-library.max_file_size'))
                                ->columnSpan(4)->nullable(),
//                                --
                                SpatieMediaLibraryFileUpload::make('poster_upload')
                                ->collection('posters')
                                ->acceptedFileTypes(['image/*'])
                                ->maxSize(30000)
                                ->columnSpan(4)->nullable(),
//                                --
                                SpatieMediaLibraryFileUpload::make('hd_fil_upload')
                                ->label('HD file upload')
                                ->collection('videos')
                                ->acceptedFileTypes(['video/*'])
                                ->maxSize(config('media-library.max_file_size'))
                                ->columnSpan(8)->nullable(),
//                                --
                                Select::make('sponsored_by')
                                ->disabled(!$can_assign_sponsor)
                                ->label('Sponsored By')
                                ->options(
                                        SponsorProfile::all()->pluck('organization_name', 'user_id')
                                )->columnSpan(4)->nullable(),
                                Select::make('status')
                                ->disabled(!$can_change_status)
                                ->label('Status')->options(ProposalStatus::all()->pluck('status', 'id'))
                                ->columnSpan(4)->nullable(),
                            ])->columns(8),
                        ])->statePath('data');
    }

    public static function table(Table $table): Table
    {
        $admins_only = auth()->user()->can('update');

        $query = CreatorProposal::query()->with(['sponsor', 'genre']);
        if (auth()->user()->hasRole('creator')) {
            $query = $query->where('user_id', auth()->id());
        }

        return $table
                ->headerActions([
                        Tables\Actions\Action::make('Export')
                        ->action(function(){
                            return Excel::download(new FilmProjectsExport(), 'fprojects.csv');
                        })
                ])
                        ->filters([
                            SelectFilter::make('sponsored_by')
                            ->searchable()
                            ->preload()
                            ->label('Sponsor')
                            ->relationship('sponsor', 'organization_name'),
                            SelectFilter::make('film_genre')
                            ->relationship('genre', 'genre_name')
                            ->label('Genre')
                            ,
                            SelectFilter::make('status')
                            ->relationship('proposal_status', 'status'),
                            Filter::make('created_at')
                            ->form([
                                DatePicker::make('created_from')->label('From'),
                                DatePicker::make('created_until')->label('To'),
                            ])
                            ->columns(2)
                            ->columnSpan(2)
                            ->query(function (Builder $query, array $data): Builder {
                                return $query
                                ->when(
                                        $data['created_from'],
                                        fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                                )
                                ->when(
                                        $data['created_until'],
                                        fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                                );
                            })
                                ], layout: FiltersLayout::AboveContent)->filtersFormColumns(5)
                        ->filtersTriggerAction(
                                fn(Action $action) => $action
                                ->button()
                                ->label('Filter'),
                        )
                        ->query($query)
                        ->columns([
                            TextColumn::make('working_title')
                            ->label('Working Title'),
                            TextColumn::make('user.name')
                            ->name('user.name'),
                            TextColumn::make('sponsor')
                            ->name('sponsor.organization_name'),
                            TextColumn::make('genre')
                            ->name('genre.genre_name'),
                            TextColumn::make('status')
                            ->label('Proposal Status')
                            ->name('proposal_status.status'),
                            TextColumn::make('created_at')
                            ->label('Date Created')
                            ->date()
                        ])
                        ->actions([
                            Tables\Actions\EditAction::make()
                            ->label('Update Project'),
                            Tables\Actions\Action::make('updateStatus')
                            ->visible(fn() => $admins_only),
                            Tables\Actions\DeleteAction::make()
                            ->visible(auth()->user()->can('delete_creator::proposal'))
                        ])
                        ->bulkActions([
                            Tables\Actions\BulkActionGroup::make([
                                Tables\Actions\DeleteBulkAction::make(),
                            ]),
        ]);
    }

    public static function getRelations(): array
    {
        return [
                //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCreatorProposals::route('/'),
            'create' => Pages\CreateCreatorProposal::route('/create'),
            'edit' => Pages\EditCreatorProposal::route('/{record}/edit'),
        ];
    }
}
