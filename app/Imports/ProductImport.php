<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Group;
use App\Models\SubGroup;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Throwable;
use Log;

class ProductImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        try {
            // Fetch the group and sub-group titles based on IDs
            $groupTitle = Group::find($row['group_id'])->title;
            $subGroupTitle = SubGroup::find($row['sub_group_id'])->title;

            return new Product([
                'department_id' => $row['department_id'],
                'group_id' => $row['group_id'],
                'group_title' => $groupTitle,
                'sub_group_id' => $row['sub_group_id'],
                'sub_group_title' => $subGroupTitle,
                'si_upc' => $row['si_upc'],
                'barcode_sku' => $row['barcode_sku'],
                'department_title' => $row['department_title'],
                'product_name' => $row['product_name'],
                'product_description' => $row['product_description'],
                'packsize' => $row['packsize'],
                'unit_price' => $row['unit_price'],
                'case_price' => $row['case_price'],
                'rsp' => $row['rsp'],
                'vat' => $row['vat'],
                'por' => $row['por'],
                'bcqty_1' => $row['bcqty_1'],
                'bcp_1' => $row['bcp_1'],
                'por_1' => $row['por_1'],
                'bcqty_2' => $row['bcqty_2'],
                'bcp_2' => $row['bcp_2'],
                'por_2' => $row['por_2'],
                'bcqty_3' => $row['bcqty_3'],
                'bcp_3' => $row['bcp_3'],
                'por_3' => $row['por_3'],
            ]);
        } catch (Throwable $e) {
            // Log any errors that occur during import
            Log::error('Error importing product: ' . $e->getMessage());
            // Log the row data for debugging
            Log::debug('Row Data: ', $row);
        }

        return null;
    }
}
