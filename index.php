<?php
if(!file_exists("connect.php"))
{
	include("install.php");
}
elseif(file_exists("install.php"))
{
	//tesztkapcsolat és vizsgálat
	include("connect.php");
	$webosszetevok=$pdo->query("select * from ".$elotag."_parameterek");
	if($webosszetevok)
	{
		if($webosszetevok->rowCount()>0)
		{
			$installtorol=unlink("install.php");
			if($installtorol)
			{
				print("<br /><br /><br /><br /><center><font face='Verdana' size='5' color='#FF0000'><b>Törlöm az INSTALL.PHP-t!<br /><br />Kis türelmet...</b></font></center>");
				print("<script>				    
							function atiranyit()
							{
								location.href = 'index.php';
							}
							ID = window.setTimeout('atiranyit();', 1*1);
						</script>");
			}
			else
			{
				print("<br /><br /><br /><br /><center><font face='Verdana' size='5' color='#FF0000'><b>Előbb töröld az INSTALL.PHP-t, ez biztonsági rés és sajnos a rendszernek nem sikerült!</b></font></center>");
			}
		}
		else
		{
			print("<br /><br /><br /><br /><center><font face='Verdana' size='5' color='#FF0000'><b>Sajnos hibát tapasztaltam, az adatbázis kapcsolat fájl bár létezik, de az nem a K.E.K. CMS-hez tartozik, így nem tudjuk folytatni sem a telepítést sem a betöltést!<br />Kérlek nézz utána és távolítsd el a problémás fájlt vagy másold más elérési út alá a K.E.K. CMS rendszert!</b></font></center>");
		}
	}
	else
	{
		print("<br /><br /><br /><br /><center><font face='Verdana' size='5' color='#FF0000'><b>Sajnos hibát tapasztaltam, az adatbázis kapcsolat fájl bár létezik, de az nem a K.E.K. CMS-hez tartozik, így nem tudjuk folytatni sem a telepítést sem a betöltést!<br />Kérlek nézz utána és távolítsd el a problémás fájlt vagy másold más elérési út alá a K.E.K. CMS rendszert!</b></font></center>");
	}
}
else
{
	include("connect.php");
	$webosszetevok=$pdo->query("select * from ".$elotag."_parameterek");
		$webadatok=$webosszetevok->fetch();

	if(!isset($_GET["lng"]))
	{
		$weblangok=$pdo->query("select langnev from ".$elotag."_nyelvek order by langkod asc");
		$webegylang=$weblangok->fetch();
		$webaktlang=$webegylang["langnev"];
	}
	else
	{
		$webaktlang=$_GET["lng"];
	}
	include("./themes/".$webadatok["sablon"]."/theme.php");
}
?>