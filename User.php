<?php

	Class User extends Auth {

		public function __construct() {

			//if(!$this->CheckLoginPage()) {
				//header('Location: ' . $this->redirectTO);
				//exit;
			//}

			$this->CheckAuth();

		}

		public function GetUser($id) {

			$database = new Database();

			$sql = "SELECT * FROM `users` WHERE `id` = '" . $id . "'";
			$result = mysqli_query($database->db, $sql);
			
			if (!$result) die(mysqli_error($database->db));

			// Извлечение из БД
			$n = mysqli_num_rows($result);
			if (!$n) return false;

			$row = $result->fetch_assoc();
			$params = $row;

			return $params;

		}

		public function RePass($id) {

			if (isset($_POST['save'])) {
				$password = trim($_POST['password']);
        		$re_password = trim($_POST['re_password']);
        		if(empty($password)) {
					echo '<script>alert("Поле пароль не заполненно!");</script>';
				}elseif($password != $re_password) {
					echo '<script>alert("Пароли не совпадают!");</script>';
				}else{
					// Хешируем пароль
					$password = password_hash($password, PASSWORD_DEFAULT);
					if ($this->editPassword($id, $password)) {
						echo '<script>alert("Пароль успешно изменен!");</script>';
					}else {
						echo '<script>alert("Произошла ошибка!");</script>';
					}
				}
			}

		}

		public function editPassword($id, $password) {

	    	$database = new Database();

			$t = "UPDATE `users` SET `password`='%s' WHERE `id`='%s'";

			$query = sprintf($t, 
								mysqli_real_escape_string($database->db, $password),
								$id
							);

			$result = mysqli_query($database->db, $query);

			if (!$result) die(mysqli_error($database->db));
			return true;

		}

		

	}