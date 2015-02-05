@extends('layouts.interface')

@section('title')
    Редактирование теста
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
            @if(!empty($test))
            <div class="col-md-8 col-md-offset-2">
                {{ Form::open(array('action' => 'TestController@doAction')) }}
                    <input name="id" type="hidden" class="form-control" value="{{ $test->id }}">
                    <div class="form-group">
                        <label for="name">Название</label>
                        <input name="name" type="text" class="form-control" id="name" value="{{ $test->name }}">
                    </div>
                    <div class="form-group">
                        <label for="subject">Предмет</label>
                        {{ Form::select('subject_id', $subjects, $test->subject_id, array('class' => 'form-control')) }}
                    </div>
                    <button type="submit" class="btn btn-success" name="action" value="update">Сохранить</button>
                    <button type="submit" class="btn btn-danger" name="action" value="delete">Удалить тест</button>
                    <button type="button" class="btn btn-primary" onclick="window.location.href='/test/q/{{ $test->id }}'">Новый вопрос</button>
                {{ Form::close() }}
            </div>
            @else
            <p>Тест не найден.</p>
            @endif
        </div>
    </div>
@stop