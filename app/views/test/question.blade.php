@extends('layouts.interface')

@section('title')
    Тестирование
@stop

@section('content')
    <div class="jumbotron">
        <div class="row">
            <div class="col-md-9 col-md-offset-2">
                {{ Form::open(array('action' => 'QuestionController@setAnswer')) }}
                <p>{{ $question->title }}</p>

                @foreach($answers as $key => $answer)
                    <div class="{{ $question->type }}">
                        <input type="{{ $question->type }}" name="{{$answer['name']}}" value="{{$answer['id']}}"> {{$answer['answer']}}
                    </div>
                @endforeach

                <button type="submit" class="btn btn-success" style="margin-top:25px;">Далее</button>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@stop