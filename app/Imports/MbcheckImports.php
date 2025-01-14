<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\MbcheckProdlist;
use App\Models\Mbcheck;

class MbcheckImports implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        //
        return Mbcheck::all();

    }
}
