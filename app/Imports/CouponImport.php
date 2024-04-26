<?php

namespace App\Imports;

use App\Models\CouponImportLog;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpParser\Node\Expr\Array_;

class CouponImport implements ToModel
{
    /**
    * @param Collection $collection
    */
    public function collection(array $row)
    {
        return new CouponImportLog([
            'coupon_code' => $row['coupon_code'],
            'detail' => $row['detail'],
            'status' => $row['status'],
            // Add more columns as needed
        ]);
    }

    public function model(array $row)
    {
        // TODO: Implement model() method.
    }
}
