<?php
	
	Class Database {

		public $db;

		public function __construct() {
			
			$this->db = mysqli_connect(HOST, USER, PASS, DB);
			
			if (!$this->db) {
				exit('No connect DB!');
			}

			if (!mysqli_select_db($this->db, DB)) {
				exit('No table!');
			}

			mysqli_query($this->db, "SET NAMES utf8");

	        return $this->db;

		}

	}

