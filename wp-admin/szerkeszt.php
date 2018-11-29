<?php
session_start();
if(isset($_SESSION["userlogged"]) AND $_SESSION["userlogged"]!="" AND $_SESSION["userlogged"]!=" ")
{
?>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script src="ckeditor/adapters/jquery.js"></script>
<script>
    CKEDITOR.env.isCompatible = true;
</script>
<form method="POST" action="mentes.php?lng=<?php print($webaktlang); ?>" enctype="multipart/form-data">
<?php
//cimek mutatása
if(isset($_GET["modosit"]))
{
	$lekerdez=$pdo->query("select * from ".$elotag."_menu_".$webaktlang." where kod='".$_GET["modosit"]."'");
	$oldal=$lekerdez->fetch();
	echo "<p align='left'><big><b><u>Menüpont címe:</u></b></big><br><input type='text' name='mfnev' value='".$oldal["nev"]."'></p>";
	echo "<p align='left'><big><b><u>Meta TITLE:</u></b></big><br><input type='text' name='metatitle' value='".$oldal["metatitle"]."'></p>";
	echo "<p align='left'><big><b><u>Meta KEYWORDS:</u></b></big><br><input type='text' name='metakeywords' value='".$oldal["metakeywords"]."'></p>";
	echo "<p align='left'><big><b><u>Meta DESCRIPTION:</u></b></big><br><input type='text' name='metadesc' value='".$oldal["metadesc"]."'></p><br />";
}
elseif(isset($_GET["almodosit"]))
{
	$lekerdez=$pdo->query("select * from ".$elotag."_almenu_".$webaktlang." where kod='".$_GET["almodosit"]."'");
	$oldal=$lekerdez->fetch();
	echo "<p align='left'><big><b><u>Almenüpont címe:</u></b></big><br><input type='text' name='manev' value='".$oldal["nev"]."'></p>";
	echo "<p align='left'><big><b><u>Meta TITLE:</u></b></big><br><input type='text' name='metatitle' value='".$oldal["metatitle"]."'></p>";
	echo "<p align='left'><big><b><u>Meta KEYWORDS:</u></b></big><br><input type='text' name='metakeywords' value='".$oldal["metakeywords"]."'></p>";
	echo "<p align='left'><big><b><u>Meta DESCRIPTION:</u></b></big><br><input type='text' name='metadesc' value='".$oldal["metadesc"]."'></p><br />";
}
elseif(isset($_GET["blokkszerk"]))
{
	$lekerdez=$pdo->query("select * from ".$elotag."_oldalsav_".$webaktlang." where kod='".$_GET["blokkszerk"]."'");
	$blokk=$lekerdez->fetch();
	echo "<p align='left'><big><b><u>Blokk címe:</u></b></big><br><input type='text' name='bcim' value='".$blokk["cim"]."'></p><br />";
}
elseif(isset($_GET["cikkmod"]))
{
	$lekerdez=$pdo->query("select * from ".$elotag."_hirkezelo_".$webaktlang." where hirkod='".$_GET["cikkmod"]."'");
	$cikk=$lekerdez->fetch();
	echo "<p align='left'><big><b><u>Cikk címe:</u></b></big><br><input type='text' name='ccim' value='".$cikk["cim"]."'></p>";
	echo "<p align='left'><big><b><u>Cikk előzetese:</u></b></big><br><input type='text' name='bevezeto' value='".$cikk["bevezeto"]."'></p>";
	echo "<p align='left'><big><b><u>Cikk címkék <small>(vesszővel elválasztva)</small>:</u></b></big><br><input type='text' name='tags' value='".$cikk["tags"]."'></p>";
	echo "<p align='left'><big><b><u>Cikk kis képe:</u></b></big><br><small>Ha raksz be képet, azzal lecseréled az előzőt!</small><br><input type='file' name='kiskep'></p><br />";
	echo "<p align='left'><big><b><u>Meta TITLE:</u></b></big><br><input type='text' name='metatitle' value='".$cikk["metatitle"]."'></p>";
	echo "<p align='left'><big><b><u>Meta KEYWORDS:</u></b></big><br><input type='text' name='metakeywords' value='".$cikk["metakeywords"]."'></p>";
	echo "<p align='left'><big><b><u>Meta DESCRIPTION:</u></b></big><br><input type='text' name='metadesc' value='".$cikk["metadesc"]."'></p><br />";
}
?>
<p align='left'><big><b><u>Menüpont tartalma:</u></b></big></p>
<textarea id="elm1" name="tartalom">
<?php
if(isset($_GET["modosit"]))
{
	$lekerdez=$pdo->query("select * from ".$elotag."_menu_".$webaktlang." where kod='".$_GET["modosit"]."'");
	$oldal=$lekerdez->fetch();
	print($oldal["tartalom"]);
}
elseif(isset($_GET["almodosit"]))
{
	$lekerdez=$pdo->query("select * from ".$elotag."_almenu_".$webaktlang." where kod='".$_GET["almodosit"]."'");
	$oldal=$lekerdez->fetch();
	print($oldal["tartalom"]);
}
elseif(isset($_GET["blokkszerk"]))
{
	$lekerdez=$pdo->query("select * from ".$elotag."_oldalsav_".$webaktlang." where kod='".$_GET["blokkszerk"]."'");
	$blokk=$lekerdez->fetch();
	print($blokk["szoveg"]);
}
elseif(isset($_GET["cikkmod"]))
{
	$lekerdez=$pdo->query("select * from ".$elotag."_hirkezelo_".$webaktlang." where hirkod='".$_GET["cikkmod"]."'");
	$cikk=$lekerdez->fetch();
	print($cikk["szoveg"]);
}
?>
</textarea>
<?php
if(isset($_GET["modosit"]))
{
	echo "<input type='hidden' name='modosit' value='".$_GET["modosit"]."'>";
}
else if(isset($_GET["almodosit"]))
{
	echo "<input type='hidden' name='almodosit' value='".$_GET["almodosit"]."'>";
}
else if(isset($_GET["blokkszerk"]))
{
	echo "<input type='hidden' name='blokkszerk' value='".$_GET["blokkszerk"]."'>";
}
else if(isset($_GET["cikkmod"]))
{
	echo "<input type='hidden' name='cikkmod' value='".$_GET["cikkmod"]."'>";
}
?>
<br /><center><input type="submit" value="MENTÉS" class="btn btn-large btn-secondary"></center>
<script>
	CKEDITOR.replace( 'tartalom', {
    language: 'hu',
<?php
	$useragent=$_SERVER['HTTP_USER_AGENT'];
	if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
	{
		echo 'toolbar : \'Basic\'';
	}
	else
	{
		echo 'toolbar : \'Full\'';
	}
?>
	});
</script>
</form>
<?php
}
else { echo 'ERROR!'; }
?>