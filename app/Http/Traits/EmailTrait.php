<?php

namespace App\Http\Traits;

use App\Models\EmailTemplate;

use Mail;


Trait EmailTrait
{
	public function sendEmail($templateName,$data)
	{	
		$email_template = EmailTemplate::where('name', $templateName)->first();
		$replacement = $data['replacement'];

		$replacement['FACEBOOK_LINK'] = 'https://www.facebook.com';

		$replacement['LINKEDIN_LINK'] = 'https://www.linkedin.com';

		$replacement['TWITTER_LINK'] = 'http://twitter.com';


		if($email_template)
		{
			$content = $email_template->content;
	        $data['subject'] = $email_template->subject;

	        if(count($replacement) > 0)
	        {
	            foreach ($replacement as $key => $value)
	            {
	                $content = str_replace('{{'.$key.'}}', $value, $content);
	            }
	            $year1 = date('Y');
	            $year2 = date('Y');
	            $year2 = $year2+1;
	            $content = str_replace('{{FROM_TO_DATE}}', $year1.'-'.$year2, $content);
	        }

	        Mail::send('webApp.partials.email_template', ['content' => $content], function ($message) use ($data) {

				$from_email = 'no-reply@thesst.com';
				$from_name = 'Careefer';

	            $message->from($from_email,$from_name);
	            $message->subject($data['subject']);
	            $message->to($data['to']);
	        });	
		}
	}
}
