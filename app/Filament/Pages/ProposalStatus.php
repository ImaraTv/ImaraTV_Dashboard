<?php

namespace App\Filament\Pages;

use App\Models\ProposalStatus as Status;
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

class ProposalStatus extends Page implements HasTable
{

    use InteractsWithTable,
        HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-c-check';

    protected static string $view = 'filament.pages.proposal-status';


    protected function getHeaderActions(): array
    {
        return [
                    CreateAction::make()
                    ->form([
                        TextInput::make('status')
                        ->label('Proposal Status')
                        ->name('status')
                        ->required()
                        ->maxLength(255),
                    ])
                    ->using(function (array $data): Status {
                        return Status::create($data);
                    })
        ];
    }

    protected static function table(Table $table): Table
    {

        return $table
                        ->query(Status::query())
                        ->columns([
                            TextColumn::make('status')
                            ->name('status'),
                            TextColumn::make('created_at')
                            ->date()
                        ])
                        ->filters([
                                //
                        ])
                        ->actions([
                            EditAction::make()
                            ->form([
                                TextInput::make('status')
                                ->label('Proposal Status')
                                ->name('status')
                                ->maxLength(255)
                            ])
                            ->using(function (Status $record, array $data): Status {
                                $record->update($data);

                                return $record;
                            }),
                            DeleteAction::make(),
                        ])
                        ->bulkActions([
                            BulkActionGroup::make([
                                DeleteBulkAction::make(),
                            ]),
        ]);
    }
}
