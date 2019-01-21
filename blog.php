<?php
	echo '<div class="tittle_head_w3layouts">
				<h3 class="tittle main">Blog</h3>
			</div>
			<div class="inner_sec_info_agileits_w3">';
	$hi=1;
	$sql = $pdo->query("SELECT * FROM ".$elotag."_hirkezelo_".$webaktlang." where aktiv='1' order by datum desc limit 3");
	while($egyhir=$sql->fetch())
	{
		echo '<div class="col-md-4 grid_info">
				<div class="icon_info">
					'.($egyhir["kiskep"]=="" ? '<span class="fa fa-comments-o fa-lg" aria-hidden="true"></span>' : '<img src="/blog/'.$egyhir["kiskep"].'" class="img-responsive" alt="'.$egyhir["cim"].'">').'
					<h5>'.$egyhir["cim"].'</h5>
					<p><i>'.$egyhir["datum"].'</i></p><br>
					'.$egyhir["bevezeto"].'<br><br>
					<a href="#" data-toggle="modal" data-target="#myModal'.$hi.'" class="btn btn-default">Elolvasom</a>
					
					<div class="modal fade" tabindex="-1" role="dialog" id="myModal'.$hi.'">
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
		$hi++;
	}
	echo '		<div class="clearfix"> </div>
			</div>';
?>