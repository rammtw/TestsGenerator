@extends('layouts.interface')

@section('title')
    Создание теста
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
            @if(!empty($subjects))
            <div class="col-md-6 col-md-offset-3">
                {{ Form::open(array('action' => 'TestController@doAction')) }}
                    <div class="form-group">
                        <label for="name">Название теста</label>
                        <input type="text" class="form-control" name="name">
                    </div>
                    <div class="form-group">
                        <label for="subject">Предмет</label>
                        {{ Form::select('subject_id', $subjects, null, array('class' => 'form-control')) }}
                    </div>
                    <button type="submit" class="btn btn-success" name="action" value="create">Сохранить</button>
                {{ Form::close() }}
            </div>
            @else
            <p>Создайте сначала предметы.</p>
            <button class="btn btn-success" onclick="window.location.href='/test/subject/new'">Новый предмет</button>
            @endif
        </div>
    </div>
@stop