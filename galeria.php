<?php
	echo '<div class="features" id="features">
			<div class="container">
				<div class="tittle_head_w3layouts">
					<h3 class="tittle">Galéria</h3>
				</div>
				<div class="inner_sec_info_agileits_w3">';
				
	$mappak=$pdo->query("select * from ".$elotag."_mappak");
	$gal=0;
	while($mem=$mappak->fetch())
	{
		echo '<div class="col-md-4 grid_info text-center">
				<a href="#" data-toggle="modal" data-target="#galModal'.$gal.'" class="text-center">
					<h4><b>'.$mem["mappanev"].'</b></h4><br>
					<img src="galeria/'.$mem["mappakep"].'" class="img-responsive" alt="'.$mem["mappanev"].'">
				</a>';
					if(!file_exists("leirasok/".$fajl.".txt"))
					{
						$title="demo szöveg";
					}
					else
					{
						$fm=fopen("leirasok/".$fajl.".txt","r");
						$szoveg="";
						while(!feof($fm))
						{
							$betu=fgetc($fm);
							$szoveg=$szoveg.$betu;
						}
						$title=$szoveg;
					}
			echo '<div class="modal fade" tabindex="-1" role="dialog" id="galModal'.$gal.'">
					  <div class="modal-dialog modal-lg" role="document">
						<div class="modal-content">
						  <div class="modal-header">
							<h4 class="modal-title">'.$mem["mappanev"].' ALBUM</h4>
						  </div>
						  <div class="modal-body">';
							$ig=0;
							$melyik=opendir("galeria/".$mem["mappaut"]);
							while($fajl=readdir($melyik))
							{
								if($fajl!="." and $fajl!="..")
								{
									echo '<div class="col-md-4"><a href="galeria/'.$mem["mappaut"].'/'.$fajl.'" class="fancybox" rel="galeria"><img src="galeria/'.$mem["mappaut"].'/'.$fajl.'" class="img-responsive" alt="'.$title.'"></a></div>';
									$ig++;
									if($ig%3==0)
									{
										echo '<div class="clearfix"> </div>';
									}
								}
							}
							echo '<div class="clearfix"> </div>
						  </div>
						</div>
					  </div>
					</div>';
					
		echo '</div>';
		$gal++;
		if($gal%3==0)
		{
			echo '<div class="clearfix"> </div>';
		}
	}

	echo '		</div>
			</div>
		</div>';
?>