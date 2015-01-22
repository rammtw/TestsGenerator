@extends('layouts.interface')

@section('title')
    Пройденные
@stop

@section('script')
<script>
    jQuery(document).ready(function($) {
          $(".clickableRow").click(function() {
                window.document.location = $(this).attr("href");
          });
          $(".clickableRow").hover(function (){
                $(this).toggleClass("active");
           });
    });
</script>
@stop

@section('content')
    <div class="jumbotron">
        <div class="row">
            @if(!empty($tests))
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Название</th>
                        <th>Правильных</th>
                        <th>Не правильных</th>
                        <th>Оценка</th>
                        <th>Дата начала</th>
                        <th>Дата окончания</th>
                    </tr>
                </thead>
                @foreach ($tests as $test)
                    <tr class="clickableRow" style="cursor:pointer;" href="/u/result/{{ $test->id }}">
                        <td>{{ $test->name }}</td>
                        <td class="text-success">{{ $test->total_correct }}</td>
                        <td class="text-danger">{{ $test->total_incorrect }}</td>
                        <td>{{ $test->rating }}</td>
                        <td>{{ $test->created_at }}</td>
                        <td>{{ $test->updated_at }}</td>
                    </tr>
                @endforeach
            </table>
            @else
            <p>Пока тестов нет.</p>
            @endif
        </div>
    </div>
@stop