<?php

namespace App\Exports;

use App\Models\PaymentHistory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PaymentExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct($id)
    {
    	$this->id = $id; 
    }

    public function collection()
    {
        return PaymentHistory::where('job_id', $this->id)->where('user_type', 'admin')->select("*", \DB::raw('(CASE 
                        WHEN is_paid = "1" THEN "Paid"
                        WHEN is_paid = "2" THEN "On Hold"
                        WHEN is_paid = "3" THEN "Cancelled"
                        ELSE "Unpaid" 
                        END) AS payment_status'), \DB::raw('(CASE 
                        WHEN is_paid = "1" THEN "Amount"
                        ELSE "Due" 
                        END) AS payment_status_label'))->get();
    }

    public function headings() :array
    {
        return ["Job ID", "Application Id", "Candidate Name", "Candidate Email", "Payment status", "Amount"];
    }

    public function map($row): array
    {
        return [
        	@$row->job->job_id ? $row->job->job_id  : '',
            @$row->application->application_id ? $row->application->application_id  : '',
            @$row->application->name ? $row->application->name  : '',
            @$row->application->email ? $row->application->email  : '',
            $row->payment_status,
            ($row->amount) ? $row->amount  : '0',
            //@$row->job->specialist->name ? $row->job->specialist->name  : '',
            //@$row->rating_by_specialist ? $row->rating_by_specialist  : '',
            //@$row->specialist_notes ? $row->specialist_notes  : '',
            //@$row->employer_notes ? $row->employer_notes  : '',
        ];
    } 

}
