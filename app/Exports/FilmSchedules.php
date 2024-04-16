<?php

namespace App\Exports;

use App\Models\PublishingSchedule;
use Illuminate\Support\{
    Carbon,
    Collection
};
use Maatwebsite\Excel\Concerns\{
    FromCollection,
    WithHeadings,
    WithMapping
};

class FilmSchedules implements FromCollection, WithMapping, WithHeadings
{

    /**
     * @return Collection
     */
    public function collection()
    {
        return PublishingSchedule::with([
                    'sponsor', 'creator', 'genre', 'proposal'
                ])->get();
    }

    public function map($s): array
    {

        return [
            $s->film_title,
            $s->topics,
            $s->synopsis,
            $s->film_type,
            $s->creator?->name,
            $s->creator?->stage_name,
            $s->sponsor?->organization_name,
            $s->created_at->format('d-m-Y'),
            Carbon::parse($s->release_date)->format('d-m-Y')
        ];
    }

    public function headings(): array
    {
        return [
            'Title', 'Topics', 'Synopsis', 'Film Type', 'Creator Name', 'Creator Stage Name',
            'Sponsor', 'Created On', 'Release Date'
        ];
    }
}
