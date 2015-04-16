@extends('layouts.interface')

@section('title')
    Предметы
@stop

@section('content')
    <div class="jumbotron">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                @if(!$subjects->isEmpty())
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>№ п/п</th>
                            <th>Название</th>
                            <th>Количество тестов</th>
                        </tr>
                    </thead>
                    @foreach ($subjects as $key => $subject)
                        <tr class="clickableRow" style="cursor:pointer;" href="/test/subject/{{ $subject->id }}">
                            <td>{{ $key+1 }}</td>
                            <td>{{ $subject->name }}</td>
                            <td>{{ $subject->tests()->count() }}</td>
                        </tr>
                    @endforeach
                </table>
                @else
                <p>Пока предметов нет.</p>
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