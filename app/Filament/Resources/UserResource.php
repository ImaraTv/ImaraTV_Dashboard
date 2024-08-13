<?php

namespace App\Filament\Resources;

use App\{Exports\Users, Filament\Resources\UserResource\Pages, Mail\UserApprovalEmail, Models\User};
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\{
    Forms,
    Forms\Components\DatePicker,
    Forms\Form,
    Resources\Pages\CreateRecord,
    Resources\Pages\Page,
    Resources\Resource,
    Tables,
    Tables\Enums\FiltersLayout,
    Tables\Filters\Filter,
    Tables\Table
};
use Illuminate\{Database\Eloquent\Builder, Database\Eloquent\Model, Support\Facades\Hash, Support\Facades\Mail};
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;
use function auth;
use function collect;
use function filled;

class UserResource extends Resource implements HasShieldPermissions
{

    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-m-user';

    public ?array $data = [];

    protected static ?int $navigationSort = 4;


    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'delete_any',
            'publish',
            'view_locations',
            'create_location',
            'update_location',
            'delete_location',
            'view_genres',
            'create_genres',
            'update_genres',
            'delete_genres',
            'view_topics',
            'update_topics',
            'delete_topics',
            'create_topics',
            'view_statuses',
            'delete_statuses',
            'create_statuses',
            'update_statuses',
        ];
    }

    #[\Override]
    public static function canAccess(): bool
    {
        return boolval(auth()->user()->approved);
    }

    public static function form(Form $form): Form
    {
        $roles = collect(Role::whereNotIn('name', ['panel_user'])->get())->pluck('name', 'name');
        return $form
                        ->schema([
                            Forms\Components\Card::make()->schema([
                                Forms\Components\TextInput::make('name')
                                ->label('Name')
                                ->maxLength(255)
                                ->required(),
                                Forms\Components\TextInput::make('email')
                                ->label('Email Address')
                                ->email()
                                ->required(),
                                Forms\Components\TextInput::make('password')
                                ->password()
                                ->same('passwordConfirmation')
                                ->required(fn(Page $livewire): bool => $livewire instanceof CreateRecord)
                                ->dehydrated(fn($state) => filled($state))
                                ->dehydrateStateUsing(fn($state) => Hash::make($state))
                                ->minLength(3),
                                Forms\Components\TextInput::make('passwordConfirmation')
                                ->password()
                                ->required(fn(Page $livewire): bool => $livewire instanceof CreateRecord)
                                ->label('Confirm Password')
                                ->dehydrated(false)
                                ->minLength(6),
                                Forms\Components\Select::make('role')
                                ->formatStateUsing(function (?Model $record) {
                                    if ($record) {
                                        $user = User::with(['roles'])->whereId($record->id)->first();
                                        $role = collect($user->roles)->filter(fn($i) => $i != 'panel_user')->last();
                                        if (isset($role)) {

                                            return $role->name;
                                        }
                                    }

                                    return 'user';
                                })
                                ->options($roles)
                            ])
                        ])->statePath('data');
    }

    public static function table(Table $table): Table
    {
        $query = User::with('roles');

        return $table
                        ->headerActions([
                            Tables\Actions\Action::make('Export')
                            ->hidden(!auth()->user()->hasRole(['admin', 'super_admin']))
                            ->action(function () {
                                return Excel::download(new Users(), 'users.csv');
                            })
                        ])
                        ->query($query)
                        ->columns([
                            Tables\Columns\TextColumn::make('id')->sortable(),
                            Tables\Columns\TextColumn::make('name')->searchable(),
                            Tables\Columns\TextColumn::make('email')->sortable()->searchable(),
                            Tables\Columns\TextColumn::make('role')->getStateUsing(function (Model $record) {
                                return collect($record->roles)->filter(fn($i) => $i->name != 'panel_user')->first()?->name;
                            }),
                            Tables\Columns\TextColumn::make('created_at')->dateTime(),
                            Tables\Columns\ToggleColumn::make('approved')
                                ->label('Approve')
                                ->afterStateUpdated(function (Model $record) {
                                    if ($record->approved) {
                                        Mail::to($record)->send(new UserApprovalEmail($record));
                                    }
                                }),
                        ])
                        ->filters([
                            Tables\Filters\SelectFilter::make('role')
                            ->query(function (Builder $query, $data) {
                                $data = collect($data)->filter(fn($i) => !is_null($i))->toArray();

                                if (!empty($data)) {
                                    return $query->whereHas('roles', fn($q) => $q->where('id', $data));
                                }
                                return $query;
                            })
                            ->options(collect(Role::whereNotIn('name', ['panel_user'])->get())->pluck('name', 'id'))
                            ->searchable()
                            ->preload(),
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
                                ], layout: FiltersLayout::AboveContent)
                        ->filtersFormColumns(3)
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
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
