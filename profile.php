<?php 
	if(isset($_GET['username']) === true && empty($_GET['username']) === false) {
		include 'core/init.php';
		$username = $getFromU->checkInput($_GET['username']);
		$profile_id = $getFromU->userIdByUsername($username);
		$profile_data = $getFromU->userData($profile_id);
		if(isset($_SESSION['user_id'])) {
			$user_id = $_SESSION['user_id'];
			$user = $getFromU->userData($user_id);
		}
		if(!$profile_data) {
			header('Location: index.php');
		}
	}

	


?>

<!--
   This template created by Meralesson.com 
   This template only use for educational purpose 
-->
<!doctype html>
<html>
	<head>
		<title>time</title>
		<meta charset="UTF-8" />
 		<link rel="stylesheet" href="<?php echo BASE_URL;?>assets/css/style-complete.css"/>
   		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css"/>  
		<script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>  	  

    </head>
<!--Helvetica Neue-->
<body>
<div class="wrapper">
<!-- header wrapper -->
<div class="header-wrapper">	
	<div class="nav-container">
    	<div class="nav">
		<div class="nav-left">
			<ul>
				<li><a href="<?php echo BASE_URL;?>home.php"><i class="fa fa-home" aria-hidden="true">
				</i>Home</a></li>
				<?php if($getFromU->loggedIn()===true){?>	
				<li><a href="<?php echo BASE_URL;?>i/notifications"><i class="fa fa-bell" aria-hidden="true"></i>Notification</a></li>
				<li><i class="fa fa-envelope" aria-hidden="true"></i>Messages</li>
				 <?php } ?>
			</ul>
		</div><!-- nav left ends-->
		<div class="nav-right">
			<ul>
				<li><input type="text" placeholder="Search" class="search"/><i class="fa fa-search" aria-hidden="true"></i>
					<div class="search-result"> 			
					</div>
				</li>
				<?php if($getFromU->loggedIn()===true){?>	
				<li class="hover"><label class="drop-label" for="drop-wrap1"><img src="<?php echo BASE_URL . $user->profile_image;?>"/></label>
				<input type="checkbox" id="drop-wrap1">
				<div class="drop-wrap">
					<div class="drop-inner">
						<ul>
							<li><a href="<?php echo BASE_URL . $user->username;?>"><?php echo $user->username;?></a></li>
							<li><a href="<?php echo BASE_URL;?>settings/account">Settings</a></li>
							<li><a href="<?php echo BASE_URL;?>includes/logout.php">Log out</a></li>
						</ul>
					</div>
				</div>
				</li>
				<!-- <li><label for="pop-up-tweet" class="addTweetBtn">Tweet</label></li> -->
			<?php }else {echo '<li><a href="' . BASE_URL .'index.php">Have an account? Log in!</a></li>';} ?>
			</ul>
		</div><!-- nav right ends-->

	</div><!-- nav ends -->
	</div><!-- nav container ends -->
</div><!-- header wrapper end -->
<!--Profile cover-->
<div class="profile-cover-wrap"> 
<div class="profile-cover-inner">
	<div class="profile-cover-img">
		<!-- PROFILE-COVER -->
		<img src="<?php echo BASE_URL . $profile_data->profile_cover;?>"/>
	</div>
</div>
<div class="profile-nav">
 <div class="profile-navigation">
	<ul>
		<li>
		<div class="n-head">
			Total Support Minutes
		</div>
		<div class="n-bottom">
		  <span><?php echo $profile_data->support_minutes;?></span>
		</div>
		</li>
		<!--
		<li>
			<a href="<?php //echo BASE_URL . $profile_data->username;?>/following">
				<div class="n-head">
					<a href="<?php //echo BASE_URL . $profile_data->username;?>">FOLLOWING</a>
				</div>
				<div class="n-bottom">
					<span class="count-following"><?php //echo $profile_data->following;?></span>
				</div>
			</a>
		</li>
	-->
		<li>
		 
				<div class="n-head">
					Supported Customers
				</div>
				<div class="n-bottom">
					<span class="count-followers"><?php echo $profile_data->supported_customers;?></span>
				</div>
			
		</li>
		<li>
			
				<div class="n-head">
					Average Support Time
				</div>
				<div class="n-bottom">
					<span class="count-followers"><?php echo $profile_data->average_support_time;?></span>
				</div>
			
		</li>
	</ul>
	<!--
	<div class="edit-button">
		<span>
			<button class="f-btn follow-btn"  data-follow="user_id" data-user="user_id"><i class="fa fa-user-plus"></i> Follow </button>
		</span>
	</div>
-->
    </div>
</div>
</div><!--Profile Cover End-->

<!---Inner wrapper-->
<div class="in-wrapper">
 <div class="in-full-wrap">
   <div class="in-left">
     <div class="in-left-wrap">
	<!--PROFILE INFO WRAPPER END-->
	<div class="profile-info-wrap">
	 <div class="profile-info-inner">
	 <!-- PROFILE-IMAGE -->
		<div class="profile-img">
			<img src="<?php echo BASE_URL . $profile_data->profile_image;?>"/>
		</div>	

		<div class="profile-name-wrap">
			<div class="profile-name">
				<a href="<?php echo BASE_URL . $profile_data->username;?>"><?php echo $profile_data->username;?></a>
			</div>
			<div class="profile-tname">
				@<span class="username"><?php echo $profile_data->username;?></span>
			</div>
		</div>

		<div class="profile-bio-wrap">
		 <div class="profile-bio-inner">
		    <!--<?php echo $profile_data->bio;?>-->
		 </div>
		</div>
<!--
<div class="profile-extra-info">
	<div class="profile-extra-inner">
		<ul>
			<?php if(!empty($profile_data->country)) { ?>
				<li>
					<div class="profile-ex-location-i">
						<i class="fa fa-map-marker" aria-hidden="true"></i>
					</div>
					<div class="profile-ex-location">
						<?php echo $profile_data->country;?>
					</div>
				</li>
			<?php } ?>
			<?php if(!empty($profile_data->website)) { ?>
				<li>
					<div class="profile-ex-location-i">
						<i class="fa fa-link" aria-hidden="true"></i>
					</div>
					<div class="profile-ex-location">
						<a href="<?php echo $profile_data->website;?>" target="_blank"><?php echo $profile_data->website;?></a>
					</div>
				</li>
			<?php } ?>
			<li>
				<div class="profile-ex-location-i"> -->
					<!-- <i class="fa fa-calendar-o" aria-hidden="true"></i> -->
				<!-- </div>
				<div class="profile-ex-location">
 				</div>
			</li>
			<li>
				<div class="profile-ex-location-i"> -->
					<!-- <i class="fa fa-tint" aria-hidden="true"></i> -->
				<!--</div>
				<div class="profile-ex-location">
				</div>
			</li>
		</ul>						
	</div>
</div>
-->
<!--
<div class="profile-extra-footer">
	<div class="profile-extra-footer-head">
		<div class="profile-extra-info">
			<ul>
				<li>
					<div class="profile-ex-location-i">
						<i class="fa fa-camera" aria-hidden="true"></i>
					</div>
					<div class="profile-ex-location">
						<a href="#">0 Photos and videos </a>
					</div>
				</li>
			</ul>
		</div>
	</div>
	<div class="profile-extra-footer-body">
		<ul> -->
			 <!-- <li><img src="#"/></li> -->
		<!--</ul>		
	</div>
</div>
-->
	 </div>
	<!--PROFILE INFO INNER END-->

	</div>
	<!--PROFILE INFO WRAPPER END-->

	</div>
	<!-- in left wrap-->

  </div>
	<!-- in left end-->

<div class="in-center">
	<div class="in-center-wrap">
	<!--Tweet SHOW WRAPER-->
	<!--Tweet SHOW WRAPER END-->
	</div><!-- in left wrap-->
  <div class="popupTweet"></div>
</div>
<!-- in center end -->

<div class="in-right">
	<div class="in-right-wrap">
			
		<!--==WHO TO FOLLOW==-->
	      <!--who to follow-->
		<!--==WHO TO FOLLOW==-->
			
		<!--==TRENDS==-->
	 	   <!--Trends-->
	 	<!--==TRENDS==-->
			
	</div><!-- in right wrap-->
</div>
<!-- in right end -->

		</div>
		<!--in full wrap end-->
	</div>
	<!-- in wrappper ends-->	
 </div>
 <!-- ends wrapper -->
</body>
</html>