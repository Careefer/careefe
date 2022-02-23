$(document).ready(function()
{   
    $('.edit-enable').trigger('click');

    if($('#specialist_profile_frm').length)
    {
        $('body').on('keypress keyup change','#specialist_profile_frm input,#specialist_profile_frm textarea,#specialist_profile_frm select',function(){
            $(this).nextAll('.err_msg').remove();
        });
    }

    if($('.currently_working_check').length > 0)
    {
        $(document).on('click', '.currently_working_check', function() {      
          $('.currently_working_check').not(this).prop('checked', false);      
        });
    }


    if($('.edu-current-purshing-check').length > 0)
    {
        $(document).on('click', '.edu-current-purshing-check', function() {      
          $('.edu-current-purshing-check').not(this).prop('checked', false);      
        });
    }
});


$(document).ready(function(){
  
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
    var onStar = parseInt($(this).data('value'), 10);
    var application_id = $(this).data('appid');
     // The star currently selected
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

    if(application_id){
      responseMessage(application_id, msg)
    }else{
      responseMessage(msg);
    }
  });  
});



function spc_same_permanent_location(el)
{ 
   if(el.prop('checked') == true)
   {
      $('input[name=p_zip_code]').val($('input[name=c_zip_code]').val());
      $('textarea[name=p_address]').val($('textarea[name=c_address]').val());
      

      c_location_id   = $('select[name=c_location_id]').find(':selected').val();
      c_location_html = $('select[name=c_location_id]').find(':selected').html();

      var html = '<option value="'+c_location_id+'">'+c_location_html+'</option>';

      $('select[name=p_location_id]').html(html);
   }
}

function initialise_currently_working_checkbox()
{
  $('.currently_working_check').each(function(key,val){
      $(this).attr('name','currently_working['+key+']')
  });
}

function initialise_date_picker()
{
  $( ".datepicker,.end-picker" ).datepicker({
      showOn: "button",
      buttonImage: site_url+"/assets/web/images/calendar-img.png",
      buttonImageOnly: true,
      changeMonth: true,
      changeYear: true,
      yearRange: "-50:+15"
    });
}

function initialise_edu_locations()
{
    $(".new-country-select,.new-state-select,.new-city-select").select2();
}

function initialise_select2()
{
  if($('.careefer-select2').length > 0)
  {
    $('.careefer-select2').select2({
          placeholder: "Please select data",
    });
  }
}

function initialise_job_skill_select_name()
{
  $('.work-exp-inner .job-skills-select').each(function(index,val){
      $(this).attr('name',"job_skills_"+index+"[]")
  });
}

function spc_carrer_add_more()
{   
    $('.loadAjaxSuggestion').select2('destroy');

    designation_options = $('.designation-select:first').html();

    job_skill_options = $('.job-skills-select:first').html();

    html = `<div class="work-exp-inner">
                <div class="wrap-form-detail">
                  <div class="form-detail clearfix">
                    <div class="form-input">
                      <label>Company</label>
                      <input type="text" name="company[]" placeholder="Enter Company Name" onblur="this.placeholder='Enter Company Name'" maxlength="191">
                    </div>
                    <div class="form-input">
                      <label>Position</label>
                      <select class="careefer-select2" name="designation[]" data-placeholder="Enter Position">
                        `+designation_options+`
                      </select>
                    </div>
                  </div>
                  <div class="form-detail clearfix">
                    <div class="form-input edit-select-wrap">
                        <label>Job Location</label>
                        <select name="job_location_id[]" data-placeholder="Enter Job Location"  class="loadAjaxSuggestion">
                          <option value="">- Search location -</option>
                        </select>
                    </div>
                    <div class="form-input">
                      <label>Skills</label>
                      <select class="careefer-select2 job-skills-select" multiple="multiple"  data-placeholder="Enter Skills Acquired">  
                      `+job_skill_options+`
                      </select>
                    </div>
                  </div>
                </div>
                <label class="form-label">Roles &amp; Responsibilities</label>
                <div class="add-textarea profile-input">
                  <textarea placeholder="Describe role and responsibilities" name="roles_responsibilities[]" maxlength="500"></textarea>
                </div>
                <div class="date-picker-wrapper clearfix">
                  <div class="start-date com-date">
                    <label class="form-label">Start Date</label>
                    <div class="profile-input">
                      <input type="text" name="job_start_date[]" class="datepicker">
                    </div>
                  </div>
                  <div class="end-date com-date">
                    <label class="form-label">End Date</label>
                    <div class="profile-input">
                      <input type="text" class="end-picker" name="job_end_date[]">
                    </div>
                  </div>
                </div>
                <label class="checkbox-container label-check">I am currently working here
                  <input type="checkbox" class="currently_working_check">
                  <span class="checkmark"></span>
                </label>
                <label class="form-label">Key Achievements</label>
                <div class="add-textarea profile-input">
                  <textarea placeholder="Summarize Career Highlights" name="key_achievements[]" maxlength="500"></textarea>
                </div>
                <label class="form-label">Additional Information</label>
                <div class="add-text-wrapper">
                  <div class="add-textarea profile-input last-textarea">
                    <textarea placeholder="Anything further you would like to mention" maxlength="500" name="additional_information[]"></textarea>
                  </div>
                </div>
            </div>`;
    $('#spc_profile_job_sec').append(html); 

    initialise_date_picker();

    initialise_select2();

    loadAjaxSuggestionSelect2();

    initialise_job_skill_select_name();
    
    initialise_currently_working_checkbox();   
}

function initialise_currently_purshing_checkbox()
{
  $('.edu-current-purshing-check').each(function(key,val){
      $(this).attr('name','currently_pursuing['+key+']')
  });

  $('.grade-radio').each(function(key,val){
      $(this).find('input').attr('name','grade['+key+']')
  });

}

function spc_edu_history_add_more()
{   
    country_html  = $('.edu-country .new-country-select').eq(0).html();

    var html = `<div class="edu-inner">
                  <div class="form-detail clearfix">
                    <div class="form-input edu-input">
                      <label>Qualification</label>
                      <input type="text" name="qualification[]" placeholder="Diploma, Bachelor, Masters, Post Doctoral Degree, etc." maxlength="50">
                    </div>
                    <div class="form-input edu-input">
                      <label>Course</label>
                      <input type="text" name="course[]" placeholder="Enter Course Name" maxlength="50">
                    </div>
                  </div>
                  <div class="form-detail clearfix">
                    <div class="form-input edu-input">
                      <label>Institue</label>
                      <input type="text" name="institute[]" placeholder="University, College Name, etc." maxlength="191">
                    </div>
                    <div class="form-input edu-input">
                      <label>Specialization</label>
                      <input type="text" name="degree[]" placeholder="Enter Specialization(s)" maxlength="191">
                    </div>
                  </div>
                  <div class="form-detail clearfix">
                    <div class="form-input edu-input">
                      <div class="grade-type clearfix">
                        <label class="grade-label">Grade</label>
                        <div class="radio-wrapper clearfix grade-radio">
                          <label class="radio-container">GPA
                            <input type="radio" name="grade[]" checked="checked" value="gpa">
                            <span class="radio-checkmark"></span> </label>
                          <label class="radio-container">Percentage
                            <input type="radio" name="grade[]" value="percentage">
                            <span class="radio-checkmark"></span> </label>
                        </div>
                      </div>
                      <input type="text" name="grade_data[]" placeholder="Enter">
                    </div>
                    <div class="form-input profile-input edu-country">
                      <label>Country</label>
                      <select class="new-country-select" placeholder="Enter" data-search="true" name="edu_country_ids[]">
                        `+country_html+`
                      </select>
                    </div>
                  </div>
                  <div class="form-detail clearfix end-inner-wrapper">
                    <div class="form-input profile-input edu-country">
                      <label>State</label>
                      <select class='new-state-select' placeholder="Enter" name="edu_state_ids[]">
                      <option value="">Enter</select>
                      </select>
                    </div>
                    <div class="form-input profile-input edu-country">
                      <label>City</label>
                      <select class='new-city-select' placeholder="Enter" name="edu_city_ids[]">
                      <option value="">Enter</option>
                      </select>
                    </div>
                  </div>
                  <div class="date-picker-wrapper clearfix">
                    <div class="start-date com-date">
                      <label class="form-label">Start Date</label>
                      <div class="profile-input">
                        <input type="text" class="datepicker" name="edu_start_date[]">
                      </div>
                    </div>
                    <div class="end-date com-date">
                      <label class="form-label">End Date</label>
                      <div class="profile-input">
                        <input type="text" class="datepicker" name="edu_end_date[]">
                      </div>
                    </div>
                  </div>
                  <label class="checkbox-container label-check">I am currently pursuing
                    <input type="checkbox" class="edu-current-purshing-check" name="currently_pursuing[0]">
                    <span class="checkmark"></span> </label>
                  <div class="stream-wrapper clearfix">
                    <label class="form-label">Stream/Specialization</label>
                    <div class="stream-outer">
                      <div class="inner-stream">
                        <div class="profile-input stream-input">
                          <input type="text" placeholder="Type...." name="specialization[]" maxlength="255">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>`;
    $('.edu-outer').append(html);
    initialise_currently_purshing_checkbox();
    initialise_date_picker();
    initialise_edu_locations();
}

function spc_edu_del()
{   
    if($('.edu-inner').length > 1)
    {
        $('.edu-outer').children().last().remove();
    }
}

function spc_job_del()
{
  if($('.work-exp-inner').length > 1)
  {
    $('#spc_profile_job_sec').children().last().remove();
  }
}

function update_spc_profile()
{  
    var ajax_resp = null;

    if(ajax_resp)
    {
        ajax_resp.aboart();
    }

    var formData = new FormData(document.getElementById("specialist_profile_frm"));

    ajax_resp = $.ajax({
        'url'       : site_url+"/specialist/update_profile",
        'data'      : formData,
        'method'    : 'post',
        'dataType'  : 'json',
        async: true,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend  : function()
        {   
            $('.err_msg,.success_msg').remove();
            btn_disable('#spc_profile_submit_btn');
            $('.err-msg').remove();
        },
        success     : function(resp)
        {
            if(resp.status == 'failed' && resp.type == 'validation')
            {
                $.each(resp.msg,function(input,msg)
                {   
                    $("input[name="+input+"]").after('<span class="err_msg">'+msg+'</span>')
                });
            }
            else if(resp.status == 'failed')
            {               
                $('.form-msg').html('<span class="color-red">'+SERVER_ERR_MSG+'</span>');
            }
            else if(resp.status == 'success')
            {   
              if(formData.has('drag_hidden1'))
              {
                obj_dropzone_1.processQueue();
              }

              $('.form-msg').html('<span class="success_msg">'+resp.msg+'</span>');
            }

            $('html, body').animate({
                scrollTop: $(".main-tabs-content").offset().top
            }, 1000);
        },
        error       : function(error)
        { 
            $('.form-msg').html('<span class="color-red">'+SERVER_ERR_MSG+'</span>');
            
            $('html, body').animate({
                scrollTop: $(".main-tabs-content").offset().top
            }, 1000);
        },
        complete    : function()
        {
            btn_enable('#spc_profile_submit_btn','Save');
        }
    });
}

