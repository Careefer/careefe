<?php

namespace App\Imports;

use App\Models\PaymentHistory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class PaymentHistoryImport implements ToModel,WithHeadingRow,WithChunkReading
{   
    use Importable;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {   
        $flag='';

        if(!empty($row['payment_id']) && !empty($row['payment_status']))
        {
            switch ($row['payment_status'])
            {
                case 'Paid':
                    $flag= 1;   
                    break;

                case 'Unpaid':
                    $flag= "0";   
                    break;

                case 'Hold':
                    $flag= 2;   
                    break;

                case 'Cancelled':
                    $flag= 3;   
                    break;
            }

            if($flag!='')
            {
                PaymentHistory::where('id', $row['payment_id'])->update(['is_paid'=>$flag, 'sent_email'=>1, 'by_csv'=>1]);
            }
        }
    }

    public function chunkSize(): int
    {
        return 250;
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
