<?php

	Class Register extends Auth {

		//Перенаправление после успешной регистрации
		protected $redirectTO = './';
		protected $successReg = './login.php';

		public function __construct() {

			if($this->CheckLoginPage()) {
				header('Location: ' . $this->redirectTO);
				exit;
			}

			$this->Reg();

		}

		public function Reg() {

			if (isset($_POST['reg'])) {

				$login = $_POST['login']; // Записываем логин в переменную 
        		$login = str_replace(' ', '', strtolower($login));
        		$email = $_POST['email']; // Записываем логин в переменную 
            	$email = str_replace(' ', '', strtolower($email));
        		$password = trim($_POST['password']);
        		$re_password = trim($_POST['re_password']);
        		$name = trim(htmlspecialchars($_POST['name']));

        		//$errors = array(); 
				
				// Validation
				if (empty($login)) {
					echo '<script>alert("Поле login не заполненно!");</script>';
					//$errors = "Поле login не заполненно!";
				}elseif (strlen($login) < 6) {
					echo '<script>alert("Поле login не может быть меньше 6 символов!");</script>';
					//$errors = "";
				}elseif(empty($email)) {
					echo '<script>alert("Поле Email не заполненно!");</script>';
					//$errors = "";
				}elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
					echo '<script>alert("Неверный формат E-mail!");</script>';
					//$errors = "";
				}elseif(empty($name)) {
					echo '<script>alert("Поле Имя не заполненно!");</script>';
					//$errors = "";
				}elseif(strlen($name) < 2) {
					echo '<script>alert("Поле Имя не может быть меньше 2 символов!");</script>';
					//$errors = "";
				}elseif(empty($password)) {
					echo '<script>alert("Поле пароль не заполненно!");</script>';
					//$errors = "";
				}elseif(strlen($password) < 6) {
					echo '<script>alert("Поле пароль не может быть меньше 6 символов!");</script>';
					//$errors = "";
				}elseif($password != $re_password) {
					echo '<script>alert("Пароли не совпадают!");</script>';
					//$errors = "";
				}elseif ($this->CheckRegLogin($login)) {
					echo '<script>alert("Логин занят!");</script>';
					//$errors = "";
				}elseif ($this->CheckRegEmail($email)) {
					echo '<script>alert("Email занят!");</script>';
					//$errors = "";
				}else {

					// Хешируем пароль
					$password = password_hash($password, PASSWORD_DEFAULT);

					if ($this->StartReg($email, $login, $password, $name)) {
						header('Location: ' . $this->successReg);
						exit;
					}else {
						//return $errors;
						echo '<script>alert("Произошла ошибка!");</script>';
					}
				}

			}

		}

		public function CheckRegLogin($login) {

			$database = new Database();

			$sql = "SELECT `login` FROM `users` WHERE `login` = '" . $login . "'";
			$result = mysqli_query($database->db, $sql);
			
			if (!$result) die(mysqli_error($database->db));

			// Извлечение из БД
			$n = mysqli_num_rows($result);
			if (!$n) return false;

			$row = $result->fetch_assoc();
			$params = $row;

			return $params;

		}

		public function CheckRegEmail($email) {
			
			$database = new Database();

			$sql = "SELECT `email` FROM `users` WHERE `email` = '" . $email . "'";
			$result = mysqli_query($database->db, $sql);
			
			if (!$result) die(mysqli_error($database->db));

			// Извлечение из БД
			$n = mysqli_num_rows($result);
			if (!$n) return false;

			$row = $result->fetch_assoc();
			$params = $row;

			return $params;

		}

		public function StartReg($email, $login, $password, $name) {

			if ($email == "") return false;
			if ($login == "") return false;
			if ($password == "") return false;

			$database = new Database();

			$t = "INSERT INTO `users` (`email`, `login`, `password`, `name`) VALUES ('%s', '%s', '%s', '%s')";

			$query = sprintf($t, 
								mysqli_real_escape_string($database->db, $email),
								mysqli_real_escape_string($database->db, $login),
								mysqli_real_escape_string($database->db, $password),
								mysqli_real_escape_string($database->db, $name)
							);

			$result = mysqli_query($database->db, $query);

			if (!$result) die(mysqli_error($database->db));
			return true;

		}

	}