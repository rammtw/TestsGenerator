@extends('layouts.interface')

@section('title')
    Редактирование профиля
@stop

@section('content')
    <div class="jumbotron">
        <div class="row">
            <div class="col-md-6">
                {{ Form::open(array('action' => 'AdminController@update')) }}
                    <input name="id" type="hidden" class="form-control" value="{{ $user->id }}">
                    <div class="form-group">
                        <label for="login">Email</label>
                        <input name="login" type="text" class="form-control" id="login" value="{{ $user->login }}">
                    </div>
                    <div class="form-group">
                        <label for="name">Имя</label>
                        <input name="name" type="text" class="form-control" id="name" value="{{ $user->name }}">
                    </div>
                    <div class="form-group">
                        <label for="last_name">Фамилия</label>
                        <input name="last_name" type="text" class="form-control" id="last_name" value="{{ $user->last_name }}">
                    </div>
                    <div class="form-group">
                        <label for="last_name">Группа</label>
                        {{ Form::select('group_id', $groups, $user->group_id, array('class' => 'form-control')) }}
                    </div>
                    <div class="form-group">
                        <label for="last_name">Роль</label>
                        {{ Form::select('role_id', $roles, $user->role_id, array('class' => 'form-control')) }}
                    </div>
                    <button type="submit" class="btn btn-default">Отправить</button>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@stop