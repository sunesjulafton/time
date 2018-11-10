<?php

	
	if(isset($_POST['signup'])) {
		
		$username = $_POST['username'];
		$password = $_POST['password'];
		$email = $_POST['email'];
		$error = "";

		

		if(empty($username) or empty($password) or empty($email)) {
			$error = "All fields are required!";
			
		}
		else {
			
			$username = $getFromU->checkInput($username);
			$password = $getFromU->checkInput($password);
			$email = $getFromU->checkInput($email);
			
			if(!filter_var($email)) {
				$error = "Invalid email format!";
				
			}
			
			/*else if(strlen($screen_name) > 20) {
				$error = "Name must be in between 6-20 characters!";
				console_log("sune4");
			}
			*/

			else if(strlen($password) < 5) {
				$error = "Password must be at least 5 characters long!";
				
			}
			else {
				
				if($getFromU->checkEmail($email) === true) {
					$error = "Email is already in use!";
					
				}
				else {
					
					$password = password_hash($password, PASSWORD_DEFAULT);
					
					$user_id = $getFromU->register($username, $email, $password);
					
					$_SESSION['user_id'] = $user_id;

					header('Location: home.php');
				}
				
			}
		}
	}
?>

<form method="post">
<div class="signup-div"> 
	<h3>Sign up </h3>
	<ul>
		<li>
		    <input type="text" name="username" placeholder="Username"/>
		</li>
		<li>
		    <input type="email" name="email" placeholder="Email"/>
		</li>
		<li>
			<input type="password" name="password" placeholder="Password"/>
		</li>
		<li>
			<input type="submit" name="signup" Value="Signup for Twitter">
		</li>
		<?php 
			if(isset($error)) {
				echo '<li class="error-li">
			  <div class="span-fp-error">'. $error .'</div>
			 </li> ';
		}

	?>
	</ul>
	
	 
	
</div>
</form>