<?
    //Запускаем сессию
    session_start();

    //Подключаем классы
	include 'config.php';
	include 'classes/Database.php';
	include 'classes/Auth.php';

	//Объявляем объект
	$auth = new Auth();

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Авторизация</title>
</head>
<body>
	<form action="" method="post">
		<div>
			<input type="text" name="login" value="Логин">
		</div>
		<div>
			<input type="text" name="password" value="Пароль">
		</div>
		<div>
			<input type="submit" name="go" value="Войти">
		</div>
	</form>
	<div>
		<a href="./reg.php">Регистрация</a>
	</div>
</body>
</html>