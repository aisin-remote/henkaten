<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Henkaten;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
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
        $this->templatePath = public_path('template/henkaten_template.xlsx');
    }
    
    public function collection()
    {
        return Henkaten::with(['line','henkatenManagement','troubleshoot.employee'])->get();
    }

    public function startCell(): string
    {
        return $this->startCell;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Load the template file
                $spreadsheet = IOFactory::load($this->templatePath);
                $sheet = $spreadsheet->getActiveSheet();

                // Get the data to populate into the template
                $henkatens = $this->collection();
                
                $row = 18; // Assuming your data starts from row 2
                foreach ($henkatens as $henkaten){
                    $sheet->setCellValue('A' . $row, Carbon::parse($henkaten->date)->format('m/d'));
                    $sheet->setCellValue('B' . $row, $henkaten->line->name);
                    $sheet->setCellValue('C' . $row, Carbon::parse($henkaten->date)->format('H:i'));

                    $sheet->mergeCells('D' . $row . ':H' . $row);
                    $sheet->setCellValue('D' . $row, $henkaten->abnormality);

                    // Group columns
                    $sheet->getColumnDimension('D')->setOutlineLevel(1)->setVisible(true)->setCollapsed(false);
                    $sheet->getColumnDimension('E')->setOutlineLevel(1)->setVisible(true)->setCollapsed(false);
                    $sheet->getColumnDimension('F')->setOutlineLevel(1)->setVisible(true)->setCollapsed(false);
                    $sheet->getColumnDimension('G')->setOutlineLevel(1)->setVisible(true)->setCollapsed(false);
                    $sheet->getColumnDimension('H')->setOutlineLevel(1)->setVisible(true)->setCollapsed(false);
                    
                    $sheet->setCellValue('I' . $row, $henkaten->category);
                    $sheet->setCellValue('J' . $row, $henkaten->henkatenManagement->table_no);
                    
                    $sheet->mergeCells('K' . $row . ':P' . $row);
                    $sheet->setCellValue('K' . $row, $henkaten->troubleshoot->troubleshoot);

                    // Group columns
                    $sheet->getColumnDimension('K')->setOutlineLevel(1)->setVisible(true)->setCollapsed(false);
                    $sheet->getColumnDimension('L')->setOutlineLevel(1)->setVisible(true)->setCollapsed(false);
                    $sheet->getColumnDimension('M')->setOutlineLevel(1)->setVisible(true)->setCollapsed(false);
                    $sheet->getColumnDimension('N')->setOutlineLevel(1)->setVisible(true)->setCollapsed(false);
                    $sheet->getColumnDimension('O')->setOutlineLevel(1)->setVisible(true)->setCollapsed(false);
                    $sheet->getColumnDimension('P')->setOutlineLevel(1)->setVisible(true)->setCollapsed(false);
                    
                    $sheet->setCellValue('Q' . $row, $henkaten->troubleshoot->result_check);
                    
                    $sheet->mergeCells('R' . $row . ':S' . $row);
                    $sheet->setCellValue('R' . $row, $henkaten->troubleshoot->inspection_report);
                    
                    // Group columns
                    $sheet->getColumnDimension('R')->setOutlineLevel(1)->setVisible(true)->setCollapsed(false);
                    $sheet->getColumnDimension('S')->setOutlineLevel(1)->setVisible(true)->setCollapsed(false);
                    
                    $sheet->mergeCells('T' . $row . ':W' . $row);
                    $sheet->setCellValue('T' . $row, $henkaten->troubleshoot->part);
                    
                    // Group columns
                    $sheet->getColumnDimension('T')->setOutlineLevel(1)->setVisible(true)->setCollapsed(false);
                    $sheet->getColumnDimension('U')->setOutlineLevel(1)->setVisible(true)->setCollapsed(false);
                    $sheet->getColumnDimension('V')->setOutlineLevel(1)->setVisible(true)->setCollapsed(false);
                    $sheet->getColumnDimension('W')->setOutlineLevel(1)->setVisible(true)->setCollapsed(false);
                    
                    $sheet->setCellValue('X' . $row, $henkaten->troubleshoot->before_treatment);
                    $sheet->setCellValue('Y' . $row, $henkaten->troubleshoot->after_treatment);
                    $sheet->setCellValue('Z' . $row, $henkaten->troubleshoot->employee->name);
                    $row++;
                }

                // Write the modified template back to the Excel writer
                $event->sheet->getParent()->addExternalSheet($sheet);
            },
        ];
    }
}
