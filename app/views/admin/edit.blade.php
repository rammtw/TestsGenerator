<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Signin Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../../css/jambotron-narrow.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">

      <div class="header">
        <ul class="nav nav-pills pull-right">
          <li class="active"><a href="#">Home</a></li>
          <li><a href="#">About</a></li>
          <li><a href="#">Contact</a></li>
          @if(Auth::check())
            <li><a href="/logout">Выйти</a></li>
          @endif
        </ul>
        <h3 class="text-muted">Project name</h3>
      </div>

      <div class="jumbotron">
        <div class="row">
            <div class="col-md-6">
                {{ Form::open(array('action' => 'AdminController@update')) }}
                    <input name="id" type="hidden" class="form-control" value="{{ $user->id }}">
                    <div class="form-group">
                      <label for="login">Email</label>
                      <input name="login" type="text" class="form-control" id="login" value="{{ $user->login }}">
                    </div>
                    <div class="form-group">
                      <label for="name">Имя</label>
                      <input name="name" type="text" class="form-control" id="name" value="{{ $user->name }}">
                    </div>
                    <div class="form-group">
                      <label for="last_name">Фамилия</label>
                      <input name="last_name" type="text" class="form-control" id="last_name" value="{{ $user->last_name }}">
                    </div>
                    <div class="form-group">
                      <label for="last_name">Группа</label>
                      {{ Form::select('group_id', $groups, $user->group_id, array('class' => 'form-control')) }}
                    </div>
                    <div class="form-group">
                      <label for="last_name">Роль</label>
                      {{ Form::select('role_id', $roles, $user->role_id, array('class' => 'form-control')) }}
                    </div>
                    <button type="submit" class="btn btn-default">Отправить</button>
                {{ Form::close() }}
            </div>
        </div>
      </div>

      <div class="footer">
        <p>&copy; Company 2014</p>
      </div>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  </body>
</html>