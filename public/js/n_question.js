$('#type').change(function() {
    var type = $(this).val();
    switch(type){
        case 'radio':
        case 'checkbox':
            $('#answer-count').prop("disabled", false);
            break;
        default: 
            $('#answer-count').prop("disabled", true).val('1');
            break;
    }
});

$('#next-step').click(function(){
    $('#question-form').fadeOut(200);
    $('#question').text($("#title").val());
    $('.form-horizontal').fadeIn(200);
    var count = $('#answer-count').val();
    var type = $('#type').val();

    if(type !== 'input') {
        $('.r-index').prop("disabled", false).val('');
    }

    for(i = parseInt(count); i > 0; i--) {
        $('.r-num').after('<div class="form-group"><label class="col-sm-2 control-label">' + i + '</label><div class="col-sm-10"><input type="text" class="form-control answers"></div></div>');
    }
});

function doCheck(){
    var allFilled = true;
    $(this).find('input').each(function(){
        if($(this).val() == ''){
            allFilled = false;
            return false;
        }
    });
    $(this).find("button").prop('disabled', !allFilled);
}

$('.r-index').keyup(function(){
    var num = parseInt($(this).val());
    var allowed_num = $('#answer-count').val();

    if(!Number.isInteger(num) || num > allowed_num) {
        $(this).val('');
    }

    $('.answers').each(function(i){
        $(this).css("border-color", "#FF8B8B");

        if(num ===  i+1) {
            $(this).css("border-color", "green");
        }
    });
});

$('#question-form').keyup(doCheck).focusout(doCheck);
$('.form-horizontal').keyup(doCheck).focusout(doCheck);

$.ajaxSetup({
    headers: {
        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
    }
});

$('#save').click(function (){
    var data = {
        _token: "{{ csrf_token() }}",
        title: $('#title').val(),
        type: $('#type').val(),
        r_index: $('.r-index').val(),
        answers: []
    }

    $('.answers').each(function(){
        data["answers"].push($(this).val());
    });

    $.ajax({
        type: "POST",
        url: "/test/q/create",
        data: data,
        success: function(data) {
            if(data.response == 'ok') {
                $('.col-md-10').html('<button type="button" class="btn btn-primary btn-sm" onclick="location.reload();" style="margin-right:10px;">Добавить еще</button><button type="button" class="btn btn-sm" onclick="window.location.href=\'/test/my\'">Перейти к списку тестов</button>');
            }
        }
    }, "json");
});