<?php
session_start();
include("../connect.php");
$webaktlang=$_GET["lng"];
if(isset($_SESSION["userlogged"]) AND $_SESSION["userlogged"]!="" AND $_SESSION["userlogged"]!=" ")
{
	$mirol=array("í","é","á","ű","ú","ő","ó","ü","ö","Í","É","Á","Ű","Ú","Ő","Ó","Ü","Ö","_","+",":",",","?","=","(",")","[","]","{","}","&","#","@","<",">","$","'","!","/"," ");
	$mire=array("i","e","a","u","u","o","o","u","o","i","e","a","u","u","o","o","u","o","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-");
	
	//webtartalom - menütartalom - frissitése
	if(isset($_POST["modosit"]))
	{
		$furl=str_replace($mirol, $mire, strtolower($_POST["mfnev"]));
		$parancs="update ".$elotag."_menu_".$webaktlang." set furl='".$furl."',tolink='".$_POST["tolink"]."',tomodul='".$_POST["tomodul"]."',nev='".$_POST["mfnev"]."',tartalom='".trim($_POST["tartalom"])."',metatitle='".trim($_POST["metatitle"])."',metakeywords='".trim($_POST["metakeywords"])."',metadesc='".trim($_POST["metadesc"])."',datum=now() where kod='".$_POST["modosit"]."'";
		$hova="index.php?lng=".$webaktlang."&page=".$_POST["modosit"];
	}
	//új menüpont és tartalom mentése
	if(isset($_POST["menunev"]))
	{
		$furl=str_replace($mirol, $mire, strtolower($_POST["menunev"]));
		$parancs="insert into ".$elotag."_menu_".$webaktlang." (furl,tolink,nev,tartalom,sorszam,datum) values('".$furl."','".$_POST["tolink"]."','".$_POST["menunev"]."','".addslashes(trim($_POST["tartalom"]))."','".$_POST["sorszam"]."',now())";
		$hova="index.php?lng=".$webaktlang."&page=saved";
	}
	//menüpont aktiválás
	if(isset($_GET["menustart"]))
	{
		$parancs="update ".$elotag."_menu_".$webaktlang." set aktiv='1' where kod='".$_GET["menustart"]."'";
		$hova="index.php?lng=".$webaktlang."&page=".$_GET["menustart"];
	}
	//menüpont inaktiválás
	if(isset($_GET["menustop"]))
	{
		$parancs="update ".$elotag."_menu_".$webaktlang." set aktiv='0' where kod='".$_GET["menustop"]."'";
		$hova="index.php?lng=".$webaktlang."&page=".$_GET["menustop"];
	}
	//menüpont sorszám módosítás
	if(isset($_GET["menusorszam"]))
	{
		if($_GET["irany"]=="fel")
		{
			$lekerdez=$pdo->query("select * from ".$elotag."_menu_".$webaktlang." where kod='".$_GET["menusorszam"]."'");
			$betolt=$lekerdez->fetch();
			
			$ujsorszam=$betolt["sorszam"]-1;
			$ujsorszam2=$betolt["sorszam"];
			
			$lekerdez2=$pdo->query("select * from ".$elotag."_menu_".$webaktlang." where sorszam='".$ujsorszam."'");
			$betolt2=$lekerdez2->fetch();
			
			$muvelet=$pdo->query("update ".$elotag."_menu_".$webaktlang." set sorszam='".$ujsorszam2."' where kod='".$betolt2["kod"]."'");
			$parancs="update ".$elotag."_menu_".$webaktlang." set sorszam='".$ujsorszam."' where kod='".$_GET["menusorszam"]."'";
		}
		if($_GET["irany"]=="le")
		{
			$lekerdez=$pdo->query("select * from ".$elotag."_menu_".$webaktlang." where kod='".$_GET["menusorszam"]."'");
			$betolt=$lekerdez->fetch();
			
			$ujsorszam=$betolt["sorszam"]+1;
			$ujsorszam2=$betolt["sorszam"];
			
			$lekerdez2=$pdo->query("select * from ".$elotag."_menu_".$webaktlang." where sorszam='".$ujsorszam."'");
			$betolt2=$lekerdez2->fetch();
			
			$muvelet=$pdo->query("update ".$elotag."_menu_".$webaktlang." set sorszam='".$ujsorszam2."' where kod='".$betolt2["kod"]."'");
			$parancs="update ".$elotag."_menu_".$webaktlang." set sorszam='".$ujsorszam."' where kod='".$_GET["menusorszam"]."'";
		}
		$hova="index.php?lng=".$webaktlang."&mod=y&menusormod=1";
	}
	//menüpont és tartalom törlése
	if(isset($_GET["torol"]))
	{
		$parancs="delete from ".$elotag."_menu_".$webaktlang." where kod='".$_GET["torol"]."'";
		$hova="index.php?lng=".$webaktlang."&page=saved";
	}
	//almenü tartalom mentése
	if(isset($_POST["almodosit"]))
	{
		$furl=str_replace($mirol, $mire, strtolower($_POST["manev"]));
		$parancs="update ".$elotag."_almenu_".$webaktlang." set furl='".$furl."',tolink='".$_POST["tolink"]."',tomodul='".$_POST["tomodul"]."',nev='".$_POST["manev"]."',tartalom='".trim($_POST["tartalom"])."',metatitle='".trim($_POST["metatitle"])."',metakeywords='".trim($_POST["metakeywords"])."',metadesc='".trim($_POST["metadesc"])."',datum=now() where kod='".$_POST["almodosit"]."'";
		$hova="index.php?lng=".$webaktlang."&alpage=".$_POST["almodosit"];
	}
	//új almenüpont és tartalom mentése
	if(isset($_POST["almenunev"]))
	{
		$furl=str_replace($mirol, $mire, strtolower($_POST["almenunev"]));
		$parancs="insert into ".$elotag."_almenu_".$webaktlang." (furl,tolink,nev,szulo,tartalom,datum) values('".$furl."','".$_POST["tolink"]."','".$_POST["almenunev"]."','".$_POST["szulo"]."','".addslashes (trim ($_POST["tartalom"]))."',now())";
		$hova="index.php?lng=".$webaktlang."&page=saved";
	}
	//almenüpont aktiválás
	if(isset($_GET["almenustart"]))
	{
		$parancs="update ".$elotag."_almenu_".$webaktlang." set aktiv='1' where kod='".$_GET["almenustart"]."'";
		$hova="index.php?lng=".$webaktlang."&alpage=".$_GET["almenustart"];
	}
	//almenüpont inaktiválás
	if(isset($_GET["almenustop"]))
	{
		$parancs="update ".$elotag."_almenu_".$webaktlang." set aktiv='0' where kod='".$_GET["almenustop"]."'";
		$hova="index.php?lng=".$webaktlang."&alpage=".$_GET["almenustop"];
	}
	//almenüpont és tartalom törlése
	if(isset($_GET["altorol"]))
	{
		$parancs="delete from ".$elotag."_almenu_".$webaktlang." where kod='".$_GET["altorol"]."'";
		$hova="index.php?lng=".$webaktlang."&page=saved";
	}
	//új blokk hozzáadása
	if(isset($_POST["blokknev"]))
	{
		$parancs="insert into ".$elotag."_oldalsav_".$webaktlang." (cim,szoveg,sorszam) values('".$_POST["blokknev"]."','".$_POST["szoveg"]."','".$_POST["sorszam"]."')";
		$hova="index.php?lng=".$webaktlang."&mod=y&blokkok=1";
	}
	//blokk aktiválás
	if(isset($_GET["blokkstart"]))
	{
		$parancs="update ".$elotag."_oldalsav_".$webaktlang." set aktiv='1' where kod='".$_GET["blokkstart"]."'";
		$hova="index.php?lng=".$webaktlang."&mod=y&blokkok=1";
	}
	//blokk inaktiválás
	if(isset($_GET["blokkstop"]))
	{
		$parancs="update ".$elotag."_oldalsav_".$webaktlang." set aktiv='0' where kod='".$_GET["blokkstop"]."'";
		$hova="index.php?lng=".$webaktlang."&mod=y&blokkok=1";
	}
	//blokk tartalom módosítás
	if(isset($_POST["blokkszerk"]))
	{
		$parancs="update ".$elotag."_oldalsav_".$webaktlang." set cim='".$_POST["bcim"]."',szoveg='".$_POST["tartalom"]."' where kod='".$_POST["blokkszerk"]."'";
		$hova="index.php?lng=".$webaktlang."&mod=y&blokkok=".$_POST["blokkszerk"];
	}
	//blokk sorszám módosítás
	if(isset($_GET["blokksorszam"]))
	{
		if($_GET["irany"]=="fel")
		{
			$lekerdez=$pdo->query("select * from ".$elotag."_oldalsav_".$webaktlang." where kod='".$_GET["blokksorszam"]."'");
			$betolt=$lekerdez->fetch();
			
			$ujsorszam=$betolt["sorszam"]-1;
			$ujsorszam2=$betolt["sorszam"];
			
			$lekerdez2=$pdo->query("select * from ".$elotag."_oldalsav_".$webaktlang." where sorszam='".$ujsorszam."'");
			$betolt2=$lekerdez2->fetch();
			
			$muvelet=$pdo->query("update ".$elotag."_oldalsav_".$webaktlang." set sorszam='".$ujsorszam2."' where kod='".$betolt2["kod"]."'");
			$parancs="update ".$elotag."_oldalsav_".$webaktlang." set sorszam='".$ujsorszam."' where kod='".$_GET["blokksorszam"]."'";
		}
		if($_GET["irany"]=="le")
		{
			$lekerdez=$pdo->query("select * from ".$elotag."_oldalsav_".$webaktlang." where kod='".$_GET["blokksorszam"]."'");
			$betolt=$lekerdez->fetch();
			
			$ujsorszam=$betolt["sorszam"]+1;
			$ujsorszam2=$betolt["sorszam"];
			
			$lekerdez2=$pdo->query("select * from ".$elotag."_oldalsav_".$webaktlang." where sorszam='".$ujsorszam."'");
			$betolt2=$lekerdez2->fetch();
			
			$muvelet=$pdo->query("update ".$elotag."_oldalsav_".$webaktlang." set sorszam='".$ujsorszam2."' where kod='".$betolt2["kod"]."'");
			$parancs="update ".$elotag."_oldalsav_".$webaktlang." set sorszam='".$ujsorszam."' where kod='".$_GET["blokksorszam"]."'";
		}
		$hova="index.php?lng=".$webaktlang."&mod=y&blokksormod=1";
	}
	//blokknév és tartalom törlése
	if(isset($_GET["blokktorol"]))
	{
		$parancs="delete from ".$elotag."_oldalsav_".$webaktlang." where kod='".$_GET["blokktorol"]."'";
		$hova="index.php?lng=".$webaktlang."&mod=y&blokkok=1";
	}
	//hír hozzáadása
	if(isset($_POST["hircim"]))
	{
		$furl=str_replace($mirol, $mire, strtolower($_POST["hircim"]));
		$parancs="insert into ".$elotag."_hirkezelo_".$webaktlang."(furl,cim,szoveg,metatitle,metakeywords,metadesc,datum) values('".$furl."','".trim($_POST["hircim"])."','".trim($_POST["szoveg"])."','".trim($_POST["metatitle"])."','".trim($_POST["metakeywords"])."','".trim($_POST["metadesc"])."',now())";
		$hova="index.php?lng=".$webaktlang."&page=blog";
	}
	//hír szerkesztése
	if(isset($_POST["cikkmod"]))
	{
		$furl=str_replace($mirol, $mire, strtolower($_POST["ccim"]));
		if(isset($_FILES['kiskep']) AND $_FILES['kiskep']['name']!="")
		{
			$SafeFile = $_FILES['kiskep']['name'];
			$SafeFile = strtolower($SafeFile);
			$SafeFile = str_replace($mirol, $mire, $SafeFile);

			$datummost=getDate();
			$datekeszit=mktime($datummost["hours"],$datummost["minutes"],$datummost["seconds"],$datummost["mon"],$datummost["mday"],$datummost["year"]);
			$dazo=date("Ymdhms",$datekeszit);
			
			$ext = strtolower(substr(strrchr($_FILES["kiskep"]["name"], "."), 1));
			if($ext == "jpg" || $ext == "jpeg" || $ext == "png")
			{
				$fajlnev=$dazo."_".$SafeFile;
				
				if(move_uploaded_file($_FILES['kiskep']['tmp_name'],"../blog/".$fajlnev))
				{
					list($width, $height) = getimagesize("../blog/".$fajlnev);
					if($width>="1")
					{
						$parancs="update ".$elotag."_hirkezelo_".$webaktlang." set furl='".$furl."',cim='".$_POST["ccim"]."',bevezeto='".$_POST["bevezeto"]."',tags='".$_POST["tags"]."',szoveg='".$_POST["tartalom"]."',kiskep='".$fajlnev."',metatitle='".$_POST["metatitle"]."',metakeywords='".$_POST["metakeywords"]."',metadesc='".$_POST["metadesc"]."',datum=now() where hirkod='".$_POST["cikkmod"]."'";
						$hova="index.php?lng=".$webaktlang."&page=blog";
					}
					else
					{
						unlink("../blog/".$fajlnev);
						echo "<script> alert('Fájl feltöltési hiba, ez nem kép!'); </script>";
						$hova="index.php?lng=".$webaktlang."&page=blog";
					}
				}
				else
				{
					echo "<script> alert('Sikertelen művelet. :( A kép nem volt megfelelő és nem sikerült feltölteni.'); </script>";
					$hova="index.php?lng=".$webaktlang."&page=blog";
				}
			}
			else
			{
				echo "<script> alert('Sikertelen művelet. :( A kép formátuma nem volt megfelelő, a feltölthető formátum: JPG, PNG.'); </script>";
				$hova="index.php?lng=".$webaktlang."&page=blog";
			}
		}
		else
		{
			$parancs="update ".$elotag."_hirkezelo_".$webaktlang." set furl='".$furl."',cim='".$_POST["ccim"]."',bevezeto='".$_POST["bevezeto"]."',tags='".$_POST["tags"]."',szoveg='".$_POST["tartalom"]."',metatitle='".$_POST["metatitle"]."',metakeywords='".$_POST["metakeywords"]."',metadesc='".$_POST["metadesc"]."',datum=now() where hirkod='".$_POST["cikkmod"]."'";
			$hova="index.php?lng=".$webaktlang."&page=blog";
		}
	}
	//hír aktiválás
	if(isset($_GET["hirstart"]))
	{
		$parancs="update ".$elotag."_hirkezelo_".$webaktlang." set aktiv='1' where hirkod='".$_GET["hirstart"]."'";
		$hova="index.php?lng=".$webaktlang."&page=blog";
	}
	//hír inaktiválás
	if(isset($_GET["hirstop"]))
	{
		$parancs="update ".$elotag."_hirkezelo_".$webaktlang." set aktiv='0' where hirkod='".$_GET["hirstop"]."'";
		$hova="index.php?lng=".$webaktlang."&page=blog";
	}
	//hír törlése
	if(isset($_GET["cikktorol"]))
	{
		$parancs="delete from ".$elotag."_hirkezelo_".$webaktlang." where hirkod='".$_GET["cikktorol"]."'";
		$hova="index.php?lng=".$webaktlang."&page=blog";
	}
	//SLIDER blokk hozzáadása
	if(isset($_FILES['ujsliderkep']) AND $_FILES['ujsliderkep']['name']!="")
	{
		$SafeFile = $_FILES['ujsliderkep']['name'];
		$SafeFile = strtolower($SafeFile);
		$SafeFile = str_replace($mirol, $mire, $SafeFile);

		$datummost=getDate();
		$datekeszit=mktime($datummost["hours"],$datummost["minutes"],$datummost["seconds"],$datummost["mon"],$datummost["mday"],$datummost["year"]);
		$dazo=date("Ymdhms",$datekeszit);
		
		$ext = strtolower(substr(strrchr($_FILES["ujsliderkep"]["name"], "."), 1));
		if($ext == "jpg" || $ext == "jpeg" || $ext == "png")
		{
			$fajlnev=$dazo."_".$SafeFile;
			
			if(move_uploaded_file($_FILES['ujsliderkep']['tmp_name'],"../slider/".$fajlnev))
			{
				list($width, $height) = getimagesize("../slider/".$fajlnev);
				if($width>="1")
				{
					$parancs="insert into ".$elotag."_slider(slidert,hiperlink,dumahozza,gombnev,gomblink,slidersor) values('".$fajlnev."','".$_POST["hivatkozas"]."','".$_POST["dumahozza"]."','".$_POST["gombnev"]."','".$_POST["gomblink"]."','".$_POST["slidersor"]."')";
					$hova="index.php?lng=".$webaktlang."&mod=y&sliderek=1";
				}
				else
				{
					unlink("../slider/".$fajlnev);
					echo "<script> alert('Fájl feltöltési hiba, ez nem kép!'); </script>";
					$hova="index.php?lng=".$webaktlang."&mod=y&sliderek=1";
				}
			}
			else
			{
				echo "<script> alert('Sikertelen művelet. :( A kép nem volt megfelelő.'); </script>";
				$hova="index.php?lng=".$webaktlang."&mod=y&sliderek=1";
			}
		}
		else
		{
			echo "<script> alert('Sikertelen művelet. :( A kép formátuma nem volt megfelelő, a feltölthető formátum: JPG, PNG.'); </script>";
			$hova="index.php?lng=".$webaktlang."&mod=y&sliderek=1";
		}
	}
	//SLIDER blokk szerkesztés mentése
	if(isset($_POST["sliderkodmod"]) AND $_POST["sliderkodmod"]!="" AND $_POST["sliderkodmod"]!=" ")
	{
		if($_FILES["modsliderkep"]["name"]!="")
		{
			$SafeFile = $_FILES['modsliderkep']['name'];
			$SafeFile = strtolower($SafeFile);
			$SafeFile = str_replace($mirol, $mire, $SafeFile);

			$datummost=getDate();
			$datekeszit=mktime($datummost["hours"],$datummost["minutes"],$datummost["seconds"],$datummost["mon"],$datummost["mday"],$datummost["year"]);
			$dazo=date("Ymdhms",$datekeszit);
		
			$ext = strtolower(substr(strrchr($_FILES["modsliderkep"]["name"], "."), 1));
			if($ext == "jpg" || $ext == "jpeg" || $ext == "png")
			{
				$fajlnev=$dazo."_".$SafeFile;
				
				if(move_uploaded_file($_FILES['modsliderkep']['tmp_name'],"../slider/".$fajlnev))
				{
					list($width, $height) = getimagesize("../slider/".$fajlnev);
					if($width>="1")
					{
						$parancs="update ".$elotag."_slider set slidert='".$fajlnev."',hiperlink='".$_POST["hivatkozas"]."',dumahozza='".$_POST["dumahozza"]."',gombnev='".$_POST["gombnev"]."',gomblink='".$_POST["gomblink"]."',slidersor='".$_POST["slidersor"]."' where sliderkod='".$_POST["sliderkodmod"]."')";
						$hova="index.php?lng=".$webaktlang."&mod=y&sliderek=1";
					}
					else
					{
						unlink("../slider/".$fajlnev);
						echo "<script> alert('Fájl feltöltési hiba, ez nem kép!'); </script>";
						$hova="index.php?lng=".$webaktlang."&mod=y&sliderek=1";
					}
				}
				else
				{
					echo "<script> alert('Sikertelen művelet. :( A kép nem volt megfelelő.'); </script>";
					$hova="index.php?lng=".$webaktlang."&mod=y&sliderek=1";
				}
			}
			else
			{
				echo "<script> alert('Sikertelen művelet. :( A kép formátuma nem volt megfelelő, a feltölthető formátum: JPG, PNG.'); </script>";
				$hova="index.php?lng=".$webaktlang."&mod=y&sliderek=1";
			}
		}
		else
		{
			$parancs="update ".$elotag."_slider set hiperlink='".$_POST["hivatkozas"]."',dumahozza='".$_POST["dumahozza"]."',gombnev='".$_POST["gombnev"]."',gomblink='".$_POST["gomblink"]."',slidersor='".$_POST["slidersor"]."' where sliderkod='".$_POST["sliderkodmod"]."'";
			$hova="index.php?lng=".$webaktlang."&mod=y&sliderek=1";
		}
	}
	//SLIDER blokk törlése
	if(isset($_GET["sliderdel"]))
	{
		$bt=$pdo->query("select * from ".$elotag."_slider where sliderkod='".$_GET["sliderdel"]."'");
		$kpt=$bt->fetch();
		if($kpt["slidert"]!="" AND $kpt["slidert"]!=" ")
		{
			unlink("../slider/".$kpt["slidert"]);
		}
		$parancs="delete from ".$elotag."_slider where sliderkod='".$_GET["sliderdel"]."'";
		$hova="index.php?lng=".$webaktlang."&mod=y&sliderek=1";
	}
	//új nyelv hozzáadásának mentése
	if(isset($_POST["ujnyelv"]))
	{
		//menüpont és oldalak létrehozása
		$letrehoz_menu_most=$pdo->query("CREATE TABLE ".$elotag."_menu_".$_POST["ujnyelv"]." (kod INT(10) auto_increment, furl TEXT, tolink TEXT, aktiv INT(2), nev VARCHAR(50), tartalom TEXT, metatitle TEXT, metakeywords TEXT, metadesc TEXT, sorszam VARCHAR(2), datum DATETIME DEFAULT '0000-00-00 00:00:00', PRIMARY KEY(kod)) DEFAULT CHARSET=utf8");
		$feltolt_menu_most=$pdo->query("insert into ".$elotag."_menu_".$_POST["ujnyelv"]." (furl,nev,tartalom,sorszam,aktiv) values ('/','Üdvözlet a K.E.K.-ben!','<br /><font face=Verdana size=3 color=#3333DD><b>Sikeresen feltelepítette a K.E.K. CMS programot!</b></font><br /><br /><font face=Verdana size=2 color=#000000>Mostmár használatba veheti a CMS motort! Az adminisztráció linkre kattintva tud bejelentkezni, majd login után szerkeszteni ezt a szöveget is, illetve minden mást a rendszeren belül! Sikeres felhasználást kívánok!</font>','1','1')");
		//almenü létrehozása
		$letrehoz_almenu_most=$pdo->query("CREATE TABLE ".$elotag."_almenu_".$_POST["ujnyelv"]." (kod INT(10) auto_increment, furl TEXT, tolink TEXT, aktiv INT(2), nev VARCHAR(50), szulo int(20), tartalom TEXT, metatitle TEXT, metakeywords TEXT, metadesc TEXT, datum DATETIME DEFAULT '0000-00-00 00:00:00', PRIMARY KEY(kod)) DEFAULT CHARSET=utf8");
		//oldalsáv és tartalma létrehozása
		$letrehoz_oldalsav_most=$pdo->query("CREATE TABLE ".$elotag."_oldalsav_".$_POST["ujnyelv"]." (kod INT(10) auto_increment, cim VARCHAR(200), aktiv INT(2), szoveg TEXT, sorszam VARCHAR(2), PRIMARY KEY(kod)) DEFAULT CHARSET=utf8");
		$feltolt_oldalsav_most=$pdo->query("insert into ".$elotag."_oldalsav_".$_POST["ujnyelv"]." (cim,szoveg,sorszam) values ('Doboz','Ide blokkokat helyezhet el, szerkesztheti őket, illetve törölni is tudja, ha nem kellenek! Mindezt az adminon való bejelentkezés után tudja megtenni! Az adminisztrátori bejelentkezéshez a telepítés során adta meg a hozzáférést!','1')");
		//blog létrehozása (ha van!)
		$vanblog=$pdo->query("select * from ".$elotag."_modulok where modulnev='blog'");
		if($vanblog->rowCount()>0)
		{
			$letrehoz_hir=$pdo->query("CREATE TABLE ".$elotag."_hirkezelo_".$_POST["ujnyelv"]." (hirkod INT(20) auto_increment, furl TEXT, aktiv INT(2), cim VARCHAR(200), bevezeto VARCHAR(200), tags VARCHAR(200), szoveg TEXT, kiskep TEXT, metatitle TEXT, metakeywords TEXT, metadesc TEXT, datum DATETIME DEFAULT '0000-00-00 00:00:00', PRIMARY KEY (hirkod)) DEFAULT CHARSET=utf8");
		}
		
		$parancs="insert into ".$elotag."_nyelvek (langnev) values ('".$_POST["ujnyelv"]."')";
		$hova="index.php?lng=".$webaktlang."&page=saved";
	}
	//nyelv törlése
	if(isset($_GET["nyelvdel"]))
	{
		if($_GET["nyelvdel"]!="hun")
		{
			$nyelvmtorles=$pdo->query("DROP TABLE ".$elotag."_menu_".$_GET["nyelvdel"]." ");
			$nyelvatorles=$pdo->query("DROP TABLE ".$elotag."_almenu_".$_GET["nyelvdel"]." ");
			$nyelvotorles=$pdo->query("DROP TABLE ".$elotag."_oldalsav_".$_GET["nyelvdel"]." ");
			$nyelvotorles=$pdo->query("DROP TABLE ".$elotag."_hirkezelo_".$_GET["nyelvdel"]." ");
			$parancs="delete from ".$elotag."_nyelvek where langnev='".$_GET["nyelvdel"]."'";
				$weblangok=$pdo->query("select langnev from ".$elotag."_nyelvek order by langkod");
				$webegylang=$weblangok->fetch();
				$webaktlang=$webegylang["langnev"];
			$hova="index.php?lng=".$webaktlang."&page=saved";
		}
		else
		{
			echo "<script> alert('Sikertelen művelet. Az alapvető magyar nyelv NEM törölhető!'); </script>";
			$hova="index.php?lng=".$webaktlang."";
		}
	}
	//google analytics kód mentése
	if(isset($_POST["ganalkey"]))
	{
		$leker=$pdo->query("select * from ".$elotag."_ganal");
		if($leker->rowCount()>0)
		{
			$parancs="update ".$elotag."_ganal set ganalkey='".$_POST["ganalkey"]."'";
		}
		else
		{
			$parancs="insert into ".$elotag."_ganal (ganalkey) values ('".$_POST["ganalkey"]."')";
		}
		$hova="index.php?lng=".$webaktlang."&mod=y&ganal=1";
	}
	//sitemap.xml készítés
	if(isset($_POST["xmlsitemap"]))
	{
		//alapok deklarálása
		$menupontok="";
		$almenupontok="";
		$cikkek="";
		$elolap="<?xml version='1.0' encoding='UTF-8'?>
<urlset
	xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'
	xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance'
	xsi:schemaLocation='http://www.sitemaps.org/schemas/sitemap/0.9
	http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd'>";
		//elsődleges nyelv meghatározása
		$egylang=$pdo->query("select * from ".$elotag."_nyelvek limit 1");
		$ezanyelv=$egylang->fetch();
		$nyelv=$ezanyelv["langnev"];
		//menük behivása
		$menuk=$pdo->query("select * from ".$elotag."_menu_".$nyelv." where aktiv='1'");
		while($e=$menuk->fetch())
		{
			$menupontok.='<url>
						  <loc>'.$webadatok["defaultlink"].'/'.$e["furl"].'</loc>
						  <lastmod>'.str_replace(" ","T",$e["datum"]).'+00:00</lastmod>
						  <priority>1.00</priority>
						</url>';
		}
		//almenük behivása
		$almenuk=$pdo->query("select * from ".$elotag."_almenu_".$nyelv." where aktiv='1'");
		while($a=$almenuk->fetch())
		{
			$almenupontok.='<url>
						  <loc>'.$webadatok["defaultlink"].'/'.$a["furl"].'</loc>
						  <lastmod>'.str_replace(" ","T",$a["datum"]).'+00:00</lastmod>
						  <priority>0.80</priority>
						</url>';
		}
		//blog behivása
		$blog=$pdo->query("select * from ".$elotag."_hirkezelo_".$nyelv." where aktiv='1'");
		if($blog)
		{
			while($b=$blog->fetch())
			{
				$cikkek.='<url>
							  <loc>'.$webadatok["defaultlink"].'/'.$b["furl"].'</loc>
							  <lastmod>'.str_replace(" ","T",$b["datum"]).'+00:00</lastmod>
							  <priority>1.00</priority>
							</url>';
			}
		}
		//meglévő oldaltérkép létezés vizsgálat
		if(file_exists("../sitemap.xml"))
		{
			unlink("../sitemap.xml");
		}
		else
		{
			touch("../sitemap.xml");
		}
		//sitemap összefoglalás
		$fullsitemap=$elolap.$menupontok.$almenupontok.$cikkek."</urlset>";
		//sitemap irása
		$fm=fopen("../sitemap.xml","a");
		fwrite($fm,$fullsitemap);
		$parancs="select langnev from ".$elotag."_nyelvek limit 1";
		$hova="index.php";
	}
	//weboldal paraméterek módosítása
	if(isset($_POST["title"]))
	{
		if(isset($_FILES['ogimage']) AND $_FILES['ogimage']['name']!="")
		{
			$SafeFile = $_FILES['ogimage']['name'];
			$SafeFile = strtolower($SafeFile);
			$SafeFile = str_replace($mirol, $mire, $SafeFile);
			
			$datummost=getDate();
			$datekeszit=mktime($datummost["hours"],$datummost["minutes"],$datummost["seconds"],$datummost["mon"],$datummost["mday"],$datummost["year"]);
			$dazo=date("Ymdhms",$datekeszit);
			$fajlnev=$SafeFile;
			
			$ext = strtolower(substr(strrchr($_FILES["ogimage"]["name"], "."), 1));
			if($ext == "jpg" || $ext == "jpeg" || $ext == "png")
			{
				if(move_uploaded_file($_FILES['ogimage']['tmp_name'],"../".$fajlnev))
				{
					list($width, $height) = getimagesize("../".$fajlnev);
					if($width>="1")
					{
						$ogimage=$fajlnev;
						$parancs="update ".$elotag."_parameterek set title='".$_POST["title"]."',keywords='".$_POST["keywords"]."',description='".$_POST["description"]."',sitename='".$_POST["sitename"]."',siteslogen='".$_POST["siteslogen"]."',copyright='".$_POST["copyright"]."',sablon='".$_POST["sablon"]."',ogimage='".$ogimage."'";
						$hova="index.php?lng=".$webaktlang."&mod=y&settings=1";
					}
					else
					{
						unlink("../".$fajlnev);
						echo "<script> alert('Fájl feltöltési hiba, ez nem kép!'); </script>";
						$hova="index.php?lng=".$webaktlang."&mod=y&settings=1";
					}
				}
				else
				{
					echo "<script> alert('Sikertelen művelet. :( A képet nem sikerült feltölteni.'); </script>";
					$hova="index.php?lng=".$webaktlang."&page=blog";
				}
				
			}
			else
			{
				echo "<script> alert('Sikertelen művelet. :( A kép formátuma nem volt megfelelő, a feltölthető formátum: JPG, PNG.'); </script>";
				$hova="index.php?lng=".$webaktlang."&mod=y&settings=1";
			}
		}
		else
		{
			$parancs="update ".$elotag."_parameterek set title='".$_POST["title"]."',keywords='".$_POST["keywords"]."',description='".$_POST["description"]."',sitename='".$_POST["sitename"]."',siteslogen='".$_POST["siteslogen"]."',copyright='".$_POST["copyright"]."',sablon='".$_POST["sablon"]."'";
			$hova="index.php?lng=".$webaktlang."&mod=y&settings=1";
		}
	}
	//karbantartás mód bekapcsolása
	if(isset($_GET["breakoff"]))
	{
		$parancs="update ".$elotag."_parameterek set breakoff='".$_GET["breakoff"]."'";
		$hova="index.php";
	}
	//social linkek mentése
	if(isset($_POST["socialsite"]))
	{
		$socialsite=$_POST["socialsite"];
		$sociallink=$_POST["sociallink"];
		for($i=1; $i<=6; $i++)
		{
			$pdo->query("update ".$elotag."_social set sociallink='".$sociallink[$i]."' where socialsite like '".$socialsite[$i]."%'");
		}
		//álparancs küldése, hogy TRUE legyen a buli :)
		$parancs="select sociallink from ".$elotag."_social where socialsite='Facebook'";
		$hova="index.php?lng=".$webaktlang."&mod=y&social=1";
	}
	//google maps link mentése
	if(isset($_POST["gmapskey"]))
	{
		$mapsmod=$pdo->query("select * from ".$elotag."_gmaps");
		if($mapsmod->rowCount()>0)
		{
			$parancs="update ".$elotag."_gmaps set gmapskey='".$_POST["gmapskey"]."'";
		}
		else
		{
			$parancs="insert into ".$elotag."_gmaps (gmapskey) values('".$_POST["gmapskey"]."')";
		}
		$hova="index.php?lng=".$webaktlang."&mod=y&gmaps=1";
	}
	//LETÖLTÉS hozzáadása
	if(isset($_FILES['ujdown']) AND $_FILES['ujdown']['name']!="")
	{
		$SafeFile = $_FILES['ujdown']['name'];
		$SafeFile = strtolower($SafeFile);
		$SafeFile = str_replace($mirol, $mire, $SafeFile);
		
		$datummost=getDate();
		$datekeszit=mktime($datummost["hours"],$datummost["minutes"],$datummost["seconds"],$datummost["mon"],$datummost["mday"],$datummost["year"]);
		$dazo=date("Ymdhms",$datekeszit);
		$fajlnev=$dazo."_".$SafeFile;
		
		if(move_uploaded_file($_FILES['ujdown']['tmp_name'],"../letoltesek/".$fajlnev))
		{
			$parancs="insert into ".$elotag."_letoltesek(lelink,lenev,leleiras) values('".$fajlnev."','".$_POST["lenev"]."','".$_POST["leleiras"]."')";
		}
		else
		{
			echo "<script> alert('Fájl feltöltési hiba!'); </script>";
		}
		$hova="index.php?lng=".$webaktlang."&mod=y&downmod=1";
	}
	//letöltés blokk törlése
	if(isset($_GET["downdel"]))
	{
		$bt=$pdo->query("select * from ".$elotag."_letoltesek where lekod='".$_GET["downdel"]."'");
		$kpt=$bt->fetch();
		unlink("../letoltesek/".$kpt["lelink"]);
		$parancs="delete from ".$elotag."_letoltesek where lekod='".$_GET["downdel"]."'";
		$hova="index.php?lng=".$webaktlang."&mod=y&downmod=1";
	}
	//új videó hozzáadása
	if(isset($_POST["ujvideocim"]))
	{		
		$parancs="insert into ".$elotag."_videok(videocim,vhiv,vtext) values('".$_POST["ujvideocim"]."','".$_POST["vhiv"]."','".$_POST["vtext"]."')";
		$hova="index.php?lng=".$webaktlang."&page=video";
	}
	//videó módosítás mentés
	if(isset($_POST["videomodkod"]))
	{		
		$parancs="update ".$elotag."_videok set videocim='".$_POST["videocim"]."',vhiv='".$_POST["vhiv"]."',vtext='".$_POST["vtext"]."' where videokod='".$_POST["videomodkod"]."'";
		$hova="index.php?lng=".$webaktlang."&page=video";
	}
	//videó törlése
	if(isset($_GET["videotorol"]))
	{
		$parancs="delete from ".$elotag."_videok where videokod='".$_GET["videotorol"]."'";
		$hova="index.php?lng=".$webaktlang."&page=video";
	}
	//felhasználói adatok módosításának mentése
	if(isset($_POST["ujadminpass"]))
	{
		$parancs="update ".$elotag."_admin set nev='".$_POST["ujadminnev"]."',email='".$_POST["ujemailcim"]."',jelszo='".md5($_POST["ujadminpass"])."' where kod='".$_POST["userkod"]."'";
		$hova="index.php?lng=".$webaktlang."&mod=y&usermod=1";
	}
	//felhasználó hozzáadásának mentése
	if(isset($_POST["newadminnev"]))
	{
		$parancs="insert into ".$elotag."_admin (nev,email,jelszo) values('".$_POST["newadminnev"]."','".$_POST["newemailcim"]."','".md5($_POST["newadminpass"])."')";
		$hova="index.php?lng=".$webaktlang."";
	}
	//modulok telepítése
	if(isset($_POST["modulinstall"]) AND $_POST["modulinstall"]!="" AND $_POST["modulinstall"]!=" " AND $_SESSION["userlogged"]=="nimda")
	{
		if(isset($_POST["slidermodul"]))
		{
			if($_POST["slidermodul"]=="igen")
			{
				$modules=$pdo->query("select * from ".$elotag."_modulok where modulnev='slider'");
				if($modules->rowCount()>0)
				{
					$save_mod=$pdo->query("update ".$elotag."_modulok set bekapcsolva='".$_POST["slidermodul"]."' where modulnev='slider'");
				}
				else
				{
					$save_mod=$pdo->query("insert into ".$elotag."_modulok (modulnev,bekapcsolva) values('slider','".$_POST["slidermodul"]."')");
					$letrehoz_slider=$pdo->query("CREATE TABLE ".$elotag."_slider (sliderkod INT(10) auto_increment, slidert TEXT, hiperlink TEXT, dumahozza TEXT, PRIMARY KEY(sliderkod)) DEFAULT CHARSET=utf8");
					mkdir("../slider", 0777, true);
				}
			}
			else
			{
				$save_mod=$pdo->query("update ".$elotag."_modulok set bekapcsolva='".$_POST["slidermodul"]."' where modulnev='slider'");
			}
		}
		if(isset($_POST["galeriamodul"]))
		{
			if($_POST["galeriamodul"]=="igen")
			{
				$modules=$pdo->query("select * from ".$elotag."_modulok where modulnev='galeria'");
				if($modules->rowCount()>0)
				{
					$save_mod=$pdo->query("update ".$elotag."_modulok set bekapcsolva='".$_POST["galeriamodul"]."' where modulnev='galeria'");
				}
				else
				{
					$save_mod=$pdo->query("insert into ".$elotag."_modulok (modulnev,bekapcsolva) values('galeria','".$_POST["galeriamodul"]."')");
					$letrehoz_galeria=$pdo->query("CREATE TABLE ".$elotag."_mappak (mappakod INT(10) AUTO_INCREMENT, furl TEXT, mappanev TEXT, mappaut TEXT, mappakep TEXT, PRIMARY KEY (mappakod)) DEFAULT CHARSET=utf8");
					mkdir("../galeria", 0777, true);
					mkdir("../leirasok", 0777, true);
				}
			}
			else
			{
				$save_mod=$pdo->query("update ".$elotag."_modulok set bekapcsolva='".$_POST["galeriamodul"]."' where modulnev='galeria'");
			}
		}
		if(isset($_POST["videomodul"]))
		{
			if($_POST["videomodul"]=="igen")
			{
				$modules=$pdo->query("select * from ".$elotag."_modulok where modulnev='video'");
				if($modules->rowCount()>0)
				{
					$save_mod=$pdo->query("update ".$elotag."_modulok set bekapcsolva='".$_POST["videomodul"]."' where modulnev='video'");
				}
				else
				{
					$save_mod=$pdo->query("insert into ".$elotag."_modulok (modulnev,bekapcsolva) values('video','".$_POST["videomodul"]."')");
					$letrehoz_video=$pdo->query("CREATE TABLE ".$elotag."_videok (videokod INT(10) AUTO_INCREMENT, videocim TEXT, vhiv TEXT, PRIMARY KEY (videokod)) DEFAULT CHARSET=utf8");
				}
			}
			else
			{
				$save_mod=$pdo->query("update ".$elotag."_modulok set bekapcsolva='".$_POST["videomodul"]."' where modulnev='video'");
			}
		}
		if(isset($_POST["hirekmodul"]))
		{	
			if($_POST["hirekmodul"]=="igen")
			{
				$modules=$pdo->query("select * from ".$elotag."_modulok where modulnev='blog'");
				if($modules->rowCount()>0)
				{
					$save_mod=$pdo->query("update ".$elotag."_modulok set bekapcsolva='".$_POST["hirekmodul"]."' where modulnev='blog'");
				}
				else
				{
					$save_mod=$pdo->query("insert into ".$elotag."_modulok (modulnev,bekapcsolva) values('blog','".$_POST["hirekmodul"]."')");
					$nyelvek=$pdo->query("select * from ".$elotag."_nyelvek");
					while($egynyelv=$nyelvek->fetch())
					{
						$val=$egynyelv["langnev"];
						$letrehoz_hir=$pdo->query("CREATE TABLE ".$elotag."_hirkezelo_".$val." (hirkod INT(20) auto_increment, furl TEXT, aktiv INT(2), cim VARCHAR(200), bevezeto VARCHAR(200), tags VARCHAR(200), szoveg TEXT, kiskep TEXT, metatitle TEXT, metakeywords TEXT, metadesc TEXT, datum DATETIME DEFAULT '0000-00-00 00:00:00', PRIMARY KEY (hirkod)) DEFAULT CHARSET=utf8");
					}
					mkdir("../blog", 0777, true);
					if(!file_exists("../blog/index.php"))
					{
						touch("../blog/index.php");
					}
					$fm=fopen("../blog/index.php","w");
					fwrite($fm,"<?php \n include('../connect.php'); \n header('Content-Type: application/rss+xml; charset=UTF-8'); \n \$rssfeed = '<?xml version=\"1.0\" encoding=\"UTF-8\"?>'; \n \$rssfeed .= '<rss version=\"2.0\">'; \n \$rssfeed .= '<channel>'; \n \$rssfeed .= '<title>Blog Feed</title>'; \n \$rssfeed .= '<link>".$absp."/blog/</link>'; \n \$rssfeed .= '<description>RSS FEED</description>'; \n \$rssfeed .= '<language>hu</language>'; \n \$rssfeed .= '<copyright>Copyright (C) ".date('Y')." ".$absp."</copyright>'; \n \$query = \$pdo->query('SELECT * FROM '.\$elotag.'_hirkezelo_hun ORDER BY datum DESC'); \n while(\$row = \$query->fetch()) { \n \$rssfeed .= '<item>'; \n \$rssfeed .= '<title>'.\$row['cim'].'</title>'; \n \$rssfeed .= '<description>'.\$row['bevezeto'].'</description>'; \n \$rssfeed .= '<link>'.\$absp.'/blog/'.\$row['furl'].'</link>'; \n \$rssfeed .= '<pubDate>'.\$row['datum'].' +0000</pubDate>'; \n \$rssfeed .= '</item>'; \n} \n \$rssfeed .= '</channel>'; \n \$rssfeed .= '</rss>'; \n echo \$rssfeed; \n ?>");
				}
			}
			else
			{
				$save_mod=$pdo->query("update ".$elotag."_modulok set bekapcsolva='".$_POST["hirekmodul"]."' where modulnev='blog'");
			}
		}
		if(isset($_POST["socialmod"]))
		{
			if($_POST["socialmod"]=="igen")
			{
				$modules=$pdo->query("select * from ".$elotag."_modulok where modulnev='social'");
				if($modules->rowCount()>0)
				{
					$save_mod=$pdo->query("update ".$elotag."_modulok set bekapcsolva='".$_POST["socialmod"]."' where modulnev='social'");
				}
				else
				{
					$save_mod=$pdo->query("insert into ".$elotag."_modulok (modulnev,bekapcsolva) values('social','".$_POST["socialmod"]."')");
					
					$letrehoz_social=$pdo->query("CREATE TABLE ".$elotag."_social (sockod INT(10) auto_increment, socialsite TEXT, sociallink TEXT, PRIMARY KEY(sockod)) DEFAULT CHARSET=utf8");
					
					$pdo->query("insert into ".$elotag."_social (socialsite,sociallink) values('Facebook','#')");
					$pdo->query("insert into ".$elotag."_social (socialsite,sociallink) values('Twitter','#')");
					$pdo->query("insert into ".$elotag."_social (socialsite,sociallink) values('Google Plus','#')");
					$pdo->query("insert into ".$elotag."_social (socialsite,sociallink) values('Pinterest','#')");
					$pdo->query("insert into ".$elotag."_social (socialsite,sociallink) values('Instagram','#')");
					$pdo->query("insert into ".$elotag."_social (socialsite,sociallink) values('Youtube','#')");
				}
			}
			else
			{
				$save_mod=$pdo->query("update ".$elotag."_modulok set bekapcsolva='".$_POST["socialmod"]."' where modulnev='social'");
			}
		}
		if(isset($_POST["gmaps"]))
		{
			if($_POST["gmaps"]=="igen")
			{
				$modules=$pdo->query("select * from ".$elotag."_modulok where modulnev='gmaps'");
				if($modules->rowCount()>0)
				{
					$save_mod=$pdo->query("update ".$elotag."_modulok set bekapcsolva='".$_POST["gmaps"]."' where modulnev='gmaps'");
				}
				else
				{
					$save_mod=$pdo->query("insert into ".$elotag."_modulok (modulnev,bekapcsolva) values('gmaps','".$_POST["gmaps"]."')");
					$letrehoz_gmaps=$pdo->query("CREATE TABLE ".$elotag."_gmaps (gmkod INT(2) auto_increment, gmapskey TEXT, PRIMARY KEY(gmkod)) DEFAULT CHARSET=utf8");
				}
			}
			else
			{
				$save_mod=$pdo->query("update ".$elotag."_modulok set bekapcsolva='".$_POST["gmaps"]."' where modulnev='gmaps'");
			}
		}
		if(isset($_POST["downmodul"]))
		{
			if($_POST["downmodul"]=="igen")
			{
				$modules=$pdo->query("select * from ".$elotag."_modulok where modulnev='letoltes'");
				if($modules->rowCount()>0)
				{
					$save_mod=$pdo->query("update ".$elotag."_modulok set bekapcsolva='".$_POST["downmodul"]."' where modulnev='letoltes'");
				}
				else
				{
					$save_mod=$pdo->query("insert into ".$elotag."_modulok (modulnev,bekapcsolva) values('letoltes','".$_POST["downmodul"]."')");
					$letrehoz_down=$pdo->query("CREATE TABLE ".$elotag."_letoltesek (lekod INT(20) auto_increment, lelink VARCHAR(200), lenev TEXT, leleiras TEXT, PRIMARY KEY (lekod)) DEFAULT CHARSET=utf8");
					mkdir("../letoltesek", 0777, true);
				}
			}
			else
			{
				$save_mod=$pdo->query("update ".$elotag."_modulok set bekapcsolva='".$_POST["downmodul"]."' where modulnev='letoltes'");
			}
		}
		if(isset($_POST["shopmodul"]))
		{
			if($_POST["shopmodul"]=="igen")
			{
				$modules=$pdo->query("select * from ".$elotag."_modulok where modulnev='shop'");
				if($modules->rowCount()>0)
				{
					$save_mod=$pdo->query("update ".$elotag."_modulok set bekapcsolva='".$_POST["shopmodul"]."' where modulnev='shop'");
				}
				else
				{
					$save_mod=$pdo->query("insert into ".$elotag."_modulok (modulnev,bekapcsolva) values('shop','".$_POST["shopmodul"]."')");
					$letrehoz_shop=$pdo->query("CREATE TABLE ".$elotag."_shop_termek (t_id int(20) NOT NULL AUTO_INCREMENT, t_gyarto varchar(200) NOT NULL, t_nev text NOT NULL, t_ar varchar(200) NOT NULL, t_kategoria varchar(200) NOT NULL, t_fkep text NOT NULL, t_kepek text NOT NULL, t_kleiras varchar(200) NOT NULL, t_nleiras text NOT NULL, t_datum date NOT NULL DEFAULT '0000-00-00', t_pdf text NOT NULL, PRIMARY KEY (t_id)) DEFAULT CHARSET=utf8");
					$letrehoz_gyartok=$pdo->query("CREATE TABLE ".$elotag."_shop_gyartok (shop_gyartoid int(20) NOT NULL AUTO_INCREMENT, shop_gyartonev varchar(200) NOT NULL, PRIMARY KEY (shop_gyartoid)) DEFAULT CHARSET=utf8");
					$letrehoz_kategok=$pdo->query("CREATE TABLE ".$elotag."_shop_kategoriak (shop_kategoriaid int(20) NOT NULL AUTO_INCREMENT, shop_kategkep text NOT NULL, shop_kategorianev varchar(200) NOT NULL, PRIMARY KEY (shop_kategoriaid)) DEFAULT CHARSET=utf8");
					$letrehoz_rendelesek=$pdo->query("CREATE TABLE ".$elotag."_shop_rendelesek (m_id int(20) NOT NULL AUTO_INCREMENT, megrendelo text NOT NULL, tetelek text NOT NULL, szallitas text NOT NULL, fizetes varchar(200) NOT NULL, datum date NOT NULL, duma text NOT NULL, PRIMARY KEY (m_id)) DEFAULT CHARSET=utf8");
					mkdir("../shop", 0777, true);
					mkdir("../shop/kepek", 0777, true);
					mkdir("../shop/kateg", 0777, true);
				}
			}
			else
			{
				$save_mod=$pdo->query("update ".$elotag."_modulok set bekapcsolva='".$_POST["shopmodul"]."' where modulnev='shop'");
			}
		}
		
		$parancs="select title from ".$elotag."_parameterek";
		$hova="index.php?lng=".$webaktlang."";
	}
	//parancsok lefuttatása
	if($pdo->query($parancs))
	{
		echo "<script>				    
					function atiranyit()
					{
						location.href = 'index.php?lng=".$webaktlang."&page=saved&url=".urlencode($hova)."';
					}
					ID = window.setTimeout('atiranyit();', 1*1);
			   </script>";
	}
}
else { echo 'ERROR!'; }
?>