<?php

namespace App\Filament\Resources;

use App\{
    Filament\Resources\UserResource\Pages,
    Models\User
};
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\{
    Forms,
    Forms\Form,
    Resources\Pages\CreateRecord,
    Resources\Pages\Page,
    Resources\Resource,
    Tables,
    Tables\Table
};
use Illuminate\{
    Database\Eloquent\Model,
    Support\Facades\Hash
};
use Spatie\Permission\Models\Role;
use function auth;
use function collect;
use function filled;

class UserResource extends Resource implements HasShieldPermissions
{

    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-m-user';

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

    public static function form(Form $form): Form
    {
        $roles = collect(Role::whereNotIn('name', ['panel_user', 'super_admin'])->get())->pluck('name', 'name');
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
                                ->options($roles)
                            ])
                        ])->statePath('data');
    }

    public static function table(Table $table): Table
    {
        $query = User::withoutRole(['super_admin']);
        
        return $table
                        ->query($query)
                        ->columns([
                            Tables\Columns\TextColumn::make('id')->sortable(),
                            Tables\Columns\TextColumn::make('name')->searchable(),
                            Tables\Columns\TextColumn::make('email')->sortable()->searchable(),
                            Tables\Columns\TextColumn::make('role')->getStateUsing(function(Model $record){
                                return collect($record->roles)->filter(fn($i)=>$i->name!='panel_user')->first()?->name;
                            }),
                            Tables\Columns\TextColumn::make('created_at')->dateTime()
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
