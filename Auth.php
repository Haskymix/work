<?php

	Class Auth {

		//Перенаправление после успешной авторизации
		protected $redirectTO = './';
		protected $redirectNOauth = './login.php';

		protected $login;
		protected $password;

		public function __construct() {

			if($this->CheckLoginPage()) {
				header('Location: ' . $this->redirectTO);
				exit;
			}

			$this->Login();

		}

		public function CheckAuth() {

			if(isset($_SESSION['id'])) {
				return $_SESSION['id'];
			}else {
				header('Location: ' . $this->redirectNOauth);
				exit;
			}

		}

		public function CheckLoginPage() {
			if(isset($_SESSION['id'])) 
				return true;
			else
				return false;
		}

		public function CheckLogin($login, $pass) {
			$sql = "SELECT `id` FROM `users` WHERE `login` = '" . $login . "' AND `password` = '" . $pass . "'";
			$result = mysqli_query($this->db, $sql);
			
			if (!$result) die(mysqli_error($this->db));

			// Извлечение из БД
			$n = mysqli_num_rows($result);
			$params = array();

			for ($i = 0; $i < $n; $i++) {
				$row = $result->fetch_assoc();
				$params[] = $row;
			}

			return $params;
		}

		public function Login() {
			
			if (isset($_POST['go'])) {
				
				if (empty($_POST['login'])) {
					echo '<script>alert("Поле login не заполненно!");</script>';
				}elseif(empty($_POST['password'])) {
					echo '<script>alert("Поле пароль не заполненно!");</script>';
				}else {
					$login = $_POST['login']; // Записываем логин в переменную 
            		$login = str_replace(' ', '', strtolower($login));
            		$password = trim($_POST['password']);

            		if($this->GetOneUser($login)) {
            			if (password_verify($password, $this->GetOneUser($login)['password'])) {

            				//Добавляем в сессию id
            				$_SESSION['id'] = $this->GetOneUser($login)['id'];

            				header('Location: ' . $this->redirectTO);
							exit;

            			}else {
            				echo '<script>alert("Пароль введен не верно!");</script>';
            			}
            		}else {
            			echo '<script>alert("Логин введен не верно!");</script>';
            		}

				}
				
			}

		}

		public function GetOneUser($login) {

			$database = new Database();

			$sql = "SELECT `id`, `name`, `password` FROM `users` WHERE `login` = '" . $login . "'";
			$result = mysqli_query($database->db, $sql);
			
			if (!$result) die(mysqli_error($database->db));

			// Извлечение из БД
			$n = mysqli_num_rows($result);
			if (!$n) return false;

			$row = $result->fetch_assoc();
			$params = $row;

			return $params;

		}

	}