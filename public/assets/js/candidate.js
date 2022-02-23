$(document).ready(function() {
    // $('.edit-enable').trigger('click');

    if ($('#specialist_profile_frm').length) {
        $('body').on('keypress keyup change', '#specialist_profile_frm input,#specialist_profile_frm textarea,#specialist_profile_frm select', function() {
            $(this).nextAll('.err_msg').remove();
        });
    }

    if ($('.currently_working_check').length > 0) {
        $(document).on('click', '.currently_working_check', function() {
            $('.currently_working_check').not(this).prop('checked', false);
        });
    }

    if ($('.edu-current-purshing-check').length > 0) {
        $(document).on('click', '.edu-current-purshing-check', function() {
            $('.edu-current-purshing-check').not(this).prop('checked', false);
        });
    }

    /* Rating Js */
    $('#stars li').on('click', function() {
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
        } else {
            msg = ratingValue;
        }

        if (application_id) {
            responseMessage(application_id, msg)
        } else {
            responseMessage(msg);
        }
    });

});

function can_same_permanent_location(el) {
    if (el.prop('checked') == true) {
        $('input[name=p_zip_code]').val($('input[name=c_zip_code]').val());
        $('textarea[name=p_address]').val($('textarea[name=c_address]').val());


        c_location_id = $('select[name=c_location_id]').find(':selected').val();
        c_location_html = $('select[name=c_location_id]').find(':selected').html();

        var html = '<option value="' + c_location_id + '">' + c_location_html + '</option>';

        $('select[name=p_location_id]').html(html);
    }
}

function initialise_currently_working_checkbox() {
    $('.currently_working_check').each(function(key, val) {
        $(this).attr('name', 'currently_working[' + key + ']')
        $(this).attr('id', 'currently_working[' + key + ']')
    });

    $('.working-check').each(function(key, val) {
        $(this).attr('id', 'end[' + key + ']')
    });
}

function initialise_date_picker() {
    $(".datepicker,.end-picker").datepicker({
        showOn: "button",
        buttonImage: site_url + "/assets/web/images/calendar-img.png",
        buttonImageOnly: true,
        changeMonth: true,
        changeYear: true
    });
}

function initialise_edu_locations() {
    $(".new-country-select,.new-state-select,.new-city-select").select2();
}

function initialise_select2() {
    // if($('.careefer-select2').length > 0)
    // {
    //   $('.careefer-select2').select2({
    //         placeholder: "Please select data",
    //   });
    // }

    $('.position').select2({
        tags: true
    });
}

function initialise_job_skill_select_name() {
    $('.work-exp-inner .job-skills-select').each(function(index, val) {
        $(this).attr('name', "job_skills_" + index + "[]")
    });
}
var count = 1;

function can_carrer_add_more() {
    $('.loadAjaxSuggestion').select2('destroy');

    designation_options = $('.designation-select:first').html();

    job_skill_options = $('.job-skills-select:first').html();
    html = `<div class="work-exp-inner">
                <div class="wrap-form-detail">
                  <div class="form-detail clearfix">
                    <div class="form-input">
                      <label>Company</label>
                      <input type="text" name="company[]" placeholder="Sparxit Solutions" onfocus="this.placeholder=''" onblur="this.placeholder='Sparxit Solutions'" maxlength="191">
                    </div>
                    <div class="form-input">
                      <label>Designation</label>
                      <select class="careefer-select2 position" name="designation[]">
                        ` + designation_options + `
                      </select>
                    </div>
                  </div>
                  <div class="form-detail clearfix">
                    <div class="form-input edit-select-wrap">
                        <label>Job Location</label>
                        <select name="job_location_id[]" placeholder="City, State, Country" class="loadAjaxSuggestion">
                          <option value="">- Search location -</option>
                        </select>
                    </div>
                    <div class="form-input">
                      <label>Skills</label>
                      <select class="careefer-select2 skill-dropdown` + count + ` job-skills-select position" multiple="multiple" data-placeholder="Enter Skills Acquired">  
                      ` + job_skill_options + `
                      </select>
                    </div>
                  </div>
                </div>
                <label class="form-label">Roles &amp; Responsibilities</label>
                <div class="add-textarea profile-input">
                  <textarea placeholder="Type...." name="roles_responsibilities[]" maxlength="500"></textarea>
                </div>
                <div class="date-picker-wrapper clearfix">
                  <div class="start-date com-date">
                    <label class="form-label">Start Date</label>
                    <div class="profile-input">
                      <input type="text" name="job_start_date[]" class="datepicker">
                    </div>
                  </div>
                  <div class="end-date com-date working-check">
                    <label class="form-label">End Date</label>
                    <div class="profile-input">
                      <input type="text" class="end-picker" name="job_end_date[]">
                    </div>
                  </div>
                </div>
                <label class="checkbox-container label-check" onclick="checkvalue(event,` + count + `)">I am currently working here
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
                    <textarea placeholder="Type...." maxlength="500" name="additional_information[]"></textarea>
                  </div>
                </div>
            </div>`;
    $('#spc_profile_job_sec').append(html);
    count++;
    initialise_date_picker();

    initialise_select2();

    loadAjaxSuggestionSelect2();

    initialise_job_skill_select_name();

    initialise_currently_working_checkbox();
}

function initialise_currently_purshing_checkbox() {
    $('.edu-current-purshing-check').each(function(key, val) {
        $(this).attr('name', 'currently_pursuing[' + key + ']')
    });

    $('.grade-radio').each(function(key, val) {
        $(this).find('input').attr('name', 'grade[' + key + ']')
    });

}

function can_edu_history_add_more() {
    qualification_options = $('.qualification-select:first').html();
    country_html = $('.edu-country .new-country-select').eq(0).html();

    var html = `<div class="edu-inner">
                  <div class="form-detail clearfix">
                    <div class="form-input edu-input">
                      <label>Qualification</label>
                      <select class="careefer-select2 position" name="qualification[]">
                        ` + qualification_options + `
                      </select>
                    </div>
                    <div class="form-input edu-input">
                      <label>Course</label>
                      <input type="text" name="course[]" placeholder="Enter" maxlength="50">
                    </div>
                  </div>
                  <div class="form-detail clearfix">
                    <div class="form-input edu-input">
                      <label>Institue</label>
                      <input type="text" name="institute[]" placeholder="Enter" maxlength="191">
                    </div>
                    <div class="form-input edu-input">
                      <label>Stream (Degree Specialization)</label>
                      <input type="text" name="degree[]" placeholder="Enter" maxlength="191">
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
                        ` + country_html + `
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
    initialise_select2();
}

function spc_edu_del() {
    if ($('.edu-inner').length > 1) {
        $('.edu-outer').children().last().remove();
    }
}

function spc_job_del() {
    if ($('.work-exp-inner').length > 1) {
        $('#spc_profile_job_sec').children().last().remove();
    }
}

function update_cand_profile() {
    var ajax_resp = null;

    if (ajax_resp) {
        ajax_resp.aboart();
    }

    var formData = new FormData(document.getElementById("candidate_profile_frm"));
    ajax_resp = $.ajax({
        'url': site_url + "/candidate/update-profile",
        'data': formData,
        'type': 'post',
        'dataType': 'json',
        async: true,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function() {
            $('.err_msg,.success_msg').remove();
            $('.form-msg').html('');
            btn_disable('#spc_profile_submit_btn');
            $('.err-msg').remove();
        },
        success: function(resp) {
            console.log(resp);
            if (resp.status == 'failed' && resp.type == 'validation') {
                $.each(resp.msg, function(input, msg) {
                    $("input[name=" + input + "]").after('<span class="err_msg">' + msg + '</span>')
                });
                //$('.form-msg').html('<span class="color-red">Error please check form and fill correct data</span>');
            } else if (resp.status == 'failed' && resp.type == 'date-validation') {
                $('.date-form-msg').after('<span class="err_msg">' + resp.msg + '</span>');
            } else if (resp.status == 'failed') {
                $('.form-msg').html('<span class="color-red">' + SERVER_ERR_MSG + '</span>');
            } else if (resp.status == 'success') {
                //$('.form-msg').html('<span class="success_msg">'+resp.msg+'</span>');

                // if resume draged
                if (formData.has('drag_hidden1')) {
                    obj_dropzone_1.processQueue();
                }

                // if resume draged
                if (formData.has('drag_hidden2')) {
                    obj_dropzone_2.processQueue();
                }

                location.reload();
                $('html, body').animate({
                    scrollTop: $(".main-tabs-content").offset().top
                }, 100);

                /*setTimeout(function(){
                  location.reload();
                },3000)*/
            }

            /*$('html, body').animate({
                scrollTop: $(".main-tabs-content").offset().top
            }, 1000);*/
        },
        error: function(error) {
            console.log(error);
            // return false;
            $('.form-msg').html('<span class="color-red">' + SERVER_ERR_MSG + '</span>');

            $('html, body').animate({
                scrollTop: $(".main-tabs-content").offset().top
            }, 1000);
        },
        complete: function() {
            btn_enable('#spc_profile_submit_btn', 'Save');
        }
    });
}

function make_job_favorite(el, candidate_id, job_id) {
    var ajax_resp = null;

    if (ajax_resp) {
        ajax_resp.aboart();
    }

    el.find('img').after(`<i class="fa fa-circle-o-notch fa-spin temp-loader"></i>`);


    var post_data = { 'candidate_id': candidate_id, 'job_id': job_id, '_token': get_token() };

    ajax_resp = $.ajax({
        'url': site_url + "/candidate/make_job_favorite",
        'data': post_data,
        'type': 'post',
        'dataType': 'json',
        success: function(resp) {
            $('#NotiflixNotifyWrap').remove();

            if (resp.status == 'failed') {
                Notiflix.Notify.Failure(SOMETHING_WENT_WRONG);
            }

            if (resp.status == 'success') {
                Notiflix.Notify.Success(resp.msg);
            }

            el.find('img').attr('src', resp.image);
            $('.temp-loader').remove();
        },
        error: function() {
            error_popup(SERVER_ERR_MSG, true);
        }
    });
}

function radio_check_new_cover_letter_type() {
    if ($('#cl_type_new').length > 0) {
        $('#cl_type_new').prop('checked', true);
    }
}

function radio_check_cv_letter_type() {
    console.log($('#cv_type_new').length);
    if ($('#cv_type_new').length > 0) {
        $('#cv_type_new').prop('checked', true);
    }
}

function onChageType(str, ind) {
    if (str == 'show') {
        $('.file-wrapper').eq(ind).show();
    } else {
        $('.file-wrapper').eq(ind).hide();
    }
}
// apply job
function apply_job(url) {
    var ajax_resp = null;

    if (ajax_resp) {
        ajax_resp.aboart();
    }

    var formData = new FormData(document.getElementById("candidate_apply_job_frm"));

    ajax_resp = $.ajax({
        'url': url,
        'data': formData,
        'type': 'post',
        'dataType': 'json',
        async: true,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function() {
            $('.err_msg,.success_msg').remove();
            $('.form-msg').html('');
            btn_disable('#apply_job_btn');
        },
        success: function(resp) {
            if (resp.status == 'failed' && resp.type == 'validation') {
                $.each(resp.msg, function(input, msg) {
                    $("input[name=" + input + "]").eq(0).after('<span class="err_msg">' + msg + '</span>')
                });

                $('.form-msg').html('<span class="color-red">Please check the form and fill the correct data</span>');
            } else if (resp.status == 'failed') {
                location.reload();
                /*$('.form-msg').html('<span class="color-red">'+resp.msg+'</span>');*/
            } else if (resp.status == 'success') {

                window.p_data_1 = resp.data; // post data for drag request

                /*$('.form-msg').html('<span class="success_msg">'+resp.msg+'</span>');*/

                obj_dropzone_1.processQueue();

                location.reload();
            }

            $('html, body').animate({
                scrollTop: $(".content").offset().top
            }, 1000);
        },
        error: function(error) {
            $('.form-msg').html('<span class="color-red">' + SERVER_ERR_MSG + '</span>');
            $('html, body').animate({
                scrollTop: $(".content").offset().top
            }, 1000);
        },
        complete: function() {
            btn_enable('#apply_job_btn', 'Done');
        }
    });
}

// apply friend job
function apply_friend_job(url) {

    //obj_dropzone_2.processQueue(); return false;

    var ajax_resp = null;

    if (ajax_resp) {
        ajax_resp.aboart();
    }

    var formData = new FormData(document.getElementById("friend_apply_job_frm"));

    ajax_resp = $.ajax({
        'url': url,
        'data': formData,
        'type': 'post',
        'dataType': 'json',
        async: true,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function() {
            $('.err_msg,.success_msg').remove();
            $('.form-msg').html('');
            btn_disable('#apply_job_btn');
        },
        success: function(resp) {
            if (resp.status == 'failed' && resp.type == 'validation') {
                $.each(resp.msg, function(input, msg) {
                    $("input[name=" + input + "]").eq(0).after('<span class="err_msg">' + msg + '</span>')
                });

                $('.form-msg').html('<span class="color-red">Please check the form and fill the correct data</span>');
            } else if (resp.status == 'failed') {
                $('.form-msg').html('<span class="color-red">' + resp.msg + '</span>');
            } else if (resp.status == 'success') {
                window.p_data_1 = resp.data; // post data for drag request
                window.p_data_2 = resp.data; // post data for drag request

                $('.form-msg').html('<span class="success_msg">' + resp.msg + '</span>');

                if (formData.has('drag_hidden1')) {
                    obj_dropzone_1.processQueue();
                }

                if (formData.has('drag_hidden2')) {
                    obj_dropzone_2.processQueue();
                }

                setTimeout(function() {
                    location.reload();
                }, 5000);

            }

            $('html, body').animate({
                scrollTop: $(".content").offset().top
            }, 1000);
        },
        error: function(error) {
            $('.form-msg').html('<span class="color-red">' + SERVER_ERR_MSG + '</span>');
            $('html, body').animate({
                scrollTop: $(".content").offset().top
            }, 1000);
        },
        complete: function() {
            btn_enable('#apply_job_btn', 'Done');
        }
    });
}
