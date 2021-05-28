<?php
	echo '<div class="tittle_head_w3layouts">
				<h3 class="tittle main">Blog</h3>
			</div>
			<div class="inner_sec_info_agileits_w3">';

	if(isset($_REQUEST["hir"]))
	{
		$sql = $pdo->query("SELECT * FROM ".$elotag."_hirkezelo_".$webaktlang." where aktiv='1' and furl='".$_REQUEST["hir"]."'");
		$egyhir=$sql->fetch();
		echo '<div class="col-md-12 grid_info">';
			echo ''.($egyhir["kiskep"]=="" ? '' : '<img src="/blog/'.$egyhir["kiskep"].'" class="img-responsive" alt="'.$egyhir["cim"].'"><br>').'
					<h5>'.$egyhir["cim"].'</h5>
					<p><i>'.$egyhir["datum"].'</i></p><br>
					'.$egyhir["szoveg"].'<br><br>
					'.($egyhir["tags"]!="" ? $egyhir["tags"] : "").'';
		echo '</div>';
	}
	else
	{
		$egy_oldal_max = 6;
		$darab = $pdo->query("SELECT COUNT(hirkod) as db FROM ".$elotag."_hirkezelo_".$webaktlang." WHERE aktiv='1' order by datum desc");
		$db =  $darab->fetch();

		if(isset($_GET["oldal"]))
		{
			$oldal = $_GET["oldal"];
		}
		else
		{
			$oldal = 1;
		}
		$limit = (($oldal*$egy_oldal_max)-$egy_oldal_max);
		
		$sql = $pdo->query("SELECT * FROM ".$elotag."_hirkezelo_".$webaktlang." where aktiv='1' order by datum desc limit ".$limit.", ".$egy_oldal_max." ");
		while($egyhir=$sql->fetch())
		{
			echo '<div class="col-md-4 grid_info">
					<div class="icon_info">

						'.($egyhir["kiskep"]=="" ? '<span class="fa fa-comments-o fa-lg" aria-hidden="true"></span>' : '<img src="/blog/'.$egyhir["kiskep"].'" class="img-responsive" alt="'.$egyhir["cim"].'">').'
						<h5>'.$egyhir["cim"].'</h5>
						<p><i>'.$egyhir["datum"].'</i></p><br>
						'.$egyhir["bevezeto"].'<br><br>
						<a href="#" data-toggle="modal" data-target="#myModal'.$egyhir["hirkod"].'" class="btn btn-default">Elolvasom</a>
						
						<div class="modal fade" tabindex="-1" role="dialog" id="myModal'.$egyhir["hirkod"].'">
						  <div class="modal-dialog" role="document">
							<div class="modal-content">
							  <div class="modal-header">
								<h4 class="modal-title">'.$egyhir["cim"].'</h4>
							  </div>
							  <div class="modal-body">
								'.$egyhir["szoveg"].'<br><br>
								'.($egyhir["tags"]!="" ? $egyhir["tags"] : "").'
							  </div>
							</div>
						  </div>
						</div>

					</div>
				</div>';
		}
		echo '<div class="clearfix"> </div>';
		echo foot_linkek("/blog/", $db["db"], $egy_oldal_max, ($limit+1), $oldal );
	}
	echo '</div>';
?>