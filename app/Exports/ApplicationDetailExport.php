<?php

namespace App\Exports;

use App\Models\Job_application;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ApplicationDetailExport implements FromCollection, WithHeadings, WithMapping
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
        return Job_application::where('id', $this->id)->get();
    }


    public function headings() :array
    {
        return ["Job ID","Applicant ID", "Applicant Name", "Specialist Assigned", "Specialist Ratings", "Specialist Notes","My Notes"];
    }

    public function map($row): array
    {
        return [
        	@$row->job->job_id ? $row->job->job_id  : '',
            // @$row->candidate->candidate_id ? $row->candidate->candidate_id  : '',
            @$row->application_id ? $row->application_id  : '',
            @$row->name ? $row->name  : '',
            @$row->job->specialist->name ? $row->job->specialist->name  : '',
            @$row->rating_by_specialist ? $row->rating_by_specialist  : '',
            @$row->specialist_notes ? $row->specialist_notes  : '',
            @$row->employer_notes ? $row->employer_notes  : '',
        ];
    } 

}
