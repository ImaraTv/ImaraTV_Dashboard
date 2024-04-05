<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\{
    Filament\Resources\UserResource,
    Models\User
};
use Filament\{
    Actions,
    Resources\Pages\EditRecord
};
use Illuminate\Database\Eloquent\Model;

class EditUser extends EditRecord
{

    protected static string $resource = UserResource::class;

    public ?array $data = [];


    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {

        $record->update($data);

        return $record;
    }

    protected function afterSave()
    {
        $user = User::whereId($this->data['id'])->first();
        if ($user) {
            $user->syncRoles([$this->data['role'], 'panel_user']);
        }
    }
}
