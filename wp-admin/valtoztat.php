<?php
session_start();
if(isset($_SESSION["userlogged"]) AND $_SESSION["userlogged"]!="" AND $_SESSION["userlogged"]!=" ")
{
	//új menüpont hozzáadása
	if(isset($_REQUEST["ujmenu"]))
	{
		$sorszam=$pdo->query("select max(sorszam) as sorszam from ".$elotag."_menu_".$webaktlang);
		$illeszt=$sorszam->fetch();
		$ujsorszam=$illeszt["sorszam"]+1;
		echo "<h3>Új menüpont létrehozása</h3>";
		echo "<form action='index.php?lng=".$webaktlang."&mod=y' method='POST'>";
		echo "<font face='Verdana' size='2' color='#000000'><b>Írja be ide a menüpont nevét:</b></font><br />";
		echo "<input type='text' name='menunev' style='width:200px;' required><br /><br />";
		echo "<font face='Verdana' size='2' color='#000000'><b>Ha külső tartalomra mutat, add meg itt a linket:</b></font><br />";
		echo "<input type='text' name='tolink' style='width:200px;' value=''><br /><br />";
		echo "<input type='hidden' name='tartalom' value='Új weboldal tartalom mentve!'>";
		echo "<input type='hidden' name='sorszam' value='".$ujsorszam."'>";
		echo "<input type='submit' value='mentés' class='btn btn-large btn-secondary'></form>";
	}
	//menüpont sorszám módosítása
	if(isset($_REQUEST["menusormod"]))
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
	if(isset($_REQUEST["ujalmenu"]))
	{
		echo "<h3>Új almenüpont létrehozása</h3>";
		echo "<form action='index.php?lng=".$webaktlang."&mod=y' method='POST'>";
		echo "<font face='Verdana' size='2' color='#000000'><b>Írja be ide az almenüpont nevét:</b></font><br />";
		echo "<input type='text' name='almenunev' style='width:200px;' required><br /><br />";
		echo "<font face='Verdana' size='2' color='#000000'><b>Ha külső tartalomra mutat, add meg itt a linket:</b></font><br />";
		echo "<input type='text' name='tolink' style='width:200px;' value=''><br /><br />";
		echo "<input type='hidden' name='tartalom' value='Új almenü tartalom mentve!'>";
		echo "<font face='Verdana' size='2' color='#000000'><b>Szülőmenü:</b></font>";
		echo "<input type=hidden name='szulo' value='".$_REQUEST["ujalmenu"]."'>";
		$szulok=$pdo->query("select * from ".$elotag."_menu_".$webaktlang." where kod='".$_REQUEST["ujalmenu"]."'");
		$egy_szulo=$szulok->fetch();
		echo "<b>".$egy_szulo["nev"]."</b><br /><br />";
		echo "<input type='submit' value='mentés' class='btn btn-large btn-secondary'></form>";
	}
	//DOBOZOK blokkok kezelése
	if(isset($_REQUEST["blokkok"]))
	{
		$lekerdez=$pdo->query("select * from ".$elotag."_oldalsav_".$webaktlang."");
		echo "<h3>Dobozok blokkok kezelése</h3>";
		echo "<a href='index.php?lng=".$webaktlang."&mod=y&ujblokk=1' class='btn'>+ Új hozzáadása</a><br><br>";
		if($lekerdez->rowCount()>0)
		{

			while($oldal=$lekerdez->fetch())
			{
				echo "<table border='0'>
						<tr>
						<td>
							<h5><u>CÍM:</u> ".$oldal["cim"]."</h5>
							<a href='#myModal".$oldal["kod"]."' data-toggle='modal' class='btn'><i class='icon-eye-open'></i>  megtekintés</a> 
							".($oldal["aktiv"]=="1" ? "<a href='index.php?lng=".$webaktlang."&mod=y&blokkstop=".$oldal["kod"]."' class='btn'> <i class='fa fa-power-off' aria-hidden='true'></i>kikapcsolás</a> " : "<a href='index.php?lng=".$webaktlang."&mod=y&blokkstart=".$oldal["kod"]."' class='btn'><i class='fa fa-check-square-o' aria-hidden='true'></i> aktiválás</a> ")."
							<a href='index.php?lng=".$webaktlang."&mod=edit&blokkszerk=".$oldal["kod"]."' class='btn'><i class='icon-pencil'></i> szerkesztés</a> 
							<a href='index.php?lng=".$webaktlang."&mod=y&blokktorol=".$oldal["kod"]."' onclick=\"return confirm('Biztos törli a blokk-ot a tartalmával együtt?')\" class='btn'><i class='icon-trash'></i> törlés</a>
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
			echo "<h5>Még nincs doboz létrehozva!</h5>";
			echo "<a class='btn' href='index.php?lng=".$webaktlang."&mod=y&ujblokk=1'>új blokk létrehozása</a><br><br>";
		}
	}
	//új blokk hozzáadása
	if(isset($_REQUEST["ujblokk"]))
	{
		$sorszam=$pdo->query("select max(sorszam) as sorszam from ".$elotag."_oldalsav_".$webaktlang."");
		$illeszt=$sorszam->fetch();
		$ujsorszam=$illeszt["sorszam"]+1;
		echo "<h4>Doboz hozzáadása</h4>";
		echo "<form action='index.php?lng=".$webaktlang."&mod=y' method='POST'>";
		echo "<font face='Verdana' size='2' color='#000000'><b>Írja be ide a doboz címét:</b></font><br />";
		echo "<input type='hidden' name='szoveg' value='<p><center><b>Új doboz tartalom mentve!</b></center></p>'>";
		echo "<input type='text' name='blokknev' style='width:200px;' required><br /><br />";
		echo "<input type='hidden' name='sorszam' value='".$ujsorszam."'>";
		echo "<input type='submit' value='mentés' class='btn btn-large btn-secondary'></form>";
	}
	//blokk névváltoztatás
	if(isset($_REQUEST["blokkmod"]))
	{
		$lekerdez=$pdo->query("select * from ".$elotag."_oldalsav_".$webaktlang." where kod='".$_REQUEST["blokkmod"]."'");
		$oldalsav=$lekerdez->fetch();
		$blokkcim=str_replace(" ","&nbsp;",$oldalsav["cim"]);

		echo "<br /><form action='index.php?lng=".$webaktlang."&mod=y' method='POST'>";
		echo "<font face='Verdana' size='2' color='#000000'><b>Írja be ide a doboz címét:</b></font><br />";
		echo "<input type='hidden' name='kod' value='".$_REQUEST["blokkmod"]."'>";
		echo "<input type='text' name='cim' value='".$blokkcim."' style='width:200px;' required><br /><br />";
		echo "<input type='submit' value='mentés' class='btn btn-large btn-secondary'></form>";
	}
	//blokk sorszám módosítása
	if(isset($_REQUEST["blokksormod"]))
	{
		$lekerdez=$pdo->query("select * from ".$elotag."_oldalsav_".$webaktlang." order by sorszam");
			$lastblokk=$pdo->query("select max(sorszam) as utso from ".$elotag."_oldalsav_".$webaktlang."");
			$meghataroz=$lastblokk->fetch();
		echo "<br /><font face='Verdana' size='2' color=#000000><b>Dobozok sorrendje:</b></font><br /><br />";
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
	if(isset($_REQUEST["ujcikk"]))
	{
		echo "<h4>Bejegyzés, hírcikk hozzáadása</h4>";
		echo "<form action='index.php?lng=".$webaktlang."&mod=y' method='POST'>";
		echo "<font face='Verdana' size='2' color='#000000'><b>Létrehozandó hír címe:</b></font><br />";
		echo "<input type='hidden' name='szoveg' value='<p><center><b>Új hír létrehozva!</b></center></p>'>";
		echo "<input type='text' name='hircim' required><br /><br />";
		echo "<input type=submit value='mentés' class='btn btn-large btn-secondary'></form>";
	}
	//új SLIDER bokk hozzáadása
	if(isset($_REQUEST["ujslider"]))
	{
		$foo=array();
		$lekerdez=$pdo->query("select slidersor from ".$elotag."_slider");
		while($sorszamok=$lekerdez->fetch())
		{
			array_push($foo, $sorszamok["slidersor"]);
		}
		
		if(empty($foo))
		{
			$lastslidid=1;
		}
		else
		{
			$aktid=max($foo);
			$lastslidid=$aktid+1;
		}
		
		echo "<h3>Képváltó kezelése</h3>";
		echo "<h4>Új képváltó hozzáadása</h4>";
		echo "<form action='index.php?lng=".$webaktlang."&mod=y' method='POST' enctype='multipart/form-data'>";
		echo "<font face='Verdana' size='2' color='#000000'><b>Töltsön fel egy képet:</b><br /></font>";
		echo "<input type='file' name='ujsliderkep' id='ujsliderkep' required><br /><br />";
		echo "<font face='Verdana' size='2' color='#000000'><b>Képváltó első sora:</b><br><small>(ha a képváltó tartalmazza)</small></font><br />";
		echo "<input type='text' name='dumahozza' id='dumahozza' style='width:280px;' placeholder='Egyszerű, rövid szöveg!' value=''><br /><br />";
		echo "<font face='Verdana' size='2' color='#000000'><b>Képváltó második sora:</b><br><small>(ha a képváltó tartalmazza)</small></font><br />";
		echo "<input type='text' name='hivatkozas' id='hivatkozas' style='width:280px;' placeholder='Egyszerű, rövid szöveg!' value=''><br /><br />";
		echo "<font face='Verdana' size='2' color='#000000'><b>Képváltó elem/gomb neve:</b><br><small>(ha a képváltó tartalmazza)</small></font><br />";
		echo "<input type='text' name='gombnev' id='gombnev' style='width:280px;' placeholder='pl: MEGNYITÁS'><br /><br />";
		echo "<font face='Verdana' size='2' color='#000000'><b>Képváltó elem/gomb hivatkozása:</b><br><small>(ha a képváltó tartalmazza)</small></font><br />";
		echo "<input type='text' name='gomblink' id='gomblink' style='width:280px;' placeholder='Teljes URL, link!' value=''><br /><br />";
		echo "<font face='Verdana' size='2' color='#000000'><b>Képváltó elem sorszáma:</b></font><br />";
		echo "<input type='number' name='slidersor' id='slidersor' style='width:280px;' value='".$lastslidid."' required><br /><br />";
		echo "<input type=submit value='mentés' class='btn btn-large btn-secondary'></form>";
	}
	//SLIDER blokk szerkesztése
	if(isset($_REQUEST["slidermod"]))
	{
		$lekerdez=$pdo->query("select * from ".$elotag."_slider where sliderkod='".$_REQUEST["slidermod"]."'");
		$data=$lekerdez->fetch();
		echo "<h3>Képváltó kezelése</h3>";
		echo "<h4>Képváltó elem szerkesztése</h4>";
		echo "<form action='index.php?lng=".$webaktlang."&mod=y' method='POST' enctype='multipart/form-data'>";
		echo "<input type='hidden' name='sliderkodmod' id='sliderkodmod' value='".$_REQUEST["slidermod"]."'>";
		echo "<font face='Verdana' size='2' color='#000000'><b>Töltsön fel egy képet:</b><br><small>(ha a képváltó képét cserélni akarja)</small><br /></font>";
		echo "<input type='file' name='modsliderkep' id='modsliderkep'><br /><br />";
		echo "<font face='Verdana' size='2' color='#000000'><b>Képváltó első sora:</b><br><small>(ha a képváltó tartalmazza)</small></font><br />";
		echo "<input type='text' name='dumahozza' id='dumahozza' style='width:280px;' placeholder='Egyszerű, rövid szöveg!' value='".$data["dumahozza"]."'><br /><br />";
		echo "<font face='Verdana' size='2' color='#000000'><b>Képváltó második sora:</b><br><small>(ha a képváltó tartalmazza)</small></font><br />";
		echo "<input type='text' name='hivatkozas' id='hivatkozas' style='width:280px;' placeholder='Egyszerű, rövid szöveg!' value='".$data["hiperlink"]."'><br /><br />";
		echo "<font face='Verdana' size='2' color='#000000'><b>Képváltó elem/gomb neve:</b><br><small>(ha a képváltó tartalmazza)</small></font><br />";
		echo "<input type='text' name='gombnev' id='gombnev' style='width:280px;' placeholder='pl: MEGNYITÁS' value='".$data["gombnev"]."'><br /><br />";
		echo "<font face='Verdana' size='2' color='#000000'><b>Képváltó elem/gomb hivatkozása:</b><br><small>(ha a képváltó tartalmazza)</small></font><br />";
		echo "<input type='text' name='gomblink' id='gomblink' style='width:280px;' placeholder='Teljes URL, link!' value='".$data["gomblink"]."'><br /><br />";
		echo "<font face='Verdana' size='2' color='#000000'><b>Képváltó elem sorszáma:</b></font><br />";
		echo "<input type='number' name='slidersor' id='slidersor' style='width:280px;' value='".$data["slidersor"]."' required><br /><br />";
		echo "<input type=submit value='mentés' class='btn btn-large btn-secondary'></form>";
	}
	//SLIDER blokkok kezelése
	if(isset($_REQUEST["sliderek"]))
	{
		echo "<h3>Képváltó kezelése</h3>";
		echo "<a href='index.php?lng=".$webaktlang."&mod=y&ujslider=1' class='btn'>+ Új hozzáadása</a><br><br>";
		echo "<table border='0'>";
		$lekerdez=$pdo->query("select * from ".$elotag."_slider");
		if($lekerdez->rowCount()>0)
		{
			while($oldal=$lekerdez->fetch())
			{
				echo "<tr><td><a class='btn' href='index.php?lng=".$webaktlang."&mod=y&sliderdel=".$oldal["sliderkod"]."' onclick=\"return confirm('Biztos törlöd a mappát?')\"><i class='icon-trash'></i> TÖRLÉS</a> &nbsp; <a class='btn' href='index.php?lng=".$webaktlang."&mod=y&slidermod=".$oldal["sliderkod"]."'><i class='icon-edit'></i> MÓDOSÍTÁS</a><br /><br />
					<b>Első sor szövege:</b> ".($oldal["dumahozza"]!="" ? $oldal["dumahozza"] : "nincs megadva")."<br />
					<b>Második sor szövege:</b> ".($oldal["hiperlink"]!="" ? $oldal["hiperlink"] : "nincs megadva")."<br />
					<b>Gomb/elem neve:</b> ".($oldal["gombnev"]!="" ? $oldal["gombnev"] : "nincs megadva")."<br />
					<b>Gomb/elem hivatkozása:</b> ".($oldal["gomblink"]!="" ? $oldal["gomblink"] : "nincs megadva")."<br />
					<b>Képváltó adat sorszáma:</b> ".$oldal["slidersor"]."<br /><br />
					<img src='../slider/".$oldal["slidert"]."' border='0' width='650' data-pin-nopin='true'></td></tr><tr><td><hr></td></tr>";
			}
		}
		else
		{
			echo "<tr><td><h4>Még nincs feltöltve...</h4></td></tr>";
		}
		echo "</table><br />";
	}
	//felhasználói adatok módosítása
	if(isset($_REQUEST["usermod"]))
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
	//új felhasználó hozzáadása
	if(isset($_REQUEST["newuser"]))
	{
		echo "<h3>Felhasználó hozzáadása:</h3>";
		echo "<form action='index.php?lng=".$webaktlang."&mod=y' method='POST'>";
		echo "<big>Felhasználónév:</big><br>&nbsp; <input type='text' name='newadminnev' placeholder='adja meg felhasználónevét'><br>";
		echo "<big>E-mail cím:</big><br>&nbsp; <input type='text' name='newemailcim' placeholder='adja meg e-mail címét'><br>";
		echo "<big>Jelszó:</big><br>&nbsp; <input type='password' name='newadminpass' placeholder='adja meg jelszavát' pattern='.{3,}' minlength='5' required><br><br>";
		echo "<input type='submit' value='hozzáadás' class='btn btn-large btn-secondary'>";
		echo "</form><br />";
	}
	//új nyelv hozzáadása
	if(isset($_REQUEST["ujnyelv"]))
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
	if(isset($_REQUEST["social"]))
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
	if(isset($_REQUEST["gmaps"]))
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
	if(isset($_REQUEST["ujdown"]))
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
	if(isset($_REQUEST["downmod"]))
	{
		$lekerdez=$pdo->query("select * from ".$elotag."_letoltesek");
		echo "<section id='tables'>";
		echo "<h3>Letöltések kezelése</h3>";
		echo "<a href='index.php?lng=".$webaktlang."&mod=y&ujdown=1' class='btn'>+ új fájl hozzáadása &raquo;</a><br><br>";
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
	if(isset($_REQUEST["ujvideo"]))
	{
		?>
			<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
			<script src="ckeditor/adapters/jquery.js"></script>
			<script>
				CKEDITOR.env.isCompatible = true;
			</script>
		<?php
		echo "<h2>Videótár - hozzáadás</h2>
		<form name='ujvidi' method='POST' action='index.php?lng=".$webaktlang."&mod=y' enctype='multipart/form-data'>
			<font face='Verdana' size='2' color='#000000'><b>Videó címe:</b></font><br><input type='text' name='ujvideocim' id='ujvideocim' style='width:400px;' placeholder='Videó címe'><br />
			<font face='Verdana' size='2' color='#000000'><b>Videó linkje:</b></font><br><input type='text' name='vhiv' id='vhiv' style='width:400px;' placeholder='Videó LINK-je a böngésző címsorából'><br />
			<font face='Verdana' size='2' color='#000000'><b>Videó leírása:</b></font><br><textarea name='vtext' style='width:400px;' placeholder='Oktató anyag, vagy leírás a videóról'></textarea><br />
			<input type='submit' value=' videó mentése ' class='btn btn-large btn-secondary'>
		</form>";
		?>
		<script>
			CKEDITOR.replace( 'vtext', {
				language: 'hu',
				toolbar : 'Full'
			});
		</script>
		<?php
	}
	//videó módosítása
	if(isset($_REQUEST["videomod"]))
	{
		?>
			<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
			<script src="ckeditor/adapters/jquery.js"></script>
			<script>
				CKEDITOR.env.isCompatible = true;
			</script>
		<?php
		$videok=$pdo->query("select * from ".$elotag."_videok where videokod='".$_REQUEST["videomod"]."'");
		$v=$videok->fetch();
		echo "<h2>Videótár - módosítás</h2>
		<form name='modvidi' method='POST' action='index.php?lng=".$webaktlang."&mod=y' enctype='multipart/form-data'>
			<input type='hidden' name='videomodkod' value='".$_REQUEST["videomod"]."'>
			<font face='Verdana' size='2' color='#000000'><b>Videó címe:</b></font><br><input type='text' name='videocim' id='videocim' style='width:400px;' value='".$v["videocim"]."' placeholder='Videó címe'><br />
			<font face='Verdana' size='2' color='#000000'><b>Videó linkje:</b></font><br><input type='text' name='vhiv' id='vhiv' style='width:400px;' value='".$v["vhiv"]."' placeholder='Videó LINK-je a böngésző címsorából'><br />
			<font face='Verdana' size='2' color='#000000'><b>Videó leírása:</b></font><br><textarea name='vtext'style='width:400px;'>".$v["vtext"]."</textarea><br />
			<input type='submit' value=' videó mentése ' class='btn btn-large btn-secondary'>
		</form>";
		?>
		<script>
			CKEDITOR.replace( 'vtext', {
				language: 'hu',
				toolbar : 'Full'
			});
		</script>
		<?php
	}
	//sitemap - oldaltérkép készitése
	if(isset($_REQUEST["createxml"]))
	{
		echo "<form action='index.php?lng=".$webaktlang."&mod=y' method='POST'>";
		echo "<h3>XML oldaltérkép készítése a keresőrobotok számára<br><small>(sitemap.xml készítése a főkönyvtárba, elérése: ".$absp."/sitemap.xml)</small></h3>";
		echo "<input type='hidden' name='xmlsitemap' value='1'>";
		echo "<input type='submit' value='készítés' class='btn btn-large btn-secondary'>";
		echo "</form>";
	}
	//GDPR dokumentáció feltöltése
	if(isset($_REQUEST["gdpr"]))
	{
		echo "<form action='index.php?lng=".$webaktlang."&mod=y' method='POST' enctype='multipart/form-data'>";
		echo "<h3>GDPR adatvédelmi tájékoztató feltöltése<br><small>(Kizárólag PDF állomány tölthető fel!)</small></h3>";
		$gdprdok=$pdo->query("select * from ".$elotag."_parameterek");
		$g=$gdprdok->fetch();
		if($g["gdpr"]!="")
		{
			echo "<p><small>Jelenlegi adatvédelmi tájékoztató elérhető itt: <a href='".$absp."/".$g["gdpr"]."' target='_blank'><i class='fa fa-eye'> </i> megtekintés</a> | <a href='index.php?lng=".$webaktlang."&mod=y&delgdpr=1' onclick=\"return confirm('Biztos törli az eddig feltöltött GDPR dokumentációt?')\"><i class='fa fa-trash'> </i> törlés</a></small></p><br>";
		}
		echo "<font face='Verdana' size='2' color='#000000'><b>Tallózza be a PDF fájlt:</b></font> <input type='file' name='gdprdok'><br><br>";
		echo "<input type='submit' value='feltöltés' class='btn btn-large btn-secondary'>";
		echo "</form>";
	}
	//google analytics készitése
	if(isset($_REQUEST["ganal"]))
	{
		$leker=$pdo->query("select * from ".$elotag."_ganal");
		$gl=$leker->fetch();
		echo "<form action='index.php?lng=".$webaktlang."&mod=y' method='POST'>";
		echo "<h3>Google Analytics</h3>";
		echo "<font face='Verdana' size='2' color='#000000'><b>A követőkód megadása:</b></font><br><input type='text' name='ganalkey' id='ganalkey' style='width:400px;' placeholder='UA-1234567-8' value='".$gl["ganalkey"]."'><br />";
		echo "<input type='submit' value='MENTÉS' class='btn btn-large btn-secondary'>";
		echo "</form>";
	}
	//paraméterek beállítása
	if(isset($_REQUEST["settings"]))
	{
		$betoltes=$pdo->query("select * from ".$elotag."_parameterek");
		$beallitasok=$betoltes->fetch();
		
		echo "<form action='index.php?lng=".$webaktlang."&mod=y' method='POST' enctype='multipart/form-data'>";
		echo "<h3>Weboldal paramétereinek szerkesztése:</h3><p>";
		echo "Címsor (TITLE):<br />&nbsp;&nbsp;&nbsp;<input type='text' name='title' value='".$beallitasok["title"]."' style='width:200px;' required><br />";
		echo "Kulcsszavak (KEYWORDS):<br />&nbsp;&nbsp;&nbsp;<input type='text' name='keywords' value='".$beallitasok["keywords"]."' style='width:200px;' required><br />";
		echo "META leírás (DESCRIPTION):<br />&nbsp;&nbsp;&nbsp;<input type='text' name='description' value='".$beallitasok["description"]."' style='width:200px;' required><br />";
		echo "Fejléc szöveg (SITENAME):<br />&nbsp;&nbsp;&nbsp;<input type='text' name='sitename' value='".$beallitasok["sitename"]."' style='width:200px;' required><br />";
		echo "Szlogen (SITESLOGEN):<br />&nbsp;&nbsp;&nbsp;<input type='text' name='siteslogen' value='".$beallitasok["siteslogen"]."' style='width:200px;' required><br />";
		echo "Megosztási kép (OG:IMG):<br />&nbsp;&nbsp;&nbsp;<input type='file' name='ogimage' style='width:200px;'><br />";
		if($beallitasok["ogimage"]!="")
		{
			echo '<img src="/'.$beallitasok["ogimage"].'" class="img-responsive" style="max-width:250px !important;"><br>';
		}
		echo "Copyright:<br />&nbsp;&nbsp;&nbsp;<input type='text' name='copyright' value='".$beallitasok["copyright"]."' style='width:200px;' required><br />";
		echo "Téma:<br />&nbsp;&nbsp;&nbsp;<select name='sablon' size='1' style='width:200px;'>";
			$themes=opendir("../themes");
			while($fajl=readdir($themes))
			{
				if($fajl!="." and $fajl!=".." and is_dir("../themes/".$fajl))
				{
					echo "<option value='".$fajl."' ".($beallitasok["sablon"]==$fajl ? "selected" : "").">".$fajl."</option>";
				}
			}
		echo "</select></p>";
		echo "<br /><input type='submit' value='mentés' class='btn btn-large btn-secondary'></form><br>";
	}
	//root modulok telepítése
	if(isset($_REQUEST["rootmodul"]) AND $_SESSION["userlogged"]=="nimda")
	{
		echo "<form name='root-module' action='index.php?lng=".$webaktlang."&mod=y' method='POST'>";
			echo '<input type="hidden" name="modulinstall" value="root">';
			echo "<h4>Weboldal MODULOK telepítése:</h4>";
			$bt1=$pdo->query("select * from ".$elotag."_modulok where modulnev='slider'");
			$md1=$bt1->fetch();
			echo "<label for='slidermodul'>Slider: (".($md1["bekapcsolva"]=="igen" ? "már telepítve" : "nincs telepítve").")</label>
				<select name='slidermodul' id='slidermodul' size='1'><option value='igen'>Telepítem</option><option value='nem'>nem kérem</option></select><br />";
			$bt2=$pdo->query("select * from ".$elotag."_modulok where modulnev='galeria'");
			$md2=$bt2->fetch();
			echo "<label for='galeriamodul'>Galéria: (".($md2["bekapcsolva"]=="igen" ? "már telepítve" : "nincs telepítve").")</label>
				<select name='galeriamodul' id='galeriamodul' size='1'><option value='igen'>Telepítem</option><option value='nem'>nem kérem</option></select><br />";
			$bt3=$pdo->query("select * from ".$elotag."_modulok where modulnev='video'");
			$md3=$bt3->fetch();
			echo "<label for='videomodul'>Videók: (".($md3["bekapcsolva"]=="igen" ? "már telepítve" : "nincs telepítve").")</label>
				<select name='videomodul' id='videomodul' size='1'><option value='igen'>Telepítem</option><option value='nem'>nem kérem</option></select><br />";
			$bt4=$pdo->query("select * from ".$elotag."_modulok where modulnev='blog'");
			$md4=$bt4->fetch();
			echo "<label for='hirekmodul'>Blog: (".($md4["bekapcsolva"]=="igen" ? "már telepítve" : "nincs telepítve").")</label>
				<select name='hirekmodul' id='hirekmodul' size='1'><option value='igen'>Telepítem</option><option value='nem'>nem kérem</option></select><br />";
			$bt5=$pdo->query("select * from ".$elotag."_modulok where modulnev='social'");
			$md5=$bt5->fetch();
			echo "<label for='socialmod'>Közösségi portálok: (".($md5["bekapcsolva"]=="igen" ? "már telepítve" : "nincs telepítve").")</label>
				<select name='socialmod' id='socialmod' size='1'><option value='igen'>Telepítem</option><option value='nem'>nem kérem</option></select><br />";
			$bt6=$pdo->query("select * from ".$elotag."_modulok where modulnev='gmaps'");
			$md6=$bt6->fetch();
			echo "<label for='gmaps'>Google térkép: (".($md6["bekapcsolva"]=="igen" ? "már telepítve" : "nincs telepítve").")</label>
				<select name='gmaps' id='gmaps' size='1'><option value='igen'>Telepítem</option><option value='nem'>nem kérem</option></select><br />";
			$bt7=$pdo->query("select * from ".$elotag."_modulok where modulnev='letoltes'");
			$md7=$bt7->fetch();
			echo "<label for='downmodul'>Letöltések modul: (".($md7["bekapcsolva"]=="igen" ? "már telepítve" : "nincs telepítve").")</label>
				<select name='downmodul' id='downmodul' size='1'><option value='igen'>Telepítem</option><option value='nem'>nem kérem</option></select><br />";
			$bt8=$pdo->query("select * from ".$elotag."_modulok where modulnev='shop'");
			$md8=$bt8->fetch();
			echo "<label for='shopmodul'>WEBSHOP: (".($md8["bekapcsolva"]=="igen" ? "már telepítve" : "nincs telepítve").")</label>
				<select name='shopmodul' id='shopmodul' size='1'><option value='igen'>Telepítem</option><option value='nem'>nem kérem</option></select><br /><br />";
			echo '<input type="submit" value="mentés" class="btn btn-large btn-secondary">';
		echo "</form>";
	}
	//alaprendszer frissítése
	if(isset($_REQUEST["sysupd"]))
	{
		if(file_exists("update.php"))
		{
			echo "<h3>A rendszer frissítések ellenőrzése és végrehajtása, kis türelmet!</h3><br><br>";
			include("update.php");
		}
		else
		{
			echo '<h3>A rendszer a jelenlegi legfrissebb állapotban van!</h3>';
			echo '<a href="index.php?lng='.$webaktlang.'" class="btn btn-large btn-secondary">Rendben</a>';
		}
	}
}
else { echo 'ERROR!'; }
?>