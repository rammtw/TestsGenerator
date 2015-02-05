@extends('layouts.interface')

@section('title')
    Список тестов
@stop

@section('content')
    <div class="jumbotron">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                @if(!$tests->isEmpty())
                <p>Предмет: {{ $subject->name }}</p>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>№ п/п</th>
                            <th>Название</th>
                            <th>Количество вопросов</th>
                            <th>Количество баллов</th>
                        </tr>
                    </thead>
                    @foreach ($tests as $key => $test)
                        <tr class="clickableRow @if($test->questions_count > 0) success @else danger @endif" style="cursor:pointer;" href="/test/{{ $test->id }}">
                            <td>{{ $key+1 }}</td>
                            <td>{{ $test->name }}</td>
                            <td>{{ $test->questions_count }}</td>
                            <td>{{ $test->max_points }}</td>
                        </tr>
                    @endforeach
                </table>
                @else
                <p>Пока тестов нет.</p>
                @endif
            </div>
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