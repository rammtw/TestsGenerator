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
    var status = 'checked disabled';
    var types = {
        "input" : "checkbox",
        "checkbox" : "checkbox",
        "radio" : "radio"
    }

    if(type !== 'input') {
        status = '';
    }

    for(i = parseInt(count)-1; i >= 0; i--) {
        $('.r-num').after('<div class="form-group"><label class="col-sm-2 control-label"><input class="r-index" ' + status + ' type="' + types[type] + '" name="check" value="' + i + '"></label><div class="col-sm-10"><input type="text" class="form-control answers"></div></div>');
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
        r_indexes: [],
        answers: []
    }

    $('.r-index:checked').each(function(e){
        data["r_indexes"].push($(this).val());
    });

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