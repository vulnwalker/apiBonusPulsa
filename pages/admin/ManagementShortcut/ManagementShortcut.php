<?php
class ManagementShortcutObj  extends DaftarObj2{	
	var $Prefix = 'ManagementShortcut';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'system_shortcut'; //daftar 
	var $TblName_Hapus = 'system_shortcut';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('Id_shortcut');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $checkbox_rowspan = 1;
	var $PageTitle = 'Management Shortcut';
	var $PageIcon = 'images/masterdata_ico.gif';
	var $pagePerHal ='';
	var $cetak_xls=TRUE ;
	var $fileNameExcel='usulansk.xls';
	var $Cetak_Judul = 'Management Shortcut';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'ManagementShortcutForm'; 
	
			
	function setTitle(){
		return 'Management Shortcut';
	}
	
	function setMenuView(){
		return "";
	}
	function setMenuEdit(){
		return
		"<td>".genPanelIcon("javascript:".$this->Prefix.".Upload()","upload_f2.png","Upload", 'Upload')."</td>".
		"<td>".genPanelIcon("javascript:".$this->Prefix.".Baru()","sections.png","Baru", 'Baru')."</td>".
		"<td>".genPanelIcon("javascript:".$this->Prefix.".Edit()","edit_f2.png","Edit", 'Edit')."</td>".
		"<td>".genPanelIcon("javascript:".$this->Prefix.".Hapus()","delete_f2.png","Hapus", 'Hapus')."</td>";
		;
	}
		
	function simpanUpload(){
	 global $HTTP_COOKIE_VARS;
	 global $Main;
	 $cek = '';			
	 $err = '';			
	 $content = '';	
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 
	 
	 	$fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 	$idplh = $_REQUEST[$this->Prefix.'_idplh'];
		$temp1=sqlArray(sqlQuery("select Id from gambar_uploadmenu_aktif where mnu_id = '$idplh' and stat='0'"));
		$temp2=sqlArray(sqlQuery("select Id from gambar_uploadmenu_pasif where mnu_id = '$idplh' and stat='0'"));
		
		$aq = "SELECT * FROM gambar_upload WHERE id_upload = '$idplh' AND stat = '2' and jns_upload='4'";$cek .=$aq;
		$qry = sqlQuery($aq);
		while($del = sqlArray($qry)){
			unlink("Media/shortcut/".$del['nmfile']);
		}
		$hapus = "DELETE FROM gambar_upload WHERE id_upload = '$idplh' AND stat = '2' and jns_upload='4'"; $cek .= ' || '.$hapus;
		$hps = sqlQuery($hapus);
		
		
		$aq1 = "SELECT * FROM gambar_upload WHERE id_upload = '$idplh' AND stat = '2' and jns_upload='5'";$cek .=$aq;
		$qry1 = sqlQuery($aq1);
		while($del2 = sqlArray($qry1)){
			unlink("Media/shortcut/".$del2['nmfile']);
		}
		$hapus1 = "DELETE FROM gambar_upload WHERE id_upload = '$idplh' AND stat = '2' and jns_upload='5'"; $cek .= ' || '.$hapus;
		$hps1 = sqlQuery($hapus1);
		
		$upd = "UPDATE gambar_upload SET stat = '0' , stat2 = '0' , tgl_create = NOW() WHERE jns_upload='4' and id_upload = '$idplh'";$cek .= ' ||'. $upd;
		$qryupd = sqlQuery($upd);
		$upd2 ="UPDATE gambar_upload SET stat = '0' , stat2 = '0' , tgl_create = NOW() WHERE jns_upload='5' and id_upload = '$idplh'";$cek .= ' ||'. $upd;
		$qryupd2 = sqlQuery($upd2);
		$temp1=sqlArray(sqlQuery("select Id from gambar_upload where id_upload = '$idplh' and stat='0' and jns_upload='4'"));
		$temp2=sqlArray(sqlQuery("select Id from gambar_upload where id_upload = '$idplh' and stat='0' and jns_upload='5'"));
	//	$cek.="select Id from gambar_upload where mnu_id = '$idplh' and stat='0'";
		$upd3 = "UPDATE system_shortcut SET file_imagesaktif ='".$temp1['Id']."',file_imagespasif ='".$temp2['Id']."'  WHERE Id_menu = '$idplh'";
		$qryupd3 = sqlQuery($upd3);
	
					
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }	
	
	
	function simpan(){
	  global $HTTP_COOKIE_VARS;
	 global $Main;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	//get data -----------------
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];
	 $id_menu = $_REQUEST['id_menu'];
	 $id_modul = $_REQUEST['id_modul'];
	 $id_system = $_REQUEST['id_system'];
     $nourut= $_REQUEST['nourut'];
     $nm_modul= $_REQUEST['nm_modul'];
	 $kode= $_REQUEST['kode'];
	 $url= $_REQUEST['url'];
	 $title= $_REQUEST['title'];
	 $baris= $_REQUEST['baris'];
	 $kolom= $_REQUEST['kolom'];
	 $tgl_update = $_REQUEST['tgl_update'];
	 $username = $_REQUEST['username'];
	/* $k1 = $_REQUEST['kode_x'];
	 $k2 = $_REQUEST['kode_y'];
	 $k3 = $_REQUEST['kode_z'];*/
	// $tik=.;
	// $kode=$k1.'.'.$k2.'.'.$k3; 
	$tgl_update = explode("-",$tgl_update);
	$tgl_update2 = $tgl_update[2].'-'.$tgl_update[1].'-'.$tgl_update[0];
	 
	
		
	 if( $err=='' && $nourut =='' ) $err= 'No Urut Belum Di Isi !!';
	/* if( $err=='' && $k1 =='' ) $err= 'No Kode Baris Pertama Belum Di Isi !!';
	 if( $err=='' && $k2 =='' ) $err= 'No Kode Baris Kedua Belum Di Isi !!';
	 if( $err=='' && $k3 =='' ) $err= 'No Kode Baris Ketiga Belum Di Isi !!';*/
	 if( $err=='' && $nm_modul =='' ) $err= 'Nama Modul Belum Di Isi !!';
	 if( $err=='' && $title =='' ) $err= 'Title Belum Di Isi !!';
	 if( $err=='' && $baris =='' ) $err= 'Data ROW Belum Di Isi !!';
	 if( $err=='' && $kolom =='' ) $err= 'Data Colom Belum Di Isi !!';
	
	//$ck=sqlArray(sqlQuery("Select kode from system_menu "));
	
	
	 
		if($fmST == 0){
		
			if($err==''){
				
					$aqry = "INSERT into system_shortcut (Id_menu,Id_modul,Id_system,no_urut,title,alamat_url,row,colom,file_imagesaktif,file_imagespasif,tgl_update,uid) values('$id_menu','$id_modul','$id_system','$nourut','$title','$url','$baris','$kolom','','','$tgl_update2','$username')";	$cek .= $aqry;	
					$qry = sqlQuery($aqry);
				}
			}else{
				
			
			 
			 
							
				if($err==''){
				$aqry = "UPDATE system_shortcut SET Id_menu='$id_menu',Id_modul='$id_modul',no_urut='$nourut',title='$title',alamat_url='$url',row='$baris',colom='$kolom',file_imagesaktif='',file_imagespasif='',Id_system='$id_system', title='$title'  where Id_shortcut='".$idplh."'";	$cek .= $aqry;
			
						$qry = sqlQuery($aqry) or die(mysql_error());
				}
			} //end else
					
			return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }	
	
	function set_selector_other2($tipe){
	 global $Main;
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	 return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
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
		
		case 'formUpload':{				
			$fm = $this->setFormUpload();				
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
		
		
		case 'hapus':{
			$get= $this->Hapus();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
		break;
		}
		
		case 'formEdit':{				
			$fm = $this->setFormEdit();				
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];												
		break;
		}
		case 'simpan':{
			$get= $this->simpan();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
		break;
	    }
		
		case 'simpanUpload':{
			$get= $this->simpanUpload();
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
			   
		 default:{
				$other = $this->set_selector_other2($tipe);
				$cek = $other['cek'];
				$err = $other['err'];
				$content=$other['content'];
				$json=$other['json'];
		 break;
		 }
		 
	 }//end switch
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
   }
 
	function Hapus($ids){ //validasi hapus tbl_sppd
		 $err=''; $cek='';
		 $cbid = $_REQUEST[$this->Prefix.'_cb'];
		$this->form_idplh = $cbid[0];
		
		if ($err ==''){
			
		for($i = 0; $i<count($ids); $i++){
		$idplh1 = explode(" ",$ids[$i]);
			
		if($err=='' ){
		
		$aq = "SELECT * FROM gambar_upload WHERE id_upload = '".$ids[$i]."' and jns_upload='2'";$cek .=$aq;
		$qry = sqlQuery($aq);
		while($del = sqlArray($qry)){
			unlink("Media/shortcut/".$del['nmfile']);
		}
		$hapus = "DELETE FROM gambar_upload WHERE id_upload = '".$ids[$i]."' and jns_upload='2'"; $cek .= ' || '.$hapus;
		$hps = sqlQuery($hapus);
		
		
		$aq1 = "SELECT * FROM gambar_upload WHERE id_upload = '".$ids[$i]."' and jns_upload='3'";$cek .=$aq;
		$qry1 = sqlQuery($aq1);
		while($del2 = sqlArray($qry1)){
			unlink("Media/shortcut/".$del2['nmfile']);
		}
		$hapus1 = "DELETE FROM gambar_upload WHERE id_upload = '".$ids[$i]."' and jns_upload='3'"; $cek .= ' || '.$hapus;
		$hps1 = sqlQuery($hapus1);
					
					$qy = "DELETE FROM system_shortcut WHERE Id_shortcut='".$ids[$i]."' ";$cek.=$qy;
					$qry = sqlQuery($qy);
					
			}else{
				break;
			}			
		}
		}
		return array('err'=>$err,'cek'=>$cek);
	}	  
	
	function setPage_OtherScript(){
		$scriptload = 

					"<script>
						$(document).ready(function(){ 
							".$this->Prefix.".loading();
						});
						
					</script>";
					
		return 
			
			"<link href='css/ui-lightness/jquery-ui-1.10.3.custom.css' rel='stylesheet'>".
			"<script type='text/javascript' src='js/skpd.js' language='JavaScript' ></script>".
			"<link rel='stylesheet' href='css/template_css.css' type='text/css'>".
			"<link href='css/ui-lightness/jquery-ui-1.10.3.custom.css' rel='stylesheet'>".
			"<link rel='stylesheet' href='css/upload_style.css' type='text/css'>".
			"<script src='js/jquery.js' type='text/javascript'></script>".			
			"<script src='js/jquery-ui.js' type='text/javascript'></script>".
			"<script src='js/jquery.min.js' type='text/javascript'></script>
			<script type='text/javascript' src='js/jquery.form.js'></script> ".
			"<script src='js/jquery-ui.custom.js'></script>".
			 "<script type='text/javascript' src='js/admin/ManagementShortcut/ManagementShortcut.js' language='JavaScript' ></script>".
			  "<script type='text/javascript' src='js/admin/ManagementStrukturMenu/ManagementStrukturMenu2.js' language='JavaScript' ></script>
			 ".
			// "<script type='text/javascript' src='js/master/ref_aset/refjurnal.js' language='JavaScript' ></script>".
			
			$scriptload;
	}
	
	//form ==================================
	function setFormBaru(){
		$dt=array();
		//$this->form_idplh ='';
		$this->form_fmST = 0;
		$dt['tgl'] = date("Y-m-d"); //set waktu sekarang
		$fm = $this->setForm($dt);
		return	array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}
   
   function setFormUpload(){
		$cek ='';
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 1;				
		//get data 
		$aqry = "SELECT * FROM  system_shortcut WHERE Id_shortcut='".$this->form_idplh."' "; $cek.=$aqry;
		$dt = sqlArray(sqlQuery($aqry));
		
		$file = "SELECT * FROM gambar_upload WHERE jns_upload='4' and id_upload='$this->form_idplh'LIMIT 0,1";$cek=$qry;
	//	$file = "SELECT * FROM gambar_uploadmenu_aktif WHERE mnu_id='$this->form_idplh'LIMIT 0,1";$cek=$qry;
		$aqfile = sqlQuery($file);
		$qryfile = sqlArray($aqfile);
		
		if(sqlNumRow($aqfile) > 0) {
			$dt['isifile'] = sqlNumRow($aqfile);
			$dt['idfile'] = $qryfile['Id'];
			$dt['nmfile'] = $qryfile['nmfile'];
			$dt['nmfile_asli'] = $qryfile['nmfile_asli'];
		}else{
			$dt['isifile'] = 0;
		}
		
		$file2 = "SELECT * FROM gambar_upload WHERE jns_upload='5' and id_upload='$this->form_idplh'LIMIT 0,1";$cek=$qry;
		$aqfile2 = sqlQuery($file2);
		$qryfile2 = sqlArray($aqfile2);
		
		if(sqlNumRow($aqfile2) > 0) {
			$dt['isifile'] = sqlNumRow($aqfile2);
			$dt['idfile'] = $qryfile2['Id'];
			$dt['nmfile'] = $qryfile2['nmfile'];
			$dt['nmfile_asli'] = $qryfile2['nmfile_asli'];
		}else{
			$dt['isifile'] = 0;
		}
		
		$fm = $this->setUpload($dt);
		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}	
   
  	function setFormEdit(){
		
	$cek ='';
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$c1=$kode[0];
		$c=$kode[1];
		$d=$kode[2];
		$e=$kode[3];
		$e1=$kode[4];
		$this->form_fmST = 1;				
		//get data 
		$aqry = "SELECT * FROM  system_shortcut WHERE Id_shortcut='".$this->form_idplh."' "; $cek.=$aqry;
		$dt = sqlArray(sqlQuery($aqry));
		$fm = $this->setFormeditdata($dt);
		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}
		
	function setForm($dt){	
	 global $SensusTmp ,$Main;
	 global $Main;
	 global $HTTP_COOKIE_VARS;
	 $uid = $HTTP_COOKIE_VARS['coID'];	
	 $cek = ''; $err=''; $content=''; 
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';				
	  $this->form_width = 750;
	 $this->form_height = 230;
	 $tgl_update = date('d-m-Y');	
	  if ($this->form_fmST==0) {
		$this->form_caption = 'Management Shortcut - Baru';
	  }else{
		$this->form_caption = 'Management Shortcut - Edit';			
		$Id = $dt['id'];			
	  }
	  
	$id = $_REQUEST['Id_system'];
		
	$queryKF="SELECT max(no_urut)as nourut FROM system_shortcut" ;
	
		$get=sqlArray(sqlQuery($queryKF));
		$no_urut=$get['nourut'] + 1;
	
	$datalevel=1;
	$datatipe=1;
	$datajenis=1;
	$dataposisi=1;
	$dataaktif=1;
	$kdx=$dt['kode'];
	$datasys=sqlArray(sqlQuery("select nm_system from system where Id_system='".$dt['Id_system']."'"));
	$datamod=sqlArray(sqlQuery("select nm_system,nm_modul from system_modul where Id_modul='".$dt['Id_modul']."'"));
	
				$l = substr($kdx, 0,2);
				$m = substr($kdx, 3,2);
				$n = substr($kdx, 6,2);
		
       //items ----------------------
		  $this->form_fields = array(
		  
		  	'no_urut' => array( 
						'label'=>'NO.URUT',
						'labelWidth'=>120, 
						'value'=>"<input type='text' onkeypress='return event.charCode >= 48 && event.charCode <= 57'name='nourut' id='nourut' maxlength='3' value='$no_urut' style='width:30px;maxlength='3' readonly>",
						 ),
						 
					 
			'nm_system' => array( 
								'label'=>'NAMA SYSTEM / MODUL',
								'labelWidth'=>140, 
								'value'=>"
								<input type='hidden' name='id_menu' value='' placeholder='Kode' size='5px' id='id_menu' readonly>
								<input type='hidden' name='id_modul' value='".$dt['Id_modul']."' placeholder='Kode' size='5px' id='id_modul' readonly>
								<input type='hidden' name='id_system' value='".$dt['Id_system']."' placeholder='Kode' size='5px' id='id_system' readonly>
								
						  		<input type='text' name='nm_system' value='".$datasys['nm_system']."' placeholder='Nama System' style='width:245px' id='nm_system' readonly>&nbsp
								 <input type='text' name='nm_modul' value='".$datamod['nm_modul']."' placeholder='Nama Modul' style='width:250px' id='nm_modul' readonly>&nbsp
								<input type='button' value='Cari' onclick ='".$this->Prefix.".Cari()' title='Cari' >" 
									 ),
		  	
			'url' => array( 
						'label'=>'ALAMAT URL',
						'labelWidth'=>100, 
						'value'=>"<input type='text' name='url' id='url' value='".$dt['title']."' placeholder='Alamat URL' style='width:500px;' readonly>",
						 ),	
						 	 
			'title' => array( 
						'label'=>'TITLE',
						'labelWidth'=>100, 
						'value'=>"<input type='text' name='title' id='title' value='".$dt['title']."' placeholder='Title' style='width:500px;'>",
						 ),	
						 
			'row' => array( 
						'label'=>'ROW',
						'labelWidth'=>100, 
						'value'=>"<input type='text' onkeypress='return event.charCode >= 48 && event.charCode <= 57'name='baris' id='baris' maxlength='3' value='$l' style='width:30px;maxlength='3'>",
						 ),				 
			
			'colom' => array( 
						'label'=>'COLOM',
						'labelWidth'=>100, 
						'value'=>"<input type='text' onkeypress='return event.charCode >= 48 && event.charCode <= 57'name='kolom' id='kolom' maxlength='3' value='$l' style='width:30px;maxlength='3'>",
						 ),
			
			/*'scan_foto' => array( 
				'label'=>'UPLOAD FILE IMAGES AKTIF2','labelWidth'=>150, 
				'value'=>"<input type='file' id='myFile' multiple size='50' onchange ='".$this->Prefix.".upload()'>
				
				<p id='demo'></p>",
			 ),*/
		
						 		
			/*'type_link' => array( 
						'label'=>'TIPE LINK',
						'labelWidth'=>100,
						'value'=>cmbArray('typelink',$datatipe,$this->Typelink,'-- PILIH --','style="width:95px;"'),
						 ),	
			
			'jenis' => array( 
						'label'=>'JENIS',
						'labelWidth'=>100,
						'value'=>cmbArray('jenis',$datajenis,$this->Jenis,'-- PILIH --','style="width:95px;"'),
						 ),	
						 
			'posisi' => array( 
						'label'=>'POSISI',
						'labelWidth'=>100,
						'value'=>cmbArray('posisi',$dataposisi,$this->Posisi,'-- PILIH --','style="width:95px;"'),
						 ),				 
						 			 			 		
			'status' => array( 
						'label'=>'STATUS',
						'labelWidth'=>100,
						'value'=>cmbArray('status',$dataaktif,$this->Status,'-- PILIH --','style="width:95px;"'),
						 ),	*/
			
			'tgl_update' =>	array(
								'label'=>'TANGGAL UPDATE',
								'name'=>'dokumensumber',
								'label-width'=>100,
								'value'=>"<input type='text' name='tgl_update' id='tgl_update' class='' value='$tgl_update' style='width:80px;'readonly />  "
										
								,						
								),				 
			'username' => array( 
						'label'=>'USER NAME',
						'labelWidth'=>100, 
						'value'=>"<input type='text' name='username' id='username' value='$uid' style='width:250px;'readonly>",
						 ),	
			);
		//tombol
		$this->form_menubawah =	
			
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
			
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	
	
	function setFormeditdata($dt){	
	 global $SensusTmp ,$Main;
	 global $Main;
	 global $HTTP_COOKIE_VARS;
	 $uid = $HTTP_COOKIE_VARS['coID'];	
	 $cek = ''; $err=''; $content=''; 
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 750;
	 $this->form_height = 250;
	 $tgl_update = date('d-m-Y');	
	  if ($this->form_fmST==0) {
		$this->form_caption = 'Management Shortcut - Baru';
	  }else{
		$this->form_caption = 'Management Shortcut - Edit';			
		$Id = $dt['id'];			
	  }
	  
		$id = $_REQUEST['Id_system'];
		$fmc = $_REQUEST['fmc'];
		$fmd = $_REQUEST['fmd'];
		$fme = $_REQUEST['fme'];
		$fme1 = $_REQUEST['fme1'];
		$gedung = $_REQUEST['gedung'];
					
	
	
	$akt=sqlArray(sqlQuery("select nmfile_asli from gambar_upload where id_upload='".$dt['Id_shortcut']."' and jns_upload='4'"));
	$pas=sqlArray(sqlQuery("select nmfile_asli from gambar_upload where id_upload='".$dt['Id_shortcut']."' and jns_upload='5'"));
	$datalevel=1;
	$datatipe=1;
	$datajenis=1;
	$dataposisi=1;
	$dataaktif=1;
	$kdx=$dt['kode'];
	$datasys=sqlArray(sqlQuery("select nm_system from system where Id_system='".$dt['Id_system']."'"));
	$datamod=sqlArray(sqlQuery("select nm_system,nm_modul from system_modul where Id_modul='".$dt['Id_modul']."'"));
	 $alt_url2=sqlArray(sqlQuery("select alamat_url from system_menu where Id_menu='".$dt['Id_menu']."'"));
				$l = substr($kdx, 0,2);
				$m = substr($kdx, 3,2);
				$n = substr($kdx, 6,2);
		
       //items ----------------------
		  $this->form_fields = array(
		  
		  	'no_urut' => array( 
						'label'=>'NO.URUT',
						'labelWidth'=>100, 
						'value'=>"<input type='text' onkeypress='return event.charCode >= 48 && event.charCode <= 57'name='nourut' id='nourut' maxlength='3' value='".$dt['no_urut']."' style='width:30px;maxlength='3' readonly>",
						 ),
						 
			/*'kode' => array( 
						'label'=>'KODE',
						'labelWidth'=>100, 
						'value'=>"<input type='text' onkeypress='return event.charCode >= 48 && event.charCode <= 57'name='kode_x' id='kode_x' maxlength='2' value='$l' style='width:30px;maxlength='3'>&nbsp
						<input type='text' onkeypress='return event.charCode >= 48 && event.charCode <= 57'name='kode_y' id='kode_y' maxlength='2' value='$m' style='width:30px;maxlength='3'>&nbsp
						<input type='text' onkeypress='return event.charCode >= 48 && event.charCode <= 57'name='kode_z' id='kode_z' maxlength='2' value='$n' style='width:30px;maxlength='3'> * 01.02.03",
						 ),	*/
						 
			/*'nm_modul' => array( 
								'label'=>'NAMA MODUL',
								'labelWidth'=>100, 
								'value'=>"
								<input type='hidden' name='id' value='".$dt['Id_modul']."' placeholder='Kode' size='5px' id='id' readonly>
								<input type='hidden' name='id_system' value='".$dt['Id_system']."' placeholder='Kode' size='5px' id='id_system' readonly>
								<input type='text' name='nm_modul' value='".$datamod['nm_modul']."' placeholder='Nama Modul' style='width:250px' id='nm_modul' readonly>&nbsp
								<input type='button' value='Cari' onclick ='".$this->Prefix.".Cari()' title='Cari' >" 
									 ),*/
									 
			'nm_system' => array( 
								'label'=>'NAMA SYSTEM / MODUL',
								'labelWidth'=>140, 
								'value'=>"
								<input type='hidden' name='id_menu' value='".$dt['Id_menu']."' placeholder='Kode' size='5px' id='id_menu' readonly>
								<input type='hidden' name='id_modul' value='".$dt['Id_modul']."' placeholder='Kode' size='5px' id='id_modul' readonly>
								<input type='hidden' name='id_system' value='".$dt['Id_system']."' placeholder='Kode' size='5px' id='id_system' readonly>
								
								
						  		<input type='text' name='nm_system' value='".$datasys['nm_system']."' placeholder='Nama System' style='width:245px' id='nm_system' readonly>&nbsp
								 <input type='text' name='nm_modul' value='".$datamod['nm_modul']."' placeholder='Nama Modul' style='width:250px' id='nm_modul' readonly>&nbsp
								<input type='button' value='Cari' onclick ='".$this->Prefix.".Cari()' title='Cari' >" 
									 ),
		  	
			'url' => array( 
						'label'=>'ALAMAT URL',
						'labelWidth'=>100, 
						'value'=>"<input type='text' name='url' id='url' value='".$alt_url2['alamat_url']."' placeholder='Alamat URL' style='width:500px;' readonly>",
						 ),	
						 	 
			'title' => array( 
						'label'=>'TITLE',
						'labelWidth'=>100, 
						'value'=>"<input type='text' name='title' id='title' value='".$dt['title']."' placeholder='Title' style='width:500px;'>",
						 ),							 
				 
			'title' => array( 
						'label'=>'TITLE',
						'labelWidth'=>100, 
						'value'=>"<input type='text' name='title' id='title' value='".$dt['title']."' style='width:250px;'>",
						 ),	
						 
			'row' => array( 
						'label'=>'ROW',
						'labelWidth'=>100, 
						'value'=>"<input type='text' onkeypress='return event.charCode >= 48 && event.charCode <= 57'name='baris' id='baris' maxlength='3' value='".$dt['row']."' style='width:30px;maxlength='3'>",
						 ),	
						 			 
			'colom' => array( 
						'label'=>'COLOM',
						'labelWidth'=>100, 
						'value'=>"<input type='text' onkeypress='return event.charCode >= 48 && event.charCode <= 57'name='kolom' id='kolom' maxlength='3' value='".$dt['colom']."' style='width:30px;maxlength='3'>",
						 ),		
									 
			'AKTIF' => array( 
				'label'=>'FILE IMAGES AKTIF','labelWidth'=>120, 
				'value'=>$akt['nmfile_asli'],
			 ),
			
			'PASIF' => array( 
				'label'=>'FILE IMAGES PASIF','labelWidth'=>120, 
				'value'=>$pas['nmfile_asli'],
			 ),
						
			'tgl_update' =>	array(
								'label'=>'TANGGAL UPDATE',
								'name'=>'dokumensumber',
								'label-width'=>100,
								'value'=>"<input type='text' name='tgl_update' id='tgl_update' class='' value='$tgl_update' style='width:80px;'readonly />  "
										
								,						
								),				 
			'username' => array( 
						'label'=>'USER NAME',
						'labelWidth'=>100, 
						'value'=>"<input type='text' name='username' id='username' value='$uid' style='width:250px;'readonly>",
						 ),	
			);
		//tombol
		$this->form_menubawah =	
			
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
			
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	
	function setUpload($dt){	
	 global $SensusTmp;
	 global $HTTP_COOKIE_VARS;
	 global $Main;
	 
	 $cek = ''; $err=''; $content=''; 	
	// $uid = $HTTP_COOKIE_VARS['coID'];			
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';				
	  $this->form_width = 770;
	// $this->form_height = 350;
	 $this->form_height = 230;
	  if ($this->form_fmST==0) {
		
		//$nip	 = '';
	  }else{
		$this->form_caption = 'Shortcut - Upload';			
	//	$Id = $dt['id'];		
	  }
	    //ambil data trefditeruskan
	  	
		$tgl_expired=TglInd($dt['expired_date']);
		$tgl_update=TglInd($dt['tgl_update']);
		
	 if($dt['kel_user_system']==1){
	 	$kel='ADMIN';
	 }elseif($dt['kel_user_system']==2){
	 	$kel='USER';
	 }elseif($dt['kel_user_system']==3){
	 	$kel='CUSTOMER';
	 }elseif($dt['kel_user_system']==4){
	 	$kel='PUBLIK';
	 }
	 
	 if($dt['status_menu']==1){
	 	$status='AKTIF';
	 }elseif($dt['status_menu']==2){
	 	$status='TIDAK AKTIF';
	 }
	
	 if($dt['type_link']==1){
	 	$type_link='TEKS';
	 }elseif($dt['type_link']==2){
	 	$type_link='BUTTON';
	 }
	 
	  if($dt['jenis']==1){
	 	$jenis='A';
	 }elseif($dt['jenis']==2){
	 	$jenis='B';
	 }elseif($dt['jenis']==3){
	 	$jenis='C';
	 }elseif($dt['jenis']==4){
	 	$jenis='D';
	 }
	 
	  if($dt['posisi']==1){
	 	$posisi='HEADER';
	 }elseif($dt['posisi']==2){
	 	$posisi='FOOTER';
	 }
	 
	$datasys=sqlArray(sqlQuery("select nm_system from system where Id_system='".$dt['Id_system']."'"));
	$datamod=sqlArray(sqlQuery("select nm_system,nm_modul from system_modul where Id_modul='".$dt['Id_modul']."'"));$cek.="select nm_system from system where Id_system='".$dt['Id_system']."'";
	//$datamne=sqlArray(sqlQuery("select nm_system,nm_modul from system_modul where Id_modul='".$dt['Id_menu']."'"));
	
	
	 $datakt=sqlArray(sqlQuery("select nmfile_asli from gambar_upload where jns_upload='2' and id_upload='".$dt['file_imagesaktif']."'"));
	 
	 $cek.="select nmfile_asli from gambar_uploadmenu_pasif where id_upload='".$dt['file_imagespasif']."'";
	 $datpsf=sqlArray(sqlQuery("select nmfile_asli from gambar_upload where jns_upload='3' and id_upload='".$dt['file_imagespasif']."'"));
	 //items ----------------------
	  $this->form_fields = array(
	  		
			'no_urut' => array( 
						'label'=>'NO.URUT',
						'labelWidth'=>170, 
						'value'=>$dt['no_urut'],
						 ),			 
			
						 
			/*'level' => array( 
						'label'=>'LEVEL',
						'labelWidth'=>100, 
						'value'=>$dt['level'],
						 ),		*/			 		 		
			/*'SYSTEM/MODUL' => array( 
						'label'=>'NAMA MODUL',
						'labelWidth'=>100, 
						'value'=>$datamod['nm_modul'],
						 ),	*/
			'SYSTEM' => array( 
						'label'=>'NAMA SYSTEM',
						'labelWidth'=>100, 
						'value'=>$datasys['nm_system'],
						 ),	
			'MODUL' => array( 
						'label'=>'NAMA MODUL',
						'labelWidth'=>100, 
						'value'=>$datamod['nm_modul'],
						 ),		
			'TITLE' => array( 
						'label'=>'TITLE',
						'labelWidth'=>100, 
						'value'=>$dt['title'],
						 ),
						 
						 
			'row' => array( 
						'label'=>'ROW',
						'labelWidth'=>100, 
						'value'=>$dt['row'],
						 ),	
						 
			'kolom' => array( 
						'label'=>'COLOM',
						'labelWidth'=>100, 
						'value'=>$dt['colom'],
						 ),					 			
						 			 
			'AKTIF' => array( 
				'label'=>'FILE IMAGES AKTIF','labelWidth'=>100, 
				'value'=>						
					"<form></form>".					
					"<form action='pages.php?Pg=processuploadfileshortcut1' method='post' enctype='multipart/form-data' id='UploadForm'>".
					"<input type='hidden' id='cut_id' name='cut_id' value='".$dt['Id_shortcut']."' >".
					"<input id='ImageFile' name='ImageFile' type='file'  style='visibility:hidden;width:0px;height:0px' onchange=\"".$this->Prefix.".btfile_onchange()\" />".
					"<input type='button' onclick=\"$('#ImageFile').click();\" value='Pilih File'>
					 <input type='hidden' id='isifile' name='isifile' value='".$dt['isifile']."' >
					 <input type='hidden' id='ref_idupload' name='ref_idupload' value='".$dt['id']."' >
					 <input type='hidden' id='idfile' name='idfile' value='".$dt['idfile']."' >
					 <input type='hidden' id='jns_upload' name='jns_upload' value='4' >
					 <input type='hidden' id='nmfile' name='nmfile' value='".$dt['nmfile']."' >".
					"<input type='hidden' id='nmfile_asli' name='nmfile_asli' value='".$dt['nmfile_asli']."' >".
					"<span id='content_newfile' style='margin-left:6px;'>".$datakt['nmfile_asli']."</span>".
					"</form>".
					'', 
			 ),
			 
			 'Pasif' => array( 
				'label'=>'FILE IMAGES PASIF','labelWidth'=>100, 
				'value'=>						
					"<form></form>".					
					"<form action='pages.php?Pg=processuploadfileshortcut2' method='post' enctype='multipart/form-data' id='UploadForm2'>".
					"<input type='hidden' id='cut_id' name='cut_id' value='".$dt['Id_shortcut']."' >".
					"<input id='ImageFile2' name='ImageFile2' type='file'  style='visibility:hidden;width:0px;height:0px' onchange=\"".$this->Prefix.".btfile2_onchange()\" />".
					"<input type='button' onclick=\"$('#ImageFile2').click();\" value='Pilih File'>
					 <input type='hidden' id='isifile' name='isifile' value='".$dt['isifile']."' >
					 <input type='hidden' id='ref_idupload1' name='ref_idupload1' value='".$dt['id']."' >
					 <input type='hidden' id='idfile' name='idfile' value='".$dt['idfile']."' >
					<input type='hidden' id='jns_upload' name='jns_upload' value='5' >
					 <input type='hidden' id='nmfile' name='nmfile' value='".$dt['nmfile']."' >".
					"<input type='hidden' id='nmfile_asli' name='nmfile_asli' value='".$dt['nmfile_asli']."' >".
					"<span id='content_newfile2' style='margin-left:6px;'>".$datpsf['nmfile_asli']."</span>".
					"</form>".
					'', 
			 ),
			 
			'progress' => array(
				'label'=>'','labelWidth'=>100, 'pemisah'=>' ',
				'value'=>				
					"<div id='progressbox'><div id='progressbar'></div >
					<div id='statustxt'>0%</div >
					<div id='output'></div>	"
			),
			
			/*'import' => array( 
						'label'=>'',
						'value'=>"<div id='import' style='height:5px'></div>", 
						
						'type'=>'merge'
					 ),*/
			
			/*'LINK' => array( 
						'label'=>'TIPE LINK',
						'labelWidth'=>100, 
						'value'=>$type_link,
						 ),		
			
			'JNS' => array( 
						'label'=>'JENIS',
						'labelWidth'=>100, 
						'value'=>$jenis,
						 ),		
			
			'POSISI' => array( 
						'label'=>'POSISI',
						'labelWidth'=>100, 
						'value'=>$posisi,
						 ),		
			
			'status' => array( 
						'label'=>'STATUS',
						'labelWidth'=>100,
						'value'=>$status,
						 ),
						 							 
			
			'tgl_update' =>	array(
							'label'=>'TANGGAL UPDATE',
							'name'=>'tgl_update',
							'label-width'=>170,
							'value'=>$tgl_update,						
							),				 
								 			 
			'username' => array( 
						'label'=>'USER NAME',
						'labelWidth'=>100, 
						'value'=>$dt['uid'],
						 ),	*/
			);
						
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SimpanUpload()' title='Simpan' >".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Batal()' >";				
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function setPage_HeaderOther(){
	return "";
		
	}
			
	//daftar =================================
	function setKolomHeader($Mode=1, $Checkbox=''){
	$NomorColSpan = $Mode==1? 2: 1;
	 $headerTable =
	  "<thead>
	   <tr>
  	   <th class='th01' width='5' >No.</th>
  	   $Checkbox		
	   <th class='th01' width='200' align='center'>No Urut</th>
	   
	   <th class='th01' width='450' align='center'>System</th>
	   <th class='th01' width='450' align='center'>Modul</th>
	   <th class='th01' width='450' align='center'>Title</th>
	   <th class='th01' width='300' align='center'>Alamat URL</th>
	   <th class='th01' width='300' align='center'>ROW</th>
	   <th class='th01' width='450' align='center'>COLOM</th>
	   <th class='th01' width='450' align='center'>File Images Aktif</th>
	   <th class='th01' width='450' align='center'>File Images Pasif</th>
	   <th class='th01' width='450' align='center'>Tanggal Update</th>
	   <th class='th01' width='450' align='center'>User Name</th>
	    </tr>
	   </thead>";
	 
		return $headerTable;
	}	
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	 if($isi['status_menu']==1){
	 	$status='AKTIF';
	 }elseif($isi['status_menu']==2){
	 	$status='TIDAK AKTIF';
	 }
	 
	 if($isi['type_link']==1){
	 	$typelink='Text';
	 }elseif($isi['type_link']==2){
	 	$typelink='Buttom';
	 }
	 
	 if($isi['jenis']==1){
	 	$jenis='A';
	 }elseif($isi['jenis']==2){
	 	$jenis='B';
	 }elseif($isi['jenis']==3){
	 	$jenis='C';
	 }elseif($isi['jenis']==4){
	 	$jenis='D';
	 }
	 
	  if($isi['posisi']==1){
	 	$posisi='Header';
	 }elseif($isi['posisi']==2){
	 	$posisi='Footer';
	 }
	 
	 $img=sqlArray(sqlQuery("SELECT `gambar_upload`.`jns_upload`,`gambar_upload`.`nmfile_asli`, `gambar_upload`.`nmfile`, `gambar_upload`.`stat` FROM `system_shortcut` RIGHT JOIN `gambar_upload` ON `system_shortcut`.`Id_shortcut` = `gambar_upload`.`id_upload` WHERE `gambar_upload`.`stat` = 0 and gambar_upload.jns_upload='4' and Id_shortcut='".$isi['Id_shortcut']."'"));
	
	 if($img != ''){
	 	$file = "<a download='".$img['nmfile_asli']."' href='Media/shortcut/".$img['nmfile']."' title='".$img['nmfile_asli']."'><img width='23px' height='23px' src='images/administrator/images/download_f2.png' /> </a>";
	 }else{
	 	$file='';
	 }
	 
	  $img2=sqlArray(sqlQuery("SELECT `gambar_upload`.`jns_upload`,`gambar_upload`.`nmfile_asli`, `gambar_upload`.`nmfile`, `gambar_upload`.`stat` FROM `system_shortcut` RIGHT JOIN `gambar_upload` ON `system_shortcut`.`Id_shortcut` = `gambar_upload`.`id_upload` WHERE `gambar_upload`.`stat` = 0 and `gambar_upload`.`jns_upload` ='5' and Id_shortcut='".$isi['Id_shortcut']."'"));
	
	 if($img2 != ''){
	 	$file2 = "<a download='".$img2['nmfile_asli']."' href='Media/shortcut/".$img2['nmfile']."' title='".$img2['nmfile_asli']."'><img width='23px' height='23px' src='images/administrator/images/download_f2.png' /> </a>";
	 }else{
	 	$file2='';
	 }
	 
	 $datsys=sqlArray(sqlQuery("select nm_system from system where Id_system='".$isi['Id_system']."'"));
	 $datmenu=sqlArray(sqlQuery("select nm_modul from system_modul where Id_modul='".$isi['Id_modul']."'"));
	 $alt_url=sqlArray(sqlQuery("select alamat_url from system_menu where Id_menu='".$isi['Id_menu']."'"));
	
	 $Koloms = array();
	 $Koloms[] = array('align="center"', $no.'.' );
	  if ($Mode == 1) $Koloms[] = array(" align='center' ", $TampilCheckBox);
	 $Koloms[] = array('align="right"',$isi['no_urut']);
	 
	 $Koloms[] = array('align="left"',$datsys['nm_system']);
	 $Koloms[] = array('align="left"',$datmenu['nm_modul']);
	 $Koloms[] = array('align="left"',$isi['title']);
	 $Koloms[] = array('align="left"',$alt_url['alamat_url']);
	 $Koloms[] = array('align="right"',$isi['row']);
	 $Koloms[] = array('align="right"',$isi['colom']);
	 $Koloms[] = array('align="center" width="60px"',$file);
	 $Koloms[] = array('align="center" width="60px"',$file2);
	 $Koloms[] = array('align="left"',TglInd($isi['tgl_update']));
	 $Koloms[] = array('align="left"',$isi['uid']);
	  
	 return $Koloms;
	}
	
	function genDaftarInitial(){
		global $HTTP_COOKIE_VARS;
		$TampilOpt = $this->genDaftarOpsi();
		
		if($HTTP_COOKIE_VARS['coSKPD']=='00'){
			$skpd=$HTTP_COOKIE_VARS['cofmSKPD'];
			$unit=$HTTP_COOKIE_VARS['cofmUNIT'];
			$subunit=$HTTP_COOKIE_VARS['cofmSUBUNIT'];
		}
		else{
			$skpd=$HTTP_COOKIE_VARS['coSKPD'];
			$unit=$HTTP_COOKIE_VARS['coUNIT'];
			$subunit=$HTTP_COOKIE_VARS['coSUBUNIT'];
		}
		
		return		
			//$NavAtas.	
			"<div id='{$this->Prefix}_cont_title' style='position:relative'></div>". 
			"<div id='{$this->Prefix}_cont_skpd' style='position:relative'></div>".
			"<div id='{$this->Prefix}_cont_opsi' style='position:relative'>". 
			//$vOpsi['TampilOpt'].
			"<input type='hidden' id='thn' name='thn' value='".date('Y')."'>".
			"<input type='hidden' id='bln' name='bln' value='".date('m')."'>".
			"<input type='hidden' id='skpd_penerimaanfmBidang' name='skpd_penerimaanfmBidang' value='".$skpd."'>".
			"<input type='hidden' id='skpd_penerimaanfmBagian' name='skpd_penerimaanfmBagian' value='".$unit."'>".
			"<input type='hidden' id='skpd_penerimaanfmSubBagian' name='skpd_penerimaanfmSubBagian' value='".$subunit."'>".
			"</div>".					
			"<div id='{$this->Prefix}_cont_daftar' style='position:relative' >".	
				//$this->genDaftar($Opsi['Kondisi'],$Opsi['Order'], $Opsi['Limit'], $Opsi['NoAwal']).									
			"</div>".
			"<div id='{$this->Prefix}_cont_hal' style='position:relative'>".				
				//"<input type='hidden' id='".$this->Prefix."_hal' name='".$this->Prefix."_hal' value='1'>".
			"</div>";
	}
	
	function genDaftarOpsi(){
	 global $Ref, $Main;
	 
	 $arr = array(
			//array('selectAll','Semua'),	
			array('selectBarang','Barang'),		
			);
		
	 //data order ------------------------------
	 $arrOrder = array(
			     	array('1','Barang'),
					);
	 
	$fmPILCARI = $_REQUEST['fmPILCARI'];	
	$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];		
	$fmBidang = cekPOST('fmBidang'); 
	$fmSKPD = cekPOST('fmSKPD'); 
	//query Bidang
	$queryBidang = "SELECT c,nm_skpd FROM ref_skpd WHERE c!='00' AND d='00' AND e='00' AND e1='000'";
	//query SKPD
	$querySKPD = "SELECT d,nm_skpd FROM ref_skpd WHERE c='$fmBidang' AND d!='00' AND e='00' AND e1='000'";
	//query program
	 //combo box 
	 $BIDANG=cmbQuery('fmBidang',$fmBidang,$queryBidang,'onChange=\''.$this->Prefix.'.fmSKPD()\'','-- PILIH BIDANG --');	 
	 $SKPD=cmbQuery('fmSKPD',$fmSKPD,$querySKPD,'','-- PILIH SKPD --');	
	
	
		return array('TampilOpt'=>$TampilOpt);
	}				
	
	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID']; 
		//kondisi -----------------------------------
				
		$arrKondisi = array();		
		
		//$fmPILCARI = $_REQUEST['fmPILCARI'];	
		//$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];
		$fmBidang = $_REQUEST['fmBidang']; 
		$fmSKPD = $_REQUEST['fmSKPD']; 
		if(!($fmBidang=='' || $fmBidang=='00') ) $arrKondisi[] = "c='$fmBidang'";
		if(!($fmSKPD=='' || $fmSKPD=='00') ) $arrKondisi[] = "d='$fmSKPD'";		
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
		/*switch($fmORDER1){
			case '1': $arrOrders[] = " nama $Asc1 " ;break;
		}*/	
		$arrOrders[] = " no_urut asc ";
		$Order= join(',',$arrOrders);	
		$OrderDefault = '';// Order By no_terima desc ';
		$Order =  $Order ==''? $OrderDefault : ' Order By '.$Order;
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
	
	function batal(){
	 global $HTTP_COOKIE_VARS;
	 global $Main;
	 $uid = $HTTP_COOKIE_VARS['coID'];
		
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	//get data -----------------
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];
	  
	 	$aq = "SELECT * FROM gambar_upload WHERE id_upload = '$idplh' AND stat2='1' and jns_upload='4'";$cek .=$aq;
		$qry = sqlQuery($aq);
		while($del = sqlArray($qry)){
			unlink("Media/shortcut/".$del['nmfile']);
		}
		$hapus = "DELETE FROM gambar_upload WHERE id_upload = '$idplh' AND stat2='1' and jns_upload='4'"; $cek .= ' || '.$hapus;
		$hps = sqlQuery($hapus);
		
		$upd ="UPDATE gambar_upload SET stat = '0' WHERE id_upload = '$idplh' AND stat2 = '0' and jns_upload='4'";$cek .= ' ||'. $upd;
		$qryupd = sqlQuery($upd);
		
		//------------------pasif----------------------------------
		$aq ="SELECT * FROM gambar_upload WHERE id_upload = '$idplh' AND stat2='1' and jns_upload='5'";$cek .=$aq;
		$qry = sqlQuery($aq);
		while($del = sqlArray($qry)){
			unlink("Media/shortcut/".$del['nmfile']);
		}
		$hapus = "DELETE FROM gambar_upload WHERE id_upload = '$idplh' AND stat2='1' and jns_upload='5'"; $cek .= ' || '.$hapus;
		$hps = sqlQuery($hapus);
		
		$upd2 = "UPDATE gambar_upload SET stat = '0' WHERE id_upload = '$idplh' AND stat2 = '0' and jns_upload='5'";$cek .= ' ||'. $upd2;
		$qryupd = sqlQuery($upd2);
	
					
	return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    
	}
	
}
$ManagementShortcut = new ManagementShortcutObj();
?>