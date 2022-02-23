<?php

namespace App\Imports;

use App\Models\CurrencyConversion;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;




class CurrencyRateConversionImport implements ToModel,WithHeadingRow
{   
    use Importable;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {   
        return CurrencyConversion::updateOrCreate([
           'iso_code'        => $row['currency_code'],
        ], [
           'iso_code'        => $row['currency_code'],
           'usd_value'       => $row['conversion_value_to_usd'], 
        ]);
    }

    public function rules(): array
    {
        return [
             
             // Can also use callback validation rules
             '0' => function($attribute, $value, $onFailure) {
                  
                    dd('hi');
              }
        ];
    }
}
