<?php

namespace App\Exports;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    use Exportable, Queueable;
    /**
     * Return json as Collection
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $json = Storage::disk('public')->get('uploads/users.json');
        $data = json_decode($json, true);

        return collect($data);
    }

    /**
     * Define headings for the exported Excel file
     * @return array
     */
    public function headings(): array
    {
        return [
            'name',
            'email',
            'phone',
            'address',
        ];
    }
}
