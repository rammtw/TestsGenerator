@extends('layouts.interface')

@section('title')
    Новый предмет
@stop

@section('content')
    <div class="jumbotron">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                @if(Session::has('message'))
                    <p class="bg-success" style="padding:15px;">{{ Session::get('message') }}</p>
                @endif
                {{ Form::open(array('action' => 'TestController@createSubject')) }}
                    <div class="form-group">
                        <label for="name">Название предмета</label>
                        <input type="text" class="form-control" name="name">
                    </div>
                    <button type="submit" class="btn btn-success">Сохранить</button>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@stop