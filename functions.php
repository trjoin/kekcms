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
							$kimenet .="<li><a href='#' disabled>".$szam."</a></li>";
						}
						else
						{
							$kimenet .= '<li><a href="'.$link.'o/'.$szam.'" style="text-decoration: none;">'.$szam.' </a></li>';
						}
					}
				}
				$kimenet .= '</ul>
							</nav>';

		return $kimenet;
	}