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
    <link href="../../css/signin.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">

		{{ Form::open(array('action' => 'UserController@auth', 'class' => 'form-signin')) }}
			@if(Session::get('error'))
				<p class="bg-danger" style="padding:15px;">Неверный логин или пароль</p>
			@endif
			<h2 class="form-signin-heading">Please sign in</h2>
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<input type="name" name="name" class="form-control" placeholder="Login" required autofocus>
			<input type="password" name="password" class="form-control" placeholder="Password" required>
			<label class="checkbox">
			  <input type="checkbox" name="remember" value="1"> Remember me
			</label>
			<button class="btn btn-lg btn-success btn-block" type="submit">Войти</button>
			<a href="/reg" class="btn btn-lg btn-primary btn-block" type="button">Нету аккаунта?</a>
		{{ Form::close() }}

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  </body>
</html>