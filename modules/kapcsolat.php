<?php
session_start();
$kuldott="";
if(isset($_SESSION["titkos"]) AND $_SESSION["titkos"]!="" AND $_SESSION["titkos"]!=" " AND isset($_POST["csapta"]))
{
	foreach($_SESSION["titkos"] as $ujbetu)
	{
		$kuldott=$kuldott.$ujbetu;
	}
}
else
{
	$_SESSION["titkos"]="";
	/*** SAJÁT CSAPTA KÉSZITÉSE ***/
	$betuk=array("A","B","C","D","E","F","G","H","J","K","L","M","N","O","P","R","S","T","U","W","X","Y","Z","2","3","4","5","6","7","8","9");
	$betutomb=array();
	$titkos="";
	for($i=0;$i<6;$i++)
	{
		$velbetu=$betuk[rand(0,count($betuk)-1)];
		$titkos=$titkos.$velbetu;
		array_push($betutomb,$velbetu);
	}

	$_SESSION["titkos"]=$betutomb;
}

if($kuldott!="" AND $kuldott!=" " AND $kuldott==$_POST["csapta"] AND isset($_POST["email"]) AND $_POST["email"]!="")
{
	$targy="Üzenet a weboldalról!";
	$targyu="Köszönjük érdeklődését!";
	$felado=trim($_POST["name"]);
	$email=trim($_POST["email"]);
	$phone=trim($_POST["telefonszam"]);
	$uzenet=trim($_POST["message"]);
	$mailcim  = "info@trswebdesign.hu";
	$headers  = "MIME-Version: 1.0" . "\r\n";    
	$headers .= "Content-type:text/html;charset=utf-8" . "\r\n";   
	$headers .= "From: <".$email.">" . "\r\n";
	$ido = ("Beérkezett: ".date("Y.m.d. H:i:s", time())."\r\n\r\n");
	$level=mail ($mailcim, $targy, "<b>Üzenete érkezett!</b><br /><br />Az adatforgalmi figyelő értesít, hogy ".$felado." üzenetet írt az alábbiakban részletezett adatokkal.<br /><br /><b>Küldő adatai:</b><br />Név: ".$felado."<br />E-mail: ".$email."<br />Telefonszám: ".$phone."<br />Üzenet: ".$uzenet."<br /><br /><br />" .$ido. "<br />",$headers);
	//levél az ügyfélnek
	mail ($email, $targyu, "<b>Kedves ".$felado.".<br><br>Köszönjük, hogy ".$absp." weboldalunkról elküldte üzenetét, megkeresését.</b><br /><br />Hamarosan felvesszük Önnel a kapcsolatot, és segítünk megoldást találni kérésére.<br /><br />További szép napot.<br>" .$ido. "</font><br />",$headers);
	if($level)
	{
		print("
			<script type='text/javascript'>
				function atiranyit()
				{
					alert('Sikeres.');
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
				}
				ID = window.setTimeout('atiranyit();', 1*1);
			  </script>");
	}
}
?>
<h1>Küldjön üzenetet:</h1>
<form method="POST" id="sendemail">
	<table border="0" cellpadding="2" cellspacing="2">
	  <tr>
		<td><label for="nev">Név *:</label></td>
		<td><input type="text" id="nev" name="nev" required /></td>
	  </tr>
	  <tr>
		<td><label for="email">E-mail cím *:</label></td>
		<td><input type="email" id="email" name="email" required /></td>
	  </tr>
	  <tr>
		<td><label for="telefonszam">Telefonszám *:</label></td>
		<td><input type="text" id="telefonszam" name="telefonszam" required /></td>
	  </tr>
	  <tr>
		<td valign="top"><label for="message">Üzenet *:</label></td>
		<td><textarea id="message" name="message" rows="8" cols="50"></textarea></td>
	  </tr>
	  <tr>
	    <td valign="top"><label for="csapta">Grafikus kód *:</label></td>
		<td valign="top">
			<img src="modules/csapta.php"><br><br>
			<input type="text" name="csapta" id="csapta" placeholder="Adja meg a fentebb látható kódot" class="pix_text" required />
		</td>
	  </tr>
	  <tr>
		<td colspan="2" align="center"><input type="submit" name="submit" value=" KÜLDÉS " /></td>
	  </tr>
	</table>
</form>