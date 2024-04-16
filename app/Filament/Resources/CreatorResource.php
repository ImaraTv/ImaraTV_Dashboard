<?php

namespace App\Filament\Resources;

use App\{
    Exports\CreatorProfiles,
    Filament\Resources\CreatorResource\Pages,
    Models\CreatorProfile,
    Models\Location
};
use Filament\{
    Forms\Components\Card,
    Forms\Components\DatePicker,
    Forms\Components\Select,
    Forms\Components\SpatieMediaLibraryFileUpload,
    Forms\Components\TagsInput,
    Forms\Components\Textarea,
    Forms\Components\TextInput,
    Forms\Form,
    Infolists\Components\ImageEntry,
    Infolists\Components\Section,
    Infolists\Components\TextEntry,
    Resources\Resource,
    Tables,
    Tables\Table
};
use Illuminate\{
    Database\Eloquent\Model,
    Support\Carbon
};
use Maatwebsite\Excel\Facades\Excel;
use function auth;

class CreatorResource extends Resource
{

    protected static ?string $model = CreatorProfile::class;

    public static ?string $label = 'Creator Profile';

    protected static ?string $navigationIcon = 'heroicon-m-user-group';


    public static function form(Form $form): Form
    {
        return $form->schema([
                    self::creatorForm()
                ])->statePath('data');
    }

    public static function table(Table $table): Table
    {

        $is_admin = auth()->user()->hasRole('super_admin|admin');
        return $table
                ->headerActions([
                        Tables\Actions\Action::make('Export')
                        ->action(function(){
                            return Excel::download(new CreatorProfiles(), 'creator_pfiles.csv');
                        })
                ])
                        ->columns([
                            Tables\Columns\TextColumn::make('name'),
                            Tables\Columns\TextColumn::make('stage_name'),
                            Tables\Columns\TextColumn::make('email'),
                            Tables\Columns\TextColumn::make('mobile_phone')
                        ])
                        ->filters([
                                //
                        ])
                        ->actions([
                            Tables\Actions\EditAction::make(),
                            Tables\Actions\ViewAction::make('View Profile')
                            ->infolist([
                                Section::make()
                                ->schema([
                                    ImageEntry::make('profile_picture')->columnSpan(2),
                                    ImageEntry::make('profile_banner')->columnSpan(2),
                                    TextEntry::make('name')->columnSpan(2),
                                    TextEntry::make('email')->columnSpan(2),
                                    TextEntry::make('mobile_phone')
                                        ->visible($is_admin)
                                        ->columnSpan(2),
                                    TextEntry::make('stage_name')->columnSpan(2),
                                    TextEntry::make('description')->columnSpan(4),
                                    TextEntry::make('skills_and_talents')->columnSpan(2),
                                    TextEntry::make('identification_number')
                                        ->visible($is_admin)
                                        ->columnSpan(2),
                                    TextEntry::make('date_of_birth')
                                    ->label('Age (Years)')
                                    ->getStateUsing(function (Model $record) {
                                        if (!is_null($record->date_of_birth)) {
                                            $t = Carbon::parse($record->date_of_birth)->age;
                                            return $t;
                                        }
                                    })
                                    ->columnSpan(2),
                                    TextEntry::make('payment_via')
                                            ->visible($is_admin)
                                            ->columnSpan(2),
                                    TextEntry::make('payment_account_number')
                                            ->visible($is_admin)
                                            ->columnSpan(2),
                                    TextEntry::make('kra_pin')
                                            ->visible($is_admin)
                                            ->columnSpan(2),
                                    TextEntry::make('location.location_name')
                                            ->columnSpan(2)
                                ])->columns(4)
                            ])
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
            'index' => Pages\ListCreators::route('/'),
            'create' => Pages\CreateCreator::route('/create'),
            'edit' => Pages\EditCreator::route('/{record}/edit')
        ];
    }

    public static function shouldRegisterNavigation(): bool
    {
        if (auth()->user()->hasRole('creator')) {
            return false;
        }
        return true;
    }

    protected static function creatorForm()
    {
        return Card::make()->schema(
                        [
                                    SpatieMediaLibraryFileUpload::make('profile_picture')
                                    ->name('profile_picture')
                                    ->collection('profile_pictures')
                                    ->columnSpan(3),
                                    SpatieMediaLibraryFileUpload::make('profile_banner')
                                    ->name('profile_banner')
                                    ->collection('profile_banners')
                                    ->columnSpan(3),
                                    TextInput::make('name')
                                    ->columnSpan(3),
                                    TextInput::make('stage_name')
                                    ->columnSpan(3),
                                    TextInput::make('email')
                                    ->email()
                                    ->columnSpan(3),
                                    TextInput::make('mobile_phone')
                                    ->columnSpan(3),
                                    Textarea::make('description')
                                    ->rows(5)
                                    ->label('About Me')
                                    ->columnSpan(6),
                                    TagsInput::make('skills_and_talents')
                                    ->separator(',')
                                    ->name('skills_and_talents')->columnSpan(6),
                                    TextInput::make('identification_number')
                                    ->columnSpan(3),
                                    DatePicker::make('date_of_birth')
                                    ->columnSpan(3),
//                                --
                            Select::make('payment_via')
                                    ->options([
                                        'mpesa' => 'Safaricom Mpesa',
                                        'kcb' => 'KCB',
                                        'stan_chart' => 'Stan Chart',
                                    ])->columnSpan(3)
                                    ->label('Payment Via (Bank Name or Mobile Money)'),
//                                --
                            TextInput::make('payment_account_number')
                                    ->label('Payment Account Number')
                                    ->columnSpan(3),
//                                --
                            TextInput::make('kra_pin')
                                    ->name('kra_pin')
                                    ->label('KRA PIN')
                                    ->columnSpan(3),
//                                --
                            Select::make('location')
                                    ->options(Location::all()->pluck('location_name', 'id'))->columnSpan(3)
                                    ->label('Location'),
                        ]
                )->columns(6);
    }
}
