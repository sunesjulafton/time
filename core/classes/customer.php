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

	}
?>