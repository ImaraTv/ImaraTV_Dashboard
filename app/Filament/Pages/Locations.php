<?php

namespace App\Filament\Pages;

use App\Models\Location as Loc;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\{
    Forms\Components\TextInput,
    Pages\Actions\CreateAction,
    Pages\Page,
    Tables\Actions\BulkActionGroup,
    Tables\Actions\DeleteAction,
    Tables\Actions\DeleteBulkAction,
    Tables\Actions\EditAction,
    Tables\Columns\TextColumn,
    Tables\Concerns\InteractsWithTable,
    Tables\Contracts\HasTable,
    Tables\Table
};

class Locations extends Page implements HasTable
{

    use InteractsWithTable,
        HasPageShield;

//    protected static ?string $navigationIcon = 'heroicon-m-map-pin';

    protected static string $view = 'filament.pages.locations';

    protected static ?string $navigationGroup = 'Settings';


    #[\Override]
    public static function canAccess(): bool
    {
        return boolval(auth()->user()->hasRole('admin|super_admin'));
    }

    protected function getHeaderActions(): array
    {
        $can_add_location = auth()->user()->can('create_location_user');

        return [
                    CreateAction::make()
                    ->visible($can_add_location)
                    ->form([
                        TextInput::make('location_name')
                        ->label('Location Name')
                        ->name('location')
                        ->required()
                        ->maxLength(255),
                    ])
                    ->using(function (array $data): Loc {
                        return Loc::create($data);
                    })
        ];
    }

    protected static function table(Table $table): Table
    {
        $can_view_locations = auth()->user()->can('view_locations_user');
        $can_update_location = auth()->user()->can('update_location_user');
        $can_delete_location = auth()->user()->can('delete_location_user');
        if ($can_view_locations) {
            return $table
                            ->query(Loc::query())
                            ->columns([
                                TextColumn::make('location_name')
                                ->name('location_name'),
                                TextColumn::make('created_at')
                                ->date()
                            ])
                            ->filters([
                                    //
                            ])
                            ->actions([
                                EditAction::make()
                                ->visible($can_update_location)
                                ->form([
                                    TextInput::make('location_name')
                                    ->label('Location')
                                    ->name('location_name')
                                    ->maxLength(255)
                                ])
                                ->using(function (Loc $record, array $data): Loc {
                                    $record->update($data);

                                    return $record;
                                }),
                                DeleteAction::make()->visible($can_delete_location),
                            ])
                            ->bulkActions([
                                BulkActionGroup::make([
                                    DeleteBulkAction::make(),
                                ]),
                            ]);
        }
    }
}
