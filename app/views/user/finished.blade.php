@extends('layouts.interface')

@section('title')
    Пройденные
@stop

@section('content')
    <div class="jumbotron">
        <div class="row">
            @if(!$user_tests->isEmpty())
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>№ п/п</th>
                        <th>Название</th>
                        <th>Правильных</th>
                        <th>Не правильных</th>
                        <th>Оценка</th>
                        <th>Дата начала</th>
                        <th>Дата окончания</th>
                    </tr>
                </thead>
                @foreach ($user_tests as $key => $user_test)
                    <tr class="clickableRow" style="cursor:pointer;" href="/u/finished/{{ $user_test->id }}">
                        <td>{{ $key+1 }}</td>
                        <td>{{ $user_test->test->name }}</td>
                        <td class="text-success">{{ $user_test->total_correct }}</td>
                        <td class="text-danger">{{ $user_test->total_incorrect }}</td>
                        <td>{{ $user_test->rating }}</td>
                        <td>{{ date("H:i:s d.m.Y",strtotime($user_test->created_at)) }}</td>
                        <td>{{ date("H:i:s d.m.Y",strtotime($user_test->updated_at)) }}</td>
                    </tr>
                @endforeach
            </table>
            @else
            <p>Пока тестов нет.</p>
            @endif
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
