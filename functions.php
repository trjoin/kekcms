<?php
	/*** LAPOZÓ ***/
	function foot_linkek($link, $tomb_szama, $oldalankenti_db, $kezdes, $act_oldal)
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

		$kimenet .= '<nav>
						<ul class="pagination">';
				if ($tomb_szama > $oldalankenti_db)
				{
					$k = $tomb_szama;
					 for ($k; $k > 0; $k=$k-$oldalankenti_db)
					 {
						$szam=$szam+1;
						if($szam == $act_oldal)
						{
							$kimenet .='<li><a href="#" class="page-link" disabled>'.$szam.'</a></li>';
						}
						else
						{
							$kimenet .= '<li><a href="'.$link.'o/'.$szam.'" class="page-link">'.$szam.' </a></li>';
						}
					}
				}
				$kimenet .= '</ul>
							</nav>';

		return $kimenet;
	}
	/*** GENERATOR ***/
	function generateRandomString($length)
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	/*** KARAKTERCSERÉLŐ ***/
	function cserekarakter($mirol, $mire, $miben)
	{
		$mirol=array("í","é","á","ű","ú","ő","ó","ü","ö","Í","É","Á","Ű","Ú","Ő","Ó","Ü","Ö","§","\"","_","+",":","%",",","?","=","*","(",")","<",">","[","]","{","}","&","#","@","<",">","$","'","!","/",";"," ");
		$mire=array("i","e","a","u","u","o","o","u","o","i","e","a","u","u","o","o","u","o","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-");
		$cserelt=$miben;
		str_replace($mirol, $mire, $cserelt);
		return $cserelt;
	}
	/*** csere tömbÖK ***/
	$mirol=array("í","é","á","ű","ú","ő","ó","ü","ö","Í","É","Á","Ű","Ú","Ő","Ó","Ü","Ö","§","\"","_","+",":","%",",","?","=","*","(",")","<",">","[","]","{","}","&","#","@","<",">","$","'","!","/",";"," ");
	$mire=array("i","e","a","u","u","o","o","u","o","i","e","a","u","u","o","o","u","o","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-");