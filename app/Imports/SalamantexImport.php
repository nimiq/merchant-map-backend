<?php

namespace App\Imports;

use App\Models\Shop;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class SalamantexImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (is_null($row['column1companyname'])) {
            return;
        }

        $shop = Shop::where([
            'source_id' => 'salamantex',
            'object_id' => $row['column1partnernumber']
        ])->first();

        $data = [
            'label' => $row['column1companyname'],
            'email' => $row['column1companymail'],
            'description' => '',
            'street' => $row['column1addressinfoaddresslines'],
            'zip' => $row['column1addressinfozipcode'],
            'city' => $row['column1addressinfocity'],
            'country' => $row['column1addressinfocountry']
        ];

        if (is_null($shop)) {
            $shop = new Shop($data);
            $shop->user_id = auth()->user()->id;
            $shop->object_id = $row['column1partnernumber'];
            $shop->source_id = 'salamantex';
            $shop->save();
        } else {
            $shop->update($data);
        }
    }
}
