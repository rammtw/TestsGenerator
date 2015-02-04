@extends('layouts.interface')

@section('title')
    Результат - [{{ $test_name }}]
@stop

@section('content')
    <div class="jumbotron" style="text-align:left;">
        <div class="row">
            <p>Название теста: {{ $test_name }}</p>
            <p>Вопросы:</p>
            @foreach ($results as $key => $result)
                <div style="margin-bottom:20px;padding:20px;background-color:#E9E9E9;">
                <p>{{ $key+1 }}. {{ $result['title'] }}</p>
                <p class="text-success">Правильные ответы:</p>
                <ul class="list-style">
                    @foreach ($result['answers'] as $answer)
                        <li>{{ $answer }}</li>
                    @endforeach
                </ul>
                <p class="text-info">Вы отвечали:</p>
                <ul class="list-style">
                    @foreach ($result['user_answers'] as $user_answer)
                        <li>{{ $user_answer }}</li>
                    @endforeach
                </ul>
                <h5>Набрано баллов: [{{ $result['points'] }}]</h5>
                </div>
            @endforeach
            <p>Результаты</p>
            <dl class="dl-horizontal">
              <dt>Набрано баллов</dt>
              <dd class="text-{{ $total['status'] }}">{{ $total['points'] }} ({{ $total['percent'] }}%)</dd>
              <dt>Необходимо</dt>
              <dd class="text-success">{{ $total['max_points'] }}</dd>
              <dt>Оценка</dt>
              <dd class="text-{{ $total['status'] }}">{{ $total['rating'] }}</dd>
            </dl>
        </div>
    </div>
@stop

@section('script')
<script>
    $(".clickableRow").click(function() {
        window.document.location = $(this).attr("href");
    });
    $(".clickableRow").hover(function (){
        $(this).toggleClass("active");
    });
</script>
@stop
