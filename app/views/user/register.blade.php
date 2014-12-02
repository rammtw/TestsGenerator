<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Register</h2>
		<div>
			{{ Form::open(array('action' => 'UserController@create')) }}
  			{{ Form::text('name') }}
  			{{ Form::text('last_name') }}
  			{{ Form::password('password') }}
    		{{ Form::select('group_id', $groups) }}
  			{{ Form::submit('Зарегистрироваться') }}
			{{ Form::close() }}
		</div>
	</body>
</html>