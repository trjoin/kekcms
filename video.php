<?php
if(isset($_REQUEST["vid"]) AND $_REQUEST["vid"]!="" AND $_REQUEST["vid"]!=" ")
{
	$videok=$pdo->query("select * from ".$elotag."_videok where videokod='".$_REQUEST["vid"]."'");
	$ev=$videok->fetch();
	
	echo '<div class="features" id="features">
			<div class="container">
				<h1>'.$ev["videocim"].'</h1><br><br>
				<div class="inner_sec_info_agileits_w3">';	
	
	$posa=strpos($ev["vhiv"], "youtube.com"); //youtube.com
	$posb=strpos($ev["vhiv"], "youtu.be"); //youtu.be
	$posc=strpos($ev["vhiv"], "vimeo.com"); //vimeo.com
	$posd=strpos($ev["vhiv"], "videa.hu"); //videa.hu
	
	if($posa !== false)
	{
		$vlink=explode("=",$ev["vhiv"]);
		$video="<iframe width='100%' height='550' src='https://www.youtube.com/embed/".$vlink[1]."?rel=0&amp;showinfo=0' frameborder='0' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>";
	}
	if($posb !== false)
	{
		$vlink=explode("/",$ev["vhiv"]);
		$video="<iframe width='100%' height='550' src='https://www.youtube.com/embed/".$vlink[3]."?rel=0&amp;showinfo=0' frameborder='0' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>";
	}
	if($posc !== false)
	{
		$vlink=explode("/",$ev["vhiv"]);
		$video="<iframe width='100%' height='550' src='https://player.vimeo.com/video/".$vlink[3]."' frameborder='0' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>";
	}
	if($posd !== false)
	{
		$vlink = substr(strrchr($ev["vhiv"], "-"), 1);
		$video="<iframe width='100%' height='550' src='https://videa.hu/player?v=".$vlink."' frameborder='0' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>";
	}

	echo '<div class="col-md-12 text-center">
			'.$ev["vtext"].'<br>'.$video.'<br><br>
			<a href="/penzugy/videok" class="btn btn-lg btn-success">VISSZA</a>
		</div>';
	echo '<div class="clearfix"> </div><br>';
	echo '		</div>
			</div>
		</div>';
}
else
{
	$vi=0;
	$videok=$pdo->query("select * from ".$elotag."_videok order by videokod desc");
	echo '<div class="features" id="features">
			<div class="container">
				<h1>Videók</h1><br><br>
				<div class="inner_sec_info_agileits_w3 row">';				

	while($ev=$videok->fetch())
	{
		echo '<div class="col-4 text-center card card-block">
				<span style="min-height:55px;display: block;">'.$ev["videocim"].'</span><br><br>
				<a href="/penzugy/videok/'.$ev["videokod"].'" class="btn btn-lg btn-info">MEGTEKINTÉS</a>
			</div>';
		$vi++;
		if($vi%3==0)
		{
			echo '<div class="clearfix"> </div><br><hr><br>';
		}
	}
	echo '<div class="clearfix"> </div><br><hr><br>';
	echo '		</div>
			</div>
		</div>';
}
?>