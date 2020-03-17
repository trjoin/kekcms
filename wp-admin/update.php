<?php
session_start();
if(isset($_SESSION["userlogged"]) AND $_SESSION["userlogged"]!="" AND $_SESSION["userlogged"]!=" ")
{
	/*** LEGÚJABB FRISSITÉSEK HOZZÁADÁSA ***/
	$frissit=$pdo->query("ALTER TABLE `".$elotag."_parameterek` ADD `gdpr` TEXT NOT NULL AFTER `ogimage`");
	$frissit=$pdo->query("ALTER TABLE `".$elotag."_parameterek` ADD `favicon` TEXT NOT NULL AFTER `ogimage`");
	$frissit=$pdo->query("ALTER TABLE `".$elotag."_parameterek` ADD `debugmod` INT(2) NOT NULL DEFAULT '0' AFTER `breakoff`");
	
	if($frissit)
	{
		echo'<div class="widget stacked">
				<div class="widget-header">
					<i class="icon-th-large"></i>
					<h3>Rendszer frissítés - [K.E.K. Admin]</h3>
				</div>
				<div class="widget-content">
					<div class="row-fluid">
						<div class="span12">';
		echo '<h2>SIKERES FRISSITÉS!</h2>';
		echo '			</div>
					</div>
				</div>
			</div>';
		unlink("update.php");
		echo "<script>				    
					function atiranyit()
					{
						location.href = 'index.php';
					}
					ID = window.setTimeout('atiranyit();', 1*1000);
			   </script>";
	}
	else
	{
		echo'<div class="widget stacked">
				<div class="widget-header">
					<i class="icon-th-large"></i>
					<h3>Rendszer frissítés - [K.E.K. Admin]</h3>
				</div>
				<div class="widget-content">
					<div class="row-fluid">
						<div class="span12">';
		echo '<h2>SIKERTELEN FRISSITÉS!</h2>';
		echo '			</div>
					</div>
				</div>
			</div>';
		echo "<script>				    
					function atiranyit()
					{
						location.href = 'index.php';
					}
					ID = window.setTimeout('atiranyit();', 1*1000);
			   </script>";
	}
}
else { echo 'ERROR!'; }
?>