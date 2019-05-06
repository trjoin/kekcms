<?php
/* Google térkép */
	if(!isset($_REQUEST["furl"]))
	{
		$modgmapsbe=$pdo->query("select * from ".$elotag."_modulok where modulnev='gmaps'");
		$mapsmod=$modgmapsbe->fetch();
		if($mapsmod["bekapcsolva"]=="igen")
		{
			echo '<div class="banner-bottom">
					<div class="container">
						<div class="tittle_head_w3layouts">
							<h3 class="tittle main"><span>Átlátható</span> Google térkép</h3>
						</div>
						<div class="inner_sec_info_agileits_w3">';
				$mapsmod=$pdo->query("select * from ".$elotag."_gmaps");
				$gm=$mapsmod->fetch();
				echo '<iframe src="https://www.google.com/maps/embed/v1/place?q='.$gm["gmapskey"].'&key=AIzaSyBGUnRIK9gqjmB2h2ClAETUAw70fzkHJRw" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>';
			echo '		</div>
					</div>
				</div>';
		}
	}
?>