@extends('layouts.signin')

@section('title')
    Регистрация
@stop

@section('content')
    @if ($errors->all())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

	{{ Form::open(array('action' => 'UserController@create', 'class' => 'form-signin')) }}
		<h2 class="form-signin-heading">Регистрация</h2>
		<input type="login" name="login" class="form-control" placeholder="Логин" required autofocus>
		<input type="name" name="name" class="form-control" placeholder="Имя" required>
		<input type="last_name" name="last_name" class="form-control" placeholder="Фамилия" required>
		<input type="password" name="password" class="form-control" placeholder="Пароль" required>
		<input type="password" name="password_confirmation" class="form-control" placeholder="Повторите пароль" required>
		{{ Form::select('group_id', $groups, null, array('class' => 'form-control last')) }}
		<button class="btn btn-lg btn-success btn-block" type="submit">Зарегистрироваться</button>
	{{ Form::close() }}
@stop