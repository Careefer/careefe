function get_token()
{
  return $('input[name=_token]').val();
}

function loadAjaxSuggestionSelect2(){
  var ajaxSuggCl = $('.loadAjaxSuggestion');
  ajaxSuggCl.each(function(ind,el){
    $(this).select2({
      placeholder: "City, State or Country", 
      ajax: {
        url: site_url.replace("admin", "")+"/location_suggestion",
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

$(window).load(function()
{   
    if($('.careefer-date-picker').length > 0)
    {
        $('.careefer-date-picker').datepicker({
            autoclose:true,
            format:date_picker_format
        });
    }

    if($('#create_city_form').length)
    {
        country_id = $('#country_id').val();

        if(country_id)
        {
            get_state(country_id);
        }
    }

    if($('.careefer-select2').length > 0)
    { 
        var placeholder = 'Enter';
        if(typeof $(this).data('placeholder') !== 'undefined')
        {
            placeholder = $('.careefer-select2').data('placeholder');
        }

        $('.careefer-select2').select2({
            placeholder: placeholder,
        });
    }

    if($('.loadAjaxSuggestion').length > 0)
    {
      loadAjaxSuggestionSelect2();
    }
});


function get_state(country_id)
{
    $.ajax({
        'url'       : site_url+'/location/cities/get_state/'+country_id,
        'method'    : 'get',
        success     : function(html)
        {
            $('#state_id').html(html).selectpicker('refresh');
        },
        error       : function(error)
        {
            alert('Error something went wrong. Please try after sometime');
            //location.reload();
            
        }
    });
}

function get_states(country_id)
{
    $.ajax({
        'url'       : site_url+'/jobs/get_state/'+country_id,
        'method'    : 'get',
        success     : function(html)
        {
            $('#state_id').html(html);
        },
        error       : function(error)
        {
            alert('Error something went wrong. Please try after sometime');
            //location.reload();
            
        }
    });
}

function get_cities(state_id,el)
{   
    el.parents('.form-group').next('.form-group').find('.add_job_city')
    $.ajax({
        'url'       : site_url+'/jobs/get_city/'+state_id,
        'method'    : 'get',
        success     : function(html)
        {
            //$('#city_id').html(html).selectpicker('refresh');
            el.parents('.form-group').next('.form-group').find('select').html(html);
        },
        error       : function(error)
        {
            alert('Error something went wrong. Please try after sometime');
            //location.reload();
            
        }
    });
}

function get_specialists(functional_id)
{
    $.ajax({
        'url'       : site_url+'/jobs/get_specialist/'+functional_id,
        'method'    : 'get',
        success     : function(html)
        {
            $('#primary_specialist').html(html);
            $('#secondary_specialist').html(html);
        },
        error       : function(error)
        {
            error_popup(SERVER_ERR_MSG);
        }
    });
}


function init_state_ajax(el)
{   
    country_id = el.val();
    get_state(country_id);    
}

function init_states_ajax(el)
{   
    country_id = el.val();

    if($('.country-state-city-wrap').length > 0)
    {
       $('.country-state-city-wrap').remove();

       var add_more_btn = `
                            <div class="col-md-3 btn-action">
                                <button type="button" class="btn btn-primary emp-add-more" onclick="admin_job_add_more_location($(this));">+Add more</button>
                            </div>
                            `;
        $('#location_add_more_wrap').find('.form-group:last').append(add_more_btn);
    }

    get_states(country_id);    
}

function init_cities_ajax(el)
{   
    state_id = el.val();
    get_cities(state_id,el);    
}

function fetch_specialist_ajax(el)
{

    functional_id = el.val();

    get_specialists(functional_id);  
}


function admin_job_add_more_location(el)
{   
    country_id = $('select[name=add_job_country]').val();
    state_id = $('.add_job_sates').val();

    if(country_id == null)
    {
        alert('Please select country');
        return false;
    }

    if(state_id == "")
    {
        alert('Please select state');
        return false;
    }

    selected_country = $('select[name=add_job_country]').find(':selected').html().trim();
    state_optoins = $('#state_id').html();

    var html = `
                <div class="country-state-city-wrap">
                    <div class="form-group">
                        <label class="control-label col-md-3">Country
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6">
                            <div class="input-icon right">
                                <select class="form-control careefer-select2 disabled" disabled="disabled">
                                <option >`+selected_country+`</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">State
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6">
                            <div class="input-icon right">
                                <input type="hidden" name="temp[]">
                                <select data-placeholder="" class="form-control careefer-select2 add_job_sates" onchange="init_cities_ajax($(this));" >
                                `+state_optoins+`
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">City
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6">
                            <div class="input-icon right select-group careefer-select2-multiple">
                                <select data-placeholder="" class="form-control careefer-select2 add_job_city" multiple>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 btn-action">
                            <button type="button" class="btn btn-primary emp-add-more" onclick="admin_job_add_more_location($(this));">+Add more</button>
                            <button type="button" class="btn btn-danger btn-rm" onclick="job_more_location_remove($(this))">-Remove</button>
                        </div>
                    </div>
                </div>                    
                `;                            

    $("#location_add_more_wrap").append(html);
    $("#location_add_more_wrap").find('.add_job_sates:last').val('');
    

    el.remove();

    $('.careefer-select2').select2();

    //$('.bs-select').selectpicker('refresh');

    $('.add_job_sates').each(function(key,val){
        $(this).attr('name','state_id['+key+']')
    });

    $('.add_job_city').each(function(key,val){
        $(this).attr('name','city_id['+key+'][]')
    });


}

function job_more_location_remove(el)
{   
    if($('.country-state-city-wrap').length > 0)
    {   
        el.parents('.country-state-city-wrap').remove();
        /*$("#location_add_more_wrap").find('.country-state-city-wrap:last').remove();*/

        var add_more_btn = `
                            <div class="col-md-3 btn-action">
                                <button type="button" class="btn btn-primary emp-add-more" onclick="admin_job_add_more_location($(this));">+Add more</button>
                                <button type="button" class="btn btn-danger btn-rm" onclick="job_more_location_remove($(this))">-Remove</button>
                            </div>
                            `;

        $('#location_add_more_wrap').find('.btn-action:last').remove();
        $('#location_add_more_wrap').find('.form-group:last').append(add_more_btn);

        if($('.country-state-city-wrap').length < 1)
        {
            $('.btn-rm').remove();
        }
    }

}


function change_status(db_table, column, column_val, status, html_table_id ='datatable_ajax')
{    
    $('#NotiflixNotifyWrap').remove();

    var ajax_resp = null;
    if (ajax_resp) {
        ajax_resp.abort();
    }
    ajax_resp = $.ajax({
        url: site_url + '/dashboard/change_status?db_table=' + db_table + '&column=' + column + '&column_value=' + column_val + '&status=' + status,
        dataType: 'JSON',
        method: 'GET',
        success: function (resp) {
            if (resp.success == true)
            {   
                Notiflix.Notify.Success("Status changed successfully");

                $('#' + html_table_id).DataTable().ajax.reload();
            }
            else if (resp.success == false)
            {
                Notiflix.Notify.Failure(resp.msg);
                location.reload();
            }
        },
        error: function ()
        {
            Notiflix.Notify.Failure('Error something went wrong');
            location.reload();
        }
    });
}

function confirmation(url, title='', text='') {
    var title = (title) ? title : 'Delete Record';
    var text = (text) ? text : 'Do you want to delete this record ?'; 
    swal({
        title: title,
        text: text,
        type: false,
        allowOutsideClick: true,
        showConfirmButton: true,
        showCancelButton: true,
        confirmButtonClass: 'btn-danger',
        cancelButtonClass: 'btn-primary',
        closeOnConfirm: true,
        closeOnCancel: true,
        confirmButtonText: 'Yes',
        cancelButtonText: "Cancel"
    },
        function (t) {
            if (t) {
                window.location.href = url;
            }
        });

    return false;
}

function add_edit_ajax(btn_id,frm_id,url)
{       
    $.ajax({
        'url'       : site_url+url,
        'data'      : $('#'+frm_id).serialize(),
        'method'    : 'post',
        'dataType'  : 'json',
        beforeSend  : function()
        {
            btn_disable('#'+btn_id);
            $('.err-msg').remove();
        },
        success     : function(resp)
        {
            if(resp.status == 'failed' && resp.type == 'validation')
            {   
               Notiflix.Notify.Failure(FORM_ERROR_MSG);

                $.each(resp.msg,function(input,msg)
                { 
                    $("select[name='"+input+"']").parents('.select-group').after('<span class="err-msg"><p class="help-block">'+msg+'</p></span>');
                    $("input[name='"+input+"']").after('<span class="err-msg"><p class="help-block">'+msg+'</p></span>');
                    $("textarea[name='"+input+"']").after('<span class="err-msg"><p class="help-block">'+msg+'</p></span>');
                });
            }
            else if(resp.status == 'failed' && resp.type == 'error')
            {
               error_popup(resp.msg);
            }
            else if(resp.status == 'success')
            {   
                window.location.href=site_url+'/jobs';
            }
            else if(resp.status == 'failed')
            {
               error_popup(SERVER_ERR_MSG);
            }
        },
        error       : function(error)
        {
            error_popup(SERVER_ERR_MSG);
        },
        complete    : function()
        {
            btn_enable('#'+btn_id,'Submit');
        }


    });
}

function add_job(btn_id,frm_id)
{   
    url ='/jobs/store';
    add_edit_ajax(btn_id,frm_id,url);
}

function edit_job(btn_id,frm_id,edit_id)
{
    url ='/jobs/job/'+edit_id;
    add_edit_ajax(btn_id,frm_id,url);  
}


function submit_form(obj_btn, obj_form , show_loder_only = false)
{   

    if(obj_form.data('parsley-validate'))
    {   
        obj_form.parsley().validate();

        if(obj_form.parsley().isValid())
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
    }
    else
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

    

}

function redirect_url(obj, url, show_loder_only = false,new_tab = false)
{
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

function btn_enable(btn_id_class,txt)
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