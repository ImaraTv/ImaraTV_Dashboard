<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\{
    Filament\Resources\UserResource,
    Mail\UserApprovalEmail,
    Models\User};
use Filament\{
    Actions,
    Resources\Pages\EditRecord,
    Resources\Pages\ViewRecord};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class ViewUser extends ViewRecord
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

    protected function afterSave(): void
    {
        $user = User::whereId($this->data['id'])->first();
        if ($user) {
            $user->syncRoles([$this->data['role'], 'panel_user']);
        }
    }
}
