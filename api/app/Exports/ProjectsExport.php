<?php

namespace App\Exports;

use App\Http\Resources\ProjectResource;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProjectsExport implements FromCollection, WithHeadings, WithMapping
{

    private $data;
    private $trashed;

    public function __construct($data, $trashed) 
    {
        $this->data = $data;
        $this->trashed = $trashed;
    }

    public function headings(): array
    {
        $heading = [
            '#',
            'Nome',
            'Descrizione',
            'Note',
            'Priorità',
            'Stato avanzamento',
            'Deadline',
            'Stato',
            'Categoria',
            //'Committenti',
        ];
        if ($this->trashed) array_push($heading, 'Data eliminazione');
        return $heading;
    }

    public function map($project) : array {

        $map = [
            $project->id,
            $project->name,
            $project->description,
            $project->notes,
            $project->projectPriority->name,
            $project->progress,
            $project->deadline_date,
            $project->projectStatus->name,
            $project->projectCategory->name,
            //$project->projectApplicant->name
        ];
        if ($this->trashed) array_push($map, $project->deleted_at);
        return $map; 
    }


    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ProjectResource::collection($this->data);
    }
}