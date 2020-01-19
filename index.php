<?
    //Запускаем сессию
    session_start();

    //Подключаем классы
	include 'config.php';
	include 'classes/Database.php';
	include 'classes/Auth.php';
	include 'classes/User.php';
	include 'classes/Orders.php';

	//Объявляем объект
	$user = new User();

	//Поместим массив данных выборки
	$user_info = $user->GetUser($user->CheckAuth());
	//При вызове формы смены пароля, меняем пароль если все ок!
	$user->RePass($user->CheckAuth());

	//Объявляем объект для выборки из второй части задания
	/*
		Необходимо :
		1 - составить запрос, который выведет список email'лов встречающихся более чем у одного пользователя
		2 - вывести список логинов пользователей, которые не сделали ни одного заказа
		3 - вывести список логинов пользователей которые сделали более двух заказов
	*/
	$order = new Orders();

	/*
		Для себя выход, удаление сессии	
	*/
	if (isset($_GET['exit'])) {
		unset($_SESSION['id']);
		header('Location: ./login.php');
		exit;
	}

	//var_dump($order->UserOrder());

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<h1>
		Добро пожаловать, <?= $user_info['name'] ?>!
	</h1>
		
	<div>
		<a href="?exit=1" title="">Выйти</a>
	</div>

	<div>
		<h2>
			Смена пороля
		</h2>
		<form action="" method="post">
			<div>
				<input type="text" name="password" value="Пароль">
			</div>
			<div>
				<input type="text" name="re_password" value="Повторите Пароль">
			</div>
			<div>
				<input type="submit" name="save" value="Сохранить">
			</div>
		</form>
	</div>

	<div>
		<h3>
			Cписок email'лов встречающихся более чем у одного пользователя
		</h3>
		<?php if ($order->havingEmail()): ?>
			<?php foreach ($order->havingEmail() as $item): ?>
				<p>
					- <?= $item['email'] ?>
				</p>
			<?php endforeach ?>
		<?php else: ?>
			<p>
				Ничего нет!
			</p>
		<?php endif ?>
	</div>

	<div>
		<h3>
			Cписок логинов пользователей, которые не сделали ни одного заказа
		</h3>
		<?php if ($order->noOrder()): ?>
			<?php foreach ($order->noOrder() as $item): ?>
				<p>
					- <?= $item['login'] ?>
				</p>
			<?php endforeach ?>
		<?php else: ?>
			<p>
				Ничего нет!
			</p>
		<?php endif ?>
	</div>

	<div>
		<h3>
			Cписок логинов пользователей которые сделали более двух заказов
		</h3>
		<?php if ($order->UserOrder()): ?>
			<?php foreach ($order->UserOrder() as $item): ?>
				<p>
					- <?= $item['login'] ?>
				</p>
			<?php endforeach ?>
		<?php else: ?>
			<p>
				Ничего нет!
			</p>
		<?php endif ?>
	</div>

</body>
</html>
