<?php

class Dpb_RencanaObj extends DaftarObj2{
	var $Prefix = 'Dpb_Rencana';
	//var $SHOW_CEK = TRUE;	
	var $TblName = 'dkb';//view2_sensus';
	var $TblName_Hapus = 'dkb';
	var $TblName_Edit = 'dkb';
	var $KeyFields = array('id');
	var $FieldSum = array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 7, 6,6);
	var $FieldSum_Cp2 = array( 4, 4,4);	
	//var $FormName = 'Sensus_form';
	//var $pagePerHal = 7;
	//var $thnsensus_default = 2013;
	//var $periode_sensus = 5;// tahun
	
	var $PageTitle = 'Rencana Pengadaan Barang';
	var $PageIcon = 'images/perencanaan_ico.png';
	var $ico_width = '';
	var $ico_height = '';
	
	var $fileNameExcel='dkbmd.xls';
	var $Cetak_Judul = 'DAFTAR RENCANA PENGADAAN BARANG';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $fmST = 0;
	var $idpilih = '';
	
	function setTitle(){
		return 'Rencana Pengadaan Barang';
	}
	function setNavAtas(){
		return
		
		
			'<table cellspacing="0" cellpadding="0" border="0" width="100%">
			<tr>
			<td class="menudottedline" width="60%" height="20" style="text-align:right"><b>
				<a style="color:blue;" href="pages.php?Pg=dpb_rencana" title="Rencana">Rencana</a> |				
				<a  href="pages.php?Pg=dpb_spk" title="Daftar Pengadaan Barang Milik Daerah SPK">SPK</a>  |  
				<a href="pages.php?Pg=dpb" title="Pengadaan">Pengadaan</a>  |  
				<a href="pages.php?Pg=rekapdpb" title="Rekap">Rekap</a>  |
				<a href="pages.php?Pg=rekapdpb_skpd" title="Rekap SKPD">Rekap (SKPD)</a> 
				  &nbsp;&nbsp;&nbsp;
			</b></td>
			</tr>
			</table>';	
	}
	
	function cmbQueryBidang($name='txtField', $value='', $query='', $param='', $Atas='Pilih', $vAtas='',$readonly=FALSE) {
     global $Ref,$Main;
	 Global $fmSKPDBidang;
		$fmSKPDBidang = cekPOST('fmSKPDBidang');
	 $aqry="select * from ref_skpd where c!='00' and d='00'  GROUP by c";
	 $Input = "<option value='$vAtas'>$Atas</option>";
	 $Query = sqlQuery($aqry);
	 $nmSKPDBidang='';
    	while ($Hasil = sqlArray($Query)) {
        	$Sel = $Hasil['c'] ==  $value ? "selected" : "";
				if ($nmSKPDBidang=='' ) $nmSKPDBidang =  $value == $Hasil['c'] ? $Hasil['nm_skpd'] : '';
			$Input .= "<option $Sel value='{$Hasil[c]}'>{$Hasil[nm_skpd]}";
    	}
     $Input = $readonly == false ?
	 "<select $param name='$name' id='$name'> $Input</select>":
	 "$nmSKPDBidang <input type='hidden' name='$name' id='$name' value='". $value."' >";
     return $Input;
	}
	
	function cmbQuerySKPD($name='txtField', $value='', $query='', $param='', $Atas='Pilih', $vAtas='',$readonly=FALSE) {
	 global $Ref,$Main;
	 Global $fmSKPDBidang,$fmSKPDskpd;
		$fmSKPDBidang = cekPOST('fmSKPDBidang');
		$fmSKPDskpd = cekPOST('fmSKPDskpd');
		setcookie('cofmSKPD',$fmSKPDBidang);
		setcookie('cofmUNIT',$fmSKPDskpd);
	 $aqry="select * from ref_skpd where c='$fmSKPDBidang' and d!='00' and e='00' GROUP by d";
	 $Input = "<option value='$vAtas'>$Atas</option>";
	 $Query = sqlQuery($aqry);
	 $nmSKPDskpd='';
    	while ($Hasil = sqlArray($Query)) {
        	$Sel = $Hasil['d'] ==  $value ? "selected" : "";
				if ($nmSKPDskpd=='' ) $nmSKPDskpd =  $value == $Hasil['d'] ? $Hasil['nm_skpd'] : '';
			$Input .= "<option $Sel value='{$Hasil[d]}'>{$Hasil[nm_skpd]}";
    	}
     $Input = $readonly == false ?
	 "<select $param name='$name' id='$name'> $Input</select>":
	 "$nmSKPDskpd <input type='hidden' name='$name' id='$name' value='". $value."' >";
     return $Input;
	}
	
	function genDaftarInitial($tipe='',$fmSKPD='',$fmUNIT='',$height=''){
		global $HTTP_COOKIE_VARS;
		$vOpsi = $this->genDaftarOpsi();
		$fmFiltThnAnggaran = $_COOKIE['coThnAnggaran'];
		
		if($tipe=='windowshow'){
			$jns = "<input type='hidden' value='windowshow' id='jns' name='jns' >";
			$title = "";
		}else{
			$jns = "<input type='hidden' value='' id='jns' name='jns' >";
			$title = "<div id='{$this->Prefix}_cont_title' style='position:relative'></div>";
		}
		
		return			
			$title. 
			"<div id='{$this->Prefix}_cont_opsi' style='position:relative'>". 		
				"<input type='hidden' value='$fmFiltThnAnggaran' id='fmFiltThnAnggaran' name='fmFiltThnAnggaran' >".
				$jns.		
				"<input type='hidden' id='".$this->Prefix."SkpdfmSKPD' name='".$this->Prefix."SkpdfmSKPD' value='$fmSKPD'>".
				"<input type='hidden' id='".$this->Prefix."SkpdfmUNIT' name='".$this->Prefix."SkpdfmUNIT' value='$fmUNIT'>".
				//"<input type='hidden' id='".$this->Prefix."SkpdfmSUBUNIT' name='".$this->Prefix."SkpdfmSUBUNIT' value='$fmSUBUNIT'>".
				//"<input type='hidden' id='".$this->Prefix."tahun_anggaran' name='".$this->Prefix."tahun_anggaran' value='$tahun_anggaran'>".
			"</div>".					
			"<div id=garis style='height:1;border-bottom:1px solid #E5E5E5;'></div>".
			"<div id=contain style='overflow:auto;height:$height;'>".
			//"<div id=contain style='overflow:auto;height:256;'>".
			"<div id='{$this->Prefix}_cont_daftar' style='position:relative' >".					
			"</div>
			</div>".
			"<div id='{$this->Prefix}_cont_hal' style='position:relative'>".				
				"<input type='hidden' id='".$this->Prefix."_hal' name='".$this->Prefix."_hal' value='1'>".
			"</div>";
	}
	
	function setPage_OtherScript(){
		$scriptload = 
					"<script>
						$(document).ready(function(){ 
							".$this->Prefix.".loading();
						});
						
					</script>";
					
		return 
		 "<script type='text/javascript' src='js/barcode.js' language='JavaScript' ></script>".			
		 "<script type='text/javascript' src='js/skpd.js' language='JavaScript' ></script>".
		 "<script type='text/javascript' src='js/pengadaan/".strtolower($this->Prefix).".js' language='JavaScript' ></script>".
			
			 
			
			$scriptload;
	}
	
	function setKolomHeader($Mode=1, $Checkbox=''){
		$NomorColSpan = $Mode==1? 2: 1;
		$headerTable =
			"<thead>
				<tr>
				
				<th class='th01' width='40'>No.</th>
				$Checkbox		
				<th class='th01' width=150>Kode Barang/ Kode Akun</th>
				<th class='th01' width=150>Nama Barang/ Nama Akun</th>
				<th class='th01' >Merk / Type / Ukuran / Spesifikasi </th>
				<th class='th01' >Jumlah</th>
				<th class='th01' >Satuan</th>
				
				<!--<th class='th01' >Harga Satuan<br>(Rp) </th>											
				<th class='th01' >Program / Kegiatan</th>-->
											
				<!--<th class='th01' >Pagu Anggaran</th>-->	
				<th class='th01' >Jumlah Harga<br>(Rp) </th>						
				<th class='th01' >Dipergunakan SubUnit</th>							
				<th class='th01' >Keterangan </th>											
			</tr>
				
			</thead>";
		return $headerTable;
	}
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
		global $Ref,$HTTP_COOKIE_VARS;
		 $kb=sqlArray(sqlQuery("select * from ref_barang where f=".$isi['f']." and g=".$isi['g']." and h=".$isi['h']." and i=".$isi['i']." and j=".$isi['j'].""));	 
		 $ka=sqlArray(sqlQuery("select * from ref_jurnal where ka='".$isi['k']."' and kb='".$isi['l']."' and kc='".$isi['m']."' and kd='".$isi['n']."' and ke='".$isi['o']."' and kf='".$isi['kf']."'"));	 
	 	 $ka = array_map('utf8_encode', $ka);
		 $kode = $isi['f'].'.'.$isi['g'].'.'.$isi['h'].'.'.$isi['i'].'.'.$isi['j'].'</br>'.$isi['k'].'.'.$isi['l'].'.'.$isi['m'].'.'.$isi['n'].'.'.$isi['o'].'.'.$isi['kf'];		
		 $nama = $kb['nm_barang'].'</br>'.$ka['nm_account'];
		 //query rkb
		 //$qr=sqlArray(sqlQuery("select * from rkb where ref_id='".$isi['idrkb']."'"));
		 //query program
		 $qp=sqlArray(sqlQuery("SELECT p,nama FROM ref_program WHERE bk='".$isi['bk']."' AND ck='".$isi['ck']."' AND dk='".$isi['dk']."' AND p='".$isi['p']."' AND q='0'"));
		 //query Kegiatan
		 $qq=sqlArray(sqlQuery("SELECT q,nama FROM ref_program WHERE bk='".$isi['bk']."' AND ck='".$isi['ck']."' AND dk='".$isi['dk']."' AND p='".$isi['p']."' AND q='".$isi['q']."'"));
		 $program=$qp['nama'].'</br>'.$qq['nama'];
		 //query Pagu Harga
		 $pg=sqlArray(sqlQuery("SELECT pagu FROM ref_program where bk='".$isi['bk']."' AND ck='".$isi['ck']."' AND dk='".$isi['dk']."' AND p='".$isi['p']."' AND q='".$isi['q']."'"));
		 $sub=sqlArray(sqlQuery("SELECT nm_skpd from ref_skpd where c='".$isi['c']."' AND d='".$isi['d']."' AND e='".$isi['e']."' AND e1='".$isi['e1']."'"));
		 $Koloms = array();
		 $Koloms[] = array('align="center" width="20"', $no.'.' );
		 if ($Mode == 1) $Koloms[] = array(" align='center'  ", $TampilCheckBox);
	  	 $Koloms[] = array('align="left" "',$kode);
		 $Koloms[] = array('align="left" ',$nama);
	 	 $Koloms[] = array('align="left" ',$isi['merk_barang']);	 	 	 	 	 	 	 	 
	 	 $Koloms[] = array('align="center" ',$isi['jml_barang']);	 	 	 	 
	 	 $Koloms[] = array('align="center" ',$isi['satuan']);		  	 	 	 
	 	 //$Koloms[] = array('align="right" ',number_format($isi['harga'],2,',','.'));	 	 	 	 	 	 	 	 
	 	 //$Koloms[] = array('align="left" ',$program);	 		 		  	 	  	 	 	 	 	 	 	 	 	 	 
	 	 //$Koloms[] = array('align="right" ',number_format($pg['pagu'],2,',','.'));
	 	 $Koloms[] = array('align="right" ',number_format($isi['jml_harga'],2,',','.'));	 	 	 	 
	 	 $Koloms[] = array('align="left" ',$sub['nm_skpd']);	 		 		  	 	  	 	 	 	 	 	 	 	 	 	 
	 	 $Koloms[] = array('align="left" ',$isi['ket']);
		 return $Koloms;
	}	

	function genDaftarOpsi(){
	 global $Ref, $Main;
	 Global $fmSKPDBidang,$fmSKPDskpd;
	 $fmSKPDBidang=cekPOST('fmSKPDBidang');
	 $fmSKPDskpd=cekPOST('fmSKPDskpd');
	 $fmThnAnggaran=  $_REQUEST['fmFiltThnAnggaran'];
	
	
	$TampilOpt = 
			"<table  class=\"adminform\">	<tr>		
			<td style='padding:1 8 0 8; '  valign=\"top\">".
			"<table><tr><td width='100'>Bidang</td><td width='10'>:</td><td>".
				$this->cmbQueryBidang('fmSKPDBidang',$fmSKPDBidang,'','onchange=Dpb_Rencana.BidangAfter() '.$disabled1,'--- Pilih BIDANG ---','00')."</td></tr>".
			"<tr><td width='100'>SKPD</td><td width='10'>:</td><td>".
				$this->cmbQuerySKPD('fmSKPDskpd',$fmSKPDskpd,'','onchange=Dpb_Rencana.SKPDAfter() '.$disabled1,'--- Pilih SKPD ---','00').
			"</td></tr></table>".
			"</td>
			</tr></table>".
			
			genFilterBar(
				array(	
					"Tahun Anggaran &nbsp;"
					."<input type='text'  size='4' value='$fmThnAnggaran' id='fmFiltThnAnggaran' name='fmFiltThnAnggaran' readonly=''>"
				),$this->Prefix.".refreshList(true)",TRUE
			)
			;		
		return array('TampilOpt'=>$TampilOpt);
	}
	
	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		global $fmPILCARI;
		$UID = $_COOKIE['coID']; 
		//kondisi -----------------------------------
				
		$arrKondisi = array();
		$fmSKPDBidang = cekPOST('fmSKPDBidang');
		$fmSKPDskpd = cekPOST('fmSKPDskpd');		
		$fmThnAnggaran=$_REQUEST['fmFiltThnAnggaran'];
		
		
		if(!($fmSKPDBidang=='' || $fmSKPDBidang=='00') ) $arrKondisi[] = "c='$fmSKPDBidang'";
		if(!($fmSKPDskpd=='' || $fmSKPDskpd=='00') ) $arrKondisi[] = "d='$fmSKPDskpd'";
		if(!($fmThnAnggaran=='') ) $arrKondisi[] = "tahun='$fmThnAnggaran'";
		
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
		$arrOrders[]="c,d";
			$Order= join(',',$arrOrders);	
			$OrderDefault = '';// Order By no_terima desc ';
			$Order =  $Order ==''? $OrderDefault : ' Order By '.$Order;
		//}
		//$Order ="";
		//limit --------------------------------------
		/**$HalDefault=cekPOST($this->Prefix.'_hal',1);	//Cat:Settingan Lama				
		$Limit = " limit ".(($HalDefault	*1) - 1) * $Main->PagePerHal.",".$Main->PagePerHal; //$LimitHal = '';
		$Limit = $Mode == 3 ? '': $Limit;
		//noawal ------------------------------------
		$NoAwal= $Main->PagePerHal * (($HalDefault*1) - 1);							
		$NoAwal = $Mode == 3 ? 0: $NoAwal;		
		**/
		$pagePerHal = $this->pagePerHal =='' ? $Main->PagePerHal: $this->pagePerHal; 
		$HalDefault=cekPOST($this->Prefix.'_hal',1);					
		//$Limit = " limit ".(($HalDefault	*1) - 1) * $Main->PagePerHal.",".$Main->PagePerHal; //$LimitHal = '';
		$Limit = " limit ".(($HalDefault	*1) - 1) * $pagePerHal.",".$pagePerHal; //$LimitHal = '';
		$Limit = $Mode == 3 ? '': $Limit;
		//noawal ------------------------------------
		$NoAwal= $pagePerHal * (($HalDefault*1) - 1);							
		$NoAwal = $Mode == 3 ? 0: $NoAwal;	
		
		return array('Kondisi'=>$Kondisi, 'Order'=>$Order ,'Limit'=>$Limit, 'NoAwal'=>$NoAwal);
		
	}
	
	function setMenuEdit(){
		return	"";
			//"<td>".genPanelIcon("javascript:".$this->Prefix.".Baru()","new_f2.png","Baru",'Baru')."</td>".
			//"<td>".genPanelIcon("javascript:".$this->Prefix.".Edit()","edit_f2.png","Edit", 'Edit')."</td>".
			//"<td>".genPanelIcon("javascript:".$this->Prefix.".Hapus()","delete_f2.png","Hapus", 'Hapus')."</td>";			
	}

	/*function setMenuView(){
		return 
		//"<td>".genPanelIcon("javascript:".$this->Prefix.".cetakHal(\"$Op\")","print_f2.png","Halaman")."</td>			<td>".genPanelIcon("javascript:".$this->Prefix.".cetakAll(\"$Op\")","print_f2.png","Semua")."</td>				<td>".genPanelIcon("javascript:".$this->Prefix.".exportXls(\"$Op\")","export_xls.png","Excel")."</td>
		"";
		}*/	
	
 	function setFormBaru(){
		$cbid = $_REQUEST['rkb_cb'];
		$cek =$cbid[0];
		$c = $_REQUEST['rkbSkpdfmSKPD'];
		$d = $_REQUEST['rkbSkpdfmUNIT'];
		$e = $_REQUEST['rkbSkpdfmSUBUNIT'];
		$e1 = $_REQUEST['rkbSkpdfmSEKSI'];	
				
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 0;
		//get data
		$aqry = "select * from rkb where Id='".$this->form_idplh."'"; $cek.=$aqry;
		$dt = sqlArray(sqlQuery($aqry));
		
		//query mendapatkan ref_skpd_urusan
		$su=sqlArray(sqlQuery("select * from ref_skpd_urusan WHERE c='".$dt['c']."' AND d='".$dt['d']."'"));
		//declare bk,ck,dk
		$dt['bk']=$su['bk'];
		$dt['ck']=$su['ck'];
		$dt['dk']=$su['dk'];
		
		//query skpd
		$c=sqlArray(sqlQuery("select * from ref_skpd where c=".$dt['c']." and d=00 and e=00 and e1=00"));
		$d=sqlArray(sqlQuery("select * from ref_skpd where c=".$dt['c']." and d=".$dt['d']." and e=00 and e1=00"));
	 	$e=sqlArray(sqlQuery("select * from ref_skpd where c=".$dt['c']." and d=".$dt['d']." and e=".$dt['e']." and e1=00"));
	 	$e1=sqlArray(sqlQuery("select * from ref_skpd where c=".$dt['c']." and d=".$dt['d']." and e=".$dt['e']." and e=".$dt['e1'].""));
		$dt['bidang']=$c['nm_skpd'];
		$dt['skpd']=$d['nm_skpd'];
		$dt['unit']=$e['nm_skpd'];
		$dt['subunit']=$e1['nm_skpd'];	 	

		//query barang
		$cb=sqlArray(sqlQuery("select * from ref_barang where f='".$dt['f']."' and g='".$dt['g']."' and h='".$dt['h']."' and i='".$dt['i']."' and j='".$dt['j']."'"));
		$dt['kode_barang']=$dt['f'].'.'.$dt['g'].'.'.$dt['h'].'.'.$dt['i'].'.'.$dt['j'];
		$dt['nama_barang']=$cb['nm_barang'];		

		//query akun
		$qa=sqlArray(sqlQuery("select * from ref_jurnal where ka='".$dt['k']."' and kb='".$dt['l']."' and kc='".$dt['m']."' and kd='".$dt['n']."' and ke='".$dt['o']."' and kf='".$dt['kf']."'"));
	    $qa = array_map('utf8_encode', $qa);
		$dt['kode_akun']=$dt['k'].'.'.$dt['l'].'.'.$dt['m'].'.'.$dt['n'].'.'.$dt['o'].'.'.$dt['kf'];
		$dt['nama_akun']=$qa['nm_account'];		

		$dt['merk_barang_rkbmd']=$dt['merk_barang'];
		$dt['jml_barang_rkbmd']=$dt['jml_barang'];
		$dt['harga_rkbmd']=$dt['harga'];
		$dt['jml_harga_rkbmd']=$dt['jml_harga'];			
		$dt['ket_rkbmd']=$dt['ket'];	

		//query rka
		$qr=sqlArray(sqlQuery("select * from rka where ref_id='".$this->form_idplh."' AND sttemp='0'"));
		$dt['ref_id']=$qr['id'];
		//query program
		$qp=sqlArray(sqlQuery("SELECT p,nama FROM ref_program WHERE bk='".$qr['bk']."' AND ck='".$qr['ck']."' AND dk='".$qr['dk']."' AND p='".$qr['p']."' AND q='0'"));
		//query Kegiatan
		$qq=sqlArray(sqlQuery("SELECT q,nama FROM ref_program WHERE bk='".$qr['bk']."' AND ck='".$qr['ck']."' AND dk='".$qr['dk']."' AND p='".$qr['p']."' AND q='".$qr['q']."'"));
		$dt['program_dkbmd']=$qr['p'];
		$dt['program']=$qp['nama'];	
		$dt['kegiatan_dkbmd']=$qr['q'];
		$dt['kegiatan']=$qq['nama'];			
		$dt['jml_dkbmd']=$dt['jml_barang'];
		$dt['harga_sat_dkbmd']=$dt['harga'];
		$dt['jml_harga_dkbmd']=$dt['jml_harga'];
		$dt['merk_barang_dkbmd']=$dt['merk_barang'];
		$dt['readonly']='readonly';
		$dt['disabled']='disabled';		
		$crkb=sqlArray(sqlQuery("select * from rkb where id='".$this->form_idplh."'"));
		$cerr = "select * from rkb where stat='".$dt['stat']."'"; $cek.=$cerr;	
		if($crkb['stat']!=2){
			$fm['err']="Data yang dipilih harus RKA";
		}else{
			$fm = $this->setForm($dt);
		}
		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}

 	function setFormEdit(){
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$cek =$cbid[0];
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 1;
		//get data
		$aqry = "select * from dkb where id='".$this->form_idplh."'"; $cek.=$aqry;
		$dt = sqlArray(sqlQuery($aqry));
		//query rkb
		$rkb=sqlArray(sqlQuery("select * from rkb WHERE id='".$dt['idrkb']."'"));		
		//query skpd
		$c=sqlArray(sqlQuery("select * from ref_skpd where c=".$rkb['c']." and d=00 and e=00 and e1=00"));
		$d=sqlArray(sqlQuery("select * from ref_skpd where c=".$rkb['c']." and d=".$rkb['d']." and e=00 and e1=00"));
	 	$e=sqlArray(sqlQuery("select * from ref_skpd where c=".$rkb['c']." and d=".$rkb['d']." and e=".$rkb['e']." and e1=00"));
	 	$e1=sqlArray(sqlQuery("select * from ref_skpd where c=".$rkb['c']." and d=".$rkb['d']." and e=".$rkb['e']." and e=".$rkb['e1'].""));
		$dt['bidang']=$c['nm_skpd'];
		$dt['skpd']=$d['nm_skpd'];
		$dt['unit']=$e['nm_skpd'];
		$dt['subunit']=$e1['nm_skpd'];	
		
		//tahun RKB
		$dt['tahun']= $rkb['tahun'];	
		
		//query barang
		$cb=sqlArray(sqlQuery("select * from ref_barang where f='".$rkb['f']."' and g='".$rkb['g']."' and h='".$rkb['h']."' and i='".$rkb['i']."' and j='".$rkb['j']."'"));
		$dt['kode_barang']=$rkb['f'].'.'.$rkb['g'].'.'.$rkb['h'].'.'.$rkb['i'].'.'.$rkb['j'];
		$dt['nama_barang']=$cb['nm_barang'];		

		//query akun
		$qa=sqlArray(sqlQuery("select * from ref_jurnal where ka='".$rkb['k']."' and kb='".$rkb['l']."' and kc='".$rkb['m']."' and kd='".$rkb['n']."' and ke='".$rkb['o']."'"));
	    $qa = array_map('utf8_encode', $qa);
		$dt['kode_akun']=$rkb['k'].'.'.$rkb['l'].'.'.$rkb['m'].'.'.$rkb['n'].'.'.$rkb['o'];
		$dt['nama_akun']=$qa['nm_account'];	
		
		$dt['merk_barang_rkbmd']=$rkb['merk_barang'];
		$dt['jml_barang_rkbmd']=$rkb['jml_barang'];
		$dt['harga_rkbmd']=$rkb['harga'];
		$dt['jml_harga_rkbmd']=$rkb['jml_harga'];			
		$dt['ket_rkbmd']=$rkb['ket'];	
		//query rka
		$qr=sqlArray(sqlQuery("select * from rka where id='".$dt['ref_id']."' AND sttemp='0'"));
		//query program
		$qp=sqlArray(sqlQuery("SELECT p,nama FROM ref_program WHERE bk='".$qr['bk']."' AND ck='".$qr['ck']."' AND dk='".$qr['dk']."' AND p='".$qr['p']."' AND q='0'"));
		//query Kegiatan
		$qq=sqlArray(sqlQuery("SELECT q,nama FROM ref_program WHERE bk='".$qr['bk']."' AND ck='".$qr['ck']."' AND dk='".$qr['dk']."' AND p='".$qr['p']."' AND q='".$qr['q']."'"));
		$dt['program']=$qp['nama'];	
		$dt['kegiatan']=$qq['nama'];
			
		$dt['jml_dkbmd']=$dt['jml_barang'];
		$dt['harga_sat_dkbmd']=$dt['harga'];
		$dt['jml_harga_dkbmd']=$dt['jml_harga'];
		$dt['merk_barang_dkbmd']=$dt['merk_barang'];
		$dt['program_dkbmd']=$dt['p'];
		$dt['kegiatan_dkbmd']=$dt['q'];
		$dt['ket_dkbmd']=$dt['ket'];		
		$dt['readonly']='readonly';
		$dt['disabled']='disabled';		
		//$dt['c'] = $_REQUEST[$this->Prefix.'SkpdfmSKPD'];
		//$dt['d'] = $_REQUEST[$this->Prefix.'SkpdfmUNIT'];
		//$dt['e'] = $_REQUEST[$this->Prefix.'SkpdfmSUBUNIT'];
		//$crkb=sqlArray(sqlQuery("select * from rkb where id='".$this->form_idplh."'"));
		//$cerr = "select * from rkb where stat='".$dt['stat']."'"; $cek.=$cerr;	
		//if($crkb['stat']!=2){
		//	$fm['err']="Data yang dipilih harus RKA";
		//}else{
			$fm = $this->setForm($dt);
		//}
		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}
	
	function windowShow(){		
		$cek = ''; $err=''; $content=''; 
		$json = TRUE;	//$ErrMsg = 'tes';		
		$form_name = $this->FormName;
		
		$fmSKPD = $_REQUEST['fmSKPD'];
		$fmUNIT = $_REQUEST['fmUNIT'];
		//$fmSUBUNIT = $_REQUEST['fmSUBUNIT'];
		$tahun_anggaran = $_REQUEST['tahun_anggaran'];	
		$tipe='windowshow';	
		
		//if($err=='' && ($fmSKPD=='00' || $fmSKPD=='') ) $err = 'Bidang belum diisi!';
		//if($err=='' && ($fmUNIT=='00' || $fmUNIT=='' )) $err = 'Asisten/OPD belum diisi!';
		//if($err=='' && ($fmSUBUNIT=='00' || $fmSUBUNIT=='')) $err='BIRO / UPTD/B belum diisi!';	
		//if($err==''){
			$FormContent = $this->genDaftarInitial($tipe,$fmSKPD,$fmUNIT);
			$form = centerPage(
					"<form name='$form_name' id='$form_name' method='post' action=''>".
					createDialog(
						$form_name.'_div', 
						$FormContent,
						1000,
						400,
						'Pilih DKB',
						'',
						"<input type='button' value='Pilih' onclick ='".$this->Prefix.".windowSave()' >".
						"<input type='button' value='Batal' onclick ='".$this->Prefix.".windowClose()' >".
						"<input type='hidden' id='".$this->Prefix."_idplh' name='".$this->Prefix."_idplh' value='$this->form_idplh' >".
						"<input type='hidden' id='".$this->Prefix."_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >".
						"<input type='hidden' id='sesi' name='sesi' value='$sesi' >"
						,//$this->setForm_menubawah_content(),
						$this->form_menu_bawah_height
					).
					"</form>"
			);
			$content = $form;//$content = 'content';	
		//}
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function setForm($dt){	
	 global $SensusTmp;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = 'dkb_form';				
	 $this->form_width = 1340;
	 $this->form_height = 565;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'DKBMD - Baru';
		$nip	 = '';
	  }else{
		$this->form_caption = 'DKBMD - Edit';			
		$Id = $dt['Id'];			
	  }
	    //ambil data trefditeruskan
	  	$query = "" ;$cek .=$query;
	  	$res = sqlQuery($query);
		//query program
		$queryProgram = "SELECT p,nama FROM ref_program WHERE bk='".$dt['bk']."' AND ck='".$dt['ck']."' AND dk='".$dt['dk']."' AND p!='0' AND q='0'";
 		//query Kegiatan
		$queryKegiatan = "SELECT q,nama FROM ref_program WHERE bk='".$dt['bk']."' AND ck='".$dt['ck']."' AND dk='".$dt['dk']."' AND p='".$dt['program_dkbmd']."' AND q!='0'";
 		
	 //items ----------------------
	  $this->form_fields = array(
			'RKBMD' => array( 
						'label'=>'Status Barang',
						'labelWidth'=>100, 
						'value'=>'<b>RKBMD</b>', 
						'type'=>'merge',
						'row_params'=>"style='font-size: 18px;font-weight: bold;color: #C64934;margin:0 0 10 0';"
						 ),
						 
			'bidang' => array( 
							'label'=>'BIDANG',
							'labelWidth'=>100, 
							'value'=>"<input type='text' name='bidang' value='".$dt['bidang']."' size='30px' id='bidang' readonly>&nbsp&nbsp
									<input type='hidden' name='c' value='".$dt['c']."' id='c' >"
								),	
						 
			'skpd' => array( 
							'label'=>'SKPD',
							'labelWidth'=>100, 
							'value'=>"<input type='text' name='skpd' value='".$dt['skpd']."' size='30px' id='skpd' readonly>&nbsp&nbsp
									<input type='hidden' name='d' value='".$dt['d']."' id='d' >"
								),	
						 
			'unit' => array( 
							'label'=>'UNIT',
							'labelWidth'=>100, 
							'value'=>"<input type='text' name='unit' value='".$dt['unit']."' size='30px' id='unit' readonly>&nbsp&nbsp
									<input type='hidden' name='e' value='".$dt['e']."' id='e' >"
								),	
						 
			'subunit' => array( 
							'label'=>'SUB UNIT',
							'labelWidth'=>100, 
							'value'=>"<input type='text' name='subunit' value='".$dt['subunit']."' size='30px' id='subunit' readonly>&nbsp&nbsp
									<input type='hidden' name='e1' value='".$dt['e1']."' id='e1' >"
								),	
						 
			'tahun' => array( 
						'label'=>'Tahun',
						'labelWidth'=>100, 
						'value'=>$dt['tahun'], 
						'type'=>'text',
						'param'=>"style='width:75px;' readonly"
						 ),	
						 
			'nama_barang' => array( 
								'label'=>'Kode & Nama Barang',
								'labelWidth'=>150, 
								'value'=>"<input type='text' name='kode_barang' value='".$dt['f'].'.'.$dt['g'].'.'.$dt['h'].'.'.$dt['i'].'.'.$dt['j']."' size='10px' id='kode_barang' readonly>
								<input type='text' name='nama_barang' value='".$dt['nama_barang']."' size='55px' id='nama_barang' readonly>&nbsp"
									),	
									
			'nama_akun' => array( 
								'label'=>'Kode & Nama Akun',
								'labelWidth'=>150, 
								'value'=>"<input type='text' name='kode_akun' value='".$dt['kode_akun']."' size='10px' id='kode_akun' readonly>
								<input type='text' name='nama_akun' value='".$dt['nama_akun']."' size='55px' id='nama_akun' readonly>&nbsp"
									),
									
			'merk_barang' => array(  'label'=>'Merk/Type/Ukuran/Spesifikasi',
				 'value'=>"<textarea id='merk_barang' name='merk_barang' rows='5' cols='60' ".$dt['disabled'].">".$dt['merk_barang_rkbmd']."</textarea>", 
				 'param'=> "valign=top",
				 'labelparam'=> "valign=top",		 
				   ),
				   				   
			'jml_rkbmd' => array( 
							'label'=>'Jumlah RKBMD',
							'labelWidth'=>150, 
							'value'=>"<input type='text' name='jumlah_pengadaan_barang' value='".$dt['jml_barang_rkbmd']."' style='width:50px;' id='jumlah_pengadaan_barang' onkeypress='return isNumberKey(event);' onchange ='".$this->Prefix.".CekJP()' readonly>&nbsp&nbsp
							Satuan Barang : <input type='text' name='satuan' value='".$dt['satuan']."' size='20px' id='satuan' readonly>"
								),	

			'harga_sat' => array( 
						'label'=>'Harga Satuan Barang',
						'labelWidth'=>100, 
						'value'=>number_format($dt['harga_rkbmd'],2,',','.'), 
						'type'=>'text',
						'param'=>"size='15px' readonly"
						 ),					   						   																									 						 						 						 						 						 						 						 		

			'jml_harga' => array( 
						'label'=>'Jumlah Harga',
						'labelWidth'=>100, 
						'value'=>number_format($dt['jml_harga_rkbmd'],2,',','.'),
						'type'=>'text',
						'param'=>"size='15px' readonly"
						 ),	
						 
			'ket' => array(  'label'=>'Keterangan',
				 'value'=>"<textarea id='ket' name='ket' rows='5' cols='60' ".$dt['disabled'].">".$dt['ket_rkbmd']."</textarea>", 
				 'param'=> "valign=top",
				 'labelparam'=> "valign=top",		 
				   ),

			'program' => array( 
							'label'=>'Program',
							'labelWidth'=>100, 
							'value'=>"<input type='text' name='program' value='".$dt['program']."' size='20px' id='program' readonly>"
								),								 	
	
			'kegiatan' => array( 
							'label'=>'Kegiatan',
							'labelWidth'=>100, 
							'value'=>"<input type='text' name='kegiatan' value='".$dt['kegiatan']."' size='20px' id='kegiatan' readonly>"
								),	
						 
			'DKBMD' => array( 
						'label'=>'DKBMD',
						'labelWidth'=>100, 
						'value'=>'<b>DKBMD</b>', 
						'type'=>'merge',
						'row_params'=>"style='font-size: 18px;font-weight: bold;color: #C64934;margin:0 0 10 0';"
						 ),
						 
			'jml_dkbmd' => array( 
						'label'=>'Jumlah DKBMD',
						'labelWidth'=>100, 
						'value'=>$dt['jml_dkbmd'], 
						'type'=>'text',
						'param'=>'style="width:50px;" onkeypress="return isNumberKey(event)" '
						 ),	

			'harga_sat_dkbmd' => array( 
						'label'=>'Harga Satuan',
						'labelWidth'=>100, 
						'value'=>$dt['harga_sat_dkbmd'], 
						'type'=>'text',
						'param'=>'size="15px" onkeypress="return isNumberKey(event)"'
						 ),					   						   																									 						 						 						 						 						 						 						 		

			'jml_harga_dkbmd' => array( 
								'label'=>'Jumlah Harga',
								'labelWidth'=>150, 
								'value'=>"<input type='text' name='jml_harga_dkbmd' value='".number_format($dt['jml_harga_dkbmd'],2,',','.')."' size='15px' id='jml_harga_dkbmd' readonly>&nbsp
										<input type='button' value='Hitung' onclick ='".$this->Prefix.".HitungHarga()' title='Hitung harga' >"
									 ),
						 
			'merk_barang_dkbmd' => array(  'label'=>'Merk/Type/Ukuran/Spesifikasi',
				 'value'=>"<textarea id='merk_barang_dkbmd' name='merk_barang_dkbmd' rows='5' cols='60' >".$dt['merk_barang_dkbmd']."</textarea>", 
				 'param'=> "valign=top",
				 'row_params'=>"valign='top'",	 
				   ),						 						 						 			
	
			'program_dkbmd' => array( 
						'label'=>'Program',
						'labelWidth'=>100, 
						'value'=>cmbQuery('program_dkbmd',$dt['program_dkbmd'],$queryProgram,'onChange=\''.$this->Prefix.'.Kegiatan()\'','-- PILIH Program --'),
						),
						 			
			'kegiatan_dkbmd' => array( 
						'label'=>'Kegiatan',
						'labelWidth'=>100, 
						'value'=>"<div id='div_kegiatan'>".cmbQuery('kegiatan_dkbmd',$dt['kegiatan_dkbmd'],$queryKegiatan,'','-- PILIH Kegiatan --')."</div>",
						),
	
			'ket_dkbmd' => array(  
						'label'=>'Keterangan',
						'labelWidth'=>100, 
						'value'=>"<textarea id='ket_dkbmd' name='ket_dkbmd' rows='5' cols='60' >".$dt['ket_dkbmd']."</textarea>", 
				 '		row_params'=>"valign='top'",	 
				   ),						 						 						 			
		
			);
		//tombol
		$this->form_menubawah =
			"<input type='hidden' id='mode' name='mode' value='".$dt['mode']."'>".
			"<input type='hidden' id='idrka' name='idrka' value='".$dt['ref_id']."'>".
			"<input type='hidden' id='bk' name='bk' value='".$dt['bk']."'>".
			"<input type='hidden' id='ck' name='ck' value='".$dt['ck']."'>".
			"<input type='hidden' id='dk' name='dk' value='".$dt['dk']."'>".
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SimpanDKBMD()' title='Simpan' >".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".CloseDKBMD()' >";
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function genForm2($withForm=TRUE){	
		$form_name = 'dkb_form';	
				
		if($withForm){
			$params->tipe=1;
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
					$this->form_menu_bawah_height,
					'',$params
					).
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
					$this->form_menu_bawah_height
				);
			
			
		}
		
		
		/*$form = 
			centerPage(
				$form
			);*/
		return $form;
	}			
	
	function simpan(){
		global $Main, $HTTP_COOKIE_VARS;
		$cek = ''; $err=''; $content=''; $json=TRUE;
		$fmST = $_REQUEST[$this->Prefix.'_fmST'];
		$id = $_REQUEST[$this->Prefix.'_idplh'];
		$UID = $HTTP_COOKIE_VARS['coID'];
		$jml_barang = $_REQUEST['jml_barang'];
		$harga = $_REQUEST['harga'];
		
		$old = sqlArray( sqlQuery(
			"select * from $this->TblName where id='$id' "		
		));
				
		//-- validasi
		if($err=='' && ($jml_barang == '' || $jml_barang==0))$err = "Jumlah Barang belum diisi!";
		if($err=='' && ($harga == '' || $harga==0))$err = "Harga Barang belum diisi!";
		
		
		//-- cek sudah pengadaan
		if($err=='' ){
			$pengadaan = sqlArray(sqlQuery(
				"select count(*) as cnt from pengadaan where tahun='".$old['tahun']."' ".
				" and c='".$old['c']."' and d='".$old['d']."' and e='".$old['e']."' and e1='".$old['e1']."' ".
				" and f='".$old['f']."' and g='".$old['g']."' and h='".$old['h']."' and i='".$old['i']."' and j='".$old['j']."' "
			));
			if( $pengadaan['cnt'] > 0 ) $err='Gagal Simpan! Data Sudah Ada di Pengadaan!';
		}
		//-- cek jml kebutuhan < jml rencana
		if($err==''){
			$aqry = "select * from rkb where tahun='".$old['tahun']."' ".
				" and c='".$old['c']."' and d='".$old['d']."' and e='".$old['e']."' and e1='".$old['e1']."'".
				" and f='".$old['f']."' and g='".$old['g']."' and h='".$old['h']."' and i='".$old['i']."' and j='".$old['j']."' "; 
			$cek .= $aqry;		
			$rkb = sqlArray(sqlQuery($aqry));
			if( $jml_barang > $rkb['jml_barang']) $err = "Jumlah Barang Kebutuhan Tidak Lebih Besar Dari Rencana!";
		}
		//-- hit jmlbarang
		$jml_harga = $harga * $jml_barang;
		
		//-- simpan
		if($err==''){
			$qry = sqlQuery(
				"update $this->TblName_Edit set jml_barang='$jml_barang', harga='$harga', jml_harga='$jml_harga', uid='$UID', tgl_update=now() where id='$id' "		
			);
		}
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);					
	}	

	function simpanDKBMD(){
	 global $HTTP_COOKIE_VARS;
	 global $Main;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $thnAnggaran = $HTTP_COOKIE_VARS['coThnAnggaran'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	 //get data -----------------
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];
	 $a1 = $Main->DEF_KEPEMILIKAN;
	 $a = $Main->Provinsi[0];
	 $b = $Main->DEF_WILAYAH;
	 $c = $_REQUEST['c'];
	 $d = $_REQUEST['d'];
	 $e = $_REQUEST['e'];
	 $e1 = $_REQUEST['e1'];
	 //generate kode barang
	 $kb = explode(".",$_REQUEST['kode_barang']);
	 $f = $kb[0];
	 $g = $kb[1];
	 $h = $kb[2];
	 $i = $kb[3];
	 $j = $kb[4];
	 $nm_barang=$_REQUEST['nama_barang'];
	 $bk = $_REQUEST['bk'];
	 $ck = $_REQUEST['ck'];
	 $dk = $_REQUEST['dk'];
	 $idrka = $_REQUEST['idrka'];
	 //generate kode akun
	 $ka = explode(".",$_REQUEST['kode_akun']);
	 $k = $ka[0];
	 $l = $ka[1];
	 $m = $ka[2];
	 $n = $ka[3];
	 $o = $ka[4];
	 $kf = $ka[5];
 	 $nm_akun=$_REQUEST['nama_akun'];	 
	 $satuan = $_REQUEST['satuan'];
	 $jml_dkbmd = $_REQUEST['jml_dkbmd'];
	 $harga_sat_dkbmd = $_REQUEST['harga_sat_dkbmd'];
	 $jml_harga_dkbmd = str_replace('.','',$_REQUEST['jml_harga_dkbmd']);
	 $merk_barang_dkbmd = $_REQUEST['merk_barang_dkbmd'];
	 $program_dkbmd = $_REQUEST['program_dkbmd'];
	 $kegiatan_dkbmd = $_REQUEST['kegiatan_dkbmd'];
	 $ket_dkbmd = $_REQUEST['ket_dkbmd'];	 
	if( $err=='' && $jml_dkbmd =='' ) $err= 'Jumlah DKBMD belum diisi!';
	if( $err=='' && $harga_sat_dkbmd =='' ) $err= 'Harga Satuan DKBMD belum diisi!';
	if( $err=='' && $jml_harga_dkbmd =='' ) $err= 'Jumlah Harga DKBMD belum diisi!';
	if( $err=='' && ($jml_dkbmd*$harga_sat_dkbmd)!=$jml_harga_dkbmd) $err='Hitung Jumlah DKBMD dan Harga Satuan Terlebih daulu';
	if( $err=='' && $merk_barang_dkbmd =='' ) $err= 'Merk Barang DKBMD belum diisi!';
	if( $err=='' && $program_dkbmd =='' ) $err= 'Program DKBMD belum diisi!';
	if( $err=='' && $kegiatan_dkbmd =='' ) $err= 'Kegiatan DKBMD belum diisi!';
	if( $err=='' && $ket_dkbmd =='' ) $err= 'Keterangan DKBMD belum diisi!';
									 	 			 		  
			if($fmST == 0){ 
				if($err==''){  
					$aqry="INSERT into dkb(idrkb,merk_barang,jml_barang,harga,satuan,jml_harga,ket,a1,a,b,c,d,e,e1,bk,ck,dk,p,q,
											f,g,h,i,j,nm_barang,k,l,m,n,o,kf,nm_account,tahun,tgl_update,uid,ref_id)"." 
							values('$idplh','$merk_barang_dkbmd','$jml_dkbmd','$harga_sat_dkbmd','$satuan','$jml_harga_dkbmd','$ket_dkbmd',
									'$a1','$a','$b','$c','$d','$e','$e1','$bk','$ck','$dk','$program_dkbmd','$kegiatan_dkbmd','$f','$g','$h','$i','$j','$nm_barang'
									,'$k','$l','$m','$n','$o','$kf','$nm_akun','$thnAnggaran',now(),'$uid','$idrka')"; $cek.=$aqry;
						$aqry2 = "UPDATE rkb
								set "." stat = '1',
								tgl_update = now(),
								uid = '$uid'".
								"WHERE Id='$idplh'";	$cek .= $aqry2;
						$qry = sqlQuery($aqry);
						$qry = sqlQuery($aqry2);	
				}
			}elseif($fmST == 1){						
				if($err==''){					 
							$aqry2 = "UPDATE dkb
				        	 set "." jml_barang = '$jml_dkbmd',
							 harga = '$harga_sat_dkbmd',
							 jml_harga = '$jml_harga_dkbmd',
							 merk_barang = '$merk_barang_dkbmd',
							 P = '$program_dkbmd',
							 Q = '$kegiatan_dkbmd',
							 ket = '$ket_dkbmd',
							 tgl_update = 'now()',
							 uid = '$uid'".
						 	"WHERE id='".$idplh."'";	$cek .= $aqry2;
							$qry = sqlQuery($aqry2);

					}
			}else{
			if($err==''){ 

				}
			} //end else
					
			return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }
	
  	function Hapus(){
	 global $HTTP_COOKIE_VARS;
	 global $Main;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	 //get data -----------------
	 $cbid = $_REQUEST[$this->Prefix.'_cb']; $cek .= $cbid;
	 //$cb = explode(" ", $cbid[0]);
	 for($i=0;$i<sizeof($cbid);$i++){
		 $getIdRKB=sqlArray(sqlQuery("select * from dkb where id='".$cbid[$i]."'"));
		
			if($err==''){ 				
						$aqry = "DELETE FROM dkb WHERE id='".$cbid[$i]."'";	$cek .= $aqry;	
						$qry = sqlQuery($aqry);
						if($aqry==TRUE){
							$aqry2 = "UPDATE rkb
									set "." stat = '2',
									tgl_update = now(),
									uid = '$uid'".
									"WHERE id='".$getIdRKB['idrkb']."'";	$cek .= $aqry2;
							$qry2 = sqlQuery($aqry2);						
						}
			}
	 }					
					
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }		
	
	function set_selector_other($tipe){
		global $Main;
		$cek = ''; $err=''; $content=''; $json=TRUE;
		switch($tipe){			
			case 'formBaru':{				
				$fm = $this->setFormBaru();				
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];												
			break;
			}
			
			case 'formEdit':{				
				$fm = $this->setFormEdit();				
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];												
			break;
			}			
			
		   case 'kegiatan':{
				$program = $_REQUEST['program'];
				$bk=$_REQUEST['bk'];	
				$ck=$_REQUEST['ck'];	
				$dk=$_REQUEST['dk'];	
	
					$query = "SELECT q,nama FROM ref_program WHERE bk='$bk' AND ck='$ck' AND dk='$dk' AND p='".$program."' AND q!='0'"; $cek .= $query2;
					$hasil = sqlQuery($query);
					$kegiatan = "<option value=''>-- PILIH Kegiatan--</option>";
					while ($dt = sqlArray($hasil))
					{
						$kegiatan.="<option value='".$dt['q']."'>".$dt['nama']."</option>";
					}
			$content = "<select name='kegiatan_dkbmd' id='kegiatan_dkbmd'>".$kegiatan."</select>";
					
			break;
		   }
		   
		   	case 'getdata':{
	
				$ref_pilihdkb = $_REQUEST['id'];
				
				//query ambil data ref_jurnal
				$get = sqlArray( sqlQuery("select * from dkb where id='$ref_pilihdkb'"));
				
				//query ambil data barang
				$brg = sqlArray(sqlQuery("select * from ref_barang where 
										f='".$get['ka']."' and g='".$get['kb']."' and 
										h='".$get['kc']."' and i='".$get['kd']."' and 
										j='".$get['ke']."'"));
				$kd_barang = $brg['f'].".".$brg['g'].".".$brg['h'].".".$brg['i'].".".$brg['j'];
				$nm_barang=$brg['nm_barang'];
				
				//query ambil data akun
				$akn = sqlArray(sqlQuery("select * from ref_jurnal where 
										ka='".$get['k']."' and kb='".$get['l']."' and 
										kc='".$get['m']."' and kd='".$get['n']."' and 
										ke='".$get['o']."' and kf='".$get['kf']."'"));
				$kd_account = $akn['ka'].".".$akn['kb'].".".$akn['kc'].".".$akn['kd'].".".$akn['ke'].".".$akn['kf'];
				$nm_account = $akn['nm_account'];
				
				$content = array('iddkb'=>$ref_pilihdkb,
								 'kd_barang'=>$kd_barang,
								 'nm_barang'=>$nm_barang,
								 'kd_account'=>$kd_account,
								 'nm_account'=>$nm_account
								 );	
				break;
		   }			

			case 'simpan' : {
				$get = $this->simpan();
				$cek = $get['cek']; $err = $get['err']; $content=$get['content']; 
				break;
			}
			
			case 'Hapus':{
				$get= $this->Hapus();
				$cek = $get['cek'];
				$err = $get['err'];
				$content = $get['content'];
			break;
		   }			
			
			case 'simpanDKBMD':{
				$get= $this->simpanDKBMD();
				$cek = $get['cek'];
				$err = $get['err'];
				$content = $get['content'];
			break;
		   }	
		   
		   case 'windowshow':{
				$fm = $this->windowShow();
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];	
			break;
			}
			
		 	case 'BidangAfter':{
				$content= $this->cmbQuerySKPD('fmSKPDskpd',$fmSKPDskpd,'','onchange=dpb_rencana.refreshList(true)','--- Pilih SKPD ---','00');
			break;
		    }
			
			case 'SKPDAfter':{
				$fmSKPDBidang = cekPOST('fmSKPDBidang');
				$fmSKPDskpd = cekPOST('fmSKPDskpd');
				setcookie('cofmSKPD',$fmSKPDBidang);
				setcookie('cofmUNIT',$fmSKPDskpd);
			break;
		    }							
		}
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}
}

$Dpb_Rencana = new Dpb_RencanaObj();

?>