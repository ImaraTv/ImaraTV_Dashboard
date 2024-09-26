<?php

namespace App\Filament\Pages;

use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelAuthenticationLog\Models\AuthenticationLog as Log;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AuthLog extends Page implements HasTable
{
    use InteractsWithTable, HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-m-user-group';
    protected static string $view = 'filament.pages.auth-log';
    protected static ?string $navigationGroup = 'Statistics';

    #[\Override]
    public static function canAccess(): bool
    {
        return boolval(auth()->user()->hasRole('admin|super_admin'));
    }

    protected static function table(Table $table): Table
    {
        $can_view = boolval(auth()->user()->hasRole('admin|super_admin'));
        if ($can_view) {
            return $table
                ->query(Log::query())
                ->columns([
                    TextColumn::make('authenticatable.name')
                        ->name('authenticatable.name')
                        ->label('User'),
                    TextColumn::make('login_at')->dateTime(),
                    TextColumn::make('logout_at')->dateTime(),
                    TextColumn::make('login_successful')
                        ->formatStateUsing(function ($state) {
                            return $state === true ? 'Yes' : 'No';
                        }),
                    TextColumn::make('ip_address'),
                ])
                ->filters([
                    Filter::make('login_at')
                        ->form([
                            DatePicker::make('from')->label('Login Date From'),
                            DatePicker::make('to')->label('Login Date To'),
                        ])
                        ->columns(2)
                        ->columnSpan(2)
                        ->query(function (Builder $query, array $data): Builder {
                            return $query
                                ->when(
                                    $data['from'],
                                    fn(Builder $query, $date): Builder => $query->whereDate('login_at', '>=', $date),
                                )
                                ->when(
                                    $data['to'],
                                    fn(Builder $query, $date): Builder => $query->whereDate('login_at', '<=', $date),
                                );
                        })
                ], layout: FiltersLayout::AboveContent)->filtersFormColumns(5)
                ->actions([
                    //
                ])
                ->bulkActions([
                    //
                ]);
        }
    }
}
