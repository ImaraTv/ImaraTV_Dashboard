<?php

namespace App\Exports;

use App\Models\CreatorProposal;
use Maatwebsite\Excel\Concerns\FromCollection;

class FilmProjectsExport implements FromCollection, \Maatwebsite\Excel\Concerns\WithMapping, \Maatwebsite\Excel\Concerns\WithHeadings
{

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return CreatorProposal::with(['user', 'genre', 'sponsor', 'proposal_status', 'creator'])->get();
    }

    public function map($proposal): array
    {
        return [
            $proposal->id,
            $proposal->working_title,
            $proposal->synopsis,
            $proposal->genre?->genre_name,
            $proposal->creator?->name,
            $proposal->creator?->stage_name,
            $proposal->sponsor?->organization_name,
            $proposal->film_budget,
            $proposal->film_length,
            $proposal->film_type,
            $proposal->production_time,
            $proposal->created_at->format('d-m-Y')
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'Title',
            'Synopsis',
            'Genre',
            'Creator Name',
            'Creator Stage Name',
            'Sponsor',
            'Budget',
            'Film Length',
            'Film Type',
            'Production Time',
            'Created At'
        ];
    }
}
