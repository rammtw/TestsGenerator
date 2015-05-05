@extends('layouts.interface')

@section('title')
	{{ $question->title }}
@stop

@section('content')
	<div class="jumbotron">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				@if($errors->all())
					<div class="alert alert-danger">
						@foreach ($errors->all() as $error)
						<p>{{ $error }}</p>
						@endforeach
					</div>
				@endif

				{{ Form::open(array('action' => 'QuestionController@setAnswer')) }}

				<div class="form-group">
					<label for="title">Вопрос</label>
					<input name="title" type="text" class="form-control" value="{{{ $question->title }}}">
				</div>

				<div class="form-group">
					<label for="type">Тип ответов</label>
					<select class="form-control" id="type">
						<option disabled>Выберите тип</option>
						<option value="input" {{ $question->type == 'input' ? 'selected' : '' }}>Текст</option>
						<option value="radio" {{ $question->type == 'radio' ? 'selected' : '' }}>Один из нескольких</option>
						<option value="checkbox" {{ $question->type == 'checkbox' ? 'selected' : '' }}>Несколько правильных</option>
					</select>
				</div>

				<label for="answers">Ответы</label>
				<div id="answers">
				@foreach($question->answers as $key => $answer)
					<div class="form-group has-feedback">
						<input class="form-control" type="text" name="a_indexes[]" value="{{{$answer['answer']}}}" autocomplete="off">
						<a href="/a/delete/{{$answer->id}}" style="color:rgb(166, 0, 0);"><span style="top:0;" class="glyphicon glyphicon-remove form-control-feedback"></span></a>
					</div>
				@endforeach
				</div>

				<button type="submit" class="btn btn-success" style="margin-top:25px;">Сохранить</button>
				{{ Form::close() }}
			</div>
		</div>
	</div>
@stop

@section('script')

<script>
	$('#type').change(function(){
		var count = {
			input: 1,
			radio: 4,
			checkbox: 4
		};

		$('#answers').empty();

		for (var i = 0; i < count[$(this).val()]; i++) {
			$('#answers').append('<div class="form-group"><input class="form-control" type="text" name="a_indexes[]" autocomplete="off"></div>');
		}

		if($(this).val() != 'input'){
			$('#answers').append('<button>add</button>');
		}
	});
</script>

@stop