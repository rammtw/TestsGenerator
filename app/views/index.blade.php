@extends('layouts.interface')

@section('content')
    <div class="jumbotron">
        <h1>Let's Test</h1>
        <p class="lead">Эффективное приложение для проверки знаний.</p>
        @if(!Auth::check())
          <p><a class="btn btn-lg btn-success sign" href="/sign" role="button">Войти</a></p>
        @endif
    </div>
    <div class="row marketing">
        <div class="col-lg-6">
            <h4>Создание групп</h4>
            <p>Возможность разделять студентов на группы.</p>

            <h4>Статистика</h4>
            <p>Результаты тестов сохраняются в профиле.</p>

            <h4>Разделение ролей</h4>
            <p>Управляние тестами, просмотр статистики и дополнительные возможности через профиль администратора.</p>
        </div>

        <div class="col-lg-6">
            <h4>Безопасность</h4>
            <p>Ответы хранятся в базе данных, результат расчитывается после каждого ответа.</p>

            <h4>Subheading</h4>
            <p>Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Cras mattis consectetur purus sit amet fermentum.</p>

            <h4>Subheading</h4>
            <p>Maecenas sed diam eget risus varius blandit sit amet non magna.</p>
        </div>
    </div>
@stop