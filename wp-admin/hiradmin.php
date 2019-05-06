<?php
session_start();
if(isset($_SESSION["userlogged"]) AND $_SESSION["userlogged"]!="" AND $_SESSION["userlogged"]!=" ")
{
	$egy_oldal_max = 5;

	function lapozo($link, $tomb_szama, $oldalankenti_db, $kezdes, $act_oldal)
	{
		$kimenet = "";
		$szam = 0;

		if( ($kezdes + $oldalankenti_db) > $tomb_szama)
		{
			$max = $tomb_szama;
		}
		else
		{
			$max = ($kezdes + $oldalankenti_db)-1;
		}

		$kimenet .= '<nav class="pagination">
						<ul class="pagination">';
				if ($tomb_szama > $oldalankenti_db)
				{
					$k = $tomb_szama;
					 for ($k; $k > 0; $k=$k-$oldalankenti_db)
					 {
						$szam=$szam+1;
						if($szam == $act_oldal)
						{
							$kimenet .='<li disabled><a href="javascript:void(0)" class="page-link" disabled>'.$szam.'</a></li>';
						}
						else
						{
							$kimenet .= '<li><a href="'.$link.'oldal='.$szam.'" class="page-link">'.$szam.' </a></li>';
						}
					}
				}
				$kimenet .= '</ul>
							</nav>';

		return $kimenet;
	}
	
	$sql = $pdo->query("SELECT COUNT(hirkod) as db FROM ".$elotag."_hirkezelo_".$webaktlang." ");
	$db =  $sql->fetch();

	if(isset($_GET["oldal"]))
	{
		$oldal = $_GET["oldal"];
	}
	else
	{
		$oldal = 1;
	}
	$limit = (($oldal*$egy_oldal_max)-$egy_oldal_max);

	$sql = "SELECT * FROM ".$elotag."_hirkezelo_".$webaktlang." order by datum desc LIMIT ".$limit.", ".$egy_oldal_max." ";
	$talalatok = $pdo->query($sql) or die("Hibás lekérdezés!");
	if($talalatok->rowCount()>0)
	{
		echo "<h3>Bejegyzések kezelése</h3>";
		echo "<a class='btn' href='index.php?lng=".$webaktlang."&mod=y&ujcikk=1'>+ új bejegyzés létrehozása &raquo;</a><br><br>";
		$hirszamol=0;
		while($egyhir=$talalatok->fetch())
		{
			echo "<p><b>Cím:</b> ".$egyhir["cim"]."<br />";
			echo "<b>F-URL:</b> /".$egyhir["furl"]."<br />";
			echo "<b>Publikálva:</b> <i>".str_replace("-",".",$egyhir["datum"])."</i><br />";
			echo "<a class='btn' data-toggle='modal' href='#myModal".$egyhir["hirkod"]."'><i class='icon-eye-open' aria-hidden='true'></i> megtekintés &raquo;</a> 
			".($egyhir["aktiv"]=="1" ? "<a href='index.php?lng=".$webaktlang."&mod=y&hirstop=".$egyhir["hirkod"]."' class='btn'><i class='fa fa-power-off' aria-hidden='true'></i> kikapcsolás</a> " : "<a href='index.php?lng=".$webaktlang."&mod=y&hirstart=".$egyhir["hirkod"]."' class='btn'><i class='fa fa-check-square-o' aria-hidden='true'></i> aktiválás</a> ")."
					<a class='btn' href='index.php?lng=".$webaktlang."&mod=edit&cikkmod=".$egyhir["hirkod"]."'><i class='fa fa-edit' aria-hidden='true'></i> módosítás &raquo;</a> 
					<a class='btn' href='index.php?lng=".$webaktlang."&mod=y&cikktorol=".$egyhir["hirkod"]."' onclick=\"return confirm('Biztos törli?')\"><i class='fa fa-trash' aria-hidden='true'></i> törlés &raquo;</a><hr align='left' width='88%' color='#000000' size='1' noshade></p>";
			
			//MODAL-ba a hircikk tartalmát beleerőszakoljuk
			echo '<div class="modal fade hide" id="myModal'.$egyhir["hirkod"].'">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h3>'.$egyhir["cim"].'</h3>
				  </div>
				  <div class="modal-body">
					'.$egyhir["szoveg"].'
				  </div>
				  <div class="modal-footer">
					<a href="javascript:void(0);" class="btn" data-dismiss="modal">bezárás</a>
				  </div>
				</div>';
		}
		echo  lapozo("index.php?lng=".$webaktlang."&page=blog&", $db["db"],$egy_oldal_max, ($limit+1), $oldal );
	}
	else
	{
		echo "<h4>Még nincs létrehozva bejegyzés, cikk!</h4>";
		echo "<a class='btn' href='index.php?lng=".$webaktlang."&mod=y&ujcikk=1'>új bejegyzés létrehozása</a>";
	}
}
else { echo 'ERROR!'; }
?>