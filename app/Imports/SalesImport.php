<?php

namespace App\Imports;

use App\SalesReposition;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class SalesImport implements ToModel, WithChunkReading, ShouldQueue, WithBatchInserts
{
    /**
     * @param array $row
     *
     * @return \App\User|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Model[]|null
     */
    public function model(array $row)
    {
        if($row[10] != 'UNID.SALI.')
        {
            return New SalesReposition([
                'almacen' => $row[1],
                'cantidad' => $row[10],
                'aecoc' => $row[23]
            ]);
        }

    }

    public function chunkSize(): int
    {
        return 100;
    }

    public function batchSize(): int
    {
        return 100;
    }
}
