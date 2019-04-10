<script src="https://www.google.com/recaptcha/api.js"></script>
<?php
$captcha="";
if(isset($_POST["g-recaptcha-response"])){
	$captcha=$_POST["g-recaptcha-response"];
}

$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LcpYwUTAAAAAPVTd2VpyoAsgG3izvEeIMcItx3c&response=".$captcha."&remoteip=".$_SERVER["REMOTE_ADDR"]);

if($captcha!="" AND $response.success!=false AND isset($_POST["email"]) AND $_POST["email"]!="")
{
	$targy="Üzenet a weboldalról!";
	$felado=trim($_POST["name"]);
	$email=trim($_POST["email"]);
	$phone=trim($_POST["telefonszam"]);
	$uzenet=trim($_POST["message"]);
	$mailcim  = "info@trswebdesign.hu";
	$headers  = "MIME-Version: 1.0" . "\r\n";    
	$headers .= "Content-type:text/html;charset=utf8" . "\r\n";   
	$headers .= "From: <".$email.">" . "\r\n";
	$ido = ("Beérkezett: ".date("Y.m.d. H:i:s", time())."\r\n\r\n");
	$level=mail ($mailcim, $targy, "<b>Üzenete érkezett!</b><br /><br />Az adatforgalmi figyelő értesít, hogy ".$felado." üzenetet írt az alábbiakban részletezett adatokkal.<br /><br /><b>Küldő adatai:</b><br />Név: ".$felado."<br />E-mail: ".$email."<br />Telefonszám: ".$phone."<br /><br />Üzenet:<br />" .$uzenet. "<br /><br /><br />" .$ido. "<br />",$headers);
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
	    <td>
			<div class="g-recaptcha" name="g-recaptcha" data-sitekey="6LcpYwUTAAAAAL-H7Vv9y73fuOik9A_aUC0JvHUX"></div>
		</td>
	  </tr>
	  <tr>
		<td colspan="2" align="center"><input type="submit" name="submit" value=" KÜLDÉS " /></td>
	  </tr>
	</table>
</form>