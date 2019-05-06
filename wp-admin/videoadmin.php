<?php
session_start();
if(isset($_SESSION["userlogged"]) AND $_SESSION["userlogged"]!="" AND $_SESSION["userlogged"]!=" ")
{
	$szam=1;
	echo "<h3>Videók kezelése<br><small>(Az alábbi szolgáltatókat kezeli: youtube, vimeo, videa)</small></h3><p>";
	echo "<a href='index.php?lng=".$webaktlang."&mod=y&ujvideo' class='btn'>+ új videó hozzáadása &raquo;</a><br><br>";
		$vidik=$pdo->query("select * from ".$elotag."_videok order by videokod desc");
		while($evid=$vidik->fetch())
		{
			echo "<h4>".$szam.".: ".$evid["videocim"]."</h4>
				<a href='".$evid["vhiv"]."' target='_blank' class='btn'><i class='icon-eye-open'></i> megtekintés</a> 
				<a href='index.php?lng=".$webaktlang."&mod=y&videotorol=".$evid["videokod"]."' class='btn' onclick='return confirm(\"Biztosan törlöd ezt a videót?\")'><i class='icon-trash'></i> törlés</a> 
				<a href='index.php?lng=".$webaktlang."&mod=y&videomod=".$evid["videokod"]."'class='btn'><i class='icon-pencil'></i>  módosítás</a><br><hr>";
			$szam++;
		}
		echo "</p>";
}
?>