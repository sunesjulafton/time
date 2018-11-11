<?php 

	if(isset($_GET['customer_id']) === true && empty($_GET['customer_id']) === false) {
		include 'core/init.php';
		$customer_id = $_GET['customer_id'];
		$customer = $getFromC->customerData($customer_id);
	}


	if(isset($_SESSION['user_id'])) {
		$user_id = $_SESSION['user_id'];
		$user = $getFromU->userData($user_id);
		console_log($user_id);
	}
	

	if(isset($_POST['register_ticket'])) {
		
		$ticket_owner= $_POST['ticket_owner'];
		$ticket_user = $_POST['ticket_user'];
		$ticket_time = $_POST['ticket_time'];
		$ticket_date = $_POST['ticket_date'];
		$error = "";

		console_log($ticket_owner);
		console_log($ticket_user);
		console_log($ticket_time);
		console_log($ticket_date);

		if(empty($ticket_owner) or empty($ticket_user) or empty($ticket_time) or empty($ticket_date)) {
			$error = "All fields are required!";
			
		}
		else {
			$ticket_user = $getFromU->checkInput($ticket_user);
			$ticket_time = $getFromU->checkInput($ticket_time);
			$ticket_date = $getFromU->checkInput($ticket_date);
			
			/*
			if(!filter_var($email)) {
				$error = "Invalid email format!";
				
			}
			*/

			/*else if(strlen($screen_name) > 20) {
				$error = "Name must be in between 6-20 characters!";
				console_log("sune4");
			}
			*/
			/*
			else if(strlen($password) < 5) {
				$error = "Password must be at least 5 characters long!";
				
			}
			*/
			//else {
				/*
				if($getFromU->checkEmail($email) === true) {
					$error = "Email is already in use!";
					
				}
				else {
				*/	
					//$password = password_hash($password, PASSWORD_DEFAULT);
					$getFromU->create('tickets', array('ticket_owner' => $ticket_owner, 'ticket_user' => $ticket_user, 'ticket_time' => $ticket_time, 'ticket_date' => date('Y-m-d H:i:s')));

					
					$total_support_time = $customer->total_support_time;
					$used_support_time = $customer->used_support_time;
					
					console_log($total_support_time);
					console_log($used_support_time);


					$total_support_time = $total_support_time + $ticket_time;
					$total_support_time = (string)$total_support_time;
					$used_support_time = $used_support_time + $ticket_time;
					$used_support_time = (string)$used_support_time;
					
					console_log($total_support_time);
					console_log($used_support_time);
					console_log($customer_id);

					$getFromC->update('customers', $customer_id, array('total_support_time' => $total_support_time, 'used_support_time' => $used_support_time));



					//$user_id = $getFromC->register_support($customer_id, $email, $password);
					
					//$_SESSION['user_id'] = $user_id;

					header('Location: customer_profile.php?customer_id=' . $customer_id);
				//}
				
			//}
		}
	}


?>


<!doctype html>
<html>
	<head>
		<title>time</title>
		<meta charset="UTF-8" />
 		<link rel="stylesheet" href="<?php echo BASE_URL;?>assets/css/style-complete.css"/>
 		<link rel="stylesheet" href="assets/css/customer_profile.css"/> 
   		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css"/>  
		<script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>  	  

    </head>
<!--Helvetica Neue-->
	<body>
		<div class="wrapper">
			<!-- header wrapper -->
			<div class="header-wrapper">

				<div class="nav-container">
					<!-- Nav -->
					<div class="nav">
						
						<div class="nav-left">
							<ul>
								<li><a href="#"><i class="fa fa-home" aria-hidden="true"></i>Home</a></li>
								<li><a href="i/notifications"><i class="fa fa-bell" aria-hidden="true"></i>Notification</a></li>
								<li><i class="fa fa-envelope" aria-hidden="true"></i>Messages</li>
							</ul>
						</div><!-- nav left ends-->

						<div class="nav-right">
							<ul>
								
								<li>
								<input type="text" placeholder="Search" class="search"/>
								<i class="fa fa-search" aria-hidden="true"></i>
								<div class="search-result">			
								</div>
								</li>


								<li class="hover"><label class="drop-label" for="drop-wrap1"><img src="<?php echo $user->profile_image;?>"/></label>
								<input type="checkbox" id="drop-wrap1">
								<div class="drop-wrap">
									<div class="drop-inner">
										<ul>
											<li><a href="<?php echo $user->username;?>"><?php echo $user->username;?></a></li>
											<li><a href="settings/account">Settings</a></li>
											<li><a href="includes/logout.php">Log out</a></li>
										</ul>
									</div>
								</div>
								</li>
								<!--<li><a href="includes/logout.php">Log out</a></li>-->
							</ul>
						</div><!-- nav right ends-->

					</div><!-- nav ends -->

				</div><!-- nav container ends -->

			</div><!-- header wrapper end -->
			<script type="text/javascript" src="assets/js/search.js"></script>
			
			<div class="inner-wrapper">
				<div class="in-wrapper">
					<div class='customer-container'>
						
						<h2 class="customer-header"><?php echo $customer->customer_name; ?></h2>


						<div class='customer-info-container'>
							<h3 class="customer-h3">Details</h3>
							<div class='customer-info'>
								
								<ul>
									<li>
										<div class="n-head">
											Total used support time
										</div>
										<div class="n-bottom">
											<span class="count-followers"><?php echo $customer->total_support_time;?></span>
										</div>
									</li>
									<li>
										<div class="n-head">
											Used time / Time left
										</div>
										<div class="n-bottom">
											<span class="count-followers"><?php echo $customer->used_support_time . ' / ' . $customer->monthly_support_time;?></span>
										</div>
									</li>
								</ul>
							</div>
						</div>
						<div class="customer-actions-container">
							<h3 class="customer-h3">New support ticket</h3>
							<div>
								<form method="post">

									<input type="hidden" name="ticket_owner" value="<?php echo $customer->customer_id ?>">

									<div>
										User:<br>
										<input type="text" name="ticket_user">
									</div>
									<div>
										Time:<br>
										<input type="number" name="ticket_time">
									</div>
									<div>
										Date:<br>
										<input type="date" name="ticket_date">
									</div>
									<div>
										<input type="submit" name="register_ticket" value="Send">
									</div>


								</form>
							</div>
						</div>
					</div>
				</div>
			</div>


		</div>
		<!--in full wrap end-->
		
	 <!-- ends wrapper -->
	</body>
</html>