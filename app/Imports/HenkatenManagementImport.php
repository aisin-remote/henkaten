<?php

namespace App\Imports;

use App\Models\HenkatenManagement;
use Maatwebsite\Excel\Concerns\ToModel;

class HenkatenManagementImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new HenkatenManagement([
            //
        ]);
    }
}
