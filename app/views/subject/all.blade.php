@extends('layouts.interface')

@section('title')
    Предметы
@stop

@section('content')
    <div class="jumbotron">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>№ п/п</th>
                            <th>Название</th>
                            <th>Количество тестов</th>
                        </tr>
                    </thead>
                    @foreach ($subjects as $key => $subject)
                        <tr>
                            <td>{{ $key }}</td>
                            <td>{{ $subject->name }}</td>
                            <td>{{ $subject->tests()->count() }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@stop