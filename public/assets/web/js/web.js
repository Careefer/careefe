$(document).ready(function()
{   
  
    // job search ajax pagination
    if($('.ajax-search-job-html-bind .pagination-wrapper li a').length > 0)
    { 
      $('body').on('click','.ajax-search-job-html-bind .pagination-wrapper li a',function(e){
          e.preventDefault();
          var url = $(this).attr('href');
          job_search_ajax_pagination_data(url);
      });
    }

    // specialist my jobs ajax pagination
    if($('.spc-job-ajax-render-section .pagination-wrapper li a').length > 0)
    { 
      $('body').on('click','.spc-job-ajax-render-section .pagination-wrapper li a',function(e){
          e.preventDefault();
          var url = $(this).attr('href');

          ajax_pagination(url,'spc-job-ajax-render-section');
      });
    }

     

    // home page keyword suggestations
    if($('.home-job-search-keyword').length > 0)
    {   
      job_search_keyword_suggestion();
    }

    // home page locaton suggestation
    $($('.job-search-location').length > 0)
    {
      job_search_location_suggestion();
    }

    //Companies Listing pagination 
    if($('.company-wrapper .pagination-wrapper li a').length > 0)
    {
       $('body').on('click','.company-wrapper .pagination-wrapper li a',function(e){
            e.preventDefault();
            var url = $(this).attr('href');
            load_company_data_ajax(url);
      });
    }

    // company listing letter filters
    if($('.company_list_letter_filter').length > 0)
    { 
        $('body').on('click','.company_list_letter_filter',function(){
          $('input[name=company_list_letter_filter]').remove();  
          var letter = $(this).data('letter');
          $(this).after('<input type="hidden" name="company_list_letter_filter" value="'+letter+'">')

          var letter = '';
          if(typeof $('input[name=company_list_letter_filter]').val() !== 'undefined')
          {
            letter = $('input[name=company_list_letter_filter]').val();
          }

          var full_url_split  = window.location.href.split('?');

          ajax_url = full_url_split[0]+"?letter="+letter;

          if(typeof full_url_split[1] !== 'undefined')
          {
            keyword_val = getQueryStringValue('keyword');
            
            if(keyword_val.length > 0)
            {
              ajax_url+="&keyword="+keyword_val;
            }
          }
          load_company_data_ajax(ajax_url);
        });
    }

    // all blog list ajax pagination
    if($('.all-blog-bind-ajax-data .pagination-wrapper li a').length > 0)
    {
      $('body').on('click','.all-blog-bind-ajax-data .pagination-wrapper li a',function(e){
            e.preventDefault();
            var url = $(this).attr('href');
            load_blog_data_ajax(url);
      });
    }

    // all career advice list ajax pagination
    if($('.all-career-bind-ajax-data .pagination-wrapper li a').length > 0)
    {
      $('body').on('click','.all-career-bind-ajax-data .pagination-wrapper li a',function(e){
            e.preventDefault();
            var url = $(this).attr('href');
            load_career_advice_data_ajax(url);
      });
    }

    // Start apply job search filters 

      // Posted date
      $('.job-filter-posted-date').on('selectmenuchange', function() {
          apply_filter_search_job();
      });

       // Referral Bonus
       $( "#slider-range-data" ).on( "slidechange", function( event, ui ){
            var val = ui.values[0]+'-'+ui.values[1];            
            $('#job_search_rb_filter').val(val);
            apply_filter_search_job();
       });

       // Salary 
      $( "#slider-range" ).on( "slidechange", function( event, ui ){
            var val = ui.values[0]+'-'+ui.values[1];            
            $('#job_search_sal_filter').val(val);
            apply_filter_search_job();
       });

      // Experience
      $( "#experience-range-slider" ).on( "slidechange", function( event, ui ){
            var val = ui.values[0]+'-'+ui.values[1];            
            $('#job_search_exp_filter').val(val);
            apply_filter_search_job();
       });

      // sort by
      $('body').on( "selectmenuchange",".emp-job-sort-by", function( event, ui ){
          apply_filter_search_job();
      });

     // End apply job search filters 
    // let init = setInterval(() => {
      // if($('.careefer-select2')){
        // clearInterval(init)
          // $('.careefer-select2').select2({
          //   tags: true
          // });          
      // }
    // }, 100);
});

function copy_text(el)
{ 
  //console.log(el.prev().val());
  text = el.prev().val();
  el.prev().attr('type','text');
  var copyText = el.prev();
  var length = text.length;
  copyText.type = 'hidden';
  copyText.select();
  document.execCommand("copy");
  el.prev().attr('type','hidden');
  //alert("Copied the text: " + text);
  Notiflix.Notify.Success("Link copied: "+text);

}

function apply_filter_search_job()
{   
    var form_data = $("#search_job_filters_frm").serialize();

    // update create job alert action URL
    var create_alert_action = $('#create_job_alert_frm').data('action');
        create_alert_action+="&"+form_data;

    $('#create_job_alert_frm').attr('action',create_alert_action);

    if(typeof $('.emp-job-sort-by').val() !== 'undefined')
    {
      var sort_by = $('.emp-job-sort-by').val().trim();

      if(sort_by.length > 0)
      {
        form_data+="&sort="+sort_by      
      }
    }
    
    var url       = window.current_url+'&'+form_data;
    let stateObj = { id: "100" };
    window.history.pushState(stateObj,"Job Listing", url);

    // find jobs
    job_search_ajax_pagination_data(url);
}

function job_search_ajax_pagination_data(url)
{
    if(url == 'javascript:void(0);')
    {
      return false;
    }
            
    show_loader();

    $.ajax({
          url : url 
        }).done(function (data)
        {
          $('.ajax-search-job-html-bind').html(data);

          var cities = $("input[name='c[]']:checked")
              .map(function(){return $(this).val();}).get();

          var industries = $("input[name='ind[]']:checked")
              .map(function(){return $(this).val();}).get();

          if((cities.length > 0) || (industries.length > 0))
          {
            get_filtered_company();
          }    

          // bind sort select 
          if($('#relevance').length > 0)
          {
            $( "#relevance" ).selectmenu({
              appendTo: ".relevance-inner"
            });
          }
 
          hide_loader() 

        }).fail(function()
        {
          hide_loader() 
          alert('Data could not be loaded.');
        });
}

function get_filtered_company()
{ 
    var form_data = $("#search_job_filters_frm").serialize();

    var urlParams = new URLSearchParams(window.location.search);

    if(urlParams.has('l'))
    {      
      var location = urlParams.get('l');
      form_data+='&l='+location;
    }

    $.ajax({
          url : site_url+'/job/filter_top_company?'+form_data
        }).done(function (html)
        {
          $('#top-company-wrap').html(html);
        }).fail(function()
        {
          console.log('Unable to load filtered company list');
        });
}

function job_search_location_suggestion()
{     
        $('.job-search-location').select2({ 
          placeholder:'Location',
          ajax: {
            url: site_url+"/search_jog_location_suggestion",
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
                results: $.map(data, function (res) {
                    return {
                        text: res.text,
                        id: res.slug
                    }
                })
              };
            },
            cache: true,
            minimumInputLength: 2,
          },

        });
}

function job_search_keyword_suggestion()
{ 
        $('.home-job-search-keyword').select2({ 
          placeholder:'Keywords',
          ajax: {
            url: site_url+"/search_job_keyword_suggestion",
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
                results: $.map(data, function (res) {
                    return {
                        text: res.text,
                        id: res.slug
                    }
                })
              };
            },
            cache: true,
            minimumInputLength: 2,
          },

        });
}

function getQueryStringValue (key)
{  
    return decodeURIComponent(window.location.search.replace(new RegExp("^(?:.*[&\\?]" + encodeURIComponent(key).replace(/[\.\+\*]/g, "\\$&") + "(?:\\=([^&]*))?)?.*$", "i"), "$1"));  
}

function load_career_advice_data_ajax(url)
{
    if(url == 'javascript:void(0);')
    {
      return false;
    }
            
    show_loader();

    $.ajax({
          url : url 
        }).done(function (data)
        {
          $('.all-career-bind-ajax-data').html(data); 

          hide_loader() 

        }).fail(function()
        {
          hide_loader() 
          alert('Data could not be loaded.');
        });
}  

function ajax_pagination(url,render_section_class)
{
    if(url == 'javascript:void(0);')
    {
      return false;
    }
          
  show_loader();

  $.ajax({
        url : url 
      }).done(function (data)
      {
        $('.'+render_section_class).html(data); 

        hide_loader() 

      }).fail(function()
      {
        hide_loader() 
        alert('Data could not be loaded.');
      });
}

function load_blog_data_ajax(url)
{
    if(url == 'javascript:void(0);')
      {
        return false;
      }
            
    show_loader();

    $.ajax({
          url : url 
        }).done(function (data)
        {
          $('.all-blog-bind-ajax-data').html(data); 

          hide_loader() 

        }).fail(function()
        {
          hide_loader() 
          alert('Data could not be loaded.');
        });
}  

function load_company_data_ajax(url)
{
    if(url == 'javascript:void(0);')
      {
        return false;
      }
            
    show_loader();

    $.ajax({
          url : url 
        }).done(function (data)
        {
          $('.company-bind-ajax-data').html(data); 

          hide_loader() 

        }).fail(function()
        {
          hide_loader() 
          alert('Data could not be loaded.');
        });
}

function show_loader()
{ 
  Notiflix.Loading.Hourglass('Loading please wait...');

  /*$('.website-loader').show();
  $('.content').css('opacity','0.1');*/
}

function hide_loader()
{
  /*$('.website-loader').hide();
  $('.content').css('opacity','');*/
  Notiflix.Loading.Remove();
}

function submit_form(obj_btn, obj_form , show_loder_only = false)
{
    if(show_loder_only == true)
    {   
        current_html = obj_btn.html();
        obj_btn.html('<i class="fa fa-circle-o-notch fa-spin"></i>&nbsp'+current_html);
    }
    else
    {
        obj_btn.html('<i class="fa fa-circle-o-notch fa-spin"></i>&nbspPlease wait..');
    }
    obj_btn.attr('disabled', 'disabled');
    obj_form.submit();
}

function redirect_url(obj, url, show_loder_only = false,new_tab = false) {

    if(show_loder_only == true)
    {   
        current_html = obj.html();
        obj.html('<i class="fa fa-circle-o-notch fa-spin"></i>&nbsp'+current_html);
    }
    
    if(show_loder_only == false)
    {
        obj.html('<i class="fa fa-circle-o-notch fa-spin"></i>&nbspPlease wait..');
    }

    if(new_tab == true)
    {
        window.open(url, "_blank"); 
    }
    else
    {
      obj.attr('disabled', 'disabled');
      window.location.href = url;
    }
}


function btn_disable(btn_id_class)
{   
    $(btn_id_class).html('<i class="fa fa-circle-o-notch fa-spin"></i> Please wait..');
    $(btn_id_class).attr('disabled','disabled');
}

function btn_enable(btn_id_class,txt = null)
{   
    $(btn_id_class).removeAttr('disabled','disabled');
    $(btn_id_class).text(txt);
}

function error_popup(msg = SERVER_ERR_MSG , reload = false,redirect_url = false,new_tab = false)
{
  Notiflix.Report.Failure('Failure',msg,false,function(){
    if(reload == true)
    {
      location.reload();
    }

    if(redirect_url && new_tab == false)
    {
      window.location.href = redirect_url;
    }

    if(redirect_url && new_tab == true)
    {
      window.open(redirect_url, '_blank');
    }

  });
}

function success_popup(msg = null,reload = false,redirect_url = false,new_tab = false)
{
  Notiflix.Report.Success('Success',msg,false,function(){
    if(reload == true)
    {
      location.reload();
    }

    if(redirect_url && new_tab == false)
    {
      window.location.href = redirect_url;
    }

    if(redirect_url && new_tab == true)
    {
      window.open(redirect_url, '_blank');
    }
  });
}

function confirm_popup(url = null,confirm_msg = 'Want to delete')
{
  Notiflix.Confirm.Show('Are you sure?', confirm_msg, false, false,
    function()
    {
      window.location.href=url;
    },
  );
}


function get_token()
{
  return $('input[name=_token]').val();
}

function price_update(url, title='', text='') {
    var title = (title) ? title : 'Delete Record';
    var text = (text) ? text : 'Do you want to delete this record ?';

    swal({
      title: "An input!",
      text: "Write something interesting:",
      type: "input",
      showCancelButton: true,
      closeOnConfirm: false,
      inputPlaceholder: "Write something"
    }, function (inputValue) {
      if (inputValue === false) return false;
      if (inputValue === "") {
        swal.showInputError("You need to write something!");
        return false
      }
      swal("Nice!", "You wrote: " + inputValue, "success");
    });
    

    // swal({
    //     title: title,
    //     text: text,
    //     type: false,
    //     allowOutsideClick: true,
    //     showConfirmButton: true,
    //     showCancelButton: true,
    //     confirmButtonClass: 'btn-danger',
    //     cancelButtonClass: 'btn-primary',
    //     closeOnConfirm: true,
    //     closeOnCancel: true,
    //     confirmButtonText: 'Yes',
    //     cancelButtonText: "Cancel",
    //     content: {
    //       element: "input",
    //       attributes: {
    //         placeholder: "Type your password",
    //         type: "password",
    //       },
    //     },
    //   },
    //     function (t) {
    //         if (t) {
    //             window.location.href = url;
    //         }
    //     });

    return false;
}








