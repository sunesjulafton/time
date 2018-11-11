<?php

	include '../init.php';

	if(isset($_POST['search']) && !empty($_POST['search'])) {
		$search = $getFromU->checkInput($_POST['search']);
		$result = $getFromU->search($search);

		

		if(!empty($result)) {
			echo '<div class="nav-right-down-wrap"><ul> ';

			foreach($result as $customer) {
				echo '<li>
						<a href="'. BASE_URL . 'customer_profile.php?customer_id=' . $customer->customer_id .'">' . $customer->customer_name . '</a>

					</li> ';

					/*
				  		<div class="nav-right-down-inner">
							<div class="nav-right-down-left">
								<a href="'. BASE_URL . $customer->customer_name .'"><img src="'. BASE_URL . $customer->customer_name .'"></a>
							</div>
							<div class="nav-right-down-right">
								<div class="nav-right-down-right-headline">
									<a href="'. BASE_URL . $customer->customer_name .'">'. $customer->customer_name .'</a><span>@'.$customer->customer_name .'</span>
								</div>
								<div class="nav-right-down-right-body">
								 
							    </div>
							</div>
						</div> 
					 </li> ';
					 */
			}

			echo '</ul></div>';
		}
		else {
			
		}
	}

?>



	  

	 
