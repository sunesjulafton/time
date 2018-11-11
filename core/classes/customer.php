<?php 
	class Customer extends User {
		
		function __construct($pdo) {
			$this->pdo = $pdo;
		}


		public function customerData($customer_id) {
			$stmt = $this->pdo->prepare('SELECT * FROM customers WHERE customer_id = ?');
			$stmt->bindParam(1, $customer_id, PDO::PARAM_INT);
			$stmt->execute();
			return $stmt->fetch(PDO::FETCH_OBJ);
		}


		public function register_support($username, $email, $password) {
			
			$password = password_hash($password, PASSWORD_DEFAULT);

			

			$stmt = $this->pdo->prepare('INSERT INTO users (username, email, password) VALUES (?, ?, ?)');
			
			$stmt->bindParam(1, $username, PDO::PARAM_STR);
			$stmt->bindParam(2, $email, PDO::PARAM_STR);
			$stmt->bindParam(3, $password, PDO::PARAM_STR);
			
			$stmt->execute();

			$user_id = $this->pdo->lastInsertId();

			return $_SESSION['user_id'] = $user_id;


		}



	}
?>