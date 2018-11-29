<?php
	$absp=(isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER["HTTP_HOST"];
	$fullurl=$absp.$_SERVER["REQUEST_URI"];
	$mirol=array("í","é","á","ű","ú","ő","ó","ü","ö","Í","É","Á","Ű","Ú","Ő","Ó","Ü","Ö","_","+",":",",","?","=","(",")","[","]","{","}","&","#","@","<",">","$","'","!","/"," ");
	$mire=array("i","e","a","u","u","o","o","u","o","i","e","a","u","u","o","o","u","o","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-");
?>
<!DOCTYPE html>
<html lang="hu-HU" xml:lang="hu" dir="ltr">
<head>
<?php
	if(isset($_REQUEST["furl"]) AND strpos($_REQUEST["furl"],"blog/")=== false AND strpos($_REQUEST["furl"],"galeria/")=== false)
	{
		$megjelenit=$pdo->query("select * from ".$elotag."_menu_".$webaktlang." where furl='".$_REQUEST["furl"]."'");
		if($megjelenit->rowCount()>0)
		{
			$ad=$megjelenit->fetch();
		}
		else
		{
			$megjelenit=$pdo->query("select * from ".$elotag."_almenu_".$webaktlang." where furl='".$_REQUEST["furl"]."'");
			$ad=$megjelenit->fetch();
		}
		$title=$ad["metatitle"];
		$keywords=$ad["metakeywords"];
		$description=$ad["metadesc"];
		$sitename=$ad["metatitle"];
		$siteslogen="";
	}
	elseif(isset($_REQUEST["hir"]))
	{
		$megjelenit=$pdo->query("select * from ".$elotag."_hirkezelo_".$webaktlang." where furl='".$_REQUEST["hir"]."'");
		$ad=$megjelenit->fetch();
		$title=$ad["metatitle"];
		$keywords=$ad["metakeywords"];
		$description=$ad["metadesc"];
		$sitename=$ad["metatitle"];
		$siteslogen="";
	}
	else
	{
		$megjelenit=$pdo->query("select * from ".$elotag."_parameterek");
		$ad=$megjelenit->fetch();
		$title=$ad["title"];
		$keywords=$ad["keywords"];
		$description=$ad["description"];
		$sitename=$ad["sitename"];
		$siteslogen=$ad["siteslogen"];
	}
	
?>
	<title><?php echo $title; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="<?php echo $keywords; ?>" />
	<meta name="description" content="<?php echo $description; ?>" />
	<meta name="robots" content="index, follow" />
	<meta name="googlebot" content="index, follow" />
	<meta name="revisit-after" content="1 days">
	<meta name="author" content="Handzsúr István" />
	<meta name="publisher" content="TrS WebDesign" />
	<meta property="og:type" content="website" />
	<meta property="og:title" content="<?php echo $title; ?>" />
	<meta property="og:site_name" content="<?php echo $sitename; ?>" />
	<meta property="og:url" content="<?php echo $fullurl; ?>" />
	<meta property="og:image" content="<?php echo $absp; ?>/header-bg.jpg" />
	<meta property="og:image:alt" content="<?php echo $sitename." ".$siteslogen; ?>" />
	<meta property="og:description" content="<?php echo $description; ?>" />
	<meta property="og:locale" content="hu_HU" />
	<meta name="DC.coverage" content="Hungary" />
	<meta name="DC.description" content="<?php echo $description; ?>" />
	<meta name="DC.format" content="text/html" />
	<meta name="DC.identifier" content="<?php echo $fullurl; ?>" />
	<meta name="DC.publisher" content="TrS WebDesign" />
	<meta name="DC.title" content="<?php echo $title; ?>" />
	<meta name="DC.type" content="Text" />
	<link rel="schema.dcterms" href="https://purl.org/dc/terms/">
	<link rel="shortcut icon" href="/favicon.png" />
	<link rel="apple-touch-icon" href="/favicon.png">
	<script type="application/x-javascript">
		addEventListener("load", function () {
			setTimeout(hideURLbar, 0)
		}), false;

		function hideURLbar() {
			window.scrollTo(0, 1)
		}
	</script>
	<script type="text/javascript" src="<?php echo $absp; ?>/themes/<?php echo $webadatok["sablon"]; ?>/js/jquery-2.1.4.min.js"></script>
	<link href="<?php echo $absp; ?>/themes/<?php echo $webadatok["sablon"]; ?>/css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
	<link href="<?php echo $absp; ?>/themes/<?php echo $webadatok["sablon"]; ?>/css/style.css" rel="stylesheet" type="text/css" media="all" />
	<link href="<?php echo $absp; ?>/themes/<?php echo $webadatok["sablon"]; ?>/css/font-awesome.css" rel="stylesheet">
	<link href="//fonts.googleapis.com/css?family=Raleway:300,300i,400,400i,500,500i,600,600i,700,700i,800" rel="stylesheet">
	<link href="//fonts.googleapis.com/css?family=Lato:400,100,100italic,300,300italic,400italic,700,900,900italic,700italic" rel="stylesheet" type="text/css">
	<link href="//fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,600,600i,700" rel="stylesheet">
	<link href="<?php echo $absp; ?>/wp-admin/fancybox/jquery.fancybox.css" rel="stylesheet">
	<script type="text/javascript" src="<?php echo $absp; ?>/wp-admin/fancybox/jquery.fancybox.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('.fancybox').fancybox();
		});
	</script>
	<script type="text/javascript">
		window.cookieconsent_options = {"message":"Ez a weboldal sütiket (cookie-kat) használ a jobb felhasználói élmény érdekében.","dismiss":"Rendben","learnMore":"További infó","link":"index.php","theme":"dark-bottom"};
	</script>
	<script async src="https://cdnjs.cloudflare.com/ajax/libs/cookieconsent2/1.0.10/cookieconsent.min.js"></script>
</head>
<body>
<?php
	if($webadatok["breakoff"]=="1")
	{
		echo '<div class="col-md-3 hidden-xs"> </div>';
		echo '<div class="col-md-6 text-center"><br><br><br><br><h1>The website is under construction!<br>Please be patient.</h1><br><br>&nbsp;</div>';
		echo '<div class="col-md-3 hidden-xs"> </div>';
		echo '<div class="clearfix"> </div>';
	}
	else
	{
		/*** ANALYTICS KÓD HA VAN ***/
		$ganal=$pdo->query("select * from ".$elotag."_ganal");
		$analitika=$ganal->fetch();
		if($analitika["ganalkey"]!="")
		{
			?>
				<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $analitika["ganalkey"]; ?>"></script>
				<script>
				  window.dataLayer = window.dataLayer || [];
				  function gtag(){dataLayer.push(arguments);}
				  gtag('js', new Date());
				  gtag('config', '<?php echo $analitika["ganalkey"]; ?>');
				</script>
			<?php
		}
?>
	<div class="header" id="home">
		<div class="content white">
			<nav class="navbar navbar-default" role="navigation">
				<div class="container">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="index.php">
							<h1><span class="fa fa-code" aria-hidden="true"></span><?php print($webadatok["sitename"]); ?> <label><?php print($webadatok["siteslogen"]); ?></label></h1>
						</a>
					</div>
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<nav>
							<ul class="nav navbar-nav">
<?php
/* menüsor behivása */
	$menu=$pdo->query("select * from ".$elotag."_menu_".$webaktlang." where aktiv='1' order by sorszam asc");
	while($emu=$menu->fetch())
	{
		$almenu=$pdo->query("select * from ".$elotag."_almenu_".$webaktlang." where szulo='".$emu["kod"]."' and aktiv='1'");
		if($almenu->rowCount()>0)
		{
			echo '<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">'.$emu["nev"].' <b class="caret"></b></a>
					<ul class="dropdown-menu">';
					while($eamp=$almenu->fetch())
					{
						echo '<li><a href="/'.$eamp["furl"].'">'.$eamp["nev"].'</a></li>';
					}
			echo '	</ul>
				  </li>';
		}
		else
		{
			echo '<li><a href="/'.$emu["furl"].'">'.$emu["nev"].'</a></li>';
		}
	}
?>
							</ul>
						</nav>
					</div>
				</div>
			</nav>
		</div>
	</div>
<?php
	$modslidebe=$pdo->query("select * from ".$elotag."_modulok where modulnev='slider'");
	$slimod=$modslidebe->fetch();
	if($slimod["bekapcsolva"]=="igen")
	{
?>
	<div id="myCarousel" class="carousel slide" data-ride="carousel">
		<div class="carousel-inner" role="listbox">
<?php
/* slider megjelenitése */
	$i=1;
	$sliderblokk=$pdo->query("select * from ".$elotag."_slider order by sliderkod asc");
	while($egy_sb=$sliderblokk->fetch())
	{
		echo '<div class="item item'.$i.' '.($i==1 ? "active" : "" ).'" style="background: linear-gradient(rgba(23, 22, 23, 0.2), rgba(23, 22, 23, 0.5)), url(slider/'.$egy_sb["slidert"].') center no-repeat; background-size:100%;">
				<div class="container">
					<div class="carousel-caption">
						<h3>'.$egy_sb["dumahozza"].'</h3>
						<p>'.$egy_sb["hiperlink"].'</p>
					</div>
				</div>
			</div>';
		$i++;
	}
?>
		</div>
		<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
			<span class="fa fa-chevron-left" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		</a>
		<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
			<span class="fa fa-chevron-right" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
		</a>
	</div>
<?php
	}
?>

	<div class="banner-bottom">
		<div class="container">
<?php
/* menüpontok tartalmának megjelenitése */
	if(isset($_REQUEST["furl"]) AND strpos($_REQUEST["furl"],"blog/")=== false AND strpos($_REQUEST["furl"],"galeria/")=== false)
	{
		$megjelenit=$pdo->query("select * from ".$elotag."_menu_".$webaktlang." where furl='".$_REQUEST["furl"]."'");
		if($megjelenit->rowCount()>0)
		{
			$oldal=$megjelenit->fetch();
		}
		else
		{
			$megjelenit=$pdo->query("select * from ".$elotag."_almenu_".$webaktlang." where furl='".$_REQUEST["furl"]."'");
			$oldal=$megjelenit->fetch();
		}
		echo '<div class="tittle_head_w3layouts">
					<h3 class="tittle main">'.$oldal["nev"].'</span></h3>
				</div>
				<div class="inner_sec_info_agileits_w3">
					'.$oldal["tartalom"].'
					<div class="clearfix"> </div>
				</div>';
	}
	else
	{
		$megjelenit=$pdo->query("select * from ".$elotag."_menu_".$webaktlang." where aktiv='1' order by sorszam asc");
		$oldal=$megjelenit->fetch();
		echo '<div class="tittle_head_w3layouts">
					<h3 class="tittle main">Üdvözöljük weboldalunkon, ez  K.E.K. DEMO</span></h3>
				</div>
				<div class="inner_sec_info_agileits_w3">
					'.$oldal["tartalom"].'
					<div class="clearfix"> </div>
				</div>';
	}
	
	echo '<br><div class="clearfix"> </div> <br>';
?>
	
<?php
/* BLOG */
	if(!isset($_REQUEST["furl"]))
	{
		/* 
		HA A BLOGOT AKARJUK SPECI /blog MENÜPONT ALATT MEGJELENITENI AKKOR: 
		AND strpos($_REQUEST["furl"],"blog/")!== false AND strpos($_REQUEST["furl"],"galeria/")=== false)
		*/
		
		$modhirekbe=$pdo->query("select * from ".$elotag."_modulok where modulnev='hirek'");
		$hirmod=$modhirekbe->fetch();
		if($hirmod["bekapcsolva"]=="igen")
		{
			echo '<div class="tittle_head_w3layouts">
						<h3 class="tittle main"><span>Olvasható</span> Blog</h3>
					</div>
					<div class="inner_sec_info_agileits_w3">';
			$hi=1;
			$sql = $pdo->query("SELECT * FROM ".$elotag."_hirkezelo_".$webaktlang." where aktiv='1' order by datum desc limit 3");
			while($egyhir=$sql->fetch())
			{
				echo '<div class="col-md-4 grid_info">
						<div class="icon_info">
							'.($egyhir["kiskep"]=="" ? '<span class="fa fa-comments-o" aria-hidden="true"></span>' : '<img src="blog/'.$egyhir["kiskep"].'" class="img-responsive"').'
							<h5>'.$egyhir["cim"].'</h5>
							<p><i>'.$egyhir["datum"].'</i></p><br>
							'.$egyhir["bevezeto"].'<br><br>
							<a href="#" data-toggle="modal" data-target="#myModal'.$hi.'" class="btn btn-default">Elolvasom</a>
							
							<div class="modal fade" tabindex="-1" role="dialog" id="myModal'.$hi.'">
							  <div class="modal-dialog" role="document">
								<div class="modal-content">
								  <div class="modal-header">
									<h4 class="modal-title">'.$egyhir["cim"].'</h4>
								  </div>
								  <div class="modal-body">
									'.$egyhir["szoveg"].'<br><br>
									'.$egyhir["tags"].'
								  </div>
								</div>
							  </div>
							</div>
							
						</div>
					</div>';
				$hi++;
			}
			echo '		<div class="clearfix"> </div>
					</div>';
		}
	}
	
?>	
		</div>
	</div>

	<div class="team_work">
		<h4><?php print($webadatok["siteslogen"]); ?></h4>
	</div>

<?php
/* galéria */
	if(!isset($_REQUEST["furl"]))
	{
		/* 
		HA A GALÉRIÁT AKARJUK SPECI /galeria MENÜPONT ALATT MEGJELENITENI AKKOR: 
		AND strpos($_REQUEST["furl"],"blog/")=== false AND strpos($_REQUEST["furl"],"galeria/")!== false)
		*/
		
		$modgalbe=$pdo->query("select * from ".$elotag."_modulok where modulnev='galeria'");
		$galmod=$modgalbe->fetch();
		if($galmod["bekapcsolva"]=="igen")
		{
			echo '<div class="features" id="features">
					<div class="container">
						<div class="tittle_head_w3layouts">
							<h3 class="tittle">Élethű <span>Galéria</span></h3>
						</div>
						<div class="inner_sec_info_agileits_w3">';
						
			$mappak=$pdo->query("select * from ".$elotag."_mappak");
			$gal=0;
			while($mem=$mappak->fetch())
			{
				echo '<div class="col-md-4 grid_info text-center galpakk">
						<a href="#" data-toggle="modal" data-target="#galModal'.$gal.'" class="text-center">
							<h4><b>'.$mem["mappanev"].'</b></h4><br>
							<img src="galeria/'.$mem["mappakep"].'" class="img-responsive" alt="'.$mem["mappanev"].'">
						</a>';
							if(!file_exists("leirasok/".$fajl.".txt"))
							{
								$title="demo szöveg";
							}
							else
							{
								$fm=fopen("leirasok/".$fajl.".txt","r");
								$szoveg="";
								while(!feof($fm))
								{
									$betu=fgetc($fm);
									$szoveg=$szoveg.$betu;
								}
								$title=$szoveg;
							}
					echo '<div class="modal fade" tabindex="-1" role="dialog" id="galModal'.$gal.'">
							  <div class="modal-dialog modal-lg" role="document">
								<div class="modal-content">
								  <div class="modal-header">
									<h4 class="modal-title">'.$mem["mappanev"].' ALBUM</h4>
								  </div>
								  <div class="modal-body">';
									$ig=0;
									$melyik=opendir("galeria/".$mem["mappaut"]);
									while($fajl=readdir($melyik))
									{
										if($fajl!="." and $fajl!="..")
										{
											echo '<div class="col-md-4"><a href="galeria/'.$mem["mappaut"].'/'.$fajl.'" class="fancybox" rel="galeria"><img src="galeria/'.$mem["mappaut"].'/'.$fajl.'" class="img-responsive" alt="'.$title.'"></a></div>';
											$ig++;
											if($ig%3==0)
											{
												echo '<div class="clearfix"> </div>';
											}
										}
									}
									echo '<div class="clearfix"> </div>
								  </div>
								</div>
							  </div>
							</div>';
							
				echo '</div>';
				$gal++;
				if($gal%3==0)
				{
					echo '<div class="clearfix"> </div>';
				}
			}

			echo '		</div>
					</div>
				</div>';
		}
	}
?>

<?php
/* videók */
	if(!isset($_REQUEST["furl"]))
	{
		$videok=$pdo->query("select * from ".$elotag."_videok order by videokod desc");
		if($videok AND $videok->rowCount()>0)
		{
			echo '<div class="features" id="features">
					<div class="container">
						<div class="tittle_head_w3layouts">
							<h3 class="tittle">Látványos <span>Videók</span></h3>
						</div>
						<div class="inner_sec_info_agileits_w3">';
			/*** YOUTUBE BORITÓKÉP KISZEDÉSE: ***/
			/* $kep='<img src="https://img.youtube.com/vi/'.$vlink[1].'/maxresdefault.jpg" alt="'.$ev["videocim"].'" class="img-responsive" data-pin-nopin="true"/>'; */
						
			$vid=0;
			while($ev=$videok->fetch())
			{
				$posa=strpos($ev["vhiv"], "youtube.com"); //youtube.com
				$posb=strpos($ev["vhiv"], "youtu.be"); //youtu.be
				$posc=strpos($ev["vhiv"], "vimeo.com"); //vimeo.com
				$posd=strpos($ev["vhiv"], "videa.hu"); //videa.hu
				
				if($posa !== false)
				{
					$vlink=explode("=",$ev["vhiv"]);
					$video="<iframe width='100%' height='350' src='https://www.youtube.com/embed/".$vlink[1]."?rel=0&amp;showinfo=0' frameborder='0' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>";
				}
				if($posb !== false)
				{
					$vlink=explode("/",$ev["vhiv"]);
					$video="<iframe width='100%' height='350' src='https://www.youtube.com/embed/".$vlink[3]."?rel=0&amp;showinfo=0' frameborder='0' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>";
				}
				if($posc !== false)
				{
					$vlink=explode("/",$ev["vhiv"]);
					$video="<iframe width='100%' height='350' src='https://player.vimeo.com/video/".$vlink[3]."' frameborder='0' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>";
				}
				if($posd !== false)
				{
					$vlink = substr(strrchr($ev["vhiv"], "-"), 1);
					$video="<iframe width='100%' height='350' src='https://videa.hu/player?v=".$vlink."' frameborder='0' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>";
				}

				echo '<div class="col-md-6 text-center">
						'.$video.'<br>'.$ev["videocim"].'
					</div>';
				$vid++;
				if($vid%2==0)
				{
					echo '<div class="clearfix"> </div>';
				}
			}

			echo '		</div>
					</div>
				</div>';
		}
	}
?>

<?php
/* webáruház */
	if(!isset($_REQUEST["furl"]))
	{
		$modshopbe=$pdo->query("select * from ".$elotag."_modulok where modulnev='shop'");
		$shopmod=$modshopbe->fetch();
		if($shopmod["bekapcsolva"]=="igen")
		{
			echo '<div class="banner-bottom">
					<div class="container">
						<div class="tittle_head_w3layouts">
							<h3 class="tittle main"><span>Könnyen használható</span> webáruház</h3>
						</div>
						<div class="inner_sec_info_agileits_w3">';
				
				$tszam=0;
				$webshop=$pdo->query("select * from ".$elotag."_shop_termek");
				while($et=$webshop->fetch())
				{
					echo '<div class="col-md-3">
							<img src="shop/'.$et["t_fkep"].'" class="img-responsive"><br>
							<h2>'.$et["t_nev"].'</h2>
							<h4><i>'.$et["t_kategoria"].'</i></h4>
							<p>'.number_format($et["t_ar"], 0, ",", ".").' Ft</p>
							<p><a href="#" data-toggle="modal" data-target="#terModal'.$tszam.'" class="btn btn-default">Megtekintés</a></p>';
							
							echo '<div class="modal fade" tabindex="-1" role="dialog" id="terModal'.$tszam.'">
							  <div class="modal-dialog" role="document">
								<div class="modal-content">
								  <div class="modal-header">
									<h4 class="modal-title">'.$et["t_nev"].' adatlapja</h4>
								  </div>
								  <div class="modal-body">
									'.$et["t_kleiras"].'<br><br>'.str_replace("\r\n","<br>",$et["t_nleiras"]).'
								  </div>
								</div>
							  </div>
							</div>';
							
					echo '</div>';
					$tszam++;
					if($tszam%4==0)
					{
						echo '<div class="clearfix"> </div>';
					}
				}
				echo '<div class="clearfix"> </div>';
				
			echo '		</div>
					</div>
				</div>';
		}
	}
?>

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

	<div class="footer_top_agile_w3ls">
		<div class="container">
<?php
	$oldalsav=$pdo->query("select * from ".$elotag."_oldalsav_".$webaktlang." where aktiv='1' order by sorszam limit 4");
	while($szekcio=$oldalsav->fetch())
	{
		echo '<div class="col-md-3 footer_grid">
				<h3>'.$szekcio["cim"].'</h3>
				'.$szekcio["szoveg"].'
			</div>';
	}
?>
			<div class="clearfix"> </div>
		</div>
	</div>
	<div class="footer_wthree_agile">
<?php
	$socmod=$pdo->query("select * from ".$elotag."_social");
	if($socmod->rowCount()>0)
	{
		echo '<p>';
		while($sm=$socmod->fetch())
		{
			if($sm["sociallink"]!="#" AND $sm["sociallink"]!="" AND $sm["sociallink"]!=" ")
			{
				echo '<a href="'.$sm["sociallink"].'" target="_blank"><i class="fa fa-lg fa-'.strtolower($sm["socialsite"]).'" aria-hidden="true"></i></a> &nbsp; ';
			}
		}
		echo '</p>';
	}
?>
		<p>Copyright &copy; 2018 <?php echo $webadatok["copyright"]; ?> | Programozás: <a href="https://trswebdesign.hu" target="_blank" title="webfejlesztés szolnok">TrJoin</a></p>
	</div>
	<script>
		$('ul.dropdown-menu li').hover(function () {
			$(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
		}, function () {
			$(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
		});
	</script>
	<script src="themes/<?php print($webadatok["sablon"]); ?>/js/jquery.waypoints.min.js"></script>
	<script type="text/javascript" src="themes/<?php print($webadatok["sablon"]); ?>/js/bootstrap.js"></script>
<?php
	}
?>
</body>
</html>
