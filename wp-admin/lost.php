<?php
	if(isset($_POST["username"]) AND isset($_POST["usermail"]))
	{
		echo '<div class="account-container stacked">
				<div class="content clearfix">
					<h1>Elfelejtett jelszó</h1>';	
					if($_POST["username"]!="" AND $_POST["username"]!=" "  AND $_POST["usermail"]!="" AND $_POST["usermail"]!=" ")
					{
						$losted=$pdo->prepare("select * from ".$elotag."_admin where nev=? and email=? ");
						$losted->execute(array($_POST["username"],$_POST["usermail"]));
						if($losted->rowCount()>0)
						{
							$targy="Új jelszó kérése a ".$absp." weboldal adminisztrációs felületéhez";
							$mailcim  = $_POST["usermail"];
							$headers  = "MIME-Version: 1.0" . "\r\n";    
							$headers .= "Content-type:text/html;charset=utf8" . "\r\n";   
							$headers .= "From: <noreply@kek-admin.hu>" . "\r\n";
							$ido = ("Kérelem érkezett: ".date("Y.m.d. H:i:s", time())."\r\n\r\n");
							$level=mail ($mailcim, $targy, "<b>ÚJ JELSZÓ IGÉNYLÉS!</b><br /><br />Az adatforgalmi figyelő értesít, hogy új jelszót kértél a weboldalad adminisztrációs felületéhez.<br /><br />
								<b>Weboldalad adatai:</b><br />URL link: ".$absp."<br /><br />Az új jelszavad az alábbi linkre való kattintással tudod biztonságosan igényelni:<br />
								<a href='".$absp."/wp-admin/index.php?lost=1&lpwd=".md5($_POST["usermail"])."'>KÉREM AZ ÚJ JELSZÓT</a><br><br />
								Ha nem te voltál az aki az új jelszót igényelte, akkor ezt az üzenetet nyugodtan hagyd figyelmen kivül, nincs teendőd, védett a weboldalad.<br><br>" .$ido. "<br />",$headers);
							if($level)
							{
								print("
									<script type='text/javascript'>
										function atiranyit()
										{
											alert('Sikeres, nézd meg a postafiókod.');
											location.href = 'index.php';
										}
										ID = window.setTimeout('atiranyit();', 1*1);
									</script>
								");
							}
							else
							{
								print("<script type='text/javascript'>
										function atiranyit()
										{
											alert('Hiba történt!');
											location.href = 'index.php';
										}
										ID = window.setTimeout('atiranyit();', 1*1);
									  </script>");
							}
						}
						else
						{
							echo '<p><strong>Sajnos valamelyik adat nem helyes, kérjük próbáld meg újra!</strong></p>';
						}
					}
					else
					{
						echo '<p><strong>Sajnos valamelyik mező üresen maradt!</strong></p>';
					}
		echo '		<br><br><a href="index.php" class="btn-info btn-sm">&nbsp; VISSZA A BELÉPÉSHEZ &nbsp;</a> <a href="index.php" class="btn-warning btn-sm">&nbsp; VISSZA A JELSZÓ KÉRÉSHEZ &nbsp;</a>
				</div>
			</div>';
	}
	elseif(isset($_REQUEST["lpwd"]) AND $_REQUEST["lpwd"]!="" AND $_REQUEST["lpwd"]!=" ")
	{
		echo '<div class="account-container stacked">
				<div class="content clearfix">
					<h1>Elfelejtett jelszó</h1>';
		$beload=$pdo->query("select *,md5(email) as 'mailmd5' from ".$elotag."_admin having mailmd5='".$_REQUEST["lpwd"]."' ");
		if($beload->rowCount()>0)
		{
			$e=$beload->fetch();
			$emailja=$e["email"];
			$ujjelszo=generateRandomString(6);
			$bejegyzes=$pdo->query("update ".$elotag."_admin set jelszo='".md5($ujjelszo)."' where email='".$emailja."'");
			if($bejegyzes)
			{
				$targy="Új jelszó készítése a ".$absp." weboldal adminisztrációs felületéhez";
				$mailcim  = $emailja;
				$headers  = "MIME-Version: 1.0" . "\r\n";    
				$headers .= "Content-type:text/html;charset=utf8" . "\r\n";   
				$headers .= "From: <noreply@kek-admin.hu>" . "\r\n";
				$ido = ("Generálva: ".date("Y.m.d. H:i:s", time())."\r\n\r\n");
				$level=mail ($mailcim, $targy, "<b>ÚJ JELSZÓ KÉSZÍTÉS!</b><br /><br />Az adatforgalmi figyelő értesít, hogy új jelszót generáltunk a weboldalad adminisztrációs felületéhez.<br /><br />
					<b>Weboldalad adatai:</b><br />URL link: ".$absp."<br /><br />Az új jelszavad az alábbi ".$ujjelszo."<br />Kérlek jegyezd fel jól!<br><br>
					Az alábbi linkre kattintva ki is próbálhatod az új jelszavad: <a href='".$absp."/wp-admin/index.php'>BEJELENTKEZÉS</a><br><br /><br>" .$ido. "<br />",$headers);
				if($level)
				{
					print("
						<script type='text/javascript'>
							function atiranyit()
							{
								alert('Sikeres.');
								location.href = 'index.php';
							}
							ID = window.setTimeout('atiranyit();', 1*1);
						</script>
					");
				}
				else
				{
					print("<script type='text/javascript'>
							function atiranyit()
							{
								alert('Hiba történt!');
								location.href = 'index.php';
							}
							ID = window.setTimeout('atiranyit();', 1*1);
						  </script>");
				}
			}
			else
			{
				echo '<p><strong>Sajnos adatbázis hiba történt, az új jelszavad elmentése sikertelen volt; kérjük igényeld újra azt.!</strong></p>';
			}
		}
		else
		{
			echo '<p><strong>Sajnos valamelyik adat nem stimmelt, így nem tudtunk neked új jelszavat generálni. Kérlek próbáld újra később!</strong></p>';
		}
		echo '		<br><br><a href="index.php" class="btn-info btn-sm">&nbsp; VISSZA A BELÉPÉSHEZ &nbsp;</a> <a href="index.php" class="btn-warning btn-sm">&nbsp; VISSZA A JELSZÓ KÉRÉSHEZ &nbsp;</a>
				</div>
			</div>';
	}
	else
	{
?>
<div class="account-container stacked">
	<div class="content clearfix">
		<form method="POST" />
			<h1>Elfelejtett jelszó</h1>		
			<div class="login-fields">
				<p>Kérem adja meg a telepítési adatait:</p>
				<?php echo $error; ?>
				<div class="field">
					<label for="username">Felhasználónév:</label>
					<input type="text" id="username" name="username" value="" placeholder="felhasználónév" class="login username-field" />
				</div>
				<div class="field">
					<label for="usermail">Jelszó:</label>
					<input type="email" id="usermail" name="usermail" value="" placeholder="regisztrált email cím" class="login password-field" />
				</div>
			</div>
			<div class="login-actions">
				<button class="button btn btn-warning btn-large">ÚJ JELSZÓ KÉRÉSE</button>
			</div>
		</form><br>
		<a href="index.php" class="btn-info btn-sm">&nbsp; VISSZA A BELÉPÉSHEZ &nbsp;</a>
	</div>
</div>
<?php
	}
?>