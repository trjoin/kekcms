<?php
session_start();
if(isset($_SESSION["userlogged"]) AND $_SESSION["userlogged"]!="" AND $_SESSION["userlogged"]!=" ")
{
	/*** LEGÚJABB FRISSITÉSEK HOZZÁADÁSA ***/
	//$frissit=$pdo->query("ALTER TABLE ".$elotag."_slider ADD gomblink TEXT AFTER hiperlink, ADD slidersor INT(5) AFTER dumahozza");
	//$frissit=$pdo->query("update ".$elotag."_social set socialsite='LinkedIn',sociallink='#' where socialsite like '%Google%'");
	
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