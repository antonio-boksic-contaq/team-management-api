<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
// aggiunto io
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::all();
    }

    public function headings(): array
    {
        return [
          'id','name', "lastname", "email", "gender", "team_id", // 'created_at','updated_at'
        ];
    }

    Public function map($row): array {
        return [
            $row->id,
            $row->name,
            $row->lastname,
            $row->email,
            $row->gender,
            $row->team_id
        ];
    }
}