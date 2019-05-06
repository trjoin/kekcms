<?php
session_start();
if(isset($_SESSION["userlogged"]) AND $_SESSION["userlogged"]!="" AND $_SESSION["userlogged"]!=" ")
{
?>
<link href="./css/ui-lightness/jquery-ui-1.10.0.custom.min.css" rel="stylesheet" />
<link href="./js/plugins/lightbox/themes/evolution-dark/jquery.lightbox.css" rel="stylesheet" />
<link href="./js/plugins/msgGrowl/css/msgGrowl.css" rel="stylesheet" />
<link href="./js/plugins/msgbox/jquery.msgbox.css" rel="stylesheet" />	
<script src="./js/plugins/hoverIntent/jquery.hoverIntent.minified.js"></script>
<script src="./js/plugins/lightbox/jquery.lightbox.min.js"></script>
<script src="./js/demo/gallery.js"></script>
<script src="./js/demo/notifications.js"></script>
<script src="./js/plugins/msgGrowl/js/msgGrowl.js"></script>
<script src="./js/plugins/msgbox/jquery.msgbox.min.js"></script>
<?php
	$mirol=array("í","é","á","ű","ú","ő","ó","ü","ö","Í","É","Á","Ű","Ú","Ő","Ó","Ü","Ö","_","+",":",",","?","=","(",")","[","]","{","}","&","#","@","<",">","$","'","!","/"," ");
	$mire=array("i","e","a","u","u","o","o","u","o","i","e","a","u","u","o","o","u","o","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-");
	//kép törlése
	if(isset($_GET["keptorol"]))
	{
		$keptorol=unlink("../galeria/".$_GET["honnan"]."/".$_GET["keptorol"]);
		if($keptorol)
		{
			if(file_exists("../leirasok/".$_GET["keptorol"].".txt"))
			{
				$texttorol=unlink("../leirasok/".$_GET["keptorol"].".txt");
			}
			echo "<script type='text/javascript'>
					$(document).ready(function() {
						$.msgGrowl({
							type: 'success',
							title: 'Üzenet',
							text: 'Sikeres képtörlés!'
						});
					});
					</script>";
		}
		else
		{
			echo "<script type='text/javascript'>
					$(document).ready(function() {
						$.msgGrowl({
							type: 'error',
							title: 'Üzenet',
							text: 'Sikertelen kép törlés, SQL hiba történt!'
						});
					});
					</script>";
		}
	}
	//mappa törlése
	if(isset($_GET["dirtorol"]))
	{
		$csekkol=$pdo->query("select * from ".$elotag."_mappak where mappakod='".$_GET["dirtorol"]."'");
		$mapkp=$csekkol->fetch();
		$mappakeptorol=unlink("../galeria/".$mapkp["mappakep"]."");
		$dirdel=$pdo->query("delete from ".$elotag."_mappak where mappakod='".$_GET["dirtorol"]."'");
		if($dirdel)
		{
			echo "<script type='text/javascript'>
					$(document).ready(function() {
						$.msgGrowl({
							type: 'success',
							title: 'Üzenet',
							text: 'Sikeres album törlés!'
						});
					});
					</script>";
		}
		else
		{
			echo "<script type='text/javascript'>
					$(document).ready(function() {
						$.msgGrowl({
							type: 'error',
							title: 'Üzenet',
							text: 'Sikertelen album törlés, SQL hiba történt!'
						});
					});
					</script>";
		}
	}
	//kép feltöltése
	if(isset($_FILES["kep"]))
	{
		if(count($_FILES["kep"]))
		{
			include("SimpleImage.php");
			$feltoltve=0;
			for($i = 0; $i < count($_FILES["kep"]["name"]); $i++)
			{
				$SafeFile = $_FILES["kep"]["name"][$i];
				$SafeFile = strtolower($SafeFile);
				$SafeFile = str_replace($mirol, $mire, $SafeFile);
				
				$datummost=getDate();
				$datekeszit=mktime($datummost["hours"],$datummost["minutes"],$datummost["seconds"],$datummost["mon"],$datummost["mday"],$datummost["year"]);
				$dazo=date("Ymdhms",$datekeszit);
				$kepnev=$dazo."_".$SafeFile;
				$fajlnev="../galeria/".$_POST["mappa"]."/".$kepnev;

				$ext = strtolower(substr(strrchr($_FILES["kep"]["name"][$i], "."), 1));
				if($ext == "jpg" || $ext == "jpeg" || $ext == "png")
				{
					if(move_uploaded_file($_FILES['kep']['tmp_name'][$i],$fajlnev))
					{
						$feltoltve++;
						list($width, $height) = getimagesize($fajlnev);
						if($width>="1")
						{
							if($width>="1280")
							{
								//dátumbélyeg fájlnév előkészítő
								$uks=$dazo."_s_".$SafeFile;
								//Képméretező FÁNKSÖN
								$image = new SimpleImage();
								$image->load($fajlnev);
								$image->resizeToWidth(1280);
								$image->save("../galeria/".$_POST["mappa"]."/".$uks);
								//régi nagy kép törlése
								unlink($fajlnev);
							}
							if(isset($_POST["leiras"]) AND $_POST["leiras"]!="")
							{
								if($uks!="")
								{
									$kepnev=$uks;
								}
								if(touch("../leirasok/".$kepnev.".txt"))
								{
									$fm=fopen("../leirasok/".$kepnev.".txt","a");
									fwrite($fm,$_POST["leiras"]);
									echo "<script type='text/javascript'>
										$(document).ready(function() {
											$.msgGrowl({
												type: 'success',
												title: 'Üzenet',
												text: 'Sikeres képfeltöltés, a leírás is mentésre került!'
											});
										});
										</script>";
								}
								else
								{
									echo "<script type='text/javascript'>
											$(document).ready(function() {
												$.msgGrowl({
													type: 'info',
													title: 'Üzenet',
													text: 'Sikeres képfeltöltés, de a leírást nem sikerült menteni!'
												});
											});
											</script>";
								}
							}
							else
							{
								echo "<script type='text/javascript'>
										$(document).ready(function() {
											$.msgGrowl({
												type: 'success',
												title: 'Üzenet',
												text: 'Sikeres képfeltöltés, leírást nem adott meg!'
											});
										});
										</script>";
							}
						}
						else
						{
							unlink($fajlnev);
							echo "<script type='text/javascript'>
									$(document).ready(function() {
										$.msgGrowl({
											type: 'error',
											title: 'Üzenet',
											text: 'Sikertelen képfeltöltés, hibás formátum! Próbálja újra!'
										});
									});
									</script>";
						}
					}
					else
					{
						echo "<script type='text/javascript'>
								$(document).ready(function() {
									$.msgGrowl({
										type: 'error',
										title: 'Üzenet',
										text: 'Sikertelen képfeltöltés! Próbálja újra!'
									});
								});
								</script>";
					}
				}
				else
				{
					echo "<script type='text/javascript'>
							$(document).ready(function() {
								$.msgGrowl({
									type: 'error',
									title: 'Üzenet',
									text: 'Sikertelen képellenőrzés, hibás formátum! Próbálja újra!'
								});
							});
							</script>";
				}
			}
		}
	}
	//mappa létrehozása és mentése
	if(isset($_POST["mappanev"]) AND $_FILES["mappakep"]["name"]!="")
	{
		$furl=str_replace($mirol, $mire, strtolower($_POST["mappanev"]));
		//mappanév feldolgozás
		$SafeFile=$_POST["mappanev"];
		$SafeFile = strtolower($SafeFile);
		$SafeFile = str_replace($mirol, $mire, $SafeFile);
		//mappakép feldolgozás
		$MapFile=$_FILES["mappakep"]["name"];
		$MapFile = strtolower($MapFile);
		$MapFile = str_replace($mirol, $mire, $MapFile);
			
		$datummost=getDate();
		$datekeszit=mktime($datummost["hours"],$datummost["minutes"],$datummost["seconds"],$datummost["mon"],$datummost["mday"],$datummost["year"]);
		$dazo=date("Ymdhms",$datekeszit);
		$mappakep="../galeria/".$dazo."_".$MapFile;
		$mappakepnev=$dazo."_".$MapFile;
		
		//végrehajtás
		if(move_uploaded_file($_FILES["mappakep"]["tmp_name"],$mappakep))
		{
			list($width, $height) = getimagesize("../galeria/".$mappakepnev);
			if($width>="1")
			{
				mkdir("../galeria/".$SafeFile, 0777);
				$ment=$pdo->query("insert into ".$elotag."_mappak (furl,mappanev,mappaut,mappakep) values('".$furl."','".$_POST["mappanev"]."','".$SafeFile."','".$mappakepnev."')");
				if(!$ment)
				{
					echo "<script type='text/javascript'>
							$(document).ready(function() {
								$.msgGrowl({
									type: 'error',
									title: 'Üzenet',
									text: 'Sikertelen album mentés, SQL hiba történt!'
								});
							});
							</script>";
				}
				else
				{
					echo "<script type='text/javascript'>
							$(document).ready(function() {
								$.msgGrowl({
									type: 'success',
									title: 'Üzenet',
									text: 'Sikeres album mentés!'
								});
							});
							</script>";
				}
			}
			else
			{
				echo "<script type='text/javascript'>
						$(document).ready(function() {
							$.msgGrowl({
								type: 'error',
								title: 'Üzenet',
								text: 'Sikertelen album mentés, a boritókép nem kép!'
							});
						});
						</script>";
			}
		}
		else
		{
			echo "<script type='text/javascript'>
					$(document).ready(function() {
						$.msgGrowl({
							type: 'error',
							title: 'Üzenet',
							text: 'Sikertelen album mentés, nem volt mappakép, vagy nem sikerült feltölteni!'
						});
					});
					</script>";
		}
	}
	//mappa szerkesztésének mentése
	if(isset($_POST["mappanevedt"]) AND isset($_POST["diredt"]))
	{
		$furl=str_replace($mirol, $mire, strtolower($_POST["mappanevedt"]));
		//mappanév feldolgozás
		$SafeFile=$_POST["mappanevedt"];
		$SafeFile = strtolower($SafeFile);
		$SafeFile = str_replace($mirol, $mire, $SafeFile);
		
		if($_FILES["mappakepedt"]["name"]!="")
		{
			//mappakép feldolgozás
			$MapFile=$_FILES["mappakepedt"]["name"];
			$MapFile = strtolower($MapFile);
			$MapFile = str_replace($mirol, $mire, $MapFile);
				
			$datummost=getDate();
			$datekeszit=mktime($datummost["hours"],$datummost["minutes"],$datummost["seconds"],$datummost["mon"],$datummost["mday"],$datummost["year"]);
			$dazo=date("Ymdhms",$datekeszit);
			$mappakep="../galeria/".$dazo."_".$MapFile;
			$mappakepnev=$dazo."_".$MapFile;
		
			//végrehajtás
			if(move_uploaded_file($_FILES["mappakepedt"]["tmp_name"],$mappakep))
			{
				list($width, $height) = getimagesize("../galeria/".$mappakepnev);
				if($width>="1")
				{
					$ment=$pdo->query("update ".$elotag."_mappak set furl='".$furl."',mappanev='".$_POST["mappanevedt"]."',mappakep='".$mappakepnev."' where mappakod='".$_POST["diredt"]."'");
					if(!$ment)
					{
						echo "<script type='text/javascript'>
								$(document).ready(function() {
									$.msgGrowl({
										type: 'error',
										title: 'Üzenet',
										text: 'Sikertelen album módosítás, SQL hiba történt!'
									});
								});
								</script>";
					}
					else
					{
						echo "<script type='text/javascript'>
								$(document).ready(function() {
									$.msgGrowl({
										type: 'success',
										title: 'Üzenet',
										text: 'Sikeres album módosítás!'
									});
								});
								</script>";
					}
				}
				else
				{
					echo "<script type='text/javascript'>
							$(document).ready(function() {
								$.msgGrowl({
									type: 'error',
									title: 'Üzenet',
									text: 'Sikertelen album módosítás, a boritókép nem kép!'
								});
							});
							</script>";
				}
			}
			else
			{
				echo "<script type='text/javascript'>
						$(document).ready(function() {
							$.msgGrowl({
								type: 'error',
								title: 'Üzenet',
								text: 'Sikertelen album módosítás, a mappa borítóképét nem sikerült feltölteni!'
							});
						});
						</script>";
			}
		}
		else
		{
			$ment=$pdo->query("update ".$elotag."_mappak set furl='".$furl."',mappanev='".$_POST["mappanevedt"]."' where mappakod='".$_POST["diredt"]."'");
			if(!$ment)
			{
				echo "<script type='text/javascript'>
						$(document).ready(function() {
							$.msgGrowl({
								type: 'error',
								title: 'Üzenet',
								text: 'Sikertelen album módosítás, SQL hiba történt!'
							});
						});
						</script>";
			}
			else
			{
				echo "<script type='text/javascript'>
						$(document).ready(function() {
							$.msgGrowl({
								type: 'success',
								title: 'Üzenet',
								text: 'Sikeres album módosítás!'
							});
						});
						</script>";
			}
		}
	}
/*** admin megjelentítése ***/
	if(isset($_GET["ujkep"]))
	{
		//képfeltöltés
		echo "<h4>KÉP FELTÖLTÉSE A GALÉRIÁBA:</h4>";
		echo "<form enctype='multipart/form-data' action='index.php?lng=".$webaktlang."&page=galeria&open=1' method='POST'>";
		$mappak=$pdo->query("select * from ".$elotag."_mappak");
		if($mappak->rowCount()<=0)
		{
			echo "<p><b>MÉG NINCS ALBUM LÉTREHOZVA!</b></p>";
			echo "<a class='btn' href='index.php?lng=".$webaktlang."&page=galeria&ujalbum=1'>Új album létrehozása &raquo;</a>";
		}
		else
		{
			echo "<font face='arial' size='2' color='#190210'>Válassza ki a képet:</font><br>&nbsp;&nbsp; ";
			echo "<input type='file' name='kep[]' required='required' multiple><br />";
			echo "<font face='arial' size='2' color='#190210'>Válassza ki hová tölti fel:</font><br>&nbsp;&nbsp; ";
			echo "<select name='mappa' id='mappa'>";
			while($em=$mappak->fetch())
			{
				echo "<option value='".$em["mappaut"]."'>".$em["mappanev"]."</option>";
			}
			echo "</select><br />";
			echo "<font face='arial' size='2' color='#190210'>Adjon egy rövid megjegyzést a képhez:</font><br>&nbsp;&nbsp; <input type='text' name='leiras' id='leiras' placeholder='ezen a képen mi szerepel...'><br /><br />";
			echo "<input type=submit value='FELTÖLTÉS' class='btn btn-large btn-secondary'>";
		}
		echo "</form>";
	}
	if(isset($_GET["ujalbum"]))
	{
		//mappalétrehozás
		echo "<h4>ÚJ ALBUM LÉTREHOZÁSA A GALÉRIÁBA:</h4>";
		echo "<form enctype='multipart/form-data' action='index.php?lng=".$webaktlang."&page=galeria&open=1' method='POST'>";
		echo "<font face='arial' size='2' color='#190210'>Írja be az új album nevét:</font><br>&nbsp;&nbsp; <input type='text' name='mappanev' id='mappanev'><br />";
		echo "<font face='arial' size='2' color='#190210'>Adja meg az album borítóképét:</font><br>&nbsp;&nbsp; <input type='file' name='mappakep' id='mappakep'><br /><br />";
		echo "<input type=submit value='ALBUM MENTÉSE' class='btn btn-large btn-secondary'>";
		echo "</form>";
	}
	if(isset($_GET["diredit"]))
	{
		$mappabe=$pdo->query("select * from ".$elotag."_mappak where mappakod='".$_GET["diredit"]."'");
		$azut=$mappabe->fetch();
		//mappa szerkesztés
		echo "<h4>ALBUM SZERKESZTÉSE A GALÉRIÁBA:</h4>";
		echo "<form enctype='multipart/form-data' action='index.php?lng=".$webaktlang."&page=galeria&open=1' method='POST'>";
		echo "<input type='hidden' name='diredt' value='".$_GET["diredit"]."'>";
		echo "<font face='arial' size='2' color='#190210'>Írja be az <b>új</b> album nevét:</font><br>&nbsp;&nbsp; 
				<input type='text' name='mappanevedt' id='mappanevedt' value='".$azut["mappanev"]."'><br />";
		echo "<font face='arial' size='2' color='#190210'>Adja meg az <b>új</b> album borítóképét<br><small>(nem kötelező, maradhat a régi is)</small>:</font><br>&nbsp;&nbsp; 
				<input type='file' name='mappakepedt' id='mappakepedt'><br /><br />";
		echo "<input type=submit value='ALBUM MENTÉSE' class='btn btn-large btn-secondary'>";
		echo "</form>";
	}
	if(isset($_GET["open"]))
	{
		//mappák és képek megnyitása
		if(isset($_GET["megnyit"]))
		{
			//mappa adatainak betöltése
			$mappabe=$pdo->query("select * from ".$elotag."_mappak where mappakod='".$_GET["megnyit"]."'");
			$azut=$mappabe->fetch();
			//html folytatása
			echo "<b>Galéria | ".$azut["mappanev"]." album // <a href='index.php?lng=".$webaktlang."&page=galeria&open=1' style='text-decoration:none;'>&laquo; vissza</a></b><br /><br />";
			echo "<ul class='gallery-container'>";
			$melyik=opendir("../galeria/".$azut["mappaut"]);
			$szamol=0;
			while($fajl=readdir($melyik))
			{
				if($fajl!="." and $fajl!="..")
				{
					echo "<li><a href='../galeria/".$azut["mappaut"]."/".$fajl."' class='ui-lightbox'><img src='../galeria/".$azut["mappaut"]."/".$fajl."'></a> <a href='../galeria/".$azut["mappaut"]."/".$fajl."' class='preview'></a><br ><br><a href='index.php?lng=".$webaktlang."&page=galeria&open=1&keptorol=".$fajl."&honnan=".$azut["mappaut"]."' style='color:#FF0000;' onclick=\"return confirm('Biztos törlöd a képet?')\">&laquo; kép törlése &raquo;</a></li>";
					$szamol++;
				}
			}
			echo "</ul>";
			echo "<p>Összesen: ".$szamol." db kép</p>";
		}
		//mappák felolvasása
		else
		{
			echo "<h3>Albumok, galéria kezelése</h3>";
			echo "<a class='btn' href='index.php?lng=".$webaktlang."&page=galeria&ujkep=1'>+ Új kép feltöltése &raquo;</a> 
					<a class='btn' href='index.php?lng=".$webaktlang."&page=galeria&ujalbum=1'>+ Új album létrehozása &raquo;</a><br><br>";
			echo "<ul class='gallery-container'>";
			$mappak=$pdo->query("select * from ".$elotag."_mappak");
			if($mappak->rowCount()<=0)
			{
				echo "Még nincs mappa létrehozva!";
			}
			else
			{
				while($mem=$mappak->fetch())
				{
					echo "<li>
								<a href='index.php?lng=".$webaktlang."&page=galeria&open=1&megnyit=".$mem["mappakod"]."'><img src='../galeria/".$mem["mappakep"]."' border='0'><br /><b>".$mem["mappanev"]."</b><br>album megnyitás</a>
								<br />
								<a href='index.php?lng=".$webaktlang."&page=galeria&diredit=".$mem["mappakod"]."' style='color:#009900;'>&laquo; album szerkesztés &raquo;</a>
								<br />
								<a href='index.php?lng=".$webaktlang."&page=galeria&open=1&dirtorol=".$mem["mappakod"]."' style='color:#ff0000;' onclick=\"return confirm('Biztos törlöd a mappát?')\">&laquo; album törlés &raquo;</a>
							</li>";
				}
			}
			echo "</ul>";
		}
	}
}
else { echo 'ERROR BAZMEG!'; }
?>