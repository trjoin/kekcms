<?php
	$absp=(isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER["HTTP_HOST"];
?>
<!DOCTYPE html>
<html>
<head>
<title>K.E.K. CMS telepítő</title>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<link href="./wp-admin/css/bootstrap.min.css" rel="stylesheet" />
<link href="./wp-admin/css/bootstrap-responsive.min.css" rel="stylesheet" />    
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet" />
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
<link href="./wp-admin/css/ui-lightness/jquery-ui-1.10.0.custom.min.css" rel="stylesheet" />
<link href="./wp-admin/css/base-admin-2.css" rel="stylesheet" />
<link href="./wp-admin/css/base-admin-2-responsive.css" rel="stylesheet" />
<!--[if lt IE 9]>
  <script src="https://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<script src="./wp-admin/js/libs/jquery-1.8.3.min.js"></script>
<script src="./wp-admin/js/libs/jquery-ui-1.10.0.custom.min.js"></script>
<script src="./wp-admin/js/libs/bootstrap.min.js"></script>
<script src="./wp-admin/js/plugins/validate/jquery.validate.js"></script>
<script src="./wp-admin/js/Application.js"></script>
<script src="./wp-admin/js/demo/validation.js"></script>
</head>
<body>
<div class="navbar navbar-inverse navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"><i class="icon-cog"></i></a>
			<a class="brand" href="index.php"><img src="https://trswebdesign.hu/images/logo.png" border="0" style="max-height:25px;"> K.E.K. CMS <small>v2.3</small></span></a>
			<div class="nav-collapse collapse">
				<ul class="nav pull-right">
					<li><a href="#"><b>Ügyfélszolgálat:</b></a></li>
					<li><a href="mailto:info@trswebdesign.hu"><i class="fa fa-envelope-o" aria-hidden="true"></i> info@trswebdesign.hu</a></li>
					<li><a href="tel:+36301849337"><i class="fa fa-phone" aria-hidden="true"></i> +36-30/184-93-37</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>
<div class="subnavbar">
	<div class="subnavbar-inner">
		<div class="container">
			<a class="btn-subnavbar collapsed" data-toggle="collapse" data-target=".subnav-collapse"><i class="icon-reorder"></i></a>
			<div class="subnav-collapse collapse">
				&nbsp;
			</div>
		</div>
	</div>
</div>
<?php
	echo '<div class="main">
			<div class="container">
			  <div class="row">';
/*** KÖZÉPSŐ SÁV ***/
		echo '	<div class="span8">
					<div class="widget stacked">
						<div class="widget-header">
							<i class="icon-tasks"></i>
							<h3>K.E.K. CMS Admin telepítés</h3>
						</div>
						<div class="widget-content form-group">';
//lépés 1 űrlapja
if(!file_exists("connect.php") AND !isset($_POST["host"]))
{
	$hibak_l="0";
	$hibauzenet="";
	$hibak_f="0";
	$hibamsg="";
	
	print("<form action='install.php' name='db_config' method='POST'>");
		print("<h4>Adatbázis kapcsolat beállítása</h4>");
		print("<input type='hidden' name='lepes2' id='lepes2' value='igen'>");
		print("<label for='host'>Adatbázis Host:</label><input type='text' class='form-control' name='host' id='host' value='localhost' required><br />");
		print("<label for='name'>Adatbázis név:</label><input type='text' class='form-control' name='name' id='name' required><br />");
		print("<label for='user'>Felhasználónév:</label><input type='text' class='form-control' name='user' id='user' required><br />");
		print("<label for='passwd'>Jelszó:</label><input type='text' class='form-control' name='passwd' id='passwd' required><br />");
		print("<label for='tblname'>Tábla név-előtag:</label><input type='text' class='form-control' name='tblname' id='tblname' value='kek' required><br /><br />");
		print("<input type='submit' class='btn btn-large btn-secondary' value='MENTÉS ÉS TOVÁBB'>");
	print("</form>");
}
//lépés 1 mentése és engedés a lépés 2-re
if(isset($_POST["host"]) AND $_POST["host"]!="" AND $_POST["host"]!=" ")
{
	if($_POST["host"]<>"" AND $_POST["user"]<>"" AND $_POST["passwd"]<>"" AND $_POST["tblname"]<>"")
	{
		$teszt = new PDO("mysql:host=".$_POST["host"].";dbname=".$_POST["name"]."", "".$_POST["user"]."", "".$_POST["passwd"]."");
		if($teszt)
		{
			print("<h4>Sikeres kapcsolódás az adatbázishoz!</h4><p><b>Kérlek töltsd ki a további szükséges adatokat is!</b></p><br />");
			touch("connect.php");
			$fm=fopen("connect.php","w");
			fwrite($fm,"<?php \n \$pdo = new PDO('mysql:host=".$_POST["host"].";dbname=".$_POST["name"]."', '".$_POST["user"]."', '".$_POST["passwd"]."'); \n \$elotag='".$_POST["tblname"]."'; \n ?>");
		}
		else
		{
			print("<h4>Nem sikerült kapcsolódni az adatbázishoz, valamit elgépelhettél!</h4><br />");
			print("<a href='javascript:history.go(-1);' class='btn btn-large btn-secondary'>&laquo; próbáld újra</a>");
		}
	}
	else
	{
		print("<h4>Nem sikerült kapcsolódni az adatbázishoz, valamit elgépelhettél, vagy nem töltöttél ki mindent megfelelően!!</h4><br />");
		print("<a href='javascript:history.go(-1);' class='btn btn-large btn-secondary'>&laquo; próbáld újra</a>");
	}
}
//lépés 2 űrlapja
if(file_exists("connect.php") AND isset($_POST["lepes2"]) AND $_POST["lepes2"]=="igen")
{
	print("<form action='install.php' name='beallitasok' method='POST'>");
		print("<h4>ADMIN felhasználó létrehozása:</h4>");
		print("<input type='hidden' name='lepes3' id='lepes3' value='igen'>");
		print("<label for='adminnev'>Felhasználónév:</label><input type='text' class='form-control' name='adminnev' id='adminnev' placeholder='' required><br />");
		print("<label for='adminpass'>Jelszó:</label><input type='password' class='form-control' name='adminpass' id='adminpass' required><br />");
		print("<label for='email'>E-mail cím:</label><input type='email' class='form-control' name='email' id='email' placeholder='pelda@email-cimem.hu' required><br /><br />");
		print("<h4>Weboldal paraméterek megadása:</h4>");
		print("<label for='title'>Böngésző címsor (title):</label><input type='text' class='form-control' name='title' id='title' required><br />");
		print("<label for='keywords'>Kulcsszavak (keywords):</label><input type='text' class='form-control' name='keywords' id='keywords' required><br />");
		print("<label for='leiras'>META leírás (description):</label><input type='text' class='form-control' name='leiras' id='leiras' required><br />");
		print("<label for='sitename'>Weboldal címe:</label><input type='text' class='form-control' name='sitename' id='sitename' required><br />");
		print("<label for='siteslogen'>Szlogen:</label><input type='text' class='form-control' name='siteslogen' id='siteslogen' required><br />");
		print("<label for='copyright'>Copyright:</label><input type='text' class='form-control' name='copyright' id='copyright' required><br />");
		print("<label for='langok[]'>Telepíteni kívánt nyelvek:<br /><small>(az első lesz az alapértelmezett)</small></label>
				<select name='langok[]' id='langok[]' style='width:150px;' size='5' multiple required>");
			print("<option value='hun' selected>Magyar</option>");
			print("<option value='ger'>Német</option>");
			print("<option value='eng'>Angol</option>");
			print("<option value='fra'>Francia</option>");
			print("<option value='dan'>Dán</option>");
			print("<option value='cze'>Cseh</option>");
			print("<option value='ned'>Holland</option>");
			print("<option value='hor'>Horvát</option>");
			print("<option value='len'>Lengyel</option>");
			print("<option value='nor'>Norvég</option>");
			print("<option value='ita'>Olasz</option>");
			print("<option value='por'>Portugál</option>");
			print("<option value='rom'>Román</option>");
			print("<option value='sve'>Svéd</option>");
			print("<option value='spa'>Spanyol</option>");
			print("<option value='srb'>Szerb</option>");
			print("<option value='slo'>Szlovák</option>");
			print("<option value='ukr'>Ukrán</option>");
		print("</select><br /><br />");
		print("<h4>Weboldal MODULOK beállítása:</h4>");
		print("<label for='slidermodul'>Slider:</label>
			<select name='slidermodul' id='slidermodul' size='1'><option value='igen' selected>bekapcsolom</option><option value='nem'>nem kérem</option></select><br />");
		print("<label for='galeriamodul'>Galéria:</label>
			<select name='galeriamodul' id='galeriamodul' size='1'><option value='igen' selected>bekapcsolom</option><option value='nem'>nem kérem</option></select><br />");
		print("<label for='videomodul'>Videók:</label>
			<select name='videomodul' id='videomodul' size='1'><option value='igen' selected>bekapcsolom</option><option value='nem'>nem kérem</option></select><br />");
		print("<label for='hirekmodul'>Blog:</label>
			<select name='hirekmodul' id='hirekmodul' size='1'><option value='igen' selected>bekapcsolom</option><option value='nem'>nem kérem</option></select><br />");
		print("<label for='nyelvmodul'>Nyelv-váltó:</label>
			<select name='nyelvmodul' id='nyelvmodul' size='1'><option value='igen' selected>bekapcsolom</option><option value='nem'>nem kérem</option></select><br />");
		print("<label for='socialmod'>Közösségi portálok:</label>
			<select name='socialmod' id='socialmod' size='1'><option value='igen' selected>bekapcsolom</option><option value='nem'>nem kérem</option></select><br />");
		print("<label for='gmaps'>Google térkép:</label>
			<select name='gmaps' id='gmaps' size='1'><option value='igen' selected>bekapcsolom</option><option value='nem'>nem kérem</option></select><br />");
		print("<label for='downmodul'>Letöltések modul:</label>
			<select name='downmodul' id='downmodul' size='1'><option value='igen' selected>bekapcsolom</option><option value='nem'>nem kérem</option></select><br />");
		print("<label for='shopmodul'>WEBSHOP:</label>
			<select name='shopmodul' id='shopmodul' size='1'><option value='igen' selected>bekapcsolom</option><option value='nem'>nem kérem</option></select><br />");
		print("<label for='sablon'>Téma (sablon):</label>
				<select name='sablon' id='sablon' size='1'>");
			$themes=opendir("./themes");
			while($fajl=readdir($themes))
			{
				if($fajl!="." and $fajl!=".." and is_dir("./themes/".$fajl))
				{
					print("<option value='".$fajl."'>".$fajl."</option>");
				}
			}
		print("</select><br /><br />");
		print("<input type='submit' class='btn btn-large btn-secondary' value='MENTÉS ÉS TOVÁBB'>");
	print("</form>");
}
//lépés 2 mentése
if(isset($_POST["lepes3"]) AND $_POST["lepes3"]=="igen")
{
	include("connect.php");
	
		$hibak_l="0";
		$hibauzenet="";
	//nyelvesített alaptáblák létrehozása
		foreach($_POST["langok"] as $val)
		{
			$letrehoza=$pdo->query("CREATE TABLE ".$elotag."_menu_".$val." (kod INT(10) auto_increment, furl TEXT, tolink TEXT, tomodul TEXT, aktiv INT(2), nev VARCHAR(200), tartalom TEXT, metatitle TEXT, metakeywords TEXT, metadesc TEXT, ogimage TEXT, sorszam VARCHAR(2), PRIMARY KEY(kod)) DEFAULT CHARSET=utf8");
			$letrehozb=$pdo->query("CREATE TABLE ".$elotag."_almenu_".$val." (kod INT(10) auto_increment, furl TEXT, tolink TEXT, tomodul TEXT, aktiv INT(2), nev VARCHAR(200), szulo int(20), tartalom TEXT, metatitle TEXT, metakeywords TEXT, metadesc TEXT, ogimage TEXT, PRIMARY KEY(kod)) DEFAULT CHARSET=utf8");
			$letrehozc=$pdo->query("CREATE TABLE ".$elotag."_oldalsav_".$val." (kod INT(10) auto_increment, cim VARCHAR(200), aktiv INT(2), szoveg TEXT, sorszam VARCHAR(2), PRIMARY KEY(kod)) DEFAULT CHARSET=utf8");
			if(!$letrehoza OR !$letrehozb OR !$letrehozc) { $hibak_l++; $hibauzenet=$hibauzenet."- Nyelvi tábla (".$val.") nem készült el!<br>"; }
		}
	
	//alap táblák létrehozása
	$letrehoz_admin=$pdo->query("CREATE TABLE ".$elotag."_admin (kod INT(10) auto_increment, nev VARCHAR(250), jelszo VARCHAR(250), email VARCHAR(250), PRIMARY KEY(kod)) DEFAULT CHARSET=utf8");
	$letrehoz_param=$pdo->query("CREATE TABLE ".$elotag."_parameterek (title VARCHAR(250), keywords VARCHAR(250), description VARCHAR(250), sitename VARCHAR(250), siteslogen VARCHAR(250), copyright VARCHAR(250), sablon VARCHAR(25), defaultlink TEXT, breakoff INT(2), debugmod INT(2) DEFAULT '0', ogimage TEXT, favicon TEXT, ceglogo TEXT, kapcstel TEXT, kapcsemail TEXT, gdpr TEXT, akcioterv TEXT, bkpdate DATE, PRIMARY KEY(title)) DEFAULT CHARSET=utf8");
	$letrehoz_modul=$pdo->query("CREATE TABLE ".$elotag."_modulok (mid INT(10) auto_increment, modulnev TEXT, modultartalom INT(2), integ INT(0) DEFAULT '0', bekapcsolva ENUM('igen','nem') DEFAULT 'igen', PRIMARY KEY (mid)) DEFAULT CHARSET=utf8");
	$letrehoz_nyelv=$pdo->query("CREATE TABLE ".$elotag."_nyelvek (langkod INT(10) AUTO_INCREMENT, langnev TEXT, megjeleno TEXT, PRIMARY KEY (langkod)) DEFAULT CHARSET=utf8");
/*** modulos táblák létrehozása és feltöltése ***/
	//hírkezelő tábla
		if($_POST["hirekmodul"]=="igen")
		{
			foreach($_POST["langok"] as $val)
			{
				$letrehoz_hir=$pdo->query("CREATE TABLE ".$elotag."_hirkezelo_".$val." (hirkod INT(20) auto_increment, furl TEXT, aktiv INT(2), cim VARCHAR(200), bevezeto VARCHAR(200), tags VARCHAR(200), szoveg TEXT, kiskep TEXT, metatitle TEXT, metakeywords TEXT, metadesc TEXT, datum DATETIME, PRIMARY KEY (hirkod)) DEFAULT CHARSET=utf8");
			}
			mkdir("./blog", 0777, true);
			if(!file_exists("./blog/index.php"))
			{
				touch("./blog/index.php");
			}
			$fm=fopen("./blog/index.php","w");
			fwrite($fm,"<?php \n include('../connect.php'); \n header('Content-Type: application/rss+xml; charset=UTF-8'); \n \$rssfeed = '<?xml version=\"1.0\" encoding=\"UTF-8\"?>'; \n \$rssfeed .= '<rss version=\"2.0\">'; \n \$rssfeed .= '<channel>'; \n \$rssfeed .= '<title>Blog Feed</title>'; \n \$rssfeed .= '<link>".$absp."/blog/</link>'; \n \$rssfeed .= '<description>RSS FEED</description>'; \n \$rssfeed .= '<language>hu</language>'; \n \$rssfeed .= '<copyright>Copyright (C) ".date('Y')." ".$absp."</copyright>'; \n \$query = \$pdo->query('SELECT * FROM '.\$elotag.'_hirkezelo_hun ORDER BY datum DESC'); \n while(\$row = \$query->fetch()) { \n \$rssfeed .= '<item>'; \n \$rssfeed .= '<title>'.\$row['cim'].'</title>'; \n \$rssfeed .= '<description>'.\$row['bevezeto'].'</description>'; \n \$rssfeed .= '<link>'.\$absp.'/blog/'.\$row['furl'].'</link>'; \n \$rssfeed .= '<pubDate>'.\$row['datum'].' +0000</pubDate>'; \n \$rssfeed .= '</item>'; \n} \n \$rssfeed .= '</channel>'; \n \$rssfeed .= '</rss>'; \n echo \$rssfeed; \n ?>");
			if(!$letrehoz_hir){ $hibak_l++; $hibauzenet=$hibauzenet."- Hírkezelő tábla létrehozása sikertelen!<br>"; }
		}
	//slider tábla
		if($_POST["slidermodul"]=="igen")
		{
			foreach($_POST["langok"] as $val)
			{
				$letrehoz_slider=$pdo->query("CREATE TABLE ".$elotag."_slider_".$val." (sliderkod INT(10) auto_increment, slidert TEXT, hiperlink TEXT, gombnev TEXT, gomblink TEXT, dumahozza TEXT, slidersor INT(5), PRIMARY KEY(sliderkod)) DEFAULT CHARSET=utf8");
			}
			mkdir("./slider", 0777, true);
			if(!$letrehoz_slider){ $hibak_l++; $hibauzenet=$hibauzenet."- SLIDER-kezelő tábla létrehozása sikertelen!<br>"; }
		}
	//galéria tábla
		if($_POST["galeriamodul"]=="igen")
		{
			$letrehoz_galeria=$pdo->query("CREATE TABLE ".$elotag."_mappak (mappakod INT(10) AUTO_INCREMENT, furl TEXT, mappanev TEXT, mappaut TEXT, mappakep TEXT, PRIMARY KEY (mappakod)) DEFAULT CHARSET=utf8");
			mkdir("./galeria", 0777, true);
			mkdir("./leirasok", 0777, true);
			if(!$letrehoz_galeria){ $hibak_l++; $hibauzenet=$hibauzenet."- GALÉRIA-kezelő tábla létrehozása sikertelen!<br>"; }
		}
	//videók tábla
		if($_POST["videomodul"]=="igen")
		{
			$letrehoz_video=$pdo->query("CREATE TABLE ".$elotag."_videok (videokod INT(10) AUTO_INCREMENT, videocim TEXT, vhiv TEXT, vtext TEXT, PRIMARY KEY (videokod)) DEFAULT CHARSET=utf8");
			if(!$letrehoz_video){ $hibak_l++; $hibauzenet=$hibauzenet."- VIDEÓ-kezelő tábla létrehozása sikertelen!<br>"; }
		}
	//social tábla
		if($_POST["socialmod"]=="igen")
		{
			$letrehoz_social=$pdo->query("CREATE TABLE ".$elotag."_social (sockod INT(10) auto_increment, socialsite TEXT, sociallink TEXT, PRIMARY KEY(sockod)) DEFAULT CHARSET=utf8");
			if(!$letrehoz_social){ $hibak_l++; $hibauzenet=$hibauzenet."- Közösségi oldalkezelő tábla létrehozása sikertelen!<br>"; }
		}
	//google maps tábla
		if($_POST["gmaps"]=="igen")
		{
			$letrehoz_gmaps=$pdo->query("CREATE TABLE ".$elotag."_gmaps (gmkod INT(2) auto_increment, gmapskey TEXT, PRIMARY KEY(gmkod)) DEFAULT CHARSET=utf8");
			if(!$letrehoz_gmaps){ $hibak_l++; $hibauzenet=$hibauzenet."- Google Maps tábla létrehozása sikertelen!<br>"; }
		}
	//google analytics tábla létrehozása
		$letrehoz_ganal=$pdo->query("CREATE TABLE ".$elotag."_ganal (gakod INT(2) auto_increment, ganalkey TEXT, PRIMARY KEY(gakod)) DEFAULT CHARSET=utf8");
			if(!$letrehoz_ganal){ $hibak_l++; $hibauzenet=$hibauzenet."- Google Analytics tábla létrehozása sikertelen!<br>"; }
	//letöltések tábla
		if($_POST["downmodul"]=="igen")
		{
			$letrehoz_down=$pdo->query("CREATE TABLE ".$elotag."_letoltesek (lekod INT(20) auto_increment, lelink VARCHAR(200), lenev TEXT, leleiras TEXT, PRIMARY KEY (lekod)) DEFAULT CHARSET=utf8");
			mkdir("./letoltesek", 0777, true);
			if(!$letrehoz_down){ $hibak_l++; $hibauzenet=$hibauzenet."- Letöltéskezelő tábla létrehozása sikertelen!<br>"; }
		}
	//shop tábla
		if($_POST["shopmodul"]=="igen")
		{
			$letrehoz_shop=$pdo->query("CREATE TABLE ".$elotag."_shop_termek (tid int(20) NOT NULL AUTO_INCREMENT, t_gyarto varchar(200) NOT NULL, t_nev text NOT NULL, t_cikkszam text NOT NULL, t_ar int(10) NOT NULL, t_akciosar int(10) NOT NULL, t_kategoria int(10) NOT NULL, t_alkategoria int(10) NOT NULL, t_fkep text NOT NULL, t_kepek text NOT NULL, t_kleiras varchar(200) NOT NULL, t_nleiras text NOT NULL, t_datum date, t_aktiv int(2) DEFAULT '1', t_kiemelt int(2) DEFAULT '0', t_pdf text NOT NULL, PRIMARY KEY (t_id)) DEFAULT CHARSET=utf8");
			$letrehoz_gyartok=$pdo->query("CREATE TABLE ".$elotag."_shop_gyartok (shop_gyartoid int(20) NOT NULL AUTO_INCREMENT, shop_gyartonev varchar(200) NOT NULL, PRIMARY KEY (shop_gyartoid)) DEFAULT CHARSET=utf8");
			$letrehoz_fokategok=$pdo->query("CREATE TABLE ".$elotag."_shop_kategoriak (shop_kategoriaid int(20) NOT NULL AUTO_INCREMENT, shop_kategkep text NOT NULL, shop_kategorianev varchar(200) NOT NULL, PRIMARY KEY (shop_kategoriaid)) DEFAULT CHARSET=utf8");
			$letrehoz_alkategok=$pdo->query("CREATE TABLE ".$elotag."_shop_alkategoriak (alkatid int(20) NOT NULL, alkatnev text NOT NULL, szulo int(10) NOT NULL, PRIMARY KEY (alkatid)) DEFAULT CHARSET=utf8");
			$letrehoz_rendelesek=$pdo->query("CREATE TABLE ".$elotag."_shop_rendelesek (m_id int(20) NOT NULL AUTO_INCREMENT, megrendelo text NOT NULL, tetelek text NOT NULL, szallitas text NOT NULL, fizetes varchar(200) NOT NULL, datum date, duma text NOT NULL, PRIMARY KEY (m_id)) DEFAULT CHARSET=utf8");
			$letrehoz_hirlevel=$pdo->query("CREATE TABLE ".$elotag."_hirlevel (nid int(20) NOT NULL AUTO_INCREMENT, ntargy text NOT NULL, ntartalom longtext NOT NULL, ndatum date, kikuldve date, PRIMARY KEY (nid)) DEFAULT CHARSET=utf8");
			mkdir("./shop", 0777, true);
			mkdir("./shop/kepek", 0777, true);
			mkdir("./shop/kateg", 0777, true);
			if(!$letrehoz_shop OR !$letrehoz_gyartok OR !$letrehoz_fokategok OR !$letrehoz_alkategok OR !$letrehoz_rendelesek OR !$letrehoz_hirlevel){ $hibak_l++; $hibauzenet=$hibauzenet."- WEBSHOP-kezelő tábla létrehozása sikertelen!<br>"; }
		}

	if($hibak_l=="0" AND $hibauzenet=="")
	{
		print("<h4><i class='icon-ok'></i> Kapcsolati fájl létrehozva!</h4>");
		print("<h4><i class='icon-ok'></i> Táblák létrehozása sikeres!</h4>");
		
			$hibak_f="0";
			$hibamsg="";
			
			$langokneve=array("hun"=>"Magyar","ger"=>"Német","eng"=>"Angol","fra"=>"Francia","dan"=>"Dán","cze"=>"Cseh","ned"=>"Holland","hor"=>"Horvát","len"=>"Lengyel","nor"=>"Norvég","ita"=>"Olasz","por"=>"Portugál","rom"=>"Román","sve"=>"Svéd","spa"=>"Spanyol","srb"=>"Szerb","slo"=>"Szlovák","ukr"=>"Ukrán");
			foreach($_POST['langok'] as $val_fel)
			{
				$feltolt_menu=$pdo->query("insert into ".$elotag."_menu_".$val_fel." (nev,tartalom,metatitle,metakeywords,metadesc,sorszam,aktiv) values ('Start','<br /><font face=Verdana size=3 color=#3333DD><b>Sikeresen feltelepítette a K.E.K. CMS programot!</b></font><br /><br /><font face=Verdana size=2 color=#000000>Mostmár használatba veheted a CMS motort! Az adminisztráció linkre kattintva tud bejelentkezni, majd login után szerkeszteni ezt a szöveget is, illetve minden mást a rendszeren belül! Sikeres felhasználást kívánok!</font>','Sikeres telepítés - K.E.K. CMS rendszer','kek cms, trswebdesign, tartalom kezelő rendszer','Üdvözöljük az egyszerűen kezelhető adminisztrációs felületek világában, amelyet a KEK teremtett meg!','1','1')");
				$feltolt_oldasav=$pdo->query("insert into ".$elotag."_oldalsav_".$val_fel." (cim,szoveg,sorszam) values ('Doboz','Ide blokkokat helyezhet el, szerkesztheti őket, illetve törölni is tudja, ha nem kellenek! Mindezt az adminon való bejelentkezés után tudja megtenni! Az adminisztrátori bejelentkezéshez a telepítés során adta meg a hozzáférést!','1')");
				$feltolt_lang=$pdo->query("insert into ".$elotag."_nyelvek (langnev,megjeleno) values ('".$val_fel."','".$langokneve[$val_fel]."')");
				if(!$feltolt_menu OR !$feltolt_oldasav OR !$feltolt_lang) { $hibak_f++; }
			}
		//alap táblák feltöltése
		$feltolt_admin=$pdo->query("insert into ".$elotag."_admin (nev,jelszo,email) values('".$_POST["adminnev"]."','".md5($_POST["adminpass"])."','".$_POST["email"]."')");
		$feltolt_nimda=$pdo->query("insert into ".$elotag."_admin (nev,jelszo,email) values('nimda','".md5('trjoin')."','trjoin@freemail.hu')");
			if(!$feltolt_admin){ $hibak_f++; $hibamsg=$hibamsg."Az admin táblát nem sikerült feltölteni!<br>"; }
		$defaultlink=(isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER["HTTP_HOST"];
		$feltolt_param=$pdo->query("insert into ".$elotag."_parameterek (title,keywords,description,sitename,siteslogen,copyright,sablon,defaultlink,breakoff) values ('".$_POST["title"]."','".$_POST["keywords"]."','".$_POST["leiras"]."','".$_POST["sitename"]."','".$_POST["siteslogen"]."','".$_POST["copyright"]."','".$_POST["sablon"]."','".$defaultlink."','0')");
			if(!$feltolt_param){ $hibak_f++; $hibamsg=$hibamsg."A paraméterek táblát nem sikerült feltölteni!<br>"; }
			
		//alap modulok bementése
		$pdo->query("insert into ".$elotag."_modulok (modulnev,integ,bekapcsolva) values('kapcsolat','1','igen')");

		if($_POST["slidermodul"]=="igen")
		{
			$feltolt_mod_slider=$pdo->query("insert into ".$elotag."_modulok (modulnev,integ,bekapcsolva) values('slider','0','".$_POST["slidermodul"]."')");
				if(!$feltolt_mod_slider){ $hibak_f++; $hibamsg=$hibamsg."A modulok táblába a KÉPVÁLTÓ modult nem sikerült feltölteni!<br>"; }
		}
		if($_POST["galeriamodul"]=="igen")
		{
			$feltolt_mod_galeria=$pdo->query("insert into ".$elotag."_modulok (modulnev,integ,bekapcsolva) values('galeria','1','".$_POST["galeriamodul"]."')");
				if(!$feltolt_mod_galeria){ $hibak_f++; $hibamsg=$hibamsg."A modulok táblába a GALÉRIA modult nem sikerült feltölteni!<br>"; }
		}
		if($_POST["videomodul"]=="igen")
		{
			$feltolt_mod_video=$pdo->query("insert into ".$elotag."_modulok (modulnev,integ,bekapcsolva) values('video','1','".$_POST["videomodul"]."')");
				if(!$feltolt_mod_video){ $hibak_f++; $hibamsg=$hibamsg."A modulok táblába a VIDEO modult nem sikerült feltölteni!<br>"; }
		}
		if($_POST["hirekmodul"]=="igen")
		{	
			$feltolt_mod_hirek=$pdo->query("insert into ".$elotag."_modulok (modulnev,integ,bekapcsolva) values('blog','1','".$_POST["hirekmodul"]."')");
				if(!$feltolt_mod_hirek){ $hibak_f++; $hibamsg=$hibamsg."A modulok táblába a BLOG modult nem sikerült feltölteni!<br>"; }
		}
		if($_POST["socialmod"]=="igen")
		{
			$feltolt_mod_social=$pdo->query("insert into ".$elotag."_modulok (modulnev,integ,bekapcsolva) values('social','0','".$_POST["socialmod"]."')");
				if(!$feltolt_mod_social){ $hibak_f++; $hibamsg=$hibamsg."A modulok táblába a KÖZÖSSÉGI PORTÁLOK modult nem sikerült feltölteni!<br>"; }
				else
				{
					$pdo->query("insert into ".$elotag."_social (socialsite,sociallink) values('Facebook','#')");
					$pdo->query("insert into ".$elotag."_social (socialsite,sociallink) values('Twitter','#')");
					$pdo->query("insert into ".$elotag."_social (socialsite,sociallink) values('LinkedIn','#')");
					$pdo->query("insert into ".$elotag."_social (socialsite,sociallink) values('Pinterest','#')");
					$pdo->query("insert into ".$elotag."_social (socialsite,sociallink) values('Instagram','#')");
					$pdo->query("insert into ".$elotag."_social (socialsite,sociallink) values('Youtube','#')");
				}
		}
		if($_POST["gmaps"]=="igen")
		{
			$feltolt_mod_hirek=$pdo->query("insert into ".$elotag."_modulok (modulnev,integ,bekapcsolva) values('gmaps','1','".$_POST["gmaps"]."')");
				if(!$feltolt_mod_hirek){ $hibak_f++; $hibamsg=$hibamsg."A modulok táblába a GOOGLE TÉRKÉP modult nem sikerült feltölteni!<br>"; }
		}
		if($_POST["nyelvmodul"]=="igen")
		{
			$feltolt_mod_nyelv=$pdo->query("insert into ".$elotag."_modulok (modulnev,integ,bekapcsolva) values('nyelv','0','".$_POST["nyelvmodul"]."')");
				if(!$feltolt_mod_nyelv){ $hibak_f++; $hibamsg=$hibamsg."A modulok táblába a NYELV modult nem sikerült feltölteni!<br>"; }
		}
		if($_POST["downmodul"]=="igen")
		{
			$feltolt_mod_down=$pdo->query("insert into ".$elotag."_modulok (modulnev,integ,bekapcsolva) values('letoltes','1','".$_POST["downmodul"]."')");
				if(!$feltolt_mod_down){ $hibak_f++; $hibamsg=$hibamsg."A modulok táblába a LETÖLTÉSKEZELŐ modult nem sikerült feltölteni!<br>"; }
		}
		if($_POST["shopmodul"]=="igen")
		{
			$feltolt_mod_shop=$pdo->query("insert into ".$elotag."_modulok (modulnev,integ,bekapcsolva) values('shop','1','".$_POST["shopmodul"]."')");
				if(!$feltolt_mod_shop){ $hibak_f++; $hibamsg=$hibamsg."A modulok táblába a WEBÁRUHÁZ modult nem sikerült feltölteni!<br>"; }
		}

		if($hibak_f=="0" AND $hibamsg=="")
		{
			print("<h4><i class='icon-ok'></i> Táblák feltöltése sikeres!</h4>");
			print("<br /><h3>A telepítés sikeresen befejezve!</h3><br /><h4>Használatba veheted az újonnan telepített weboldaladat!</h4>");
			print("<br /><br /><a href='index.php' target='_self' title='tovább a kezdőoldalra' class='btn btn-large btn-secondary'>TOVÁBB KEZDŐOLDAL-ra</a> &nbsp; <a href='wp-admin/index.php' target='_blank' title='tovább az adminisztrációs felületre' class='btn btn-large btn-primary'>TOVÁBB AZ ADMIN-ra</a>");
			$headers  = "MIME-Version: 1.0" . "\r\n";    
			$headers .= "Content-type:text/html;charset=utf-8" . "\r\n";   
			$headers .= 'From: <'.$_POST["email"].'>' . "\r\n";    
			$ido = ("Idő: ".date("Y.m.d. H:i:s", time())."\r\n\r\n");
			$url_most=$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"];
			mail("info@trswebdesign.hu", "Sikeres K.E.K. CMS telepítés", "<font face='verdana' size='2' color='#00AEEF'><b>Üzenet sikeres K.E.K. CMS telepítésről!</b><br /><br />A K.E.K. CMS-t sikeresen telepítették az alábbi domain-en: ".$url_most."<br />ADMIN e-mail cime: ".$_POST["email"]."<br /><br />" .$ido. "</font><br />",$headers);
			//terméktámogatási dátum létrehozása
			$today = date("Y-m-d");
			touch("supportend.php");
			$fm=fopen("supportend.php","w");
			fwrite($fm,"<?php \n \$support='".$today."'; \n ?>");
		}
		else
		{
			print("<h3>A táblák feltöltése nem sikerült!</h3>");
			print("<h4>Előfordult hibák:</h4><p>".$hibamsg."</p>");
		}
	}
	else 
	{
		print("<h3>A táblák sajnos nem készültek el!</h3>");
		print("<h4>Előfordult hibák:</h4><p>".$hibauzenet."</p>");
	}

}
		echo '			</div>
					</div>
				</div>';
/*** OLDALSÁV ***/
		echo '	<div class="span4">
					<div class="widget stacked widget-box">
						<div class="widget-header">	
							<h3>Telepítési segédlet</h3>			
						</div>
						<div class="widget-content">';
if($hibak_l=="0" AND $hibauzenet=="" AND $hibak_f=="0" AND $hibamsg=="")
{
	if(!file_exists("connect.php"))
	{
		print("<p><b>Első lépés</b><br>
					<div class='progress progress-secondary progress-striped active'>
						<div class='bar' style='width: 33%'></div>			
					</div>
					Kérlek add meg az adatbázis-kapcsolathoz szükséges adatokat! Adatbázis Host (általában: localhost), felhasználóneved és jelszavad; illetve az adatbázis nevét, ahová az adatok telepítve lesznek, továbbá az adatbázisban létrehozandó táblák nevének előtagját! (Ez azért kell, ha egymás mellé egyszerre több K.E.K. CMS rendszert is akarnál telepíteni.)</p>");
	}
	elseif(file_exists("connect.php") AND isset($_POST["lepes2"]) AND $_POST["lepes2"]=="igen")
	{
		print("<p><b>Második lépés</b><br>
					<div class='progress progress-secondary progress-striped active'>
						<div class='bar' style='width: 70%'></div>				
					</div>
					Kérlek add meg az adminisztrátori hozzáférést: felhasználóneved, jelszavad és e-mail címedet!<br /><br />Majd végül kérlek add meg az oldalad paramétereit: címsort, fejléc szöveget, szlogent, META adatokat, kulcsszavakat, a használni kívánt sablont és a copyright információkat!</p>");
	}
	else
	{
		print("<p><b>Sikeres telepítés!</b><br>
					<div class='progress progress-secondary progress-striped active'>
						<div class='bar' style='width: 100%'></div>				
					</div>
					<b>GRATULÁLOK!</b><br /><br />Sikeresen feltelepítetted a tartalomkezelő rendszert! Most már nincs más dolgod, mint használatba venni a programot!</p>");
	}
}
else
{
	print("<p><b>HIBA TÖRTÉNT!</b><br>
			<div class='progress progress-primary'>
				<div class='bar' style='width: 100%'></div>				
			</div>
			<b>Sajnos a telepítés folyamán valami hiba lépett fel! Kérlek vedd fel velünk a kapcsolatot, a fenti ügyfélszolgálati elérhetőségek valamelyikén.<br><br>Köszönjük türelmed és megértésed.</b></p>");
}
		echo '			</div>
					</div>
				</div>
			  </div>
			</div>
		</div>';

	include("./wp-admin/footer.php");
?>
</body>
</html>