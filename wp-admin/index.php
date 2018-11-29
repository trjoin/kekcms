<?php
session_start();
include_once("../connect.php");
$baseurl=$_SERVER["SERVER_NAME"];
$url=explode(".",$baseurl);
$absp=(isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER["HTTP_HOST"];
$fullurl=$absp.$_SERVER["REQUEST_URI"];
$webosszetevok=$pdo->query("select * from ".$elotag."_parameterek");
$webadatok=$webosszetevok->fetch();
/*** használati nyelv letárolás ***/
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
/*** login-logout kontrol ***/
if(isset($_GET["kilepes"]))
{
	session_unset();
}
if(isset($_POST["username"]) AND $_POST["username"]!="" AND $_POST["username"]!=" ")
{
	$login=$pdo->prepare("select * from ".$elotag."_admin where nev=? and jelszo=? ");
	$login->execute(array($_POST["username"],md5($_POST["password"])));
	if($login->rowCount()>0)
	{
		if(file_exists("../supportend.php"))
		{
			include("../supportend.php");
			$datumt = strtotime($support);
			$finale = date("Y-m-d", strtotime("+24 month", $datumt));
			if($finale>=$ma)
			{
				$egy_sor=$login->fetch(\PDO::FETCH_ASSOC);
				$_SESSION["userlogged"]=$egy_sor["nev"];
			}
			else
			{
				/*** $error="<span style='color:#f00;'>Az Ön terméktámogatása (24 hónap) lejárt, kérjük a szoftver használatának meghosszabbításához keressen minket elérhetőségeinken!</span><br>"; ***/
				$egy_sor=$login->fetch(\PDO::FETCH_ASSOC);
				$_SESSION["userlogged"]=$egy_sor["nev"];
				echo '<script> alert(\'Az Ön szoftverének terméktámogatása lejárt, a további zavartalan használhatoz kérjük keressen fel bennünket elérhetőségeinken.\'); </script>';
			}
		}
	}
	else
	{
		$error="<span style='color:#f00;'>Hibás felhasználónév vagy jelszó!</span><br>";
	}
}
?>
<!DOCTYPE html>
<html lang="hu">
  <head>
    <meta charset="utf-8" />
    <title><?php print($webadatok["title"]); ?> - [K.E.K. Admin] &raquo;</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <link href="./css/bootstrap.min.css" rel="stylesheet" />
    <link href="./css/bootstrap-responsive.min.css" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
	<link href="./css/font-awesome.min.css" rel="stylesheet" />
    <link href="./css/ui-lightness/jquery-ui-1.10.0.custom.min.css" rel="stylesheet" />
    <link href="./css/base-admin-2.css" rel="stylesheet" />
    <link href="./css/base-admin-2-responsive.css" rel="stylesheet" />
    <link href="./css/pages/dashboard.css" rel="stylesheet" />
	<link href="./css/pages/signin.css" rel="stylesheet" type="text/css" />
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet" />
    <!--[if lt IE 9]>
      <script src="https://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
	<script src="./js/libs/jquery-1.8.3.min.js"></script>
	<script src="./js/libs/jquery-ui-1.10.0.custom.min.js"></script>
	<script src="./js/libs/bootstrap.min.js"></script>
	<script src="./js/plugins/validate/jquery.validate.js"></script>
	<script src="./js/Application.js"></script>
	<script src="./js/demo/validation.js"></script>
</head>
<body>
<div class="navbar navbar-inverse navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"><i class="icon-cog"></i></a>
			<a class="brand" href="index.php"><img src="https://trswebdesign.hu/images/logo.png" border="0" style="max-height:25px;" alt="K.E.K. CMS Rendszer"> K.E.K. CMS <small>v2.2</small></span></a>
			<div class="nav-collapse collapse">
				<ul class="nav pull-right">
					<li><a href="#"><b>Ügyfélszolgálat:</b></a></li>
					<li><a href="mailto:info@trswebdesign.hu"><i class="fa fa-envelope-o" aria-hidden="true"></i> info@trswebdesign.hu</a></li>
					<li><a href="tel:+36301849337"><i class="fa fa-phone" aria-hidden="true"></i> +36-30/184-93-37</a></li>
<?php
if(isset($_SESSION["userlogged"]) AND $_SESSION["userlogged"]!="" AND $_SESSION["userlogged"]!=" " AND $_SESSION["userlogged"]!="1")
{
	echo '			<li class="dropdown">						
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<b>Üdvözöllek</b> 
							<i class="icon-user"></i> 
							'.$_SESSION["userlogged"].'
							<b class="caret"></b>
						</a>						
						<ul class="dropdown-menu">
							<li><a href="index.php?lng='.$webaktlang.'&mod=y&usermod=1">Profil</a></li>
							<li class="divider"></li>
							<li><a href="?kilepes">Kilépés</a></li>
						</ul>
					</li>';
}
?>
				</ul>
			</div>
		</div>
	</div>
</div>
<?php
if(isset($_SESSION["userlogged"]) AND $_SESSION["userlogged"]!="" AND $_SESSION["userlogged"]!=" " AND $_SESSION["userlogged"]!="1") //LOGIN UTÁNI MEGJELENITÉS
{
	/*** MENÜSÁV ***/
	echo '<div class="subnavbar">
			<div class="subnavbar-inner">
				<div class="container">
					<a class="btn-subnavbar collapsed" data-toggle="collapse" data-target=".subnav-collapse"><i class="icon-reorder"></i></a>
					<div class="subnav-collapse collapse">
						<ul class="mainnav">
						
							<li class="active">
								<a href="index.php">
									<i class="icon-home"></i>
									<span>Kezdőoldal</span>
								</a>	    				
							</li>';
	// menüpontok //
	echo '					<li class="dropdown">					
								<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
									<i class="icon-copy"></i>
									<span>Oldalak</span>
									<b class="caret"></b>
								</a>
								<ul class="dropdown-menu">';
	$menu=$pdo->query("select * from ".$elotag."_menu_".$webaktlang." order by kod asc");
	while($egy_menupont=$menu->fetch())
	{
		$almenu=$pdo->query("select * from ".$elotag."_almenu_".$webaktlang." where szulo='".$egy_menupont["kod"]."'");
		if($almenu->rowCount()>0)
		{			
			echo '<li class="dropdown-submenu">
					  <a tabindex="-1" href="index.php?lng='.$webaktlang.'&page='.$egy_menupont["kod"].'">'.$egy_menupont["nev"].'</a>
					  <ul class="dropdown-menu">';
				while($eamp=$almenu->fetch())
				{
					echo '<li tabindex="-2"><a href="index.php?lng='.$webaktlang.'&alpage='.$eamp["kod"].'">'.$eamp["nev"].'</a></li>';
				}
				echo '  <li class="divider"></li>
						<li><a tabindex="-2" href="index.php?lng='.$webaktlang.'&mod=y&ujalmenu='.$egy_menupont["kod"].'">&plus; Új almenüpont</a></li>
					  </ul>
					</li>';
		}
		else
		{
			echo '<li class="dropdown-submenu">
					<a tabindex="-1" href="index.php?lng='.$webaktlang.'&page='.$egy_menupont["kod"].'">'.$egy_menupont["nev"].'</a>
					<ul class="dropdown-menu">
						<li class="divider"></li>
						<li><a tabindex="-2" href="index.php?lng='.$webaktlang.'&mod=y&ujalmenu='.$egy_menupont["kod"].'">&plus; Új almenüpont</a></li>
					</ul>
				  </li>';
		}
	}
	echo '						<li class="divider"></li>';
	echo '							<li><a tabindex="-1" href="index.php?lng='.$webaktlang.'&mod=y&ujmenu=1">&raquo; Új menüpont hozzáadása</a></li>
									<li><a tabindex="-1" href="index.php?lng='.$webaktlang.'&mod=y&menusormod=1">&raquo; Sorrend módosítása</a></li>
								</ul> 				
							</li>';
// MODULOK //
	echo '					<li class="dropdown">					
								<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
									<i class="icon-th"></i>
									<span>Modulok</span>
									<b class="caret"></b>
								</a>	    
							
								<ul class="dropdown-menu">

									<li class="dropdown-submenu">
									  <a tabindex="-1" href="#">Nyelvek</a>
									  <ul class="dropdown-menu">';
								$weblangok=$pdo->query("select langnev from ".$elotag."_nyelvek order by langkod");
								while($webegylang=$weblangok->fetch())
								{
									$mirol=array("hun","ger","eng","fra","dan","cze","ned","hor","len","nor","ita","por","rom","sve","spa","srb","slo","tur","ukr","rus");
									$mire=array("magyar","német","angol","francia","dán","cseh","holland","horvát","lengyel","norvég","olasz","portugál","román","svéd","spanyol","szerb","szlovák","török","ukrán","orosz");
									$miben=$webegylang["langnev"];
									$nyelvnev=str_replace($mirol, $mire, $miben);
									echo "<li><a href='index.php?lng=".$webegylang["langnev"]."&nologin' title='".$webegylang["langnev"]."'>".$nyelvnev."</a></li>";
								}
	echo '								<li class="divider"></li>
										<li><a tabindex="-2" href="index.php?lng='.$webaktlang.'&mod=y&ujnyelv=1">&plus; Új nyelv telepítése</a></li>
									  </ul>
									</li>';
		$modgalbe=$pdo->query("select bekapcsolva from ".$elotag."_modulok where modulnev='galeria'");
		$galmod=$modgalbe->fetch();
		if($galmod["bekapcsolva"]=="igen")
		{
			echo '					<li class="dropdown-submenu">
									  <a tabindex="-1" href="#">Galéria</a>
									  <ul class="dropdown-menu">
										<li><a tabindex="-2" href="index.php?lng='.$webaktlang.'&page=galeria&open=1">&raquo; Megtekintés és kezelés</a></li>
										<li><a tabindex="-2" href="index.php?lng='.$webaktlang.'&page=galeria&ujkep=1">&plus; Új kép feltöltése</a></li>
										<li><a tabindex="-2" href="index.php?lng='.$webaktlang.'&page=galeria&ujalbum=1">&plus; Új album létrehozása</a></li>
									  </ul>
									</li>';
		}
		$modvidbe=$pdo->query("select bekapcsolva from ".$elotag."_modulok where modulnev='video'");
		$vidmod=$modvidbe->fetch();
		if($vidmod["bekapcsolva"]=="igen")
		{
			echo '					<li class="dropdown-submenu">
									  <a tabindex="-1" href="#">Videók</a>
									  <ul class="dropdown-menu">
										<li><a tabindex="-2" href="index.php?lng='.$webaktlang.'&page=video">&raquo; Megtekintés és kezelés</a></li>
										<li><a tabindex="-2" href="index.php?lng='.$webaktlang.'&mod=y&ujvideo">&plus; Új hozzáadása</a></li>
									  </ul>
									</li>';
		}
		$modslidebe=$pdo->query("select bekapcsolva from ".$elotag."_modulok where modulnev='slider'");
		$slimod=$modslidebe->fetch();
		if($slimod["bekapcsolva"]=="igen")
		{
			echo '					<li class="dropdown-submenu">
									  <a tabindex="-1" href="#">Képváltó</a>
									  <ul class="dropdown-menu">
										<li><a tabindex="-2" href="index.php?lng='.$webaktlang.'&mod=y&sliderek=1">&raquo; Megtekintés és kezelés</a></li>
										<li><a tabindex="-2" href="index.php?lng='.$webaktlang.'&mod=y&ujslider=1">&plus; Új kép feltöltése</a></li>
									  </ul>
									</li>';
		}
		$modhirekbe=$pdo->query("select bekapcsolva from ".$elotag."_modulok where modulnev='hirek'");
		$hirmod=$modhirekbe->fetch();
		if($hirmod["bekapcsolva"]=="igen")
		{
			echo '					<li class="dropdown-submenu">
									  <a tabindex="-1" href="#">Bejegyzések</a>
									  <ul class="dropdown-menu">
										<li><a tabindex="-2" href="index.php?lng='.$webaktlang.'&page=hirek">&raquo; Megtekintés és kezelés</a></li>
										<li><a tabindex="-2" href="index.php?lng='.$webaktlang.'&mod=y&ujcikk=1">&plus; Új hozzáadása</a></li>
									  </ul>
									</li>';
		}
		echo '						<li class="dropdown-submenu">
									  <a tabindex="-1" href="#">Oldalsáv</a>
									  <ul class="dropdown-menu">
										<li><a tabindex="-2" href="index.php?lng='.$webaktlang.'&mod=y&blokkok=1">&raquo; Megtekintés és kezelés</a></li>
										<li><a tabindex="-2" href="index.php?lng='.$webaktlang.'&mod=y&blokksormod=1">&raquo; Sorrend módosítása</a></li>
										<li><a tabindex="-2" href="index.php?lng='.$webaktlang.'&mod=y&ujblokk=1">&plus; Új hozzáadása</a></li>
									  </ul>
									</li>';
		$moddown=$pdo->query("select bekapcsolva from ".$elotag."_modulok where modulnev='letoltes'");
		$downmod=$moddown->fetch();
		if($downmod["bekapcsolva"]=="igen")
		{
			echo '					<li class="dropdown-submenu">
									  <a tabindex="-1" href="#">Letöltés kezelő</a>
									  <ul class="dropdown-menu">
										<li><a tabindex="-2" href="index.php?lng='.$webaktlang.'&mod=y&downmod=1">&raquo; Megtekintés és kezelés</a></li>
										<li><a tabindex="-2" href="index.php?lng='.$webaktlang.'&mod=y&ujdown=1">&plus; Új fájl feltöltése</a></li>
									  </ul>
									</li>';
		}
		$modsocialbe=$pdo->query("select bekapcsolva from ".$elotag."_modulok where modulnev='social'");
		$socmod=$modsocialbe->fetch();
		if($socmod["bekapcsolva"]=="igen")
		{
			echo '					<li class="dropdown-submenu">
									  <a tabindex="-1" href="#">Közösségi oldalak</a>
									  <ul class="dropdown-menu">
										<li><a tabindex="-2" href="index.php?lng='.$webaktlang.'&mod=y&social=1">&raquo; Linkek kezelése</a></li>
									  </ul>
									</li>';
		}
		$modgmapsbe=$pdo->query("select bekapcsolva from ".$elotag."_modulok where modulnev='gmaps'");
		$mapsmod=$modgmapsbe->fetch();
		if($mapsmod["bekapcsolva"]=="igen")
		{
			echo '					<li class="dropdown-submenu">
									  <a tabindex="-1" href="#">Google MAPS</a>
									  <ul class="dropdown-menu">
										<li><a tabindex="-2" href="index.php?lng='.$webaktlang.'&mod=y&gmaps=1">&raquo; Térkép kezelése</a></li>
									  </ul>
									</li>';
		}
		echo '					</ul> 				
							</li>';
		$modshopbe=$pdo->query("select bekapcsolva from ".$elotag."_modulok where modulnev='shop'");
		$shopmod=$modshopbe->fetch();
		if($shopmod["bekapcsolva"]=="igen")
		{
			echo '			<li class="dropdown">					
								<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
									<i class="icon-shopping-cart"></i>
									<span>Webáruház</span>
									<b class="caret"></b>
								</a>	
							
								<ul class="dropdown-menu">
									<li><a href="index.php?lng='.$webaktlang.'&page=shop">Termékek kezelése</a></li>
									<li><a href="index.php?lng='.$webaktlang.'&page=shop&kategoriak=y">Kategóriák kezelése</a></li>
									<li><a href="index.php?lng='.$webaktlang.'&page=shop&gyartok=y">Gyártók kezelése</a></li>
									<li><a href="index.php?lng='.$webaktlang.'&page=shop&rendelesek=y">Megrendelések kezelése</a></li>
								</ul>    				
							</li>';
		}
		echo '				<li class="dropdown">					
								<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
									<i class="icon-check"></i>
									<span>SEO Adatok</span>
									<b class="caret"></b>
								</a>	
							
								<ul class="dropdown-menu">
									<li><a href="index.php?lng='.$webaktlang.'&mod=y&settings=1">Weboldal beállításai</a></li>
									<li><a href="index.php?lng='.$webaktlang.'&mod=y&createxml=1">Oldaltérkép készítése</a></li>
									<li><a href="index.php?lng='.$webaktlang.'&mod=y&ganal=1">Google Analytics</a></li>
								</ul>    				
							</li>';
		echo '			</ul>
					</div>
				</div>
			</div>
		</div>';
/*** TARTALOM ***/
	echo '<div class="main">
			<div class="container">
			  <div class="row">
				<div class="span12">';
// BELTARTALOM AMI LINKENKÉNT VÁLTOZIK //
	if(isset($_REQUEST["page"]))
	{
		if($_REQUEST["page"]=="hirek")
		{
			echo '<div class="widget stacked">
					<div class="widget-header">
						<i class="icon-th-large"></i>
						<h3>Tartalom változtatás - [K.E.K. Admin]</h3>
					</div>
					<div class="widget-content">
						<div class="row-fluid">
							<div class="span12">';
				include("hiradmin.php");
			echo '			</div>
						</div>
					</div>
				</div>';
		}
		elseif($_REQUEST["page"]=="galeria")
		{
			echo '<div class="widget stacked">
					<div class="widget-header">
						<i class="icon-th-large"></i>
						<h3>Tartalom változtatás - [K.E.K. Admin]</h3>
					</div>
					<div class="widget-content">
						<div class="row-fluid">
							<div class="span12">';
				include("galadmin.php");
			echo '			</div>
						</div>
					</div>
				</div>';
		}
		elseif($_REQUEST["page"]=="video")
		{
			echo '<div class="widget stacked">
					<div class="widget-header">
						<i class="icon-th-large"></i>
						<h3>Tartalom változtatás - [K.E.K. Admin]</h3>
					</div>
					<div class="widget-content">
						<div class="row-fluid">
							<div class="span12">';
				include("videoadmin.php");
			echo '			</div>
						</div>
					</div>
				</div>';
		}
		elseif($_REQUEST["page"]=="shop")
		{
			echo '<div class="widget stacked">
					<div class="widget-header">
						<i class="icon-th-large"></i>
						<h3>Tartalom változtatás - [K.E.K. Admin]</h3>
					</div>
					<div class="widget-content">
						<div class="row-fluid">
							<div class="span12">';
				include("shopadmin.php");
			echo '			</div>
						</div>
					</div>
				</div>';
		}
		elseif($_REQUEST["page"]=="saved")
		{
			echo'<div class="widget stacked">
					<div class="widget-header">
						<i class="icon-th-large"></i>
						<h3>Tartalom szerkesztés - [K.E.K. Admin]</h3>
					</div>
					<div class="widget-content">
						<div class="row-fluid">
							<div class="span12">';
			echo '<h2>A művelet sikeres!</h2>';
			echo '			</div>
						</div>
					</div>
				</div>';
			if(strpos($_GET["url"],"saved"))
			{
			}
			else
			{
				echo "<script>				    
						function atiranyit()
						{
							location.href = '".$_GET["url"]."';
						}
						ID = window.setTimeout('atiranyit();', 1*1000);
				   </script>";
			}
		}
		else
		{
			$megjelenit=$pdo->query("select * from ".$elotag."_menu_".$webaktlang." where kod='".$_REQUEST["page"]."'");
			$oldal=$megjelenit->fetch();
			echo'<div class="widget stacked">
					<div class="widget-header">
						<i class="icon-th-large"></i>
						<h3>"'.$oldal["nev"].'" menüpont - [K.E.K. Admin]</h3>
					</div>
					<div class="widget-content">
						<div class="row-fluid">
							<div class="span12">';
				if($oldal["aktiv"]=="1")
				{
					echo "<i class='fa fa-power-off'></i> <a href='index.php?lng=".$webaktlang."&mod=y&menustop=".$oldal["kod"]."'>kikapcsolás</a>&nbsp;|&nbsp;";
				}
				else
				{
					echo "<i class='fa fa-check-square-o'></i> <a href='index.php?lng=".$webaktlang."&mod=y&menustart=".$oldal["kod"]."'>aktiválás</a>&nbsp;|&nbsp;";
				}
				echo "<i class='icon-edit'></i> <a href='index.php?lng=".$webaktlang."&mod=edit&modosit=".$oldal["kod"]."'>szerkesztés</a>&nbsp;|&nbsp;";
				//van almenüje? mert ha igen nem engedjük törölni!
				$almenu=$pdo->query("select * from ".$elotag."_almenu_".$webaktlang." where szulo='".$_REQUEST["page"]."'");
				if($almenu->rowCount()>0)
				{
					echo "<i class='icon-trash'></i> <a href='javascript:alert(\"Ennek a menüpontnak van almenüje, előbb azt kell törölni!\");'>menüpont törlése</a><br /><br />";
				}
				else
				{
					echo "<i class='icon-trash'></i> <a href='index.php?lng=".$webaktlang."&mod=y&torol=".$oldal["kod"]."' onclick=\"return confirm('Biztos törli a menüpontot a teljes tartalmával együtt?')\">menüpont törlése</a><br /><br />";
				}
				print($oldal["tartalom"]);
			echo '			</div>
						</div>
					</div>
				</div>';
		}
	}
	elseif(isset($_REQUEST["alpage"]))
	{
		$megjelenit=$pdo->query("select * from ".$elotag."_almenu_".$webaktlang." where kod='".$_REQUEST["alpage"]."'");
		$oldal=$megjelenit->fetch();
		echo'<div class="widget stacked">
					<div class="widget-header">
						<i class="icon-th-large"></i>
						<h3>"'.$oldal["nev"].'" almenüpont - [K.E.K. Admin]</h3>
					</div>
					<div class="widget-content">
						<div class="row-fluid">
							<div class="span12">';
			if($oldal["aktiv"]=="1")
			{
				echo "<i class='fa fa-power-off'></i> <a href='index.php?lng=".$webaktlang."&mod=y&almenustop=".$oldal["kod"]."'>kikapcsolás</a>&nbsp;|&nbsp;";
			}
			else
			{
				echo "<i class='fa fa-check-square-o'></i> <a href='index.php?lng=".$webaktlang."&mod=y&almenustart=".$oldal["kod"]."'>aktiválás</a>&nbsp;|&nbsp;";
			}
			echo "<i class='icon-edit'></i> <a href='index.php?lng=".$webaktlang."&mod=edit&almodosit=".$oldal["kod"]."'>szerkesztés</a>&nbsp;|
				   <i class='icon-trash'></i> <a href='index.php?lng=".$webaktlang."&mod=y&altorol=".$oldal["kod"]."' onclick=\"return confirm('Biztos törli az almenüpontot a teljes tartalmával együtt?')\">almenüpont törlése</a><br /><br />";
			print($oldal["tartalom"]);
		echo '			</div>
					</div>
				</div>
			</div>';
	}
	elseif(isset($_GET["mod"]))
	{
		if($_GET["mod"]=="y")
		{
			echo '<div class="widget stacked">
					<div class="widget-header">
						<i class="icon-th-large"></i>
						<h3>Tartalom változtatás - [K.E.K. Admin]</h3>
					</div>
					<div class="widget-content">
						<div class="row-fluid">
							<div class="span12">';
						include("valtoztat.php");
						include("mentes.php");
			echo '			</div>
						</div>
					</div>
				</div>';
		}
		else
		{
			echo '<div class="widget stacked">
					<div class="widget-header">
						<i class="icon-th-large"></i>
						<h3>Tartalom szerkesztés - [K.E.K. Admin]</h3>
					</div>
					<div class="widget-content">
						<div class="row-fluid">
							<div class="span12">';
						include("szerkeszt.php");
			echo '			</div>
						</div>
					</div>
				</div>';
		}
	}
	else if(isset($_GET["nologin"]))
	{
		echo '<div class="widget stacked">
			<div class="widget-header">
				<i class="icon-th-large"></i>
				<h3>Nyelvváltoztatás - [K.E.K. Admin]</h3>
			</div>
			<div class="widget-content">
				<div class="pricing-header">
					<h1>Rendben, sikeresen nyelvet váltott!</h1>
					<h2>AZ AKTUÁLIS NYELV: '.$webaktlang.'</big><br />(<small><a href="index.php?lng='.$webaktlang.'&mod=y&nyelvdel='.$webaktlang.'" title="A nyelv és a hozzá tartozó adatok végleges törlése!" onclick="return confirm(\'Biztos törli az aktuális nyelvet a hozzátartozó összes tartalmával együtt? Ez végleges és visszaállíthatatlan. Menüpontok, tartalmak kerülnek végleges törlésre!\')">Nyelv és tartalmak teljes törlése</a></small>)</h2>
				</div>
				<div class="row-fluid">
					<div class="span12">
						<p><b>NE FELEDJE:</b><br><br>
						Többnyelvű oldal esetében a menüpontok és tartalmaik az MODULOK főmenüben található NYELVEK választó segítségével módosíthatóak, az alábbi módon:<br>
						- válassza ki a kívánt nyelvet a MODULOK főmenüből,<br>
						- kattintson a hozzá tartozó linkre - azaz a nyelv nevére,<br>
						- a főmenüben máris a választott idegen nyelvi tartalmak jelennek meg,<br>
						- ezekre kattintva már szerkeszteni is fogja tudni.</p><br>
						<p><b>FIGYELEM!</b><br><br>
						Új menüpont létrehozásánál, CSAK az aktuális - oldal által használt és beállított - nyelven jön létre a tartalom!<br>
						A többi nyelven a tartalmakat egyénileg létre kell hozni!</p>
					</div>
				</div>
			</div>
		</div>';
	}
	else
	{
		echo '<div class="widget stacked">
				<div class="widget-header">
					<i class="icon-th-large"></i>
					<h3>Üdvözlünk a '.$webadatok["title"].' weboldal adminisztrációs felületén! - [K.E.K. Admin]</h3>
				</div>
				<div class="widget-content">
					<div class="pricing-header">
						<h1>Rendben, sikeresen bejelentkezett!</h1>
						<h2>Válassza ki a fenti menüből a kívánt tartalmat, vagy a tevékenységet!</h2>
						<a href="index.php?lng='.$webaktlang.'&mod=y&breakoff='.($webadatok["breakoff"]=="1" ? "0" : "1").'" class="btn btn-large btn-secondary"><h4>KARBANTARTÁS MÓD '.($webadatok["breakoff"]=="1" ? "KI" : "BE").'KAPCSOLÁSA</h4></a>
					</div>
					<div class="row-fluid">
						<div class="span12">
							<p><b>FONTOS!</b><br><br>
							Többnyelvű oldal esetében a menüpontok és tartalmaik az MODULOK főmenüben található NYELVEK választó segítségével módosíthatóak, az alábbi módon:<br>
							- válassza ki a kívánt nyelvet a MODULOK főmenüből,<br>
							- kattintson a hozzá tartozó linkre - azaz a nyelv nevére,<br>
							- a főmenüben máris a választott idegen nyelvi tartalmak jelennek meg,<br>
							- ezekre kattintva már szerkeszteni is fogja tudni.</p><br>
							<p><b>FIGYELEM!</b><br><br>
							Új menüpont létrehozásánál, CSAK az aktuális - oldal által használt és beállított - nyelven jön létre a tartalom!<br>
							A többi nyelven a tartalmakat egyénileg létre kell hozni!</p>
						</div>
					</div>
				</div>
			</div>';
	}
// BELTARTALOM VÁLTOZÓS RÉSZE VÉGE //
	echo '		</div>
			  </div>
			</div>
		</div>';
}
else // LOGIN NÉLKÜLIS MEGJELENITÉS
{
	/*** MENÜSÁV ***/
	echo '<br><br>';
	/*** TARTALOM ***/
	echo '<div class="main">
			<div class="container">
			  <div class="row">
				<div class="span8">
					<div class="widget stacked">
						<div class="widget-header">
							<i class="icon-th-large"></i>
							<h3>Üdvözlünk a K.E.K. adminisztrációs felületén!</h3>
						</div>
						<div class="widget-content">
							<div class="row-fluid">
								<div class="span12"><br>';
							include("login.php");
	echo '						<br><br>
								</div>
							</div>
						</div>
					</div>
				</div>';
?>
	<script>
		$(function(){
			$.ajax({
				type: "GET",
				url: "https://trswebdesign.hu/hirekxml.php",
				dataType: "xml",
				success: function(xml) {
					var $newsData = $(xml).find('news:eq(0)');
					var $newsTitle = $($newsData).find('title:eq(0)').text();
					var $newsContent = $($newsData).find('content:eq(0)').text();
					$("#newsbox").html('<h4 id="title">' + $newsTitle + '</h4><div id="content">' + $newsContent + '</div>');
				}
			});
		})
	</script>
<?php
	echo '		<div class="span4">
					<div class="widget stacked widget-box">
						<div class="widget-header">	
							<h3>Legfrissebb hírek</h3>			
						</div>
						<div class="widget-content" id="newsbox"> </div>
					</div>
				</div>
			  </div>
			</div>
		</div>';
}
/*** LÁBLÉC ***/
	include("footer.php");
?>
</body>
</html>