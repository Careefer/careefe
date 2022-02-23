/* Start code for admin panel*/

$(document).ready(function(){
  
  function load() {
    var countryId = $('.country_id').val();
    if(countryId){
        rest_rest_country_city_html(countryId);
    }
  }
  window.onload = load;
  /* 1. Visualizing things on Hover - See next part for action on click */
  $('#stars li').on('mouseover', function(){
    var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on
   
    // Now highlight all the stars that's not after the current hovered star
    $(this).parent().children('li.star').each(function(e){
      if (e < onStar) {
        $(this).addClass('hover');
      }
      else {
        $(this).removeClass('hover');
      }
    });
    
  }).on('mouseout', function(){
    $(this).parent().children('li.star').each(function(e){
      $(this).removeClass('hover');
    });
  });
  
/* Rating Js */
$('#stars li').on('click', function(){
    var onStar = parseInt($(this).data('value'), 10); // The star currently selected
    var stars = $(this).parent().children('li.star');
    
    for (i = 0; i < stars.length; i++) {
      $(stars[i]).removeClass('selected');
    }
    
    for (i = 0; i < onStar; i++) {
      $(stars[i]).addClass('selected');
    }
    
    // JUST RESPONSE (Not needed)
    var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
    var msg = "";
    if (ratingValue > 1) {
        msg = ratingValue;
    }
    else {
        msg = ratingValue;
    }
    responseMessage(msg);
    
  });  
});


function re_display_title()
{
    $('.branch_code_section').each(function(index,el){

        obj = $(this);

        num = index+parseInt(1);

        obj.find('.bo-title').html('Branch Office '+num);
        obj.find('input[type="text"]').eq(0).attr('name','branch_office_'+index);

    });
}

function add_more_branch_office(el)
{
    var total_branch_office = $('.branch_code_section').length+1;

    var index = $('.branch_code_section').length;

    html = `
            <div class="form-group branch_code_section">
                <label class="control-label col-md-3 bo-title">Branch Office `+total_branch_office+`
                    <span class="required">*</span>
                </label>

                <div class="col-md-6">
                    <div class="input-icon select-group right">

                        <select data-parsley-required="branch office" name="branch_office_`+index+`"class="loadAjaxSuggestion" data-placeholder="">
                        </section>

                        <input type="hidden" name="temp[]">
                    </div>
                </div>

                <div class="col-md-3 emp-action-btn">
                    <button type="button" class="btn btn-danger emp-rm" onclick="remove_branch_office($(this));">X Remove</button>
                    <button type="button" class="btn btn-primary emp-add-more" onclick="add_more_branch_office($(this));">+Add more</button>
                </div>

            </div>`;
    
    $('.branch_code_container').append(html);

    el.remove();

    loadAjaxSuggestionSelect2();            
}

function remove_branch_office(el)
{   
    if($('.branch_code_section').length > 1)
    {
        el.parents('.branch_code_section').remove();


        var action_btns = `<div class="col-md-3 emp-action-btn">
                            <button type="button" class="btn btn-danger emp-rm" onclick="remove_branch_office($(this));">X Remove</button>
                            <button type="button" class="btn btn-primary emp-add-more" onclick="add_more_branch_office($(this));">+Add more</button>
                        </div>`;

        $('.branch_code_container').find('.emp-action-btn:last').remove();                
        $('.branch_code_container').find('.branch_code_section:last').append(action_btns);                

        re_display_title();
    }

    if($('.branch_code_section').length < 2)
    {
        $('.emp-rm').remove();
    }
}


/* Start code for website */

function employer_register()
{   
   var ajax_resp = null;

    if(ajax_resp)
    {
        ajax_resp.aboart();
    }

    ajax_resp = $.ajax({
        'url'       : site_url+"/employer/register",
        'data'      : $('#employer_signup').serialize(),
        'method'    : 'post',
        'dataType'  : 'json',
        beforeSend  : function()
        {   
            $('.err_msg,#NotiflixNotifyWrap').remove();
            btn_disable('#emp_signup_btn');
        },
        success     : function(resp)
        {
            if(resp.status == 'failed' && resp.type == 'validation')
            {
                $.each(resp.msg,function(input,msg)
                {  
                    $("select[name='"+input+"']").after('<span class="err_msg">'+msg+'</span>');
                    $("input[name='"+input+"']").after('<span class="err_msg">'+msg+'</span>');
                });

               Notiflix.Notify.Failure('Please complete all mandatory fields.');
            }
            else if(resp.status == 'failed')
            {   
                error_popup(resp.msg,true);
            }
            else if(resp.status == 'success')
            {   
                success_popup(resp.msg,true);
            }
        },
        error       : function(error)
        {       
            error_popup(SERVER_ERR_MSG,true);
        },
        complete    : function()
        {
            btn_enable('#emp_signup_btn','Sign Up');
        }
    }); 
}

function emp_profile_branch_office_delete()
{   
    if($('.emp-profile-other-location').length > 1)
    {
        $(".other-loc-wrapper").children().last().remove();  
    }
}

function emp_profile_branch_office_add_more()
{   
    $('.loadAjaxSuggestion').select2('destroy');
    var html = `<div class="form-input edit-input-wrap">
                    <label>Other Location</label>
                    <select class="loadAjaxSuggestion emp-profile-other-location">
                        <option value="">Enter</option>
                    </select>
                    <input type="hidden" name="temp[]">
                </div>`;

    $('.other-loc-wrapper').append(html);

    $('.emp-profile-other-location').each(function(index,val){
       $(this).attr('name',"location_id_"+index) 
    });

  loadAjaxSuggestionSelect2();
}

function update_company_profile()
{
    var ajax_resp = null;

    if(ajax_resp)
    {
        ajax_resp.aboart();
    }

    ajax_resp = $.ajax({
        'url'       : site_url+"/employer/update_company_profile",
        'data'      : $('#emp_company_profile_frm').serialize(),
        'method'    : 'post',
        'dataType'  : 'json',
        beforeSend  : function()
        {   
            $('.err_msg,success_msg').remove();
            $('.form-msg').html('');
            btn_disable('#emp_profile_submit_btn');
            $('.err-msg').remove();
        },
        success     : function(resp)
        {
            if(resp.status == 'failed' && resp.type == 'validation')
            {
                $.each(resp.msg,function(input,msg)
                {  
                    $("select[name='"+input+"']").after('<span class="err_msg">'+msg+'</span>');
                    $("input[name='"+input+"']").after('<span class="err_msg">'+msg+'</span>');
                });

               $('.form-msg').html('<span class="color-red">Please check the form and fill correct data..!!</span>'); 
            }
            else if(resp.status == 'failed')
            {   
               $('.form-msg').html('<span class="color-red">'+resp.msg+'</span>'); 
            }
            else if(resp.status == 'success')
            {   
               $('.form-msg').html('<span class="success_msg">'+resp.msg+'</span>'); 
            }

            $([document.documentElement, document.body]).animate({
                scrollTop: $(".main-tabs-content").offset().top
            }, 200);
        },
        error       : function(error)
        {
            if(typeof error.statusText != 'undefined')
            {   
                $('.form-msg').html('<span class="color-red">Unexpected error occurred while trying to process your request.!!</span>');
            }
            $([document.documentElement, document.body]).animate({
                scrollTop: $(".main-tabs-content").offset().top
            }, 200);
        },
        complete    : function()
        {
            btn_enable('#emp_profile_submit_btn','Save');
        }
    }); 
}

function emp_job_add_more_location()
{   
    country_id = $('select[name=add_job_country]').val();
    state_id = $('.add_job_sates').val();
    
    if(country_id == "")
    {
        alert('Please select country');
        return false;
    }

    if(state_id == "")
    {
        alert('Please select state');
        return false;
    }

    selected_country = $('select[name=add_job_country]').find(':selected').html();
    state_optoins = $('.add_job_sates').html();

    var html = `<div class="container-form">
                    <div class="form-detail clearfix">
                      <div class="form-input profile-input add-location color">
                        <select disabled="disabled" class="new-country-select" data-search="true" name="country">
                            <option value="">`+selected_country+`</option>
                        </select>
                      </div>
                      <div class="form-input profile-input add-state color">
                        <select class='new-state-select'>
                            `+state_optoins+`
                        </select>
                        <input type="hidden" name="temp[]">
                      </div>
                    </div>
                    <select class='new-city-select' multiple="multiple">
                        <option value="">Select</option>
                    </select>
                </div>`;

    $(".form-outer-wrapper .form-data").append(html);

    $(".new-state-select,.new-city-select,.new-country-select").select2();

    $('.new-state-select').each(function(key,val){
        $(this).attr('name','add_job_state['+key+']')
    });

    $('.new-city-select').each(function(key,val){
        $(this).attr('name','add_job_city['+key+'][]')
    });
}

function rest_rest_country_city_html(sel)
{    
    if($('.form-outer-wrapper .container-form').length > 1)
    {
        $(".form-outer-wrapper .container-form").not(".container-form:first").remove();    
    }

    if(sel.value){
        var countryId = sel.value;
    }
    else{
        var countryId = sel;
    }

    $.ajax({
      url:site_url+'/get_currency/'+countryId,
      type:'get',
      success:function(data){
        if(data.symbol){
         $('.currency-symbol').text(data.symbol);
        }else{
           $('.currency-symbol').text('NA'); 
        }
      }
    })
}

function add_edit_job(url)
{   
    var ajax_resp = null;

    if(ajax_resp)
    {
        ajax_resp.aboart();
    }

    ajax_resp = $.ajax({
        'url'       : url,
        'data'      : $('#emp_job_frm').serialize(),
        'method'    : 'post',
        'dataType'  : 'json',
        beforeSend  : function()
        {   
            $('.err_msg,success_msg').remove();
            $('.form-msg').html('');
            btn_disable('#emp_job_submit_btn');
            $('.err-msg').remove();
        },
        success     : function(resp)
        {   
            var success = false;

            if(resp.status == 'failed' && resp.type == 'validation')
            {
                $.each(resp.msg,function(input,msg)
                { 
                    $("select[name='"+input+"']").after('<span class="err_msg">'+msg+'</span>');
                    $("input[name='"+input+"']").after('<span class="err_msg">'+msg+'</span>');
                    $("textarea[name='"+input+"']").after('<span class="err_msg">'+msg+'</span>');
                });

               $('.form-msg').html('<span class="color-red">Please check the form and fill correct data..!!</span>'); 
            }
            else if(resp.status == 'failed')
            {   
               $('.form-msg').html('<span class="color-red">'+resp.msg+'</span>'); 
            }
            else if(resp.status == 'success')
            {   
                success = true;
                window.location.href=resp.redirect_url;
            }

            if(success == false)
            {
                $([document.documentElement, document.body]).animate({
                    scrollTop: $(".main-tabs-content").offset().top
                }, 200);
            }

        },
        error       : function(error)
        {
            if(typeof error.statusText != 'undefined')
            {   
                $('.form-msg').html('<span class="color-red">Unexpected error occurred while trying to process your request.!!</span>');
            }
            $([document.documentElement, document.body]).animate({
                scrollTop: $(".main-tabs-content").offset().top
            }, 200);
        },
        complete    : function()
        {
            btn_enable('#emp_job_submit_btn','Submit');
        }
    });
}