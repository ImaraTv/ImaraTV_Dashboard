<?php

namespace App\Filament\Resources;

use App\{
    Filament\Resources\CreatorProposalResource\Pages,
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
    Resources\Resource,
    Tables,
    Tables\Columns\TextColumn,
    Tables\Enums\FiltersLayout,
    Tables\Filters\Filter,
    Tables\Filters\SelectFilter,
    Tables\Table
};
use function auth;

class CreatorProposalResource extends Resource implements HasShieldPermissions
{

    protected static ?string $model = CreatorProposal::class;

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

    public static function form(Form $form): Form
    {

        $can_change_status = auth()->user()->can('change_status_creator::proposal');
        $can_assign_sponsor = auth()->user()->can('assign_sponsor_creator::proposal');

        return $form
                        ->schema([
                            Card::make()->schema([
                                TextInput::make('working_title')->label('Working Title')->columnSpan(4),
                                TagsInput::make('topics')
                                ->separator(',')
                                ->suggestions(FilmTopic::all()->pluck('topic_name'))
                                ->label('Topics (Select All Related Topics)')->columnSpan(4)->nullable(),
                                Textarea::make('synopsis')->label('Synopsis')->columnSpanFull()->nullable(),
                                TextInput::make('film_budget')->label('Film Budget (KES)')->columnSpan(4)->nullable(),
                                TextInput::make('film_length')->label('Film Length (Minutes)')->columnSpan(4)->nullable(),
                                TextInput::make('production_time')->label('Production Time')->columnSpan(4)->nullable(),
                                Select::make('film_genre')->label('Film Genre')->options(FilmGenre::all()->pluck('genre_name', 'id'))->columnSpan(4)->nullable(),
                                Select::make('film_type')->label('Film Type')->options([
                                    'free' => 'Free',
                                    'premium' => 'Premium',
                                ])->columnSpan(4)->nullable(),
                                TextInput::make('premium_file_price')->label('Premium File Price')->type('number')->columnSpan(4)->nullable(),
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
                                ->maxSize(30000)
                                ->columnSpan(4)->nullable(),
//                                --
                                SpatieMediaLibraryFileUpload::make('poster_upload')
                                ->collection('posters')
                                ->acceptedFileTypes(['image/*'])
                                ->maxSize(30000)
                                ->columnSpan(4)->nullable(),
//                                --
                                SpatieMediaLibraryFileUpload::make('hd_fil_upload')
                                ->collection('videos')
                                ->acceptedFileTypes(['video/*'])
                                ->maxSize(30000)
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
                        ->filters([
                            SelectFilter::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'reviewing' => 'Reviewing',
                                'published' => 'Published',
                            ]),
                            Filter::make('created_at')
                            ->form([DatePicker::make('date')])
                                ,
                                ], layout: FiltersLayout::AboveContent)
                        ->query($query)
                        ->columns([
                            TextColumn::make('working_title'),
                            TextColumn::make('user.name')
                            ->name('user.name'),
                            TextColumn::make('sponsor')
                            ->name('sponsor.organization_name'),
                            TextColumn::make('genre')
                            ->name('genre.genre_name'),
                            TextColumn::make('status')
                            ->name('proposal_status.status'),
                            TextColumn::make('created_at')
                            ->date()
                        ])
                        ->filters([
                                //
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
