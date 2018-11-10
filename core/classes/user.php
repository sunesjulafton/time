<?php

	class User {
		protected $pdo;

		function __construct($pdo) {
			$this->pdo = $pdo;
		}


		public function checkInput($var) {
			$var = htmlspecialchars($var);
			$var = trim($var);
			$var = stripcslashes($var);
			
			return $var;
		}

		public function search($search) {
			$stmt = $this->pdo->prepare("SELECT user_id, username, screen_name, profile_image, profile_cover FROM users WHERE username LIKE ? OR screen_name LIKE ?");
			$stmt->bindValue(1,$search.'%', PDO::PARAM_STR);
			$stmt->bindValue(2,$search.'%', PDO::PARAM_STR);
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		}


		public function get_password_hash($email) {
			include 'core/database/connection.php';
	      try {

	        $stmt = $pdo->prepare('SELECT password FROM users WHERE email = ?');
	        $stmt->bindParam(1, $email, PDO::PARAM_STR);
	       
	        $stmt->execute();
	      } catch (Execption $e) {
	        echo "Error: " . $e.getMessage() . "<br />";
	        return false;
	      }
	      return $stmt->fetch(PDO::FETCH_ASSOC);


	    }  


		public function login($email, $password) {

			console_log($email);
			console_log($password);

			$password_hash = $this->get_password_hash($email);

			console_log($password_hash);

			

			if (password_verify($password, $password_hash['password'])) {

			console_log("sune");

				$password = $password_hash['password'];

				

				$stmt = $this->pdo->prepare('SELECT user_id FROM users WHERE email = ? AND password = ?');

				
				$stmt->bindParam(1, $email, PDO::PARAM_STR);
				$stmt->bindParam(2, $password, PDO::PARAM_STR);
				$stmt->execute();

				$user = $stmt->fetch(PDO::FETCH_OBJ);
				$count = $stmt->rowCount();

				
				if($count > 0) {
					$_SESSION['user_id'] = $user->user_id;
					header('Location: home.php');
					
				}
				else {
					return false;
				}

			}
			else {

				return false;
			}

		}

		

		public function userData($user_id) {
			$stmt = $this->pdo->prepare('SELECT * FROM users WHERE user_id = ?');
			$stmt->bindParam(1, $user_id, PDO::PARAM_INT);
			$stmt->execute();
			return $stmt->fetch(PDO::FETCH_OBJ);
		}

		public function register($username, $email, $password) {
			console_log("jajajaj");
			$password = password_hash($password, PASSWORD_DEFAULT);

			console_log($username . " " . $email . " " . $password);

			$stmt = $this->pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
			
			$stmt->bindParam(1, $username, PDO::PARAM_STR);
			$stmt->bindParam(2, $email, PDO::PARAM_STR);
			$stmt->bindParam(3, $password, PDO::PARAM_STR);
			
			$stmt->execute();

			$user_id = $this->pdo->lastInsertId();

			return $_SESSION['user_id'] = $user_id;


		}


		public function logout() {
			$_SESSION = array();
			session_destroy();
			header('Location: '.BASE_URL. 'index.php');
		}

		
		public function create($table, $fields = array()) {
			$columns = implode(',', array_keys($fields));
			$values = ':' . implode(', :', array_keys($fields));
			$sql = "INSERT INTO {$table} ({$columns}) VALUES ({$values})";
			 
			if($stmt = $this->pdo->prepare($sql)) {
				foreach($fields as $key => $data) {
					$stmt->bindValue(':' . $key, $data);
				}
				$stmt->execute();
				return $this->pdo->lastInsertId();
			}
		}
		

		public function update($table, $user_id, $fields = array()) {
			$columns = '';
			$i = 1;

			foreach($fields as $name => $value) {
				$columns .= "`{$name}` = :{$name}";
				if($i < count($fields)) {
					$columns .= ', ';
				}
				$i++;
			}

			$sql = "UPDATE {$table} SET {$columns} WHERE `user_id` = {$user_id}";
			if($stmt = $this->pdo->prepare($sql)) {
				foreach($fields as $key => $value) {
					$stmt->bindValue(':'. $key, $value);
				}
				
				$stmt->execute();
			}
		}


		public function checkUsername($username) {
			$stmt = $this->pdo->prepare('SELECT username FROM users WHERE username = ?');
			$stmt->bindParam(1, $username, PDO::PARAM_STR);
			$stmt->execute();
			
			$count = $stmt->rowCount();
			if($count > 0) {
				return true;
			}
			else {
				return false;
			}
			
		}

		

		public function checkPassword($email, $password) {

			//$this->console_log("------");
			$password_hash = $this->get_password_hash($email);

			$count = 0;
			if (password_verify($password, $password_hash['password'])) {

				$password = $password_hash['password'];
			
				$stmt = $this->pdo->prepare('SELECT password FROM users WHERE password = ?');
				$stmt->bindParam(1, $password, PDO::PARAM_STR);
				$stmt->execute();
				
				$count = $stmt->rowCount();
			}
			if($count > 0) {
				return true;
			}
			else {
				return false;
			}
			
		}

		

		public function checkEmail($email) {
			console_log($email);
			
			
			$stmt = $this->pdo->prepare('SELECT email FROM users WHERE email = ?');
			$stmt->bindParam(1, $email, PDO::PARAM_STR);
			console_log("paran");
			$stmt->execute();
			
			$count = $stmt->rowCount();
			console_log($count);
			if($count > 0) {
				console_log("c1");
				return true;
			}
			else {
				
				console_log("c2");
				return false;
			}
			
		}


		public function loggedIn() {
			return (isset($_SESSION['user_id'])) ? true : false;
		}

		public function userIdByUsername($username) {
			$stmt = $this->pdo->prepare('SELECT user_id FROM users WHERE username  = ?');
			$stmt->bindParam(1, $username, PDO::PARAM_STR);
			$stmt->execute();
			$user = $stmt->fetch(PDO::FETCH_OBJ);
			return $user->user_id; 
		}

		public function uploadImage($file) {
			$filename = basename($file['name']);
			$fileTmp = $file['tmp_name'];
			$fileSize = $file['size'];
			$error = $file['error'];

			$ext = explode('.', $filename);
			$ext = strtolower(end($ext));
			$allowed_ext = array('jpg', 'png', 'jpeg');

			if(in_array($ext, $allowed_ext) === true) {
				if($error === 0) {
					if($fileSize <= 209272152) {
						$fileRoot = 'users/' . $filename;
						move_uploaded_file($fileTmp, $fileRoot);
						return $fileRoot;
					}
					else {
						$GLOBALS['imageError'] = "The file size is too large";
					}
				}
			}
			else {
				$GLOBALS['imageError'] = "The extension is not allowed";
			}
		}

	}

?>