<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
   
<center>
<h2 style="padding: 23px;background: #b3deb8a1;border-bottom: 6px green solid;">
	
</h2>
</center>
  
<div>
    <label for="title">
        <strong>Title:</strong>
    </label>
   <p>{{$newsletter->title}}</p>
</div>

<div>
    <label for="title">
        <strong>Subject:</strong>
    </label>
   <p>{{$newsletter->subject}}</p>
</div>

<div>
    <label for="title">
        <strong>Content:</strong>
    </label>
  <p>@php echo html_entity_decode($newsletter->content); @endphp</p>
</div>

<img src="{{ $message->embed(public_path().'/storage/newsletters/'.$newsletter->attachments) }}" alt="" />
  				
</body>
</html>