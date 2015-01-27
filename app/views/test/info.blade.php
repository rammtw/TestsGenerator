@extends('layouts.interface')

@section('title')
    Информация
@stop

@section('script')
	<script type="text/javascript">
		var prepare = function (id) {
			var dataString = '_token={{ csrf_token() }}';
			$.ajax({
	            type: "POST",
	            url : "/q/p",
	            data : dataString,
	            success : function(data){
	            	if(data.response == 'ok') {
	                	window.location.href="/q/" + data.id;
	            	} else {
	            		$('.test-info').html(data.msg);
	            	}
	            }
	        },"json");
		}
	</script>
@stop

@section('content')
    <div class="jumbotron">
            <div class="test-info">
               <p>Название теста: {{ $test->name }}</p>
               <p>Количество вопросов: {{ $test->questions_count }}</p>
               <p>Время на тест: {{ $test->timer }}</p>
               <button onclick="prepare({{ $test->id }})">Начать тест</button>
            </div>
    </div>
@stop