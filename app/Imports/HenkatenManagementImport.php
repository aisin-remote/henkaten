<?php

namespace App\Imports;

use App\Models\HenkatenManagement;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class HenkatenManagementImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        try {
            DB::beginTransaction();

            foreach ($rows as $row) {
                HenkatenManagement::updateOrCreate(
                    [
                        'table_no' => $row['table_no'], // Matching criteria
                        '4M' => $row['type'],            // Matching criteria
                    ],
                    [
                        'henkaten_item' => $row['henkaten_item'], // Fields to update
                    ]
                );
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            dd($th);
        }
        
    }
}
