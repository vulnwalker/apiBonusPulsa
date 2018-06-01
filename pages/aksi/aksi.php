<?php
session_start();

class aksiObj  extends DaftarObj2{
	var $Prefix = 'aksi';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'aksi'; //bonus
	var $TblName_Hapus = 'aksi';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('id_modul');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);
	var $checkbox_rowspan = 1;
	var $PageTitle = 'REFERENSI MODUL';
	var $PageIcon = 'images/masterData_01.gif';
	var $pagePerHal ='';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='aksi.xls';
	var $namaModulCetak='REFERENSI MODUL';
	var $Cetak_Judul = 'REFERENSI MODUL';
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'aksiForm';
	var $noModul=14;
	var $TampilFilterColapse = 0; //0

	function setTitle(){
		return 'REFERENSI MODUL';
	}

	function setMenuEdit(){
		return
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Baru()","sections.png","Baru", 'Baru')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Edit()","edit_f2.png","Edit", 'Edit')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Hapus()","delete_f2.png","Hapus", 'Hapus')."</td>";
	}

	function simpan(){
	 global $HTTP_COOKIE_VARS;
	 global $Main;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];

	 foreach ($_REQUEST as $key => $value) {
		  $$key = $value;
	 }


	 if( $err=='' && $namaModul =='' ) $err= 'Nama Dokumen Sumber Belum Di Isi !!';

			if($fmST == 0){
				if($err==''){
					$aqry = "INSERT into aksi (nama_modul,status) values('$namaModul','$status')";	$cek .= $aqry;
					$qry = mysql_query($aqry);
				}
			}else{
				if($err==''){
				$aqry = "UPDATE aksi set nama_modul='$namaModul', status = '$status' WHERE id_modul='".$idplh."'";	$cek .= $aqry;
						$qry = mysql_query($aqry) or die(mysql_error());
					}
			}

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


			case 'removeOrder':{
				foreach ($_REQUEST as $key => $value) {
					$$key = $value;
				}
				mysql_query("delete from order_detail where id_order = '$id'");
				mysql_query("delete from order_produk where id_order = '$id'");
			break;
		    }

			case 'addStok':{
				foreach ($_REQUEST as $key => $value) {
					$$key = $value;
				}

					mysql_query("update produk set stok = stok + $jumlah where id = '$id'");
					$cek = "update produk set stok = stok + $jumlah where id = '$id'";
						break;
		    }

			case 'deleteProduk':{
				foreach ($_REQUEST as $key => $value) {
					$$key = $value;
				}
				mysql_query("delete from produk where id = '$id'");
			break;
		    }
			case 'addProduk':{
					foreach ($_REQUEST as $key => $value) {
					  $$key = $value;
				  }


					$tempatBase = preg_replace('#^data:image/\w+;base64,#i', '',$tempatBase);
					$data = array(
												'nama_produk' => $nama,
												'jenis' => $jenis,
												'id_kategori' => $kategori,
												'harga' => $harga,
												'stok' => $stok,
												'deskripsi' => $deskripsi,
												'foto' => $tempatBase,
												'tgl_add' => date('Y-m-d')
					);
					mysql_query(VulnWalkerInsert("produk",$data));


					$cek = VulnWalkerInsert("produk",$data);


					$content = array('foto' => $foto);

			break;
		    }


				case 'editProduk':{
						foreach ($_REQUEST as $key => $value) {
						  $$key = $value;
					  }
						$tempatBase = preg_replace('#^data:image/\w+;base64,#i', '',$tempatBase);
						if(empty($tempatBase)){
							$data = array(
														'nama_produk' => $nama,
														'jenis' => $jenis,
														'id_kategori' => $kategori,
														'harga' => $harga,
														'deskripsi' => $deskripsi,
							);
						}else{
							$data = array(
														'nama_produk' => $nama,
														'jenis' => $jenis,
														'id_kategori' => $kategori,
														'harga' => $harga,
														'deskripsi' => $deskripsi,
														'foto' => $tempatBase,
							);
						}


						mysql_query(VulnWalkerUpdate("produk",$data,"id= '$id'"));


						$cek  =VulnWalkerUpdate("produk",$data,"id= '$id'");


						$content = array('foto' => $foto);

				break;
			    }

			case 'updateProfile':{
					foreach ($_REQUEST as $key => $value) {
					  $$key = $value;
				  }
					$data = array(
													'nama_lengkap' => $namaLengkap,
													'email' => $email,
													'alamat' => $alamat,
													'tlp' => $telepon,
					);
					mysql_query(VulnWalkerUpdate("user",$data,"username = '$username'"));

			break;
		    }


			case 'provinsiChanged':{
				foreach ($_REQUEST as $key => $value) {
					  $$key = $value;
				 }

				 $queryKota = "select id_kabkot, nama_kabkot  from kabkot where id_prov = '$idProvinisi' ";
		     $cmbKota = cmbQuery('cmbKota','',$queryKota,'onchange=aksi.kotaChanged(); required','-- KOTA --');

				 $queryKecamatan = "select id_kabkot, nama_kabkot  from kec where id_prov = '$idProvinisi' and id_kabkot = '$idKota' ";
				 $cmbKecamatan = cmbQuery('cmbKecamatan','',$queryKecamatan,' required','-- KECAMATAN --');
				 $content = array('kota' => $cmbKota,'kecamatan' => $cmbKecamatan);
				 $cek = $queryKota;

			break;
		    }

				case 'kotaChanged':{
					foreach ($_REQUEST as $key => $value) {
						  $$key = $value;
					 }

					 $queryKecamatan = "select id_kec, nama_kec  from kec where id_prov = '$idProvinisi' and id_kabkot = '$idKota' ";
			     $cmbKecamatan = cmbQuery('cmbKecamatan','',$queryKecamatan,' required','-- KECAMATAN --');
					 $content = array('kecamatan' => $cmbKecamatan);
					 $cek = $queryKota;

				break;
			    }


			case 'addToCart':{
				foreach ($_REQUEST as $key => $value) {
					  $$key = $value;
				 }



					$produk = mysql_fetch_array(mysql_query("select * from produk where id = '$id'"));

					$cekJumlahCart = mysql_num_rows(mysql_query("select * from order_session where id_produk = '$id' and session_id = '".session_id()."'"));
					if($cekJumlahCart < 1){
							$data = array(
														'id_produk' => $id,
														'session_id' => session_id(),
														'jumlah' => '1',
														'tgl' => date('Y-m-d')
							);
						  $query = VulnWalkerInsert('order_session',$data);
							$cek = $query;
							mysql_query($query);

							$session_id = session_id();
							$sql = mysql_fetch_array(mysql_query("SELECT SUM(jumlah) as item FROM order_session where session_id = '$session_id' "));
							$jumlahBeli = $sql['item'];
					}else{
							if($cekJumlahCart['jumlah'] > $produk['stok']) {
									$err = ' Maaf Stok hanya tersedia '.$produk['stok'];

							}else {
									mysql_query("UPDATE order_session set jumlah = jumlah+1 WHERE id_produk='$id' AND session_id ='".session_id()."' ");
									$session_id = session_id();
									$sql = mysql_fetch_array(mysql_query("SELECT SUM(jumlah) as item FROM order_session where session_id = '$session_id' "));
									$jumlahBeli = $sql['item'];
							}


					}
					$content = array('jumlahBeli' => $jumlahBeli);
				  // $sql = query("SELECT * From produk where id='$id'");
	    		// $produk=fetch($sql);
					//
	    		// $query = query("SELECT * From order_session WHERE id_produk='$id' AND session_id ='".session_id()."' ");
	    		// $cek=fetch($query);
					//
	    		// if (numrows($query) < 1) {
					//  		$save=query("INSERT into  order_session values('','$id','".session_id()."','1','$tglnow')");
	 		    //   if ($save){
	 		    //    	echo"$cart";
					//
	 		    //   } else {
	 		    //     echo"$index";
	 		    //   }
	    		// } else {
	    		// 	if ($cek['jumlah'] > $produk['stok']) {
	    		// 			$_SESSION['tcukup'] = ' Maaf Stok hanya tersedia '.$produk['stok'].'';
	    		// 		echo"$cart";
	    		// 	}
					//
	    		// 	else {
	    		// 		$update = query("UPDATE order_session set jumlah = jumlah+1 WHERE id_produk='$id' AND session_id ='".session_id()."' ");
	    		// 		if ($update){
	 			  //      	echo"$cart";
					//
	 			  //     } else {
	 			  //       echo"$index";
	 			  //     }
	    		// 	}
	    		// }



			break;
		    }



	    case 'register':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			 }
			 if(empty($nama)){
				 $err = "Silahkan isi nama lengkap";
			 }elseif(empty($username)){
				 $err = "Silahkan isi username";
			 }elseif(empty($password)){
				 $err ="Silakan isi password";
			 }elseif(empty($alamat)) {
			 	 $err = "Silahkan isi alamat";
			 }elseif(empty($email)) {
			 	 $err = "Silahkan isi email";
			 }elseif(empty($tlp)) {
			 	 $err = "Silahkan isi nomor telpon";
			 }
			  else{
						if(mysql_num_rows(mysql_query("select * from user where username ='$username'")) != 0){
						     $err = "Username sudah ada";
					 }

					if($err == ''){
							$data = array(	'nama_lengkap' => $nama,
								 							'username' => $username,
								 							'password' => md5($password),
								 							'email' => $email,
								 							'alamat' => $alamat,
								 							'tlp' => $tlp,
															'foto' => "",
															'level' => "member",
															'bergabung_tgl' => date('Y-m-d'),
															'ip' => $_SERVER['REMOTE_HOST'],
							);
							$query = VulnWalkerInsert('user',$data);
							mysql_query($query);


							$dataLogin = array(
														'ip' => $_SERVER['REMOTE_ADDR']
							);

							$_SESSION[user]=$username;
							$_SESSION[level]='member';
							$qry = VulnWalkerUpdate('user', $dataLogin, "username = '$username'");
							mysql_query($qry);


							$cek = $qry;
					}


			 }


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


   function setPage_OtherScript(){
		$scriptload =
					"<script>
						$(document).ready(function(){
							".$this->Prefix.".loading();
						});
					</script>";
		return
			"<script type='text/javascript' src='js/master/aksi/".$this->Prefix.".js' language='JavaScript' ></script>".
			$scriptload;
	}

	function setFormBaru(){
		$dt=array();
		//$this->form_idplh ='';
		$this->form_fmST = 0;
		$dt['tgl'] = date("Y-m-d");
		$fm = $this->setForm($dt);
		return	array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}

  	function setFormEdit(){
		$cek ='';
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 1;
		if($err == ''){
			$aqry = "SELECT * FROM  aksi WHERE id_modul='".$this->form_idplh."' "; $cek.=$aqry;
			$dt = mysql_fetch_array(mysql_query($aqry));
			$fm = $this->setForm($dt);
		}

		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$err.$fm['err'], 'content'=>$fm['content']);
	}

	function setForm($dt){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 500;
	 $this->form_height = 100;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'Baru';
		$nip	 = '';
	  }else{
		$this->form_caption = 'Edit';
		$namaModul = $dt['nama_modul'];
		$status	 = $dt['status'];
	  }

	  $arrayStatus = array(
	  						array('AKTIF','AKTIF'),
							array('TIDAK AKTIF','TIDAK AKTIF')

							);
	$Cmbstatus = cmbArray('status',$status,$arrayStatus,'-- STATUS --');
	 //items ----------------------
	  $this->form_fields = array(
			'namaModul' => array(
						'label'=>'NAMA MODUL',
						'labelWidth'=>100,
						'value'=>$namaModul,
						'type'=>'text',
						'param'=>"style='width:300px;' placeholder = 'NAMA MODUL'"
						 ),
			'status' => array(
						'label'=>'STATUS',
						'labelWidth'=>100,
						'value'=>$Cmbstatus,
						 ),

			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan()' title='Simpan' > &nbsp ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}



	//daftar =================================
	function setKolomHeader($Mode=1, $Checkbox=''){
	 $NomorColSpan = $Mode==1? 2: 1;
	 $headerTable =
	  "<thead>
	   <tr>
  	   <th class='th01' width='5' >No.</th>
  	   $Checkbox
	   <th class='th01' width='900'>NAMA MODUL</th>
	   <th class='th01' width='200'>STATUS</th>
	   </tr>
	   </thead>";

		return $headerTable;
	}

	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;

	 $Koloms = array();
	 $Koloms[] = array('align="center"', $no.'.' );
	  if ($Mode == 1) $Koloms[] = array(" align='center'  ", $TampilCheckBox);
	 $Koloms[] = array('align="left"',$isi['nama_modul']);
	 $Koloms[] = array('align="left"',$isi['status']);
	 return $Koloms;
	}

	function genDaftarOpsi(){
	 global $Ref, $Main;


	 //data order ------------------------------

	  $arr = array(
						array('nama_modul','NAMA MODUL'),
						array('status','STATUS')
			);

	 $arrOrder = array(
				     	array('nama_modul','NAMA MODUL'),
						array('status','STATUS')
					);

	$fmPILCARI = $_REQUEST['fmPILCARI'];
	$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];
$fmORDER1 = $_REQUEST['fmORDER1'];


	$fmDESC1 = cekPOST('fmDESC1');
	$baris = $_REQUEST['baris'];
	if($baris == ''){
		$baris = "25";
	}
	$TampilOpt =
			"<div class='FilterBar' style='margin-top:5px;'>".
			"<table style='width:100%'>
			<tr>
			<td style='width:100px;'> ".cmbArray('fmPILCARI',$fmPILCARI,$arr,'-- Cari Data --','')."  </td><td><input type='text' value='".$fmPILCARIvalue."' name='fmPILCARIvalue' id='fmPILCARIvalue'>  &nbsp <input type='button' id='btTampil' value='Cari' onclick='".$this->Prefix.".refreshList(true)'></td>
			 </tr>
			</table>".
			"</div>"."<div class='FilterBar' style='margin-top:5px;'>".
			"<table style='width:100%'>
			<tr>
			<td style='width:100px;'> ".cmbArray('fmORDER1',$fmORDER1,$arrOrder,'--Urutkan--','')."  </td>
			<td style='width:200px;' ><input $fmDESC1 type='checkbox' id='fmDESC1' name='fmDESC1' value='checked'> menurun &nbsp Jumlah Data : <input type='text' name='baris' value='$baris' id='baris' style='width:30px;'>  </td><td align='left' ><input type='button' id='btTampil' value='Tampilkan' onclick='".$this->Prefix.".refreshList(true)'></td>
			 </tr>
			</table>".
			"</div>"

			;

		return array('TampilOpt'=>$TampilOpt);
	}

	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID'];
		//kondisi -----------------------------------

		$arrKondisi = array();

		$fmPILCARI = $_REQUEST['fmPILCARI'];
		$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];
		//cari tgl,bln,thn


		$fmLimit = $_REQUEST['baris'];
		$this->pagePerHal=$fmLimit;


		$fmPILCARI = $_REQUEST['fmPILCARI'];
		$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];
		//cari tgl,bln,thn
		$fmLimit = $_REQUEST['baris'];
		$this->pagePerHal=$fmLimit;

		//Cari
		switch($fmPILCARI){
			case 'nama_modul': $arrKondisi[] = " $fmPILCARI like '%$fmPILCARIvalue%'"; break;
			case 'status': $arrKondisi[] = " $fmPILCARI like '%$fmPILCARIvalue%'"; break;
		}


		$Kondisi= join(' and ',$arrKondisi);
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;

		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');
		$Asc1 = $fmDESC1 ==''? '': 'desc';
		$arrOrders = array();
		switch($fmORDER1){
			case 'nama_modul': $arrOrders[] = " $fmORDER1 $Asc1 " ;break;
			case 'status': $arrOrders[] = " $fmORDER1 $Asc1 " ;break;
		}
		$Order= join(',',$arrOrders);
		$OrderDefault = '';// Order By no_terima desc ';
		$Order =  $Order ==''? $OrderDefault : ' Order By '.$Order;

		$pagePerHal = $this->pagePerHal =='' ? $Main->PagePerHal: $this->pagePerHal;
		$HalDefault=cekPOST($this->Prefix.'_hal',1);

		$Limit = " limit ".(($HalDefault	*1) - 1) * $pagePerHal.",".$pagePerHal; //$LimitHal = '';
		$Limit = $Mode == 3 ? '': $Limit;

		$NoAwal= $pagePerHal * (($HalDefault*1) - 1);
		$NoAwal = $Mode == 3 ? 0: $NoAwal;

		return array('Kondisi'=>$Kondisi, 'Order'=>$Order ,'Limit'=>$Limit, 'NoAwal'=>$NoAwal);

	}

	function Hapus($ids){ //validasi hapus ref_kota
		 $err=''; $cek='';
		for($i = 0; $i<count($ids); $i++)	{

		if($cnt['cnt'] > 0) $err = "aksi ".$ids[$i]." Tidak Bisa DiHapus ! Sudah Digunakan Di Ref Barang.";

			if($err=='' ){
					$qy = "DELETE FROM $this->TblName_Hapus WHERE id_modul='".$ids[$i]."' ";$cek.=$qy;
					$qry = mysql_query($qy);

			}else{
				break;
			}
		}
		return array('err'=>$err,'cek'=>$cek);
	}
}
$aksi = new aksiObj();
?>
