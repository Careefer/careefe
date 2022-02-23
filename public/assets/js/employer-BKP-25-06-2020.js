/* Start code for admin panel*/

function re_display_title()
{
    $('.branch_code_section').each(function(index,el){

        obj = $(this);

        num = index+parseInt(1);

        obj.find('strong').html('Branch Office '+num);
        obj.find('input').eq(0).attr('name','branch_office_'+index);

    });
}

function add_more_branch_office(el)
{
    var total_branch_office = $('.branch_code_section').length+1;

    var index = $('.branch_code_section').length;

    html = `<div class="form-group form-md-line-input has-info branch_code_section">
                <input class="form-control" name="branch_office_`+index+`" type="text" id="branch_office" value="" placeholder="Enter branch office here...">
                <input type="hidden" name="temp[]">
                <label for="branch_office">
                    <strong>Branch Office `+total_branch_office+`</strong>
                </label>
                <div class="remove-btn">
                    <button type="button" class="btn btn-danger" onclick="remove_branch_office($(this));">X Remove</button>
                </div>
            </div>`;
    
    $('.add-more-btn').before(html);            
}

function remove_branch_office(el)
{
    el.parents('.branch_code_section').remove();
    re_display_title();
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

               Notiflix.Notify.Failure(FORM_ERROR_MSG);
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
            btn_enable('#emp_signup_btn','Register');
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

    console.log(state_optoins); return false;
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

function rest_rest_country_city_html()
{    
    if($('.form-outer-wrapper .container-form').length > 1)
    {
        $(".form-outer-wrapper .container-form").not(".container-form:first").remove();    
    }
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