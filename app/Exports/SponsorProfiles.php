<?php

namespace App\Exports;

use App\Models\SponsorProfile;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\{
    FromCollection,
    WithHeadings,
    WithMapping
};

class SponsorProfiles implements FromCollection, WithHeadings, WithMapping
{

    /**
     * @return Collection
     */
    public function collection()
    {
        return SponsorProfile::with(['user'])->get();
    }

    public function headings(): array
    {
        return [
            'Name','About','Website','Location of Interest','Contact Person',
            'Contact Email','Contact Phone',''
        ];
    }

    public function map($row): array
    {
        return [
            $row->organization_name,
            $row->about_us,
            $row->organization_website,
            $row->locations_of_interest,
            $row->contact_person_name,
            $row->contact_person_email,
            $row->contact_person_phone
        ];
    }
}
