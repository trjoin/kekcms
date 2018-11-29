<?php
session_start();
if(isset($_SESSION["userlogged"]) AND $_SESSION["userlogged"]!="" AND $_SESSION["userlogged"]!=" ")
{
	echo "<h3>Videók kezelése</h3><p>";
	echo "<a href='index.php?lng=".$webaktlang."&mod=y&ujvideo' class='btn'>új videó hozzáadása &raquo;</a><br><br>";
		$vidik=$pdo->query("select * from ".$elotag."_videok order by videokod desc";
		while($evid=$vidik->fetch())
		{
			echo $evid["videocim"]." | <a href='index.php?lng=".$webaktlang."&mod=y&videotorol=".$evid["videokod"]."' onclick='return confirm(\"Biztosan törlöd ezt a videót?\")'>[ TÖRLÉS ]</a><br>";
		}
		echo "</p>";
}
?>