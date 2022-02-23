<?php
	
	defined('SERVER_ERR_MSG') OR define('SERVER_ERR_MSG','Unexpected error occurred while trying to process your request. Please report to admin as soon as you can.');

    defined('SOMETHING_WENT_WRONG') OR define('SOMETHING_WENT_WRONG','Error something went wrong');

    defined('FORM_ERROR_MSG') OR define('FORM_ERROR_MSG','Please check form and fill valid data.');


    defined('SUPER_ADMIN_ID') OR define('SUPER_ADMIN_ID',1);
    defined('SUPER_ADMIN_ROLE_ID') OR define('SUPER_ADMIN_ROLE_ID',1);
 
    defined('JOB_STATUS') OR define('JOB_STATUS',['active'=>'Active', 'on_hold'=>'On Hold', 'closed'=>'Closed', 'cancelled'=>'Cancelled','pending'=>'Pending', 'rejected'=>'Reject']);

    define('APPLICATION_STATUS', ['applied'=>'Applied', 'in_progress' => 'In Progress with Specialist', 'in_progress_with_employer'=>'In Progress with Employer' ,'unsuccess'=>'Unsuccessfull','success'=>'Successfull','candidate_declined'=>'Candidate declined','hired'=>'Hired','cancelled'=>'Cancelled']);

    define('GMT_DATE_TIME', gmdate("Y-m-d H:i:s"));
?>