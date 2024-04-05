<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\{
    Filament\Resources\UserResource,
    Models\User
};
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{

    protected static string $resource = UserResource::class;

    public ?array $data = [];


    protected function afterCreate()
    {
        $user = User::whereId($this->record->id)->first();
        if ($user) {
            $user->syncRoles([$this->data['role'], 'panel_user']);
        }
    }
}
