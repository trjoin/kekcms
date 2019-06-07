<?php
session_start();
if(isset($_SESSION["userlogged"]) AND $_SESSION["userlogged"]!="" AND $_SESSION["userlogged"]!=" ")
{
?>
<script>
function fokepCsere(f)
{
	if(document.termekmodform.fkepetis.checked == true)
	{
		document.termekmodform.t_fkep.disabled=false;
	}
	else
	{
		document.termekmodform.t_fkep.disabled=true;
	}
}

function tobbikepCsere(f)
{
	if(document.termekmodform.tobbkepetis.checked == true)
	{
		document.getElementById('t_kepek[]').disabled=false;
	}
	else
	{
		document.getElementById('t_kepek[]').disabled=true;
	}
}

function PDFetis(f)
{
	if(document.ujtermek.pdfis.checked == true)
	{
		document.getElementById('t_pdf').disabled=false;
	}
	else
	{
		document.getElementById('t_pdf').disabled=true;
	}
}

function PDFetismod(f)
{
	if(document.termekmodform.pdfis.checked == true)
	{
		document.getElementById('t_pdf').disabled=false;
	}
	else
	{
		document.getElementById('t_pdf').disabled=true;
	}
}
</script>
<?php
/*** TÖRLÉSEK VÉGREHAJTÁSA ***/
	//termék törlése
	if(isset($_GET["termektorol"]))
	{
		$torles=$pdo->query("delete from ".$elotag."_shop_termek where t_id=".$_GET["termektorol"]);
		if($torles)
		{
			echo "<h3 style='color:#00FF00;'>Sikeres terméktörlés!</h3>";
			echo "<script>
					function atiranyit()
					{
						location.href = 'index.php?lng=hun&page=shop';
					}
					ID = window.setTimeout('atiranyit();', 1*300);
				</script>";
		}
		else
		{
			echo "<h3 style='color:#FF0000;'>Sajnos nem sikerült a termék törlése!</h3>";
			echo "<script>
					function atiranyit()
					{
						location.href = 'index.php?lng=hun&page=shop';
					}
					ID = window.setTimeout('atiranyit();', 1*300);
				</script>";
		}
	}
	//kategória törlése
	elseif(isset($_GET["kategoriatorol"]))
	{
		$torles=$pdo->query("delete from ".$elotag."_shop_kategoriak where shop_kategoriaid='".$_GET["kategoriatorol"]."'");
		if($torles)
		{
			echo "<h3 style='color:#00FF00;'>Sikeres kategóriatörlés!</h3>";
			echo "<script>
					function atiranyit()
					{
						location.href = 'index.php?lng=hun&page=shop&kategoriak=y';
					}
					ID = window.setTimeout('atiranyit();', 1*300);
				</script>";
		}
		else
		{
			echo "<h3 style='color:#FF0000;'>Sajnos nem sikerült a kategória törlése!</h3>";
			echo "<script>
					function atiranyit()
					{
						location.href = 'index.php?lng=hun&page=shop&kategoriak=y';
					}
					ID = window.setTimeout('atiranyit();', 1*300);
				</script>";
		}
	}
	//gyártó törlése
	elseif(isset($_GET["gyartotorol"]))
	{
		$torles=$pdo->query("delete from ".$elotag."_shop_gyartok where shop_gyartoid=".$_GET["gyartotorol"]);
		if($torles)
		{
			echo "<h3 style='color:#00FF00;'>Sikeres gyártótörlés!</h3>";
			echo "<script>
					function atiranyit()
					{
						location.href = 'index.php?lng=hun&page=shop&gyartok=y';
					}
					ID = window.setTimeout('atiranyit();', 1*300);
				</script>";
		}
		else
		{
			echo "<h3 style='color:#FF0000;'>Sajnos nem sikerült a gyártó törlése!</h3>";
			echo "<script>
					function atiranyit()
					{
						location.href = 'index.php?lng=hun&page=shop&gyartok=y';
					}
					ID = window.setTimeout('atiranyit();', 1*300);
				</script>";
		}
	}
	//ügyfél törlése
	elseif(isset($_GET["uftorol"]))
	{
		$torles=$pdo->query("delete from ".$elotag."_shop_vasarlok where vkod=".$_GET["uftorol"]);
		if($torles)
		{
			echo "<h3 style='color:#00FF00;'>Sikeres ügyfél törlés!</h3>";
			echo "<script>
					function atiranyit()
					{
						location.href = 'index.php?lng=hun&page=shop&ugyfelek=y';
					}
					ID = window.setTimeout('atiranyit();', 1*300);
				</script>";
		}
		else
		{
			echo "<h3 style='color:#FF0000;'>Sajnos nem sikerült a gyártó törlése!</h3>";
			echo "<script>
					function atiranyit()
					{
						location.href = 'index.php?lng=hun&page=shop&ugyfelek=y';
					}
					ID = window.setTimeout('atiranyit();', 1*300);
				</script>";
		}
	}
	//megrendelés törlése
	elseif(isset($_GET["rendtorol"]))
	{
		$torles=$pdo->query("delete from ".$elotag."_shop_rendelesek where m_id=".$_GET["rendtorol"]);
		if($torles)
		{
			echo "<h3 style='color:#00FF00;'>Sikeres adattörlés!</h3>";
			echo "<script>
					function atiranyit()
					{
						location.href = 'index.php?lng=hun&page=shop&rendelesek=y';
					}
					ID = window.setTimeout('atiranyit();', 1*300);
				</script>";
		}
		else
		{
			echo "<h3 style='color:#FF0000;'>Sajnos nem sikerült a megrendelési adat törlése!</h3>";
			echo "<script>
					function atiranyit()
					{
						location.href = 'index.php?lng=hun&page=shop&rendelesek=y';
					}
					ID = window.setTimeout('atiranyit();', 1*300);
				</script>";
		}
	}
/*** ADATFELVÉTELEK VÉGREHAJTÁSA ***/
	//ügyfél aktiválása
	elseif(isset($_GET["ufakt"]))
	{
		$aktival=$pdo->query("update ".$elotag."_shop_vasarlok set vaktiv='igen' where vkod='".$_GET["ufakt"]."'");
		if($aktival)
		{
			$hovamegy=$pdo->query("select * from ".$elotag."_shop_vasarlok where vkod='".$_GET["ufakt"]."'");
			$idemegy=$hovamegy->fetch();
			echo "<h3 style='color:#00FF00;'>Sikeres aktiválás!</h3>";
				$reggelonek=$idemegy["vmail"];
				$targy2="Vásárlói regisztráció aktiválás";
				$headers  = "MIME-Version: 1.0" . "\r\n";    
				$headers .= "Content-type:text/html;charset=iso-8859-2" . "\r\n";   
				$headers .= "From: <webshop@turanium.com>" . "\r\n";    
				$ido = ("Küldve: ".date("Y.m.d. H:i:s", time())."\r\n\r\n");
				mail ($reggelonek, $targy2, "<font face='verdana' size='2' color='#00AEEF'><b>Welcome!</b><br /><br />Thank you for registration at the www.turanium.com . Your account has been accepted and activated.<br /><br /><b>Your Login datas:</b><br />Name: ".$idemegy["vnev"]."<br />E-mail: ".$idemegy["vmail"]."<br />Phone number: ".$idemegy["vtelefon"]."<br />Address: ".$idemegy["vlakcim"]."<br /><br />" .$ido. "</font><br />",$headers);
			echo "<script>
					function atiranyit()
					{
						location.href = 'index.php?lng=hun&page=shop&ugyfelek=y';
					}
					ID = window.setTimeout('atiranyit();', 1*300);
				</script>";
		}
		else
		{
			echo "<h3 style='color:#FF0000;'>Sajnos nem sikerült az aktiválás - SQL hiba!</h3>";
			echo "<script>
					function atiranyit()
					{
						location.href = 'index.php?lng=hun&page=shop&ugyfelek=y';
					}
					ID = window.setTimeout('atiranyit();', 1*500);
				</script>";
		}
	}
	//termék hozzáadása végrehajtása
	elseif(isset($_POST["ujtermek"]))
	{
		$datummost=getDate();
		$datekeszit=mktime($datummost["hours"],$datummost["minutes"],$datummost["seconds"],$datummost["mon"],$datummost["mday"],$datummost["year"]);
		$dazo=date("Ymdhms",$datekeszit);
		
		//főkép, mert kötelező!
		$SafeFile=$_FILES["t_fkep"]["name"];
		$SafeFile = strtolower($SafeFile);
		$SafeFile = str_replace($mirol, $mire, $SafeFile);
		
		$fajlnev="../shop/".$dazo."_".$SafeFile;
		$fokep=$dazo."_".$SafeFile;
		
		//termék PDF, ha van!
		if(isset($_POST["pdfis"]) AND $_POST["pdfis"]=="yes")
		{
			$SafePDF=$_FILES["t_pdf"]["name"];
			$SafePDF = strtolower($SafePDF);
			$SafePDF = str_replace($mirol, $mire, $SafePDF);;
			
			//időbélyeg készítée
			$datummost=getDate();
			$datekeszit=mktime($datummost["hours"],$datummost["minutes"],$datummost["seconds"],$datummost["mon"],$datummost["mday"],$datummost["year"]);
			$dazo=date("Ymdhms",$datekeszit);
			
			$pdfnev="../shop/".$dazo."_".$SafePDF;
			$pdfdok=$dazo."_".$SafePDF;
			
			if(move_uploaded_file($_FILES["t_fkep"]["tmp_name"],$fajlnev) AND move_uploaded_file($_FILES["t_pdf"]["tmp_name"],$pdfnev))
			{
				$termekment=$pdo->query("insert into ".$elotag."_shop_termek (t_gyarto,t_nev,t_ar,t_kategoria,t_fkep,t_kleiras,t_nleiras,t_datum,t_pdf) values('".$_POST["t_gyarto"]."','".$_POST["t_nev"]."','".$_POST["t_ar"]."','".$_POST["t_kategoria"]."','".$fokep."','".$_POST["t_kleiras"]."','".$_POST["t_nleiras"]."',now(),'".$pdfdok."')");
				if($termekment)
				{
					echo "<h3 style='color:#00FF00;'>Sikeres termékfelvétel!</h3>";
				}
				else
				{
					echo "<h3 style='color:#FF0000;'>Sajnos nem sikerült a termék mentése - SQL Hiba történt!</h3>";
					echo "<a href='javascript:history.go(-1)'>próbálja újra a hiba kijavításával... &raquo;</a>";
				}
			}
			else
			{
				echo "<h3 style='color:#FF0000;'>Sajnos nem sikerült a kép feltöltése!</h3>";
				echo "<a href='javascript:history.go(-1)'>próbálja újra a hiba kijavításával... &raquo;</a>";
			}
		}
		else
		{
			if(move_uploaded_file($_FILES["t_fkep"]["tmp_name"],$fajlnev))
			{
				$termekment=$pdo->query("insert into ".$elotag."_shop_termek (t_gyarto,t_nev,t_ar,t_kategoria,t_fkep,t_kleiras,t_nleiras,t_datum) values('".$_POST["t_gyarto"]."','".$_POST["t_nev"]."','".$_POST["t_ar"]."','".$_POST["t_kategoria"]."','".$fokep."','".$_POST["t_kleiras"]."','".$_POST["t_nleiras"]."',now())");
				if($termekment)
				{
					echo "<h3 style='color:#00FF00;'>Sikeres termékfelvétel!</h3><a href='index.php?lng=hun&page=shop&ujtermek=y'><b>ISMÉT ÚJ TERMÉK FELVÉTELE &raquo;</b></a>";
				}
				else
				{
					echo "<h3 style='color:#FF0000;'>Sajnos nem sikerült a termék mentése - SQL Hiba történt!</h3>";
					echo "<a href='javascript:history.go(-1)'>próbálja újra a hiba kijavításával... &raquo;</a>";
				}
			}
			else
			{
				echo "<h3 style='color:#FF0000;'>Sajnos nem sikerült a kép feltöltése!</h3>";
				echo "<a href='javascript:history.go(-1)'>próbálja újra a hiba kijavításával... &raquo;</a>";
			}
		}
	}
	//gyártó hozzáadása végrehajtása
	elseif(isset($_POST["ujgyarto"]))
	{
		$gyartoment=$pdo->query("insert into ".$elotag."_shop_gyartok (shop_gyartonev) values('".$_POST["shop_gyartonev"]."')");
		if($gyartoment)
		{
			echo "<h3 style='color:#00FF00;'>Sikeres gyártó felvétel!</h3>";
			echo "<script>
					function atiranyit()
					{
						location.href = 'index.php?lng=hun&page=shop&gyartok=y';
					}
					ID = window.setTimeout('atiranyit();', 1*100);
				</script>";
		}
		else
		{
			echo "<h3 style='color:#FF0000;'>Sajnos nem sikerült a gyártó mentése!</h3>";
			echo "<script>
					function atiranyit()
					{
						location.href = 'index.php?lng=hun&page=shop&gyartok=y';
					}
					ID = window.setTimeout('atiranyit();', 1*100);
				</script>";
		}
	}
	//kategória hozzáadása végrehajtása
	elseif(isset($_POST["ujkategoria"]))
	{
		$SafeFile4=$_FILES["shop_kategkep"]["name"];
		$SafeFile4 = strtolower($SafeFile4);
		$SafeFile4 = str_replace("#", "_", $SafeFile4); 
		$SafeFile4 = str_replace("$", "_", $SafeFile4); 
		$SafeFile4 = str_replace("%", "_", $SafeFile4); 
		$SafeFile4 = str_replace("'", "_", $SafeFile4); 
		$SafeFile4 = str_replace(",", "_", $SafeFile4); 
		$SafeFile4 = str_replace("&", "_", $SafeFile4); 
		$SafeFile4 = str_replace("*", "_", $SafeFile4); 
		$SafeFile4 = str_replace("+", "_", $SafeFile4); 
		$SafeFile4 = str_replace("!", "_", $SafeFile4); 
		$SafeFile4 = str_replace("?", "_", $SafeFile4);
		$SafeFile4 = str_replace("=", "_", $SafeFile4);
		$SafeFile4 = str_replace("/", "_", $SafeFile4); 
		$SafeFile4 = str_replace("§", "_", $SafeFile4); 
		$SafeFile4 = str_replace("(", "_", $SafeFile4); 
		$SafeFile4 = str_replace(")", "_", $SafeFile4); 
		$SafeFile4 = str_replace("ö", "o", $SafeFile4);
		$SafeFile4 = str_replace("ő", "o", $SafeFile4);
		$SafeFile4 = str_replace("ó", "o", $SafeFile4);
		$SafeFile4 = str_replace("ü", "u", $SafeFile4);
		$SafeFile4 = str_replace("ű", "u", $SafeFile4);
		$SafeFile4 = str_replace("ú", "u", $SafeFile4);
		$SafeFile4 = str_replace("é", "e", $SafeFile4);
		$SafeFile4 = str_replace("á", "a", $SafeFile4);
		$SafeFile4 = str_replace("í", "i", $SafeFile4);
		$SafeFile4 = str_replace("ö", "o", $SafeFile4);
		$SafeFile4 = str_replace("Ö", "o", $SafeFile4);
		$SafeFile4 = str_replace("Ő", "o", $SafeFile4);
		$SafeFile4 = str_replace("Ó", "o", $SafeFile4);
		$SafeFile4 = str_replace("Ü", "u", $SafeFile4);
		$SafeFile4 = str_replace("Ű", "u", $SafeFile4);
		$SafeFile4 = str_replace("Ú", "u", $SafeFile4);
		$SafeFile4 = str_replace("É", "e", $SafeFile4);
		$SafeFile4 = str_replace("Á", "a", $SafeFile4);
		$SafeFile4 = str_replace("Í", "i", $SafeFile4);
		$SafeFile4 = str_replace(" ", "_", $SafeFile4);
		
		$datummost1=getDate();
		$datekeszit1=mktime($datummost1["hours"],$datummost1["minutes"],$datummost1["seconds"],$datummost1["mon"],$datummost1["mday"],$datummost1["year"]);
		$dazo2=date("Ymdhms",$datekeszit1);
		
		$fajlnev4="../shop/kateg/".$dazo2."_".$SafeFile4;
		$kategkep=$dazo2."_".$SafeFile4;
		
		if(move_uploaded_file($_FILES["shop_kategkep"]["tmp_name"],$fajlnev4))
		{
			$kategoriament=$pdo->query("insert into ".$elotag."_shop_kategoriak(shop_kategkep,shop_kategorianev) values('".$kategkep."','".$_POST["shop_kategorianev"]."')");
			if($kategoriament)
			{
				echo "<h3 style='color:#00FF00;'>Sikeres kategória felvétel!</h3>";
				echo "<script>
						function atiranyit()
						{
							location.href = 'index.php?lng=hun&page=shop&kategoriak=y';
						}
						ID = window.setTimeout('atiranyit();', 1*300);
					</script>";
			}
			else
			{
				echo "<h3 style='color:#FF0000;'>Sajnos nem sikerült a kategória mentése!</h3>";
				echo "<script>
						function atiranyit()
						{
							location.href = 'index.php?lng=hun&page=shop&kategoriak=y';
						}
						ID = window.setTimeout('atiranyit();', 1*300);
					</script>";
			}
		}
		else
		{
			$kategoriament=$pdo->query("insert into ".$elotag."_shop_kategoriak (shop_kategkep,shop_kategorianev) values('nincskep.png','".$_POST["shop_kategorianev"]."')");
			if($kategoriament)
			{
				echo "<h3 style='color:#00FF00;'>Sikeres kategória felvétel!</h3>";
				echo "<script>
						function atiranyit()
						{
							location.href = 'index.php?lng=hun&page=shop&kategoriak=y';
						}
						ID = window.setTimeout('atiranyit();', 1*300);
					</script>";
			}
			else
			{
				echo "<h3 style='color:#FF0000;'>Sajnos nem sikerült a kategória mentése!</h3>";
				echo "<script>
						function atiranyit()
						{
							location.href = 'index.php?lng=hun&page=shop&kategoriak=y';
						}
						ID = window.setTimeout('atiranyit();', 1*300);
					</script>";
			}
		}
	}
/*** ADAT SZERKESZTÉSEK VÉGREHAJTÁSAI ***/
	elseif(isset($_POST["gyartomod"]))
	{
		$gyartofrissit=$pdo->query("update ".$elotag."_shop_gyartok set shop_gyartonev='".$_POST["shop_gyartonev"]."' where shop_gyartoid='".$_POST["gyartomod"]."'");
		if($gyartofrissit)
		{
			echo "<h3 style='color:#00FF00;'>Sikeres gyártó frissítés!</h3>";
			echo "<script>
					function atiranyit()
					{
						location.href = 'index.php?lng=hun&page=shop&gyartok=y';
					}
					ID = window.setTimeout('atiranyit();', 1*100);
				</script>";
		}
		else
		{
			echo "<h3 style='color:#FF0000;'>Sajnos nem sikerült a gyártó frissítése!</h3>";
			echo "<script>
					function atiranyit()
					{
						location.href = 'index.php?lng=hun&page=shop&gyartok=y';
					}
					ID = window.setTimeout('atiranyit();', 1*100);
				</script>";
		}
	}
	elseif(isset($_POST["kategoriamod"]))
	{
		$SafeFile4=$_FILES["shop_kategkep"]["name"];
		$SafeFile4 = strtolower($SafeFile4);
		$SafeFile4 = str_replace("#", "_", $SafeFile4); 
		$SafeFile4 = str_replace("$", "_", $SafeFile4); 
		$SafeFile4 = str_replace("%", "_", $SafeFile4); 
		$SafeFile4 = str_replace("'", "_", $SafeFile4); 
		$SafeFile4 = str_replace(",", "_", $SafeFile4); 
		$SafeFile4 = str_replace("&", "_", $SafeFile4); 
		$SafeFile4 = str_replace("*", "_", $SafeFile4); 
		$SafeFile4 = str_replace("+", "_", $SafeFile4); 
		$SafeFile4 = str_replace("!", "_", $SafeFile4); 
		$SafeFile4 = str_replace("?", "_", $SafeFile4);
		$SafeFile4 = str_replace("=", "_", $SafeFile4);
		$SafeFile4 = str_replace("/", "_", $SafeFile4); 
		$SafeFile4 = str_replace("§", "_", $SafeFile4); 
		$SafeFile4 = str_replace("(", "_", $SafeFile4); 
		$SafeFile4 = str_replace(")", "_", $SafeFile4); 
		$SafeFile4 = str_replace("ö", "o", $SafeFile4);
		$SafeFile4 = str_replace("ő", "o", $SafeFile4);
		$SafeFile4 = str_replace("ó", "o", $SafeFile4);
		$SafeFile4 = str_replace("ü", "u", $SafeFile4);
		$SafeFile4 = str_replace("ű", "u", $SafeFile4);
		$SafeFile4 = str_replace("ú", "u", $SafeFile4);
		$SafeFile4 = str_replace("é", "e", $SafeFile4);
		$SafeFile4 = str_replace("á", "a", $SafeFile4);
		$SafeFile4 = str_replace("í", "i", $SafeFile4);
		$SafeFile4 = str_replace("ö", "o", $SafeFile4);
		$SafeFile4 = str_replace("Ö", "o", $SafeFile4);
		$SafeFile4 = str_replace("Ő", "o", $SafeFile4);
		$SafeFile4 = str_replace("Ó", "o", $SafeFile4);
		$SafeFile4 = str_replace("Ü", "u", $SafeFile4);
		$SafeFile4 = str_replace("Ű", "u", $SafeFile4);
		$SafeFile4 = str_replace("Ú", "u", $SafeFile4);
		$SafeFile4 = str_replace("É", "e", $SafeFile4);
		$SafeFile4 = str_replace("Á", "a", $SafeFile4);
		$SafeFile4 = str_replace("Í", "i", $SafeFile4);
		$SafeFile4 = str_replace(" ", "_", $SafeFile4);
		
		$datummost1=getDate();
		$datekeszit1=mktime($datummost1["hours"],$datummost1["minutes"],$datummost1["seconds"],$datummost1["mon"],$datummost1["mday"],$datummost1["year"]);
		$dazo2=date("Ymdhms",$datekeszit1);
		
		$fajlnev4="../shop/kateg/".$dazo2."_".$SafeFile4;
		$kategkep=$dazo2."_".$SafeFile4;
		
		if(move_uploaded_file($_FILES["shop_kategkep"]["tmp_name"],$fajlnev4))
		{
			$kategoriafrissit=$pdo->query("update ".$elotag."_shop_kategoriak set shop_kategkep='".$kategkep."',shop_kategorianev='".$_POST["shop_kategorianev"]."' where shop_kategoriaid='".$_POST["kategoriamod"]."'");
			if($kategoriafrissit)
			{
				echo "<h3 style='color:#00FF00;'>Sikeres kategória frissítés!</h3>";
				echo "<script>
						function atiranyit()
						{
							location.href = 'index.php?lng=hun&page=shop&kategoriak=y';
						}
						ID = window.setTimeout('atiranyit();', 1*300);
					</script>";
			}
			else
			{
				echo "<h3 style='color:#FF0000;'>Sajnos nem sikerült a kategória frissítése!</h3>";
				echo "<script>
						function atiranyit()
						{
							location.href = 'index.php?lng=hun&page=shop&kategoriak=y';
						}
						ID = window.setTimeout('atiranyit();', 1*300);
					</script>";
			}
		}
		else
		{
			$kategoriafrissit=$pdo->query("update ".$elotag."_shop_kategoriak set shop_kategorianev='".$_POST["shop_kategorianev"]."' where shop_kategoriaid='".$_POST["kategoriamod"]."'");
			if($kategoriafrissit)
			{
				echo "<h3 style='color:#00FF00;'>Sikeres kategória frissítés!</h3>";
				echo "<script>
						function atiranyit()
						{
							location.href = 'index.php?lng=hun&page=shop&kategoriak=y';
						}
						ID = window.setTimeout('atiranyit();', 1*300);
					</script>";
			}
			else
			{
				echo "<h3 style='color:#FF0000;'>Sajnos nem sikerült a kategória frissítése!</h3>";
				echo "<script>
						function atiranyit()
						{
							location.href = 'index.php?lng=hun&page=shop&kategoriak=y';
						}
						ID = window.setTimeout('atiranyit();', 1*300);
					</script>";
			}
		}
	}
	elseif(isset($_POST["termekmod"]))
	{
		if(isset($_POST["pdfis"]) AND $_POST["pdfis"]=="yes")
		{
			$SafePDF=$_FILES["t_pdf"]["name"];
			$SafePDF = strtolower($SafePDF);
			$SafePDF = str_replace("#", "_", $SafePDF); 
			$SafePDF = str_replace("$", "_", $SafePDF); 
			$SafePDF = str_replace("%", "_", $SafePDF); 
			$SafePDF = str_replace("'", "_", $SafePDF); 
			$SafePDF = str_replace(",", "_", $SafePDF); 
			$SafePDF = str_replace("&", "_", $SafePDF); 
			$SafePDF = str_replace("*", "_", $SafePDF); 
			$SafePDF = str_replace("+", "_", $SafePDF); 
			$SafePDF = str_replace("!", "_", $SafePDF); 
			$SafePDF = str_replace("?", "_", $SafePDF);
			$SafePDF = str_replace("=", "_", $SafePDF);
			$SafePDF = str_replace("/", "_", $SafePDF); 
			$SafePDF = str_replace("§", "_", $SafePDF); 
			$SafePDF = str_replace("(", "_", $SafePDF); 
			$SafePDF = str_replace(")", "_", $SafePDF); 
			$SafePDF = str_replace("ö", "o", $SafePDF);
			$SafePDF = str_replace("ő", "o", $SafePDF);
			$SafePDF = str_replace("ó", "o", $SafePDF);
			$SafePDF = str_replace("ü", "u", $SafePDF);
			$SafePDF = str_replace("ű", "u", $SafePDF);
			$SafePDF = str_replace("ú", "u", $SafePDF);
			$SafePDF = str_replace("é", "e", $SafePDF);
			$SafePDF = str_replace("á", "a", $SafePDF);
			$SafePDF = str_replace("í", "i", $SafePDF);
			$SafePDF = str_replace("ö", "o", $SafePDF);
			$SafePDF = str_replace("Ö", "o", $SafePDF);
			$SafePDF = str_replace("Ő", "o", $SafePDF);
			$SafePDF = str_replace("Ó", "o", $SafePDF);
			$SafePDF = str_replace("Ü", "u", $SafePDF);
			$SafePDF = str_replace("Ű", "u", $SafePDF);
			$SafePDF = str_replace("Ú", "u", $SafePDF);
			$SafePDF = str_replace("É", "e", $SafePDF);
			$SafePDF = str_replace("Á", "a", $SafePDF);
			$SafePDF = str_replace("Í", "i", $SafePDF);
			$SafePDF = str_replace(" ", "_", $SafePDF);
			
			//időbélyeg készítée
			$datummost=getDate();
			$datekeszit=mktime($datummost["hours"],$datummost["minutes"],$datummost["seconds"],$datummost["mon"],$datummost["mday"],$datummost["year"]);
			$dazo=date("Ymdhms",$datekeszit);
			
			$pdfnev="../shop/".$dazo."_".$SafePDF;
			$pdfdok=$dazo."_".$SafePDF;
			
			if(move_uploaded_file($_FILES["t_pdf"]["tmp_name"],$pdfnev))
			{
				$termekfrissitpdf=$pdo->query("update ".$elotag."_shop_termek set t_pdf='".$pdfdok."' where t_id='".$_POST["termekmod"]."'");
				if($termekfrissitpdf)
				{
					echo "<h3 style='color:#00FF00;'>Sikeres PDF feltöltés!</h3>";
				}
				else
				{
					echo "<h3 style='color:#FF0000;'>Sajnos nem sikerült a PDF mentése - SQL Hiba történt!</h3>";
				}
			}
			else
			{
				echo "<h3 style='color:#FF0000;'>Sajnos nem sikerült a PDF feltöltése!</h3>";
			}
		}
		if(isset($_POST["tobbkepetis"]) AND $_POST["tobbkepetis"]=="yes" AND isset($_POST["fkepetis"]) AND $_POST["fkepetis"]=="yes")
		{
			$sikeres=0; // sikeresen feltöltött és mentett fájl
			$hibaszoveg=""; //hibák szövege
			$osszesfajl=""; //összes feltölteni kivánt fájl
			$vanfokep="nincs"; //főkép alapértelmezetten: nincs!
			
			//további képek feltöltögetése
			for ($i = 0; $i < count($_FILES['t_kepek']['name']); $i++)
			{
				$SafeFile = $_FILES['t_kepek']['name'][$i];
				$SafeFile = strtolower($SafeFile);
				$SafeFile = str_replace("#", "_", $SafeFile);
				$SafeFile = str_replace("$", "_", $SafeFile);
				$SafeFile = str_replace("%", "_", $SafeFile);
				$SafeFile = str_replace("'", "_", $SafeFile);
				$SafeFile = str_replace(",", "_", $SafeFile);
				$SafeFile = str_replace("&", "_", $SafeFile);
				$SafeFile = str_replace("*", "_", $SafeFile);
				$SafeFile = str_replace("+", "_", $SafeFile);
				$SafeFile = str_replace("!", "_", $SafeFile);
				$SafeFile = str_replace("?", "_", $SafeFile);
				$SafeFile = str_replace("=", "_", $SafeFile);
				$SafeFile = str_replace("/", "_", $SafeFile);
				$SafeFile = str_replace("§", "_", $SafeFile);
				$SafeFile = str_replace("(", "_", $SafeFile);
				$SafeFile = str_replace(")", "_", $SafeFile);
				$SafeFile = str_replace("ö", "o", $SafeFile);
				$SafeFile = str_replace("ő", "o", $SafeFile);
				$SafeFile = str_replace("ó", "o", $SafeFile);
				$SafeFile = str_replace("ü", "u", $SafeFile);
				$SafeFile = str_replace("ű", "u", $SafeFile);
				$SafeFile = str_replace("ú", "u", $SafeFile);
				$SafeFile = str_replace("é", "e", $SafeFile);
				$SafeFile = str_replace("á", "a", $SafeFile);
				$SafeFile = str_replace("í", "i", $SafeFile);
				$SafeFile = str_replace("Ö", "o", $SafeFile);
				$SafeFile = str_replace("Ő", "o", $SafeFile);
				$SafeFile = str_replace("Ó", "o", $SafeFile);
				$SafeFile = str_replace("Ü", "u", $SafeFile);
				$SafeFile = str_replace("Ű", "u", $SafeFile);
				$SafeFile = str_replace("Ú", "u", $SafeFile);
				$SafeFile = str_replace("É", "e", $SafeFile);
				$SafeFile = str_replace("Á", "a", $SafeFile);
				$SafeFile = str_replace("Í", "i", $SafeFile);
				$SafeFile = str_replace(" ", "_", $SafeFile);

				$ext = strtolower(substr(strrchr($SafeFile, "."), 1));
				
				if($ext == "jpg" || $ext == "gif" || $ext == "bmp" || $ext == "png")
				{
					//időbélyeg készítée
					$datummost=getDate();
					$datekeszit=mktime($datummost["hours"],$datummost["minutes"],$datummost["seconds"],$datummost["mon"],$datummost["mday"],$datummost["year"]);
					$dazo=date("Ymdhms",$datekeszit);

					$fajlnev="../shop/kepek/".$dazo."_".$SafeFile;
					
					//fájlfeltöltés végrehajtása
					if(move_uploaded_file($_FILES['t_kepek']['tmp_name'][$i],$fajlnev))
					{
						$osszesfajl=$osszesfajl."|".$fajlnev;
						$sikeres++;
					}
					else
					{
						$hibaszoveg=$hibaszoveg."Feltöltési hiba történt: ".$fajlnev."&nbsp;<br />";
					}
				}
				else
				{
					$hibaszoveg=$hibaszoveg."Fájlformátum hiba történt: ".$fajlnev."&nbsp;<br />";
				}
			}
			//főkép feltöltése
			if(count($_FILES['t_fkep']))
			{
				$SafeFile2=$_FILES["t_fkep"]["name"];
				$SafeFile2 = strtolower($SafeFile2);
				$SafeFile2 = str_replace("#", "_", $SafeFile2); 
				$SafeFile2 = str_replace("$", "_", $SafeFile2); 
				$SafeFile2 = str_replace("%", "_", $SafeFile2); 
				$SafeFile2 = str_replace("'", "_", $SafeFile2); 
				$SafeFile2 = str_replace(",", "_", $SafeFile2); 
				$SafeFile2 = str_replace("&", "_", $SafeFile2); 
				$SafeFile2 = str_replace("*", "_", $SafeFile2); 
				$SafeFile2 = str_replace("+", "_", $SafeFile2); 
				$SafeFile2 = str_replace("!", "_", $SafeFile2); 
				$SafeFile2 = str_replace("?", "_", $SafeFile2);
				$SafeFile2 = str_replace("=", "_", $SafeFile2);
				$SafeFile2 = str_replace("/", "_", $SafeFile2); 
				$SafeFile2 = str_replace("§", "_", $SafeFile2); 
				$SafeFile2 = str_replace("(", "_", $SafeFile2); 
				$SafeFile2 = str_replace(")", "_", $SafeFile2); 
				$SafeFile2 = str_replace("ö", "o", $SafeFile2);
				$SafeFile2 = str_replace("ő", "o", $SafeFile2);
				$SafeFile2 = str_replace("ó", "o", $SafeFile2);
				$SafeFile2 = str_replace("ü", "u", $SafeFile2);
				$SafeFile2 = str_replace("ű", "u", $SafeFile2);
				$SafeFile2 = str_replace("ú", "u", $SafeFile2);
				$SafeFile2 = str_replace("é", "e", $SafeFile2);
				$SafeFile2 = str_replace("á", "a", $SafeFile2);
				$SafeFile2 = str_replace("í", "i", $SafeFile2);
				$SafeFile2 = str_replace("ö", "o", $SafeFile2);
				$SafeFile2 = str_replace("Ö", "o", $SafeFile2);
				$SafeFile2 = str_replace("Ő", "o", $SafeFile2);
				$SafeFile2 = str_replace("Ó", "o", $SafeFile2);
				$SafeFile2 = str_replace("Ü", "u", $SafeFile2);
				$SafeFile2 = str_replace("Ű", "u", $SafeFile2);
				$SafeFile2 = str_replace("Ú", "u", $SafeFile2);
				$SafeFile2 = str_replace("É", "e", $SafeFile2);
				$SafeFile2 = str_replace("Á", "a", $SafeFile2);
				$SafeFile2 = str_replace("Í", "i", $SafeFile2);
				$SafeFile2 = str_replace(" ", "_", $SafeFile2);
				
				$ext2 = strtolower(substr(strrchr($SafeFile2, "."), 1));
				
				if($ext2 == "jpg" || $ext2 == "gif" || $ext2 == "bmp" || $ext2 == "png")
				{
					$datummost1=getDate();
					$datekeszit1=mktime($datummost1["hours"],$datummost1["minutes"],$datummost1["seconds"],$datummost1["mon"],$datummost1["mday"],$datummost1["year"]);
					$dazo2=date("Ymdhms",$datekeszit1);
					
					$fajlnev2="../shop/".$dazo2."_".$SafeFile2;
					$fokep=$dazo2."_".$SafeFile2;
					
					if(move_uploaded_file($_FILES["t_fkep"]["tmp_name"],$fajlnev2))
					{
						$vanfokep="van";
					}
					else
					{
						$vanfokep="nincs";
					}
				}
			}
			if($sikeres>=1 AND $vanfokep=="van")
			{
				$termekfrissit=$pdo->query("update ".$elotag."_shop_termek set t_gyarto='".$_POST["t_gyarto"]."',t_nev='".$_POST["t_nev"]."',t_kategoria='".$_POST["t_kategoria"]."',t_fkep='".$fokep."',t_kepek='".$osszesfajl."',t_ar='".$_POST["t_ar"]."',t_kleiras='".$_POST["t_kleiras"]."',t_nleiras='".$_POST["t_nleiras"]."' where t_id='".$_POST["termekmod"]."'");
				
				if($termekfrissit)
				{
					echo "<h3 style='color:#00FF00;'>Sikeres termék frissítés!</h3>";
					echo "<script>
					function atiranyit()
					{
						location.href = 'index.php?lng=hun&page=shop';
					}
					ID = window.setTimeout('atiranyit();', 1*100);
				</script>";
					
				}
				else
				{
					echo "<h3 style='color:#FF0000;'>Sajnos nem sikerült a termék frissítése!</h3>";
					$hibaszoveg=$hibaszoveg."SQL Hiba történt - főkép felöltést IGEN kért.<br />";
					echo "<script>
								function atiranyit()
								{
									location.href = 'index.php?lng=hun&page=shop';
								}
								ID = window.setTimeout('atiranyit();', 1*200);
							</script>";
				}
			}
			elseif($sikeres>=1 AND $vanfokep=="nincs")
			{
				$termekfrissit=$pdo->query("update ".$elotag."_shop_termek set t_gyarto='".$_POST["t_gyarto"]."',t_nev='".$_POST["t_nev"]."',t_kategoria='".$_POST["t_kategoria"]."',t_kepek='".$osszesfajl."',t_ar='".$_POST["t_ar"]."',t_kleiras='".$_POST["t_kleiras"]."',t_nleiras='".$_POST["t_nleiras"]."' where t_id='".$_POST["termekmod"]."'");
				
				if($termekfrissit)
				{
					echo "<h3 style='color:#00FF00;'>Sikeres termék frissítés!</h3>";
					echo "<script>
					function atiranyit()
					{
						location.href = 'index.php?lng=hun&page=shop';
					}
					ID = window.setTimeout('atiranyit();', 1*100);
				</script>";
				}
				else
				{
					echo "<h3 style='color:#FF0000;'>Sajnos nem sikerült a termék frissítése!</h3>";
					$hibaszoveg=$hibaszoveg."SQL Hiba történt - főkép felöltést NEM kért.<br />";
					echo "<script>
					function atiranyit()
					{
						location.href = 'index.php?lng=hun&page=shop';
					}
					ID = window.setTimeout('atiranyit();', 1*100);
				</script>";
				}
			}
			else
			{
				echo "<h3 style='color:#FF0000;'>Sajnos nem sikerült a termék frissítése (SQL HIBA)!</h3><br /><b>HIBÁK:</b><br />".$hibaszoveg."";
				echo "<script>
					function atiranyit()
					{
						location.href = 'index.php?lng=hun&page=shop';
					}
					ID = window.setTimeout('atiranyit();', 1*100);
				</script>";
			}
		}
		elseif(isset($_POST["tobbkepetis"]) AND $_POST["tobbkepetis"]=="yes" AND !isset($_POST["fkepetis"]) AND $_POST["fkepetis"]!="yes")
		{
			$sikeres=0; // sikeresen feltöltött és mentett fájl
			$hibaszoveg=""; //hibák szövege
			$osszesfajl=""; //összes feltölteni kivánt fájl
			$vanfokep="nincs"; //főkép alapértelmezetten: nincs!
			
			//további képek feltöltögetése
			for ($i = 0; $i < count($_FILES['t_kepek']['name']); $i++)
			{
				$SafeFile = $_FILES['t_kepek']['name'][$i];
				$SafeFile = strtolower($SafeFile);
				$SafeFile = str_replace("#", "_", $SafeFile);
				$SafeFile = str_replace("$", "_", $SafeFile);
				$SafeFile = str_replace("%", "_", $SafeFile);
				$SafeFile = str_replace("'", "_", $SafeFile);
				$SafeFile = str_replace(",", "_", $SafeFile);
				$SafeFile = str_replace("&", "_", $SafeFile);
				$SafeFile = str_replace("*", "_", $SafeFile);
				$SafeFile = str_replace("+", "_", $SafeFile);
				$SafeFile = str_replace("!", "_", $SafeFile);
				$SafeFile = str_replace("?", "_", $SafeFile);
				$SafeFile = str_replace("=", "_", $SafeFile);
				$SafeFile = str_replace("/", "_", $SafeFile);
				$SafeFile = str_replace("§", "_", $SafeFile);
				$SafeFile = str_replace("(", "_", $SafeFile);
				$SafeFile = str_replace(")", "_", $SafeFile);
				$SafeFile = str_replace("ö", "o", $SafeFile);
				$SafeFile = str_replace("ő", "o", $SafeFile);
				$SafeFile = str_replace("ó", "o", $SafeFile);
				$SafeFile = str_replace("ü", "u", $SafeFile);
				$SafeFile = str_replace("ű", "u", $SafeFile);
				$SafeFile = str_replace("ú", "u", $SafeFile);
				$SafeFile = str_replace("é", "e", $SafeFile);
				$SafeFile = str_replace("á", "a", $SafeFile);
				$SafeFile = str_replace("í", "i", $SafeFile);
				$SafeFile = str_replace("Ö", "o", $SafeFile);
				$SafeFile = str_replace("Ő", "o", $SafeFile);
				$SafeFile = str_replace("Ó", "o", $SafeFile);
				$SafeFile = str_replace("Ü", "u", $SafeFile);
				$SafeFile = str_replace("Ű", "u", $SafeFile);
				$SafeFile = str_replace("Ú", "u", $SafeFile);
				$SafeFile = str_replace("É", "e", $SafeFile);
				$SafeFile = str_replace("Á", "a", $SafeFile);
				$SafeFile = str_replace("Í", "i", $SafeFile);
				$SafeFile = str_replace(" ", "_", $SafeFile);

				$ext = strtolower(substr(strrchr($SafeFile, "."), 1));
				
				if($ext == "jpg" || $ext == "gif" || $ext == "bmp" || $ext == "png")
				{
					//időbélyeg készítée
					$datummost=getDate();
					$datekeszit=mktime($datummost["hours"],$datummost["minutes"],$datummost["seconds"],$datummost["mon"],$datummost["mday"],$datummost["year"]);
					$dazo=date("Ymdhms",$datekeszit);

					$fajlut="../shop/kepek/".$dazo."_".$SafeFile;
					$fajlnev=$dazo."_".$SafeFile;
					
					//fájlfeltöltés végrehajtása
					if(move_uploaded_file($_FILES['t_kepek']['tmp_name'][$i],$fajlut))
					{
						$osszesfajl=$osszesfajl."|".$fajlnev;
						$sikeres++;
					}
					else
					{
						$hibaszoveg=$hibaszoveg."Feltöltési hiba történt: ".$fajlnev."&nbsp;<br />";
					}
				}
				else
				{
					$hibaszoveg=$hibaszoveg."Fájlformátum hiba történt: ".$fajlnev."&nbsp;<br />";
				}
			}
			if($sikeres>=1 AND $vanfokep=="nincs")
			{
				$termekfrissit=$pdo->query("update ".$elotag."_shop_termek set t_gyarto='".$_POST["t_gyarto"]."',t_nev='".$_POST["t_nev"]."',t_kategoria='".$_POST["t_kategoria"]."',t_kepek='".$osszesfajl."',t_ar='".$_POST["t_ar"]."',t_kleiras='".$_POST["t_kleiras"]."',t_nleiras='".$_POST["t_nleiras"]."' where t_id='".$_POST["termekmod"]."'");
				
				if($termekfrissit)
				{
					echo "<h3 style='color:#00FF00;'>Sikeres termék frissítés!</h3>";
					echo "<script>
					function atiranyit()
					{
						location.href = 'index.php?lng=hun&page=shop';
					}
					ID = window.setTimeout('atiranyit();', 1*100);
				</script>";
				}
				else
				{
					echo "<h3 style='color:#FF0000;'>Sajnos nem sikerült a termék frissítése!</h3>";
					$hibaszoveg=$hibaszoveg."SQL Hiba történt - főkép felöltést NEM kért.<br />";
					echo "<script>
					function atiranyit()
					{
						location.href = 'index.php?lng=hun&page=shop';
					}
					ID = window.setTimeout('atiranyit();', 1*100);
				</script>";
				}
			}
			else
			{
				echo "<h3 style='color:#FF0000;'>Sajnos nem sikerült a termék frissítése (SQL HIBA)!</h3><br /><b>HIBÁK:</b><br />".$hibaszoveg."";
				echo "<script>
					function atiranyit()
					{
						location.href = 'index.php?lng=hun&page=shop';
					}
					ID = window.setTimeout('atiranyit();', 1*100);
				</script>";
			}
		}
		elseif(isset($_POST["fkepetis"]) AND $_POST["fkepetis"]=="yes" AND !isset($_POST["tobbkepetis"]) AND $_POST["tobbkepetis"]!="yes") //ha csak a főképet cseréli
		{
			$SafeFile=$_FILES["t_fkep"]["name"];
			$SafeFile = strtolower($SafeFile);
			$SafeFile = str_replace("#", "_", $SafeFile); 
			$SafeFile = str_replace("$", "_", $SafeFile); 
			$SafeFile = str_replace("%", "_", $SafeFile); 
			$SafeFile = str_replace("'", "_", $SafeFile); 
			$SafeFile = str_replace(",", "_", $SafeFile); 
			$SafeFile = str_replace("&", "_", $SafeFile); 
			$SafeFile = str_replace("*", "_", $SafeFile); 
			$SafeFile = str_replace("+", "_", $SafeFile); 
			$SafeFile = str_replace("!", "_", $SafeFile); 
			$SafeFile = str_replace("?", "_", $SafeFile);
			$SafeFile = str_replace("=", "_", $SafeFile);
			$SafeFile = str_replace("/", "_", $SafeFile); 
			$SafeFile = str_replace("§", "_", $SafeFile); 
			$SafeFile = str_replace("(", "_", $SafeFile); 
			$SafeFile = str_replace(")", "_", $SafeFile); 
			$SafeFile = str_replace("ö", "o", $SafeFile);
			$SafeFile = str_replace("ő", "o", $SafeFile);
			$SafeFile = str_replace("ó", "o", $SafeFile);
			$SafeFile = str_replace("ü", "u", $SafeFile);
			$SafeFile = str_replace("ű", "u", $SafeFile);
			$SafeFile = str_replace("ú", "u", $SafeFile);
			$SafeFile = str_replace("é", "e", $SafeFile);
			$SafeFile = str_replace("á", "a", $SafeFile);
			$SafeFile = str_replace("í", "i", $SafeFile);
			$SafeFile = str_replace("ö", "o", $SafeFile);
			$SafeFile = str_replace("Ö", "o", $SafeFile);
			$SafeFile = str_replace("Ő", "o", $SafeFile);
			$SafeFile = str_replace("Ó", "o", $SafeFile);
			$SafeFile = str_replace("Ü", "u", $SafeFile);
			$SafeFile = str_replace("Ű", "u", $SafeFile);
			$SafeFile = str_replace("Ú", "u", $SafeFile);
			$SafeFile = str_replace("É", "e", $SafeFile);
			$SafeFile = str_replace("Á", "a", $SafeFile);
			$SafeFile = str_replace("Í", "i", $SafeFile);
			$SafeFile = str_replace(" ", "_", $SafeFile);
			
			$ext = strtolower(substr(strrchr($SafeFile, "."), 1));
			
			if($ext == "jpg" || $ext == "gif" || $ext == "bmp" || $ext == "png")
			{
				$datummost=getDate();
				$datekeszit=mktime($datummost["hours"],$datummost["minutes"],$datummost["seconds"],$datummost["mon"],$datummost["mday"],$datummost["year"]);
				$dazo=date("Ymdhms",$datekeszit);
				
				$fajlnev="../shop/".$dazo."_".$SafeFile;
				$fokep=$dazo."_".$SafeFile;
				
				if(move_uploaded_file($_FILES["t_fkep"]["tmp_name"],$fajlnev))
				{
					$termekfrissit=$pdo->query("update ".$elotag."_shop_termek set t_gyarto='".$_POST["t_gyarto"]."',t_nev='".$_POST["t_nev"]."',t_kategoria='".$_POST["t_kategoria"]."',t_fkep='".$fokep."',t_ar='".$_POST["t_ar"]."',t_kleiras='".$_POST["t_kleiras"]."',t_nleiras='".$_POST["t_nleiras"]."' where t_id='".$_POST["termekmod"]."'");
					if($termekfrissit)
					{
						echo "<h3 style='color:#00FF00;'>Sikeres termék frissítés!</h3>";
						echo "<script>
					function atiranyit()
					{
						location.href = 'index.php?lng=hun&page=shop';
					}
					ID = window.setTimeout('atiranyit();', 1*100);
				</script>";
					}
					else
					{
						echo "<h3 style='color:#FF0000;'>Sajnos nem sikerült a termék frissítése!</h3>";
						echo "<script>
					function atiranyit()
					{
						location.href = 'index.php?lng=hun&page=shop';
					}
					ID = window.setTimeout('atiranyit();', 1*100);
				</script>";
					}
				}
				else
				{
					echo "<h3 style='color:#FF0000;'>Sajnos nem sikerült a kép feltöltése a frissítés folyamán!</h3>";
					echo "<script>
					function atiranyit()
					{
						location.href = 'index.php?lng=hun&page=shop';
					}
					ID = window.setTimeout('atiranyit();', 1*100);
				</script>";
				}
			}
			else
			{
				echo "<h3 style='color:#FF0000;'>Nem megfelelő formátumot akartál feltöltni (UPD), az engedélyezettek: JPG, PNG, GIF, BMP!</h3>";
				echo "<script>
					function atiranyit()
					{
						location.href = 'index.php?lng=hun&page=shop';
					}
					ID = window.setTimeout('atiranyit();', 1*100);
				</script>";
			}
		}
		else //képcsere és feltöltés nélküli frissítés
		{
			$termekfrissit=$pdo->query("update ".$elotag."_shop_termek set t_gyarto='".$_POST["t_gyarto"]."',t_nev='".$_POST["t_nev"]."',t_kategoria='".$_POST["t_kategoria"]."',t_ar='".$_POST["t_ar"]."',t_kleiras='".$_POST["t_kleiras"]."',t_nleiras='".$_POST["t_nleiras"]."' where t_id='".$_POST["termekmod"]."'");
			if($termekfrissit)
			{
				echo "<h3 style='color:#00FF00;'>Sikeres termék frissítés!</h3>";
				echo "<script>
					function atiranyit()
					{
						location.href = 'index.php?lng=hun&page=shop';
					}
					ID = window.setTimeout('atiranyit();', 1*100);
				</script>";
			}
			else
			{
				echo "<h3 style='color:#FF0000;'>Sajnos nem sikerült a termék frissítése - SQL hiba történt a képcsere nélküli mentés folyamán!</h3>";
				echo "<script>
					function atiranyit()
					{
						location.href = 'index.php?lng=hun&page=shop';
					}
					ID = window.setTimeout('atiranyit();', 1*100);
				</script>";
			}
		}
	}
/*** ADATFELVÉTELEK ŰRLAPJAI ***/
	//termék hozzáadás űrlap
	elseif(isset($_GET["ujtermek"]))
	{
		echo "<h2>ÚJ TERMÉK FELVÉTELE</h2>";
		echo "<form name='ujtermek' method='POST' action='index.php?lng=".$webaktlang."&page=shop' enctype='multipart/form-data'>
					<input type='hidden' name='ujtermek' id='ujtermek' value='igen'>
					<b>Termék Gyártó:</b><br />
						<select name='t_gyarto' id='t_gyarto' style='width:200px;' required>
							<option value=''>Válasszon gyártót!</option>";
							$gyartok=$pdo->query("select * from ".$elotag."_shop_gyartok");
							while($eg=$gyartok->fetch())
							{
								echo "<option value='".$eg["shop_gyartonev"]."'>".$eg["shop_gyartonev"]."</option>";
							}
					echo "</select><br /><br />
					<b>Termék Kategória:</b><br />
						<select name='t_kategoria' id='t_kategoria' style='width:200px;'>
							<option value=''>Válasszon kategóriát!</option>";
							$kategoria1=$pdo->query("select * from ".$elotag."_shop_kategoriak");
							while($ek1=$kategoria1->fetch())
							{
								echo "<option value='".$ek1["shop_kategorianev"]."'>".$ek1["shop_kategorianev"]."</option>";
							}
					echo "</select><br /><br />
					<b>Termék neve:</b><br /><input type='text' name='t_nev' id='t_nev' style='width:200px;' required><br /><br />
					<b>Termék ára:</b><br /><input type='text' name='t_ar' id='t_ar' style='width:200px;' required> Ft<br /><br />
					<b>Termék főképe:</b><br /><input type='file' name='t_fkep' id='t_fkep' style='width:200px;' required><br /><br />
					<b>Termék további képei:</b><br />További képeket a mentés után, szerkesztéskor lehet hozzáadni!<br /><br />
					<b>Termékhez PDF prospektus:</b>&nbsp;<input type='checkbox' name='pdfis' id='pdfis' value='yes' onclick='PDFetis(this.form)'><br /><input type='file' name='t_pdf' id='t_pdf' style='width:200px;' disabled><br /><br />
					<b>Termék rövid leírása:</b><br /><input type='text' name='t_kleiras' id='t_kleiras' style='width:200px;' required><br /><br />
					<b>Termék teljes leírása:</b><br /><textarea name='t_nleiras' id='t_nleiras' style='width:400px;height:100px;'></textarea><br /><br />
						<input type='submit' id='termekmentes' name='termekmentes' value=' TERMÉK MENTÉSE ' class='btn btn-large btn-secondary'><br />
			   </form>";
	}
	//gyártó hozzáadás űrlap
	elseif(isset($_GET["ujgyarto"]))
	{
		echo "<h2>ÚJ GYÁRTÓ FELVÉTELE</h2>";
		echo "<form name='ujgyarto' method='POST' action='index.php?lng=".$webaktlang."&page=shop' enctype='multipart/form-data'>
					<input type='hidden' name='ujgyarto' id='ujgyarto' value='igen'>
					<b>Új gyártó neve:</b><br /><input type='text' name='shop_gyartonev' id='shop_gyartonev' style='width:200px;' required><br /><br />
					<input type='submit' id='gyartomentes' name='gyartomentes' value=' GYÁRTÓ MENTÉSE ' class='btn btn-large btn-secondary'><br />
				</form>";
	}
	//kategória hozzáadás űrlap
	elseif(isset($_GET["ujkategoria"]))
	{
		echo "<h2>ÚJ KATEGÓRIA FELVÉTELE</h2>";
		echo "<form name='ujkategoria' method='POST' action='index.php?lng=".$webaktlang."&page=shop' enctype='multipart/form-data'>
					<input type='hidden' name='ujkategoria' id='ujkategoria' value='".$_GET["ujkategoria"]."'>
					<b>Új kategória neve:</b><br /><input type='text' name='shop_kategorianev' id='shop_kategorianev' style='width:200px;' required><br /><br />
					<b>Kategória kisképe:</b><br /><input type='file' name='shop_kategkep' id='shop_kategkep'><br /><br />
					<input type='submit' id='kategoriamentes' name='kategoriamentes' value=' KATEGÓRIA MENTÉSE ' class='btn btn-large btn-secondary'><br />
				</form>";
	}
/*** SZERKESZTÉSEK ŰRLAPJAI ***/
	//gyártó szerkesztése űrlap
	elseif(isset($_GET["gyartomod"]))
	{
		$gyarto=$pdo->query("select * from ".$elotag."_shop_gyartok where shop_gyartoid='".$_GET["gyartomod"]."'");
		$adat=$gyarto->fetch();
		echo "<h2>GYÁRTÓ MÓDOSÍTÁSA</h2>";
		echo "<form name='gyartomod' method='POST' action='index.php?lng=".$webaktlang."&page=shop' enctype='multipart/form-data'>
					<input type='hidden' name='gyartomod' id='gyartomod' value='".$_GET["gyartomod"]."'>
					<b>Új gyártó neve:</b><br /><input type='text' name='shop_gyartonev' id='shop_gyartonev' style='width:200px;' value='".$adat["shop_gyartonev"]."' required><br /><br />
					<input type='submit' id='gyartomentes' name='gyartomentes' value=' GYÁRTÓ FRISSÍTÉSE ' class='btn btn-large btn-secondary'><br />
				</form>";
	}
	//kategória szerkesztése űrlap
	elseif(isset($_GET["kategoriamod"]))
	{
		$kategoria=$pdo->query("select * from ".$elotag."_shop_kategoriak where shop_kategoriaid='".$_GET["kategoriamod"]."'");
		$adat=$kategoria->fetch();
		echo "<h2>KATEGÓRIA MÓDOSÍTÁSA</h2>";
		echo "<form name='kategoriamod' method='POST' action='index.php?lng=".$webaktlang."&page=shop' enctype='multipart/form-data'>
					<input type='hidden' name='kategoriamod' id='kategoriamod' value='".$_GET["kategoriamod"]."'>
					<b>Kategória neve:</b><br /><input type='text' name='shop_kategorianev' id='shop_kategorianev' style='width:200px;' value='".$adat["shop_kategorianev"]."' required><br /><br />
					<b>Kategória kisképe:</b><br /><input type='file' name='shop_kategkep' id='shop_kategkep'><br /><br />";
		echo "		<input type='submit' id='kategoriamentes' name='kategoriamentes' value=' KATEGÓRIA FRISSÍTÉSE ' class='btn btn-large btn-secondary'>
				</form>";
	}
	//termék szerkesztése űrlap
	elseif(isset($_GET["termekmod"]))
	{
		$ter_bet=$pdo->query("select * from ".$elotag."_shop_termek where t_id='".$_GET["termekmod"]."'");
		$adatok=$ter_bet->fetch();
		echo "<h2>TERMÉK MÓDOSÍTÁSA</h2>";
		echo "<form name='termekmodform' id='termekmodform' method='POST' action='index.php?lng=".$webaktlang."&page=shop' enctype='multipart/form-data'>
					<input type='hidden' name='termekmod' id='termekmod' value='".$_GET["termekmod"]."'>
					<b>Termék Gyártó:</b><br /><select name='t_gyarto' id='t_gyarto' style='width:200px;' required>
											<option value='".$adatok["t_gyarto"]."'>".$adatok["t_gyarto"]."</option>";
					$gyartok=$pdo->query("select * from ".$elotag."_shop_gyartok");
					while($eg=$gyartok->fetch())
					{
						echo "<option value='".$eg["shop_gyartonev"]."'>".$eg["shop_gyartonev"]."</option>";
					}
									echo "</select><br /><br />
					<b>Termék Kategória:</b><br><select name='t_kategoria' id='t_kategoria' style='width:220px;'>";
							if($adatok["t_kategoria"]!="" AND $adatok["t_kategoria"]!=" ") { echo "<option value='".$adatok["t_kategoria"]."' selected>AKTUÁLIS: ".$adatok["t_kategoria"]."</option>"; }
							else { echo "<option value=''>Válasszon kategóriát!</option>"; }
							$kategoria1=$pdo->query("select * from ".$elotag."_shop_kategoriak");
							while($ek1=$kategoria1->fetch())
							{
								echo "<option value='".$ek1["shop_kategorianev"]."'>".$ek1["shop_kategorianev"]."</option>";
							}
					echo "</select><br /><br />
					<b>Termék neve:</b><br /><input type='text' name='t_nev' id='t_nev' style='width:200px;' value='".$adatok["t_nev"]."' required><br /><br />
					<b>Termék ára:</b><br /><input type='text' name='t_ar' id='t_ar' style='width:200px;' value='".$adatok["t_ar"]."' required> Ft<br /><br />
					<b>Termék főképe:</b><br /><a href='../shop/".$adatok["t_fkep"]."' rel='clearbox'><img src='../shop/".$adatok["t_fkep"]."' border='0' width='200'></a><br />
						<input type='checkbox' name='fkepetis' id='fkepetis' value='yes' onclick='fokepCsere(this.form)'> <small>(Szeretném a főképet lecserélni.)</small><br />
						<input type='file' name='t_fkep' id='t_fkep' style='width:200px;' disabled><br /><br />
					<b>Termék további képei:</b><br />";
					if($adatok["t_kepek"]!="")
					{
						$t_kepek=explode("|", $adatok["t_kepek"]);
						$darabszam=0;
						foreach($t_kepek as $valami)
						{
							if($t_kepek[$darabszam]=="")
							{
								echo "&nbsp;";
							}
							else
							{
								echo "<a href='../shop/kepek/".$t_kepek[$darabszam]."' rel='clearbox'><img src='../shop/kepek/".$t_kepek[$darabszam]."' border='0' width='100' height='100'></a>&nbsp;";
							}
							$darabszam++;
						}
					}
					else
					{
						echo "<small>Még nincsen feltöltve több kép!</small>";
					}
			 echo "<br /><input type='checkbox' name='tobbkepetis' id='tobbkepetis' value='yes' onclick='tobbikepCsere(this.form)'> <small>(Szeretnék további képeket feltölteni.)</small><br />
							<small>(A meglévő képek törlődnek újak feltöltésekor!)</small><br />
						  <input type='file' name='t_kepek[]' id='t_kepek[]' value='' style='width:200px;' multiple disabled><br /><br />
					<b>Termék prospektus:</b><br />";
					if($adatok["t_pdf"]!="")
					{
						echo "<a href='../shop/".$adatok["t_pdf"]."' target='_blank'>Prospektus megtekintése</a>";
					}
					else
					{
						echo "<small>Még nincsen feltöltve PDF dokumentum!</small>";
					}
			echo "	<br /><input type='checkbox' name='pdfis' id='pdfis' value='yes' onclick='PDFetismod(this.form)'><small>Szeretnék új PDF-et feltölteni</small><br /><input type='file' name='t_pdf' id='t_pdf' style='width:200px;' disabled><br /><br />
					<b>Termék rövid leírása:</b><br /><input type='text' name='t_kleiras' id='t_kleiras' style='width:200px;' value='".$adatok["t_kleiras"]."' required><br /><br />
					<b>Termék teljes leírása:</b><br /><textarea name='t_nleiras' id='t_nleiras' style='width:400px;height:100px;'>".$adatok["t_nleiras"]."</textarea><br /><br />
						<input type='submit' id='termekmentes' name='termekmentes' value=' TERMÉK FRISSÍTÉSE ' class='btn btn-large btn-secondary'><br />
			   </form>";
	}
/*** FŐ RENDSZERTÖLTŐ SCRIPT ***/
	else
	{
		//jQ_Datatables script
?>
	<script src='./js/libs/jquery-migrate-1.1.1.min.js'></script>
	<link href="https://cdn.datatables.net/1.10.18/css/dataTables.jqueryui.min.css" rel="stylesheet" type="text/css" />
	<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.18/js/dataTables.jqueryui.min.js"></script>
	<script src='https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js'></script>
	<script src='https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js'></script>
	<script src='https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js'></script>	
	<script src='https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js'></script>	
	<script src='https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js'></script>
	<script src='https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js'></script>
	<script src='https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js'></script>
	<link href="https://cdn.datatables.net/responsive/2.2.2/css/responsive.semanticui.min.css" rel="stylesheet" type="text/css" />
	<script src='https://cdn.datatables.net/responsive/2.2.2/js/dataTables.responsive.min.js'></script>
	<script src='https://cdn.datatables.net/responsive/2.2.2/js/responsive.semanticui.min.js'></script>
	<style>
		input[type="text"] {
			max-width: 150px !important;
		}
	</style>
	<script type="text/javascript">
		$.extend( true, $.fn.dataTable.defaults, {
			responsive: false,
			buttons: [
				{
					extend: 'copy',
					text: 'Másolás',
					exportOptions: {
						modifier: {
							page: 'current'
						}
					}
				},
				{
					extend: 'pdfHtml5',
					text: 'PDF',
					exportOptions: {
						modifier: {
							page: 'current'
						}
					}
				},
				{
					extend: 'excel',
					text: 'Excel (XLS)',
					exportOptions: {
						modifier: {
							page: 'current'
						}
					}
				},
				{
					extend: 'csv',
					text: 'Excel (CSV)',
					exportOptions: {
						modifier: {
							page: 'current'
						}
					}
				},
				{
					extend: 'print',
					text: 'Nyomtatás',
					exportOptions: {
						modifier: {
							page: 'current'
						}
					}
				}
			],
			"language": {
				"lengthMenu": "_MENU_ sor / lap",
				"zeroRecords": "Nem találtam semmit, bocsi... :)",
				"info": "Adatok: _START_ - _END_ | Összesen: _TOTAL_",
				"infoEmpty": "Nincs megfelelő adat",
				"sProcessing": "Feldolgozás...",
				"sLoadingRecords": "Betöltés...",
				"sSearch": "Keresés:",
				"infoFiltered": "(szűrve a _MAX_ sorból összesen)",
				"oPaginate": {
					   "sFirst":    "Első",
					   "sPrevious": "Előző",
					   "sNext":     "Következő",
					   "sLast":     "Utolsó"
				   }
			}
		});
		$(document).ready(function() {
			$('#datatables tfoot th').each( function () {
				$(this).html( '<input type="text" />' );
			});

			var table = $('#datatables').DataTable({
				"pageLength": 50,
				"order": [[ 0, "desc" ]],
				dom: 'Brtip'
			});

			table.columns().every( function () {
				var column = this;
			 
				$( 'input', this.footer() ).on( 'keyup change', function () {
					column
						.search( this.value )
						.draw();
				});
			});
		});
	</script>
<?php
/*** MENÜNEK MEGFELELŐ TÁBLA BETÖLTÉSE ***/
		if(isset($_GET["rendelesek"])) //megrendelések
		{
			$osszes=$pdo->query("select * from ".$elotag."_shop_rendelesek");
			echo "<h3>MEGRENDELÉSEK LISTA</h3>
					<br />
					<table id='datatables' class='display'>
						<thead>
							<tr>
								<th>Megrendelés ID</th>
								<th>Megrendelés dátuma</th>
								<th>Művelet</th>
							</tr>
						</thead><tbody>";
			while($row = $osszes->fetch())
			{
				echo "<tr>
							<td>".$row['m_id']."</td>
							<td>".$row['datum']."</td>
							<td><a href='index.php?lng=".$webaktlang."&page=shop&rendelles=".$row["m_id"]."' title='Megrendelés megtekintése'><b>MEGTEKINT</b></a><br /><a href='index.php?lng=".$webaktlang."&page=shop&rendtorol=".$row["m_id"]."' title='Adat törlése' onclick='return confirm(\"Biztosan törlöd ezt a megrendelést?\")'><b>TÖRÖL</b></a></td>
					   </tr>";
			}
			echo "</tbody>
				</table>";
		}
		elseif(isset($_GET["kategoriak"])) //kategóriák
		{
			$osszes=$pdo->query("select * from ".$elotag."_shop_kategoriak");
			echo "<h3>KATEGÓRIA LISTA</h3>
					<a href='index.php?lng=".$webaktlang."&page=shop&ujkategoria=1' class='btn'>+ hozzáadás &raquo;</a>
					<br /><br />
					<table id='datatables' class='display'>
						<thead>
							<tr>
								<th>Kategória ID</th>
								<th>Kategória név</th>
								<th>Művelet</th>
							</tr>
						</thead><tbody>";
			while($row = $osszes->fetch())
			{
				echo "<tr>
							<td align='right'>".$row['shop_kategoriaid']."</td>
							<td>".$row['shop_kategorianev']."</td>
							<td align='center'><a href='index.php?lng=".$webaktlang."&page=shop&ksz=1&kategoriamod=".$row["shop_kategoriaid"]."' class='btn'>módosít</a> 
								<a href='index.php?lng=".$webaktlang."&page=shop&ksz=1&kategoriatorol=".$row["shop_kategoriaid"]."' class='btn' onclick='return confirm(\"Biztosan törlöd ezt a kategóriát?\")'>töröl</a></td>
					   </tr>";
			}
			echo "</tbody>
				</table>";
		}
		elseif(isset($_GET["rendelles"])) //megrendelések
		{
			$osszes=$pdo->query("select * from ".$elotag."_shop_rendelesek where m_id='".$_GET["rendelles"]."'");
			$eak=$osszes->fetch();
			echo "<h3>MEGRENDELÉS ADATAI</h3>
				<u><b>Megrendelő adatai:</b></u><br />".$eak["megrendelo"]."<br /><br />
				<u><b>Tétel adatok:</b></u><br />".$eak["tetelek"]."<br /><br />
				<u><b>Egyéb adatok:</b></u><br /><i>szállítás:</i> ".$eak["szallitas"]."<br /><i>számlázás:</i> ".$eak["fizetes"]."<br />dátum: ".$eak["datum"]."
			";
		}
		elseif(isset($_GET["gyartok"])) //gyártók
		{
			$osszes=$pdo->query("select * from ".$elotag."_shop_gyartok");
			echo "<h3>GYÁRTÓK LISTA</h3>
					<a href='index.php?lng=".$webaktlang."&page=shop&ujgyarto=y' class='btn'> + új gyártó felvétele &raquo;</a>
					<br /><br />
					<table id='datatables' class='display'>
						<thead>
							<tr>
								<th>Gyártó ID</th>
								<th>Gyártó név</th>
								<th>Művelet</th>
							</tr>
						</thead><tbody>";
			while($row = $osszes->fetch())
			{
				echo "<tr>
							<td>".$row['shop_gyartoid']."</td>
							<td>".$row['shop_gyartonev']."</td>
							<td><a href='index.php?lng=".$webaktlang."&page=shop&gyartomod=".$row["shop_gyartoid"]."' title='Gyártó módosítása'><b>MÓDOSÍT</b></a><br /><a href='index.php?lng=".$webaktlang."&page=shop&gyartotorol=".$row["shop_gyartoid"]."' title='Gyártó törlése' onclick='return confirm(\"Biztosan törlöd ezt a gyártót?\")'><b>TÖRÖL</b></a></td>
					   </tr>";
			}
			echo "</tbody>
				</table>";
		}
		else //termékek
		{
			$osszes=$pdo->query("select * from ".$elotag."_shop_termek");
			echo "<h3>TERMÉK LISTA</h3>
					<a href='index.php?lng=".$webaktlang."&page=shop&ujtermek=y' class='btn'>+ új termék felvétele &raquo;</a><br>
					<br />
					<table id='datatables' class='display'>
						<thead>
							<tr>
								<th>Gyártó</th>
								<th>Termék név</th>
								<th>Termék kategória</th>
								<th>Termék ár</th>
								<th>Művelet</th>
							</tr>
						</thead><tbody>";
			while($row = $osszes->fetch())
			{
				echo "<tr>
							<td>".$row['t_gyarto']."</td>
							<td>".$row['t_nev']."</td>
							<td>".$row['t_kategoria']."</td>
							<td>".$row['t_ar']." Ft</td>
							<td align='center'><a href='index.php?lng=".$webaktlang."&page=shop&termekmod=".$row["t_id"]."' title='Termék módosítása'><b>M</b></a>&nbsp;|&nbsp;<a href='index.php?lng=".$webaktlang."&page=shop&termektorol=".$row["t_id"]."' title='Termék törlése' onclick='return confirm(\"Biztosan törlöd ezt a terméket?\")' style='color:#f00;'><b>X</b></a></td>
					   </tr>";
			}
			echo "</tbody>
					<tfoot>
						<tr>
							<th align='left'><input type='text' name='search_t_gyarto' class='search_init' style='width:100px;' /></th>
							<th align='left'><input type='text' name='search_t_nev' class='search_init' style='width:300px;' /></th>
							<th align='left'><input type='text' name='search_t_kategoria' class='search_init' style='width:300px;' /></th>
							<th align='left'><input type='text' style='display:none;' /></th>
							<th align='left'><input type='text' style='display:none;' /></th>
						</tr>
					</tfoot>
				</table>";
		}
	}
}
else
{
	echo "<br /><br /><center><b>Nem vagy bejelentkezve!</b></center><br />";
}
?>