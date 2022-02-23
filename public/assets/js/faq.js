function faq_ajax(btn_id,frm_id,url)
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
                $.each(resp.msg,function(key,msg)
                {   
                    if(key == 'status')
                    {
                        $('select[name="'+key+'"]').before(`<span class="err-msg">
                                        <p class="help-block">`+msg+`</p>
                                    </span>`);    
                    }
                    else if(key.startsWith("answer"))
                    {
                        $('textarea[name="'+key+'"]').before(`<span class="err-msg">
                                            <p class="help-block">`+msg+`</p>
                                        </span>`);
   
                    }
                    else
                    {
                        $('input[name="'+key+'"]').before(`<span class="err-msg">
                                            <p class="help-block">`+msg+`</p>
                                        </span>`);

                    }
                });
            }
            else if(resp.status == 'success')
            {
                window.location.href=site_url+'/faqs';
            }
            else if(resp.status == 'failed')
            {
                $('.page-title-here').before(`<div class="alert alert-danger error-new ">
                        <button class="close" data-close="alert"></button>`+resp.msg+`</div>`);
            }
        },
        error       : function(error)
        {
            if(typeof error.statusText != 'undefined')
            {   
                //alert('Error something went wrong. Please contact to admin');
                //location.reload();
            }
        },
        complete    : function()
        {
            btn_enable('#'+btn_id,'Submit');
        }


    });
}


function add_faq(btn_id,frm_id)
{   
    url ='/faqs/store';
    faq_ajax(btn_id,frm_id,url);
}

function edit_faq(btn_id,frm_id,edit_id)
{
    url ='/faqs/faq/'+edit_id;
    faq_ajax(btn_id,frm_id,url);  
}

function faq_remove(el)
{
    el.parents('.ques_section').remove();

    $('#ques_wrapper').find('.ques_section:last').find('.remove-ques-btn').css('right','110px');

    //$('#ques_wrapper').find('.ques_section:last').find('.remove-ques-btn').after('<h1>Hii</h1>');
    
    manage_index();
}

function manage_index()
{
    $('.ques_section').each(function(index,el){
        obj = $(this);

        obj.find('input[name^=question]').attr('name','question['+index+']');
        obj.find('textarea[name^=answer]').attr('name','answer['+index+']');
    });
}

function faq_add_more(el)
{       
    $('.add-more-btn').remove();

    $('.remove-ques-btn').css({'right':'0'});

    var html = `<div class="ques_section">
                    <div class="form-group form-md-line-input has-info">
                            <input class="form-control" name="question[]" type="text"  value="" minlength="1" placeholder="Enter question here...">
                        <label for="question">
                            <strong>Question</strong>
                            <span class="required">*</span>
                        </label>
                    </div>

                    <div class="form-group faq_block_wrap clearfix">
                        <label for="answer">
                            <strong class="text-primary">Answer</strong>
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-12 padding_0">
                            <textarea class="wysihtml5 form-control" rows="6" name="answer[]"></textarea>
                        </div>
                    </div>
                    <div class="remove-ques-btn">
                        <button type="button" class="btn btn-danger" onclick="faq_remove($(this))">-Remove</button>
                    </div>
                </div>`;

    $('#ques_wrapper').append(html);

    var btn = `<div class="add-more-btn" id="add_more_btn">
                <button type="button" class="btn btn-primary"  onclick="faq_add_more($(this));">+Add more</button>
            </div>`;   

    $('#ques_wrapper').append(btn);

    $('#ques_wrapper textarea.wysihtml5:last').wysihtml5();


    manage_index();
}