@extends('layouts.interface')

@section('title')
    Новый вопрос
@stop

@section('content')
    <div class="jumbotron">
        <div class="row">
            @if($errors->all())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            <div class="col-md-10 col-md-offset-1">
                <form id="question-form">
                    <div class="form-group">
                        <label for="title">Название вопроса</label>
                        <input type="text" class="form-control" id="title" placeholder="Введите сюда название вопроса">
                    </div>
                    <div class="form-group">
                    	<label for="answer-count">Количество ответов</label>
                    	<input type="text" class="form-control" id="answer-count" placeholder="Количество ответов">
                    </div>
                    <div class="form-group">
                        <label for="type">Тип ответов</label>
                        <select class="form-control" id="type" id="type">
                        	<option disabled>Выберите тип</option>
                            <option value="input">Текст</option>
                            <option value="radio">Один из нескольких</option>
                            <option value="checkbox">Несколько вариантов</option>
                        </select>
                    </div>
                    <button type="button" id="next-step" class="btn btn-success btn-sm" disabled>Далее</button>
                </form>
                <div class="form-horizontal" style="display:none;">
                	<p id="question"></p>
            		<div class="form-group r-num">
            			<label class="col-sm-7 control-label">
            				Номер правильного ответа:
            			</label>
            			<div class="col-sm-3">
            				<input type="text" class="form-control r-index">
            			</div>
            		</div>
            		<button id="save" class="btn btn-success btn-sm" disabled>Сохранить</button>
      	        </div>
            </div>
        </div>
    </div>
@stop

@section('script')
<script>
    $('#next-step').click(function(){
    	$('#question-form').fadeOut(200);
    	$('#question').text($("#title").val());
    	$('.form-horizontal').fadeIn(200);
    	var count = $('#answer-count').val();
    	var type = $('#type').val();

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

	$('#question-form').keyup(doCheck).focusout(doCheck);
	$('.form-horizontal').keyup(doCheck).focusout(doCheck);

    $('#save').click(function (){
    	var data = {
    		_token: "{{ csrf_token() }}",
    		title: $('#title').val(),
    		type: $('#type').val(),
    		answers: [],
    		r_index: $('.r-index').val()
    	}

    	$('.answers').each(function(){
    		data["answers"].push($(this).val());
    	});

        $.ajax({
            type: "POST",
            url: "/test/q/create",
            data: data,
            success: function(r) {
            	console.log('ye');
            }
        }, "json");
    });
</script>
@stop