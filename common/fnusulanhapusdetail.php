<?php
/***
	salinan dari fnuseraktivitas.php
	requirement:
	 - daftarobj2 di DaftarObj2.php
	 - global variable di vars.php
	 - library fungsi di fnfile.php
	 - connect db  di config.php
***/

class UsulanHapusdetailObj  extends DaftarObj2{	
	var $Prefix = 'UsulanHapusdetail';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'v1_penghapusan_usul_det_bi';// 'penghapusan_usul_det'; //daftar
	var $TblName_Hapus = 'penghapusan_usul_det';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('Id','sesi','id_bukuinduk');//('p','q'); //daftar/hapus
	var $FieldSum = array('jml_harga');//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 9, 8, 8);//berdasar mode
	var $FieldSum_Cp2 = array( 2, 2, 2);	
	var $checkbox_rowspan = 1;
	var $PageTitle = 'Penghapusan';
	var $PageIcon = 'images/penghapusan_ico.gif';
	var $FormName = 'UsulanHapus_form';
	var $pagePerHal = 10;
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='usulanhapusba.xls';
	var $Cetak_Judul = 'Berita Acara Usulan Penghapusan';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $arrtindak_lanjut = array(
			array('1','ditolak'), //$arrtindak_lanjut[$dt['tindak_lanjut']-1]['1'] $dt['tindak_lanjut']=1; $x=0=>x=1-1=>x=$dt['tindak_lanjut']-1
			array('2','dimusnahkan'), //$arrtindak_lanjut['1']['1']	$dt['tindak_lanjut']=2;$x=2-1=>x=$dt['tindak_lanjut']-1
			array('3','dipindahtangankan'),	 //$arrtindak_lanjut['2']['1'] $dt['tindak_lanjut']=3
				//ditabel 1 =1,2=1,tabel 3=1
		);//$arrtindak_lanjut[1][1][2][1]
				
	function setPage_HeaderOther(){
		return "";
		/**
			"<table width=\"100%\" class=\"menubar\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style='margin:0 0 4 0'>
			<tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
			<A href=\"pages.php?Pg=usulanhapus\" title='Usulan Penghapusan'>USULAN </a> |
			<A href=\"pages.php?Pg=usulanhapusba\" title='Berita Acara Penghapusan'>BERITA ACARA</a>  |  
			<A href=\"pages.php?Pg=usulanhapussk\" title='Usulan SK Gubernur'>USULAN SK</a>  |
			<A href=\"index.php?Pg=09&SPg=01\" title='Daftar Penghapusan'>PENGHAPUSAN </a>  
			&nbsp&nbsp&nbsp	
			</td></tr></table>";
		**/
	}
	
	function setTitle(){
		return '';
	}

	function setMenuEdit(){
		
		return'';
		//"<td>".genPanelIcon("javascript:".$this->Prefix.".Edit()","edit_f2.png","Edit", 'Edit')."</td>".
		//"<td>".genPanelIcon("javascript:".$this->Prefix.".Hapus()","delete_f2.png","Hapus", 'Hapus')."</td>";			
	}
	
	function setCetak_Header(){
		global $Main, $HTTP_COOKIE_VARS;
		
		$fmSKPD = cekPOST($this->Prefix.'SkpdfmSKPD');// echo 'fmskpd='.$fmSKPD;
		$fmUNIT = cekPOST($this->Prefix.'SkpdfmUNIT');
		$fmSUBUNIT = cekPOST($this->Prefix.'SkpdfmSUBUNIT');
		$fmSEKSI = cekPOST($this->Prefix.'SkpdfmSEKSI');
		return
		    
			"<table style='width:100%' border=\"0\">
			<tr>
				<td class=\"judulcetak\"><DIV ALIGN=CENTER>$this->Cetak_Judul</td>
			</tr>
			</table>	
			<table width=\"100%\" border=\"0\">
				<tr>
					<td class=\"subjudulcetak\">".PrintSKPD2($fmSKPD, $fmUNIT, $fmSUBUNIT,$fmSEKSI)."</td>
				</tr>
			</table><br>";
			
	}
    
	//function setPage_IconPage(){		return 'images/masterData_ico.gif';	}	
	function simpan(){
		global $HTTP_COOKIE_VARS;
		global $Main;
		$uid = $HTTP_COOKIE_VARS['coID'];
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
								
				$keterangan = $_REQUEST['Keterangan'];
				
				$tgl_ket_usul = $_REQUEST['tgl_ket_usul'];
				
				$cek .=$idplh;				
				//if( $err=='' && $status =='' ) $err= 'Status belum diisi!';					
				
				if($fmST == 0){
					if($err==''){
						$aqry = "INSERT into penghapusan_usul_det (id_bukuinduk,tgl_update,uid,ket_usul,tgl_ket_usul)
								"."values('$id_bukuinduk',now(),'$uid','$keterangan','$tgl_ket_usul')";	$cek .= $aqry;	
								
						$qry = sqlQuery($aqry);
					}
					
				}else{
					$old = sqlArray(sqlQuery("SELECT* FROM penghapusan_usul WHERE Id='$idplh'"));
					if( $err=='' ){
						if($no_usulan!=$old['no_usulan'] ){
							$get = sqlArray(sqlQuery(
								"SELECT count(*) as cnt FROM penghapusan_usul WHERE no_usulan='$no_usulan' "
							));
							if($get['cnt']>0 ) $err='No Usulan Sudah Ada!';
						}
					}
					
					if($err==''){
											
						//ambil array daftarpilih edit
						$daftarpilih = $_REQUEST[$this->Prefix.'_daftarpilih'];//Id,id_bukuinduk cat:awalnya string
						$arrDF = explode(',',$daftarpilih);//dirubah jadi array['Id','id_bukuinduk']
						$max = count($arrDF);
						for($i = 0; $i<$max; $i++){
							$iddbi = $arrDF[$i];
							
							//*********************************************************
							$arr = explode(' ',$iddbi);
							$Id = $arr[0];
							$sesi = $arr[1];
							$id_bukuinduk = $arr[2];
																											
							//update tabel penghapusan_usul_det
							$sql = "UPDATE penghapusan_usul_det 
							         set "." tgl_update =now(),
											 uid ='$uid',
											tgl_ket_usul='$tgl_ket_usul',
											 ket_usul='$keterangan'".
									 "WHERE Id='".$Id."' and sesi='".$sesi."' and id_bukuinduk='".$id_bukuinduk."' ";	$cek .= $sql; 
							$query = sqlQuery($sql);
							
							//*****************************************
						}
						
					}
					
				}
				
				//
				
			return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
				
	}
	function simpanPr(){
		global $HTTP_COOKIE_VARS;
		global $Main;
		$uid = $HTTP_COOKIE_VARS['coID'];
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
												
				$ket_ba = $_REQUEST['ket_ba'];
				
				$tgl_ket_ba = $_REQUEST['tgl_ket_ba'];
				
				$tindak_lanjut = $_REQUEST['tindak_lanjut'];
				
				$cek .=$idplh;				
								
				if($fmST == 0){
					if($err==''){
						$aqry = "INSERT into penghapusan_usul_det (ket_ba,tgl_ket_ba,tindak_lanjut)
								"."values('$ket_ba','$tgl_ket_ba','$tindak_lanjut')";	$cek .= $aqry;
									
						$qry = sqlQuery($aqry);
					}
					
				}else{
					$old = sqlArray(sqlQuery("SELECT* FROM penghapusan_usul WHERE Id='$idplh'"));
					if( $err=='' ){
						if($no_usulan!=$old['no_usulan'] ){
							$get = sqlArray(sqlQuery(
								"SELECT count(*) as cnt FROM penghapusan_usul WHERE no_usulan='$no_usulan' "
							));
							if($get['cnt']>0 ) $err='No Usulan Sudah Ada!';
						}
					}
					
					if($err==''){
						
						//ambil array daftarpilih edit
						$daftarpilih = $_REQUEST[$this->Prefix.'_daftarpilih'];//Id,id_bukuinduk cat:awalnya string
						$arrDF = explode(',',$daftarpilih);//dirubah jadi array['Id','id_bukuinduk']
						$max = count($arrDF);
						for($i = 0; $i<$max; $i++){
							$iddbi = $arrDF[$i];
							
							//*********************************************************
							$arr = explode(' ',$iddbi);
							$Id = $arr[0];
							$sesi = $arr[1];
							$id_bukuinduk = $arr[2];
																											
							//update tabel penghapusan_usul_det
							$sql = "UPDATE penghapusan_usul_det 
						            set "." tgl_update =now(),
										 uid ='$uid',
										 ket_ba = '$ket_ba',
										 tgl_ket_ba = '$tgl_ket_ba',
										 tindak_lanjut = '$tindak_lanjut'".
								   "WHERE Id='".$Id."' and sesi='".$sesi."' and id_bukuinduk='".$id_bukuinduk."' ";	$cek .= $sql; 
							
							$query = sqlQuery($sql);
							
							//*****************************************
							
						}
																			
						//update tabel penghapusan_usul_det
						/** OLD 30 April
						$sql = "update penghapusan_usul_det 
						         set "." tgl_update =now(),
										 uid ='$uid',
										 ket_ba = '$ket_ba',
										 tgl_ket_ba = '$tgl_ket_ba',
										 tindak_lanjut = '$tindak_lanjut'".
								// "where Id='".$idplh."' and id_bukuinduk";	$cek .= $sql;
								 "where Id='".$Id."' and sesi='".$sesi."' and id_bukuinduk='".$id_bukuinduk."' ";	$cek .= $sql; 
						$query = sqlQuery($sql);**/
					}
					
				}
				
				//
				
			return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
				
	}
	/**old	18 april
	function simpanPilih(){
		global $HTTP_COOKIE_VARS;
		global $Main;
		$uid = $HTTP_COOKIE_VARS['coID'];
		$cek = ''; $err=''; $content=''; $json=TRUE;
		
		$idusul = $_POST['idusul']; if(empty($idusul)) $idusul= 0;
		$sesi = $_POST['sesicari'];
		
		$coDaftar = $HTTP_COOKIE_VARS['penatausaha_DaftarPilih'];$cek .=$coDaftar;

		
		$ids= explode(',',$coDaftar); //$_POST['cidBI'];	//id bi barang
		
		
		
		$valuearr = array();
		for($i = 0; $i<count($ids); $i++)	{
			
			$valuearr[]= "('$idusul','".$ids[$i]."','$sesi', '$uid', now())";
			//cek id buku induk sudah ada!
			$aqry = "select count(*) as cnt from penghapusan_usul_det where Id='$idusul' and sesi='$sesi' and id_bukuinduk='".$ids[$i]."' "; $cek.= $aqry;
			$get = sqlArray(sqlQuery(
				$aqry
			));
			if($get['cnt']>0){
				$bi = sqlArray(sqlQuery(
					"select concat(a1,'.',a,'.',b,'.',c,'.',d,'.',substring(thn_perolehan,3),'.', e,'.',f,'.',g,'.',h,'.',i,'.',j,'.',noreg) as barcode from buku_induk where Id='".$ids[$i]."' "
				));				
				$err = 'Barang dengan kode '.$bi['barcode'].' sudah ada!';
				break;
			}
		}
		$valuestr = join(',',$valuearr);
		
		if($err==''){
			$aqry= "replace into penghapusan_usul_det (Id,id_bukuinduk,sesi, uid, tgl_update) values ".$valuestr; $cek .= $aqry;
			//$aqry= "delete from ".$this->TblName_Hapus.' '.$Kondisi; $cek.=$aqry;
			$qry = sqlQuery($aqry);
			if ($qry==FALSE){
				$err = 'Gagal Simpan Data';
			}
			
			//delete waktu dan sesi lebih dari 3 hari
			$aqry = "delete  from penghapusan_usul_det where Id=0 and (sesi IS not null and sesi <>'') and tgl_update  < DATE_SUB(CURDATE(), INTERVAL 2 DAY) ;"; $cek .= $aqry;
			$del = sqlQuery($aqry);										
					
		}
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
	}
	**/
			
	function simpanPilih(){
		global $HTTP_COOKIE_VARS;
		global $Main;
		$uid = $HTTP_COOKIE_VARS['coID'];
		$cek = ''; $err=''; $content=''; $json=TRUE;
		
		$idusul = $_POST['idusul']; if(empty($idusul)) $idusul= 0;
		$sesi = $_POST['sesicari']; if($idusul!=0) $sesi='';
		
		$coDaftar = $HTTP_COOKIE_VARS['penatausaha_DaftarPilih'];$cek .=$coDaftar;

		
		$ids= explode(',',$coDaftar); //$_POST['cidBI'];	//id bi barang
		
		
		
		$valuearr = array();
		for($i = 0; $i<count($ids); $i++)	{
			
			$valuearr[]= "('$idusul','".$ids[$i]."','$sesi', '$uid', now())";
			//cek id buku induk sudah ada!
			$aqry = "select count(*) as cnt from penghapusan_usul_det where Id='$idusul' and sesi='$sesi' and id_bukuinduk='".$ids[$i]."' "; $cek.= $aqry;
			$get = sqlArray(sqlQuery($aqry));
			
			if($get['cnt']>0){
				$bi = sqlArray(sqlQuery(
					"select concat(a1,'.',a,'.',b,'.',c,'.',d,'.',substring(thn_perolehan,3,2),'.', e,'.',e1,'.',f,'.',g,'.',h,'.',i,'.',j,'.',noreg) as barcode from buku_induk where Id='".$ids[$i]."' "
				));				
				$err = 'Barang dengan kode '.$bi['barcode'].' sudah ada!';
				break;
			}
			//cek apakah ID barang tsb atau Id buku induk itu sudah ada di no surat lain
			$bi = sqlArray(sqlQuery(
				"select concat(a1,'.',a,'.',b,'.',c,'.',d,'.',substring(thn_perolehan,3,2),'.', e,'.',e1,'.',f,'.',g,'.',h,'.',i,'.',j,'.',noreg) as barcode from buku_induk where Id='".$ids[$i]."' "
			));	
			$read = sqlArray(sqlQuery("select count(*) as hit from penghapusan_usul_det where id_bukuinduk='".$ids[$i]."' and (sesi='' or sesi is null) "));
			if($read['hit']>0){
				$read = sqlArray(sqlQuery("SELECT * FROM penghapusan_usul_det WHERE id_bukuinduk='".$ids[$i]."' "));
				if($read['tindak_lanjut']!=1){// 1 = barang status ditolak boleh di usulkan lagi oelh yang lain
					$select = sqlArray(sqlQuery("SELECT*  FROM penghapusan_usul WHERE Id='".$read['Id']."'"));	
					$err = 'Barang dengan Kode '.$bi['barcode'].' ini sudah ada di '.$select['no_usulan'];
					break;
				}				
			}
		}
		$valuestr = join(',',$valuearr);
		
		
		if($err==''){
			$aqry= "replace into penghapusan_usul_det (Id,id_bukuinduk,sesi, uid, tgl_update) values ".$valuestr; $cek .= $aqry;
			//$aqry= "delete from ".$this->TblName_Hapus.' '.$Kondisi; $cek.=$aqry;
			$qry = sqlQuery($aqry);
			if ($qry==FALSE){
				$err = 'Gagal Simpan Data';
			}
			
			//delete waktu dan sesi lebih dari 3 hari
			$aqry = "delete  from penghapusan_usul_det where Id=0 and (sesi IS not null and sesi <>'') and tgl_update  < DATE_SUB(CURDATE(), INTERVAL 2 DAY) ;"; $cek .= $aqry;
			$del = sqlQuery($aqry);										
					
		}
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
	}

	
	
	function set_selector_other($tipe){
		global $Main;
		$cek = ''; $err=''; $content=''; $json=TRUE;
		switch($tipe){	
			case 'simpanPilih':{
				$get= $this->simpanPilih();
				$cek = $get['cek'];
				$err = $get['err'];
				$content = $get['content'];
				//$cek = 'trs';
				break;
			}
			case 'cbxgedung':{
				$c= $_REQUEST[$this->Prefix.'SkpdfmSKPD'];
				$d= $_REQUEST[$this->Prefix.'SkpdfmUNIT'];
				$e= $_REQUEST[$this->Prefix.'SkpdfmSUBUNIT'];
				$e1= $_REQUEST[$this->Prefix.'SkpdfmSEKSI'];
				if($c=='' || $c =='00') {
					$kondC='';
				}else{
					$kondC = "and c = '$c'";
				}
				if($d=='' || $d =='00') {
					$kondD='';
				}else{
					$kondD = "and d = '$d'";
				}
				if($e=='' || $e =='00') {
					$kondE='';
				}else{
					$kondE = "and e = '$e'";
				}
				if($e1=='' || $e1 =='00' || $e1 =='000') {
					$kondE1='';
				}else{
					$kondE1 = "and e1 = '$e1'";
				}
				$aqry = "select * from ref_ruang where q='0000' $kondC $kondD $kondE $kondE1";
				$cek .= $aqry;
				$content = genComboBoxQry( 'fmPILGEDUNG', $fmPILGEDUNG, 
						$aqry,
						'p', 'nm_ruang', '-- Semua Gedung --',"style='width:140'" );
				break;
			}		
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
			case 'formPeriksa':{				
				$fm = $this->setFormPeriksa();				
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];												
				break;
			}
			case 'simpanPr':{
				
				$get= $this->simpanPr();
				$cek = $get['cek'];
				$err = $get['err'];
				$content = $get['content'];
				break;
			}
			case 'simpan':{
				
				$get= $this->simpan();
				$cek = $get['cek'];
				$err = $get['err'];
				$content = $get['content'];
				break;
			}
			case 'batal':{
				
				$get= $this->batal();
				$cek = $get['cek'];
				$err = $get['err'];
				$content = $get['content'];
				break;
			}
			case 'getdata':{
				$id = $_REQUEST['id'];
				$aqry = "select * from ref_pegawai where id='$id' "; $cek .= $aqry;
				$get = sqlArray( sqlQuery($aqry));
				if($get==FALSE) $err= "Gagal ambil data!"; 
				$content = array('nip'=>$get['nip'],'nama'=>$get['nama'],'jabatan'=>$get['jabatan']);
				break;
			}
			default:{
				$other = $this->set_selector_other2($tipe);
				$cek = $other['cek'];
				$err = $other['err'];
				$content=$other['content'];
				$json=$other['json'];
				break;
			}
			/*default:{
				$err = 'tipe tidak ada!';
				break;
			}*/
		}
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}
	
	function setPage_OtherScript(){
		$scriptload = 
					"<script>
						$(document).ready(function(){ 
							".$this->Prefix.".loading();
						});
						
					</script>";
					
		return 
			/*"<script type='text/javascript' src='js/dialog1.js' language='JavaScript' ></script>**/
			"<script type='text/javascript' src='js/pegawai.js' language='JavaScript' ></script>".
			"<script type='text/javascript' src='js/barcode.js' language='JavaScript' ></script>".			
			"<script type='text/javascript' src='js/skpd.js' language='JavaScript' ></script>".		
			"<script type='text/javascript' src='js/usulanhapussk.js' language='JavaScript' ></script>".		
			"<script type='text/javascript' src='js/".strtolower($this->Prefix).".js' language='JavaScript' ></script>".
			$scriptload;
	}
	
	//form ==================================
	function setFormBaru(){
		$dt=array();
		$dt['c'] = $_REQUEST[$this->Prefix.'SkpdfmSKPD'];
		$dt['d'] = $_REQUEST[$this->Prefix.'SkpdfmUNIT'];
		$dt['e'] = $_REQUEST[$this->Prefix.'SkpdfmSUBUNIT'];
		$dt['e1'] = $_REQUEST[$this->Prefix.'SkpdfmSEKSI'];
		
		$dt['p'] = '';
		$dt['q'] = '';
		//$this->form_idplh ='';
		$this->form_fmST = 0;
		$fm = $this->setForm($dt);
		return	array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}
	function setFormPeriksa(){
		$cek ='';
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$c = $_REQUEST[$this->Prefix.'SkpdfmSKPD'];
		$d = $_REQUEST[$this->Prefix.'SkpdfmUNIT'];
		$e = $_REQUEST[$this->Prefix.'SkpdfmSUBUNIT'];
		$e1 = $_REQUEST[$this->Prefix.'SkpdfmSEKSI'];
				
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$Id = $kode[0];
		$sesi = $kode[1];
		$id_bukuinduk = $kode[2];
		$this->form_fmST = 1;
		
		//get data 
		$aqry = "select * from penghapusan_usul_det where Id ='".$Id."' and sesi = '".$sesi."' and id_bukuinduk='".$id_bukuinduk."' "; $cek.=$aqry;
		$dt = sqlArray(sqlQuery($aqry));
		
		//set form
		$fm = $this->setFormPR($dt);
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}	
	function setFormEdit(){
		$cek ='';
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$c = $_REQUEST[$this->Prefix.'SkpdfmSKPD'];
		$d = $_REQUEST[$this->Prefix.'SkpdfmUNIT'];
		$e = $_REQUEST[$this->Prefix.'SkpdfmSUBUNIT'];
		$e1 = $_REQUEST[$this->Prefix.'SkpdfmSEKSI'];
				
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$Id = $kode[0];
		$sesi = $kode[1];
		$id_bukuinduk = $kode[2];
		
		$this->form_fmST = 1;
		
		//get data penghapusan usul
		$aqry = "select * from penghapusan_usul_det where Id ='".$Id."' and sesi = '".$sesi."' and id_bukuinduk='".$id_bukuinduk."' "; $cek.=$aqry;
		
		$dt = sqlArray(sqlQuery($aqry));
			
		if ($dt['tgl_ket_usul'] == '') $dt['tgl_ket_usul'] = date('Y-m-d');
		//set form
		$fm = $this->setForm($dt);
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}	
	function setForm($dt){	
		global $SensusTmp,$Main;
		$cek = ''; $err=''; $content=''; 
		$json = TRUE;	//$ErrMsg = 'tes';
		$idplh = $_REQUEST[$this->Prefix.'_idplh'];
		
		
		$form_name = $this->Prefix.'_form';				
		$this->form_width = 640;
		$this->form_height = 100;
		if ($this->form_fmST==0) {
			$this->form_caption = 'Baru';
			$nip	 = '';
		}else{
			$this->form_caption = 'Catatan';			
			$ref_idpegawai_usul = $dt['ref_idpegawai_usul'];			
		}
		$kdSubUnit0 = genNumber(0, $Main->SUBUNIT_DIGIT );
		//items ----------------------
		$get=sqlArray(sqlQuery("select * from ref_skpd where c='".$dt['c']."' and d='00' "));
		$bidang = $get['nm_skpd'];
		$get=sqlArray(sqlQuery("select * from ref_skpd where c='".$dt['c']."' and d='".$dt['d']."' and e='00' "));
		$unit = $get['nm_skpd'];

		$get=sqlArray(sqlQuery("select * from ref_skpd where c='".$dt['c']."' and d='".$dt['d']."' and e='".$dt['e']."'  and e1='".$kdSubUnit0."' "));
		$subunit = $get['nm_skpd'];		

		$get=sqlArray(sqlQuery("select * from ref_skpd where c='".$dt['c']."' and d='".$dt['d']."' and e='".$dt['e']."'  and e1='".$dt['e1']."' "));
		$seksi = $get['nm_skpd'];		
						
		//ambil data a1,a,b,c,d,e,f,g,h,i,j,thn_perolehan,no_reg di tabel buku induk
		$get = sqlArray(sqlQuery(
								"SELECT a1,a,b,c,d,e,e1,f,g,h,i,j,noreg,thn_perolehan from buku_induk 
								 WHERE Id ='".$dt['id_bukuinduk']."'"));
								 
		$kodea1 = $get['a1']; $kodea = $get['a']; $kodeb = $get['b']; $kodec = $get['c'];$koded = $get['d']; 
		$kodee = $get['e']; $kodee1 = $get['e1'];$kodef = $get['f']; $kodeg = $get['g']; $kodeh = $get['h']; $kodei = $get['i']; $kodej = $get['j'];	
		$noreg = $get['noreg']; $thn_perolehan = $get['thn_perolehan'];
		
		//ambil data thn perolehan 2 angka di belakang contoh:2008 jadi 08
		$thnPer = substr($thn_perolehan,2,2);
		
		//ambil data di ref barang
		$read = sqlArray(sqlQuery(
						   "SELECT*from ref_barang WHERE f='".$kodef."' 
						   							 AND g='".$kodeg."'
													 AND h='".$kodeh."'
													 AND i='".$kodei."'
													 AND j='".$kodej."'
													 "));
						
		$this->form_fields = array(				
			//'bidang' => array(  'label'=>'BIDANG', 'value'=> $bidang, 'labelWidth'=>120, 'type'=>'' ),
			//'unit' => array(  'label'=>'ASISTEN / OPD', 'value'=> $unit, 'labelWidth'=>120, 'type'=>'' ),
			//'subunit' => array(  'label'=>'BIRO / UPTD/B', 'value'=> $subunit, 'labelWidth'=>120, 'type'=>'' ),
			/**
			'kode_barang' => array(  
				'label'=>'Kode Barang', 
				'value'=> $kodea1.'.'.$kodea.'.'.$kodeb.'.'.$kodec.'.'.$koded.'.'.$thnPer.'.'.$kodee.'.'.$kodef.'.'.$kodeg
						  .'.'.$kodeh.'.'.$kodei.'.'.$kodej.'.'.$noreg,
				'type'=>'' 
			),
			'nama_barang' =>array(
				'label'=>'Nama Barang',
				//'value'=>$f.'.'.$g.'.'.$h.'.'.$i.'.'.$j.' '.$namaBarang, //validasi apakah kode tersebut benar
				'value'=>$read['nm_barang'], 
				'type'=>''
			),
			**/
			'tgl_ket_usul' => array( 
				'label'=>'Tgl. Catatan',
				'value'=>$dt['tgl_ket_usul'], 
				'type'=>'date'
			 ),
			'Keterangan' =>array(
				'label'=>'Catatan',
				'value'=>
					'<textarea id="Keterangan"  name="Keterangan" style="margin: 2px; width: 453px; height: 40px;">'.$dt['ket_usul'].'</textarea>',
				'labelWidth'=>120, 
				'type'=>'' , 
				'row_params'=> " valign='top'"
			)			
			
		);
		
				
		//tombol
		$this->form_menubawah =
			"<input type=hidden id='c' name='c' value='".$dt['c']."'> ".
			"<input type=hidden id='d' name='d' value='".$dt['d']."'> ".
			"<input type=hidden id='e' name='e' value='".$dt['e']."'> ".
			"<input type=hidden id='e1' name='e1' value='".$dt['e1']."'> ".
			"<input type='hidden' value='' id='".$this->Prefix."_daftarpilih' name='".$this->Prefix."_daftarpilih'>".
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan()' >".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close(1)' >";
		
		
		$form = $this->genForm();		
				
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function setCekBox($cb, $KeyValueStr, $isi){
		$hsl = '';
		if($KeyValueStr!=''){
			
		
			$hsl = "<input type='checkbox' id='".$this->Prefix."_cb$cb' name='".$this->Prefix."_cb[]' 
					value='".$KeyValueStr."' onClick=\"isChecked2(this.checked,'".$this->Prefix."_jmlcek');".$this->Prefix.".cbxPilih(this);\" />";					
		}
		return $hsl;
	}
	
	function setFormPR($dt){	
		global $SensusTmp,$Main;
		$cek = ''; $err=''; $content=''; 
		$json = TRUE;	//$ErrMsg = 'tes';
		$idplh = $_REQUEST[$this->Prefix.'_idplh'];
				
		$tindak_lanjut = $_REQUEST['tindak_lanjut'];
		
		$form_name = $this->Prefix.'_form';				
		$this->form_width = 640;
		$this->form_height = 210;
		if ($this->form_fmST==0) {
			$this->form_caption = 'Baru';
			$nip	 = '';
		}else{
			$this->form_caption = 'Edit';			
			$ref_idpegawai_usul = $dt['ref_idpegawai_usul'];			
		}
		
		$kdSubUnit0 = genNumber(0, $Main->SUBUNIT_DIGIT );
		//items ----------------------
		//$sesi = gen_table_session('sensus','uid');
		//style='width: 318px;text-transform: uppercase;'
		$get=sqlArray(sqlQuery("select * from ref_skpd where c='".$dt['c']."' and d='00' "));
		$bidang = $get['nm_skpd'];
		$get=sqlArray(sqlQuery("select * from ref_skpd where c='".$dt['c']."' and d='".$dt['d']."' and e='00' "));
		$unit = $get['nm_skpd'];
		$get=sqlArray(sqlQuery("select * from ref_skpd where c='".$dt['c']."' and d='".$dt['d']."' and e='".$dt['e']."'  and e1='".$kdSubUnit0."'"));
		$subunit = $get['nm_skpd'];		
		$get=sqlArray(sqlQuery("select * from ref_skpd where c='".$dt['c']."' and d='".$dt['d']."' and e='".$dt['e']."'  and e1='".$dt['e1']."'"));
		$seksi = $get['nm_skpd'];		
						
		//ambil data a1,a,b,c,d,e,f,g,h,i,j,thn_perolehan,no_reg di tabel buku induk
		$get = sqlArray(sqlQuery(
								"SELECT a1,a,b,c,d,e,e1,f,g,h,i,j,noreg,thn_perolehan from buku_induk 
								 WHERE Id ='".$dt['id_bukuinduk']."'"));
								 
		$kodea1 = $get['a1']; $kodea = $get['a']; $kodeb = $get['b']; $kodec = $get['c'];$koded = $get['d']; 
		$kodee = $get['e'];$kodee1 = $get['e1']; $kodef = $get['f']; $kodeg = $get['g']; $kodeh = $get['h']; $kodei = $get['i']; $kodej = $get['j'];	
		$noreg = $get['noreg']; $thn_perolehan = $get['thn_perolehan'];
		
		//ambil data thn perolehan 2 angka di belakang contoh:2008 jadi 08
		$thnPer = substr($thn_perolehan,2,2);
		
		//ambil data di ref barang
		$read = sqlArray(sqlQuery(
						   "SELECT*from ref_barang WHERE f='".$kodef."' 
						   							 AND g='".$kodeg."'
													 AND h='".$kodeh."'
													 AND i='".$kodei."'
													 AND j='".$kodej."'
													 "));
				
		$this->form_fields = array(				
			//'bidang' => array(  'label'=>'BIDANG', 'value'=> $bidang, 'labelWidth'=>120, 'type'=>'' ),
			//'unit' => array(  'label'=>'ASISTEN / OPD', 'value'=> $unit, 'labelWidth'=>120, 'type'=>'' ),
			//'subunit' => array(  'label'=>'BIRO / UPTD/B', 'value'=> $subunit, 'labelWidth'=>120, 'type'=>'' ),
			'kode_barang' => array(  
				'label'=>'Kode Barang', 
				'value'=> $kodea1.'.'.$kodea.'.'.$kodeb.'.'.$kodec.'.'.$koded.'.'.$thnPer.'.'.$kodee.'.'.$kodee1.'.'.$kodef.'.'.$kodeg
						  .'.'.$kodeh.'.'.$kodei.'.'.$kodej.'.'.$noreg,
				'type'=>'' 
			),
			'nama_barang' =>array(
				'label'=>'Nama Barang',
				//'value'=>$f.'.'.$g.'.'.$h.'.'.$i.'.'.$j.' '.$namaBarang, //validasi apakah kode tersebut benar
				'value'=> $read['nm_barang'], 
				'type'=>''
			),
			
			'tgl_ket_ba' => array( 
				'label'=>'Tgl. Pengecekan',
				'value'=>$dt['tgl_ket_ba'], 
				'type'=>'date'
			 ),
			'ket_ba' =>array(
				'label'=>'Keterangan',
				'value'=>
					'<textarea id="ket_ba"  name="ket_ba" style="margin: 2px; width: 453px; height: 40px;">'.$dt['ket_ba'].'</textarea>',
				'labelWidth'=>120, 
				'type'=>'' , 
				'row_params'=> " valign='top'"
			),
			'tindak_lanjut'=>array(
					'label' =>'Tindak Lanjut',
					'value' =>
						cmbArray('tindak_lanjut',$dt['tindak_lanjut'],$this->arrtindak_lanjut,'-- PILIH --','')//generate checkbox
			)
			
		);
		
				
		//tombol
		$this->form_menubawah =
			"<input type=hidden id='c' name='c' value='".$dt['c']."'> ".
			"<input type=hidden id='d' name='d' value='".$dt['d']."'> ".
			"<input type=hidden id='e' name='e' value='".$dt['e']."'> ".
			"<input type=hidden id='e1' name='e1' value='".$dt['e1']."'> ".
			"<input type='hidden' value='' id='".$this->Prefix."_daftarpilih' name='".$this->Prefix."_daftarpilih'>".
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SimpanPr()' >".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close(1)' >";
		
		
		$form = $this->genForm();		
				
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	
	//daftar =================================
	function setKolomHeader($Mode=1, $Checkbox=''){
		$NomorColSpan = $Mode==1? 2: 1;
		$daftar_mode = $_REQUEST['daftar_mode'];
		switch($daftar_mode){
			case 1:{
				$headerTable =
					"<thead>
											
						<tr>
						<hr><h3>DAFTAR BARANG</h3>
						<th class='th02' colspan='4'>Nomor</th>
						<th class='th02' colspan='3'>Spesifikasi Barang</th>
						<th class='th01' width='20' rowspan='2'>Tahun Perolehan</th>
						<th class='th01' width='20' rowspan='2'>Keadaan Barang</th>
						<th class='th01' rowspan='2'>Harga Perolehan</th>
						<th class='th02' colspan='2'>Keterangan</th>
						<th class='th02' colspan='2'>Pengecekan</th>
						<th class='th01' rowspan='2'>Tindak Lanjut</th>						
						</tr>	
						<tr>
							<th class='th01' width='20' >No.</th>
							$Checkbox		
							<th class='th01' >Kode Barang</th>
							<th class='th01' >No. Reg</th>
							<th class='th01' >Nama Jenis Barang</th>
							<th class='th01' >Merk/Tipe</th>
							<th class='th01' width='30'>No. Sertifikat / No. Pabrik / No.Mesin</th>
							<th class='th01' >Tgl.</th>
							<th class='th01' >Keterangan</th>
							<th class='th01' >Tgl.</th>
							<th class='th01' >Keterangan</th>
						</tr>							
						
										
						
					</thead>";
				break;
			}
			default:{
				$headerTable =
					"<thead>
						<tr>
						<hr><h3>DAFTAR BARANG</h3>
						<th class='th02' colspan='4'>Nomor</th>
						<th class='th02' colspan='3'>Spesifikasi Barang</th>
						<th class='th01' width='50' rowspan='2'>Tahun Perolehan</th>
						<th class='th01'  width='50' rowspan='2'>Keadaan Barang</th>
						<th class='th01' width='120' rowspan='2'>Harga Perolehan</th>
						<th class='th02' colspan='2'>Keterangan</th>
						</tr>	
						<tr>
							<th class='th01' width='20' >No.</th>
							$Checkbox		
							<th class='th01'    width='140' >Kode Barang</th>
							<th class='th01' width='80'>No. Reg</th>
							<th class='th01' width='30'>Nama Jenis Barang</th>
							<th class='th01' width='20'>Merk/Tipe</th>
							<th class='th01' width='20'>No. Sertifikat / No. Pabrik / No.Mesin</th>
							<th class='th01' width='80' >Tgl</th>
							<th class='th01' width='200'>Catatan</th>
						</tr>			
						
					</thead>";
				break;
			}
		}
				
		return $headerTable;
	}
	
	
	//08maret2013
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
		global $Ref;
		global $Main;
		$daftar_mode = $_REQUEST['daftar_mode'];
		
		$tindak_lanjut = $_REQUEST['tindak_lanjut'];
						
		//--- get dinas		
		$dinas = '';		
		$c=''.$isi['c'];
		$d=''.$isi['d'];
		$e=''.$isi['e'];		
		$e1=''.$isi['e1'];		
		$nmopdarr=array();				
		$get = sqlArray(sqlQuery(
			"select * from v_bidang where c='".$c."' "
		));		
		if($get['nmbidang']<>'') $nmopdarr[] = $get['nmbidang'];
		$get = sqlArray(sqlQuery(
			"select * from v_opd where c='".$c."' and d='".$d."' "
		));		
		if($get['nmopd']<>'') $nmopdarr[] = $get['nmopd'];
		$get = sqlArray(sqlQuery(
			"select * from v_unit where c='".$c."' and d='".$d."' and e='".$e."'"
		));		
		if($get['nmunit']<>'') $nmopdarr[] = $get['nmunit'];

		$get = sqlArray(sqlQuery(
			"select * from ref_skpd where c='".$c."' and d='".$d."' and e='".$e."'  and e1='".$e1."'"
		));		
		if($get['nm_skpd']<>'') $nmopdarr[] = $get['nm_skpd'];


		$nmopd = join(' - ', $nmopdarr );
			
		//ambil id buku induk di tabel penghapusan_usul_det
		 $id = ''.$isi['id_bukuinduk'];		
		 
		//ambil data no reg,thn_perolehan,jml_harga,kondisi dari tabel buku induk berdasarkan Id dari Id tabel penghapusan_usul_det
		$bi = sqlArray(sqlQuery("SELECT * from buku_induk WHERE Id ='".$id."' "));
		
		//thn perolehan ini khusus untuk di pakai di kode barang
		 $thnPER =substr($bi['thn_perolehan'],2,2) ;
		   					
		$noreg = $bi['noreg'];
		$thn_perolehan = $bi['thn_perolehan'];
		//$vhargaA =$a[0]->harga==0?'': number_format($a[0]->harga,2,',','.');
		$jml_harga = $bi['jml_harga']==0?'':number_format($bi['jml_harga'],2,',','.');
		$kondisi = $bi['kondisi'];
		
		/*ambil data nama barang di tabel ref_barang berdasarkan f,g,h,i,j = f,g,h,i,j di tabel buku induk
		  dan Id di tabel buku induk= Id buku induk di penghapusan_usul_det	
		*/
		$brng =sqlArray(sqlQuery("SELECT* FROM ref_barang
											    WHERE   f = '".$bi['f']."'
												    AND g = '".$bi['g']."'
											      	AND h = '".$bi['h']."'
											      	AND i = '".$bi['i']."'
											     	AND j = '".$bi['j']."'
												  	
											 "));
		#ambil data f di tabel buku induk berdasarkan Id di tabel buku induk= id buku induk di tabel penghapusan usul_det
		$f = $bi['f'];
		
		switch ($f)
		{
		case '01':{
		 #ambil kib a berdasarkan f di buku induk jika f=01
		 $getkiba = sqlArray(sqlQuery("SELECT sertifikat_no from kib_a
		                                          WHERE a1 = '".$bi['a1']."' 
		                                            AND a = '".$bi['a']."' 
		                                            AND b = '".$bi['b']."' 
		                                            AND c = '".$bi['c']."' 
		                                            AND d = '".$bi['d']."' 
		                                            AND e = '".$bi['e']."' 
		                                            AND e1 = '".$bi['e1']."' 
												 	AND f ='".$bi['f']."' 
		                                            AND g ='".$bi['g']."' 
		                                            AND h ='".$bi['h']."' 
		                                            AND i ='".$bi['i']."' 
		                                            AND j ='".$bi['j']."' 
													AND noreg = '".$bi['noreg']."'
													AND tahun = '".$bi['thn_perolehan']."'
												  "));
		  $merk='-';
		  $spesifikasi = $getkiba['sertifikat_no'] !=''?$getkiba['sertifikat_no'].'/ /':'';
		  break;
		  }
		case '02':{
		 #ambil kib b berdasarkan f di buku induk jika f=02
		$getkibb = sqlArray(sqlQuery("SELECT merk,no_pabrik,bahan,no_mesin from kib_b
		                                          WHERE a1 = '".$bi['a1']."' 
		                                            AND a = '".$bi['a']."' 
		                                            AND b = '".$bi['b']."' 
		                                            AND c = '".$bi['c']."' 
		                                            AND d = '".$bi['d']."' 
		                                            AND e = '".$bi['e']."' 
		                                            AND e1 = '".$bi['e1']."' 
												  	AND f ='".$bi['f']."' 
		                                            AND g ='".$bi['g']."' 
		                                            AND h ='".$bi['h']."' 
		                                            AND i ='".$bi['i']."' 
		                                            AND j ='".$bi['j']."' 
													AND noreg = '".$bi['noreg']."'
													AND tahun = '".$bi['thn_perolehan']."'
												  ")); 
		
	       $merk =$getkibb['merk']; 
		   $spesifikasi = $getkibb['no_mesin'] !=''? '/'.$getkibb['no_mesin'].'/':'/ ';
		   $spesifikasi .= $getkibb['no_pabrik'] !=''? $getkibb['no_pabrik'].'/':'';//$getkibb['no_pabrik'];
		  // $spesifikasi .= $getkibb['bahan'] !=''?$getkibb['bahan']:'';
		   
		   
		  		 
		  break;
		}
		case '03':{
		 #ambil kib c berdasarkan f di buku induk jika f=03
		$getkibc = sqlArray(sqlQuery("SELECT dokumen_no from kib_c
		                                          WHERE a1 = '".$bi['a1']."' 
		                                            AND a = '".$bi['a']."' 
		                                            AND b = '".$bi['b']."' 
		                                            AND c = '".$bi['c']."' 
		                                            AND d = '".$bi['d']."' 
		                                            AND e = '".$bi['e']."' 
		                                            AND e1 = '".$bi['e1']."' 
												  	AND f ='".$bi['f']."' 
		                                            AND g ='".$bi['g']."' 
		                                            AND h ='".$bi['h']."' 
		                                            AND i ='".$bi['i']."' 
		                                            AND j ='".$bi['j']."'
													AND noreg = '".$bi['noreg']."'
													AND tahun = '".$bi['thn_perolehan']."' 
												  "));
		$merk='-';
		$spesifikasi = $getkibc['dokumen_no'] !=''?$getkibc['dokumen_no'].'/ /':'-';  
		  break;
		}
		case '04':{
		 #ambil kib d berdasarkan f di buku induk jika f=04
		$getkibd = sqlArray(sqlQuery("SELECT dokumen_no from kib_d
		                                          WHERE a1 = '".$bi['a1']."' 
		                                            AND a = '".$bi['a']."' 
		                                            AND b = '".$bi['b']."' 
		                                            AND c = '".$bi['c']."' 
		                                            AND d = '".$bi['d']."' 
		                                            AND e = '".$bi['e']."'  
		                                            AND e1 = '".$bi['e1']."' 
												  	AND f ='".$bi['f']."' 
		                                            AND g ='".$bi['g']."' 
		                                            AND h ='".$bi['h']."' 
		                                            AND i ='".$bi['i']."' 
		                                            AND j ='".$bi['j']."' 
													AND noreg = '".$bi['noreg']."'
													AND tahun = '".$bi['thn_perolehan']."' 
												  "));
		$merk='-';
		$spesifikasi = $getkibd['dokumen_no'] !=''?$getkibd['dokumen_no'].'/ /':'';  
		  break;
		}
		case '05':{
		 #ambil kib e berdasarkan f di buku induk jika f=05
		$getkibe = sqlArray(sqlQuery("SELECT * from kib_e
		                                          WHERE a1 = '".$bi['a1']."' 
		                                            AND a = '".$bi['a']."' 
		                                            AND b = '".$bi['b']."' 
		                                            AND c = '".$bi['c']."' 
		                                            AND d = '".$bi['d']."' 
		                                            AND e = '".$bi['e']."'  
		                                            AND e1 = '".$bi['e1']."' 
												  	AND f ='".$bi['f']."' 
		                                            AND g ='".$bi['g']."' 
		                                            AND h ='".$bi['h']."' 
		                                            AND i ='".$bi['i']."' 
		                                            AND j ='".$bi['j']."' 
													AND noreg = '".$bi['noreg']."'
													AND tahun = '".$bi['thn_perolehan']."' 
												  "));  
		$merk='-';
		$spesifikasi = $getkibe['dokumen_no'] !=''?$getkibe['dokumen_no']:'-';  
		  break;
		}
		 
		default:{
			$getkibf = sqlArray(sqlQuery("SELECT dokumen_no from kib_f
		                                          WHERE a1 = '".$bi['a1']."' 
		                                            AND a = '".$bi['a']."' 
		                                            AND b = '".$bi['b']."' 
		                                            AND c = '".$bi['c']."' 
		                                            AND d = '".$bi['d']."' 
													AND e = '".$bi['e']."'  
													AND e1 = '".$bi['e1']."'  
												    AND f ='".$bi['f']."' 
		                                            AND g ='".$bi['g']."' 
		                                            AND h ='".$bi['h']."' 
		                                            AND i ='".$bi['i']."' 
		                                            AND j ='".$bi['j']."' 
													AND noreg = '".$bi['noreg']."'
													AND tahun = '".$bi['thn_perolehan']."' 
										  ")); 
		$merk='-';	
		$spesifikasi = $getkibf['dokumen_no'] !=''?$getkibf['dokumen_no']:'/';
		}
	}
		
		$Koloms = array();
		switch($daftar_mode){
			case 1:{
				$Koloms[] = array('align=right', $no.'.' );
				if ($Mode == 1) $Koloms[] = array(" align='center'  ", $TampilCheckBox);
				$Koloms[] = array('',$bi['a1'].'.'.$bi['a'].'.'.$bi['b'].'.'.$bi['c'].'.'.$bi['d'].'.'.$thnPER.'.'.$bi['e']
									 .'<br/>'.$bi['f'].'.'.$bi['g'].'.'.$bi['h'].'.'.$bi['i'].'.'.$bi['j'] .'.'.$noreg);	
				$Koloms[] = array('align=center', $noreg);		
				$Koloms[] = array('', $brng['nm_barang']);		
				$Koloms[] = array('',$merk);		
				$Koloms[] = array('', $spesifikasi);				
				$Koloms[] = array('align=center', $thn_perolehan);				
				$Koloms[] = array('', $Main->KondisiBarang[$kondisi-1][1]);				
				$Koloms[] = array('align=right', $jml_harga);				
				$Koloms[] = array('align=center', TglInd($isi['tgl_ket_usul']));				
				$Koloms[] = array('', $isi['ket_usul']);
				$Koloms[] = array('align=center', TglInd($isi['tgl_ket_ba']));
				$Koloms[] = array('', $isi['ket_ba']);
				$Koloms[] = array('', $this->arrtindak_lanjut[ $isi['tindak_lanjut']-1][1]);//$dt['tindak_lanjut']
												
				break;
			}		
			default:{
				$Koloms[] = array('align=right', $no.'.' );
				if ($Mode == 1) $Koloms[] = array(" align='center'  ", $TampilCheckBox);
				$Koloms[] = array('',$bi['a1'].'.'.$bi['a'].'.'.$bi['b'].'.'.$bi['c'].'.'.$bi['d'].'.'.$thnPER.'.'.$bi['e'].'.'.$bi['e1']
									 .'<br/>'.$bi['f'].'.'.$bi['g'].'.'.$bi['h'].'.'.$bi['i'].'.'.$bi['j'] .'.'.$noreg);	
				$Koloms[] = array('align=center', $noreg);		
				$Koloms[] = array('', $brng['nm_barang']);		
				$Koloms[] = array('',$merk);		
				$Koloms[] = array('', $spesifikasi);				
				$Koloms[] = array('align=center', $thn_perolehan);				
				$Koloms[] = array('', $Main->KondisiBarang[$kondisi-1][1]);				
				$Koloms[] = array('align=right', $jml_harga);				
				$Koloms[] = array('align=center', TglInd($isi['tgl_ket_usul']));				
				$Koloms[] = array('', $isi['ket_usul']);
				break;
			}	
		}
		
		return $Koloms;
		
	}
	
	function setTopBar(){
	   // return genSubTitle($this->setTitle(),$this->genMenu());
		return "";
	}
	
	function genDaftarOpsi(){
		global $Ref, $Main;
		$fmPILGEDUNG = $_REQUEST['fmPILGEDUNG'];		
		$TampilOpt =
			"<table width=\"100%\" class=\"adminform\">	<tr>		
			<td width=\"100%\" valign=\"top\">" . 
				WilSKPD_ajx3($this->Prefix.'Skpd') . 
			"</td>
			<td >" . 		
			"</td></tr>
			<tr><td>
				<input type='button' id='btTampil' value='Tampilkan' onclick='".$this->Prefix.".refreshList(true)'>
			</td></tr>			
			</table>";
			//genFilterBar(
				//''
				//,$this->Prefix.".refreshList(true)",TRUE, 'Tampilkan'
			//);
		//return array('TampilOpt'=>$TampilOpt);
	}	
					   		
	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID']; 
		//kondisi -----------------------------------
				
		
		$arrKondisi = array();		
		$fmSKPD = isset($HTTP_COOKIE_VARS['cofmSKPD'])? $HTTP_COOKIE_VARS['cofmSKPD']: cekPOST($this->Prefix.'SkpdfmSKPD');
		$fmUNIT = isset($HTTP_COOKIE_VARS['cofmUNIT'])? $HTTP_COOKIE_VARS['cofmUNIT']: cekPOST($this->Prefix.'SkpdfmUNIT');
		$fmSUBUNIT = isset($HTTP_COOKIE_VARS['cofmSUBUNIT'])? $HTTP_COOKIE_VARS['cofmSUBUNIT']: cekPOST($this->Prefix.'SkpdfmSUBUNIT');		
		$fmSEKSI = isset($HTTP_COOKIE_VARS['cofmSEKSI'])? $HTTP_COOKIE_VARS['cofmSEKSI']: cekPOST($this->Prefix.'SkpdfmSEKSI');		
		$id = $_REQUEST['UsulanHapus_idplh']; //ambil data kondisi
		$sesi = $_REQUEST['sesi'];
		$genStr ='Id'.'='.$id; //ambil nama field untuk data kondisi
		if ($id !=''){$arrKondisi[]=$genStr;}  else{
			if($sesi !='')$arrKondisi[]='sesi'.'='."'$sesi'";
		}   		 			 
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;		
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');				
		$Asc = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
		$arrOrders[] = " a,b,c,d,e,e1,nip ";
		/*switch($fmORDER1){
			case '1': $arrOrders[] = " no_terima $Asc " ;break;
			case '2': $arrOrders[] = " i $Asc " ;break;
		}*/		
		$Order= join(',',$arrOrders);	
		$OrderDefault = '';// Order By no_terima desc ';
		$Order =  $Order ==''? $OrderDefault : ' Order By '.$Order;
		$Order ="";
		//limit --------------------------------------
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
	
	

}
$UsulanHapusdetail = new UsulanHapusdetailObj();


?>