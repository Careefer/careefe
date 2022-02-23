<head>
	<meta charset="utf-8">
	
    <title>@yield('title')</title>

	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
     @stack('meta')
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet" type='text/css'>

	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet" type='text/css'>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="{{asset('assets/web/css/jquery.flexdatalist.min.css')}}" rel="stylesheet" type="text/css">

    <link rel="stylesheet" type="text/css" href="{{asset('assets/web/css/jquery-ui.css')}}" media="screen">

	<link rel="stylesheet" type="text/css" href="{{asset('assets/web/css/flags.css')}}" media="screen">
    
	<link rel="stylesheet" type="text/css" href="{{asset('assets/web/css/jquery.mCustomScrollbar.css')}}" media="screen">

	<link rel="stylesheet" type="text/css" href="{{asset('assets/web/css/slick.css')}}"/>

	<link rel="stylesheet" type="text/css" href="{{asset('assets/web/css/global.css')}}" media="screen">

	<link rel="stylesheet" type="text/css" href="{{asset('assets/web/css/style.css')}}" media="screen">

	<link rel="stylesheet" type="text/css" href="{{asset('assets/web/css/responsive.css')}}" media="screen">
    
    <link rel="stylesheet" type="text/css" href="{{asset('assets/web/css/select2.min.css')}}" media="screen">

    <link href="{{asset('assets/css/dropzone.css')}}" type='text/css' rel='stylesheet'> 

    <link href="{{asset('assets/css/sweetalert.css')}}" rel="stylesheet" type="text/css" />    

    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/developer.css')}}" media="screen">

    <link href="{{asset('assets/web/css/alert_popup.css')}}" rel="stylesheet" type='text/css'>

    @stack('css')

    
	<script src="{{asset('assets/web/js/jquery-1.11.2.min.js')}}"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> -->
	<!-- <script src="{{asset('assets/js/jquery-3.3.1.min.js')}}"></script> -->

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
    <!-- https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js -->
    <script src="{{asset('assets/web/js/jquery-ui.js')}}"></script>
    <script src="{{asset('assets/web/js/jquery.flexdatalist.min.js')}}"></script>
    <script src="{{asset('assets/web/js/breaking-news-ticker.min.js')}}"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="{{asset('assets/web/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/web/js/jquery.flagstrap.js')}}"></script>
    <script src="{{asset('assets/web/js/slick.min.js')}}"></script>
    <script src="{{asset('assets/web/js/select2.min.js')}}" defer></script>

    <script src="{{asset('assets/web/js/jquery.mCustomScrollbar.concat.min.js')}}"></script>
    <script src="{{asset('assets/web/js/site.js')}}"></script>
    <script src="{{asset('assets/web/js/web.js')}}"></script>
    
    <!--begin sweet alert -->
    <script src="{{asset('assets/js/sweetalert.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/dropzone.js')}}" type='text/javascript'></script>

    <script src="{{asset('assets/web/js/notiflix-aio-2.3.1.min.js')}}"></script>


    @stack('js')
    
    @if(auth()->guard('specialist')->check())
        <script src="{{asset('assets/js/specialist.js')}}"></script>
    @endif
    @if(auth()->guard('employer')->check())
        <script src="{{asset('assets/js/employer.js')}}"></script>
    @endif
    @if(auth()->guard('candidate')->check())
        <script src="{{asset('assets/js/candidate.js')}}"></script>
    @endif

    <script type="text/javascript">
        var site_url = "{{ url('/')}}";
        var SERVER_ERR_MSG = 'Unexpected error occurred while trying to process your request. Please report to admin as soon as you can.';
        var FORM_ERROR_MSG = 'Please check form and fill valid data.';

        var SOMETHING_WENT_WRONG  = 'Error something went wrong';

        Notiflix.Notify.Init({ 
            timeout:4000,
         });
        
         Notiflix.Confirm.Init({ 
            titleColor:'#d33c29',
            okButtonBackground:'#d33c29'
         }); 

        $(window).load(function(){
            @if(session('success'))
                success_popup("{{session('success')}}");
            @endif

            @if(session('error'))
                error_popup("{{session('error')}}");
            @endif

            @if(session('success_notify'))
               Notiflix.Notify.Success("{{session('success_notify')}}");
            @endif

            @if(session('error_notify'))
               Notiflix.Notify.Failure("{{session('error_notify')}}");
            @endif
        });

    </script>

    {{csrf_field()}}

</head>