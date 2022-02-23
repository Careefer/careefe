<h2 style= "text-align: left">Hello {{ $maildata['RECEIVER_NAME'] }}</h2>
<p>{{ $maildata['SENDER_NAME'] }} reffred you this job. click on the below link to check.
<br><br><br>
<a href="{{$maildata['JOB_URL']}}">{{$maildata['JOB_URL']}} </a>
</p>
<br>
                  
<h4 style="font-size:12px">Regards,<br>
Carefeer<h4>
