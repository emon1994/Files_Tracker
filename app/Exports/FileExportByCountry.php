<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\File;

class FileExportByCountry implements FromCollection, WithHeadings
{
    protected $country;

    public function __construct($country)
    {
        $this->country = $country;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $files = File::where('country', $this->country)
            ->with(['fileDetails', 'client'])
            ->get();

        // Transform the data into the desired format with selected fields only
        return $files->map(function ($file) {
            return [
                'ID' => $file->id,
                'Code' => $file->code,
                'Partner' => $file->client->name ?? '',
                'Country' => $file->country,
                'Note' => $file->note,
                'Receiver' => $file->receiver,
                'Status' => $file->status,
                // 'Status' => $file->status, // Comment out or remove any fields you don't want to include
                'Files' => $file->fileDetails->map(function ($detail) {
                    return $detail->filename;
                })->implode(', '),
            ];
        });
    }


    /**
     * Return the headings for the export file.
     * 
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Code',
            'Partner',
            'Country',
            'Note',
            'Receiver',
            'Status',
            'Files',
            // 'Created At',
            // 'Updated At',
            // Add other headings based on your File model attributes
        ];
    }
}
