<?php

namespace App\Filament\Resources;

use App\{Exports\SponsorProfiles,
    Filament\Resources\SponsorResource\Pages,
    Models\FilmTopic,
    Models\Location,
    Models\SponsorProfile,
    Models\User};
use Filament\{Forms\Components\Card,
    Forms\Components\Select,
    Forms\Components\SpatieMediaLibraryFileUpload,
    Forms\Components\TagsInput,
    Forms\Components\Textarea,
    Forms\Components\TextInput,
    Forms\Form,
    Resources\Resource,
    Tables,
    Tables\Table};
use Maatwebsite\Excel\Facades\Excel;
use function auth;

class SponsorResource extends Resource
{

    protected static ?string $model = SponsorProfile::class;

    protected static ?string $navigationIcon = 'heroicon-m-building-office';

    protected static ?int $navigationSort = 5;


    #[\Override]
    public static function canAccess(): bool
    {
        return boolval(auth()->user()->approved);
    }

    public static function sponsorForm()
    {
        return Card::make()->schema(
                        [
                                    SpatieMediaLibraryFileUpload::make('logo')
                                    ->image()
                                    ->name('Organization Logo')
                                    ->collection('logo')
                                    ->columnSpan(2)->nullable(),
//                            --
                            Textarea::make('about_us')
                                    ->rows(5)
                                    ->required()
                                    ->columnSpan('4')
                                    ->label('About Us')->nullable(),
//                            --
                            TextInput::make('organization_name')
                                    ->columnSpan(3)
                                    ->label('Organization Name')->nullable(),
//                            --
                            TextInput::make('organization_website')
                                    ->url()
                                    ->suffixIcon('heroicon-m-globe-alt')
                                    ->columnSpan(3)
                                    ->label('Organization Website')->nullable(),
//                            --
                            TextInput::make('default_call_to_action')
                                    ->columnSpan(3)
                                    ->label('Default Call to Action')->required(),
                            //                            --
                            TextInput::make('default_call_to_action_link')
                                    ->url()
                                    ->suffixIcon('heroicon-m-globe-alt')
                                    ->columnSpan(3)
                                    ->label('Default Call to Action Link')->required(),
//                            --
                            TagsInput::make('topics_of_interest')
                                    ->placeholder('Topics of Interst')
                                    ->suggestions(FilmTopic::all()->pluck('topic_name'))
                                    ->columnSpanFull()
                                    ->label('Topics of Interest')->nullable(),
//                            --
                            TagsInput::make('locations_of_interest')
                                    ->suggestions(Location::all()->pluck('location_name'))
                                    ->separator(',')
                                    ->placeholder('locations of interest')
                                    ->separator(',')
                                    ->columnSpanFull()
                                    ->label('Locations of Interest')->nullable(),
//                            --
                            Select::make('user_id')
                                    ->label('User')
                                    ->options(
                                        User::where('role', 'sponsor')->pluck('name', 'id')
                                    )
                                    ->columnSpan(3)->required(),
                            TextInput::make('contact_person_name')
                                    ->columnSpan(3)
                                    ->label('Contact Person Name')->nullable(),
//                            --
                            TextInput::make('contact_person_email')
                                    ->columnSpan(3)
                                    ->label('Contact Person Email')->email()->nullable(),
                                    TextInput::make('contact_person_phone')
                                    ->columnSpan(3)
                                    ->label('Contact Person Phone')->nullable(),
//                            --
                            TextInput::make('contact_person_alt_phone')
                                    ->columnSpan(3)
                                    ->label('Contact Person Alt Phone')->nullable(),
                        ]
                )->columns(6);
    }

    public static function form(Form $form): Form
    {
        return $form
                        ->schema([
                            self::sponsorForm()
        ]);
    }

    public static function table(Table $table): Table
    {
        $admins_only = auth()->user()->can('update');

        $query = SponsorProfile::query()->with(['user'])
                ->whereHas('user', function ($q) {
            $q->role('sponsor');
        });

        return $table
                        ->headerActions([
                            Tables\Actions\Action::make('Export')
                            ->hidden(!auth()->user()->hasRole(['admin', 'super_admin']))
                            ->action(function () {
                                return Excel::download(new SponsorProfiles(), 'sponsor_pfiles.csv');
                            })
                        ])
                        ->query($query)
                        ->columns([
                            Tables\Columns\TextColumn::make('organization_name')->searchable(),
                            Tables\Columns\TextColumn::make('user.name')->searchable()->label('User Name'),
                            Tables\Columns\TextColumn::make('user.email')->label('User Email'),
                            Tables\Columns\TextColumn::make('contact_person_name'),
                            Tables\Columns\TextColumn::make('contact_person_email'),
                            Tables\Columns\TextColumn::make('contact_person_phone')
                        ])
                        ->filters([
                                //
                        ])
                        ->actions([
                            Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListSponsors::route('/'),
            'create' => Pages\CreateSponsor::route('/create'),
            'edit' => Pages\EditSponsor::route('/{record}/edit'),
        ];
    }

    public static function shouldRegisterNavigation(): bool
    {
        if (auth()->user()->hasRole('creator|sponsor')) {
            return false;
        }
        return true;
    }
}
