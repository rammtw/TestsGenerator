@extends('layouts.interface')

@section('title')
    Список тестов
@stop

@section('content')
    <div class="jumbotron">
        @if(Session::has('message'))
            <p class="bg-success" style="padding:15px;">{{ Session::get('message') }}</p>
        @endif
        <div class="bs">
            <button class="btn btn-success" onclick="window.location.href='/test/new'">Новый тест</button>
            <button class="btn btn-success" onclick="window.location.href='/test/subject/new'">Новый предмет</button>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Название</th>
                    <th>Предмет</th>
                    <th>Кол-во вопросов</th>
                    <th>Ред.</th>
                </tr>
            </thead>
            @foreach ($tests as $test)
                <tr>
                    <td>{{ $test->name }}</td>
                    <td>{{ $test->subject }}</td>
                    <td>{{ $test->questions_count }}</td>
                    <td>
                        <img onclick="window.location.href='/test/edit/{{ $test->id }}'" src="../../img/edit-icon.png" style="width:18px;height:18px;cursor:pointer;">
                    </td>
            @endforeach
        </table>
    </div>
@stop