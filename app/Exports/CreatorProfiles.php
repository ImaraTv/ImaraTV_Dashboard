<?php

namespace App\Exports;

use App\Models\CreatorProfile;
use Illuminate\Support\{
    Carbon,
    Collection
};
use Maatwebsite\Excel\Concerns\{
    FromCollection,
    WithHeadings,
    WithMapping
};

class CreatorProfiles implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return Collection
    */
    public function collection()
    {
        return CreatorProfile::with(['user','loc'])->get();
    }
    public function map($row): array
    {
        return [
            $row->name,
            $row->stage_name,
            $row->email,
            $row->mobile_phone,
            $row->description,
            $row->skills_and_talents,
            $row->identification_number,
            Carbon::parse($row->date_of_birth)->age,
            $row->loc?->location_name
        ];
    }
    public function headings(): array
    {
       return [
           'Name','Stage Name','Email','Mobile Phone','About','Skills','ID','Age','Location'
       ];
    }
}
