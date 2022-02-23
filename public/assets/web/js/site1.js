function init_ajax_location_suggestions()
{
    $('.loadAjaxSuggestion').select2({
 
      ajax: {
        url: site_url+"/location_suggestion",
        dataType: "json",
        method: "POST",
        // delay: 250,
        
        data:function(params){
          var query = {
            keyword: params.term,
          }
          return query;
        },
        processResults: function (data) {
          return {
            results: data
          };
        },
        cache: true,
        minimumInputLength: 3,
      }
    });
}


$(document).ready(function() {

  if($('.select2').length > 0)
  {
    $('.select2').select2({
          placeholder: "Please select data",
    });
  }


//heading accordion
if ($(window).width() < 768) {
$(".heading-tab").on("click", function(e) {
	$(this).toggleClass("tab-icon");
	$(".content-tab").slideToggle(300);
});	
}
//tabbing		
	$('.signin-tabs li').click(function(){
		var tab_id = $(this).attr('data-tab');
		$('.signin-tabs li').removeClass('current');
		$('.tab-content').removeClass('current');
		$(this).addClass('current');
		$("#"+tab_id).addClass('current');
	});
	
//password  
  $('.eye1').click(function(){       
        if($(this).hasClass('eye')){           
          $(this).removeClass('eye');          
          $(this).addClass('eye-slash');          
          $('.pass1').attr('type','text');            
        }else{         
          $(this).removeClass('eye-slash');          
          $(this).addClass('eye');            
          $('.pass1').attr('type','password');
        }
    });
      $('.eye2').click(function(){       
        if($(this).hasClass('eye')){           
          $(this).removeClass('eye');          
          $(this).addClass('eye-slash');          
          $('.pass2').attr('type','text');            
        }else{         
          $(this).removeClass('eye-slash');          
          $(this).addClass('eye');            
          $('.pass2').attr('type','password');
        }
    });
      $('.eye3').click(function(){       
        if($(this).hasClass('eye')){           
          $(this).removeClass('eye');          
          $(this).addClass('eye-slash');          
          $('.pass3').attr('type','text');            
        }else{         
          $(this).removeClass('eye-slash');          
          $(this).addClass('eye');            
          $('.pass3').attr('type','password');
        }
    });
      $('.eye4').click(function(){       
        if($(this).hasClass('eye')){           
          $(this).removeClass('eye');          
          $(this).addClass('eye-slash');          
          $('.pass4').attr('type','text');            
        }else{         
          $(this).removeClass('eye-slash');          
          $(this).addClass('eye');            
          $('.pass4').attr('type','password');
        }
    });

//custom select box
if($('.func-wrapper select').length > 0) {
	$( ".func-wrapper select" ).selectmenu({
  appendTo: ".func-wrapper"
});
}	

//flag
if($('#currency-flag').length > 0) {
$('#currency-flag').flagStrap();
}
if($('#currency-flag-2').length > 0) {
$('#currency-flag-2').flagStrap();
}

//file-upload
 $("#file-upload").change(function() {
		$(this).prev("label").clone();
		var e = $("#file-upload")[0].files[0].name;
		$(this).prev("label").text(e)
});

//suggestions
/*if($('.flexdatalist').length > 0) {
$('.flexdatalist').flexdatalist({
     limitOfValues:1,
     minLength: 1,
     valueProperty: '*',
     selectionRequired: true,
     visibleProperties: ["name","capital","continent"],
     searchIn: 'name',
     data: 'countries.json',
});	
}*/

function initializeEmployerBranchLocationName()
{
    $('.branch-container-wrap .branch_location_id').each(function(index,val){
       $(this).attr('name',"location_id_"+index) 
    });
}

function initializeEmployerAssociatedEmailsName()
{
    $('.email-container-wrap .associated-acc-email').each(function(index,val){
       $(this).attr('name',"email_"+index) 
    });
}

//add-more
$('.add-mail').click(function() {
	$('.email-container-wrap').append($('.email-container').html());
  initializeEmployerAssociatedEmailsName();
});

$('.add-branch').click(function() {
	$('.branch-container-wrap').append($('.branch-container').html());
  initializeEmployerBranchLocationName();

});
	
//delete
$('.mail-del').click(function() {
	if($(".email-append").length > 1) {
		$(".email-container-wrap").children().last().remove();  
	}	
});
	
$('.branch-del').click(function() {
	if($(".branch-loc").length > 1) {
		$(".branch-container-wrap").children().last().remove();  
	}	
});			

//homepage-slider
if($('.blog-slider').length > 0) {
 $('.blog-slider').slick({
  dots: true,
  arrows:false,
  slidesToShow: 4,
  slidesToScroll: 4,
  responsive: [
    {
      breakpoint:1024,
      settings: {
        slidesToShow: 3,
        slidesToScroll:3,
      }
    },
    {
      breakpoint:768,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
  ]
});
}
//newsticker
if($('#newsticker').length > 0) {
    $('#newsticker').breakingNews();
}
//clear-search
$(".clear").click(function(){
    $(".searched").remove();	
});

//hamburger-menu
$(".hamburger").click(function() {
	$(".hamburger-menu").toggleClass("menu-open");
	$('body').toggleClass('noscroll');	
});

$("body").on('touchstart mousedown', function(e) {
	$(e.target).closest(".hamburger").length>0||$(e.target).closest(".hamburger-menu").length>0||$(".hamburger-menu").removeClass("menu-open")&&$(".hamburger").removeClass("menu-open")&&$('body').removeClass('noscroll');
});

if ($(window).width() < 1024) {
$('.down-arrow .menu-tab').click(function(e) {
  	e.preventDefault();  
    var $this = $(this);  
    if ($this.next().hasClass('submenu-open')) {
        $this.next().removeClass('submenu-open');
        $this.next().slideUp(400);
    } else {
        $this.parent().parent().find('li .header-submenu').removeClass('submenu-open');
        $this.parent().parent().find('li .header-submenu').slideUp(400);
        $this.next().toggleClass('submenu-open');
        $this.next().slideToggle(400);
    }
});   
}

//notification
$('.action-link').click(function(e) {
	e.stopPropagation();
$(this).toggleClass('open-selection');
        $(this).closest('li').find('.box-arrow').slideToggle();
        $(this).closest('li').siblings().find('.box-arrow').slideUp();
        $(this).closest('li').siblings().find('.action-link').removeClass('open-selection');
});	  
  
//footer-accordion   
if ($(window).width() < 768) {
$('.footer-tab').click(function(e) {
  	e.preventDefault();  
    var $this = $(this);  
    if ($this.next().hasClass('footer-list-open')) {
        $this.next().removeClass('footer-list-open');
        $this.next().slideUp(400);
    } else {
        $this.parent().parent().find('.footer-list').removeClass('footer-list-open');
        $this.parent().parent().find('.footer-list').slideUp(400);
        $this.next().toggleClass('footer-list-open');
        $this.next().slideToggle(400);
    }
});   
}
if ($(window).width() < 768) {
$('.footer-tab').click(function(e) {
	e.preventDefault();  
	if($(this).hasClass('icon')) {
		$(this).removeClass('icon');
	}
	else {
		$(this).addClass('icon');
		$(this).parent().siblings().find('.footer-tab').removeClass('icon');
	}
});
}	


$(".active-jobs").click(function() {
     $('html, body').animate({
         scrollTop: $("#active-job-link").offset().top - 90
     }, 500);
 });


//career-advice-detail tabbing
$('.career-tab-link').click(function() {
		var tab_id = $(this).attr('data-tab');
		$('.career-tab-link').removeClass('current');
		$('.career-content').removeClass('current');
		$(this).addClass('current');
		$("#"+tab_id).addClass('current');
});


//categories dropdown
$('.categories-tab-wrapper h3').click(function() {
	$('.career-tab').slideToggle();
});


//faq accordion
$('.faq-question').click(function(e) {
  	e.preventDefault();  
    var $this = $(this);  
      $this.toggleClass('faq-minus')
    if ($this.next().hasClass('faq-open')) {
        $this.next().removeClass('faq-open');
        $this.next().slideUp(350);
    } else {
        $this.parent().parent().find('li .inner').removeClass('faq-open');
        $this.parent().parent().find('li .inner').slideUp(350);
        $this.next().toggleClass('faq-open');
        $this.next().slideToggle(350);
    }
});

$('body').click(function() {
	$('.action-link').removeClass('open-selection');
	$('.box-arrow').slideUp();
});     

//job-listing-selectbox
if($('#relevance').length > 0) {
	$( "#relevance" ).selectmenu({
  appendTo: ".relevance-inner"
});
}
if($('.filter-selectbox').length > 0) {
	$(".filter-selectbox").selectmenu({
  appendTo: ".filter-selectbox-wrap"
});
}

$(".filter-text").on("click", function() {
	$(this).toggleClass("filter-icon");
	$(".job-filter-inner").toggle();
});
//job-listing-dropdown
$('.filter-dropdown').click(function(e) {
  	e.preventDefault();  
    var $this = $(this);  
    if ($this.next().hasClass('filter-option-open')) {
        $this.next().removeClass('filter-option-open');
        $this.next().slideUp(400);
    } else {
        $this.parent().parent().find('.filter-option').removeClass('filter-option-open');
        $this.parent().parent().find('.filter-option').slideUp(400);
        $this.next().toggleClass('filter-option-open');
        $this.next().slideToggle(400);
    }
});
$('.filter-dropdown').click(function(e) {
	e.preventDefault();  
	if($(this).hasClass('rotate-arrow')) {
		$(this).removeClass('rotate-arrow');
	}
	else {
		$(this).addClass('rotate-arrow');
		$(this).parent().siblings().find('.filter-dropdown').removeClass('rotate-arrow');
	}
});

//file-upload
$('#cv-upload').change(function() {
  var i = $(this).prev('label').clone();
  var file = $('#cv-upload')[0].files[0].name;
  $(this).prev('label').text(file);
});

//coompany-detail tabbing
$('ul.refer-tabs li').click(function(){
		var tab_id = $(this).attr('data-tab');
		$('ul.refer-tabs li').removeClass('refer-current');
		$('.refer-content').removeClass('refer-current');

		$(this).addClass('refer-current');
		$("#"+tab_id).addClass('refer-current');
});

//range-slider

setTimeout(function () {
  $("#slider-range-data").slider({
      range: true,
      min: 0,
      max: 200000,
      step: 10,
      values: [0, 150000],
      slide: function (event, ui) {
          var delay = function () {
              var handleIndex = $(ui.handle).index() - 1;
              if (handleIndex == 0) {
                  $('#min-data').html('$' + ui.values[0]).position({
                      my: 'center top',
                      at: 'center bottom',
                      of: ui.handle,
                      offset: "0, 10"
                  });
              } else {
                  $('#max-data').html('$' + ui.values[1]).position({
                      my: 'center top',
                      at: 'center bottom',
                      of: ui.handle,
                      offset: "0, 10"
                  });
              }
          };
          setTimeout(delay, 5);
      }
  });
  $('#min-data').html('$' + $('#slider-range').slider('values', 0)).position({
      my: 'center top',
      at: 'center bottom'
  });
  $('#max-data').html('$' + $('#slider-range').slider('values', 1)).position({
      my: 'center top',
      at: 'center bottom'
  });
  $('#max-data').css({
      "position": "relative",
      "left": "64%"
  });
});



//range-slider for salary

    $("#slider-range").slider({
        range: true,
        min: 0,
        max: 200000,
        step: 10,
        values: [0, 150000],
        slide: function (event, ui) {
            var delay = function () {
                var handleIndex = $(ui.handle).index() - 1;
                if (handleIndex == 0) {
                    $('#min').html('$' + ui.values[0]).position({
                        my: 'center top',
                        at: 'center bottom',
                        of: ui.handle,
                        offset: "0, 10"
                    });
                } else {
                    $('#max').html('$' + ui.values[1]).position({
                        my: 'center top',
                        at: 'center bottom',
                        of: ui.handle,
                        offset: "0, 10"
                    });
                }

            };
            // wait for the ui.handle to set its position
            setTimeout(delay, 5);
        }
    });
    $('#min').html('$' + $('#slider-range').slider('values', 0)).position({
        my: 'center top',
        at: 'center bottom'
    });
    $('#max').html('$' + $('#slider-range').slider('values', 1)).position({
        my: 'center top',
        at: 'center bottom'
    });
    $('#max').css({
        "position": "relative",
        "left": "64%"
    });



//friends-behalf placeholder remove
$('#browse-file').change(function() {
  var i = $(this).prev('label').clone();
  var file = $('#browse-file')[0].files[0].name;
  $(this).prev('label').text(file);
});

$('#browse-file2').change(function() {
  var i = $(this).prev('label').clone();
  var file = $('#browse-file2')[0].files[0].name;
  $(this).prev('label').text(file);
});

if($('#drag-drop').length > 0) {
$('#drag-drop').FancyFileUpload({
  params : {
    action :'fileuploader'
  },
  maxfilesize : 1000000
});
}
if($('#drag-drop2').length > 0) {
$('#drag-drop2').FancyFileUpload({
  params : {
    action :'fileuploader'
  },
  maxfilesize : 1000000
});
}
$('.radio-cv').click(function(e) {
  	e.preventDefault();  
    var $this = $(this);  
    if ($this.children().last().hasClass('show-cv')) {
        $this.children().last().removeClass('show-cv');
    } else {
    	$this.siblings().children().last().removeClass('show-cv');
       $this.children().last().toggleClass('show-cv');
    }
   
});

$('.radio-cv').click(function(e) {
  	e.preventDefault();  
    var $this = $(this);  
    $this.toggleClass('radio-active');
    if ($this.siblings().hasClass('radio-active')) {
        $this.siblings().removeClass('radio-active');
    } 
   
});

// myprofile
//tabbing
$('.profile-tabs').click(function(){
		var tab_id = $(this).attr('data-tab');
		$('.profile-tabs').removeClass('profile-current');
		$('.profile-content').removeClass('profile-current');
		$(this).addClass('profile-current');
		$("#"+tab_id).addClass('profile-current');
});

//save-job tabbing
	$('.job-list').click(function(){
		var tab_id = $(this).attr('data-tab');
		$('.job-list').removeClass('job-current');
		$('.job-content').removeClass('job-current');
		$(this).addClass('job-current');
		$("#"+tab_id).addClass('job-current');
	});

//currency-select
if($('#select-currency').length > 0) {
	$( "#select-currency" ).selectmenu({
	appendTo: ".wrapper-currency"
});
}
//timezone selectbox
if($('#timezone').length > 0) {
	$( "#timezone" ).selectmenu({
	appendTo: ".wrapper-timezone"
});
}
//date-picker 
$( ".datepicker,#datepicker" ).datepicker({
      showOn: "button",
      buttonImage: site_url+"/assets/web/images/calendar-img.png",
      buttonImageOnly: true, 
    // beforeShow:function(textbox, instance){
        // $('.start-date').append($('#ui-datepicker-div'));
    // }
      
    });
$( ".end-picker,#end-picker" ).datepicker({
      showOn: "button",
      buttonImage: site_url+"/assets/web/images/calendar-img.png",
      buttonImageOnly: true
      // buttonText: "Select date"
    });    
//date-picker2 
$( ".datepicker2,#datepicker2" ).datepicker({
      showOn: "button",
      buttonImage: site_url+"/assets/web/images/calendar-img.png",
      buttonImageOnly: true
    });
$( ".end-picker2,#end-picker2" ).datepicker({
      showOn: "button",
      buttonImage: site_url+"/assets/web/images/calendar-img.png",
      buttonImageOnly: true
      // buttonText: "Select date"
    });  

//my-profile drag drop
$('#browse-file3').change(function() {
  var i = $(this).prev('label').clone();
  var file = $('#browse-file3')[0].files[0].name;
  $(this).prev('label').text(file);
});
$('#browse-file4').change(function() {
  var i = $(this).prev('label').clone();
  var file = $('#browse-file4')[0].files[0].name;
  $(this).prev('label').text(file);
});
if($('#drag-drop3').length > 0) {
$('#drag-drop3').FancyFileUpload({
  params : {
    action :'fileuploader'
  },
  maxfilesize : 1000000
});
}
if($('#drag-drop4').length > 0) {
$('#drag-drop4').FancyFileUpload({
  url : site_url+"/specialist/update_profile",
  // key-value pairs to send to the server
  'params' : {},
  // editable file name?
  'edit' : true,
  // max file size
  'maxfilesize' : -1,
  // a list of allowed file extensions
  'accept' : null,
  // 'iec_windows', 'iec_formal', or 'si' to specify what units to use when displaying file sizes
  'displayunits' : 'iec_windows',
  // adjust the final precision when displaying file sizes
  'adjustprecision' : true,
  // the number of retries to perform before giving up
  'retries' : 5,
  // the base delay, in milliseconds, to apply between retries
  'retrydelay' : 500,
  // called for each item after it has been added to the DOM
  'added' : null,
  // called whenever starting the upload
  'startupload' : null,
  // called whenever progress is updated
  'continueupload' : null,
  // called whenever an upload has been cancelled
  'uploadcancelled' : null,
  // called whenever an upload has successfully completed
  'uploadcompleted' : null,
  // jQuery File Upload options
  'fileupload' : {},
  // translation strings here
  'langmap' : {}
});
}

//my-profile

$('.additional-btn').click(function() {
  $('.loadAjaxSuggestion').select2('destroy')
	$('.work-child').append($('.work-exp-main').html());
  loadAjaxSuggestionSelect2();
});

$('.additional-del').click(function() {
	if($(".work-exp-inner").length > 1) {
		$(".work-child").children().last().remove();  	
	}
});

$('.add-stream').on('click', function() {
  $('.new-country-select').select2('destroy');
  $('.new-state-select').select2('destroy');
  $('.new-city-select').select2('destroy');
	$('.edu-main').append($('.edu-outer').html());   
  onloadselect2()
  loadChange();

  
});


$('.stream-del').click(function() {
	if($(".edu-inner").length > 1) {
		$(".edu-main").children().last().remove();  	
	}
});



//referrals tab
	$('.refer-list').click(function(){
		var tab_id = $(this).attr('data-tab');
		$('.refer-list').removeClass('refer-current');
		$('.refer-content').removeClass('refer-current');
		$(this).addClass('refer-current');
		$("#"+tab_id).addClass('refer-current');
	});

$(".ref-button").on('click', function() {
	$(this).toggleClass("ref-border");
});
//sent-detail
$(".sort-selectbox").selectmenu({
  appendTo: ".sort-option"
});

/* bank detail */   
  
$(".refer-list").on('click', function() {
	$(".referrals .inner-pagination").show();
});
$(".bank-details, .score").on('click', function() {
	$(".referrals .inner-pagination").hide();
});       

//messages delete
$(".del-msg1").on('click', function() {
	$(".msg1").hide();
});
$(".del-msg2").on('click', function() {
	$(".msg2").hide();
});
$(".del-msg3").on('click', function() {
	$(".msg3").hide();
});
$(".del-msg4").on('click', function() {
	$(".msg4").hide();
});
$(".msg-delete").on('click', function() {
	$("#message-tab").hide();
});
//notification 
$(".manage-dropdown").on("click", function() {
	$(".manage-list").toggle();
});

//dashboard 
$('.dashboard-tabs').click(function() {
		var tab_id = $(this).attr('data-tab');
		$('.dashboard-tabs').removeClass('dashboard-current');
		$('.dashboard-content').removeClass('dashboard-current');
		$(this).addClass('dashboard-current');
		$("#"+tab_id).addClass('dashboard-current');
});
//job-basket
$('.basket-list').click(function(){
	var tab_id = $(this).attr('data-tab');
	$('.basket-list').removeClass('basket-current');
	$('.basket-content').removeClass('basket-current');
	$(this).addClass('basket-current');
	$("#"+tab_id).addClass('basket-current');
});

//application
$(".id-select").selectmenu({
  appendTo: ".id-select-wrap"
});
$(".id-select2").selectmenu({
  appendTo: ".id-select-wrap2"
});
$(".id-select3").selectmenu({
  appendTo: ".id-select-wrap3"
});
$(".id-select4").selectmenu({
  appendTo: ".id-select-wrap4"
});
$(".pos-select").selectmenu({
  appendTo: ".pos-select-wrap"
});
$(".pos-select2").selectmenu({
  appendTo: ".pos-select-wrap2"
});
$(".pos-select3").selectmenu({
  appendTo: ".pos-select-wrap3"
});
$(".pos-select4").selectmenu({
  appendTo: ".pos-select-wrap4"
});
$(".com-select").selectmenu({
  appendTo: ".com-select-wrap"
});
$(".com-select2").selectmenu({
  appendTo: ".com-select-wrap2"
});
$(".com-select3").selectmenu({
  appendTo: ".com-select-wrap3"
});
$(".com-select4").selectmenu({
  appendTo: ".com-select-wrap4"
});
$('.apps-list').click(function(){
	var tab_id = $(this).attr('data-tab');
	$('.apps-list').removeClass('apps-current');
	$('.apps-content').removeClass('apps-current');
	$(this).addClass('apps-current');
	$("#"+tab_id).addClass('apps-current');
});

//applications-list 
$(".select-status").selectmenu({
  appendTo: ".status-select"
});
$(".can-select").selectmenu({
  appendTo: ".candidate-select"
});
//application detail
$(".sts-select").selectmenu({
  appendTo: ".status-wrapper"
});
//referrals
$('.referral-list').click(function(){
	var tab_id = $(this).attr('data-tab');
	$('.referral-list').removeClass('referral-current');
	$('.referral-content').removeClass('referral-current');
	$(this).addClass('referral-current');
	$("#"+tab_id).addClass('referral-current');
});
$(".push-btn").on("click", function() {
	$(".msg-employer").toggle();
});
//specialist payment
$('.payment-list').click(function() {
	var tab_id = $(this).attr('data-tab');
	$('.payment-list').removeClass('payment-current');
	$('.payment-content').removeClass('payment-current');
	$(this).addClass('payment-current');
	$("#"+tab_id).addClass('payment-current');
});

//employer dashboard 
$('.emp-tabs').click(function() {
		var tab_id = $(this).attr('data-tab');
		$('.emp-tabs').removeClass('emp-current');
		$('.emp-content').removeClass('emp-current');
		$(this).addClass('emp-current');
		$("#"+tab_id).addClass('emp-current');
});
//specialist payment
$(".payment-list").on('click', function() {
	$(".dash-pay .inner-pagination").show();
});
$(".pag-hide").on('click', function() {
	$(".dash-pay .inner-pagination").hide();
});    
$('.emp-application').click(function() {
		var tab_id = $(this).attr('data-tab');
		$('.emp-application').removeClass('employer-current');
		$('.employer-content').removeClass('employer-current');
		$(this).addClass('employer-current');
		$("#"+tab_id).addClass('employer-current');
});

if($('#export-selectbox').length > 0) {
	$("#export-selectbox").selectmenu({
  appendTo: ".export-select"
});
}

if($('.account-link').length > 0) {
$('.account-link').click(function() {
		var tab_id = $(this).attr('data-tab');
		$('.account-link').removeClass('account-current');
		$('.account-content').removeClass('account-current');
		$(this).addClass('account-current');
		$("#"+tab_id).addClass('account-current');
});
}
if($('#functional-tagit').length > 0) {
$('#functional-tagit').tagsInput({
	placeholder:'Enter',
	 'autocomplete': {
    source: [
      'Software',
      'Management',
      'Net',
      'Demo'
    ]
  }
});
}
//employer-add-job 
if($('#loc-add').length > 0) {
$('#loc-add').selectstyle();
}
if($('#loc-state').length > 0) {
$('#loc-state').selectstyle();
}
if($('#cities').length > 0) {
$('#cities').tagsInput({
	placeholder:null,
});
}
if($('#add-city').length > 0) {
$('#add-city').selectmenu({
	appendTo: ".cities-select"
});
}
if($('#tag-skill').length > 0) {
$('#tag-skill').tagsInput({
	placeholder:null,
});
}
if($('#tag-area').length > 0) {
$('#tag-area').tagsInput({
	placeholder:null,
});
}
if($('#add-edu').length > 0) {
$('#add-edu').selectmenu({
	appendTo: ".add-edu-wrap"
});
}
if($('#add-type').length > 0) {
$('#add-type').selectmenu({
	appendTo: ".add-type-wrap"
});
}
$(".add-locations").on("click", function() {
	$(".form-outer-wrapper").append($('.form-data').html());
});
$(".remove-btn").on("click", function() {
if($(".container-form").length > 1) {
	$(".form-outer-wrapper").children().last().remove();
}	
});

    $('.radio-amount').click(function(){
            if($(".radio-amount input").is(":checked")){
                $(".input-amount").addClass("show-radio");
            }
            else if($(".radio-amount input").is(":not(:checked)")){
                $(".input-amount").removeClass("show-radio");
            }
        });

    $('.radio-percent').click(function(){
            if($(".radio-percent input").is(":checked")){
                $(".input-percent").addClass("show-radio");
            }
            else if($(".radio-percent input").is(":not(:checked)")){
                $(".input-amount").removeClass("show-radio");
            }
        });


//employer-view-jobs
if($('.id-select5').length > 0) {
$('.id-select5').selectmenu({
	appendTo: ".id-select-wrap5"
});
}
if($('.pos-select5').length > 0) {
$('.pos-select5').selectmenu({
	appendTo: ".pos-select-wrap5"
});
}
if($('.status-job').length > 0) {
$('.status-job').selectmenu({
	appendTo: ".job-status"
});
}
if($('.com-select5').length > 0) {
$('.com-select5').selectmenu({
	appendTo: ".com-select-wrap5"
});
}
if($('.job-select2').length > 0) {
$('.job-select2').selectmenu({
	appendTo: ".job-select-wrap2"
});
}

//employer payment listing
if($('.pay-sort').length > 0) {
	$(".pay-sort").selectmenu({
  appendTo: ".pay-selectbox"
});
}

//employer message detail 
$(".emp-delete").on('click', function() {
	$(".emp-msg-detail").hide();
});

$('.lists-profile').click(function() {
		var tab_id = $(this).attr('data-tab');
		$('.lists-profile').removeClass('acc-current');
		$('.content-account').removeClass('acc-current');
		$(this).addClass('acc-current');
		$("#"+tab_id).addClass('acc-current');
});
//profile-edit
if($('#time-zone').length > 0) {
	$("#time-zone").selectmenu({
  appendTo: ".timezone-wrapper"
});
}

$('.add-other-loc').click(function() {
	$('.other-loc-wrapper').append($('.edit-other-loc').html());
});





//select city 



function loadAjaxSuggestionSelect2(){
  var ajaxSuggCl = $('.loadAjaxSuggestion');
  ajaxSuggCl.each(function(ind,el){
    $(this).select2({ 
      minimumInputLength: 3,
      ajax: {
        url: site_url+"/location_suggestion",
        dataType: "json",
        method: "POST",
        // delay: 250,
        
        data:function(params){
          var query = {
            keyword: params.term,
          }
          return query;
        },
        processResults: function (data) {
          return {
            results: data
          };
        },
        cache: true,
        minimumInputLength: 3,
      }
    });
  });
}

if($('.loadAjaxSuggestion').length > 0) {
 // $('#select-city').selectstyle();
  loadAjaxSuggestionSelect2();
}

//select city 

//select city permanent add
if($('#select-state').length > 0) {
$('#select-state').selectstyle();
}
if($('#bank-select').length > 0) {
$('#bank-select').selectstyle();
}
if($('.edit-selectbox').length > 0) {
   $('.edit-selectbox').selectstyle();
}
function onloadselect2(){
  function matchCustom(params, data) {

    // If there are no search terms, return all of the data
    if ($.trim(params.term) === '') {
      return data;
    }

    // Do not display the item if there is no 'text' property
    if (typeof data.text === 'undefined') {
      return null;
    }
    

    // `params.term` should be the term that is used for searching
    // `data.text` is the text that is displayed for the data object
    if (data.text.toUpperCase().indexOf(params.term.toUpperCase()) > -1) {
      var modifiedData = $.extend({}, data, true);
      modifiedData.text += ' (matched)';
      // You can return modified objects from here
      // This includes matching the `children` how you want in nested data sets
      return modifiedData;
    }

    // Return `null` if the term should not be displayed
    return null;
  }
  
  $(".new-country-select").select2({
    matcher: matchCustom
  });
   $(".new-state-select").select2({
    matcher: matchCustom
  });
    $(".new-city-select").select2({
    matcher: matchCustom
  });
 
}
function loadChange(){
  console.log('load')
  
    $('.new-country-select').change(function(e){
      // e.stopImmediatePropagation();
    var i = $(".new-country-select").index(this);
    console.log(i)
    $('.new-state-select')[i].innerHTML = "";
    $(this).select2();
    console.log($(this).children("option:selected").val());
    var key = $(this).children("option:selected").val();
    $.ajax({
      url:site_url+'/get_states/'+key,
      type:'get',
      success:function(data){
        // console.log(data);
        // var option = "";
        for(var j = 0 ; j < data.length ; j++){
          // console.log(data[i]);
         var option = '<option value='+data[j].id+'>'+ data[j].name+'</option>';
          $('.new-state-select').eq(i).append(option);
        }
         //$('#new-state').selectstyle();
          $('.new-state-select').eq(i).select2();
      }
    })

  })
  
  $('.new-state-select').change(function(e){
    var i = $(".new-state-select").index(this);
    $('.new-city-select')[i].innerHTML = "";
    $(this).select2();
    console.log($(this).children("option:selected").val());
    var key = $(this).children("option:selected").val();
    $.ajax({
      url:site_url+'/get_cities/'+key,
      type:'get',
      success:function(data){
        // console.log(data);
        // var option = "";
        for(var j = 0 ; j < data.length ; j++){
          // console.log(data[i]);
         var option = '<option value='+data[j].id+'>'+ data[j].name+'</option>';
          $('.new-city-select').eq(i).append(option);
        }
         //$('#new-state').selectstyle();
          $('.new-city-select').eq(i).select2();
      }
    })

  })

}
if($('.new-country-select').length > 0) {
  onloadselect2();
  loadChange();
}
if($('.job-select').length > 0) {
   $('.job-select').selectstyle();
}
if($('.city-sel').length > 0) {
   $('.city-sel').selectstyle();
}
// if($('.profile-loc').length > 0) {
//    $('.profile-loc').select2();
// }
// if($('.new-city,#new-city').length > 0) {
//   $('.new-city,#new-city').selectstyle();
// }
if($('.new-state,#new-state').length > 0) {
  loadChange();
}

$(".rating-star li").click(function(){
	$(this).toggleClass("star-color");
});

$(".friends-star li").click(function(){
	$(this).toggleClass("star-color");
});

$(".form-disable :input").prop("disabled", true);

$(".edit-enable").click(function() {
	$(".form-disable :input").prop("disabled", false);
	$(".profile-main-form").removeClass("form-disable");
	$(".edit-btn-outer").addClass("fixed-btn");
});

$('.bottom-image').bind('inview', function(event, visible) {
        if (visible == true) {
            $('.edit-btn-outer').addClass('edit-hide');
        } else {
             $('.edit-btn-outer').removeClass('edit-hide');
        }
    });

});
//custom-scrollbar   
$(window).on("load",function() {	
if($('.notification-menu').length > 0) {
	$(".notification-menu").mCustomScrollbar();
}
if($('#emp-scroll').length > 0) {
	$("#emp-scroll").mCustomScrollbar();
}
if($('.hrz-scroll').length > 0) {
$(".hrz-scroll").mCustomScrollbar({
	axis:"x"
});
}
//company-slider
if($('.company-slider').length > 0){
$('.company-slider').slick({
   slidesToShow: 1,
   slidesToScroll: 1,
   arrows: false,
   infinite:false,
   fade: true,
   asNavFor: '.text-slider'
 });
}
if($('.text-slider').length > 0){
 $('.text-slider').slick({
   slidesToShow:8,
   slidesToScroll: 1,
   infinite:false,
   variableWidth: true,
   asNavFor: '.company-slider',
   focusOnSelect: true,
   responsive: [
    {
      breakpoint:1200,
      settings: {
        slidesToShow:4,
        slidesToScroll:1,
      }
    },
    {
      breakpoint:768,
      settings: {
        slidesToShow:3,
        slidesToScroll:1,
      }
    },
    {
      breakpoint:576,
      settings: {
        slidesToShow:2,
        slidesToScroll:1
      }
    },
        {
      breakpoint:480,
      settings: {
        slidesToShow:1,
        slidesToScroll:1
      }
    }
  ]
});
}
//career-advice-slider
if($('.slides-wrapper').length > 0) {
$('.slides-wrapper').slick({
   slidesToShow: 1,
   infinite:false,
   slidesToScroll: 1,
   arrows: false,
   fade: true,
   asNavFor: '.career-slider'
 });
}
if($('.career-slider').length > 0) {
 $('.career-slider').slick({
   slidesToShow:7,
   slidesToScroll: 1,
   infinite:false,
   variableWidth: true,
   asNavFor: '.slides-wrapper',
   focusOnSelect: true,
   responsive: [
    {
      breakpoint:1200,
      settings: {
        slidesToShow:4,
        slidesToScroll:1,
      }
    },
    {
      breakpoint:768,
      settings: {
        slidesToShow:3,
        slidesToScroll:1,
      }
    },
    {
      breakpoint:576,
      settings: {
        slidesToShow:2,
        slidesToScroll:1
      }
    },
        {
      breakpoint:480,
      settings: {
        slidesToShow:1,
        slidesToScroll:1
      }
    }
  ]
});
}  
});  
//header 
$(window).scroll(function() {
	if ($(".header").length>0) {
	var e=$(this).scrollTop();
	if (e > 100) {
		$("header").addClass("fixed-header")
	}
	else {
		$("header").removeClass("fixed-header")
	}
}
});
