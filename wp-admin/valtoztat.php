<?php
session_start();
if(isset($_SESSION["userlogged"]) AND $_SESSION["userlogged"]!="" AND $_SESSION["userlogged"]!=" ")
{
	include("../connect.php");
	//új menüpont hozzáadása
	if(isset($_GET["ujmenu"]))
	{
		$sorszam=$pdo->query("select max(sorszam) as sorszam from ".$elotag."_menu_".$webaktlang);
		$illeszt=$sorszam->fetch();
		$ujsorszam=$illeszt["sorszam"]+1;
		echo "<h3>Új menüpont létrehozása</h3>";
		echo "<form action='index.php?lng=".$webaktlang."&mod=y' method='POST'>";
		echo "<font face='Verdana' size='2' color='#000000'><b>Írja be ide a menüpont nevét:</b></font><br />";
		echo "<input type='hidden' name='tartalom' value='Új weboldal tartalom mentve!'>";
		echo "<input type='text' name='menunev' style='width:200px;' required><br /><br />";
		echo "<input type='hidden' name='sorszam' value='".$ujsorszam."'>";
		echo "<input type='submit' value='mentés' class='btn btn-large btn-secondary'></form>";
	}
	//menüpont sorszám módosítása
	if(isset($_GET["menusormod"]))
	{
		$lekerdez=$pdo->query("select * from ".$elotag."_menu_".$webaktlang." order by sorszam");
			$lastmenu=$pdo->query("select max(sorszam) as utso from ".$elotag."_menu_".$webaktlang);
			$meghataroz=$lastmenu->fetch();
		echo "<h3>Menüpontok sorrendjének beállítása:</h3>";
		while($betolt=$lekerdez->fetch())
		{
			$menucim=str_replace(" ","&nbsp;",$betolt["nev"]);
			if($betolt["sorszam"]=="1")
			{
				echo "<font face='verdana' size='2' color='#FF0000'> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </font> | <a href='index.php?lng=".$webaktlang."&mod=y&menusorszam=".$betolt["kod"]."&irany=le' style='text-decoration:none;'><font face='verdana' size='2' color='#FF0000'>lentebb</font></a>&nbsp;&nbsp;<big><b>".$menucim."</b></big><br />";
			}
			elseif($meghataroz["utso"]==$betolt["sorszam"])
			{
				echo "<a href='index.php?lng=".$webaktlang."&mod=y&menusorszam=".$betolt["kod"]."&irany=fel' style='text-decoration:none;'><font face='verdana' size='2' color='#FF0000'>fentebb</font></a> | <font face='verdana' size='2' color='#FF0000'> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </font>&nbsp;&nbsp;<big><b>".$menucim."</b></big><br />";
			}
			else
			{
				echo "<a href='index.php?lng=".$webaktlang."&mod=y&menusorszam=".$betolt["kod"]."&irany=fel' style='text-decoration:none;'><font face='verdana' size='2' color='#FF0000'>fentebb</font></a>&nbsp;|&nbsp;";
				echo "<a href='index.php?lng=".$webaktlang."&mod=y&menusorszam=".$betolt["kod"]."&irany=le' style='text-decoration:none;'><font face='verdana' size='2' color='#FF0000'>lentebb</font></a>&nbsp;&nbsp;<big><b>".$menucim."</b></big><br />";
			}
		}
	}
	//új almenüpont hozzáadása
	if(isset($_GET["ujalmenu"]))
	{
		echo "<h3>Új almenüpont létrehozása</h3>";
		echo "<form action='index.php?lng=".$webaktlang."&mod=y' method='POST'>";
		echo "<font face='Verdana' size='2' color='#000000'><b>Írja be ide az almenüpont nevét:</b></font><br />";
		echo "<input type='hidden' name='tartalom' value='Új alweboldal tartalom mentve!'>";
		echo "<input type='text' name='almenunev' style='width:200px;' required><br /><br />";
		echo "<font face='Verdana' size='2' color='#000000'><b>Szülőmenü:</b></font>";
		echo "<input type=hidden name='szulo' value='".$_GET["ujalmenu"]."'>";
		$szulok=$pdo->query("select * from ".$elotag."_menu_".$webaktlang." where kod='".$_GET["ujalmenu"]."'");
		$egy_szulo=$szulok->fetch();
		echo "<b>".$egy_szulo["nev"]."</b><br /><br />";
		echo "<input type='submit' value='mentés' class='btn btn-large btn-secondary'></form>";
	}
	//OLDALSÁV blokkok kezelése
	if(isset($_GET["blokkok"]))
	{
		$lekerdez=$pdo->query("select * from ".$elotag."_oldalsav_".$webaktlang."");
		echo "<h3>Oldalsáv blokkok kezelése</h3>";
		echo "<a href='index.php?lng=".$webaktlang."&mod=y&ujblokk=1' class='btn'>+ Új hozzáadása</a><br><br>";
		if($lekerdez->rowCount()>0)
		{

			while($oldal=$lekerdez->fetch())
			{
				echo "<table border='0'>
						<tr>
						<td>
							<h5><u>CÍM:</u> ".$oldal["cim"]."</h5>
							<i class='icon-eye-open'></i> <a href='#myModal".$oldal["kod"]."' data-toggle='modal'>megtekintés</a> 
							".($oldal["aktiv"]=="1" ? "<i class='fa fa-power-off' aria-hidden='true'></i> <a href='index.php?lng=".$webaktlang."&mod=y&blokkstop=".$oldal["kod"]."'>kikapcsolás</a> " : "<i class='fa fa-check-square-o' aria-hidden='true'></i> <a href='index.php?lng=".$webaktlang."&mod=y&blokkstart=".$oldal["kod"]."'>aktiválás</a> ")."
							<i class='icon-pencil'></i> <a href='index.php?lng=".$webaktlang."&mod=edit&blokkszerk=".$oldal["kod"]."'>szerkesztés</a> 
							<i class='icon-trash'></i> <a href='index.php?lng=".$webaktlang."&mod=y&blokktorol=".$oldal["kod"]."' onclick=\"return confirm('Biztos törli a blokk-ot a tartalmával együtt?')\">törlés</a>
							<br><br>
						</td>
					  </tr>
					 </table>";
				//MODAL-ba a blokk tartalmát beleerőszakoljuk
				echo '<div class="modal fade hide" id="myModal'.$oldal["kod"].'">
					  <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h3>'.$oldal["cim"].'</h3>
					  </div>
					  <div class="modal-body">
						<p>'.$oldal["szoveg"].'</p>
					  </div>
					  <div class="modal-footer">
						<a href="javascript:void(0);" class="btn" data-dismiss="modal">bezárás</a>
					  </div>
					</div>';
			}
			echo "<br />";
		}
		else
		{
			echo "<h5>Még nincs oldalsáv blokk létrehozva!</h5>";
			echo "<a class='btn' href='index.php?lng=".$webaktlang."&mod=y&ujblokk=1'>új blokk létrehozása</a><br><br>";
		}
	}
	//új blokk hozzáadása
	if(isset($_GET["ujblokk"]))
	{
		$sorszam=$pdo->query("select max(sorszam) as sorszam from ".$elotag."_oldalsav_".$webaktlang."");
		$illeszt=$sorszam->fetch();
		$ujsorszam=$illeszt["sorszam"]+1;
		echo "<h4>Oldalsáv blokk hozzáadása</h4>";
		echo "<form action='index.php?lng=".$webaktlang."&mod=y' method='POST'>";
		echo "<font face='Verdana' size='2' color='#000000'><b>Írja be ide a blokk címsorát:</b></font><br />";
		echo "<input type='hidden' name='szoveg' value='<p><center><b>Új blokk tartalom mentve!</b></center></p>'>";
		echo "<input type='text' name='blokknev' style='width:200px;' required><br /><br />";
		echo "<input type='hidden' name='sorszam' value='".$ujsorszam."'>";
		echo "<input type='submit' value='mentés' class='btn btn-large btn-secondary'></form>";
	}
	//blokk névváltoztatás
	if(isset($_GET["blokkmod"]))
	{
		$lekerdez=$pdo->query("select * from ".$elotag."_oldalsav_".$webaktlang." where kod='".$_GET["blokkmod"]."'");
		$oldalsav=$lekerdez->fetch();
		$blokkcim=str_replace(" ","&nbsp;",$oldalsav["cim"]);

		echo "<br /><form action='index.php?lng=".$webaktlang."&mod=y' method='POST'>";
		echo "<font face='Verdana' size='2' color='#000000'><b>Írja be ide a blokk címét:</b></font><br />";
		echo "<input type='hidden' name='kod' value='".$_GET["blokkmod"]."'>";
		echo "<input type='text' name='cim' value='".$blokkcim."' style='width:200px;' required><br /><br />";
		echo "<input type='submit' value='mentés' class='btn btn-large btn-secondary'></form>";
	}
	//blokk sorszám módosítása
	if(isset($_GET["blokksormod"]))
	{
		$lekerdez=$pdo->query("select * from ".$elotag."_oldalsav_".$webaktlang." order by sorszam");
			$lastblokk=$pdo->query("select max(sorszam) as utso from ".$elotag."_oldalsav_".$webaktlang."");
			$meghataroz=$lastblokk->fetch();
		echo "<br /><font face='Verdana' size='2' color=#000000><b>Oldalsáv blokkok sorrendje:</b></font><br /><br />";
		while($betolt=$lekerdez->fetch())
		{
			$blokkcim=str_replace(" ","&nbsp;",$betolt["cim"]);
			if($betolt["sorszam"]=="1")
			{
				echo "<a href='index.php?lng=".$webaktlang."&mod=y&blokksorszam=".$betolt["kod"]."&irany=le' style='text-decoration:none;'><font face='verdana' size='1' color='#FF0000'>lentebb</font></a>&nbsp;&nbsp;".$blokkcim."<br />";
			}
			elseif($meghataroz["utso"]==$betolt["sorszam"])
			{
				echo "<a href='index.php?lng=".$webaktlang."&mod=y&blokksorszam=".$betolt["kod"]."&irany=fel' style='text-decoration:none;'><font face='verdana' size='1' color='#FF0000'>fentebb</font></a>&nbsp;&nbsp;".$blokkcim."<br />";
			}
			else
			{
				echo "<a href='index.php?lng=".$webaktlang."&mod=y&blokksorszam=".$betolt["kod"]."&irany=fel' style='text-decoration:none;'><font face='verdana' size='1' color='#FF0000'>fentebb</font></a>&nbsp;|&nbsp;";
				echo "<a href='index.php?lng=".$webaktlang."&mod=y&blokksorszam=".$betolt["kod"]."&irany=le' style='text-decoration:none;'><font face='verdana' size='1' color='#FF0000'>lentebb</font></a>&nbsp;&nbsp;".$blokkcim."<br />";
			}
		}
	}
	//új hírcikk hozzáadása
	if(isset($_GET["ujcikk"]))
	{
		echo "<h4>Bejegyzés, hírcikk hozzáadása</h4>";
		echo "<form action='index.php?lng=".$webaktlang."&mod=y' method='POST'>";
		echo "<font face='Verdana' size='2' color='#000000'><b>Létrehozandó hír címe:</b></font><br />";
		echo "<input type='hidden' name='szoveg' value='<p><center><b>Új hír létrehozva!</b></center></p>'>";
		echo "<input type='text' name='hircim' required><br /><br />";
		echo "<input type=submit value='mentés' class='btn btn-large btn-secondary'></form>";
	}
	//új SLIDER bokk hozzáadása
	if(isset($_GET["ujslider"]))
	{
		echo "<h3>Képváltó kezelése</h3>";
		echo "<h4>Új képváltó hozzáadása</h4>";
		echo "<form action='index.php?lng=".$webaktlang."&mod=y' method='POST' enctype='multipart/form-data'>";
		echo "<font face='Verdana' size='2' color='#000000'><b>Töltsön fel egy képet:</b><br /></font><br />";
		echo "<input type='file' name='ujsliderkep' id='ujsliderkep' required><br /><br />";
		echo "<font face='Verdana' size='2' color='#000000'><b>Képváltó első sora:</b></font><br />";
		echo "<input type='text' name='dumahozza' id='dumahozza' style='width:280px;' placeholder='Egyszerű, rövid szöveg!' value=''><br /><br />";
		echo "<font face='Verdana' size='2' color='#000000'><b>Képváltó második sora:</b></font><br />";
		echo "<input type='text' name='hivatkozas' id='hivatkozas' style='width:280px;' placeholder='Egyszerű, rövid szöveg!' value=''><br /><br />";
		echo "<input type=submit value='mentés' class='btn btn-large btn-secondary'></form>";
	}
	//SLIDER blokkok kezelése
	if(isset($_GET["sliderek"]))
	{
		echo "<h3>Képváltó kezelése</h3>";
		echo "<a href='index.php?lng=".$webaktlang."&mod=y&ujslider=1' class='btn'>+ Új hozzáadása</a><br><br>";
		echo "<table border='0'>";
		$lekerdez=$pdo->query("select * from ".$elotag."_slider");
		if($lekerdez->rowCount()>0)
		{
			while($oldal=$lekerdez->fetch())
			{
				echo "<tr><td><a class='btn' href='index.php?lng=".$webaktlang."&mod=y&sliderdel=".$oldal["sliderkod"]."'>KÉP TÖRLÉSE</a><br />Első sor szövege: ".$oldal["dumahozza"]."<br />Második sor szövege: ".$oldal["hiperlink"]."<br /><img src='../slider/".$oldal["slidert"]."' border='0' width='450'></td></tr><tr><td><hr></td></tr>";
			}
		}
		else
		{
			echo "<tr><td><h4>Még nincs feltöltve...</h4></td></tr>";
		}
		echo "</table><br />";
	}
	//felhasználói adatok módosítása
	if(isset($_GET["usermod"]))
	{
		$useradat=$pdo->query("select * from ".$elotag."_admin where nev='".$_SESSION["userlogged"]."'");
		$ua=$useradat->fetch();
		echo "<h3>Felhasználói adatok módosítása:</h3>";
		echo "<form action='index.php?lng=".$webaktlang."&mod=y' method='POST'>";
		echo "<input type='hidden' name='userkod' value='".$ua["kod"]."'>";
		echo "<big>Felhasználónév:</big><br>&nbsp; <input type='text' name='ujadminnev' placeholder='adja meg új felhasználónevét' value='".$ua["nev"]."'><br>";
		echo "<big>E-mail cím:</big><br>&nbsp; <input type='text' name='ujemailcim' placeholder='adja meg új e-mail címét' value='".$ua["email"]."'><br>";
		echo "<big>Új Jelszó:</big><br>&nbsp; <input type='password' name='ujadminpass' placeholder='adja meg jelszavát' pattern='.{3,}' minlength='5' required><br><br>";
		echo "<input type='submit' value='mentés' class='btn btn-large btn-secondary'>";
		echo "</form><br />";
	}
	//új nyelv hozzáadása
	if(isset($_GET["ujnyelv"]))
	{
		echo "<form action='index.php?lng=".$webaktlang."&mod=y' method='POST'>";
		echo "<h3>Adja meg a telepíteni kívánt új nyelvet:</h3><br />";
		echo "<select name='ujnyelv' id='ujnyelv' style='max-width:200px;'>";
		$nyelvek=array();
		$leker=$pdo->query("select * from ".$elotag."_nyelvek");
		while($l=$leker->fetch())
		{
			array_push($nyelvek,$l["langnev"]);
		}
			echo "<option value='hun' ".(in_array("hun", $nyelvek) ? "disabled" : "").">Magyar</option>";
			echo "<option value='ger' ".(in_array("ger", $nyelvek) ? "disabled" : "").">Német</option>";
			echo "<option value='eng' ".(in_array("eng", $nyelvek) ? "disabled" : "").">Angol</option>";
			echo "<option value='fra' ".(in_array("fra", $nyelvek) ? "disabled" : "").">Francia</option>";
			echo "<option value='dan' ".(in_array("dan", $nyelvek) ? "disabled" : "").">Dán</option>";
			echo "<option value='cze' ".(in_array("cze", $nyelvek) ? "disabled" : "").">Cseh</option>";
			echo "<option value='ned' ".(in_array("ned", $nyelvek) ? "disabled" : "").">Holland</option>";
			echo "<option value='hor' ".(in_array("hor", $nyelvek) ? "disabled" : "").">Horvát</option>";
			echo "<option value='len' ".(in_array("len", $nyelvek) ? "disabled" : "").">Lengyel</option>";
			echo "<option value='nor' ".(in_array("nor", $nyelvek) ? "disabled" : "").">Norvég</option>";
			echo "<option value='ita' ".(in_array("ita", $nyelvek) ? "disabled" : "").">Olasz</option>";
			echo "<option value='por' ".(in_array("por", $nyelvek) ? "disabled" : "").">Portugál</option>";
			echo "<option value='rom' ".(in_array("rom", $nyelvek) ? "disabled" : "").">Román</option>";
			echo "<option value='sve' ".(in_array("sve", $nyelvek) ? "disabled" : "").">Svéd</option>";
			echo "<option value='spa' ".(in_array("spa", $nyelvek) ? "disabled" : "").">Spanyol</option>";
			echo "<option value='srb' ".(in_array("srb", $nyelvek) ? "disabled" : "").">Szerb</option>";
			echo "<option value='slo' ".(in_array("slo", $nyelvek) ? "disabled" : "").">Szlovák</option>";
			echo "<option value='tur' ".(in_array("tur", $nyelvek) ? "disabled" : "").">Török</option>";
			echo "<option value='ukr' ".(in_array("ukr", $nyelvek) ? "disabled" : "").">Ukrán</option>";
			echo "<option value='rus' ".(in_array("rus", $nyelvek) ? "disabled" : "").">Orosz</option>";
		echo "</select><br /><br />";
		echo "<input type='submit' value='mentés' class='btn btn-large btn-secondary'></form><br>";
	}
	//social linkek kezelése
	if(isset($_GET["social"]))
	{
		echo "<h3>Közösségi portálok profil-linkjeinek kezelése</h3>";
		echo "<form action='index.php?lng=".$webaktlang."&mod=y' method='POST'>";
		$socmod=$pdo->query("select * from ".$elotag."_social");
		while($sm=$socmod->fetch())
		{
			echo "<font face='Verdana' size='2' color='#000000'><b>Írja be ide a ".$sm["socialsite"]." linkjét:</b></font><br />";
			echo "<input type='hidden' name='socialsite[".$sm["sockod"]."]' value='".$sm["socialsite"]."'>";
			echo "<input type='text' name='sociallink[".$sm["sockod"]."]' value='".$sm["sociallink"]."'><br /><br />";
		}
		echo "<input type='submit' value='mentés' class='btn btn-large btn-secondary'>";
		echo "</form>";
	}
	//google maps kezelése
	if(isset($_GET["gmaps"]))
	{
		echo "<h3>Google Maps térkép elérés kezelése</h3>";
		echo "<form action='index.php?lng=".$webaktlang."&mod=y' method='POST'>";
		$mapsmod=$pdo->query("select * from ".$elotag."_gmaps");
		$gm=$mapsmod->fetch();
		echo "<font face='Verdana' size='2' color='#000000'><b>Írja be ide a címét, amelyből a térkép készül majd:</b></font><br />";
		echo "<input type='text' name='gmapskey' value='".$gm["gmapskey"]."' style='width:95%'><br /><br />";
		echo "<input type='submit' value='mentés' class='btn btn-large btn-secondary'>";
		echo "</form>";
		if($mapsmod->rowCount()>0 AND $gm["gmapskey"]!="")
		{
			echo '<br><h3>A jelenlegi térkép:</h3><iframe src="https://www.google.com/maps/embed/v1/place?q='.$gm["gmapskey"].'&key=AIzaSyBGUnRIK9gqjmB2h2ClAETUAw70fzkHJRw" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>';
		}
	}
	//új LETÖLTÉS hozzáadása
	if(isset($_GET["ujdown"]))
	{
		echo "<h3>Új letölthető fájl hozzáadása</h3>";
		echo "<form action='index.php?lng=".$webaktlang."&mod=y' method='POST' enctype='multipart/form-data'>";
		echo "<font face='Verdana' size='2' color='#000000'><b>Töltsön fel egy fájlt:</b></font><br />&nbsp; ";
		echo "<input type='file' name='ujdown' id='ujdown' required><br /><br />";
		echo "<font face='Verdana' size='2' color='#000000'><b>Adjon neki NEVET:</b></font><br />&nbsp; ";
		echo "<input type='text' name='lenev' id='lenev' style='width:280px;' placeholder='Letöltés neve, 1-2 szó!' required><br /><br />";
		echo "<font face='Verdana' size='2' color='#000000'><b>Adjon hozzá leírást:</b></font><br />&nbsp; ";
		echo "<input type='text' name='leleiras' id='leleiras' style='width:280px;' placeholder='Egyszerű, rövid szöveg!' required><br /><br />";
		echo "<input type=submit value='mentés' class='btn btn-large btn-secondary'>";
		echo "</form><br>";
	}
	//letöltések kezelése
	if(isset($_GET["downmod"]))
	{
		$lekerdez=$pdo->query("select * from ".$elotag."_letoltesek");
		echo "<section id='tables'>";
		echo "<h3>Letöltések kezelése</h3>";
		echo "<a href='index.php?lng=".$webaktlang."&mod=y&ujdown=1' class='btn'>új fájl hozzáadása &raquo;</a><br><br>";
		if($lekerdez->rowCount()>0)
		{
			echo "<table class='table table-bordered table-striped table-highlight'>
					<thead>
					  <tr>
						<th>ID</th>
						<th>Letöltés neve</th>
						<th>Letöltés linkje</th>
						<th>Letöltés leírása</th>
						<th>Műveletek</th>
					  </tr>
					</thead>
					<tbody>";
			while($oldal=$lekerdez->fetch())
			{
				echo "<tr>
						<td>".$oldal["lekod"]."</td>
						<td>".$oldal["lenev"]."</td>
						<td><a href='../letoltesek/".$oldal["lelink"]."' target='_blank'>megtekintés &raquo;</a></td>
						<td>".$oldal["leleiras"]."</td>
						<td><a href='index.php?lng=".$webaktlang."&mod=y&downdel=".$oldal["lekod"]."'><i class='icon-trash'></i> törlés</a></td>
					   </tr>";
			}
			echo "</tbody>
				</table>";
		}
		else
		{
			echo "<h4>Még nem töltött fel egyetlen fájlt sem!</h4>";
		}
		echo "</section><br />";
	}
	//videó hozzáadása
	if(isset($_GET["ujvideo"]))
	{
		echo "<h2>Videótár - hozzáadás</h2>
		<form name='ujvidi' method='POST' action='index.php?lng=".$webaktlang."&mod=y' enctype='multipart/form-data'>
			<font face='Verdana' size='2' color='#000000'><b>Videó címe:</b></font><br><input type='text' name='videocim' id='videocim' style='width:400px;' placeholder='Videó címe'><br />
			<font face='Verdana' size='2' color='#000000'><b>Videó linkje:</b></font><br><input type='text' name='vhiv' id='vhiv' style='width:400px;' placeholder='Videó LINK-je a böngésző címsorából'><br />
			<input type='submit' value=' videó mentése ' class='btn btn-large btn-secondary'>
		</form>";
	}
	//sitemap - oldaltérkép készitése
	if(isset($_GET["createxml"]))
	{
		echo "<form action='index.php?lng=".$webaktlang."&mod=y' method='POST'>";
		echo "<h3>XML oldaltérkép készítése a keresőrobotok számára<br><small>(sitemap.xml készítése a főkönyvtárba, elérése: ".$absp."/sitemap.xml)</small></h3>";
		echo "<input type='hidden' name='xmlsitemap' value='1'>";
		echo "<input type='submit' value='készítés' class='btn btn-large btn-secondary'>";
		echo "</form>";
	}
	//google analytics készitése
	if(isset($_GET["ganal"]))
	{
		echo "<form action='index.php?lng=".$webaktlang."&mod=y' method='POST'>";
		echo "<h3>Google Analytics</h3>";
		echo "<font face='Verdana' size='2' color='#000000'><b>A követőkód megadása:</b></font><br><input type='text' name='ganalkey' id='ganalkey' style='width:400px;' placeholder='UA-1234567-8'><br />";
		echo "<input type='submit' value='MENTÉS' class='btn btn-large btn-secondary'>";
		echo "</form>";
	}
	//paraméterek beállítása
	if(isset($_GET["settings"]))
	{
		$betoltes=$pdo->query("select * from ".$elotag."_parameterek");
		$beallitasok=$betoltes->fetch();
		
		echo "<form action='index.php?lng=".$webaktlang."&mod=y' method='POST'>";
		echo "<h3>Weboldal paramétereinek szerkesztése:</h3><p>";
		echo "Címsor (TITLE):<br />&nbsp;&nbsp;&nbsp;<input type='text' name='title' value='".$beallitasok["title"]."' style='width:200px;' required><br />";
		echo "Kulcsszavak (KEYWORDS):<br />&nbsp;&nbsp;&nbsp;<input type='text' name='keywords' value='".$beallitasok["keywords"]."' style='width:200px;' required><br />";
		echo "META leírás (DESCRIPTION):<br />&nbsp;&nbsp;&nbsp;<input type='text' name='description' value='".$beallitasok["description"]."' style='width:200px;' required><br />";
		echo "Fejléc szöveg (SITENAME):<br />&nbsp;&nbsp;&nbsp;<input type='text' name='sitename' value='".$beallitasok["sitename"]."' style='width:200px;' required><br />";
		echo "Szlogen (SITESLOGEN):<br />&nbsp;&nbsp;&nbsp;<input type='text' name='siteslogen' value='".$beallitasok["siteslogen"]."' style='width:200px;' required><br />";
		echo "Copyright:<br />&nbsp;&nbsp;&nbsp;<input type='text' name='copyright' value='".$beallitasok["copyright"]."' style='width:200px;' required><br />";
		echo "Téma:<br />&nbsp;&nbsp;&nbsp;<select name='sablon' size='1' style='width:200px;'>";
		echo "<option value='".$beallitasok["sablon"]."'>".$beallitasok["sablon"]."</option>";
			$themes=opendir("../themes");
			while($fajl=readdir($themes))
			{
				if($fajl!="." and $fajl!=".." and is_dir("../themes/".$fajl))
				{
					echo "<option value='".$fajl."'>".$fajl."</option>";
				}
			}
		echo "</select></p>";
		echo "<br /><input type='submit' value='mentés' class='btn btn-large btn-secondary'></form><br>";
	}
}
else { echo 'ERROR!'; }
?>