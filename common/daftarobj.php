<?php

function romanic_number($integer, $upcase = true)
{
    $table = array('M'=>1000, 'CM'=>900, 'D'=>500, 'CD'=>400, 'C'=>100, 'XC'=>90, 'L'=>50, 'XL'=>40, 'X'=>10, 'IX'=>9, 'V'=>5, 'IV'=>4, 'I'=>1);
    $hsl = '';
    while($integer > 0)
    {
        foreach($table as $rom=>$arb)
        {
            if($integer >= $arb)
            {
                $integer -= $arb;
                if($upcase==TRUE){
					$hsl .= strtoupper($rom);
				}else{
					$hsl .= strtolower($rom);

				}
                break;
            }
        }
    }

    return $hsl;
}

function createEntryTgllahir($Tgl, $elName, $disableEntry='',
	$ket='tanggal bulan tahun (mis: 1 Januari 1998)',
	$title='', $fmName = 'adminForm',
	$tglShow=TRUE, $withBtClear = TRUE, $mode=1){
	//global $$elName,
	//global $Ref;//= 'entryTgl';

	$NamaBulan  = array(
	array("01","Januari"),
	array("02","Pebruari"),
	array("03","Maret"),
	array("04","April"),
	array("05","Mei"),
	array("06","Juni"),
	array("07","Juli"),
	array("08","Agustus"),
	array("09","September"),
	array("10","Oktober"),
	array("11","Nopember"),
	array("12","Desember")
	);

	$deftgl = date( 'Y-m-d' ) ;//'2010-05-05';

	$tgltmp= explode(' ',$Tgl);//explode(' ',$$elName); //hilangkan jam jika ada
	$stgl = $tgltmp[0];
	$tgl = explode('-',$stgl);
	if ($tgl[2]=='00'){ $tgl[2]='';	}
	if ($tgl[1]=='00'){ $tgl[1]='';	}
	if ($tgl[0]=='0000'){ $tgl[0]='';	}


	$dis='';
	if($disableEntry == '1'){
		$dis = 'disabled';
	}

	if ($tgl[0]==''){
		$thn =(int)date('Y') ;
	}else{
		$thn = $tgl[0];//(int)date('Y') ;
	}

	if($title!= ''){
		$title .= $title.'&nbsp;';
	}

	switch($mode){
		case '1' :{
			$entrytgl = $tglShow?
				'<div  style="float:left;padding: 0 4 0 0">' .
					$title .
					genCombo_tgl(
						$elName.'_tgl',
						$tgl[2],
						'',
						" $dis ".'  onchange="TglEntry_createtgl(\'' . $elName . '\')"').
				'</div>'
				: '';
			$thnaw = $thn-120;
			$thnak = $thn+11;
			$opsi = "<option value=''>Tahun</option>";
			for ($i=$thnaw; $i<$thnak; $i++){
				$sel = $i == $tgl[0]? "selected='true'" :'';
				$opsi .= "<option $sel value='$i'>$i</option>";
			}
			$entry_thn =
				'<select id="'. $elName  .'_thn"
					name="' . $elName . '_thn"	'.
					$dis.
					' onchange="TglEntry_createtgl(\'' . $elName . '\')"
				>'.
					$opsi.
				'</select>';
			break;
		}
		case '2' :{
			$entrytgl = $tglShow?
				'<div  style="float:left;padding: 0 4 0 0">'.$title.'
					<input '.$dis.' type="text" name="'.$elName.'_tgl" id="'.$elName.'_tgl" value="'.$tgl[2].'" size="2" maxlength="2"
						onkeypress="return isNumberKey(event)"
						onchange="TglEntry_createtgl(\''.$elName.'\')"
						style="width:25">
				</div>' : '';
			$entry_thn =
				'<div  style="float:left;padding: 0 4 0 0">'.$title.'
					<input '.$dis.' type="text" name="'.$elName.'_thn" id="'.$elName.'_thn"
						value="'.$tgl[0].'" size="4" maxlength="4"
						onkeypress="return isNumberKey(event)"
						onchange="TglEntry_createtgl(\''.$elName.'\')"
						style="width:40">
				</div>' ;
			break;
		}
	}



	$btClear =  $withBtClear?
		'<div style="float:left;padding: 0 4 0 0">
				<input '.$dis.'  name="'.$elName.'_btClear" id="'.$elName.'_btClear" type="button" value="Clear"
					onclick="TglEntry_cleartgl(\''.$elName.'\')">
					&nbsp;&nbsp<span style="color:red;">'.$ket.'</span>
		</div>' : '';

	$hsl =
		'<div id="'.$elName.'_content" style="float:left;">'.
			$entrytgl.
			'<div style="float:left;padding: 0 4 0 0">
				'.cmb2D_v2($elName.'_bln', $tgl[1], $NamaBulan, $dis,'Pilih Bulan',
				'onchange="TglEntry_createtgl(\''.$elName.'\')"'  ) .'
			</div>
			<div style="float:left;padding: 0 4 0 0">
				<!--<input '.$dis.' type="text" name="'.$elName.'_thn" id="'.$elName.'_thn" value="'.$tgl[0].'" size="4" maxlength="4"
					onkeypress="return isNumberKey(event)"
					onchange="TglEntry_createtgl(\''.$elName.'\')"
					style="width:35"
				>-->'.
				$entry_thn.
			'</div>'.

			$btClear.
			'<input $dis type="hidden" id='.$elName.' name='.$elName.' value="'.$Tgl.'" >
		</div>';
	return $hsl;
}

function Fmt($val,$FormatType=0){ //format entry
	$hsl ='';
	switch($FormatType){
		case 1: $hsl = number_format($val,2,',','.'); break;
		case 2: $hsl = number_format($val,0,',','.'); break;
		default: $hsl = $val; break;
	}
	return $hsl;
}




function genSubtitle($SubTitle='Daftar Pengguna',$Menu='', $Icon='images/icon/daftar48.png', $IcoWidth=50){
	return
		/*"<table class='TitlePage' width='100%'><tr>"
		"<th height='47' align='left'
					style=\"background: url('$Icon') no-repeat scroll left center transparent; padding:0 0 0 $IcoWidth;\">
					$SubTitle</th>
				<th>$Menu</th>
		</tr></table>";*/
		"".
		"
			$SubTitle

		$Menu";

}


function dialog_createCaption($caption='',$other_content = ''){
	return "<table class='' width='100%' cellspacing='0' cellpadding='0' border='0'><tr><td style='padding:0'>
			<div class='menuBar2' style='height:20' >
			<ul>
			<!--<li><a href='javascript:PengamanForm.Close()' title='Batal' class='btdel'></a></li>
			<li><a href='javascript:PengamanSimpan.Simpan()' title='Simpan' class='btcheck'></a></li>-->
			</ul>
			<span style='cursor:default;position:relative;left: 11px;top:2;color: #5a5555;font-size: 14px;font-weight:bold;'
				>$caption</span>
		.	$other_content
			</div>
			</td></tr></table>";
}


function createEntryTgl3($Tgl, $elName, $disableEntry='',
	$ket='tanggal bulan tahun (mis: 1 Januari 1998)',
	$title='', $fmName = 'adminForm',
	$tglShow=TRUE, $withBtClear = TRUE){
	//global $$elName,
	//global $Ref;//= 'entryTgl';

	$NamaBulan  = array(
	array("01","Januari"),
	array("02","Pebruari"),
	array("03","Maret"),
	array("04","April"),
	array("05","Mei"),
	array("06","Juni"),
	array("07","Juli"),
	array("08","Agustus"),
	array("09","September"),
	array("10","Oktober"),
	array("11","Nopember"),
	array("12","Desember")
	);

	$deftgl = date( 'Y-m-d' ) ;//'2010-05-05';

	$tgltmp= explode(' ',$Tgl);//explode(' ',$$elName); //hilangkan jam jika ada
	$stgl = $tgltmp[0];
	$tgl = explode('-',$stgl);
	if ($tgl[2]=='00'){ $tgl[2]='';	}
	if ($tgl[1]=='00'){ $tgl[1]='';	}
	if ($tgl[0]=='0000'){ $tgl[0]='';	}

	if($title!= ''){
		$title .= $title.'&nbsp;';
	}

	$dis='';
	if($disableEntry == '1'){
		$dis = 'disabled';
	}

	/*$entrytgl = $tglShow?
		'<div  style="float:left;padding: 0 4 0 0">'.$title.'
			<input '.$dis.' type="text" name="'.$elName.'_tgl" id="'.$elName.'_tgl" value="'.$tgl[2].'" size="2" maxlength="2"
				onkeypress="return isNumberKey(event)"
				onchange="TglEntry_createtgl(\''.$elName.'\')"
				style="width:25">
		</div>' : '';*/
	$entrytgl = $tglShow?
		'<div  style="float:left;padding: 0 4 0 0">' .
			$title .
			//$tgl[2].
			genCombo_tgl(
				$elName.'_tgl',
				$tgl[2],
				'',
				" $dis ".'  onchange="TglEntry_createtgl(\'' . $elName . '\')"').
		'</div>'
		: '';
	$btClear =  $withBtClear?
		'<div style="float:left;padding: 0 4 0 0">
				<input '.$dis.'  name="'.$elName.'_btClear" id="'.$elName.'_btClear" type="button" value="Clear"
					onclick="TglEntry_cleartgl(\''.$elName.'\')">
					&nbsp;&nbsp<span style="color:red;">'.$ket.'</span>
		</div>' : '';

	if ($tgl[0]==''){
		$thn =(int)date('Y') ;
	}else{
		$thn = $tgl[0];//(int)date('Y') ;
	}
	$thnaw = $thn-10;
	$thnak = $thn+11;
	$opsi = "<option value=''>Tahun</option>";
	for ($i=$thnaw; $i<$thnak; $i++){
		$sel = $i == $tgl[0]? "selected='true'" :'';
		$opsi .= "<option $sel value='$i'>$i</option>";
	}
	$entry_thn =
		'<select id="'. $elName  .'_thn"
			name="' . $elName . '_thn"	'.
			$dis.
			' onchange="TglEntry_createtgl(\'' . $elName . '\')"
		>'.
			$opsi.
		'</select>';

	$hsl =
		'<div id="'.$elName.'_content" style="float:left;">'.
			$entrytgl.
			'<div style="float:left;padding: 0 4 0 0">
				'.cmb2D_v2($elName.'_bln', $tgl[1], $NamaBulan, $dis,'Pilih Bulan',
				'onchange="TglEntry_createtgl(\''.$elName.'\')"'  ) .'
			</div>
			<div style="float:left;padding: 0 4 0 0">
				<!--<input '.$dis.' type="text" name="'.$elName.'_thn" id="'.$elName.'_thn" value="'.$tgl[0].'" size="4" maxlength="4"
					onkeypress="return isNumberKey(event)"
					onchange="TglEntry_createtgl(\''.$elName.'\')"
					style="width:35"
				>-->'.
				$entry_thn.
			'</div>'.

			$btClear.
			'<input $dis type="hidden" id='.$elName.' name='.$elName.' value="'.$Tgl.'" >
		</div>';
	return $hsl;
}

function createEntryTgl4($Tgl, $elName, $disableEntry='',
	$ket='tanggal bulan tahun (mis: 1 Januari 1998)', $Link='',
	$title='', $fmName = 'adminForm',
	$tglShow=TRUE, $withBtClear = TRUE){
	//global $$elName,
	//global $Ref;//= 'entryTgl';

	$NamaBulan  = array(
	array("01","Januari"),
	array("02","Pebruari"),
	array("03","Maret"),
	array("04","April"),
	array("05","Mei"),
	array("06","Juni"),
	array("07","Juli"),
	array("08","Agustus"),
	array("09","September"),
	array("10","Oktober"),
	array("11","Nopember"),
	array("12","Desember")
	);

	$deftgl = date( 'Y-m-d' ) ;//'2010-05-05';

	$tgltmp= explode(' ',$Tgl);//explode(' ',$$elName); //hilangkan jam jika ada
	$stgl = $tgltmp[0];
	$tgl = explode('-',$stgl);
	if ($tgl[2]=='00'){ $tgl[2]='';	}
	if ($tgl[1]=='00'){ $tgl[1]='';	}
	if ($tgl[0]=='0000'){ $tgl[0]='';	}

	if($title!= ''){
		$title .= $title.'&nbsp;';
	}

	$dis='';
	if($disableEntry == '1'){
		$dis = 'disabled';
	}

	/*$entrytgl = $tglShow?
		'<div  style="float:left;padding: 0 4 0 0">'.$title.'
			<input '.$dis.' type="text" name="'.$elName.'_tgl" id="'.$elName.'_tgl" value="'.$tgl[2].'" size="2" maxlength="2"
				onkeypress="return isNumberKey(event)"
				onchange="TglEntry_createtgl(\''.$elName.'\')"
				style="width:25">
		</div>' : '';*/
	$entrytgl = $tglShow?
		'<div  style="float:left;padding: 0 4 0 0">' .
			$title .
			//$tgl[2].
			genCombo_tgl(
				$elName.'_tgl',
				$tgl[2],
				'',
				" $dis ".'  onchange="TglEntry_createtgl(\'' . $elName . '\')"').
		'</div>'
		: '';
	$btClear =  $withBtClear?
		'<div style="float:left;padding: 0 4 0 0">
				<input '.$dis.'  name="'.$elName.'_btClear" id="'.$elName.'_btClear" type="button" value="Clear"
					onclick="TglEntry_cleartgl(\''.$elName.'\')">
					&nbsp;&nbsp<span style="color:red;">'.$ket.'</span>
		</div>' : '';

	if ($tgl[0]==''){
		$thn =(int)date('Y') ;
	}else{
		$thn = $tgl[0];//(int)date('Y') ;
	}
	$thnaw = $thn-10;
	$thnak = $thn+11;
	$opsi = "<option value=''>Tahun</option>";
	for ($i=$thnaw; $i<$thnak; $i++){
		$sel = $i == $tgl[0]? "selected='true'" :'';
		$opsi .= "<option $sel value='$i'>$i</option>";
	}
	$entry_thn =
		'<select id="'. $elName  .'_thn"
			name="' . $elName . '_thn"	'.
			$dis.
			' onchange="'.$Link.'"
		>'.
			$opsi.
		'</select>';

	$hsl =
		'<div id="'.$elName.'_content" style="float:left;">'.
			$entrytgl.
			'<div style="float:left;padding: 0 4 0 0">
				'.cmb2D_v2($elName.'_bln', $tgl[1], $NamaBulan, $dis,'Pilih Bulan',
				'onchange="TglEntry_createtgl(\''.$elName.'\')"'  ) .'
			</div>
			<div style="float:left;padding: 0 4 0 0">
				<!--<input '.$dis.' type="text" name="'.$elName.'_thn" id="'.$elName.'_thn" value="'.$tgl[0].'" size="4" maxlength="4"
					onkeypress="return isNumberKey(event)"
					onchange="TglEntry_createtgl(\''.$elName.'\')"
					style="width:35"
				>-->'.
				$entry_thn.
			'</div>'.

			$btClear.
			'<input $dis type="hidden" id='.$elName.' name='.$elName.' value="'.$Tgl.'" >
		</div>';
	return $hsl;
}

function Entry($val,$name='entry1',$param='', $EntryType=0){
	$hsl ='';
	switch($EntryType){
		//case 0: case '': $hsl=''; break;
		case 1: case 'hidden': $hsl = "<input type='hidden' id='$name' name='$name' value='$val' $param>" ;break;
		case 2: case 'text': $hsl = "<input type='text' id='$name' name='$name' value='$val' $param>" ;break;
		case 3: case 'date': $hsl = createEntryTgl3($val, $name, false) ;break;
		case 4: case 'number':
			$hsl =
				"<input type='text'
					onkeypress='return isNumberKey(event)'
					value='$val'
					name='$name'
					id='$name'
					$param
				>";
			break;
		case 5: case 'memo':
			$hsl = "<textarea $param id='$name' name='$name' >".$val."</textarea>";
			break;
		default:
			//$hsl='';
			$hsl = "<input type='text' id='$name' name='$name' value='$val' $param>" ;
			break;
	}
	return $hsl;
}

function centerPage($content){
	return '<table width=\'100%\' height=\'100%\'><tr><td align=\'center\'> '.$content.'</td></tr></table>';

}
function createDialog($fmID='divdialog1',
	$Content='',
	$ContentWidth=623,
	$ContentHeight=358,
	$caption='Dialog', $dlgCaptionContent='',
	$menuContent='', $menuHeight=22, $FormName='', $params = NULL ){


	$paddingMenuRight = 8;
		$paddingMenuLeft = 8;
		$paddingMenuBottom = 9;
	$marginTop= 9;
		$marginBottom= 8;
		$marginLeft = 8;
		$marginRight = 8;
	$menudlg = "
			<div style='padding: 0 $paddingMenuRight $paddingMenuBottom $paddingMenuLeft;height:$menuHeight; '>
			<div style='float:right;'>
				$menuContent
			</div>
			</div>
			";
	$captionHeight = 30;
		$dlgHeight = $captionHeight+$marginTop+$ContentHeight+$marginBottom+$menuHeight+$paddingMenuBottom;
		//$dlgWidth = 642;
		$dlgWidth = $ContentWidth+$marginLeft+$marginRight+2;
   $footerDialog = $ContentHeight - 15;
	if($params == NULL){

		//add menu

		$dlg =
			dialog_createCaption($caption, $dlgCaptionContent).
			"<div id='$fmID' style='margin:$marginTop $marginLeft $marginBottom $marginRight;
				overflow:auto;width:$ContentWidth;height:$footerDialog; border:1px solid #E5E5E5;'
			>".
			$Content.
			'</div>'.
			$menudlg;
		//add border style and dimensi
		$dlg = "<div id='div_border' style='width:$dlgWidth;height:$dlgHeight;
				background-color: white;
				border-color: rgba(0, 0, 0, 0.3);
				border-style: solid;
				border-width: 1px;
				box-shadow:0 0 232px rgba(0, 0, 0, 0.5);
				border-radius: 4px;
				'>
					$dlg
				</div>";
		//add form
		if($FormName !=''){
			//$dlg = form_it($FormName,$dlg);
		}

	}else{
		$menudlg = "
			<div style='padding: 8;height:$menuHeight; border-top: 2px solid #ddd;'>
			<div style='float:right;'>
				$menuContent
			</div>
			</div>
			";
		$dlg =

			"<table style='width:100%;height:100%' >".
			"<tr height='10'><td>".dialog_createCaption($caption, $dlgCaptionContent)."</td></tr>".
			"<tr  height='*' valign='top'><td>
			<div style='overflow:auto;height:100%'>$Content</div></td></tr>".
			"<tr height='30'><td >$menudlg</td></tr>".
			"</table>";




		$dlg = "<div id='div_border' style='width:100%;height:100%;
				background-color:white;
				border-color: rgba(0, 0, 0, 0.3);   border-style: solid;  border-width:1;
				box-shadow: 6px 6px 5px rgba(0, 0, 0, 0.3);'>
					$dlg
				</div>";

		//if($FormName !=''){
		//	$dlg = form_it($FormName,$dlg);
	//	}
	}


	return $dlg;
}


function setHeaderXls($nmfile='Daftar Realisasi Penerimaan.xls'){
	header("Content-Type: application/force-download");
	header( 'Expires: Sat, 26 Jul 1997 05:00:00 GMT' );
	header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
	header( 'Cache-Control: no-store, no-cache, must-revalidate' );
	header( 'Cache-Control: post-check=0, pre-check=0', false );
	header( 'Pragma: no-cache' );
	header("Content-Transfer-Encoding: Binary");
	header('Content-disposition: attachment; filename="'.$nmfile.'"');
}

function genRadioGrp($nmElem='cbx1', $valu='',
	$data='',
	$Params= "style='width:90;display:block;float:left;'",
	$paramradio='' ){
	//data -> hash array
	$isi = $valu; //if($isi=='')unset($isi);
	$Input = '';
	//if ($Params=='')$Params= "style='width:90;display:block;float:left;'";
	foreach($data as $key=>$value){

		$Sel = isset($isi) && $isi==$key? " checked ": "";
		$Input .= "<div $Params ><INPUT ".$Sel." TYPE='RADIO' id='$nmElem' NAME='$nmElem' VALUE='$key' $paramradio> $value</div>";

	}
	return $Input.$cek;

}

function genTableRow($Koloms, $RowAtr='', $KolomClassStyle=''){
	$baris = '';

	foreach ($Koloms as &$value) {
		//if($value[1] !='')

		$baris .= "<td class='$KolomClassStyle'  {$value[0]}>$value[1]</td>";
	}
	if (count($Koloms)>0){$baris ="<tr $RowAtr > $baris </tr>"; }
	return $baris;
}

function genFilterBar($Filters, $onClick, $withButton=TRUE, $TombolCaption='Tampilkan', $Style='FilterBar'){
	$Content=''; $i=0;
	while( $i < count($Filters) ){
		$border	= $i== count($Filters)-1 ? '' : "border-right:1px solid #E5E5E5;";
		$Content.= "<td  align='left' style='padding:1 8 0 8; $border'>".
						$Filters[$i].
					"</td>";
		$i++;
	}
	//tombol
	if($withButton){
		$Content.= "<td  align='left' style='padding:1 8 0 8;'>
					<input type=button id='btTampil' value='$TombolCaption'
						onclick=\"$onClick\">
				</td>";
	}

	/*return  "
		<table class='$Style' width='100%' style='margin: 4 0 0 0' cellspacing='0' cellpadding='0' border='0'>
		<tr><td>
			<table cellspacing='0' cellpadding='0' border='0'>
			<tr valign='middle'>
				$Content
			</tr>
			</table>
		</td><td width='*'>&nbsp</td></tr>
		</table>";	*/
	return  "
		<!--<table class='$Style' width='100%' style='margin: 4 0 0 0' cellspacing='0' cellpadding='0' border='0'>
		<tr><td> -->
		<div class='$Style' >
			<table style='width:100%'><tr><td align=left>
			<table cellspacing='0' cellpadding='0' border='0' style='height:28'>
			<tr valign='middle'>
				$Content
			</tr>
			</table>
			</td></tr></table>
		</div>
		<!--</td><td width='*'>&nbsp</td>
		</tr>
		</table>-->

		";
}
function cmbArray($name='txtField',$value='',$arrList = '',$default='Pilih', $param='') {
 	$isi = $value;
	$Input = "<option value=''>$default</option>";
	for($i=0;$i<count($arrList);$i++) {
		$Sel = $isi==$arrList[$i][0]?" selected ":"";
		$Input .= "<option $Sel value='{$arrList[$i][0]}'>{$arrList[$i][1]}</option>";
	}
	$Input  = "<select $param name='$name'  id='$name' >$Input</select>";
	return $Input;
}

//OTHER ************************
function genPanelIcon($Link="",$Image="save2.png",$Isi="Isinya",$hint='',$id="",$ReadOnly="",$Disabled=FALSE,$Rid="",$aparams='') {
	global $Pg; $RidONLY = "";
	global $PATH_IMG;
	//if(!Empty($ReadOnly)){$Link="#FORMENTRY";}
	if ($Disabled) {
		$Link ='';
		$DisAbled = "disabled='true'";
	}
	$Ret = "        <li class='nav-item' style='margin-right: 10px;margin-left: 10px;'>
				<a$ReadOnly class='toolbar' id='$id' href='$Link' $DisAbled title='$hint' $aparams>
					<img src='".$PATH_IMG."images/administrator/images/$Image'  alt='button' name='save'
					width='22' height='22' border='0' align='middle'  />
					$Isi
				</a>
        </li> ";
	return $Ret;
}
function tambah_hari($fmTglAwal='', $hari){
	return date('Y-m-d', strtotime( date("Y-m-d", strtotime($fmTglAwal)) . " +$hari day" ));
}
function selisih_tgl($tgl1='', $tgl2=''){//yyyy-mm-dd
	$tgl = explode('-',$tgl1);
	$jd1 = GregorianToJD($tgl[1], $tgl[2], $tgl[0]);//m/d/y
	$tgl = explode('-',$tgl2);
	$jd2 = GregorianToJD($tgl[1], $tgl[2], $tgl[0]);

	return $jd1-$jd2;
}
function genHidden($dat){
	$hidden = '';
	foreach($dat as $key => $value){
		$hidden .= "<input type='hidden' name='$key' id='$key' value='$value'>";
	}
	return $hidden;
}

function tbl_update($Tblname,$Fields, $Kondisi, $msg=''){//tes
	//Fields -> hash array (fieldname=>fieldvalue)
	$errmsg='';
	$klm = array();
	foreach($Fields as $key => $value){
		$klm[] = " $key = '$value' ";
	}
	$klmstr=join(',',$klm);
	if($klmstr !=''){
		$aqry = " update $Tblname set $klmstr $Kondisi ";
		$Simpan = sqlQuery($aqry);
		if($Simpan==FALSE)$errmsg ='Gagal Update Data!';
	}else{
		$errmsg = 'Tidak Ada Data!';
	}
	return $errmsg;//$aqry;
}

function tbl_insert($Tblname,$Fields, $Kondisi='', $msg=''){//tes
	//Fields -> hash array (fieldname=>fieldvalue)
	$errmsg='';
	$keys = array();
	$vals = array();
	foreach($Fields as $key => $value){
		$keys[]= $key;
		$vals[]= "'$value'";
	}
	//$fieldstr = print_r($Fields);
	$keystr=join(',',$keys);
	$valstr=join(',',$vals);
	if($keystr !=''){
		$aqry = " insert into $Tblname (".$keystr.") values(".$valstr.") $Kondisi ";
		$Simpan = sqlQuery($aqry);
		if($Simpan==FALSE)$errmsg ='Gagal Insert Data!';//.mysql_error();//.$aqry.$keystr.$valstr;
	}else{
		$errmsg = 'Tidak Ada Data!';
	}
	return $errmsg;//.$aqry;
}

function get_admin_akses($uid, $kodei){
	global $usr;

	$fvalue=array();

	$aqry = "select * from admin_akses where uid = '$uid' and i='$kodei'";
	$qry = sqlQuery($aqry);
	if($isi = sqlArray($qry)){
		//get modul akses ----------------------
		for($i=0;$i< sizeof($usr->DaftarModulsLabel) ;$i++){
			$fname = 'modul'.genNumber(($i+1),2);//'modul01';
			$fvalue[] = $isi[$fname];
		}
	}
	//$fvalue[]=$uid;	$fvalue[]=$aqry;
	return $fvalue;
}

function cekNoTable($tblname, $fieldNo, $fieldTgl, $noValue, $tglValue){
	$cnt = 0;
	$aqry = "select count(*) as cnt from $tblname where $fieldNo='$noValue' and year($fieldTgl)='$tglValue'";
	$qry = sqlQuery($aqry);
	if($isi = sqlArray($qry)){
		$cnt= $isi['cnt'];
	}
	return $cnt==0;
}

function genNoTable($tblname, $fieldNo, $fieldTgl){
	//$aqry = "select (max(coalesce($fieldNo))+1) as maxno from $tblname where year(fieldTgl) ";
	$aqry = "select max(coalesce($fieldNo,0)) as maxno from $tblname where year($fieldTgl) ";
	$qry = sqlQuery($aqry);
	if($isi = sqlArray($qry)){
		$maxno=$isi['maxno'];
		if ($maxno=='') {
			$maxno=1;
		}else{
			$maxno++;
		}
		return genNumber( $maxno,5);
	}
}

function setcookie_pejabat(
	 $fmnm_pejabat, $fmjbt_pejabat, $fmnip_pejabat,
		$fmnm_petugas, $fmjbt_petugas, $fmnip_petugas)
{

	setcookie('fmnm_pejabat', $fmnm_pejabat);
	setcookie('fmjbt_pejabat', $fmjbt_pejabat);
	setcookie('fmnip_pejabat', $fmnip_pejabat);
	setcookie('fmnm_petugas', $fmnm_petugas);
	setcookie('fmjbt_petugas', $fmjbt_petugas);
	setcookie('fmnip_petugas', $fmnip_petugas);
}
function getcookie_pejabat(){
	global $HTTP_COOKIE_VARS;

	$fmnm_pejabat  =  $_COOKIE['fmnm_pejabat'];
	$fmjbt_pejabat =  $_COOKIE['fmjbt_pejabat'];
	$fmnip_pejabat =  $_COOKIE['fmnip_pejabat'];
	$fmnm_petugas  = $_COOKIE['fmnm_petugas'] ;
	$fmjbt_petugas =  $_COOKIE['fmjbt_petugas'];
	$fmnip_petugas =  $_COOKIE['fmnip_petugas'] ;

	return array (
		'fmnm_pejabat'=>$fmnm_pejabat, 'fmjbt_pejabat'=>$fmjbt_pejabat, 'fmnip_pejabat'=>$fmnip_pejabat,
		'fmnm_petugas'=>$fmnm_petugas, 'fmjbt_petugas'=>$fmjbt_petugas, 'fmnip_petugas'=>$fmnip_petugas);
}

//app obj ==========================================================================
class AppCls{
	//global $Main;

	public $appTitle, $appCopyRight;
	public $HTMLStyle, $HTMLScript, $HTMLHead, $HTMLFoot;


	//constructor
	function AppCls($appTitle_='', $appCopyRight_=''){
		$this->appTitle = $appTitle_;
		$this->appCopyRight = $appCopyRight_;
	}


	function genHTMLHead($OtherCSS='', $OtherScript='', $pathjs=''){
		global $Main;

		return
			"<head>
	<title>$Main->Judul</title>
	<meta name='format-detection' content='telephone=no'>
	<meta name='ROBOTS' content='NOINDEX, NOFOLLOW'>


<link rel='stylesheet' type='text/css' href='css/fonts/fonts.css' />
<link rel='stylesheet' href='../../maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css' />


<link rel='stylesheet' href='assets/css/material-kit.min790f.css?v=2.0.1'>

<link href='assets/assets-for-demo/demo.css' rel='stylesheet'/>
<link href='assets/assets-for-demo/vertical-nav.css' rel='stylesheet'/>
<style type='text/css' media='screen'>
a {
    color: #4a4a4a !important;
    text-decoration: none !important;
    font-size: 13px !important;
}
th{
    padding: 8px;
}

    .blue{
      border:2px solid #1ABC9C;
    }

    .blue thead{
      background:#1ABC9C;
    }

    .purple{
      border:2px solid #9B59B6;
    }

    .purple thead{
      background:#9B59B6;
    }
    .scrollMore{
      margin-top:600px;
    }

    .col-centered{
      float: none;
      margin: 0 auto;
    }
thead {
    font-size: 11px;
    border-bottom: 2px solid #f76060;
    background: #1b7ed4;
}
.table thead tr th {
    font-size: 10px !important;
    font-weight: bold;
    color: white;
}

.fixed-bottom, .fixed-top {
    position: fixed;
    right: 0;
    left: 0;
    z-index: 985;
}
.card-collapse .card-body {
    padding-right: 11px;
    padding-left: 11px;
    padding-top: 6px;
}
.form-control, .is-focused .form-control {
    background-image: none;
}

.btn.btn-success {
    color: #fff;
    background-color: #484e48;
    border-color: #e8e8e8;
    box-shadow: 0 2px 2px 0 rgba(76,175,80,.14), 0 3px 1px -2px rgba(76,175,80,.2), 0 1px 5px 0 rgba(76,175,80,.12);
    padding: 4px;
    font-size: 11px;
    border-radius: 2px;
    width: 100px;
}

select, select.form-control {

    height: 24px;
    border-radius: 2px;
    padding-left: 9px;
    padding-right: 9px;
}
.table thead tr th {
    font-size: 12px;
    font-weight: bold;
}
.form-control {
	margin-bottom: 2px;
    margin-top: 2px;
    display: block !important;
    padding: 10px 7px !important;
    font-size: 12px !important;
    line-height: 1.5 !important;
    color: #495057 !important;
    background-color: #fff !important;
    background-clip: padding-box !important;
    border: 1px solid #a7aaad !important;
    border-radius: 2px !important;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out !important;
    height: 22px;
}

td {
    font-size: 11px !IMPORTANT;
}

</style>
	$OtherCSS



<script src='assets/js/core/jquery.min.js'></script>
<script src='assets/js/core/popper.min.js'></script>


<script src='assets/js/bootstrap-material-design.min.js'></script>



<!--  Google Maps Plugin  -->
<script type='text/javascript' src='https://maps.googleapis.com/maps/api/js?key=AIzaSyB2Yno10-YTnLjjn_Vtk0V8cdcY5lC4plU'></script>





<!--    Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
<script src='assets/js/plugins/nouislider.min.js'></script>



<!--    Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
<script src='assets/js/plugins/bootstrap-selectpicker.js'></script>

<!--    Plugin for Tags, full documentation here: http://xoxco.com/projects/code/tagsinput/  -->
<script src='assets/js/plugins/bootstrap-tagsinput.js'></script>

<!--    Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
<script src='assets/js/plugins/jasny-bootstrap.min.js'></script>

<!--    Plugin for Small Gallery in Product Page -->
<script src='assets/js/plugins/jquery.flexisel.js'></script>

<!-- Plugins for presentation and navigation  -->
<script src='assets/assets-for-demo/js/modernizr.js'></script>
<script src='assets/assets-for-demo/js/vertical-nav.js'></script>




<!-- Material Kit Core initialisations of plugins and Bootstrap Material Design Library -->

<!--  <script src='assets/js/material-kit.min790f.js?v=2.0.1'></script> -->


<!-- Fixed Sidebar Nav - js With initialisations For Demo Purpose, Don't Include it in your project -->
<script src='assets/assets-for-demo/js/material-kit-demo.js'></script>
























<!-- Sharrre libray -->
<script src='assets/assets-for-demo/js/jquery.sharrre.js'></script>

</script>


<script>

$(document).ready(function(){
    $('#twitter').sharrre({
      share: {
        twitter: true
      },
      enableHover: false,
      enableTracking: false,
      enableCounter: false,
      buttons: { twitter: {via: 'CreativeTim'}},
      click: function(api, options){
        api.simulateClick();
        api.openPopup('twitter');
      },
      template: '<i class='fa fa-twitter'></i> Twitter',
      url: 'http://demos.creative-tim.com/material-kit-pro/presentation.html'
    });

    $('#facebook').sharrre({
      share: {
        facebook: true
      },
      enableHover: false,
      enableTracking: false,
      enableCounter: false,
      click: function(api, options){
        api.simulateClick();
        api.openPopup('facebook');
      },
      template: '<i class='fa fa-facebook-square'></i> Facebook',
      url: 'http://demos.creative-tim.com/material-kit-pro/presentation.html'
    });

    $('#google').sharrre({
      share: {
        googlePlus: true
      },
      enableCounter: false,
      enableHover: false,
      enableTracking: true,
      click: function(api, options){
        api.simulateClick();
        api.openPopup('googlePlus');
      },
      template: '<i class='fa fa-google-plus'></i> Google',
      url: 'http://demos.creative-tim.com/material-kit-pro/presentation.html'
    });
});


var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-46172202-1']);
_gaq.push(['_trackPageview']);

(function() {
    var ga = document.createElement('script');
    ga.type = 'text/javascript';
    ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(ga, s);
})();

// Facebook Pixel Code Don't Delete
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
document,'script','../../connect.facebook.net/en_US/fbevents.js');

try{
    fbq('init', '111649226022273');
    fbq('track', 'PageView');

}catch(err) {
    console.log('Facebook Track Error:', err);
}

</script>



	<script src='assets/js/plugins/nouislider.min.js'></script>

	<script src='assets/js/material-kit.js?v=2.0.0'></script>

	<script language='JavaScript' src='lib/js/JSCookMenu_mini.js' type='text/javascript'></script>
	<script language='JavaScript' src='lib/js/ThemeOffice/theme.js' type='text/javascript'></script>
	<script language='JavaScript' src='lib/js/joomla.javascript.js' type='text/javascript'></script>
	<script src='js/jquery.js' type='text/javascript'></script>
	<script language='JavaScript' src='js/ajaxc2.js' type='text/javascript'></script>
	<script language='JavaScript' src='dialog/dialog.js' type='text/javascript'></script>
	<script language='JavaScript' src='js/global.js' type='text/javascript'></script>
	<script language='JavaScript' src='js/base.js' type='text/javascript'></script>
	<script language='JavaScript' src='js/encoder.js' type='text/javascript'></script>
	<script language='JavaScript' src='lib/chatx/chatx.js' type='text/javascript'></script>
	<script src='js/daftarobj.js' type='text/javascript'></script>
	<script src='js/pageobj.js' type='text/javascript'></script>
	<script>
		function getCookie(c_name){
			var i,x,y,ARRcookies=document.cookie.split(';');
			for (i=0;i<ARRcookies.length;i++)
			  {
			  x=ARRcookies[i].substr(0,ARRcookies[i].indexOf('='));
			  y=ARRcookies[i].substr(ARRcookies[i].indexOf('=')+1);
			  x=x.replace(/^\s+|\s+$/g,'');
			  if (x==c_name)
			    {
			    return unescape(y);
			    }
			  }
		}
		function setCookie(c_name,value){
			var c_value=escape(value);
			document.cookie=c_name + '=' + c_value;
		}
		function cekStatusWeb(){
			//console.log('ok');
			var off = getCookie('coOff');
			if(off=='1') {
				setCookie('coOff','0');
				alert('Silahkan login ulang!');

				window.location.href = window.location.href;
			}


		}
		//alert('tes');
		setInterval(function(){
			eval('cekStatusWeb()')
			},
			1000
		);
	</script>
	$OtherScript




	  <!-- calendar stylesheet -->
	  <link rel='stylesheet' type='text/css' media='all' href='js/jscalendar-1.0/calendar-win2k-cold-1.css' title='win2k-cold-1'>

	  <!-- main calendar program -->
	  <script type='text/javascript' src='js/jscalendar-1.0/calendar.js'></script>

	  <!-- language for the calendar -->
	  <script type='text/javascript' src='js/jscalendar-1.0/lang/calendar-id.js'></script>

	  <!-- the following script defines the Calendar.setup helper function, which makes
		   adding a calendar a matter of 1 or 2 lines of code. -->
	  <script type='text/javascript' src='js/jscalendar-1.0/calendar-setup.js'></script>

	  <script type='text/javascript'>


	  </script>


	<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
	<meta name='Generator' content='Joomla! Content Management System'>
	<!--<link rel='shortcut icon' href='http://localhost:90/dkk/images/favicon.ico'>-->

	</head>";


	}
	function genPageFoot($WithMarquee = TRUE){
		global $PATH_IMG;
		$copyright = "Copyright &copy; 2011. Dinas Pendapatan Pemerintah Kota Cimahi. Jl. Rd. Demang Hardjakusumah - Kota Cimahi. All right reserved.";
		$marq = $WithMarquee? "<marquee scrollamount='3' >
						$copyright
					</marquee>": $copyright;
		$align = $WithMarquee? '' : "align='center'";
		return
			"<table width='100%' cellspacing='0' cellpadding='0' border='0'><tr><td class='text_title' height='29' align='center' background='".$PATH_IMG."images/index_03.jpg' class='text_title'>
			$marq</td></tr></table>";
	}

	function genAppLogo($caption = 'SISTEM INFORMASI MANAJEMEN <BR>RUMAH SAKIT JIWA', $LOGOAPP=''){
		global $PATH_IMG;
		/*return
		"<table width='970' cellspacing='0' cellpadding='0' border='0'>
          <tbody><tr>
            <td width='31'>&nbsp;</td>
            <td width='179'><img width='179' height='83' src='images/simpada.gif'></td>
            <td width='25'>&nbsp;</td>
            <td width='455'><img width='455' height='83' src='images/siatem-informasi-manajemen-pajak-daerah.jpg'></td>
            <td width='248'><img width='248' height='83' src='images/dinas-pendapatan.gif'></td>
            <td width='32'>&nbsp;</td>
          </tr>
        </tbody></table>";*/

		return"
		<table width='970' border='0' cellpadding='0' cellspacing='0'>
          <tr>
            <td width='31'>&nbsp;</td>
            <td width='179'><img src='".$PATH_IMG."images/simpada.gif' width='179' height='83'></td>
            <td width='25'>&nbsp;</td>
            <td width='455'><img src='".$PATH_IMG."images/siatem-informasi-manajemen-pajak-daerah.jpg' width='455' height='83'></td>
            <td width='248'><img src='".$PATH_IMG."images/dinas-pendapatan.gif' width='248' height='83'></td>
            <td width='32'>&nbsp;</td>
          </tr>
        </table>";
	}

}
$APP_TITLE = '.:SIMPADA - Payment Point:.';
$app = new AppCls( $APP_TITLE, $APP_COPYRIGHT);


// form obj =======================================================================
class FormObj{
	var $form_width = '600';
	var $form_height = '439';
	var $form_caption = "User";
	var $form_menu_bawah_height = 22;
	var $form_fields =
			array(
				'field1' => array( 'label'=>'label1', 'value'=>'value1', 'type'=>'text' ),
				'field2' => array( 'label'=>'label1', 'value'=>'value2', 'type'=>'text' )
			);
	var $form_fmST ;
	var $form_idplh ;
	var $form_menubawah ;
	var $row_params;
	function setForm_content_fields($kolom1_width= 100){
		$content = '';

		foreach ($this->form_fields as $key=>$field){
			if ($field['type'] == ''){
				$val = $field['value'];
			}else{
				$val = Entry($field['value'],$key,'',$field['type']);
			}

			$content .=
				"<tr $this->row_params>
					<td style='width:$kolom1_width'>".$field['label']."</td>
					<td style='width:10'>:</td>
					<td>". $val."</td>
				</tr>";
		}
		//$content =
		//	"<tr><td style='width:100'>field</td><td style='width:10'>:</td><td>value</td></tr>";
		return $content;
	}
	function setForm_content(){
		$content = '';
		$content = $this->setForm_content_fields();

		$content =
			"<table style='width:100%' style=''><tr><td style='padding:4'>
				<table style='width:100%' >
				$content
				</table>
			</td></tr></table>";
		return $content;
	}
}

// daftar obj =======================================================================

class DaftarObj2{
	var $Prefix = 'pbb_penetapan_daftar'; //jsname
	var $SHOW_CEK = FALSE;
	var $withform = TRUE;
	//daftar -------------------
	//var $elCurrPage="HalDefault";
	var $TblName = 'pbb_entryawal'; //daftar
	var $TblName_Hapus = 'pbb_entryawal';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('Id'); //daftar/hapus
	var $FieldSum = array('luas_tanah');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 10, 9,9);//berdasar mode
	var $FieldSum_Cp2 = array( 0, 0,0);
	var $checkbox_rowspan = 1;
	var $totalCol = 11; //total kolom daftar
	var $fieldSum_lokasi = array( 10);  //lokasi sumary di kolom ke
	var $withSumAll = TRUE;
	var $withSumHal = TRUE;
	var $WITH_HAL = TRUE;
	var $totalhalstr = '<b>Total per Halaman';
	var $totalAllStr = '<b>Total';
	//cetak --------------------
	var $cetak_xls=FALSE ;
	var $fileNameExcel='tes.xls';
	var $Cetak_Judul;
	//var $Cetak_Header;
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;//="<link type='text/css' href='css/template_css.css' rel='stylesheet'>";
	var $namaModulCetak='REKAM MEDIS';
	//page ----------------------
	//var $Prefix='page'; //js object pake ini
	var $ToolbarAtas_edit ='';
	var $PageTitle = 'PBB - Penetapan';
	var $PageIcon = 'images/icon/daftar32.png';
	var $pagePerHal= '';
	var $FormName = 'adminForm';
	var $ico_width = 20;
	var $ico_height = 30;
	//form ---------------------
	//var $form_name = 'Usr_form';
	var $tblFormStyle = 'tblform';
	var $formLabelWidth = 100;
	var $form_width = '600';
	var $form_height = '439';
	var $form_caption = "User";
	var $form_menu_bawah_height = 22;
	var $form_fields =
			array(
				'field1' => array( 'label'=>'label1', 'value'=>'value1', 'type'=>'text', 'param'=>'' ),
				'field2' => array( 'label'=>'label1', 'value'=>'value2', 'type'=>'text' )
			);
	var $form_fmST ;
	var $form_idplh ;
	var $form_menubawah ;
		/*//sample
		"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan()' >
		"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >
		<input type='hidden' id='idplh' value='' >
		<input type='hidden' id='fmST' value='0' >";	*/
	var $multiselect = FALSE;
	//var $ms_contain = '';

	//user akses
	var $noModul = '';

	//daftar detail horisontal -----------------
	var $daftarMode = ''; //(''=normal,1=detail horisontal)
	var $tableWidth = '100%'; //width utk daftar master pada mode detail horison
	var $containWidth = '700';
	//var $tableAttribute = " border='1'   style='margin:4 0 0 0;width='100%' ";
	var $TampilFilterColapse = 1; //0
	var $TampilFilterColapseMin = 37;

	//multi select ==========================
	function getNmMsCbxPilihFilter(){
		return $this->Prefix.'_cbxpilihfilter';
	}
	function getNmMsJmlPilih(){
		return $this->Prefix.'_ms_jmlpilih';
	}
	function get_multiselect_contain(){
		global $HTTP_COOKIE_VARS;

		$cbx = $_REQUEST[$this->getNmMsCbxPilihFilter()];
		$checked = $cbx==1 ? "checked='true'" : '';
		$id_el =  $this->Prefix. '_pilihan_msg';
		$jmlpilih =0;// $_REQUEST[$this->getNmMsJmlPilih()];

		$idpilihan = $HTTP_COOKIE_VARS[$this->Prefix.'_DaftarPilih'];
		if($idpilihan != ''){
			$arrid = array();
			$arrid = explode(',',$idpilihan);
			$jmlpilih = count($arrid);
		}

		//if ($jmlpilih == '' ) $jmlpilih = 0;
		return "<div id='$id_el' name='$id_el' style='float:right;padding: 4 4 4 8;'>".
				"<div style='float:left;padding:2'>Terpilih: </div>".
				"<div id='".$this->getNmMsJmlPilih()."' name='".$this->getNmMsJmlPilih()."' style='float:left;padding:2'>$jmlpilih</div>".
				"<div style='float:left'>".
					"<input type='checkbox' id='".$this->getNmMsCbxPilihFilter()."' name='".$this->getNmMsCbxPilihFilter()."' value='1' ".
						" onclick='".$this->Prefix.".cbxFilterKlik(this)' $checked>".
				"</div>".
			"</div>";
	}

//inisial =======================================
	function DaftarObj2(){
		$this->form_menubawah =
			//"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan()' >
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
			//<input type='hidden' id='idplh' value='' >
			//<input type='hidden' id='fmST' value='0' >";
	/*
		$this->ToolbarAtas_edit =
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Baru()","new_f2.png","Baru",'')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Edit()","edit_f2.png","Ubah", '')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Hapus()","delete_f2.png","Hapus", '')."</td>";

		/*$this->Cetak_Judul =
			"<table width='100%' border=\"0\">
				<tr>
					<td align='right' colspan='4'>
						<span class='title2'>
							LAPORAN DAFTAR PENDATAAN
						</span>
					</td>
				</tr>
				<tr>
					<td align='right' colspan='4'>
						<span class='title1'>
							4.1.1.04.00 - PAJAK REKLAME
						</span>
					</td>
					<td colspan='4'><span class='title1'></span></td>
				</tr>
				<tr>
					<td><span class='title1'></span></td>
					<td colspan='4'><span class='title1'></span></td>
				</tr>
			</table>";*/

		/*$this->CetakHeader=
			$header =
			"<table style='width:100%' border=\"0\">
					<tr><td class=\"judulcetak\" align='center'>$JUDUL</td>	</tr>
				</table>
				<br>";*/



	}

//PROSES ========================================
	function Hapus_Validasi($id){
		$errmsg ='';
		/*if($errmsg=='' &&
				sqlRowCount(sqlQuery(
					"select Id from tagihan where ref_idpenetapan='".$id."'")
				) >0 )
			{ $errmsg = 'Gagal Hapus! SKPD Sudah ada di Tagihan!';}*/
		return $errmsg;
	}
	function Hapus_Data($id){//id -> multi id with space delimiter
		$err = ''; $cek='';
		$KeyValue = explode(' ',$id);
		$arrKondisi = array();
		for($i=0;$i<sizeof($this->KeyFields);$i++){
			$arrKondisi[] = $this->KeyFields[$i]."='".$KeyValue[$i]."'";
		}
		$Kondisi = join(' and ',$arrKondisi);
		if ($Kondisi !='')$Kondisi = ' Where '.$Kondisi;
		//$Kondisi = 	"Id='".$id."'";

		$aqry= "delete from ".$this->TblName_Hapus.' '.$Kondisi; $cek.=$aqry;
		$qry = sqlQuery($aqry);
		if ($qry==FALSE){
			$err = 'Gagal Hapus Data';
		}

		return array('err'=>$err,'cek'=>$cek);
	}
	function Hapus_Data_After($id){
		$err = ''; $content=''; $cek='';

		return array('err'=>$err, 'content'=>$content, 'cek'=>$cek);
	}
	function Hapus($ids){
		$err=''; $cek='';
		//$cid= $POST['cid'];
		//$err = ''.$ids;
		for($i = 0; $i<count($ids); $i++)	{
			$err = $this->Hapus_Validasi($ids[$i]);

			if($err ==''){
				$get = $this->Hapus_Data($ids[$i]);
				$err = $get['err'];
				$cek.= $get['cek'];
				if ($errmsg=='') {
					$after = $this->Hapus_Data_After($ids[$i]);
					$err=$after['err'];
					$cek=$after['cek'];
				}
				if ($err != '') break;

			}else{
				break;
			}
		}
		return array('err'=>$err,'cek'=>$cek);
	}
	function SimpanValidasi($fmST){
		$err = '';
		switch ($fmST){
			case 0 : { //baru
				break;
			}
			case 1: {//edit
				break;
			}
		}
		return $err;
	}
	function simpan($fmST, $tblsimpan='', $fieldKey='', $fieldKeyVal='', $fields = '', $fieldsval = '' ){
		/*$get = $this->simpan($fmST, 'barang_tidak_tercatat', 'Id', $id,
					"a1,a,b",
					array('a1'=>'11','a'=>'10','b'=>'00')
				);
		*/
		$Simpan = FALSE; $errmsg ='';$content=''; $cek='';

		$cek .= "fmst=$fmST ";
		switch ($fmST){
			case 0 : { //baru
				//generate fields update -------------------
				$aqry  = "insert into $tblsimpan (".implode(',',array_keys($fieldsval)).
					") values (".implode(',',array_values($fieldsval)).") ;";
				$cek .= $aqry;
				$Simpan = sqlQuery($aqry);
				if ($Simpan == FALSE) $errmsg = 'Gagal Simpan Data !';//.$aqry;
				break;
			}
			/*case 1: { //edit
				//validasi edit()
				$errmsg = $this->SimpanValidasi($fmST);
				if($errmsg == ''){
					//create kondisi key ----------------------
					$fid = array();
					if ($fieldKey == '' ){
						$fid[] = 'Id'; //default
						$valId[] = $fieldKeyVal;
					}else{
						$fid = $fieldKey;//explode(',',$fieldKeyStr);
						$valId = $fieldKeyVal;//explode(',',$fieldKeyValStr);
					}
					$kondisi = '';
					for($i=0;$i<sizeof($fid);$i++) $kondisi .= $fid[$i]." = '".$valId[$i]."'";
					if ($kondisi != '') $kondisi = " where $kondisi";
					//generate fields update -------------------
					$arrfieldupd = array();
					$arrfields = $fields;//explode(',',$fields);
					$arrfieldsval = $fieldsval;// explode(',',$fieldsval);
					for($i=0;$i<sizeof($arrfields);$i++) $arrfieldupd[] = $arrfields[$i]." = '".$arrfieldsval[$i]."'";
					$fieldupd = join(',',$arrfieldupd);
					if ($fieldupd != '') $fieldupd = " set $fieldupd";
					//update tabel -----------------------------
					$aqry  = "update $tblsimpan $fieldupd $kondisi"; $cek.=$aqry;
					$Simpan = sqlQuery($aqry);
					if ($Simpan == FALSE) $errmsg = 'Gagal Update Data !';//.$aqry;
				}
				break;
			}*/
			case 1: { //edit2
				//validasi edit()
				$errmsg = $this->SimpanValidasi($fmST);
				if($errmsg == ''){
					//create kondisi key ----------------------
					$fid = array();
					if ($fieldKey == '' ){
						$fid[] = 'Id'; //default
						$valId[] = $fieldKeyVal;
					}else{
						$fid = $fieldKey;//explode(',',$fieldKeyStr);
						$valId = $fieldKeyVal;//explode(',',$fieldKeyValStr);
					}
					$kondisi = '';
					for($i=0;$i<sizeof($fid);$i++) $kondisi .= $fid[$i]." = '".$valId[$i]."'";
					if ($kondisi != '') $kondisi = " where $kondisi";
					//generate fields update -------------------
					$arrfieldupd = array();
					$arrfields = $fields;//explode(',',$fields);
					$arrfieldsval = $fieldsval;// explode(',',$fieldsval);
					//for($i=0;$i<sizeof($arrfields);$i++) $arrfieldupd[] = $arrfields[$i]." = '".$arrfieldsval[$i]."'";
					foreach( $fieldsval as $key=>$val) {
						$arrfieldupd[] = $key." = ".$val."";
					}
					$fieldupd = join(',',$arrfieldupd);
					if ($fieldupd != '') $fieldupd = " set $fieldupd";
					//update tabel -----------------------------
					$aqry  = "update $tblsimpan $fieldupd $kondisi"; $cek.=$aqry;
					$Simpan = sqlQuery($aqry);
					if ($Simpan == FALSE) $errmsg = 'Gagal Update Data !';//.$aqry;
				}
				break;
			}

		}
		return array('err'=>$errmsg, 'content'=>$content, 'cek'=>$cek);
	}

	function simpanData($fmST, $tblsimpan='',  $fieldKey='',  $fieldval = '' ){
		/* --------
			fieldkey -> array ('id'=>10')
			fieldval -> array ('tgl'=>'2012-01-01')
		*/
		$Simpan = FALSE; $errmsg ='';$content=''; $cek='';
		switch ($fmST){
			case 0 : { //baru
				//generate fields insert -------------------
				$aqry  = "insert into $tblsimpan (".implode(',',array_keys($fieldval)).
					") values (".implode(',',array_values($fieldval)).") ;";
				$cek .= $aqry;
				$Simpan = sqlQuery($aqry);
				if ($Simpan == FALSE) $errmsg = 'Gagal Simpan Data !';//.$aqry;
				break;
			}
			case 1: { //edit2
				//validasi edit()
				$errmsg = $this->SimpanValidasi($fmST);
				if($errmsg == ''){
					//create kondisi key ----------------------
					$kondisi = '';
					$arrkond = array();
					foreach( $fieldKey as $key=>$val) {
						$arrkond[] = $key." = ".$val."";
					}
					$kondisi = join(',',$arrkond);
					if ($kondisi != '') $kondisi = " where $kondisi";
					//generate fields update -------------------
					$arrfieldupd = array();
					foreach( $fieldval as $key=>$val) {
						$arrfieldupd[] = $key." = ".$val."";
					}
					$fieldupd = join(',',$arrfieldupd);
					if ($fieldupd != '') $fieldupd = " set $fieldupd";
					//update tabel -----------------------------
					$aqry  = "update $tblsimpan $fieldupd $kondisi"; $cek.=$aqry;
					$Simpan = sqlQuery($aqry);
					if ($Simpan == FALSE) $errmsg = 'Gagal Update Data !';//.$aqry;
				}
				break;
			}

		}
		return array('err'=>$errmsg, 'content'=>$content, 'cek'=>$cek);
	}




function createHeaderPage($headerIco, $headerTitle,  $otherMenu='', $headerFixed= FALSE,
	$headerClass='pageheader',
	$ico_width=20, $ico_height=30 )
{
	global $Main;
	//$headerIco = 'images/icon/daftar32.png'; $headerTitle = 'Pendaftaran & Pendataan';
	$headerMenu = $Main->MenuHeader;
	$TampilPosFix = $headerFixed==TRUE? "position:fixed;top:0;":'';
	/*return
		"<table id='head' cellspacing='0' cellpadding='0' border='0' class='$headerClass' style='$TampilPosFix'>
			<tr class=''>
			<td width='36'><img src='$headerIco' ></td>
			<td>$headerTitle</td>
			<td>$otherMenu $headerMenu</td>
		</tr>
	</table>
	";
	*/

	return
	" <nav  class='navbar  bg-info   fixed-top  navbar-expand-lg '  id='sectionsNav' style='background-color: #ffffff!important;box-shadow: none;box-shadow: none;padding: 5px;border-bottom: 1px solid #9c9c9c;'>

    <div style='flex-wrap:  nowrap;width:  100%; '>

        <div class='navbar-translate' style='float: left;padding-left: 1%;'>
            <a  class='navbar-brand' href='./index.php' style='padding: 0% !important;'><img src='assets/img/logo.png' style='width: 100%;'>
             </a>

            <button class='navbar-toggler' type='button' data-toggle='collapse' aria-expanded='false' aria-label='Toggle navigation'>
                <span class='navbar-toggler-icon'></span>
                <span class='navbar-toggler-icon'></span>
                <span class='navbar-toggler-icon'></span>
            </button>
        </div>

        <div class='collapse navbar-collapse' style='float:  right;padding: 1%;z-index:0;'>
            <ul class='navbar-nav ml-auto'>






		".$this->setTopBar()."







            </ul>
        </div>


    </div>
</nav>
 <div class='navbar  bg-info   fixed-top  navbar-expand-lg '  id='sectionsNav' style='margin-top: 4%;z-index: 100;padding: 0%;background: #ebecec !important;'>

    <div style='flex-wrap:  nowrap;width:  100%;'>

        <div class='collapse navbar-collapse' style='float:  right;padding: 1%;'>
            <ul class='navbar-nav ml-auto'>


            <li class='nav-item' style='margin-right: 10px;margin-left: 10px;'>
 							<a data-toggle='collapse' href='#collapseOne' aria-expanded='true' aria-controls='collapseOne'>
 								<img src='images/administrator/images/search_f2.png'  alt='button' name='save'
 								width='22' height='22' border='0' align='middle'  />
 								Cari
 						</a>
 						</li>
      ".$this->setMenuEdit()."



            </ul>
        </div>
        <div class='collapse navbar-collapse' style='float:  left;padding: 1%;'>
              <span style='font-size: 17px; color:black'> ".$this->setTitle()."</span> &nbsp&nbsp &nbsp&nbsp
              ".$this->filterSaldoMiring($this->Prefix)."
        </div>
        <div id='accordion' role='tablist'>
  <div class='card card-collapse' style='
    border-top: 1px solid #5f5f5f;
' >


    <div onmouseover='$this->Prefix.bigImg()' onmouseout='$this->Prefix.normalImg()' id='collapseOne' class='collapse' role='tabpanel' aria-labelledby='headingOne' data-parent='#accordion' style='background: white;     padding-bottom: 7px;'>
      <div class='card-body' id='".$this->Prefix."_cont_opsi'>


      </div>
    </div>
  </div>
  </div>
    </div>
</div>";
}

//FORM ==========================================
	function setForm_content_fields(){
		$content = '';



		foreach ($this->form_fields as $key=>$field){

			$labelWidth = $field['labelWidth']==''? $this->formLabelWidth: $field['labelWidth'];
			$pemisah = $field['pemisah']==NULL? ':': $field['pemisah'];
			$row_params = $field['row_params']==NULL? $this->row_params : $field['row_params'];
			if ($field['type'] == ''){
				$val = $field['value'];
				$content .=
					"<tr $row_params>
						<td style='width:$labelWidth'>".$field['label']."</td>
						<td style='width:10'>$pemisah</td>
						<td>". $val."</td>
					</tr>";
			}else if ($field['type'] == 'merge' ){
				$val = $field['value'];
				$content .=
					"<tr $row_params>
						<td colspan=3 >".$val."</td>
					</tr>";
			}else{
				$val = Entry($field['value'],$key,$field['param'],$field['type']);
				$content .=
					"<tr $row_params>
						<td style='width:$labelWidth'>".$field['label']."</td>
						<td style='width:10'>$pemisah</td>
						<td>". $val."</td>
					</tr>";
			}

		}
		//$content =
		//	"<tr><td style='width:100'>field</td><td style='width:10'>:</td><td>value</td></tr>";
		return $content;
	}
	function setForm_content(){
		$content = '';
		$content = $this->setForm_content_fields();

		$content =
			"<table style='width:100%' class='$this->tblFormStyle'><tr><td style='padding:4'>
				<table style='width:100%' >
				$content
				</table>
			</td></tr></table>";
		return $content;
	}
	function setFormBaru(){
		$dt=array();

		$dt['tahun'] = 2012;
		$dt['nop_prop'] = '32';
		$dt['nop_kota'] = '17';
		//$dt['jnsjln_op'] = 0;
		//$dt['jln_no_op'] = '1';
		//$dt['jnsjln_wp'] = 0;
		//$dt['jln_no_wp'] = '1';

		$this->form_idplh ='';
		$this->form_fmST = 0;
		$this->setForm($dt);
	}
	function setFormEdit(){
		$cek ='';


		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$this->form_idplh = $cbid[0];
		$this->form_fmST = 1;

		//get data
		$aqry = "select * from pbb_entryawal where id =$this->form_idplh "; $cek.=$aqry;
		$dt = sqlArray(sqlQuery($aqry));

		//set form
		$this->setForm($dt);
		return array('cek'=>$cek);
	}
	function setForm($dt){
		$this->form_fields = array(
			//'no_sppt' => array( 'label'=>'No. SPPT', 'value'=> genNumber($get['no_terima'],5), 'type'=>'number', 'param'=>' maxlength=5 size=5 ' ),
			'no_sppt' => array( 'label'=>'No. SPPT', 'value'=> $dt['no_sppt'], 'type'=>'text', 'param'=>" title='No. SPPT' style='width: 318px;text-transform: uppercase;'"  ),
			'tahun' => array( 'label'=>'Tahun', 'value'=>$dt['tahun'], 'type'=>'number', 'param'=>' maxlength=4 size=4 ' )	,
			'labelobj' => array( 'label'=>'OBJEK PAJAK', 'value'=>'<b>OBJEK PAJAK', 'type'=>'merge' )	,
			'no_op' => array(
				'label'=>'NOP',
				'value'=>
				"<input type='text' readonly='' style='width:32;text-transform: uppercase;' maxlength='2' value='".$dt['nop_prop']."' name='nop_prop' id='nop_prop' >
				<input type='text' readonly='' style='width:32;text-transform: uppercase;' maxlength='2' value='".$dt['nop_kota']."' name='nop_kota' id='nop_kota'>
				<input type='text' style='width:48;text-transform: uppercase;' maxlength='3' value='".$dt['nop_kec']."' name='nop_kec' id='nop_kec' title='Kecamatan' onblur='fmKec.setKec()'>
				<input type='text' style='width:48;text-transform: uppercase;' maxlength='3' value='".$dt['nop_kel']."' name='nop_kel' id='nop_kel' title='Kelurahan' onblur='fmKel.setKel()'>
				<input type='text' style='width:48;text-transform: uppercase;' maxlength='3' value='".$dt['nop_blok']."' name='nop_blok' id='nop_blok' title='Blok'>
				<input type='text' style='width:72;text-transform: uppercase;' maxlength='4' value='".$dt['nop_urut']."' name='nop_urut' id='nop_urut' title='No Urut'>
				<input type='text' style='width:21;text-transform: uppercase;' maxlength='1' value='".$dt['nop_kode']."' name='nop_kode' id='nop_kode' title='Kode'>
				&nbsp <input type='button' title='Cek NOP' value='Cek NOP' onclick='".$this->Prefix.".cekNOP()'>"
				,
				'type'=>''
			),
			'alm_op' => array(
				'label'=>'Alamat',
				'value'=>
					/*"<select title='Jenis Jalan' id='jnsjln_op' name='jnsjln_op' style='margin: 0 4 0 0'>
						<option value=''></option>
						<option value='0'>Jl</option>
						<option value='1'>Gg</option>
					</select>".*/
					cmb2D_v2('jnsjln_op',$dt['jnsjln_op'], array(array('0','Jl.'),array('1','Gg.') ),'','').
					'&nbsp'.
					Entry($dt['jln_op'],'jln_op'," title='Nama Jalan' style='width: 170px;text-transform: uppercase;'",'text').
					'&nbsp No '.Entry($dt['jln_no_op'],'jln_no_op'," title='No Rumah/Lokasi' style='width: 79px;text-transform: uppercase;'",'text')
				,
				'type'=>''
			),
			//'kec_op' => array( 'label'=>'Kecamatan', 'value'=>'', 'type'=>'text' )	,
			//'kel_op' => array( 'label'=>'Kelurahan', 'value'=>'', 'type'=>'text' )	,
			'rw_rt_op' => array(
				'label'=>'RT / RW',
				'value'=>
					"<table width='320'><tr><td>".
						Entry($dt['rt_op'],'rt_op'," title='RT' style='width:50px;text-transform: uppercase;'",'text').' / '.
						Entry($dt['rw_op'],'rw_op'," title='RW' style='width:50px;text-transform: uppercase;'",'text').

					"</td><td align='right'>
					</td></tr></table>",
				'type'=>'' ),
			'kec_kel_op' => array(
				'label'=>'Kel. / Kec.',
				'value'=>
					Entry($dt['kel_op'],'kel_op'," readonly='' title='Kelurahan' style='width:154px;text-transform: uppercase;'",'text').' / '.
					Entry($dt['kec_op'],'kec_op'," readonly='' title='Kecamatan' style='width:154px;text-transform: uppercase;'",'text')
					 ,
				'type'=>'' ),
			'vluas' => array( 'label'=>'Luas (m2)',
				'value'=>
					'Tanah &nbsp;'.
					Entry($dt['luas_tanah'],'luas_tanah'," title='Tanah' style='width:100;text-transform: uppercase;' ",'number').
					'&nbsp;&nbsp; Bangunan &nbsp;'.
					Entry($dt['luas_bang'],'luas_bang'," title='Luas Bangunan' style='width:100;text-transform: uppercase;'",'number')
				, 'type'=>'' )	,
			'vnilaijual' => array( 'label'=>'Nilai Jual /m2 (Rp)',
				'value'=>
					'Tanah &nbsp;'.
					Entry($dt['nilai_tanah'],'nilai_tanah'," title='Tanah' style='width:100;text-transform: uppercase;' ",'number').
					'&nbsp;&nbsp; Bangunan &nbsp;'.
					Entry($dt['nilai_bang'],'nilai_bang'," title='Luas Bangunan' style='width:100;text-transform: uppercase;'",'number')
				, 'type'=>'' )	,
			'vklas' => array( 'label'=>'Klas',
				'value'=>
					'Tanah &nbsp;'.
					Entry($dt['klas_tanah'],'klas_tanah'," title='Tanah' style='width:100;text-transform: uppercase;' ",'text').
					'&nbsp;&nbsp; Bangunan &nbsp;'.
					Entry($dt['klas_bang'],'klas_bang'," title='Luas Bangunan' style='width:100;text-transform: uppercase;'",'text')
				, 'type'=>'' )	,
			'labelwp' => array( 'label'=>'SUBJEK PAJAK', 'value'=>'<b>SUBJEK PAJAK', 'type'=>'merge' )	,
			'npwp' => array(
				'label'=>'NPWP',
				'value'=> Entry($dt['npwp'],'npwp',"style='text-transform: uppercase;'",'text'),
				'type'=>''
			),
			'nama_wp' => array( 'label'=>'Nama', 'value'=>$dt['nama_wp'], 'param'=>"style='width: 318px;text-transform: uppercase;'", 'type'=>'text' )	,

			'alm_wp' => array(
				'label'=>'Alamat',
				'value'=>
					cmb2D_v2('jnsjln_wp',$dt['jnsjln_wp'], array(array('0','Jl.'),array('1','Gg.') ),'','').
					'&nbsp'.
					Entry($dt['jln_wp'],'jln_wp'," title='Nama Jalan' style='width: 170px;text-transform: uppercase;'",'text').
					'&nbsp No '.Entry($dt['jln_no_wp'],'jln_no_wp'," title='No Rumah\Lokasi' style='width: 79px;text-transform: uppercase;'",'text').
					"&nbsp <input type='button' title='Salin Alamat OP ke WP' value='Salin Alamat OP' onclick='".$this->Prefix.".salinAlmOp()'>"
				,
				'type'=>''
			),
			//'kec_wp' => array( 'label'=>'Kecamatan', 'value'=>'', 'type'=>'text' )	,	'kel_wp' => array( 'label'=>'Kelurahan', 'value'=>'', 'type'=>'text' )	,
			'rw_rt_wp' => array(
				'label'=>'RT / RW',
				'value'=>
					Entry($dt['rt_wp'],'rt_wp'," title='RT' style='width:50px;text-transform: uppercase;'",'text').' / '.
					Entry($dt['rw_wp'],'rw_wp'," title='RW' style='width:50px;text-transform: uppercase;'",'text'),

					//'&nbsp;&nbsp Kota '.Entry($dt['kota_wp'],'kota_wp'," title='Kota' style='width:175px;text-transform: uppercase;'",'text') ,
				'type'=>'' ),
			'kec_kel_wp' => array(
				'label'=>'Kel. / Kec.',
				'value'=>
					Entry($dt['kel_wp'],'kel_wp'," title='Kelurahan' style='width:154px;text-transform: uppercase;'",'text').' / '.
					Entry($dt['kec_wp'],'kec_wp'," title='Kecamatan' style='width:154px;text-transform: uppercase;'",'text')
					,
				'type'=>'' ),
			'kota_wp' => array(
				'label'=> 'Kota',
				'value'=> Entry($dt['kota_wp'],'kota_wp'," title='Kota' style='width:175px;text-transform: uppercase;'",'text') ,
				'type'=>''
			)

			//'rw_wp' => array( 'label'=>'RW', 'value'=>'', 'type'=>'text' )	,	'rt_wp' => array( 'label'=>'RT', 'value'=>'', 'type'=>'text' )	,
			//'kota_wp' => array( 'label'=>'Kota', 'value'=>'', 'type'=>'text' )	,
			/*'vluas_tanah' => array( 'label'=>'Luas Tanah (m2)',
				'value'=>
					Entry($dt['luas_tanah'],'luas_tanah'," title='Luas Tanah' ",'number').'&nbsp;&nbsp; Klas Tanah &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;'.
					Entry($dt['klas_tanah'],'klas_tanah'," title='Klas Tanah' maxlength=3 size=3 ",'text')
				, 'type'=>'' )	,
			'vluas_bang' => array( 'label'=>'Luas Bangunan (m2)',
				'value'=>Entry($dt['luas_bang'],'luas_bang'," title='Luas Bangunan' ",'number').'&nbsp;&nbsp; Klas Bangunan '.
					Entry($dt['klas_bang'],'klas_bang'," title='Klas Bangunan' maxlength=3 size=3 ",'text')
				, 'type'=>'' )	,*/


			//'petugas' => array( 'label'=>'Petugas Penerima', 'value'=> $petugasvalue, 'type'=>'', ),

		);
		$this->form_width = 700;
		$this->form_height = 400;



		if ($this->form_fmST==0) {
			$this->form_caption = 'Baru';
		}else{
			$this->form_caption = 'Edit';
		}
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan2()' >".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";

		//return $content;

	}
	function genForm_menubawah_add($content, $insert=FALSE){
		if($insert){
			$this->form_menubawah = $content.$this->form_menubawah;
		}else{
			$this->form_menubawah .= $content;
		}
	}

	function genForm_nodialog(){
		global $app, $Main;
		//$this->setFormBaru();
		$paddingMenuRight = 8;
		$paddingMenuLeft = 8;
		$paddingMenuBottom = 9;
		$menuHeight=22;
		echo
				//"<html xmlns='http://www.w3.org/1999/xhtml'>".
				"<html>".
					/*"<head>".
						$Main->HTML_Title.
						$Main->HTML_Meta.
						$Main->HTML_Link.
						$this->setPage_OtherStyle().

						//$Main->HTML_Script.
						"<script type='text/javascript' src='".$pathjs."js/base.js' language='JavaScript'></script>
						<script type='text/javascript' src='".$pathjs."js/jquery.js' language='JavaScript'></script>
						<script type='text/javascript' src='".$pathjs."js/ajaxc2.js' language='JavaScript' ></script>
						<script type='text/javascript' src='".$pathjs."js/dialog.js' language='JavaScript' ></script>
						<script type='text/javascript' src='".$pathjs."js/usr.js' language='JavaScript' ></script>".
						//$this->setPage_OtherScript().
						"<script type='text/javascript' src='pages/pendataan/modul_entry.js' language='JavaScript' ></script>
						<script type='text/javascript' src='js/dialog1.js' language='JavaScript' ></script>
						<script type='text/javascript' src='js/jquery.js' language='JavaScript' ></script>".
						"<script type='text/javascript' src='js/pbbobj.js' language='JavaScript' ></script>".
						"<script type='text/javascript' src='js/".strtolower($this->Prefix).".js' language='JavaScript' ></script>".
						//$scriptload;
						"<script>

						</script>".
					"</head>".*/
					//$this->genHTMLHead().
					$app->genHTMLHead(
						$this->setPage_OtherStyle(),
						$this->setPage_OtherScript_nodialog()
					).
					"<body onload='".$this->Prefix.".formNoDialog_show()'>".
					"<table id='KerangkaHal' class='menubar' cellspacing='0' cellpadding='0' border='0' width='100%' height='100%' >".
						//header page -------------------
						"<tr height='34'><td>".
							//$this->setPage_Header().
							//createHeaderPage($this->PageIcon, $this->PageTitle).
							createHeaderPage($this->PageIcon, $this->PageTitle,
								'', FALSE, 'pageheader', $this->ico_width, $this->ico_height
							).
							"<div id='header'></div>".
						"</td></tr>".
						//$OtherHeaderPage.
						//Content ------------------------
						"<tr height='*' valign='top'> <td style='padding:0 8 0 8'>".

								//Form ------------------

								//$this->setPage_Content().
								$this->setForm_content().
								"<div style='padding: 0 $paddingMenuRight $paddingMenuBottom $paddingMenuLeft;height:$menuHeight; '>
								<div style='float:right;'>".
									$this->form_menubawah.
									"<input type='hidden' id='".$this->Prefix."_idplh' name='".$this->Prefix."_idplh' value='$this->form_idplh' >
									<input type='hidden' id='".$this->Prefix."_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >".

								"</div>
								</div>".
							"</form>".

						"</td></tr>".
						//$OtherContentPage.
						//Footer ------------------------
						"<tr><td height='29' >".
							//$app->genPageFoot(FALSE).
							$Main->CopyRight.
						"</td></tr>".
						$OtherFooterPage.
					"</table>".
					"</body>
				</html>";
	}

	function genForm2($withForm=TRUE){
		$form_name = $this->Prefix.'_form';

		if($withForm){
			$params->tipe=1;
			$form= "<div class='wew'><form name='$form_name' id='$form_name' method='post' action=''>".
				createDialog(
					$form_name.'_div',
					$this->setForm_content(),
					$this->form_width,
					$this->form_height,
					$this->form_caption,
					'',
					$this->form_menubawah.
					"<input type='hidden' id='".$this->Prefix."_idplh' name='".$this->Prefix."_idplh' value='$this->form_idplh' >
					<input type='hidden' id='".$this->Prefix."_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >"
					,//$this->setForm_menubawah_content(),
					$this->form_menu_bawah_height,
					'',$params
					).
				"</form></div>";

		}else{
			$form=
				createDialog(
					$form_name.'_div',
					$this->setForm_content(),
					$this->form_width,
					$this->form_height,
					$this->form_caption,
					'',
					$this->form_menubawah.
					"<input type='hidden' id='".$this->Prefix."_idplh' name='".$this->Prefix."_idplh' value='$this->form_idplh' >
					<input type='hidden' id='".$this->Prefix."_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >"
					,//$this->setForm_menubawah_content(),
					$this->form_menu_bawah_height
				);


		}
		return $form;
	}


	function genForm($withForm=TRUE, $params=NULL, $center=TRUE){
		$form_name = $this->Prefix.'_form';

		if($withForm){
			$form= "<form name='$form_name' id='$form_name' method='post' action=''>".
				createDialog(
					$form_name.'_div',
					$this->setForm_content(),
					$this->form_width,
					$this->form_height,
					$this->form_caption,
					'',
					$this->form_menubawah.
					"<input type='hidden' id='".$this->Prefix."_idplh' name='".$this->Prefix."_idplh' value='$this->form_idplh' >
					<input type='hidden' id='".$this->Prefix."_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >"
					,//$this->setForm_menubawah_content(),
					$this->form_menu_bawah_height,'',$params).
				"</form>";

		}else{
			$form=
				createDialog(
					$form_name.'_div',
					$this->setForm_content(),
					$this->form_width,
					$this->form_height,
					$this->form_caption,
					'',
					$this->form_menubawah.
					"<input type='hidden' id='".$this->Prefix."_idplh' name='".$this->Prefix."_idplh' value='$this->form_idplh' >
					<input type='hidden' id='".$this->Prefix."_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >"
					,//$this->setForm_menubawah_content(),
					$this->form_menu_bawah_height,'',$params
				);


		}

		if($center){
			$form = centerPage( $form );
		}

		return $form;
	}
//DAFTAR ========================================
	function setTitle(){
		//return 'Daftar Penetapan SPPT';
		return $this->PageTitle;
	}
	function setMenuEdit(){
		/*$buttonEdits = array(
			array('label'=>'SPPT Baru', 'icon'=>'new_f2.png','fn'=>"javascript:".$this->Prefix.".Baru()" )
		);*/
		return
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Baru()","new_f2.png","Baru",'Baru')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Edit()","edit_f2.png","Edit", 'Edit')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Hapus()","delete_f2.png","Hapus", 'Hapus')."</td>";
			//"<td>".genPanelIcon("javascript:".$this->Prefix.".Hapus()","delete_f2.png","Recycle Bin", 'Batalkan SPPT')."</td>";
	}
	function setMenuView(){
		return
			//"<td>".genPanelIcon("javascript:".$this->Prefix.".cetakHal(\"$Op\")","print_f2.png","SPPT",'Cetak SPPT')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".cetakHal(\"$Op\")","print_f2.png",'Halaman',"Cetak Daftar per Halaman")."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".cetakAll(\"$Op\")","print_f2.png",'Semua',"Cetak Semua Daftar")."</td>";
			//"<td>".genPanelIcon("javascript:".$this->Prefix.".cetakHal(\"$Op\")","print_f2.png","Excel",'Export ke Excell')."</td>";
			//"<td>".genPanelIcon("javascript:".$this->Prefix.".cetakHal(\"$Op\")","edit_f2.png","Default",'Setting Default')."</td>";
	}
	function genMenu(){
		global $HTTP_COOKIE_VARS;
		$MyModulKU = explode(".", $HTTP_COOKIE_VARS["coModul"]);

		if($this->noModul !=''){
			$menuedit = '';
			if( $MyModulKU[$this->noModul-1 ] == '1' ) {
				$menuedit = $this->setMenuEdit();
			}
		}else{
			$menuedit = $this->setMenuEdit();
		}
		$SubTitle_menu =
			"".
			$menuedit.//$this->SetPage_ToolbarAtasEdit().
			$this->setMenuView().
			"";
		return $SubTitle_menu;
	}
	function setTopBar(){
		// if($this->TampilFilterColapse == 1){
		// 	$col = //"<div id='tes'  style='cursor:pointer;float:right; padding: 2 0 0 0'>".
		// 			"<table width='100%'><tr><td>".
		// 			"<a href='javascript:".$this->Prefix.".daftarOpsiColapse(".$this->TampilFilterColapseMin.")' style='float:right'>".
		// 			"<table ><tr>".
		// 			"<td>Pencarian </td>".
		// 			"<td><img id='".$this->Prefix."_slide_img' src='images/tumbs/up_2.png' ></td>".
		// 			"</tr></table></a>".
		// 			"</td></tr></table>"
		// 			//"</div>"
		// 			;
		// }
    //
		// return ''.genSubTitle($this->genMenu()).''.
		// 	$col
		// 	;
    return
    "



    <li class='nav-item' style='margin-right: 10px;margin-left: 10px;'>
      <a href='index.php' class='toolbar' id= href= title=>
        <img src='images/administrator/images/home_48.png'  alt='button' name='save'
        width='22' height='22' border='0' align='middle'  />
        Home
      </a>
      </li>

    <li class='nav-item' style='margin-right: 10px;margin-left: 10px;'>
      <a href='index.php?Pg=LogOut' class='toolbar' id= href= title=>
        <img src='images/administrator/images/logout.png'  alt='button' name='save'
        width='22' height='22' border='0' align='middle'  />
        Logout
      </a>
      </li>";
	}
	function getDaftar_limit($Mode=1){
		global $Main;
		$Limit=''; $NoAwal = 0;
		$pagePerHal = $this->pagePerHal==''? $Main->PagePerHal : $this->pagePerHal;
		//limit --------------------------------------
		$HalDefault=cekPOST($this->Prefix.'_hal',1);//cekPOST('HalDefault',1);
		$Limit = " limit ".(($HalDefault	*1) - 1) * $pagePerHal.",".$pagePerHal; //$LimitHal = '';
		$Limit = $Mode == 3 ? '': $Limit;
		//noawal ------------------------------------
		$NoAwal= $pagePerHal * (($HalDefault*1) - 1);
		$NoAwal = $Mode == 3 ? 0: $NoAwal;

		return array('Limit'=>$Limit, 'NoAwal' => $NoAwal);
	}
	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID'];
		//kondisi -----------------------------------

		$fmSTATUS = cekPOST('fmSTATUS');
		//$tgl = explode('-',$fmTGLTERIMA);
		$arrKondisi = array();
		//default ----------------
		//$arrKondisi[] = " uid='$UID'";

		$fmPILCARI = cekPOST('fmPILCARI');
		$fmPILCARIVALUE = cekPOST('fmPILCARIVALUE');
		switch($fmPILCARI){
			case '1': $arrKondisi[] = " concat(nop_prop,'.',nop_kota,'.',nop_kec,'.',nop_kel,'.',nop_blok,'.',nop_urut,'.',nop_kode) like '%$fmPILCARIVALUE%'"; break;
			case '2': $arrKondisi[] = " lpad(no_sppt,5,'0') like '%$fmPILCARIVALUE%'"; break;
			case '3': $arrKondisi[] = " nama_wp like '%$fmPILCARIVALUE%'"; break;

		}
		switch($fmSTATUS){
			case '1': $arrKondisi[] = " status_batal <> 3 and status_batal <> 4 "; break;
			case '2': $arrKondisi[] = " status_batal = 3 "; break;
			case '3': $arrKondisi[] = " status_batal = 4 "; break;
		}

		$fmPILKAS = cekPOST('fmPILKAS');
		if( !empty($fmPILKAS) ) $arrKondisi[] = " ref_admin_group='$fmPILKAS'";
		$Kondisi= join(' and ',$arrKondisi);
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');
		$Asc = $fmDESC1 ==''? '': 'desc';
		$arrOrders = array();
		switch($fmORDER1){
			case '1': $arrOrders[] = " no_terima $Asc " ;break;
			case '2': $arrOrders[] = " i $Asc " ;break;
		}
		$Order= join(',',$arrOrders);
		$OrderDefault = '';// Order By no_terima desc ';
		$Order =  $Order ==''? $OrderDefault : ' Order By '.$Order;
		//limit --------------------------------------
		$pagePerHal = $this->pagePerHal =='' ? $Main->PagePerHal: $this->pagePerHal;
		$HalDefault=cekPOST($this->Prefix.'_hal',1);
		//$Limit = " limit ".(($HalDefault	*1) - 1) * $Main->PagePerHal.",".$Main->PagePerHal; //$LimitHal = '';
		$Limit = " limit ".(($HalDefault	*1) - 1) * $pagePerHal.",".$pagePerHal; //$LimitHal = '';
		$Limit = $Mode == 3 ? '': $Limit;
		//noawal ------------------------------------
		$NoAwal= $pagePerHal * (($HalDefault*1) - 1);
		$NoAwal = $Mode == 3 ? 0: $NoAwal;

		$vKondisi2_old = '';
		return array('Kondisi'=>$Kondisi, 'Order'=>$Order ,'Limit'=>$Limit, 'NoAwal'=>$NoAwal, 'vKondisi2_old'=>$vKondisi2_old);

	}
	function genDaftarOpsi(){
		global $Ref, $Main;
		$arr = array(
			array('1','No. NOP'),
			array('2','No. SPPT'),
			array('3','Nama Subjek Pajak'),
			);
		$arr1 = array(
			array('1','No. NOP'),
			array('2','No. SPPT'),
			array('3','Nama Subjek Pajak'),
		);
		$arrStat = array(
			array('1','Tidak Batal'),
			array('2','Batal'),
			array('3','Dihapus'),
		);
		$arrKec = array();
		$arrKel = array();
		$fmTGLTERIMA = date('Y-m-d');//default
		$fmTGLTERIMA2 = date('Y-m-d');
		$TampilOpt =
			genFilterBar(
				array(
					'Cari Data ',
					cmbArray('fmPILCARI',$fmPILCARI,$arr,'-- Berdasarkan --','').
					"&nbsp;<input type='text' value='$fmPILCARIVALUE' id='fmPILCARIVALUE' name='fmPILCARIVALUE'>"
				)
				,$this->Prefix.".refreshList(true)",TRUE, 'Cari').
			genFilterBar(
				array(
					'Tampilkan',
					cmbArray('fmPilKec',$fmPilKec,$arrKec,'Semua Kecamatan',''),
					cmbArray('fmPilKel',$fmPilKel,$arrKel,'Semua Kelurahan',''),
					cmbArray('fmPilThn',$fmPilThn,$arrThn,'Semua Tahun',''),
					"Data per Halaman &nbsp;&nbsp; <input type='textbox' id='jmlPerHal' value='$Main->PagePerHal' style='width:50'>"

				)
				,'',FALSE,'').
			/*genFilterBar(
				array(
					'Lokasi &nbsp; '.
					genComboBoxQry( 'fmPILKAS', $fmPILKAS,
						"select Id, uraian from admin_group ",
						'Id', 'uraian', '-- Semua Lokasi Kas --',"style='width:140'" ),
					//"Penerima &nbsp; <input id='fmNmPenerima' name='fmNmPenerima' value='$fmNmPenerima'>"
					"Status &nbsp;".cmbArray('fmSTATUS',$fmSTATUS,$arrStat,'-- Semua Status --','')

				)
				,'',FALSE).*/
			genFilterBar(
				array(
					'Urutkan &nbsp;',
					cmbArray('fmORDER1',$fmORDER1,$arr1,'-- Berdasarkan --','')."<input type='checkbox' id='fmDESC1' name='fmDESC1' value='1'>Menurun"
				)
				,$this->Prefix.".refreshList(true)",TRUE, 'Tampilkan');


		return array('TampilOpt'=>$TampilOpt);
	}
	function setKolomHeader($Mode=1, $Checkbox=''){
		$NomorColSpan = $Mode==1? 2: 1;
		$headerTable =
			"<thead>
				<tr>
				<th class='th02' colspan=$NomorColSpan>Nomor</th>
				<th class='th01' rowspan=2>NOP dan LETAK <br>OBJEK PAJAK</th>
				<th class='th01' rowspan=2>NPWP, NAMA dan ALAMAT <br> SUBJEK PAJAK</th>
				<th class='th01' rowspan=2width='60'>TAHUN</th>
				<th class='th02' colspan=4 width='200'>OBJEK PAJAK BUMI</th>
				<th class='th02' colspan=4 width='200'>OBJEK PAJAK BANGUNAN</th>
				<th class='th01' rowspan=2>TOTAL NJOP <br>BUMI dan BANGUNAN<br>(Rp)</th>
				<th class='th01' rowspan=2>Total NJOPPTKP<br>(Rp)</th>
				<th class='th01' rowspan=2>Total NJOP DIKURANGI NJOPPTKP<br>(Rp)</th>
				<th class='th01' rowspan=2>PBB TERHUTANG<br>(Rp)</th>
				<th class='th01' rowspan=2>TGL. SPPT/<br>TGL. J. TEMPO/<br>STATUS</th>
				<th class='th01' rowspan=2>UPDATE <br>TERAKHIR</th>
				</tr>
				<tr>
				$Checkbox
				<th class='th01' width='40'>No.</th>
				<th class='th01' width='70'>Luas <br>(m2)</th>
				<th class='th01' width='70'>Kelas</th>
				<th class='th01' width='70'>per m2<br>(Rp)</th>
				<th class='th01' width='70'>Total NJOP<br>(Rp)</th>


				<th class='th01' width='70'>Luas <br>(m2)</th>
				<th class='th01' width='70'>Kelas</th>
				<th class='th01' width='70'>per m2<br>(Rp)</th>
				<th class='th01' width='70'>Total NJOP<br>(Rp)</th>

				</tr>
			</thead>";
		return $headerTable;
	}
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
		global $Ref;
		$arrStatus = array ('','','', 'Batal','Dihapus');
		$nop = $isi['nop_prop'].'.'.
			$isi['nop_kota'].'.'.
			$isi['nop_kec'].'.'.
			$isi['nop_kel'].'.'.
			$isi['nop_blok'].'.'.
			$isi['nop_urut'].'.'.
			$isi['nop_kode'];
			 //genNumber($isi['no_terima'],5);

		$almop .= $isi['jnsjln_op']==1?"Gg. ":"Jl. ";
		$almop .= !empty($isi['jln_op'])?"".$isi['jln_op']:"";
		$almop .= !empty($isi['jln_no_op'])?"&nbsp;No. ".$isi['jln_no_op']:"";
		$almop .= !( $isi['rt_op'].$isi['rw_op'] =='' ) ? "&nbsp;RT/RW: ".$isi['rt_op']."/".$isi['rw_op'] : "";
		$almop .= !empty($isi['kel_op'])?"<br>KEL: ".$isi['kel_op']:"";
		$almop .= !empty($isi['kec_op'])?"<br>KEC: ".$isi['kec_op']:"";

		//$almop .= !empty($isi['kota_op'])?"<br>".$isi['kota_op']:"";

		$almwp .= $isi['jnsjln_wp']==1?"Gg. ":"Jl. ";
		$almwp .= !empty($isi['jln_wp'])?"".$isi['jln_wp']:"";
		$almwp .= !empty($isi['jln_no_wp'])?"&nbsp;No. ".$isi['jln_no_wp']:"";
		$almwp .= !( $isi['rt_wp'].$isi['rw_wp'] =='' ) ? "&nbsp;RT/RW: ".$isi['rt_wp']."/".$isi['rw_wp'] : "";
		$almwp .= !empty($isi['kel_wp'])?"<br>KEL: ".$isi['kel_wp']:"";
		$almwp .= !empty($isi['kec_wp'])?"<br>KEC: ".$isi['kec_wp']:"";
		$almwp .= !empty($isi['kota_wp'])?"<br>".$isi['kota_wp']:"";

		$wp = !empty($isi['npwp'])? $isi['npwp'].'<br>' : '-<br>';
		$wp .= $isi['nama_wp'];

		$Koloms = array();
		if ($Mode == 1) $Koloms[] = array(" align='center'  ", $TampilCheckBox);
		$Koloms[] = array('align=right', $no.'.' );
		$Koloms[] = array('', $nop.'<br>'.$almop);
		$Koloms[] = array('', $wp.'<br>'.$almwp );
		$Koloms[] = array('align=right', $isi['tahun'] );

		$Koloms[] = array('align=right', $isi['luas_tanah'] );
		$Koloms[] = array('align=right', $isi['klas_tanah'] );
		$Koloms[] = array('align=right', $isi['perm2_tanah'] );
		$Koloms[] = array('align=right', $isi['total_tanah'] );

		$Koloms[] = array('align=right', $isi['luas_bang'] );
		$Koloms[] = array('align=right', $isi['klas_bang'] );
		$Koloms[] = array('align=right', $isi['perm2_bang'] );
		$Koloms[] = array('align=right', $isi['total_bang'] );

		$Koloms[] = array('align=right', $isi['total_njop'] );

		$Koloms[] = array('align=right', $isi['k13'] );
		$Koloms[] = array('align=right', $isi['k14'] );
		$Koloms[] = array('align=right', $isi['k15'] );
		$Koloms[] = array('align=right', $isi['k16'] );

		$Koloms[] = array('align=right', $isi['update'] );




		return $Koloms;
	}

	function genDaftarHeader($Mode=1){
		//mode :1.;ist, 2.cetak hal, 3. cetak semua
		global $Main;
		$rowspan_cbx = $this->checkbox_rowspan >1 ? "rowspan='$this->checkbox_rowspan'":'';
		$Checkbox = $Mode==1?
			"<th class='th01' width='10' $rowspan_cbx style='text-align:center;'>
					<input type='checkbox' name='".$this->Prefix."_toggle' id='".$this->Prefix."_toggle' value='' ".
						//" onClick=\"checkAll4($Main->PagePerHal,'".$this->Prefix."_cb','".$this->Prefix."_toggle','".$this->Prefix."_jmlcek');\" /> ".
						" onClick=\"checkAll4($Main->PagePerHal,'".$this->Prefix."_cb','".$this->Prefix."_toggle','".$this->Prefix."_jmlcek');".
							"$this->Prefix.checkAll($Main->PagePerHal,'".$this->Prefix."_cb','".$this->Prefix."_toggle','".$this->Prefix."_jmlcek')\" /> ".

			" </th>" : '';
		$headerTable = $this->setKolomHeader($Mode, $Checkbox);
		return $headerTable;
	}
	function setDaftar_query($Kondisi='', $Order='', $Limit=''){
		$aqry = "select * from $this->TblName $Kondisi $Order $Limit ";
		return $aqry;
	}
	function setDaftar_after_getrow($list_row, $isi){
		return $list_row;
	}
	function setDaftar_before_getrow($no, $isi, $Mode, $TampilCheckBox,
			$RowAtr, $KolomClassStyle)
	{
		$ListData ='';
		/*$Koloms = $this->setKolomData($no,$isi,$Mode, $TampilCheckBox);
		$list_row = genTableRow($Koloms,
						$RowAtr." valign='top' id='$cb' value='".$isi['Id']."'",$ColStyle);
		$ListData = $this->setDaftar_after_getrow($list_row, $isi);*/
		return array ('ListData'=>$ListData, 'no'=>$no);
	}
	function setCekBox($cb, $KeyValueStr, $isi){
		$hsl = '';
		if($KeyValueStr!=''){


			$hsl = "<input type='checkbox' id='".$this->Prefix."_cb$cb' name='".$this->Prefix."_cb[]'
					value='".$KeyValueStr."' onClick=\"isChecked2(this.checked,'".$this->Prefix."_jmlcek');".
					"$this->Prefix.cbxPilih(this) \" />";
		}
		return $hsl;
	}

	function setDaftar_After($no=0, $ColStyle=''){
		$ListData = '';
		/*$list_row = genTableRow($Koloms,
						$rowatr_,
						$ColStyle);
		*/
		return $ListData;
	}





	function genDaftar($Kondisi='', $Order='', $Limit='', $noAwal=0, $Mode=1, $vKondisi_old=''){
		//$Mode -> 1. daftar, 2. cetak hal, 3.cetak all
		$cek =''; $err='';

		$MaxFlush=$this->MaxFlush;
		$headerTable = $this->genDaftarHeader($Mode);
		$TblStyle =	$this->TblStyle[$Mode-1];//$Mode ==1 ? 'koptable': 'cetak';
		$genTable = $this->genTableAttribute($TblStyle);
		$ListData =
			$genTable.
			$headerTable.
			"<tbody>";

		$ColStyle = $this->ColStyle[$Mode-1];//$Mode==1? 'GarisDaftar':'GarisCetak';
		$no=$noAwal; $cb=0; $jmlDataPage =0;
		$TotalHalRp = 0;

		//$aqry = "select * from $this->TblName $Kondisi $Order $Limit ";	//echo $aqry;
		//$qry = sqlQuery($aqry);
		$aqry = $this->setDaftar_query($Kondisi, $Order, $Limit); $cek .= $aqry.'<br>';
		$qry = sqlQuery($aqry);
		$numrows = sqlRowCount($qry); $cek.= " jmlrow = $numrows ";
		if( $numrows> 0 ) {

		while ( $isi=sqlArray($qry)){
			if ( $isi[$this->KeyFields[0]] != '' ){

			$no++;
			$jmlDataPage++;
			if($Mode == 1) $RowAtr = $no % 2 == 1? "class='row0'" : "class='row1'";

			$KeyValue = array();
			for ($i=0; $i< sizeof($this->KeyFields) ; $i++) {
				$KeyValue[$i] = $isi[$this->KeyFields[$i]];
			}
			$KeyValueStr = join(' ',$KeyValue);
			$TampilCheckBox =  $this->setCekBox($cb, $KeyValueStr, $isi);//$Cetak? '' :

			//sum halaman
			for ($i=0; $i< sizeof($this->FieldSum) ; $i++) {
				$this->SumValue[$i] += $isi[$this->FieldSum[$i]];
			}

			//---------------------------
			//$rowatr_ = $RowAtr." valign='top' id='$cb' value='".$isi['Id']."'";
			$rowatr_ = $RowAtr." valign='top' id='$cb' value='".$KeyValueStr."'";
			$bef= $this->setDaftar_before_getrow(
					$no,$isi,$Mode, $TampilCheckBox,
					$rowatr_,
					$ColStyle
					);
			$ListData .= $bef['ListData'];
			$no = $bef['no'];
			//get row
			$Koloms = $this->setKolomData($no,$isi,$Mode, $TampilCheckBox);	$cek .= $Koloms;
			$list_row = $this->genTableRow($Koloms,
						$rowatr_,
						$ColStyle,$no);


			$ListData .= $this->setDaftar_after_getrow($list_row, $isi , $no, $Mode, $TampilCheckBox,
				$RowAtr, $ColStyle);

			$cb++;

			if( ($Mode == 3 ) && ($cb % $MaxFlush==0) && $cb >0 ){
				echo $ListData;
				ob_flush();
				flush();
				$ListData='';
				//sleep(2); //tes
			}
			}
		}

		}

		$ListData .= $this->setDaftar_After($no, $ColStyle);
		//total -----------------------
		if ($Mode==3) {	//flush
			echo $ListData;
			ob_flush();
			flush();
			$ListData='';
			$SumHal = $this->genSumHal($Kondisi);
		}
		//$SumHal = $this->genSumHal($Kondisi);
		$ContentSum = $this->genRowSum($ColStyle,  $Mode,
			$SumHal['sums']
		);
		/*$TampilTotalHalRp = number_format($TotalHalRp,2, ',', '.');
		$TotalColSpan = $this->FieldSum_Cp1[$Mode-1];//$Mode ==1 ? 5 : 4;
		$ContentTotalHal =
			"<tr>
				<td class='$ColStyle' colspan='$TotalColSpan' align='center'><b>Total per Halaman</td>
				<td class='$ColStyle' align='right'><b>$TampilTotalHalRp</td>
				<td class='$ColStyle' colspan='4'></td>
			</tr>" ;

		$ContentTotal =
				"<tr>
					<td class='$ColStyle' colspan='$TotalColSpan' align='center'><b>Total</td>
					<td class='$ColStyle' align='right'><b><div  id='cntDaftarTotal'>".$SumHal['sum']."</div></td>
					<td class='$ColStyle' colspan='4'></td>
				</tr>" ;

		if($Mode == 2){
			$ContentTotal = '';
		}else if($Mode == 3){
			$ContentTotalHal='';
		}
		$ContentSum=$ContentTotalHal.$ContentTotal;
		*/

		$ListData .=
				//$ContentTotalHal.$ContentTotal.

				$ContentSum.
				"</tbody>".
			"</table>
			<input type='hidden' id='".$this->Prefix."_jmldatapage' name='".$this->Prefix."_jmldatapage' value='$jmlDataPage'>
			<input type='hidden' id='".$this->Prefix."_jmlcek' name='".$this->Prefix."_jmlcek' value=''>"
			.$vKondisi_old
			;
		if ($Mode==3) {	//flush
			echo $ListData;
		}

		return array('cek'=>$cek,'content'=>$ListData, 'err'=>$err);
	}

	function genRowSum_setTampilValue($i, $value){

		return number_format($value,2, ',', '.');
	}
	function genRowSum_setColspanTotal($Mode, $colspanarr ){
		$TotalColSpan1 = $Mode==1? $colspanarr[0]-1 : $colspanarr[0]-2;
		return $TotalColSpan1;
	}
	function genRowSum($ColStyle, $Mode, $Total){
		//hal
		$ContentTotalHal=''; $ContentTotal='';

		//if (sizeof($this->FieldSum)>0){
		if (sizeof($this->FieldSum)==1){

			$TampilTotalHalRp = $this->genRowSum_setTampilValue(0, $this->SumValue[0]);//number_format($this->SumValue[0],2, ',', '.');
			$TotalColSpan1 = $this->FieldSum_Cp1[$Mode-1];//$Mode ==1 ? 5 : 4;
			$TotalColSpan2 = $this->FieldSum_Cp2[$Mode-1];//$Mode ==1 ? 5 : 4;
			$Kiri1 = $TotalColSpan1 > 0 ? "<td class='$ColStyle' colspan='$TotalColSpan1' align='center'><b>Total per Halaman</td>": '';
			$Kanan1 = $TotalColSpan2 > 0 ? "<td class='$ColStyle' colspan='$TotalColSpan2' align='center'></td>": '';
			$Kiri2 = $TotalColSpan1 > 0 ? "<td class='$ColStyle' colspan='$TotalColSpan1' align='center'><b>Total</td>": '';
			$Kanan2 = $TotalColSpan2 > 0 ? "<td class='$ColStyle' colspan='$TotalColSpan2' align='center'></td>": '';
			$ContentTotalHal =
				"<tr>
					$Kiri1
					<!--<td class='$ColStyle' colspan='$TotalColSpan' align='center'><b>Total per Halaman</td>-->
					<td class='$ColStyle' align='right'><b>$TampilTotalHalRp</td>
					$Kanan1<!--<td class='$ColStyle' colspan='4'></td>-->
				</tr>" ;

			$ContentTotal =
				"<tr>
					$Kiri2
					<td class='$ColStyle' align='right'><b><div  id='{$this->Prefix}_cont_sum'>".$Total[0]."</div></td>
					$Kanan2
				</tr>" ;



		}else if (sizeof($this->FieldSum)>1){

			$colspanarr=$this->fieldSum_lokasi;
			$ContentTotalHal =	"<tr>";
			$ContentTotal =	"<tr>";


			for ($i=0; $i<sizeof($this->FieldSum);$i++){

				if($i==0){
					$TotalColSpan1 =  //$Mode==1? $colspanarr[0]-1 : $colspanarr[0]-2  ;
						$this->genRowSum_setColspanTotal($Mode, $colspanarr );
					$Kiri1 = $TotalColSpan1 > 0 ?
						"<td class='$ColStyle' colspan='$TotalColSpan1' align='center'>$this->totalhalstr</td>": '';
					$ContentTotalHal .=	$Kiri1;
					$ContentTotal .=	$TotalColSpan1 > 0 ?
						"<td class='$ColStyle' colspan='$TotalColSpan1' align='center'>$this->totalAllStr</td>":'';
				}else{
					$TotalColSpan1 = $colspanarr[$i] - $colspanarr[$i-1]-1;
					//if($TotalColSpan1>0){
					$ContentTotalHal .=	$TotalColSpan1 > 0 ?
						"<td class='$ColStyle' colspan='$TotalColSpan1' align='center'></td>": '';
					$ContentTotal .=	$TotalColSpan1 > 0 ?
						"<td class='$ColStyle' colspan='$TotalColSpan1' align='center'></td>": '';

					//}
				}
				//$totalstr = $i==0? "<b>Total per Halaman": '';
				////$TotalColSpan1 = $colspanarr[$i]- $colspanarr[$i-1]-1;
				//$Kiri1 = $TotalColSpan1 > 0 ? "<td class='$ColStyle' colspan='$TotalColSpan1' align='center'>$totalstr</td>": '';

				$TampilTotalHalRp = //number_format($this->SumValue[$i],2, ',', '.');
					$this->genRowSum_setTampilValue($i, $this->SumValue[$i]);
				$vTotal = number_format($Total[$i],2, ',', '.');
				$ContentTotalHal .= //$i==0?
					//"<td class='$ColStyle' align='right'><b>$TampilTotalHalRp</td>"	:
					"<td class='$ColStyle' align='right'><b>$TampilTotalHalRp</td>"	;
				$ContentTotal .= $i==0?
					"<td class='$ColStyle' align='right'><b><div  id='{$this->Prefix}_cont_sum'>".$Total[$i]."</div></td>":
					"<td class='$ColStyle' align='right'><b><div  id='{$this->Prefix}_cont_sum$i'>".$Total[$i]."</div></td>";
			}

			//$totrow = $Mode == 1? $this->totalRow : $this->totalRow;
			$TotalColSpan1 = $this->totalCol - $colspanarr[sizeof($this->FieldSum)-1];
			$ContentTotalHal .=	$TotalColSpan1 > 0 ?
						"<td class='$ColStyle' colspan='$TotalColSpan1' align='center'></td></tr>": '</tr>';
			$ContentTotal .= $TotalColSpan1 > 0 ?
						"<td class='$ColStyle' colspan='$TotalColSpan1' align='center'></td></tr>": '</tr>';


		}
		$ContentTotal = $this->withSumAll? $ContentTotal: '';
		$ContentTotalHal = $this->withSumHal? $ContentTotalHal: '';
		if($Mode == 2){
			$ContentTotal = '';
		}else if($Mode == 3){
			//$ContentTotalHal='';
			if ($this->withSumAll) {
				$ContentTotalHal = '';
			}
		}
		return $ContentTotalHal.$ContentTotal;
	}

	function genRowSum_($ColStyle, $Mode, $Total){
		//hal
		$ContentTotalHal=''; $ContentTotal='';

		if (sizeof($this->FieldSum)>0){

			$TampilTotalHalRp = number_format($this->SumValue[0],2, ',', '.');
			$TotalColSpan1 = $this->FieldSum_Cp1[$Mode-1];//$Mode ==1 ? 5 : 4;
			$TotalColSpan2 = $this->FieldSum_Cp2[$Mode-1];//$Mode ==1 ? 5 : 4;
			$Kiri1 = $TotalColSpan1 > 0 ? "<td class='$ColStyle' colspan='$TotalColSpan1' align='center'><b>Total per Halaman</td>": '';
			$Kanan1 = $TotalColSpan2 > 0 ? "<td class='$ColStyle' colspan='$TotalColSpan2' align='center'></td>": '';
			$Kiri2 = $TotalColSpan1 > 0 ? "<td class='$ColStyle' colspan='$TotalColSpan1' align='center'><b>Total</td>": '';
			$Kanan2 = $TotalColSpan2 > 0 ? "<td class='$ColStyle' colspan='$TotalColSpan2' align='center'></td>": '';
			$ContentTotalHal =
				"<tr>
					$Kiri1
					<!--<td class='$ColStyle' colspan='$TotalColSpan' align='center'><b>Total per Halaman</td>-->
					<td class='$ColStyle' align='right'><b>$TampilTotalHalRp</td>
					$Kanan1<!--<td class='$ColStyle' colspan='4'></td>-->
				</tr>" ;

			$ContentTotal =
				"<tr>
					$Kiri2
					<td class='$ColStyle' align='right'><b><div  id='{$this->Prefix}_cont_sum'>".$Total."</div></td>
					$Kanan2
				</tr>" ;

			if($Mode == 2){
				$ContentTotal = '';
			}else if($Mode == 3){
				$ContentTotalHal='';
			}

		}
		return $ContentTotalHal.$ContentTotal;
	}
	function setDaftar_hal($jmlData){
		global $Main;
		$elhal = $this->Prefix.'_hal';
		$hal = cekPOST($this->Prefix.'_hal');
		$pagePerHal = $this->pagePerHal ==''? $Main->PagePerHal : $this->pagePerHal;
		return
			"<table class='koptable' border='0' width='100%' style='margin:4 0 0 0'>
			<tr><td align=center style='padding:4'>".
				Halaman2b(	$jmlData, $pagePerHal, $elhal, $hal, 5,

					$this->Prefix.'.gotoHalaman').


			"</td></tr></table>";

	}
	function setSumHal_query($Kondisi, $fsum){
		return "select $fsum from $this->TblName $Kondisi "; //echo $aqry;

	}
	function genSumHal($Kondisi){

		global $Main;
		//$Sum = 'sum'; $Hal = 'hal';
		$cek = '';
		$jmlData = 0;
		$jmlTotal = 0;
		$SumArr=array();
		$vSum = array();

		$fsum_ = array();
		$fsum_[] = "count(*) as cnt";
		//$i=0;
		foreach($this->FieldSum as &$value){
			$fsum_[] = "sum($value) as sum_$value";
			//$i++;
		}
		$fsum = join(',',$fsum_);

		$aqry = $this->setSumHal_query($Kondisi, $fsum); $cek .= $aqry;
		$qry = sqlQuery($aqry);
		if ($isi= sqlArray($qry)){
			$jmlData = $isi['cnt'];
			foreach($this->FieldSum as &$value){
				$SumArr[] = $isi["sum_$value"];
				$vSum[] = $this->genSum_setTampilValue(0, $isi["sum_$value"]);//Fmt($isi["sum_$value"],1);
			}
			if(sizeof($this->FieldSum)>0 )$Sum = $this->genSum_setTampilValue(0, $SumArr[0]);//number_format($SumArr[0], 2, ',' ,'.');

		}
		$Hal = $this->setDaftar_hal($jmlData);
		if ($this->WITH_HAL==FALSE) $Hal = '';
		return array('sum'=>$Sum, 'hal'=>$Hal, 'sums'=>$vSum, 'jmldata'=>$jmlData, 'cek'=>$cek );
	}
	function genSum_setTampilValue($i, $value){
		return number_format($value, 2, ',' ,'.');
	}


	function genTableAttribute ($class_){
		$tableAttribute = " border='1'   style='margin:4 0 0 0;width:'$this->tableWidth' id='".$this->Prefix."_table'";
		return "<div class='demo'><table class='table table-striped' $tableAttribute >";
	}
	function genTableRow($Koloms, $RowAtr='', $KolomClassStyle='', $cb=0){
		$baris = '';
		foreach ($Koloms as &$value) {
			$baris .= "<td class='$KolomClassStyle'  {$value[0]}>$value[1]</td>";
		}
		//id='".$this->Prefix."_cb$cb'
		//if (count($Koloms)>0){$baris ="<tr $RowAtr onclick=\"document.getElementById('".$this->Prefix."_cb$cb').click();".$this->Prefix.".rowOnClick(this)\ "> $baris </tr>"; }
		$cb_ = $cb-1;
		if (count($Koloms)>0){
			//isChecked2(document.document.getElementById('".$this->Prefix."_cb$cb').checked,'FarmasiPerencanaan_jmlcek');FarmasiPerencanaan.cbxPilih(document.getElementById('".$this->Prefix."_cb$cb'))
			//$baris ="<tr tes=1 $RowAtr onclick=\"isChecked2(document.getElementById('".$this->Prefix."_cb$cb_').checked,'FarmasiPerencanaan_jmlcek');FarmasiPerencanaan.cbxPilih(document.getElementById('".$this->Prefix."_cb$cb_'));".$this->Prefix.".rowOnClick(this)\"> $baris </tr>";
			$baris ="<tr $RowAtr onclick=\"".$this->Prefix.".rowOnClickEfek(this);".$this->Prefix.".rowOnClick(this)\" ondblclick=\"".$this->Prefix.".rowOnDblClick(this)\"> $baris </tr>";
		}
		return $baris;
	}
	function genTableDetail(){
		//return "tes";
		return '';
	}
	function genDaftarInitial(){
		$vOpsi = $this->genDaftarOpsi();

		$divHal = "<div id='{$this->Prefix}_cont_hal' style='position:relative;background: #e6e6e6;'>".
							"<input type='hidden' id='".$this->Prefix."_hal' name='".$this->Prefix."_hal' value='1'>".
						"</div>";
		switch($this->daftarMode){
			case '1' :{ //detail horisontal
				$vdaftar =
					"<table width='100%'><tr valign=top>
					<td style='width:$this->containWidth;'>".
						"<div id='{$this->Prefix}_cont_daftar' style='position:relative;width:$this->containWidth;overflow:auto' >"."</div>".
						$divHal.
					"</td>".
					"<td>".
						"<div id='{$this->Prefix}_cont_daftar_det' style=''>".$this->genTableDetail()."</div>".
					"</td>".
					"</tr></table>";
				break;
			}
			default :{
				$vdaftar =
					"<div id='{$this->Prefix}_cont_daftar' style='position:relative;margin-top: 5%;' >"."</div>".
					$divHal;
				break;
			}
		}

		return
			//$NavAtas.
			"<div id='{$this->Prefix}_cont_title' style='position:relative'></div>".
			"<div id='{$this->Prefix}_cont_skpd' name='{$this->Prefix}_cont_skpd'> </div> ".
			"<div id='{$this->Prefix}_cont_opsi' style='position:relative'>".
				//$vOpsi['TampilOpt'].
			"</div>".
			//"<div style='position:relative'>".
			$vdaftar.
			//"</div>".
			'';
	}

	/*function genDaftarInitial(){
		$vOpsi = $this->genDaftarOpsi();

		return
			//$NavAtas.
			"<div id='{$this->Prefix}_cont_title' style='position:relative'></div>".
			"<div id='{$this->Prefix}_cont_opsi' style='position:relative'>".
				//$vOpsi['TampilOpt'].
			"</div>".
			"<div id='{$this->Prefix}_cont_daftar' style='position:relative' >".
				//$this->genDaftar($Opsi['Kondisi'],$Opsi['Order'], $Opsi['Limit'], $Opsi['NoAwal']).
			"</div>".
			"<div id='{$this->Prefix}_cont_hal' style='position:relative'>".
				"<input type='hidden' id='".$this->Prefix."_hal' name='".$this->Prefix."_hal' value='1'>".
			"</div>";
	}
	*/
	/*
	function genSumHal2($Kondisi){
		global $Main;
		//$Sum = 'sum'; $Hal = 'hal';
		$jmlData = 0;
		$jmlTotal = 0;

		$aqry = "select count(*) as sum1, sum(jml_ketetapan) as sum2 from $this->TblName $Kondisi "; //echo $aqry;
		$qry = sqlQuery($aqry);
		if ($isi= sqlArray($qry)){
			$jmlData = $isi['sum1'];
			$jmlTotal= $isi['sum2'];
			$Sum = number_format($jmlTotal, 2, ',' ,'.');
			$Hal= "<table class='koptable' border='1' width='100%' style='margin:4 0 0 0'>
				<tr><td align=center style='padding:4'>".
					Halaman2b($jmlData,$Main->PagePerHal,"HalDefault",cekPOST('HalDefault'),5,'Penetapan.gotoHalaman').
				"</td></tr></table>";
		}

		return array('sum'=>$Sum, 'hal'=>$Hal);
	}*/
// menu ================================================================

//ajx proses ===========================================================
	function set_ajxproses_other_($idprs, $Opt){
		$ErrNo=0; $ErrMsg = ''; $content='tes'; $json=FALSE; $cek='';
		//---------
		return array('ErrNo'=>$ErrNo, 'ErrMsg'=>$ErrMsg, 'content'=> $content, 'json'=>$json ,'cek'=>$cek);
	}
	function set_ajxproses_($idprs, $Opt){
		$ErrNo=0; $ErrMsg = ''; $content=''; $json=FALSE; $cek ='';

		if ($idprs =='') {
			echo $this->setPage();
		}else{
			switch ($idprs){
				case 'list':{
					$Opsi = $this->getDaftarOpsi();	//$content = 'tes'.
					$content=
						array('list'=>
							$this->genDaftar(
								$Opsi['Kondisi'], $Opsi['Order'],
								$Opsi['Limit'], $Opsi['NoAwal'], 1
							)
						);
					$json= true;
					break;
				}
				case 'sumhal':{
					$Opsi = $this->getDaftarOpsi();
					$content = $this->genSumHal($Opsi['Kondisi']);
					$json= true;
					break;
				}
				case 'cetak_hal': {
					//echo $this->setCetak(2);
					//$this->genCetak(2,$Other,'30cm','DAFTAR NOTA HITUNG');
					$this->cetak_hal();
					break;
				}
				case 'cetak_all':{
					$this->cetak_all();
					//echo $this->setCetak(3);
					//$this->genCetak(3,$Other,'30cm','DAFTAR NOTA HITUNG');
					break;
				}
				case 'hapus':{
					$cbid= $_POST[$this->Prefix.'_cb'];
					$ErrMsg=//'hapus '.$cbstr;
						$this->Hapus($cbid);
					$json=TRUE;
					break;
				}

				/*case 'create_tahun':{
				$ErrMsg ='tes';//$this->create_tahun();
				$content = $_GET['thn'];
				$json = TRUE;
				break;
				}*/
				default :{
					//$TampilOpt = $Perhitungan->genDaftarOpsi();
					$other = $this->set_ajxproses_other($idprs,$Opt);
					$ErrNo = $other['ErrNo'];
					$ErrMsg = $other['ErrMsg'];
					$content = $other['content'];
					$json = $other['json'];
					$cek = $other['cek'];
					break;
				}
			}
		}



		return array('ErrNo'=>$ErrNo, 'ErrMsg'=>$ErrMsg, 'content'=> $content, 'json'=>$json, 'cek'=>$cek );
	}
	function ajxproses_(){
		$ErrMsg = ''; $cek='';
		if ($_GET['idprs'] != ''){
			$idprs = $_GET['idprs']; //echo ',idprs='.$idprs;
		}else{ //json
			$optstring = stripslashes($_GET['opt']);
			$Opt = json_decode($optstring); //$page = json_encode(",cek="+$Opt->idprs);
			$idprs = $Opt->daftarProses[$Opt->idprs];
		}

		$get = $this->set_ajxproses($idprs, $Opt);
		$ErrNo = $get['ErrNo'];
		$ErrMsg = $get['ErrMsg'];
		$content = $get['content'];
		$cek = $get['cek'];
		$json = $get['json'];
		if($json){ //json---
			$pageArr = array(
						'idprs'=>$Opt->idprs,
						'daftarProses'=>$Opt->daftarProses ,
						'ErrNo'=>$ErrNo,
						'ErrMsg'=>$ErrMsg,
						'content'=> $content ,
						'cek'=>$cek
					);
			$page = json_encode($pageArr);
			$page;
		}

		return $page;
	}
	function set_selector_other($tipe){
		$cek = ''; $err=''; $content=''; $json=FALSE;
		switch($tipe){
			default:{
				$err = 'tipe tidak ada!';
				break;
			}
		}
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}
	function selector(){
		global $Main;
		$cek = ''; $err=''; $content=''; $json=FALSE;
		$tipe = $_REQUEST['tipe'];
		//echo $tipe;
		if ($tipe==''){
			//$ModulAkses = isPageEnable('00','sum');
			//if ( $ModulAkses>0){
			//echo 'tes2';
			echo $this->pageShow();
					//echo $pbbPenetapan->ajxproses();
			//	}
		}else{
			switch($tipe){
				case 'subtitle':{
					// $content = $this->setTopBar();
					$json=TRUE;
					break;
				}
				case 'filter': {
					$opsi = $this->genDaftarOpsi();
					$content=$opsi['TampilOpt'];
					$json=TRUE;
					break;
				}
				case 'daftarkosong': {
					$Opsi = $this->getDaftarOpsi();

					$Opsi['Kondisi'] = 'Where 1=0' ;

					$daftar = $this->genDaftar($Opsi['Kondisi'],$Opsi['Order'], $Opsi['Limit'],  $Opsi['NoAwal'], 1, $Opsi['vKondisi_old']);

					//$daftar = $this->genDaftarKosong();
					$content=$daftar['content']	;
					$err = $daftar['err'];
					$cek .= $daftar['cek'];

					$json = TRUE;
					break;
				}
				case 'sumhalkosong':{
					$Opsi = $this->getDaftarOpsi();
					$Opsi['Kondisi'] = 'Where 1=0' ;
					$content = $this->genSumHal($Opsi['Kondisi']);
					$cek .= 'kondisi='.$Opsi['Kondisi'].'order='.$Opsi['Order'].'limit='.$Opsi['Limit'].'noawal='.$Opsi['NoAwal'];

					$json= true;
					break;
				}

				case 'daftar': {
					$Opsi = $this->getDaftarOpsi();
					$daftar = $this->genDaftar($Opsi['Kondisi'],$Opsi['Order'], $Opsi['Limit'],  $Opsi['NoAwal'], 1, $Opsi['vKondisi_old']);
					$content=$daftar['content']	;
					$err = $daftar['err'];
					$cek .= $daftar['cek'];
					$cek .= 'kondisi='.$Opsi['Kondisi'].'order='.$Opsi['Order'].
						' limit='.$Opsi['Limit'].
						' noawal='.$Opsi['NoAwal'] .
						' vkondisi='.$Opsi['vKondisi_old'];
					//$cek .= $daftar['cek'];
					$json = TRUE;
					break;
				}
				case 'sumhal':{
					$Opsi = $this->getDaftarOpsi();
					$content = $this->genSumHal($Opsi['Kondisi']);
					$cek .= 'kondisi='.$Opsi['Kondisi'].'order='.$Opsi['Order'].'limit='.$Opsi['Limit'].'noawal='.$Opsi['NoAwal'];

					$json= true;
					break;
				}
				case 'cetak_hal': {
					$this->cetak_hal();
					break;
				}
				case 'cetak_all':{
					$this->cetak_all();
					break;
				}
				case 'exportXls':{
					$this->exportExcel();
					break;
				}

				/*case 'formBaru':{
					//$content = 'form baru';
					$this->setFormBaru();
					$content= $this->genForm();
					$json = TRUE;
					break;
				}
				case 'formEdit':{
					if($err==''){
						$get = $this->setFormEdit(); $cek .= $get['cek'];
						$content= $this->genForm();
					}
					$json=TRUE;
					break;
				}*/
        case 'filterJenisSaldoChanged':{
          foreach ($_REQUEST as $key => $value) {
             $$key = $value;
          }
          $arrayJenisSaldo = array(
            array('1',"BANK"),
            array('2',"KAS")
          );
          if(empty($filterJenisTransaksi) && !isset($_REQUEST['filterJenisTransaksi'])){
            if($_COOKIE['coJenisTransaksi'] =='1'){
              $queryBankKas = "select id, nama_bank from ref_bank where 1=1 $this->allowIdBank";
              $filterBankKas = $_COOKIE['coIdBank'];
              $filterJenisTransaksi =1;
            }elseif($_COOKIE['coJenisTransaksi'] =='2'){
              $queryBankKas = "select id, nama_kas from ref_kas where 1=1 $this->allowIdKas";
              $filterJenisTransaksi =2;
              $filterBankKas = $_COOKIE['coIdKas'];
            }
          }else{
            if($filterJenisTransaksi == '1'){
              $queryBankKas = "select id, nama_bank from ref_bank where 1=1 $this->allowIdBank";
            }else{
              $queryBankKas = "select id, nama_kas from ref_kas where 1=1 $this->allowIdKas";
            }
            if(!empty($filterJenisTransaksi)){
              setCookie("coJenisTransaksi",$filterJenisTransaksi);
              if($filterJenisTransaksi == '1'){
                if(!empty($filterBankKas)){
                  $arrKondisi[] = "id_bank = '$filterBankKas'";
                  setCookie("coIdBank",$filterBankKas);
                }
              }else{
                if(!empty($filterBankKas)){
                  setCookie("coIdKas",$filterBankKas);
                }
              }
            }
          }
          if(!empty($this->oneJenisTransaksi)){
            if($this->oneJenisTransaksi == 1){
              $filterJenisTransaksi = 1;
              $queryBankKas = "select id, nama_bank from ref_bank where 1=1 $this->allowIdBank";
              $filterBankKas = $this->oneIdBank;
            }else{
              $filterJenisTransaksi = 2;
              $queryBankKas = "select id, nama_kas from ref_kas where 1=1 $this->allowIdKas";
              $filterBankKas = $this->oneIdKas;
            }
          }

          $content = array('filterBankKas' => cmbQuery("filterBankKas",$filterBankKas,$queryBankKas, "onchange=$Prefix.filterBankKasChanged()  ","-- NAMA BANK / KAS --" ));
					$json=TRUE;
					break;
				}
        case 'checkSisaSaldo':{
          foreach ($_REQUEST as $key => $value) {
             $$key = $value;
          }
          $content = array("spanFilterSaldo" => $this->getSisaSaldo($filterJenisTransaksi,$filterBankKas));

					$json=TRUE;
					break;
				}
				case 'hapus':{
					$cbid= $_POST[$this->Prefix.'_cb'];
					$get= $this->Hapus($cbid);
					$err= $get['err'];
					$cek = $get['cek'];
					$json=TRUE;
					break;
				}
				/*case 'simpan':{
					//$get = $this->Simpan();
					$get = array('cek'=>'', 'err'=>'ggal','content'=>'', 'json'=>TRUE);
					$cek = $get['cek'];
					$err = $get['err'];
					$content=$get['content'];
					$json=$get['json'];
					break;
				}*/
				default: {//other type
					//include('penetapan_list.php');
					$other = $this->set_selector_other($tipe);
					$cek = $other['cek'];
					$err = $other['err'];
					$content=$other['content'];
					$json=$other['json'];

					break;
				}
			}
			if($Main->SHOW_CEK==FALSE) $cek = '';
			if($json){
				$pageArr = array(
					'cek'=>$cek, 'err'=>$err, 'content'=>$content
				);
				$page = json_encode($pageArr);
				echo $page;
			}

		}


	}

//PAGE ===========================================
	function setPage_Header_($IconPage='', $TitlePage=''){
		//return createHeaderPage($IconPage, $TitlePage);
		return $this->createHeaderPage($IconPage, $TitlePage,
			'', FALSE, 'pageheader', $this->ico_width, $this->ico_height
		);
	}
	function setPage_Header(){
		//return createHeaderPage($this->PageIcon, $this->PageTitle);
		return $this->createHeaderPage($this->PageIcon, $this->PageTitle,
			'', FALSE, 'pageheader', $this->ico_width, $this->ico_height
		);
	}
	function setPage_OtherStyle(){
		/*return "<link type='text/css' href='css/pay.css' rel='stylesheet'>
						<link type='text/css' href='css/menu_pay.css' rel='stylesheet'>";
		*/
		return '';
	}


	function setPage_OtherScript(){
		$scriptload =
					"<script>
						$(document).ready(function(){
							".$this->Prefix.".loading();
						});

					</script>";

		return
			/*"<script type='text/javascript' src='js/dialog1.js' language='JavaScript' ></script>
			<script type='text/javascript' src='js/jquery.js' language='JavaScript' ></script>".			*/
			//"<script type='text/javascript' src='js/barcode.js' language='JavaScript' ></script>".
			//"<script type='text/javascript' src='js/skpd.js' language='JavaScript' ></script>".
			"<script type='text/javascript' src='js/".strtolower($this->Prefix).".js' language='JavaScript' ></script>".
			$scriptload;
	}
	function setPage_OtherScript_nodialog(){
		return "<script type='text/javascript' src='js/barcode.js' language='JavaScript' ></script>".
					"<script type='text/javascript' src='js/skpd.js' language='JavaScript' ></script>".
						"<script type='text/javascript' src='js/".strtolower($this->Prefix).".js' language='JavaScript' ></script>";
	}
	function setPage_IconPage(){
		return 'images/icon/daftar32.png';
	}
	function setPage_TitlePage(){
		$Op = $_GET['Op'];
				$NamaJnsPajak = get_kodrek_pad(genNumber($_GET['Op'],2 ) ,'00');
		return  $NamaJnsPajak.' - Nota Hitung';
	}
	function setPage_OtherHeaderPage(){
		return '';
	}
	function setPage_FormName(){
		return 'adminForm';
	}
	function setPage_hidden(){
		return genHidden(array('fmOp'=> genNumber($_GET['Op'],2) ));
	}
	function ToolbarAtasEdit_Add($label='',$ico='',$link='',$hint='',$insert=FALSE){
		if($insert){
			$this->ToolbarAtas_edit =
				"<td>".genPanelIcon($link,$ico,$label,$hint)."</td>".$this->ToolbarAtas_edit;
		}else{
			$this->ToolbarAtas_edit .=
				"<td>".genPanelIcon($link,$ico,$label,$hint)."</td>";
		}

		return $ToolbarAtas_edit;
	}
	function setPage_ToolbarAtasView(){
		return //"<td>".genPanelIcon("javascript:".$this->Prefix.".cetakHit()","print_f2.png","Cetak", 'Cetak Nota Hitung')."</td>
					"<td>".genPanelIcon("javascript:".$this->Prefix.".cetakHal(\"$Op\")","print_f2.png","Halaman")."</td>
					<td>".genPanelIcon("javascript:".$this->Prefix.".cetakAll(\"$Op\")","print_f2.png","Semua")."</td>";

	}
	function setPage_OtherInForm(){}
	function setPage_OtherContentPage(){

	}
	function setPage_OtherFooterPage(){}
	function genHTMLHead(){
		global $Main, $app;

		return $app->genHTMLHead($this->setPage_OtherStyle(), 	$this->setPage_OtherScript());
	}
	function setPage_HeaderOther(){
		return '';
	}
	function setNavAtas(){
		return '';//
			/*'<table cellspacing="0" cellpadding="0" border="0" width="100%"><tr>
					<td class="menudottedline" width="40%" height="20" style="text-align:right"><b>


	<a href="?Pg=05&amp;SPg=03" title="Buku Inventaris">BI</a> |
	<a href="?Pg=05&amp;SPg=04" title="Tanah">KIB A</a>  |
	<a href="?Pg=05&amp;SPg=05" title="Peralatan &amp; Mesin">KIB B</a>  |
	<a href="?Pg=05&amp;SPg=06" title="Gedung &amp; Bangunan">KIB C</a>  |
	<a href="?Pg=05&amp;SPg=07" title="Jalan, Irigasi &amp; Jaringan">KIB D</a>  |
	<a href="?Pg=05&amp;SPg=08" title="Aset Tetap Lainnya">KIB E</a>  |
	<a href="?Pg=05&amp;SPg=09" title="Konstruksi Dalam Pengerjaan">KIB F</a>  |
	<a href="?Pg=05&amp;SPg=11" title="Rekap BI">REKAP BI</a> |
	<a href="?Pg=05&amp;SPg=12" title="Daftar Mutasi">MUTASI</a>  |
	<a href="?Pg=05&amp;SPg=13" title="Rekap Mutasi">REKAP MUTASI</a> |
	<a href="pages.php?Pg=sensus" title="Sensus">SENSUS</a>
	  &nbsp;&nbsp;&nbsp;
	</b></td>
	</tr></table>';*/
	}
	function pageShow(){
		global $app, $Main;

		$navatas_ = $this->setNavAtas();
		$navatas = $navatas_==''? // '0': '20';
			'':
			"<tr><td height='20'>".
					$navatas_.
			"</td></tr>";
		$form1 = $this->withform? "<form name='$this->FormName' id='$this->FormName' method='post' action=''>" : '';
		$form2 = $this->withform? "</form >": '';

		return
		//"<html xmlns='http://www.w3.org/1999/xhtml'>".
		"<html>".
			$this->genHTMLHead().
			"<body >".
      $form1.
			/*"<div id='pageheader'>".$this->setPage_Header()."</div>".
			"<div id='pagecontent'>".$this->setPage_Content()."</div>".
			$Main->CopyRight.*/

			"<table id='KerangkaHal' class='menubar' cellspacing='0' cellpadding='0' border='0' width='100%' height='100%' >".
				//header page -------------------
				"<tr height='34'><td>".
					//$this->setPage_Header($IconPage, $TitlePage).
					$this->setPage_Header().
					"<div id='header' ></div>".
				"</td></tr>".
				$navatas.
				//$this->setPage_HeaderOther().
				//Content ------------------------
				//style='padding:0 8 0 8'
				"<tr height='*' valign='top'> <td >".

					$this->setPage_HeaderOther().
					"<div align='center' class='centermain' >".
					"<div class='main' >".


						//Form ------------------
						//$hidden.
						//genSubTitle($TitleDaftar,$SubTitle_menu).
						$this->setPage_Content().
						//$OtherInForm.

					$form2.//"</form>".
					"</div></div>".
				"</td></tr>".
				//$OtherContentPage.

			"</table>".
			"</body>
		</html>";
	}
	function setPage_Content(){

		//return "<div id='".$this->Prefix."_pagecontent'></div>";
		return $this->genDaftarInitial();

	}
//CETAK DAFTAR ===========================================
	function cetak_hal(){
		$this->Cetak_Mode=2;
		$this->genCetak();
	}
	function cetak_all(){
		$this->Cetak_Mode=3;
		$this->genCetak();
	}
	function exportExcel(){
		$this->Cetak_Mode=3;
		$this->genCetak(TRUE);
	}

	/*function setCetak_Mode($Mode){ return $Mode;}
	function setCetak_OtherHTMLHead($other=''){return $other;}
	function setCetak_WIDTH($width=30){return $width;}
	function setCetak_JUDUL($judul='Daftar'){return $judul;}
	function setCetak($Mode){
		return $this->genCetak(
					$this->setCetak_Mode($Mode),
					$this->setCetak_OtherHTMLHead(),
					$this->setCetak_WIDTH(),
					$this->setCetak_JUDUL()
				);
	}*/
	function setCetak_Header_(){
		global $Main;
		return
			"<table style='width:100%' border=\"0\"><tr>
			<td >".
				/*"<span class='title2'>PEMERINTAH KOTA CIMAHI</span><br>
				<span class='title3'>DINAS PENDAPATAN</span><br>
				<span class='title1'>Komplek Perkantoran Pemerintah Kota Cimahi</span><br>
				<span class='title1'>Jl. Rd. Demang Hardjakusuma Lt. 2 Telp/Fax (022) 6652559</span>"
				*/
				$Main->KopLogo.
			"</td>
			<td >".
				$this->Cetak_Judul.
			"</td>
			</tr></table>";
	}

	function setCetakTitle(){
		return	$this->Cetak_Judul;
	}

	function setCetak_Header($Mode=''){
		global $Main, $HTTP_COOKIE_VARS;

		/*$fmSKPD = cekPOST($this->Prefix.'SkpdfmSKPD'); //echo 'fmskpd='.$fmSKPD;
		$fmUNIT = cekPOST($this->Prefix.'SkpdfmUNIT');
		$fmSUBUNIT = cekPOST($this->Prefix.'SkpdfmSUBUNIT');*/



		return
			$Main->kopLaporan.
			"<table style='width:100%' border=\"0\">
			<tr>
				<td class=\"judulcetak\" align='center'>".strtoupper($this->setCetakTitle())."</td>
			</tr>
			</table>	".
			/*<table width=\"100%\" border=\"0\">
				<tr>
					<td class=\"subjudulcetak\">".PrintSKPD2($fmSKPD, $fmUNIT, $fmSUBUNIT)."</td>
				</tr>
			</table>*/
			"<br>";
	}
	//function genCetak($Mode=2, $OtherHTMLHead='', $WIDTH=30, $JUDUL=''){
	function setCetak_footer($xls=FALSE){
		return "<br>".
				$this->PrintTTD($this->Cetak_WIDTH, $xls);
	}


	function PrintTTD($pagewidth = '30cm', $xls=FALSE, $cp1='', $cp2='', $cp3='', $cp4='', $cp5='' ) {
	    global $fmWIL, $fmSKPD, $fmUNIT, $fmSUBUNIT, $fmTAHUNANGGARAN, $fmKEPEMILIKAN, $Main, $HTTP_COOKIE_VARS, $NAMASKPD, $JABATANSKPD, $NIPSKPD, $NAMASKPD1, $JABATANSKPD1, $NIPSKPD1, $TITIMANGSA;


	    $NIPSKPD = "";
	    $NAMASKPD = "";
	    $JABATANSKPD = "";
	    $TITIMANGSA = "Bandung, " . JuyTgl1(date("Y-m-d"));
	    if (c == '04') {
	        $Qry = sqlQuery("select * from ref_pejabat where c = '$fmSKPD' and d = '$fmUNIT' and e = '$fmSUBUNIT' and ttd1 = '1' ");
	    } else {
	        $Qry = sqlQuery("select * from ref_pejabat where c = '$fmSKPD' and d = '$fmUNIT' and e = '00' and ttd1 = '1' ");
	    }
	    while ($isi = sqlArray($Qry)) {
	        $NIPSKPD1 = $isi['nik'];
	        $NAMASKPD1 = $isi['nm_pejabat'];
	        $JABATANSKPD1 = $isi['jabatan'];
	    }
	    $Qry = sqlQuery("select * from ref_pejabat where c = '$fmSKPD' and d = '$fmUNIT' and e = '$fmSUBUNIT' and ttd2 = '1' ");
	    while ($isi = sqlArray($Qry)) {
	        $NIPSKPD2 = $isi['nik'];
	        $NAMASKPD2 = $isi['nm_pejabat'];
	        $JABATANSKPD2 = $isi['jabatan'];
	    }
		$NAMASKPD1 = $NAMASKPD1==''?'.................................................': $NAMASKPD1;
		$NAMASKPD2 = $NAMASKPD2==''?'.................................................': $NAMASKPD2;
		$NIPSKPD1 = $NIPSKPD1==''? 	'                                          ': $NIPSKPD1;
		$NIPSKPD2 = $NIPSKPD2==''? 	'                                          ': $NIPSKPD2;

		if($xls == FALSE){
			$vNAMA1	= "<INPUT TYPE=TEXT VALUE='($NAMASKPD1)' STYLE='background:none;border:none;text-align:center;font-weight:bold' size=50 >";
			$vNAMA2	= "<INPUT TYPE=TEXT VALUE='($NAMASKPD2)' STYLE='background:none;border:none;text-align:center;font-weight:bold' size=50 >";
			$vNIP1	= "<INPUT TYPE=TEXT VALUE='NIP. $NIPSKPD1' STYLE='background:none;border:none;text-align:center;font-weight:bold' size=50>";
			$vNIP2	= "<INPUT TYPE=TEXT VALUE='NIP. $NIPSKPD2' STYLE='background:none;border:none;text-align:center;font-weight:bold' size=50>";
			$vTITIKMANGSA 	= "<B><INPUT TYPE=TEXT VALUE='$TITIMANGSA' STYLE='background:none;border:none;text-align:center;font-weight:bold' size=50>";
			$vMENGETAHUI 	= "<B><INPUT TYPE=TEXT VALUE='MENGETAHUI' STYLE='background:none;border:none;text-align:center;font-weight:bold' size=50 >";
			$vJABATAN1		= "<INPUT TYPE=TEXT VALUE='KEPALA $this->namaModulCetak'	STYLE='background:none;border:none;text-align:center;font-weight:bold' size=50 >";
			$vJABATAN2 		= "<B><INPUT TYPE=TEXT VALUE='PETUGAS $this->namaModulCetak' STYLE='background:none;border:none;text-align:center;font-weight:bold' size=50 >";
		}else{
			$vNAMA1	= "<span STYLE='background:none;border:none;text-align:center;font-weight:bold' size=50 >($NAMASKPD1)</span>";
			$vNAMA2	= "<span STYLE='background:none;border:none;text-align:center;font-weight:bold' size=50 >($NAMASKPD2)</span>";
			$vNIP1	= "<span STYLE='background:none;border:none;text-align:center;font-weight:bold' size=50 >NIP. $NIPSKPD1</span>";
			$vNIP2	= "<span STYLE='background:none;border:none;text-align:center;font-weight:bold' size=50 >NIP. $NIPSKPD2</span>";
			$vTITIKMANGSA 	= "<B><span STYLE='background:none;border:none;text-align:center;font-weight:bold' size=50 >$TITIMANGSA</span>";
			$vMENGETAHUI 	= "<B><span STYLE='background:none;border:none;text-align:center;font-weight:bold' size=50 >MENGETAHUI</span>";
			$vJABATAN1		= "<span STYLE='background:none;border:none;text-align:center;font-weight:bold' size=50 >KEPALA $this->namaModulCetak</span>";
			$vJABATAN2 		= "<B><span STYLE='background:none;border:none;text-align:center;font-weight:bold' size=50 >PETUGAS $this->namaModulCetak</span>";

		}
		$Hsl = " <table style='width:$pagewidth' border=0>
					<tr>
					<td width=100 colspan='$cp1'>&nbsp;</td>
					<td align=center width=300 colspan='$cp2'>
						$vMENGETAHUI<BR>
						$vJABATAN1
						<BR><BR><BR><BR><BR><BR>
						$vNAMA1
						<br>
						$vNIP1
					</td>

					<td width=400 colspan='$cp3'>&nbsp;</td>
					<td align=center width=300 colspan='$cp4'>
						$vTITIKMANGSA<BR>
						$vJABATAN2
						<BR><BR><BR><BR><BR><BR>
						$vNAMA2
						<br>
						$vNIP2
					</td>
					<td width='*' colspan='$cp5'>&nbsp;</td>
					</tr>
				</table> ";
	    return $Hsl;
	}


	function genCetak($xls= FALSE, $Mode=''){
		global $Main;
		/*
		<style>
		.nfmt1 {mso-number-format:'\#\,\#\#0_\)\;\[Red\]\\(\#\,\#\#0\\)';}
		.nfmt2 {mso-number-format:'0\.00_';}
		.nfmt3 {mso-number-format:'00000';}
		.nfmt4 {mso-number-format:'\#\,\#\#0.00_\)\;\[Red\]\\(\#\,\#\#0\\)';}
		.nfmt5 {mso-number-format:'\@';}
		table {mso-displayed-decimal-separator:'\.';
			mso-displayed-thousand-separator:'\,';}
		br {mso-data-placement:same-cell;}
		</style>*/
		//if($this->cetak_xls){
		if($xls){
			header("Content-type: application/msexcel");
			header("Content-Disposition: attachment; filename=$this->fileNameExcel");
			header("Pragma: no-cache");
			header("Expires: 0");
		}


		//$css = $this->cetak_xls	?
		$css = $xls	?
			"<style>
			.nfmt5 {mso-number-format:'\@';}
			</style>":
			"<link rel=\"stylesheet\" href=\"css/template_css.css\" type=\"text/css\" />";
		echo
			"<html>".
				"<head>
					<title>$Main->Judul</title>
					$css
					$this->Cetak_OtherHTMLHead
				</head>".
			"<body >
			<form name='adminForm' id='adminForm' method='post' action=''>
			<div style='width:$this->Cetak_WIDTH'>
			<table class=\"rangkacetak\" style='width:$this->Cetak_WIDTH'>
			<tr><td valign=\"top\">".
				//$this->cetak_xls.
				$this->setCetak_Header($Mode).//$this->Cetak_Header.//
				"<div id='cntTerimaKondisi'>".
					//$TampilOpt['TampilOpt'].
				"</div>
				<div id='cntTerimaDaftar' >";

		$Opsi = $this->getDaftarOpsi($this->Cetak_Mode);
			//echo ',Kondisi='.$Opsi['Kondisi'].',Order='.$Opsi['Order'].',hal='.$_POST['HalDefault'].
			//	',limit='.$Opsi['Limit'].',NoAwal='.$Opsi['NoAwal'].',';
			//echo 'vkondisi='.$$Opsi[vKondisi;
		if($this->Cetak_Mode==3){//flush
			$this->genDaftar(	$Opsi['Kondisi'], $Opsi['Order'], $Opsi['Limit'], $Opsi['NoAwal'], $this->Cetak_Mode, $Opsi['vKondisi_old']);
		}else{
			$daftar = $this->genDaftar(	$Opsi['Kondisi'], $Opsi['Order'], $Opsi['Limit'], $Opsi['NoAwal'], $this->Cetak_Mode, $Opsi['vKondisi_old']);
			echo $daftar['content'];
		}
		echo	"</div>	".
				$this->setCetak_footer($xls).
			"</td></tr>
			</table>
			</div>
			</form>
			</body>
			</html>";
	}
}



//class PbbDaftarObj{



function setCetakJudul ($JUDUL = 'LAPORAN DAFTAR PENDATAAN',
	$kdpajak='4.1.1.04.00',
	$nmpajak='PAJAK REKLAME', $other='')
{
	return
			"<table width='100%' border=\"0\">
				<tr>
					<td align='right' colspan='4'>
						<span class='title2'>
							$JUDUL
						</span>
					</td>
				</tr>
				<tr>
					<td align='right' colspan='4'>
						<span class='title1'>
							$kdpajak - $nmpajak
						</span>
					</td>
					<td colspan='4'><span class='title1'></span></td>
				</tr>
				<tr>
					<td><span class='title1'></span></td>
					<td colspan='4'><span class='title1'>$other</span></td>
				</tr>
			</table>";
	}

class CetakObj{
	var $Style = 'rangkacetak';
	var $OtherHTMLHead ='';
	var $WIDTH ='20cm';
	var $HEIGHT ='26.5cm';
	function setHTMLHead(){
		global $Main, $PATH_CSS ;
		return
			"<head>
				<title>$Main->Judul</title>
				<link rel=\"stylesheet\" href=\"".$PATH_CSS."css/template_css.css\" type=\"text/css\" />
				$this->OtherHTMLHead
			</head>";
	}
	function setContent(){
		$content = 'content';
		return $content;
	}
	function genCetak(){

		//$TampilOpt = $Penetapan->genDaftarOpsi();
		/*return
			"<html>".
				$this->setHTMLHead().
			"<body >".
				"<table class=\"$this->Style\" style='width:$this->WIDTH'>
				<tr><td valign=\"top\">".
					$this->setContent().
				"</td></tr>
				</table>".
			"</body>
			</html>";*/
		//$this->WIDTH = '20cm';
		$height = $this->HEIGHT ==''? '' : "height:".$this->HEIGHT;
		return
			"<html>".
				$this->setHTMLHead().
			"<body >".
				"<div style='width:".$this->WIDTH.";$height;overflow:hidden'>".
					$this->setContent().
				"</div>".
			"</body>
			</html>";
	}
}




?>
