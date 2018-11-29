<div class="extra">
	<div class="container">
		<div class="row">
			<div class="span4">
				<h4>Szolgáltatások</h4>
				<ul>
					<li><a href="https://www.weboldalkeszites-szolnok.hu/domain-webtarhely" target="_blank">Webtárhely &amp; Domain regisztráció &raquo;</a></li>
					<li><a href="https://szerviz-szolnok.hu" target="_blank">GPS, Számítógép, Laptop szerviz &raquo;</a></li>
					<li><a href="https://www.laptop-szolnok.hu" target="_blank">Hardver kereskedelem &raquo;</a></li>
				</ul>
			</div>
			<div class="span4">
				<h4>Hozzáférések</h4>
				<ul>
					<li><a href="<?php echo 'http://'.$baseurl; ?>" target="_blank">Weblapom megtekintése &raquo;</a></li>
					<li><a href="index.php">Admin felület főoldal &raquo;</a></li>
					<li><a href="index.php?lng=eng&mod=y&usermod=1">Belépési adatok megváltoztatása &raquo;</a></li>
				</ul>
			</div>
			<div class="span4">
				<h4>Terméktámogatás</h4>
				<ul>
<?php
	if(file_exists("../supportend.php"))
	{
		include("../supportend.php");
		$datumt = strtotime($support);
		$finale = date("Y-m-d", strtotime("+24 month", $datumt));
		if($finale>=$ma)
		{
			echo '<li>Az Ön terméktámogatása <b>'.str_replace("-",".",$finale).'.</b> jár le, hosszabbításért kérjük keressen minket.</li>';
		}
		else
		{
			echo '<li><span style="color: #f00;font-size: 16px;">Az Ön terméktámogatása <b>'.str_replace("-",".",$finale).'.</b> lejárt, hosszabbításért kérjük keressen minket.</span></li>';
		}
	}
?>
					<li><a href="https://trswebdesign.hu/#contact" target="_blank">Ügyfélszolgálat &raquo;</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>
<div class="footer">
	<div class="container">
		<div class="row">
			<div id="footer-copyright" class="span6">
				&copy; <?php $d=getDate(); $datum=$d["year"]; print($datum." ".$webadatok["title"]); ?> | Powered by: <a href="http://kek.trswebdesign.hu" target="_blank" title="Könnyedén, egyedül kezelhető adminisztrációs felület">K.E.K. CMS</a>.
			</div>
			<div id="footer-terms" class="span6">
				Coded by <a href="https://trswebdesign.hu" target="_blank" title="Webes alkalmazás fejlesztés">Handzsúr István</a>
			</div>
		</div>
	</div>
</div>
