<?php
//EGY TERMÉK ADATLAP
if(isset($_REQUEST["tid"]) AND $_REQUEST["tid"]!="")
{
	$betolt=$pdo->query("select * from ".$elotag."_shop_termek where t_aktiv='1' and tid='".$_REQUEST["tid"]."'");
	$l=$betolt->fetch();
echo '<div class="w3aitssinglewthree">
	<div class="container">

		<div class="products">
		<div class="single-page">
			<div class="single-page-row" id="detail-21">
				<div class="col-md-6 single-top-left">
					<div class="flexslider">
						<ul class="slides">
							<li data-thumb="/shop/'.$l["t_fkep"].'">
								<div class="thumb-image detail_images"> <img src="/shop/'.$l["t_fkep"].'" data-imagezoom="true" class="img-responsive" alt="'.$l["t_nev_hun"].'"></div>
							</li>';
						if($l["t_kepek"]!="")
						{
							$t_kepek=explode("|", $l["t_kepek"]);
							$darabszam=0;
							foreach($t_kepek as $valami)
							{
								if($t_kepek[$darabszam]!="")
								{
									echo '<li data-thumb="/shop/kepek/'.$t_kepek[$darabszam].'">
											 <div class="thumb-image"> <img src="/shop/kepek/'.$t_kepek[$darabszam].'" data-imagezoom="true" class="img-responsive" alt="'.$l["t_nev_hun"].' - Emkiis Mobil"></div>
										</li>';
								}
								$darabszam++;
							}
						} 
					echo '</ul>
					</div>
				</div>
				<div class="col-md-6 single-top-right">
					<h1 class="item_name">'.$l["t_nev_hun"].'</h1>
					<div class="single-price">
						<ul>
						'.($l["t_akcios"]!=0 ? '<li>'.number_format($l["t_akcios"],0,",",".").' Ft</li><li><del>'.number_format($l["t_ar"],0,",",".").' Ft</del></li>' : '<li>'.number_format($l["t_ar"],0,",",".").' Ft</li>').'
						</ul>
					</div>
					'.($l["t_kleiras"]!='' ? '<p class="single-price-text"><b>Bemutatás:</b><br>'.$l["t_kleiras"].'</p>' : '<p class="single-price-text"><b>Cikkszám:</b> '.$l["tcikkszam"].'</p>').'<br>
					<p class="single-price-text"><a href="javascript:history.go(-1)" class="btn btn-default"> vissza </a></p>

				<!--<div class="agilesocialwthree">
						<ul class="social-icons">
							<li><a href="#" class="facebook w3ls" title="Go to Our Facebook Page"><i class="fa w3ls fa-facebook-square" aria-hidden="true"></i></a></li>
							<li><a href="#" class="twitter w3l" title="Go to Our Twitter Account"><i class="fa w3l fa-twitter-square" aria-hidden="true"></i></a></li>
							<li><a href="#" class="instagram wthree" title="Go to Our Instagram Account"><i class="fa wthree fa-instagram" aria-hidden="true"></i></a></li>
						</ul>
					</div>-->
				</div>
				<div class="clearfix"></div>
			</div>
		</div>

		<div class="aitsaccordionw3layouts">
			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingOne">
						<h4 class="panel-title asd">
							<a class="pa_italic" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Leírás <span class="glyphicon glyphicon glyphicon-chevron-down" aria-hidden="true"></span><i class="glyphicon glyphicon-menu-up" aria-hidden="true"></i></a>
						</h4>
					</div>
					<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
						<div class="panel-body panel_text">
							<div class="scrollbar" id="style-2">
								'.$l["t_nleiras_hun"].'
							</div>
						</div>
					</div>
				</div>

				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingFour">
						<h4 class="panel-title asd">
							<a class="pa_italic collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">Rendelési és szállítási információk <span class="glyphicon glyphicon glyphicon-chevron-down" aria-hidden="true"></span><i class="glyphicon glyphicon-menu-up" aria-hidden="true"></i>
							</a>
						</h4>
					</div>
					<div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
						<ul class="ship">
							<li class="day"><i class="fa fa-calendar" aria-hidden="true"></i> 5-10 napon belül</li>
							<li class="home"><i class="fa fa-truck" aria-hidden="true"></i> ingyenes szállítással</li>
							<li class="cod"><i class="fa fa-money" aria-hidden="true"></i> kizárólag előre utalással fizetve</li>
						</ul>
					</div>
				</div>
			</div>
		</div>

	</div>

	</div>
</div>';
}
else
{
//TERMÉK LISTÁZÓ A KATEGÓRIÁBÓL

$egy_oldal_max = 12;
$darab = $pdo->query("SELECT COUNT(tid) as db FROM ".$elotag."_shop_termek WHERE t_aktiv='1' and t_alkategoria='".$kattok[0]."' order by tid desc");
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

echo '<div class="wthreeproductdisplay">
		<div id="cbp-pgcontainer" class="cbp-pgcontainer">
			<ul class="cbp-pggrid">';
$kattermekek=$pdo->query("select * from ".$elotag."_shop_termek where t_aktiv='1' and t_alkategoria='".$kattok[0]."' order by tid desc limit ".$limit.", ".$egy_oldal_max."");
if($kattermekek->rowCount()>0)
{
	$k=1;
	while($l=$kattermekek->fetch())
	{
		echo '<li class="wthree aits w3l">
				<div class="cbp-pgcontent" id="'.$l["tid"].'">
					<a href="/'.str_replace($mirol,$mire,strtolower($l["t_nev_hun"])).'/'.$l["tid"].'">
						<div class="cbp-pgitem a3ls">
							<div class="cbp-pgitem-flip">
								<img src="/shop/'.$l["t_fkep"].'" alt="'.$l["t_nev_hun"].'">
							</div>
						</div>
					</a>
				</div>
				<div class="cbp-pginfo w3layouts">
					<h3>'.$l["t_nev_hun"].'</h3>
					<span class="cbp-pgprice">'.($l["t_akcios"]!='0' ? '<span style="color:#f00;">'.number_format($l["t_akcios"],0,",",".").'</span>' : number_format($l["t_ar"],0,",",".")).' Ft</span>
				</div>
				<div class="cbp-pginfo w3layouts text-center">
					<br><a href="/'.str_replace($mirol,$mire,strtolower($l["t_nev_hun"])).'/'.$l["tid"].'" class="btn btn-info btn-lg"><i class="fa fa-eye"></i> MEGTEKINTÉS</a><br><br>
				</div>
			</li>';
	}
}
else
{
	echo '<li class="wthree aits w3l"><div class="cbp-pginfo w3layouts"><h3>Sajnos ebben a kategóriában még nincsenek termékek.</h3></div></li>';
}
echo '</ul>
	</div>
</div>';
echo foot_linkek("/".$_REQUEST["furl"]."/", $db["db"], $egy_oldal_max, ($limit+1), $oldal );
}
?>