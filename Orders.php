<?php

	Class Orders extends User {

		public function __construct() {



		}

		public function havingEmail() {

			$database = new Database();

			$query = "SELECT `email`, COUNT(email) from `users` GROUP BY `email` HAVING COUNT(email) > 1";
			$result = mysqli_query($database->db, $query);

			if (!$result) die(mysqli_error($database->db));

			// Извлечение из БД
			$n = mysqli_num_rows($result);
			$a = array();

			for ($i = 0; $i < $n; $i++) {
				$row = $result->fetch_assoc();
				$a[] = $row;
			}

			return $a;

		}

		public function noOrder() {

			$database = new Database();

			$query = "SELECT `login` FROM `users` WHERE `id` NOT IN(( SELECT `user_id` FROM `orders`))";
			$result = mysqli_query($database->db, $query);

			if (!$result) die(mysqli_error($database->db));

			// Извлечение из БД
			$n = mysqli_num_rows($result);
			$a = array();

			for ($i = 0; $i < $n; $i++) {
				$row = $result->fetch_assoc();
				$a[] = $row;
			}

			return $a;
		}

		public function UserOrder() {

			$database = new Database();

			$query = "SELECT users.login FROM `users` JOIN `orders` ON users.id=orders.user_id WHERE orders.user_id=users.id GROUP BY orders.user_id HAVING COUNT(orders.user_id) > 2";
			$result = mysqli_query($database->db, $query);

			if (!$result) die(mysqli_error($database->db));

			// Извлечение из БД
			$n = mysqli_num_rows($result);
			$a = array();

			for ($i = 0; $i < $n; $i++) {
				$row = $result->fetch_assoc();
				$a[] = $row;
			}

			return $a;

		}

	}