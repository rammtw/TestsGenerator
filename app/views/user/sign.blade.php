@extends('layouts.signin')

@section('title')
    Авторизация
@stop

@section('content')
    {{ Form::open(array('action' => 'UserController@auth', 'class' => 'form-signin')) }}
    	@if(Session::has('error'))
    		<p class="bg-danger" style="padding:15px;">Неверный логин или пароль</p>
    	@endif
    	<h2 class="form-signin-heading">Авторизуйтесь</h2>
    	<input type="login" name="login" class="form-control" placeholder="Логин" required autofocus>
    	<input type="password" name="password" class="form-control" placeholder="Пароль" required>
    	<label class="checkbox">
            <input type="checkbox" name="remember" value="1"> Запомнить
    	</label>
    	<button class="btn btn-lg btn-success btn-block" type="submit">Войти</button>
    	<a href="/reg" class="btn btn-lg btn-primary btn-block" type="button">Нету аккаунта?</a>
    {{ Form::close() }}
@stop