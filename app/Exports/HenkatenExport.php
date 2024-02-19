<?php

namespace App\Exports;

use App\Models\Henkaten;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class HenkatenExport implements FromCollection, WithCustomStartCell, WithEvents
{
    private $startCell = 'A18';
    private $templatePath;
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct()
    {
        $this->templatePath = Storage::path('public/henkaten_template.xlsx');
    }
    
    public function collection()
    {
        return Henkaten::all();
    }

    public function startCell(): string
    {
        return $this->startCell;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Load the template
                $event->sheet->import($this->templatePath);

                // Get the data to populate into the template
                $henkatens = $this->collection();
                
                $row = 18; // Assuming your data starts from row 2
                foreach ($henkatens as $henkaten){
                    $event->sheet->setCellValue('A' . $row, $henkaten->abnormality);
                    $event->sheet->setCellValue('B' . $row, $henkaten->category);
                    $row++;
                }
            },
        ];
    }
}
