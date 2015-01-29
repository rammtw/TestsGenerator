@extends('layouts.interface')

@section('title')
    Люди
@stop

@section('content')
    <div class="jumbotron">
        @if(Session::has('message'))
            <p class="bg-success" style="padding:15px;">{{ Session::get('message') }}</p>
        @endif
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Логин</th>
                    <th>Имя</th>
                    <th>Фамилия</th>
                    <th>Дата регистрации</th>
                    <th>Группа</th>
                    <th>Роль</th>
                    <th>Ред.</th>
                </tr>
            </thead>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->login }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->last_name }}</td>
                    <td>{{ date("H:i:s d.m.Y",strtotime($user->register_date)) }}</td>
                    <td>{{ $user->group->name }}</td>
                    <td>{{ $user->role->type }}</td>
                    <td>
                        <img onclick="window.location.href='/admin/edit/{{ $user->id }}'" src="../../img/edit-icon.png" style="width:18px;height:18px;cursor:pointer;">
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@stop