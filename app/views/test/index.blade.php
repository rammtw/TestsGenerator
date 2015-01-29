@extends('layouts.interface')

@section('title')
    Информация
@stop

@section('content')
    <div class="jumbotron">
            <div class="test-info">
               <p>Название теста: {{ $test->name }}</p>
               <p>Количество вопросов: {{ $test->questions_count }}</p>
               <p>Количество баллов: {{ $test->max_points }}</p>
               <p>Время на тест: {{ $test->timer }}</p>
               <button id="begin-test" class="btn btn-primary">Начать тест</button>
            </div>
    </div>
@stop

@section('script')
	<script type="text/javascript">
		$('#begin-test').click(function(){
			$.ajax({
	            type: "POST",
	            url : "/q/p",
	            success : function(data){
	            	if(data.response == 'ok') {
	                	window.location.href="/q/" + data.id;
	            	} else {
	            		$('.test-info').html(data.msg);
	            	}
	            }
	        },"json");
		});
	</script>
@stop