<?
    //Запускаем сессию
    session_start();

    //Подключаем классы
	include 'config.php';
	include 'classes/Database.php';
	include 'classes/Auth.php';
	include 'classes/Register.php';

	//Объявляем объект
	$register = new Register();

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Регистрация</title>
</head>
<body>
	<form action="" method="post">
		<div>
			<input type="text" name="login" value="Логин">
		</div>
		<div>
			<input type="text" name="email" value="Email">
		</div>
		<div>
			<input type="text" name="name" value="Имя">
		</div>
		<div>
			<input type="text" name="password" value="Пароль">
		</div>
		<div>
			<input type="text" name="re_password" value="Повторите Пароль">
		</div>
		<div>
			<input type="submit" name="reg" value="Регистрация">
		</div>
	</form>
</body>
</html>