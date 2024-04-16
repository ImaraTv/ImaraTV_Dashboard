<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\{
    FromCollection,
    WithHeadings,
    WithMapping
};
use function collect;

class Users implements FromCollection, WithHeadings, WithMapping
{

    /**
     * @return Collection
     */
    public function collection()
    {
        return User::with(['roles'])->get();
    }

    public function headings(): array
    {
        return [
            'Name','Email','Role','Created At'
        ];
    }

    public function map($row): array
    {
        
        return [
            $row->name,
            $row->email,
            collect($row->roles)->whereNotIn('name',['panel_user'])->first()?->name,
            $row->created_at->format('d-m-Y')
        ];
    }
}
