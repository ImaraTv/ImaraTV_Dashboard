<?php

namespace App\Filament\Resources;

use App\{
    Filament\Resources\CreatorResource\Pages,
    Models\CreatorProfile
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
    Resources\Resource,
    Tables,
    Tables\Table
};
use function auth;

class CreatorResource extends Resource
{

    protected static ?string $model = CreatorProfile::class;

    public static ?string $label = 'creatorProfile';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


    public static function form(Form $form): Form
    {
        return $form->schema([
                    self::creatorForm()
        ])->statePath('data');
    }

    public static function table(Table $table): Table
    {
        return $table
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
                                    SpatieMediaLibraryFileUpload::make('attachments')
                                    ->name('profile_picture')
                                    ->label('Profile Picture')
                                    ->collection('creator_profile')
                                    ->columnSpan(2),
                                    SpatieMediaLibraryFileUpload::make('profile_banner')
                                    ->collection('creator_profile')
                                    ->columnSpan(4),
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
                                    ->options([
                                        'kajiado' => 'Kajiado',
                                        'nairobi' => 'Nairobi',
                                        'nakuru' => 'Nakuru',
                                    ])->columnSpan(3)
                                    ->label('Location'),
                        ]
                )->columns(6);
    }
}
