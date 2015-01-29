<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('title', 'Главная')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap core CSS -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">

    @section('css')
        <!-- Custom styles for this template -->
        <link href="../../css/jambotron-narrow.css" rel="stylesheet">
    @show

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

  </head>

  <body>

    <div class="container">
        <div class="header">
            @section('menu')
                <ul class="nav nav-pills pull-right" role="navigation">
                    <li class="{{ Request::is('/') ? 'active' : '' }}"><a href="/">Главная</a></li>
                    @if(User::isAdmin())
                        <li class="{{ Request::is('admin/people') ? 'active' : '' }}"><a href="/admin/people">Админ панель</a></li>
                    @endif
                    @if(User::isTeacher() || User::isAdmin())
                        <li class="{{ Request::is('test/my') ? 'active' : '' }}"><a href="/test/my">Тесты</a></li>
                    @endif
                    <li class="dropdown">
                        <a href="#" id="drop2" role="button" class="dropdown-toggle" data-toggle="dropdown">Моё<b class="caret"></b></a>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="drop2">
                            <li><a tabindex="-1" href="/test/subject/all">Все тесты</a></li>
                            <li><a tabindex="-1" href="/u/finished">Пройденные тесты</a></li>
                            <li><a tabindex="-1" href="#">Действие 3</a></li>
                            <li class="divider"></li>
                            <li><a tabindex="-1" href="#">Действие 4</a></li>
                        </ul>
                    </li>
                    @if(Auth::check())
                        <li><a href="/logout">Выйти</a></li>
                    @endif
                </ul>
            @show

            <h3 class="text-muted">@yield('logo', 'Project')</h3>
        </div>

        @yield('content')

        <div class="footer">
            <p>&copy; rammtw 2014</p>
        </div>

    </div> <!-- /container -->

    @section('scripts')
        <script type="text/javascript" src="../../js/jquery-1.11.2.min.js"></script>
        <script type="text/javascript" src="../../js/bootstrap-dropdown.js"></script>
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>
    @show

    @yield('script')

  </body>
</html>