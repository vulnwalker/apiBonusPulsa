<?php
$thn_ = getdate();
$thn = $thn_['year'];


if($Main->DOWNLOAD_MOBILE ){
	$smartMobileLink =
		"<tr><td align='center' style = 'height:24px'>
			<a target='' href='download.php?file=ATISISBADA_KabSrg.apk&dr=downloads&nm=ATISISBADA.apk'
				style='padding:8 8 8 8; color: white;
				font-family: tahoma, verdana, arial, sans-serif;
				font-size: 11px;' title='Download ATISISBADA Smart Mobile'><b>Download ATISISBADA Smart Mobile</a>
		</td></tr>";
	$smartMobileLink2 =

			"<a target='' href='download.php?file=".$Main->APK_FILE."&dr=downloads&nm=ATISISBADA.apk'
				style='padding:8 8 8 8; color: white;
				font-family: tahoma, verdana, arial, sans-serif;
				font-size: 11px;' title='Download ATISISBADA Smart Mobile'>
					<b>DOWNLOAD MANTAP SMART MOBILE
			</a>
		";
}

if($Main->MENU_VERSI == 2){
$Main->Base = "
Secured By Imam Squad
 ";

}
else{



$Main->Base = "
	Secured By Imam Squad
";
}

?>
