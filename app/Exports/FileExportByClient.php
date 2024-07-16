<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class FileExportByClient implements FromCollection, WithHeadings
{
    protected $files;

    public function __construct(Collection $files)
    {
        $this->files = $files;
    }

    public function collection()
    {
        $exportData = [];

        foreach ($this->files as $code => $fileGroup) {
            foreach ($fileGroup as $file) {
                // Adjust this according to your file export structure
                $exportData[] = [
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
                    // Add more fields as needed
                ];
            }
        }

        return collect($exportData);
    }
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
