<?php

namespace App\Exports;

use App\Models\Henkaten;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class HenkatenExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $originId;
    protected $startDate;
    protected $endDate;

    public function __construct($originId = null, $startDate = null, $endDate = null)
    {
        $this->originId = $originId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        return Henkaten::with(['line.origin', 'approval', 'henkatenManagement', 'troubleshoot'])
            ->when($this->originId, function ($q) {
                $q->whereHas('line', function ($query) {
                    $query->where('origin_id', $this->originId);
                });
            })
            ->when($this->startDate && $this->endDate, function ($q) {
                $q->whereBetween('date', [$this->startDate, $this->endDate]);
            })
            ->get();
    }

    public function headings(): array
    {
        return [
            'Henkaten Time',
            'Type',
            'Line',
            'Abnormality',
            'Category',
            'Table No',
            'Troubleshoot',
            'Troubleshoot Time',
            'Status',
            'Result Check',
            'Report Abnormality',
            'Part',
            'Before',
            'After',
            'Done By',
            'Leader Approval',
            'Supervisor Approval',
            'Manager Approval',
        ];
    }

    public function map($h): array
    {
        $ts = $h->troubleshoot;

        return [
            optional($h)->created_at ? $h->created_at->format('Y-m-d H:i:s') : null,
            strtoupper($h->{'4M'}),
            optional($h->line)->name,
            $h->abnormality,
            $h->category,
            optional($h->henkatenManagement)->table_no,
            optional($ts)->troubleshoot,
            optional($ts)->created_at ? $ts->created_at->format('Y-m-d H:i:s') : null,
            $h->approval?->ldr ? 'Solved' : 'Waiting Troubleshoot',
            $ts?->result_check,
            $ts?->inspection_report,
            $ts?->part,
            $ts?->before_treatment,
            $ts?->after_treatment,
            optional($ts?->employee)->name ?? $ts?->done_by,
            $h->approval?->ldr,
            $h->approval?->spv,
            $h->approval?->mgr,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $rowCount = $this->collection()->count() + 1; // +1 untuk heading
        $columnCount = count($this->headings());

        $lastCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($columnCount);
        $cellRange = "A1:{$lastCol}{$rowCount}";

        $sheet->getStyle($cellRange)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        return [];
    }
}   