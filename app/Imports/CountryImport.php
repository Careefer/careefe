<?php

namespace App\Imports;

use App\Models\Country;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;




class CountryImport implements ToModel,WithHeadingRow
{   
    use Importable;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {   
        return new Country([
           'name'        => $row['country'],
           'timezone_id' => $row['timezone_id'], 
           'status'      => $row['status'], 
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
