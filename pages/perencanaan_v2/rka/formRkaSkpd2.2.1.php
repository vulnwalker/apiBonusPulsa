<?php
class formRkaSkpd221_v2Obj  extends DaftarObj2{	
	var $Prefix = 'formRkaSkpd221_v2';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'temp_rka_221_v2'; //bonus
	var $TblName_Hapus = 'temp_rka_221_v2';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('id');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 0, 0, 0);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $checkbox_rowspan = 2;
	var $PageTitle = 'RKA-SKPD 2.2.1';
	var $PageIcon = 'images/perencanaan_ico.png';
	var $ico_width = '28.8';
	var $ico_height = '28.8';
	var $pagePerHal ='';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='rkbmd.xls';
	var $namaModulCetak='PERENCANAAN';
	var $Cetak_Judul = 'RKA-SKPD 2.2.1';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'formRkaSkpd221_v2Form';
	var $noModul=14; 
	var $TampilFilterColapse = 0; //0
	var $modul = "RKA-SKPD";
	var $jenisForm = "";
	var $tahun = "";
	var $nomorUrut = "";
	var $jenisAnggaran = "";
	var $idTahap = "";
	var $username 	= "";
	var $publicExcept = array();
	var $publicGrupId = array();
	var $publicNomor = 1;
	var $statusForm = "";
	
	function setTitle(){
	    $id = $_REQUEST['ID_RKA'];
	    $getTahun = sqlArray(sqlQuery("select * from tabel_anggaran where id_anggaran = '$id'"));
		return 'RKA-SKPD 2.2.1 TAHUN '.$getTahun['tahun'] ;
	}
	
	function setMenuEdit(){
		return "";

	}
	
	function setMenuView(){
		return "";
	}
	
	
	
	
	function set_selector_other2($tipe){
	 global $Main;
	 $cek = ''; $err=''; $content=''; $json=TRUE;
		
	 return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}
	
	function set_selector_other($tipe){
	 global $Main,$HTTP_COOKIE_VARS;
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	 	  
	  switch($tipe){	
			
		case 'formBaru':{				
			$fm = $this->setFormBaru();				
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];												
		break;
		}
		case 'setGenNya':{
			if($this->statusForm == "EDIT"){
				$grabMinId = sqlArray(sqlQuery("select min(id) from temp_rka_221_v2 where user = '$this->username'"));
				$id = $grabMinId['min(id)'];
				$status = "OK";
			}else{
				$status ="ERROR";
			}
			$content = array("id" => $id,"status" => $status);
			break;
		} 
		
		case 'checkKondisi':{				
			if($this->statusForm =="EDIT"){
				$content = array('status' => 1) ;
			}									
		break;
		}
		
		case  'SaveAlokasi':{
			foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
			}
			$username = $_COOKIE['coID'] ;
			sqlQuery("delete from temp_alokasi_rka_v2 where user ='$username'");
			$data = array('jan' => $jan,
						  'feb' => $feb,
						  'mar' => $mar,
						  'apr'	=> $apr,
						  'mei' => $mei,
						  'jun' => $jun,
						  'jul' => $jul,
						  'agu' => $agu,
						  'sep' => $sep,
						  'okt' => $okt,
						  'nop' => $nop,
						  'des' =>$des,
						  'jenis_alokasi_kas' => $jenisAlokasi,
						  'user' => $_COOKIE['coID'] 				
							
						  );
						  
			$query = VulnWalkerInsert('temp_alokasi_rka_v2',$data);
			
			if(empty($jenisAlokasi)){
				$err = "Pilih jenis alokasi";				
			}elseif($jenisAlokasi == 'BULANAN'){
				if( $jan == '' || $feb == '' || $mar == '' || $apr == '' || $mei == '' || $jun == '' || $jul == '' || $agu == '' || $sep == '' || $okt == '' || $nop == '' || $des == ''   ){
					$err = "Lengkapi alokasi";	
				}
							
			}elseif($jenisAlokasi == 'TRIWULAN'   ){
				if( $mar == '' ||  $jun == '' ||  $sep == '' ||  $des == ''   ){
					$err = "Lengkapi alokasi";	
				}			
			}elseif($jumlahHargaAlokasi != $jumlahHarga){
				$err = "Jumlah Alokasi Salah ";	
			}
			if($err == '')sqlQuery($query);
			
			$content = array('query' => $query);
			
			break;
		}
		
		case  'SaveRincianVolume':{
			foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
			}
			$username = $_COOKIE['coID'];
			sqlQuery("delete from temp_rincian_volume_v2 where user='$username'");
			$data = array( 'jumlah1' => $jumlah1,
						   'satuan1' => $satuan1,
						   'jumlah2' => $jumlah2,
						   'satuan2' => $satuan2,
						   'jumlah3' => $jumlah3,
						   'satuan3' => $satuan3,
						   'jumlah4' => $jumlahTotal,
						   'satuan_total' => $satuanTotal,
						   'user' => $_COOKIE['coID'] 				
						  );
						  
			$query = VulnWalkerInsert('temp_rincian_volume_v2',$data);
			if($volumeRek != $jumlahTotal ){
				$err = "Total Rincian Tidak Sama";
			}elseif( (!empty($jumlah1) && empty($satuan1) ) || (!empty($jumlah2) && empty($satuan2) || (!empty($jumlah3) && empty($satuan3)  || (!empty($jumlahTotal) && empty($satuanTotal) ) ) )  ){
				$err = "Pilih satuan";
			}else{
				sqlQuery($query);
			}
			
			$content = array('query' => $query);
			
			
			
			break;
		}
		
		case 'formEdit':{				
			$fm = $this->setFormEdit();				
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];												
		break;
		}
		
		case 'detailVolume':{		
			foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
			}
			if($statusDetail != '1'){
				sqlQuery("delete from temp_detail_volume_rka_2_2_1 where username = '$this->username'");
			
				$rows = sqlArray(sqlQuery("select * from $this->TblName where id = '$id'"));
				$getItemSama = sqlQuery("select * from  $this->TblName where user = '$this->username' and c1 = '".$rows['c1']."' and c='".$rows['c']."' and d='".$rows['d']."' and bk = '".$rows['bk']."' and ck ='".$rows['ck']."' and p='".$rows['p']."' and q='".$rows['q']."' and f='".$rows['f']."' and g='".$rows['g']."' and h ='".$rows['h']."' and i ='".$rows['i']."' and j ='".$rows['j']."' and k='".$rows['k']."' and l = '".$rows['l']."' and m = ".$rows['m']." and n ='".$rows['n']."' and o='".$rows['o']."' and catatan = '".$rows['catatan']."' and id_jenis_pemeliharaan = '".$rows['id_jenis_pemeliharaan']."'");
				while($got = sqlArray($getItemSama)){
					foreach ($got as $key => $value) { 
					  $$key = $value; 
					}
					$data = array( 'c1' => $c1,
								   'c' => $c,
								   'd' => $d,
								   'e' => $e,
								   'e1' => $e1,
								   'username' => $this->username,
								   'jumlah' => $volume_rek,
								   'id_awal' => $id
								  
								  );
					sqlQuery(VulnWalkerInsert('temp_detail_volume_rka_2_2_1',$data));
					
				}
			}		
			$fm = $this->detailVolume();				
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];												
		break;
		}
		
		
		
		case 'clearAlokasi':{				
			$username = $_COOKIE['coID'];
			sqlQuery("delete from temp_alokasi_rka_v2 where user = '$username'");	
			$content = "delete from temp_alokasi_rka_v2 where user = '$username'";										
		break;
		}
		
		case 'saveDetailVolume':{				
			$getTotal = sqlArray(sqlQuery("select sum(jumlah) from temp_detail_volume_rka_2_2_1 where username ='$this->username'"));									
			$content = array('totalVolume'=> $getTotal['sum(jumlah)']);
		break;
		}
		
		
		
		case 'finish':{		
			$username = $_COOKIE['coID'];
			if($this->jenisForm != 'PENYUSUNAN'){
				$err = "TAHAP PENYUSUNAN TELAH HABIS";
			}elseif(sqlNumRow(sqlQuery("select * from temp_rka_221_v2  where user ='$username' and delete_status = '0'")) == 0){
				$err = "Data kosong";
			}
			
			if(empty($err)){
				$execute = sqlQuery("select * from temp_rka_221_v2  where user ='$username' ");
				while($rows = sqlArray($execute)){
					foreach ($rows as $key => $value) { 
					  $$key = $value; 
					}	
					$queryCekRekening = "select * from view_rka_2_2_1 where c1='0' and f = '00' and rincian_perhitungan = '' and k='$k' and l='$l' and m='$m' and n='$n' and o='$o' and id_tahap='$this->idTahap' ";
					if(sqlNumRow(sqlQuery($queryCekRekening)) == 0){
						$arrayRekening = array(
												 'c1' => '0',
												 'c' => '00',
												 'd' => '00',
												 'e' => '00',
												 'e1' => '000',
												 'f1' => '0',
										  		 'f2' => '0',
										  		 'f' => '00',
										 		 'g' => '00',
										  		 'h' => '00',
												 'i' => '00',
												 'j' => '000',
												 'k' => $k,
												 'l' => $l,
												 'm' => $m,
												 'n' => $n,
												 'o' => $o,
												 'jenis_rka' => '2.2.1',
												 'tahun' => $this->tahun,
												 'jenis_anggaran' => $this->jenisAnggaran,
												 'id_tahap' => $this->idTahap,
												 'nama_modul' => 'RKA-SKPD'
													);
						$query = VulnWalkerInsert('tabel_anggaran',$arrayRekening);
						sqlQuery($query);
					}
					
					
					$queryCekForUpdate = "select * from view_rka_2_2_1 where id_anggaran = '$id_awal'";
					if(sqlNumRow(sqlQuery($queryCekForUpdate)) > 0){
						
						$grabPekerjaan = sqlArray(sqlQuery("select * from view_rka_2_2_1 where id_anggaran = '$id_awal'"));
					    $lamaK = $grabPekerjaan['k'];
						$lamaL = $grabPekerjaan['l'];
						$lamaM = $grabPekerjaan['m'];
						$lamaN = $grabPekerjaan['n'];
						$lamaO = $grabPekerjaan['o'];
						$lamaO1 = $grabPekerjaan['o1'];
						
						
						
						if($delete_status == '1'){
							sqlQuery("delete from tabel_anggaran where id_anggaran ='$id_awal'");
						}else{
							$getPekerjaanRekening = sqlArray(sqlQuery($queryCekRekening));
							$cekRekDulu = $getPekerjaanRekening['o1'];
							$data = array(	'k' => $k,
										'l' => $l,
										'm' => $m,
										'n' => $n,
										'o' => $o,
										'o1' => $cekRekDulu,
										'satuan_rek' => $satuan,
										'volume_rek' => $volume_rek,
										'jumlah' => $harga_satuan,
										'jumlah_harga' => $jumlah_harga,
										'rincian_perhitungan' => $rincian_perhitungan,
										'user_update' => $username,
										'tanggal_update' => date("Y-m-d")
									 );
						$query = VulnWalkerUpdate('tabel_anggaran',$data,"id_anggaran ='$id_awal'");
						sqlQuery($query);
						}
						if(sqlNumRow(sqlQuery("select * from view_rka_2_2_1 where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and k='$lamaK' and l='$lamaL' and m='$lamaM' and n='$lamaN' and o='$lamaO'  and (rincian_perhitungan !='' or f!='00') and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and id_tahap='$this->idTahap'")) == 0){
							sqlQuery("delete from tabel_anggaran where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and k='$lamaK' and l='$lamaL' and m='$lamaM' and n='$lamaN' and o='$lamaO'  and rincian_perhitungan ='' and f='00'  and jenis_rka='2.2.1' and nama_modul='$this->modul' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and id_tahap='$this->idTahap'");
						}
					}else{
						$getPekerjaanRekening = sqlArray(sqlQuery($queryCekRekening)) ;
						$cekRekDulu = $getPekerjaanRekening['o1'];
						$data = array(	'c1' => $c1,
										'c' => $c,
										'd' => $d,
										'e' => $e,
										'e1' => $e1,
										'bk' => $bk,
										'ck' => $ck,
										'p' => $p,
										'q' => $q,
										'f1' => '0',
										'f2' => '0',
									    'f' => '00',
									    'g' => '00',
										'h' => '00',
										'i' => '00',
										'j' => '000',
										'k' => $k,
										'l' => $l,
										'm' => $m,
										'n' => $n,
										'o' => $o, 
										'o1' => $cekRekDulu, 
										'satuan_rek' => $satuan,
										'volume_rek' => $volume_rek,
										'jumlah' => $harga_satuan,
										'jumlah_harga' => $jumlah_harga,
										'rincian_perhitungan' => $rincian_perhitungan,
										'jenis_rka' => '2.2.1',
										'jenis_anggaran' => $this->jenisAnggaran,
										'tahun' => $this->tahun,
										'nama_modul' => 'RKA-SKPD',
										'id_tahap' => $this->idTahap,
										'user_update' => $username,
										'tanggal_update' => date("Y-m-d")
									 );
						
						$query = VulnWalkerInsert("tabel_anggaran",$data);
						if($delete_status == '1'){
							
						}else{
							sqlQuery($query);
						}
						
						
					}
					
				
					
					
				}
				
				
				
					
				
				
			}
			
			 
		break;
		}
	
		case 'Simpan':{
		
			foreach ($_REQUEST as $key => $value) { 
			  $$key = $value; 
			} 
			
			$c1 = explode(".",$urusan);
			$c1 = $c1[0];
			$c = explode(".",$bidang);
			$c = $c[0];
			$d = explode(".",$skpd);
			$d = $d[0];
			$e = explode(".",$unit);
			$e = $e[0];
			$e1 = explode(".",$subunit);
			$e1 = $e1[0];
			
		
		
		
		break;
	    }
		
		
		case 'SaveJob':{
			$username = $_COOKIE['coID'];
	    	foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
			 } 
			 $kodeRekening2 = explode(".",$kodeRekening);
			 $k = $kodeRekening2[0];
			 $l = $kodeRekening2[1];
			 $m = $kodeRekening2[2];
			 $n = $kodeRekening2[3];
			 $o = $kodeRekening2[4];
			 
			 $getMaxLeftUrut = sqlArray(sqlQuery("select max(left_urut) from ref_pekerjaan where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and p='$p' and q='$q' and k='$k' and l='$l' and m='$m' and  n='$n' and o ='$o'"));
			 $left_urut = $getMaxLeftUrut['max(left_urut)'] + 1;
			 
			 $data = array( 'nama_pekerjaan' => $namaPekerjaan,
			 				'c1' => $c1,
							'c' => $c,
							'd' => $d,
							'e' => $e,
							'e1' => $e1,
							'bk' => $bk,
							'ck' => $ck,
							'p' => $p,
							'q' => $q,
							'k' => $k,
							'l' => $l,
							'm' => $m,
							'n' => $n,
							'o' => $o,
							'left_urut' => $left_urut
							
			 				);
			 $query = VulnWalkerInsert("ref_pekerjaan",$data);
			 
			 if(empty($namaPekerjaan)){
			 	$err = "input gagal";
			 }else{
				$execute = sqlQuery($query);
			 }
			$codeAndNamePekerjaan = "select id, nama_pekerjaan from ref_pekerjaan where concat(k,'.',l,'.',m,'.',n,'.',o) = '$kodeRekening' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and p='$p' and q='$q' ";
			$getCurrentInsert = sqlArray(sqlQuery("select max(id) from ref_pekerjaan where concat(k,'.',l,'.',m,'.',n,'.',o) = '$kodeRekening' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and p='$p' and q='$q'"));
			$cmbPekerjaan = cmbQuery('o1', $getCurrentInsert['max(id)'], $codeAndNamePekerjaan," onchange=$this->Prefix.setNoUrut(); ",'-- PEKERJAAN --');
			$getMaxUrut = sqlArray(sqlQuery("select max(urut) from temp_rka_221_v2 where user ='$username'"));
			$urut = $getMaxUrut['max(urut)'] + 1;
			$content = array('cmbPekerjaan' => $cmbPekerjaan, 'left_urut' => $left_urut, 'urut' => $urut );
		break;
	    }
		case 'SaveEditJob':{
			$username = $_COOKIE['coID'];
	    	foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
			 } 
			 $kodeRekening2 = explode(".",$kodeRekening);
			 $k = $kodeRekening2[0];
			 $l = $kodeRekening2[1];
			 $m = $kodeRekening2[2];
			 $n = $kodeRekening2[3];
			 $o = $kodeRekening2[4];
			 
			 $getMaxLeftUrut = sqlArray(sqlQuery("select left_urut  from ref_pekerjaan where  id ='$o1'"));
			 $left_urut = $getMaxLeftUrut['left_urut'];
			 
			 $data = array( 'nama_pekerjaan' => $namaPekerjaan
							
			 				);
			 $query = VulnWalkerUpdate("ref_pekerjaan",$data,"id = '$o1'");
			 
			 if(empty($namaPekerjaan)){
			 	$err = "input gagal";
			 }else{
				$execute = sqlQuery($query);
			 }
			$codeAndNamePekerjaan = "select id, nama_pekerjaan from ref_pekerjaan where concat(k,'.',l,'.',m,'.',n,'.',o) = '$kodeRekening' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and p='$p' and q='$q' ";
			$getCurrentInsert = sqlArray(sqlQuery("select max(id) from ref_pekerjaan where concat(k,'.',l,'.',m,'.',n,'.',o) = '$kodeRekening' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and p='$p' and q='$q'"));
			$cmbPekerjaan = cmbQuery('o1', $getCurrentInsert['max(id)'], $codeAndNamePekerjaan," onchange=$this->Prefix.setNoUrut(); ",'-- PEKERJAAN --');
			
			$getUrut = sqlArray(sqlQuery("select * from temp_rka_221_v2 where o1='$o1'"));
			$urut = $getUrut['urut'];
			
			$content = array('cmbPekerjaan' => $cmbPekerjaan, 'left_urut' => $left_urut, 'urut' => $urut, 'query' => "select left_urut , urut as urut from ref_pekerjaan where  id ='$o1'" );
		break;
	    }
		case 'SaveSatuanSatuan':{
	    	foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
			 } 
			 
			 $data = array( "satuan_rekening" => $namaSatuan,
			 				"type" => 'satuan'
			 				);
			 $query = VulnWalkerInsert("ref_satuan_rekening",$data);
			 $execute = sqlQuery($query);
			 if($execute){
			 	
			 }else{
			 	$err = "input gagal";
			 }

			$content .= $query;
		break;
	    }
		
		case 'cekNoUrut':{
	    	foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
			 } 
			 $username = $_COOKIE['coID'];
			 $cekRow = sqlNumRow(sqlQuery("select * from temp_rka_221_v2 where o1 = '$noPekerjaan'   and user ='$username' "));
			 if($cekRow == 0){
			 	$get = sqlArray(sqlQuery("select max(urut) from temp_rka_221_v2 where  user ='$username' and delete_status !='1'  "));
			 	$urut = $get['max(urut)'] + 1;
			 }else{
			 	 $get = sqlArray(sqlQuery("select * from temp_rka_221_v2 where o1 = '$noPekerjaan'   and user ='$username' "));
				 $urut = $get['urut'];
			 }
			 $getLeftUrut = sqlArray(sqlQuery("select * from ref_pekerjaan where id ='$noPekerjaan'"));
			 $content = array('leftUrut' => $getLeftUrut['left_urut']  ,'noUrut' => $urut);
			 
		break;
	    }
		
		case 'SaveSatuanVolume':{
	    	foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
			 } 
			 
			 $data = array( "satuan_rekening" => $namaSatuan,
			 				"type" => 'volume'
			 				);
			 $query = VulnWalkerInsert("ref_satuan_rekening",$data);
			 $execute = sqlQuery($query);
			 if($execute){
			 	
			 }else{
			 	$err = "input gagal";
			 }

			$content .= $query;
		break;
	    }
		
		case 'SaveSatuan':{
	    	foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
			 } 
			 
			 $data = array( "satuan_rekening" => $namaPekerjaan,
			 				"type" => 'volume'
			 				);
			 $query = VulnWalkerInsert("ref_satuan_rekening",$data);
			 $execute = sqlQuery($query);
			 if($execute){
			 	
			 }else{
			 	$err = "input gagal";
			 }

			$content .= $query;
		break;
	    }
		case 'hapus2':{
	    	 $id = $_REQUEST['id'];
			 $get = sqlArray(sqlQuery("select * from temp_rka_221_v2 where id='$id' "));
			 $username = $_COOKIE['coID'];
			 $noPekerjaan = $get['o1'];
			 $noUrutPekerjaan = $get['urut'];
			 sqlQuery("update  temp_rka_221_v2 set delete_status = '1', o1 ='0' where id='$id'");
			 $execute = sqlQuery("select * from temp_rka_221_v2  where user='$username' and o1='$noPekerjaan' and delete_status = '0' order by o1, rincian_perhitungan");
			 $angkaUrut = 1;
			 while($rows = sqlArray($execute)){
				if($rows['rincian_perhitungan'] == ''){
					$angkaUrut = '0';
				}
				$dataEditNoUrut = array('urut' => $noUrutPekerjaan,
			 						 	'o2' => $angkaUrut);
				$idTemp = $rows['id'];
				sqlQuery(VulnWalkerUpdate("temp_rka_221_v2",$dataEditNoUrut," id='$idTemp'"));
				$angkaUrut = $angkaUrut + 1;
				
				$content .= VulnWalkerUpdate("temp_rka_221_v2",$dataEditNoUrut," id='$idTemp'");
			 }
		break;
	    }
		
		case 'saveEdit':{
	    	foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
			 } 
			 $username = $_COOKIE['coID'];
			 $idBuatAlokasi = $id;
			 
			 
			 $grabGroup = sqlArray(sqlQuery("select * from $this->TblName where id = '$id'"));
			 foreach ($grabGroup as $key => $value) { 
				  $$key = $value; 
			 } 
			 
			 
			 
			 $getRincianVolume  = sqlArray(sqlQuery("select * from temp_rincian_volume_v2 where user='$username'"));
			 foreach ($getRincianVolume as $key => $value) { 
				  $$key = $value; 
			 } 
			 
			 $jumlahHarga = $hargaSatuan * $volumeRek;
			 $paguYangTerpakaiDITemp = "";
			 $ekseGetTempData = sqlQuery("select * from temp_rka_221_v2 where user = '$username'  and bk = '$bk' and ck='$ck' and p='$p' and q='$q'  and f!='$f' and g!='$g' and h != '$h' and i !='$i' and j !='$j' and rincian_perhitungan !='$rincian_perhitungan'  and delete_status = '0'");
			 $kondisiIDAwal = "";
			 while($baris = sqlArray($ekseGetTempData)){
			 	$idParent = $baris['id_awal'];
				$kondisiIDAwal = $kondisiIDAwal." and id_anggaran != '$idParent'" ;
				$paguYangTerpakaiDITemp = $paguYangTerpakaiDITemp + $baris['jumlah_harga'];
			 }
			 
			 
			 
			 $getIdTahapRenjaTerakhir = sqlArray(sqlQuery("select max(id_tahap) as max from view_renja where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' "));
			 $idTahapRenja = $getIdTahapRenjaTerakhir['max'];
			 $getPaguIndikatif = sqlArray(sqlQuery("select * from view_renja where c1= '$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and p='$p' and q='$q' and id_tahap = '$idTahapRenja' "));
			 $cekDulu = sqlNumRow(sqlQuery("select * from view_renja where c1= '$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and p='$p' and q='$q' and id_tahap = '$idTahapRenja' "));
			 $getJumlahPaguDiTabelAnggaran = sqlArray(sqlQuery("select sum(jumlah_harga) from view_rka_2_2_1  where id_tahap='$this->idTahap' and c1='$c1' and c='$c' and d='$d' and  e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and p='$p' and  q='$q'  and rincian_perhitungan !='' $kondisiIDAwal and f!='$f' and g!='$g' and h != '$h' and i !='$i' and j !='$j' and rincian_perhitungan !='$rincian_perhitungan' "));
			 if($cekDulu == 0){
			 	$getPaguIndikatif = sqlArray(sqlQuery("select * from view_renja where c1= '$c1' and c='$c' and d='$d' and e='00' and e1='000' and bk='$bk' and ck='$ck' and p='$p' and q='$q' and id_tahap = '$idTahapRenja' "));
			 	$getJumlahPaguDiTabelAnggaran = sqlArray(sqlQuery("select sum(jumlah_harga) from view_rka_2_2_1  where id_tahap='$this->idTahap' and c1='$c1' and c='$c' and d='$d'  and bk='$bk' and ck='$ck' and p='$p' and  q='$q'  and rincian_perhitungan !='' $kondisiIDAwal and f!='$f' and g!='$g' and h != '$h' and i !='$i' and j !='$j' and rincian_perhitungan !='$rincian_perhitungan' "));
			 }
			 $paguYangTerpakaiDiTabelAnggaran = $getJumlahPaguDiTabelAnggaran['sum(jumlah_harga)'];
			 $sisaPagu = $getPaguIndikatif['jumlah'] - $paguYangTerpakaiDiTabelAnggaran - $paguYangTerpakaiDITemp;
			 
			 
			 //cek pagu 
			 
			 /*if($rincianVolume == ''){
			 	$err = "Lengkapi Rincian Volume";
			 }elseif($teralokasi == ""){
			 	$err = "Lengkapi Alokasi";
			 }else*/
			 if(empty($volumeRek)){
			 	$err = "Isi Volume";
			 }elseif(empty($satuanRek) && $kodeBarang == ''){
			 	$err = "Pilih Satuan";
			 }elseif($kodeRekening == '' ){
			 	$err = "Pilih Kode Rekening";
			 }elseif(empty($hargaSatuan)){
			 	$err = "Isi Harga Satuan";
			 }elseif($jumlahHarga > $sisaPagu){
			 	$err = "Tidak dapat melebihi Pagu indikatif";
				//$err = "select sum(jumlah_harga) from view_rka_2_2_1  where id_tahap='$this->idTahap' and c1='$c1' and c='$c' and d='$d' and  e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and p='$p' and  q='$q'  and rincian_perhitungan !='' $kondisiIDAwal and f!='$f' and g!='$g' and h != '$h' and i !='$i' and j !='$j' and rincian_perhitungan !='$rincian_perhitungan'";
			 }
			 if($this->jenisForm != 'PENYUSUNAN'){
				$err = "TAHAP PENYUSUNAN TELAH HABIS";
			}
			 $kodeRekening = explode('.',$kodeRekening);
			 $k = $kodeRekening[0];
			 $l = $kodeRekening[1];
			 $m = $kodeRekening[2];
			 $n = $kodeRekening[3];
			 $o = $kodeRekening[4];
			 if($err == ''){
			
			 
			 
			 if($this->statusForm == "EDIT"){
			 	 $prepairWhile = sqlQuery("select * from temp_detail_volume_rka_2_2_1 where username = '$this->username'");
				 while($toktok =sqlArray($prepairWhile)){
				 	foreach ($toktok as $key => $value) { 
					  $$key = $value; 
					 }
				 	$data = array(  
				 				'bk' => $bk,
				 				'ck' => $ck,
								'p' => $p,
								'q' => $q,
								'k' => $kodeRekening[0],
								'l' => $kodeRekening[1],
								'm' => $kodeRekening[2],
								'n' => $kodeRekening[3],
								'o' => $kodeRekening[4],
								'rincian_perhitungan' => $rincianPerhitungan,
								'volume_rek' => $jumlah,
								'harga_satuan' => $hargaSatuan,
								'jumlah_harga' => $hargaSatuan * $jumlah,
								'satuan' => $satuanRek,
				 				);
				 $query = VulnWalkerUpdate("temp_rka_221_v2",$data,"id='$id_awal'");
				 sqlQuery($query);
				 }
			 	$lanjut = "finish";
			 }else{
				 	 $data = array(  
				 				'bk' => $bk,
				 				'ck' => $ck,
								'p' => $p,
								'q' => $q,
								'k' => $kodeRekening[0],
								'l' => $kodeRekening[1],
								'm' => $kodeRekening[2],
								'n' => $kodeRekening[3],
								'o' => $kodeRekening[4],
								'rincian_perhitungan' => $rincianPerhitungan,
								'volume_rek' => $volumeRek,
								'harga_satuan' => $hargaSatuan,
								'jumlah_harga' => $hargaSatuan * $volumeRek,
								'satuan' => $satuanRek,
				 				);
				 $query = VulnWalkerUpdate("temp_rka_221_v2",$data,"id='$id'");
				 sqlQuery($query);
			 }
			
			 
			 
			 
			 
			 
			 sqlQuery("delete from temp_rincian_volume_v2 where user='$username'");
			 sqlQuery("delete from temp_alokasi_rka_v2 where user='$username'");
			 sqlQuery("delete from temp_detail_volume_rka_2_2_1 where username='$this->username'");
			 
			 }
			 $content = array("kodeRekening" => $_REQUEST['kodeRekening'], 
			 "namaRekening" => $_REQUEST['namaRekening'], "o1Html" => $_REQUEST['o1Html'] ,
			 'lanjut'=> $lanjut,"query" => $query);

			
		break;
	    }
		
		case 'Simpan2':{
	    	foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
			 } 
			 $username = $_COOKIE['coID'];
			 $getRincianVolume  = sqlArray(sqlQuery("select * from temp_rincian_volume_v2 where user='$username'"));
			 foreach ($getRincianVolume as $key => $value) { 
				  $$key = $value; 
			 } 
			 $getAlokasi  = sqlArray(sqlQuery("select * from temp_alokasi_rka_v2 where user='$username'"));
			 foreach ($getAlokasi as $key => $value) { 
				  $$key = $value; 
			 } 
			 
			  //cek pagu
			 $jumlahHarga = $hargaSatuan * $volumeRek;
			 $paguYangTerpakaiDITemp = "";
			 $getIdTahapRenjaTerakhir = sqlArray(sqlQuery("select max(id_tahap) as max from view_renja where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' "));
			 $idTahapRenja = $getIdTahapRenjaTerakhir['max'];
			 $ekseGetTempData = sqlQuery("select * from temp_rka_221_v2 where user = '$username'  and bk = '$bk' and ck='$ck' and p='$p' and q='$q' and id !='$id' and delete_status = '0'");
			 $kondisiIDAwal = "";
			 while($baris = sqlArray($ekseGetTempData)){
			 	$idParent = $baris['id_awal'];
				$kondisiIDAwal = $kondisiIDAwal." and id_anggaran != '$idParent'" ;
				$paguYangTerpakaiDITemp = $paguYangTerpakaiDITemp + $baris['jumlah_harga'];
			 }
			 $getJumlahPaguDiTabelAnggaran = sqlArray(sqlQuery("select sum(jumlah_harga) from view_rka_2_2_1  where id_tahap='$this->idTahap' and c1='$c1' and c='$c' and d='$d' and  e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and p='$p' and  q='$q'  and rincian_perhitungan !='' $kondisiIDAwal "));
			 $getPaguIndikatif = sqlArray(sqlQuery("select * from view_renja where c1= '$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and p='$p' and q='$q' and id_tahap = '$idTahapRenja' "));
			 $cekDulu = sqlNumRow(sqlQuery("select * from view_renja where c1= '$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and p='$p' and q='$q' and id_tahap = '$idTahapRenja' "));
			 
			 if($cekDulu == 0){
			 	$getJumlahPaguDiTabelAnggaran = sqlArray(sqlQuery("select sum(jumlah_harga) from view_rka_2_2_1  where id_tahap='$this->idTahap' and c1='$c1' and c='$c' and d='$d' and bk='$bk' and ck='$ck' and p='$p' and  q='$q'  and rincian_perhitungan !='' $kondisiIDAwal "));
				$getPaguIndikatif = sqlArray(sqlQuery("select * from view_renja where c1= '$c1' and c='$c' and d='$d' and e='00' and e1='000' and bk='$bk' and ck='$ck' and p='$p' and q='$q' and id_tahap = '$idTahapRenja' "));
			 	$stat = "select * from view_renja where c1= '$c1' and c='$c' and d='$d' and e='00' and e1='000' and bk='$bk' and ck='$ck' and p='$p' and q='$q' and id_tahap = '$idTahapRenja' ";
			 }
			 $paguYangTerpakaiDiTabelAnggaran = $getJumlahPaguDiTabelAnggaran['sum(jumlah_harga)'];
			 
			 
			 $getIdTahapRenjaTerakhir = sqlArray(sqlQuery("select max(id_tahap) as max from view_renja where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' "));
			 $idTahapRenja = $getIdTahapRenjaTerakhir['max'];
			 $sisaPagu = $getPaguIndikatif['jumlah'] - $paguYangTerpakaiDiTabelAnggaran - $paguYangTerpakaiDITemp;
			 
			 
			 //cek pagu 
			 
			/* if($rincianVolume == ''){
			 	$err = "Lengkapi Rincian Volume";
			 }elseif($teralokasi == ""){
			 	$err = "Lengkapi Alokasi";
				elseif($teralokasi == ""){
			 	$err = "Lengkapi Alokasi";
			 }
			 }else*/
			 
			 if(empty($volumeRek)){
			 	$err = "Isi Volume";
			 }elseif(empty($satuanRek)){
			 	$err = "Pilih Satuan";
			 }elseif($kodeRekening == '' ){
			 	$err = "Pilih Kode Rekening";
			 }elseif(empty($hargaSatuan)){
			 	$err = "Isi Harga Satuan";
			 }elseif($jumlahHarga > $sisaPagu){
			 	$err = "Tidak dapat melebihi Pagu indikatif ";
			 }
			 $kodeRekening = explode('.',$kodeRekening);
			 $k = $kodeRekening[0];
			 $l = $kodeRekening[1];
			 $m = $kodeRekening[2];
			 $n = $kodeRekening[3];
			 $o = $kodeRekening[4];
			 if($err == ''){
			 	
			 
			 $data = array( 
			 				'c1' => $c1,
							   'c' => $c,
							   'd' => $d,
							   'e' => '00',
							   'e1' => '000',
							   'f1' => '0',
							   'f2' => '0',
							   'f' => '00',
							   'g' => '00',
							   'h' => '00',
							   'i' => '00',
							   'j' => '000',
			 				'bk' => $bk,
			 				'ck' => $ck,
							'p' => $p,
							'q' => $q,
							'k' => $k,
							'l' => $l,
							'm' => $m,
							'n' => $n,
							'o' => $o,
							'rincian_perhitungan' => $rincianPerhitungan,
							'volume_rek' => $volumeRek,
							'harga_satuan' => $hargaSatuan,
							'jumlah_harga' => $hargaSatuan * $volumeRek,
							'satuan' => $satuanRek,
							'user' => $username
			 				);
			 $query = VulnWalkerInsert("temp_rka_221_v2",$data);
			 sqlQuery($query);
			 
			 sqlQuery("delete from temp_rincian_volume_v2 where user='$username'");
			 sqlQuery("delete from temp_alokasi_rka_v2 where user='$username'");
			 }
			 

			$content = array("kodeRekening" => $_REQUEST['kodeRekening'], "namaRekening" => $_REQUEST['namaRekening'] , "o1Html" => $_REQUEST['o1Html'], 'sql' => $stat);
		break;
	    }
		
		case 'newJob':{
				$fm = $this->newJob($dt);				
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];										
		break;
		}
		
		case 'editJob':{
				$dt = $_REQUEST['o1'];
				$fm = $this->editJob($dt);				
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];										
		break;
		}
		
		case 'newSatuanSatuan':{
				$fm = $this->newSatuanSatuan($dt);				
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];										
		break;
		}
		case 'newSatuanVolume':{
				$fm = $this->newSatuanVolume($dt);				
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];										
		break;
		}
		
		case 'edit':{
				foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
				}
				$username = $_COOKIE['coID'];
				sqlQuery("delete from temp_alokasi_rka_v2 where user = '$username'");
				sqlQuery("delete from temp_rincian_volume_v2 where user = '$username'");
				$get = sqlArray(sqlQuery("select * from temp_rka_221_v2 where id = '$id'"));
				sqlQuery("delete from temp_detail_volume_rka_2_2_1 where username = '$this->username'");
			
				$rows = sqlArray(sqlQuery("select * from $this->TblName where id = '$id'"));
				$getItemSama = sqlQuery("select * from  $this->TblName where user = '$this->username' and c1 = '".$rows['c1']."' and c='".$rows['c']."' and d='".$rows['d']."' and bk = '".$rows['bk']."' and ck ='".$rows['ck']."' and p='".$rows['p']."' and q='".$rows['q']."' and f='".$rows['f']."' and g='".$rows['g']."' and h ='".$rows['h']."' and i ='".$rows['i']."' and j ='".$rows['j']."' and k='".$rows['k']."' and l = '".$rows['l']."' and m = ".$rows['m']." and n ='".$rows['n']."' and o='".$rows['o']."' and catatan = '".$rows['catatan']."' and id_jenis_pemeliharaan = '".$rows['id_jenis_pemeliharaan']."'");
				while($got = sqlArray($getItemSama)){
					foreach ($got as $key => $value) { 
					  $$key = $value; 
					}
					$data = array( 'c1' => $c1,
								   'c' => $c,
								   'd' => $d,
								   'e' => $e,
								   'e1' => $e1,
								   'username' => $this->username,
								   'jumlah' => $volume_rek,
								   'id_awal' => $id
								  
								  );
					sqlQuery(VulnWalkerInsert('temp_detail_volume_rka_2_2_1',$data));
					
				}
				foreach ($get as $key => $value) { 
				  $$key = $value; 
				}
				
				$got = sqlArray(sqlQuery("select 
													  sum(volume_rek) as volume_rek
													  from temp_rka_221_v2 where
													  user = '$this->username'  
													  and f='$f' and g = '$g' and h ='$h' and i ='$i' and j='$j' 
													   
													    "));

				
				
				
				
				$statusAlokasi = 'true';
				if($f == '00'){
					$kunci = '0';
				}else{
					$getNamaBarang = sqlArray(sqlQuery("select * from ref_barang where  f='$f' and g='$g' and h='$h' and i='$i' and j='$j' "));
					$rincianPerhitungan = $getNamaBarang['nm_barang'];
					$kunci = '1';
					$kodeBarang = $f.".".$g.".".$h.".".$i.".".$j;
				}
				
				$kodeRekening = $k.".".$l.".".$m.".".$n.".".$o;
				$codeAndNameProgram = "select p,concat(p,'. ',nama) from ref_program where bk='$bk' and ck='$ck' and dk='0' and p='$p' and q='0'";
				$cmbProgram = cmbQuery('p',$p,$codeAndNameProgram,'disabled','-- PROGRAM --');
				$codeAndNameKegiatan = "select q,concat(q,'. ',nama) from ref_program where bk='$bk' and ck='$ck' and dk='0' and p='$p' and q='$q'";
				$cmbKegiatan = cmbQuery('q',$q,$codeAndNameKegiatan,'disabled','-- KEGIATAN --');
				$getNamaRekening = sqlArray(sqlQuery("select * from ref_rekening where k='$k' and l='$l' and m='$m' and n='$n' and o='$o'"));
				$namaRekening= $getNamaRekening['nm_rekening'];
				$codeAndNamePekerjaan = "select id, nama_pekerjaan from ref_pekerjaan where concat(k,'.',l,'.',m,'.',n,'.',o) = '$kodeRekening' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and p='$p' and q='$q' ";
				$cmbPekerjaan = cmbQuery('o1', $o1, $codeAndNamePekerjaan," onchange=$this->Prefix.setNoUrut(); ",'-- PEKERJAAN --');
				$noUrut = $o1;
				$hargaSatuan = $harga_satuan;
				$content = array('bk' => $bk,
								 'ck' => $ck, 
								 'p'=>$p,
								 'q' => $q, 
								 'rincianPerhitungan' => $rincianPerhitungan, 
								 'rincianPerhitungan2' => $rincian_perhitungan, 
								 'kunci' => $kunci, 
								 'volume' => $got['volume_rek'], 
								 'bk' => $bk,
								 'ck' => $ck,
								 'hiddenP' => $p,
								 'q' => $q,
								 'satuan' => $satuan,
								 'kodeRekening' => $kodeRekening,
								 'namaRekening' => $namaRekening,
								 'cmbProgram' => $cmbProgram,
								 'cmbKegiatan' => $cmbKegiatan,
								 'cmbPekerjaan' => $cmbPekerjaan,
								 'noUrut' => $noUrut,
								 'hargaSatuan' => $hargaSatuan,
								 'jumlahHarga' => $harga_satuan * $got['volume_rek'],
								 'kodeBarang' => $kodeBarang,
								 'statusAlokasi' => $statusAlokasi,							 
								 'jenis_alokasi_kas' => $jenis_alokasi_kas
								    );
				 										
		break;
		}
		
		case 'formAlokasi':{
				$dt = $_REQUEST['jumlahHarga'];
				$fm = $this->formAlokasi($dt);				
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
					
															
		break;
		}
		case 'formAlokasiTriwulan':{
				$dt = $_REQUEST['jumlahHarga'];
				$fm = $this->formAlokasiTriwulan($dt);				
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
					
															
		break;
		}
		
		case 'formRincianVolume':{
				$dt = $_REQUEST['volumeRek'];
				$fm = $this->formRincianVolume($dt);				
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
					
															
		break;
		}
		
		case 'setSatuanHarga':{
			foreach ($_REQUEST as $key => $value) { 
				  		$$key = $value; 
					 }
			
			$get = sqlArray(sqlQuery("select * from ref_std_harga where f='$f' and g='$g' and h='$h' and i='$i' and j='$j' "));
			
			if($get['standar_satuan_harga'] == NULL){
				$err = "Standar harga tidak di temukan !";
			}
			
			$content = array('harga' => $get['standar_satuan_harga'] , 'bantu' => "Rp. ".number_format($get['standar_satuan_harga'],0,',','.') );
															
		break;
		}
		
		case 'newSatuan':{
				$fm = $this->newSatuan($dt);				
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
					
															
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

			"<script type='text/javascript' src='js/skpd.js' language='JavaScript' ></script>".	
			"<script type='text/javascript' src='js/perencanaan_v2/rka/formRkaSkpd2.2.1.js' language='JavaScript' ></script>".
			"<script type='text/javascript' src='js/perencanaan_v2/rka/detail_volume/detailVolumeRka221.js' language='JavaScript' ></script>".
			"<script type='text/javascript' src='js/perencanaan/rka/popupRekening.js' language='JavaScript' ></script>

			
			
			".
			
			'
			  <link rel="stylesheet" href="datepicker/jquery-ui.css">
			  <script src="datepicker/jquery-1.12.4.js"></script>
			  <script src="datepicker/jquery-ui.js"></script>
			  <script>
			  $( function() {
			    $( "#tgl_dok" ).datepicker({ dateFormat: "dd-mm-yy" });
				
				$( "#datepicker2" ).datepicker({ dateFormat: "dd-mm-yy" });
			  } );
			  </script>
			'.
			$scriptload;
	}
	
	//form ==================================
 
	function setPage_HeaderOther(){
	return 
	"";
	}
		
	//daftar =================================
	function setKolomHeader($Mode=1, $Checkbox=''){
	 $NomorColSpan = $Mode==1? 2: 1;
	 $headerTable =
	  "<thead>
	   <tr>
  	   <th class='th01' width='5'  colspan='1' >No.</th>		
	   <th class='th01' width='800' colspan='1'>URAIAN</th>
	   <th class='th01' width='150' colspan='1'>VOLUME</th>
	   <th class='th01' width='150'  colspan='1'>SATUAN</th>
	   <th class='th01' width='150'  colspan='1'>HARGA SATUAN</th>
	   <th class='th01' width='150'  colspan='1'>JUMLAH HARGA</th>
	   <th class='th01' width='100'  colspan='1'>AKSI</th>
	   </tr>
	   </thead>";
	   if($this->statusForm == "EDIT"){
	   	$headerTable = "";
	   }
		return $headerTable;
	}	
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	foreach ($isi as $key => $value) { 
			  $$key = $value; 
			}
    $username = $_COOKIE['coID'];
	$Koloms = array();
	$grabWihtCondition = sqlQuery("select * from temp_rka_221_v2 where user = '$this->username' group by c1,c,d,bk,ck,p,q,k,l,m,n,o,catatan,id_jenis_pemeliharaan");
			while($rows = sqlArray($grabWihtCondition)){
				if(sqlNumRow(sqlQuery("select * from temp_rka_221_v2 where user = '$this->username'  and c1 = '".$rows['c1']."' and c='".$rows['c']."' and d='".$rows['d']."' and bk = '".$rows['bk']."' and ck ='".$rows['ck']."' and p='".$rows['p']."' and q='".$rows['q']."' and f='".$rows['f']."' and g='".$rows['g']."' and h ='".$rows['h']."' and i ='".$rows['i']."' and j ='".$rows['j']."' and k='".$rows['k']."' and l = '".$rows['l']."' and m = ".$rows['m']." and n ='".$rows['n']."' and o='".$rows['o']."' and catatan = '".$rows['catatan']."' and id_jenis_pemeliharaan = '".$rows['id_jenis_pemeliharaan']."' ")) >= 2 && $rows['j'] !='000'){
					$this->publicExcept[] = $rows['id'];
					$this->publicGrupId[] = $rows['c1'].".".$rows['c'].".".$rows['d'].".".$rows['bk'].".".$rows['ck'].".".$rows['p'].".".$rows['q'].".".$rows['f'].".".$rows['g'].".".$rows['h'].".".$rows['i'].".".$rows['j'].".".$rows['k'].".".$rows['l'].".".$rows['m'].".".$rows['n'].".".$rows['o'].".".$rows['catatan'].".".$rows['id_jenis_pemeliharaan'];
				}
			}
		
	$grubId = $isi['c1'].".".$isi['c'].".".$isi['d'].".".$isi['bk'].".".$isi['ck'].".".$isi['p'].".".$isi['q'].".".$isi['f'].".".$isi['g'].".".$isi['h'].".".$isi['i'].".".$isi['j'].".".$isi['k'].".".$isi['l'].".".$isi['m'].".".$isi['n'].".".$isi['o'].".".$isi['catatan'].".".$isi['id_jenis_pemeliharaan'];
       if(in_array($grubId, $this->publicGrupId)) {
            $jumlah_harga = sqlArray(sqlQuery("select sum(jumlah_harga) from temp_rka_221_v2 where concat(c1,'.',c,'.',d,'.',bk,'.',ck,'.',p,'.',q,'.',f,'.',g,'.',h,'.',i,'.',j,'.',k,'.',l,'.',m,'.',n,'.',o,'.',catatan,'.',id_jenis_pemeliharaan) = '$grubId' and user = '$this->username' "));
            $jumlah_harga= $jumlah_harga['sum(jumlah_harga)'];
            $volume_rek  = sqlArray(sqlQuery("select sum(volume_rek) from temp_rka_221_v2 where concat(c1,'.',c,'.',d,'.',bk,'.',ck,'.',p,'.',q,'.',f,'.',g,'.',h,'.',i,'.',j,'.',k,'.',l,'.',m,'.',n,'.',o,'.',catatan,'.',id_jenis_pemeliharaan) = '$grubId' and user = '$this->username' "));
            $volume_rek = $volume_rek['sum(volume_rek)'];
      }
		$Koloms[] = array('align="center" width="10"', $this->publicNomor );
		if($f !='00' || $rincian_perhitungan != ''){
			$getNamaBarang = sqlArray(sqlQuery("select * from ref_barang where  f='$f' and g='$g' and h='$h' and i='$i' and j='$j'"));
			$namaBarang = $getNamaBarang['nm_barang'];
			if($f !='00'){
				$Koloms[] = array(' align="left" ', "<span style='margin-left:5px;' >$namaBarang</span>" );
			}else{
				$Koloms[] = array(' align="left" ', "<span style='margin-left:5px;' >$rincian_perhitungan</span>" );
			}
			
			$aksi  = "<img src='images/administrator/images/invalid.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=$this->Prefix.hapus('$id');></img>&nbsp  &nbsp <img src='images/administrator/images/edit_f2.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=$this->Prefix.edit('$id');></img>";
			$Koloms[] = array(' align="right"', number_format($volume_rek ,0,',','.') );
			$Koloms[] = array(' align="left"', $satuan );
			$Koloms[] = array(' align="left"', number_format($harga_satuan ,2,',','.') );
			$Koloms[] = array(' align="left"', number_format($jumlah_harga ,2,',','.' ) );
		}else{
			$getNamaPekerjaan = sqlArray(sqlQuery("select * from ref_pekerjaan where id='$o1' "));
			$namaPekerjaan = $getNamaPekerjaan['nama_pekerjaan'];
			$getTotal = sqlArray(sqlQuery("select sum(volume_rek) as volRek, sum(jumlah_harga) as jumlahHarga from temp_rka_221_v2 where o1 ='$o1' and user='$username' and delete_status !='1'"));
			$Koloms[] = array(' align="left" ',  "<span>$namaPekerjaan</span>" );
			$Koloms[] = array(' align="right"', number_format($getTotal['volRek'] ,0,',','.') );
			$Koloms[] = array(' align="left"', '' );
			$Koloms[] = array(' align="left"', '' );
			$Koloms[] = array(' align="left"', number_format($getTotal['jumlahHarga'] ,2,',','.' ) );
		}
		
	
	
	
	
		$Koloms[] = array(' align="center"', $aksi );
		if($j =='000'){
			$this->publicNomor += 1;
		}elseif(in_array($id, $this->publicExcept)) {
			$this->publicNomor += 1;
		}elseif($j != '000' && sqlNumRow(sqlQuery("select * from temp_rka_221_v2 where concat(c1,'.',c,'.',d,'.',bk,'.',ck,'.',p,'.',q,'.',f,'.',g,'.',h,'.',i,'.',j,'.',k,'.',l,'.',m,'.',n,'.',o,'.',catatan,'.',id_jenis_pemeliharaan) = '$grubId' and user = '$this->username'  ")) > 1 ){
				$Koloms= array();	
		}
		
		
		if($this->statusForm == "EDIT"){
			$Koloms = array();
		}
	
	return $Koloms;
	

	
	
	
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
		
		$cbid = $_REQUEST['rkbmd_cb'];
		 setcookie("coUrusanProgram", "", time()-3600);
		 setcookie('coBidangProgram', "", time()-3600);
		 unset($_COOKIE['coProgram']);
   		 
		return
		

		"<html>".
			$this->genHTMLHead().
			"<body >".
			"<table id='KerangkaHal' class='menubar' cellspacing='0' cellpadding='0' border='0' width='100%' height='100%' >".	
				"<tr height='34'><td>".					
					$this->setPage_Header().
					"<div id='header' ></div>".
				"</td></tr>".	
				$navatas.			
				"<tr height='*' valign='top'> <td >".
					
					$this->setPage_HeaderOther().
					"<div align='center' class='centermain' >".
					"<div class='main' >".
					$form1.
					"
					<input type='hidden' name='ID_RKA' value='".$_REQUEST['id']."' />
					<input type='hidden' name='concatSKPD' value='".$_REQUEST['skpd']."' />
					<input type='hidden' name='ID_rkbmd' value='".$_REQUEST['ID_rkbmd']."' />".
					"<input type='hidden' name='databaru' id='databaru' value='".$_REQUEST['YN']."' />".
					"<input type='hidden' name='idubah' id='idubah' value='".$cbid[0]."' />".
										
						$this->setPage_Content().

					$form2.
					"</div></div>".
				"</td></tr>".
				"<tr><td height='29' >".	
					$Main->CopyRight.							
				"</td></tr>".
				$OtherFooterPage.
			"</table>".
			"</body>
		</html>"; 
	}	
	
	
	function detailVolume($dt){	
	 global $SensusTmp;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 400;
	 $this->form_height = 80;
	 $this->form_caption = 'DETAIL VOLUME';
	 
	 	
	 //items ----------------------
	  $this->form_fields = array(
			'listDetailVolume' => array( 
						'label'=>'',
						'value'=>"
						
						<div id='listDetailVolume' style='height:5px'></div>", 
						
						'type'=>'merge'
					 ),						
			
			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveDetailVolume();' title='Simpan' >   ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
							
		$form = $this->genForm2();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	function newJob($dt){	
	 global $SensusTmp;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 400;
	 $this->form_height = 80;
	 $this->form_caption = 'PEKERJAAN BARU';
	 
	 	
	 //items ----------------------
	  $this->form_fields = array(
			'namaPekerjaan' => array( 
						'label'=>'NAMA PEKERJAAN',
						'labelWidth'=>130, 
						'value'=>"<input type='text' name='namaPekerjaan' id='namaPekerjaan' style='width:210px;'>",
						 ),					
			
			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SaveJob();' title='Simpan' >   ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function editJob($dt){	
	 global $SensusTmp;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 400;
	 $this->form_height = 80;
	 $this->form_caption = 'EDIT PEKERJAAN';
	 
	 $getNamaPekerjaan = sqlArray(sqlQuery("select * from ref_pekerjaan where id='$dt'"));
	 $namaPekerjaan = $getNamaPekerjaan['nama_pekerjaan'];
	 	
	 //items ----------------------
	  $this->form_fields = array(
			'namaPekerjaan' => array( 
						'label'=>'NAMA PEKERJAAN',
						'labelWidth'=>130, 
						'value'=>"<input type='text' name='namaPekerjaan' id='namaPekerjaan' value='$namaPekerjaan' style='width:210px;'>",
						 ),					
			
			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SaveEditJob();' title='Simpan' >   ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function newSatuanSatuan($dt){	
	 global $SensusTmp;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form2';				
	 $this->form_width = 400;
	 $this->form_height = 80;
	 $this->form_caption = 'SATUAN BARU';
	 
	 	
	 //items ----------------------
	  $this->form_fields = array(
			'' => array( 
						'label'=>'NAMA SATUAN',
						'labelWidth'=>130, 
						'value'=>"<input type='text' name='namaSatuan' id='namaSatuan' style='width:210px;'>",
						 ),					
			
			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SaveSatuanSatuan();' title='Simpan' >   ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function newSatuanVolume($dt){	
	 global $SensusTmp;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form2';				
	 $this->form_width = 400;
	 $this->form_height = 80;
	 $this->form_caption = 'SATUAN BARU';
	 
	 	
	 //items ----------------------
	  $this->form_fields = array(
			'' => array( 
						'label'=>'NAMA SATUAN',
						'labelWidth'=>130, 
						'value'=>"<input type='text' name='namaSatuan' id='namaSatuan' style='width:210px;'>",
						 ),					
			
			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SaveSatuanVolume();' title='Simpan' >   ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function formAlokasi($dt){	
	 global $SensusTmp;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 600;
	 $this->form_height = 430;
	 $this->form_caption = 'ALOKASI KAS';
	 $jumlahHargaForm = $dt;
	 $arrayJenisAlokasi = array(
	 							array('BULANAN','BULANAN'),
								array('TRIWULAN','TRIWULAN')
						  );
	$arrayJenisPerhitungan = array(
	 							array('SEMI OTOMATIS','SEMI OTOMATIS'),
								array('MANUAL','MANUAL')
						  );
						  
	 $username = $_COOKIE['coID'];
	 $getAlokasi = sqlArray(sqlQuery("select * from temp_alokasi_rka_v2 where user='$username'"));
	 foreach ($getAlokasi as $key => $value) { 
				  $$key = $value; 
			}
	 $jenisAlokasi = $jenis_alokasi_kas;	
	 $resultPenjumlahan = $jan + $feb + $mar + $apr + $mei + $jun + $jul + $agu + $sep + $okt + $nop + $des;
	 $selisih = $jumlahHargaForm - $resultPenjumlahan;	
	 if($jenisAlokasi == "TRIWULAN"){
	 	$readOnly = "readOnly";
	 }			  
	 if(empty($jenisPerhitungan))$jenisPerhitungan = "MANUAL";
	 if(empty($jan))$jan="0";
	 if(empty($feb))$feb="0";
	 if(empty($mar))$mar="0";
	 if(empty($apr))$apr="0";
	 if(empty($mei))$mei="0";
	 if(empty($jun))$jun="0";
	 if(empty($jul))$jul="0";
	 if(empty($agu))$agu="0";
	 if(empty($sep))$sep="0";
	 if(empty($okt))$okt="0";
	 if(empty($nop))$nop="0";
	 if(empty($des))$des="0";	
	 $cmbJenisAlokasi = cmbArray('jenisAlokasi','BULANAN',$arrayJenisAlokasi,'-- JENIS ALOKASI --',"onchange=$this->Prefix.jenisAlokasiChanged();") ;
	 $cmbJenisPerhitungan = cmbArray('jenisPerhitungan',$jenisPerhitungan,$arrayJenisPerhitungan,'-- JENIS PERHITUNGAN --',"onchange=$this->Prefix.jenisPerhitunganChanged();") ;
	 //items ----------------------
	  $this->form_fields = array(
			'1' => array( 
						'label'=>'JUMLAH HARGA',
						'labelWidth'=>150, 
						'value'=>"<input type='hidden' name='jumlahHargaForm' id ='jumlahHargaForm'  value='$jumlahHargaForm'> <input type='text' value='Rp. ".number_format($jumlahHargaForm,2,',','.')."' readonly style='width:210px;'>",
						 ),
			'2' => array( 
						'label'=>'JENIS ALOKASI',
						'labelWidth'=>150, 
						'value'=>$cmbJenisAlokasi,
						 ),
			'3' => array( 
						'label'=>'SISTEM PERHITUNGAN',
						'labelWidth'=>150, 
						'value'=>$cmbJenisPerhitungan." &nbsp <button type='button' id='buttonHitung' onclick='$this->Prefix.hitung();' disabled >HITUNG</button> ",
						 ),
			'4' => array( 
						'label'=>'JANUARI',
						'labelWidth'=>150, 
						'value'=> "<input type='text' name='jan' id='jan' $readOnly onkeypress='return event.charCode >= 48 && event.charCode <= 57' value='$jan' onkeyup=$this->Prefix.hitungSelisih('bantuJan'); > &nbsp <span id='bantuJan' style='color:red;'>".number_format($jan ,2,',','.')."</span> ",
						
						 ),	
			'5' => array( 
						'label'=>'FEBRUARI',
						'labelWidth'=>150, 
						'value'=> "<input type='text' name='feb' id='feb' $readOnly onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$feb' onkeyup=$this->Prefix.hitungSelisih('bantuFeb'); > &nbsp <span id='bantuFeb' style='color:red;'>".number_format($feb ,2,',','.')."</span> ",
						
						 ),
			'6' => array( 
						'label'=>'MARET',
						'labelWidth'=>150, 
						'value'=> "<input type='text' name='mar' id='mar' onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$mar' onkeyup=$this->Prefix.hitungSelisih('bantuMar');> &nbsp <span id='bantuMar' style='color:red;'>".number_format($mar ,2,',','.')."</span> ",
						
						 ),
			'7' => array( 
						'label'=>'APRIL',
						'labelWidth'=>150, 
						'value'=> "<input type='text' name='apr' id='apr' $readOnly onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$apr' onkeyup=$this->Prefix.hitungSelisih('bantuApr');> &nbsp <span id='bantuApr' style='color:red;'>".number_format($apr ,2,',','.')."</span> ",
						
						 ),
			'22' => array( 
						'label'=>'MEI',
						'labelWidth'=>150, 
						'value'=> "<input type='text' name='mei' id='mei' $readOnly onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$mei' onkeyup=$this->Prefix.hitungSelisih('bantuMei');> &nbsp <span id='bantuMei' style='color:red;'>".number_format($mei ,2,',','.')."</span> ",
						
						 ),
			'8' => array( 
						'label'=>'JUNI',
						'labelWidth'=>150, 
						'value'=> "<input type='text' name='jun' id='jun' onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$jun' onkeyup=$this->Prefix.hitungSelisih('bantuJun');> &nbsp <span id='bantuJun' style='color:red;'>".number_format($jun ,2,',','.')."</span> ",
						
						 ),
			'9' => array( 
						'label'=>'JULI',
						'labelWidth'=>150, 
						'value'=> "<input type='text' name='jul' id='jul' $readOnly onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$jul' onkeyup=$this->Prefix.hitungSelisih('bantuJul');> &nbsp <span id='bantuJul' style='color:red;'>".number_format($jul,2,',','.')."</span> ",
						
						 ),
			'10' => array( 
						'label'=>'AGUSTUS',
						'labelWidth'=>150, 
						'value'=> "<input type='text' name='agu' id='agu' $readOnly onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$agu' onkeyup=$this->Prefix.hitungSelisih('bantuAgu');> &nbsp <span id='bantuAgu' style='color:red;'>".number_format($agu ,2,',','.')."</span> ",
						
						 ),
						 
			'11' => array( 
						'label'=>'SEPTEMBER',
						'labelWidth'=>150, 
						'value'=> "<input type='text' name='sep' id='sep'  onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$sep' onkeyup=$this->Prefix.hitungSelisih('bantuSep');> &nbsp <span id='bantuSep' style='color:red;'>".number_format($sep ,2,',','.')."</span> ",
						
						 ),	
			'12' => array( 
						'label'=>'OKTOBER',
						'labelWidth'=>150, 
						'value'=> "<input type='text' name='okt' id='okt' $readOnly onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$okt' onkeyup=$this->Prefix.hitungSelisih('bantuOkt');> &nbsp <span id='bantuOkt' style='color:red;'>".number_format($okt ,2,',','.')."</span> ",
						
						 ),
			'13' => array( 
						'label'=>'NOPEMBER',
						'labelWidth'=>150, 
						'value'=> "<input type='text' name='nop' id='nop' $readOnly onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$nop' onkeyup=$this->Prefix.hitungSelisih('bantuNop');> &nbsp <span id='bantuNop' style='color:red;'>".number_format($nop ,2,',','.')."</span> ",
						
						 ),
			'14' => array( 
						'label'=>'DESEMBER',
						'labelWidth'=>150, 
						'value'=> "<input type='text' name='des' id='des' onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$des' onkeyup=$this->Prefix.hitungSelisih('bantuDes');> &nbsp <span id='bantuDes' style='color:red;'>".number_format($des ,2,',','.')."</span> ",
						
						 ),
			'15' => array( 
						'label'=>'JUMLAH HARGA ALOKASI',
						'labelWidth'=>150, 
						'value'=> "<input type='text' name='jumlahHargaAlokasi' id='jumlahHargaAlokasi' value='$resultPenjumlahan' readonly > &nbsp <span id='bantuPenjumlahan' style='color:red;'>".number_format($resultPenjumlahan ,2,',','.')."</span>",
						
						 ),
			'16' => array( 
						'label'=>'SELISIH (+/-)',
						'labelWidth'=>150, 
						'value'=> "<input type='text' name='selisih' id='selisih' value='$selisih' readonly > &nbsp <span id='bantuSelisih' style='color:red;'>".number_format($selisih ,2,',','.')."</span>",
						
						 ),					
			
			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SaveAlokasi();' title='Simpan' >   ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function formAlokasiTriwulan($dt){	
	 global $SensusTmp;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 600;
	 $this->form_height = 430;
	 $this->form_caption = 'ALOKASI KAS';
	 $jumlahHargaForm = $dt;
	 $arrayJenisAlokasi = array(
	 							array('BULANAN','BULANAN'),
								array('TRIWULAN','TRIWULAN')
						  );
	$arrayJenisPerhitungan = array(
	 							array('SEMI OTOMATIS','SEMI OTOMATIS'),
								array('MANUAL','MANUAL')
						  );
						  
	 $username = $_COOKIE['coID'];
	 $getAlokasi = sqlArray(sqlQuery("select * from temp_alokasi_rka_v2 where user='$username'"));
	 foreach ($getAlokasi as $key => $value) { 
				  $$key = $value; 
			}
	 $jenisAlokasi = $jenis_alokasi_kas;	
	 $resultPenjumlahan = $jan + $feb + $mar + $apr + $mei + $jun + $jul + $agu + $sep + $okt + $nop + $des;
	 $selisih = $jumlahHargaForm - $resultPenjumlahan;	
	 if($jenisAlokasi == "TRIWULAN"){
	 	$readOnly = "readOnly";
	 }	
	 if(empty($jenisPerhitungan))$jenisPerhitungan = "MANUAL";
	 if(empty($jan))$jan="0";
	 if(empty($feb))$feb="0";
	 if(empty($mar))$mar="0";
	 if(empty($apr))$apr="0";
	 if(empty($mei))$mei="0";
	 if(empty($jun))$jun="0";
	 if(empty($jul))$jul="0";
	 if(empty($agu))$agu="0";
	 if(empty($sep))$sep="0";
	 if(empty($okt))$okt="0";
	 if(empty($nop))$nop="0";
	 if(empty($des))$des="0";			  
	 $cmbJenisAlokasi = cmbArray('jenisAlokasi','TRIWULAN',$arrayJenisAlokasi,'-- JENIS ALOKASI --',"onchange=$this->Prefix.jenisAlokasiChanged();") ;
	 $cmbJenisPerhitungan = cmbArray('jenisPerhitungan',$jenisPerhitungan,$arrayJenisPerhitungan,'-- JENIS PERHITUNGAN --',"onchange=$this->Prefix.jenisPerhitunganChanged();") ;
	 //items ----------------------
	  $this->form_fields = array(
			'1' => array( 
						'label'=>'JUMLAH HARGA',
						'labelWidth'=>150, 
						'value'=>"<input type='hidden' name='jumlahHargaForm' id ='jumlahHargaForm'  value='$jumlahHargaForm'> <input type='text' value='Rp. ".number_format($jumlahHargaForm,2,',','.')."' readonly style='width:210px;'>",
						 ),
			'2' => array( 
						'label'=>'JENIS ALOKASI',
						'labelWidth'=>150, 
						'value'=>$cmbJenisAlokasi,
						 ),
			'3' => array( 
						'label'=>'SISTEM PERHITUNGAN',
						'labelWidth'=>150, 
						'value'=>$cmbJenisPerhitungan." &nbsp <button type='button' id='buttonHitung' onclick='$this->Prefix.hitung();' disabled >HITUNG</button>  <input type='hidden' name='jan' id='jan'><input type='hidden' name='feb' id='feb'> <input type='hidden' name='apr' id='apr'> <input type='hidden' name='mei' id='mei'> <input type='hidden' name='jul' id='jul'> <input type='hidden' name='agu' id='agu'> <input type='hidden' name='okt' id='okt'> <input type='hidden' name='nop' id='nop'> ",
						 ),
			'6' => array( 
						'label'=>'TRIWULAN 1',
						'labelWidth'=>150, 
						'value'=> "<input type='text' name='mar' id='mar' onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$mar' onkeyup=$this->Prefix.hitungSelisih('bantuMar');> &nbsp <span id='bantuMar' style='color:red;'>".number_format($mar ,2,',','.')."</span> ",
						
						 ),
			'8' => array( 
						'label'=>'TRIWULAN 2',
						'labelWidth'=>150, 
						'value'=> "<input type='text' name='jun' id='jun' onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$jun' onkeyup=$this->Prefix.hitungSelisih('bantuJun');> &nbsp <span id='bantuJun' style='color:red;'>".number_format($jun ,2,',','.')."</span> ",
						
						 ),
			'11' => array( 
						'label'=>'TRIWULAN 3',
						'labelWidth'=>150, 
						'value'=> "<input type='text' name='sep' id='sep'  onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$sep' onkeyup=$this->Prefix.hitungSelisih('bantuSep');> &nbsp <span id='bantuSep' style='color:red;'>".number_format($sep ,2,',','.')."</span> ",
						
						 ),	
			'14' => array( 
						'label'=>'TRIWULAN 4',
						'labelWidth'=>150, 
						'value'=> "<input type='text' name='des' id='des' onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$des' onkeyup=$this->Prefix.hitungSelisih('bantuDes');> &nbsp <span id='bantuDes' style='color:red;'>".number_format($des ,2,',','.')."</span> ",
						
						 ),
			'15' => array( 
						'label'=>'JUMLAH HARGA ALOKASI',
						'labelWidth'=>150, 
						'value'=> "<input type='text' name='jumlahHargaAlokasi' id='jumlahHargaAlokasi' value='$resultPenjumlahan' readonly > &nbsp <span id='bantuPenjumlahan' style='color:red;'>".number_format($resultPenjumlahan ,2,',','.')."</span>",
						
						 ),
			'16' => array( 
						'label'=>'SELISIH (+/-)',
						'labelWidth'=>150, 
						'value'=> "<input type='text' name='selisih' id='selisih' value='$selisih' readonly > &nbsp <span id='bantuSelisih' style='color:red;'>".number_format($selisih ,2,',','.')."</span>",
						
						 ),					
			
			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SaveAlokasi();' title='Simpan' >   ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	
	function formRincianVolume($dt){	
	 global $SensusTmp;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 400;
	 $this->form_height = 230;
	 $this->form_caption = 'RINCIAN VOLUME';
	 $jumlahHargaForm = $dt;
	 $username =$_COOKIE['coID'];
	 $getRincianVolume = sqlArray(sqlQuery("select * from temp_rincian_volume_v2 where user ='$username'"));
	 foreach ($getRincianVolume as $key => $value) { 
				  $$key = $value; 
		}
	 $codeAndSatuanSatuan = "select satuan_rekening, satuan_rekening  from ref_satuan_rekening where type='satuan'";
	 $cmbSatuanSatuan1 = cmbQuery('satuanSatuan1',$satuan1,$codeAndSatuanSatuan,'','-- SATUAN --');
	 
	 $codeAndSatuanSatuan = "select satuan_rekening, satuan_rekening  from ref_satuan_rekening where type='satuan'";
	 $cmbSatuanSatuan2 = cmbQuery('satuanSatuan2',$satuan2,$codeAndSatuanSatuan,'','-- SATUAN --');
	 
	 $codeAndSatuanSatuan = "select satuan_rekening, satuan_rekening  from ref_satuan_rekening where type='satuan'";
	 $cmbSatuanSatuan3 = cmbQuery('satuanSatuan3',$satuan3,$codeAndSatuanSatuan,'','-- SATUAN --');
	 
	 $codeAndSatuanVolume = "select satuan_rekening, satuan_rekening  from ref_satuan_rekening where type='volume'";
	 $cmbSatuanVolume = cmbQuery('satuanVolume',$satuan_total,$codeAndSatuanVolume,'','-- SATUAN --');
	 
	 if($jumlah3 == 0 && $satuan3 == ""){
	 	$totalResult = $jumlah1 * $jumlah2 ;	
		$jumlah3 = "";	
	 }else{
	 	$totalResult = $jumlah1 * $jumlah2 * $jumlah3 ;		
	 }
	 		  
	
	 //items ----------------------
	  $this->form_fields = array(
			array( 		'label' => '',
						'labelWidth' => 1,
						'pemisah' => ' ',
						'value'=>"<input type='hidden' id='volumeRek' value='$dt'>  <input type='text' id='jumlah1' value='$jumlah1' onkeyup='$this->Prefix.setTotalRincian();'  onkeypress='return event.charCode >= 48 && event.charCode <= 57' placeholder='JUMLAH'> &nbsp &nbsp ".$cmbSatuanSatuan1. " &nbsp &nbsp <button type='button' onclick='$this->Prefix.newSatuanSatuan();'>Baru</button>",
						 ),
			array( 		'label' => '',
						'labelWidth' => 1,
						'pemisah' => ' ',
						'value'=>"KALI (X)",
						 ),
			array( 		'label' => '',
						'labelWidth' => 1,
						'pemisah' => ' ',
						'value'=>"<input type='text' id='jumlah2' placeholder='JUMLAH' value='$jumlah2' onkeyup='$this->Prefix.setTotalRincian();'  onkeypress='return event.charCode >= 48 && event.charCode <= 57'> &nbsp &nbsp ".$cmbSatuanSatuan2. " ",
						 ),
			array( 		'label' => '',
						'labelWidth' => 1,
						'pemisah' => ' ',
						'value'=>"KALI (X)",
						 ),
			array( 		'label' => '',
						'labelWidth' => 1,
						'pemisah' => ' ',
						'value'=>"<input type='text' id='jumlah3' placeholder='JUMLAH' value='$jumlah3' onkeyup='$this->Prefix.setTotalRincian();'  onkeypress='return event.charCode >= 48 && event.charCode <= 57'> &nbsp &nbsp ".$cmbSatuanSatuan3. " ",
						 ),
			array( 		'label' => '',
						'labelWidth' => 1,
						'pemisah' => ' ',
						'value'=>"KALI (X)",
						 ),
			array( 		'label' => '',
						'labelWidth' => 1,
						'pemisah' => ' ',
						'value'=>"<input type='text' value='$totalResult' placeholder='JUMLAH' id='jumlah4' readonly > &nbsp &nbsp ".$cmbSatuanVolume. " &nbsp &nbsp <button type='button' onclick='$this->Prefix.newSatuanVolume();'>Baru</button>",
						 ),
			
			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SaveRincianVolume();' title='Simpan' >   ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	
	function newSatuan($dt){	
	 global $SensusTmp;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 400;
	 $this->form_height = 80;
	 $this->form_caption = 'SATUAN BARU';
	 
	 	
	 //items ----------------------
	  $this->form_fields = array(
			'satuan' => array( 
						'label'=>'SATUAN',
						'labelWidth'=>130, 
						'value'=>"<input type='text' name='namaSatuan' id='namaSatuan' style='width:210px;'>",
						 ),					
			
			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SaveSatuan();' title='Simpan' >   ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function genDaftarOpsi(){
	 global $Ref, $Main, $HTTP_COOKIE_VARS;
	$nomorUrutSebelumnya = $this->nomorUrut -1;
	$ID_RKA = $_REQUEST['ID_RKA'];
	$concatSKPD = $_REQUEST['concatSKPD'];
	$concatSKPD = explode('.',$concatSKPD);
	$c1 = $concatSKPD[0];
	$c = $concatSKPD[1];
	$d = $concatSKPD[2];
	$e = $concatSKPD[3];
	$e1 = $concatSKPD[4];
	$selectedC1 = $c1;
	$selectedC = $c;
	$selectedD = $d;
	$selectedE = $e;
	$selectedE1 = $e1;
	$selectedBK = $concatSKPD[5];
	$selectedCK = $concatSKPD[6];
	$selectedP = $concatSKPD[7];
	$selectedQ = $concatSKPD[8];
	foreach ($_REQUEST as $key => $value) { 
				 	 	$$key = $value; 

				 }

	
	$tujuan = "Simpan()";

	$arrayNameUrusan = sqlArray(sqlQuery("select * from ref_skpd where c1 ='$c1' and c='00' and d='00' and e='00' and e1='000'"));
	$namaUrusan = $arrayNameUrusan['nm_skpd'];
	
	$arrayNameBidang = sqlArray(sqlQuery("select * from ref_skpd where c1 ='$c1' and c='$c' and d='00' and e='00' and e1='000'"));
	$namaBidang = $arrayNameBidang['nm_skpd'];
	
	$arrayNameSKPD = sqlArray(sqlQuery("select * from ref_skpd where c1 ='$c1' and c='$c' and d='$d' and e='00' and e1='000'"));
	$namaSKPD = $arrayNameSKPD['nm_skpd'];
	
	$arrayNameUNIT = sqlArray(sqlQuery("select * from ref_skpd where c1 ='$c1' and c='$c' and d='$d' and e='$e' and e1='000'"));
	$namaUnit = $arrayNameSKPD['nm_skpd'];
	
	$arrayNameSUBUNIT = sqlArray(sqlQuery("select * from ref_skpd where c1 ='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
	$namaSubUnit = $arrayNameSKPD['nm_skpd'];
	
	$arrayNameProgram = sqlArray(sqlQuery("select * from ref_program where bk='$bk' and ck='$ck' and dk='0' and p='$p' and q='0' "));
	$program = $arrayNameProgram['nama'];
	
	$arrayNameKegiatan = sqlArray(sqlQuery("select * from ref_program where bk='$bk' and ck='$ck' and dk='0' and p='$p' and q='$q' "));
	$kegiatan = $arrayNameKegiatan['nama'];
	
	$arrayNameRincianPerhitungan = sqlArray(sqlQuery("select * from ref_barang where  f='$f' and g='$g' and h='$h' and i='$i' and j='$j'"));
	$rincianPerhitungan = $arrayNameRincianPerhitungan['nm_barang'];	
	
	
	$codeAndNameProgram = sqlQuery("select tabel_anggaran.bk, tabel_anggaran.ck, tabel_anggaran.p, tabel_anggaran.q, ref_program.nama from tabel_anggaran  inner join ref_program on tabel_anggaran.bk = ref_program.bk and tabel_anggaran.ck = ref_program.ck and tabel_anggaran.p = ref_program.p and tabel_anggaran.q = ref_program.q  inner join ref_tahap_anggaran on tabel_anggaran.id_tahap = ref_tahap_anggaran.id_tahap where tabel_anggaran.dk='0' and ref_tahap_anggaran.no_urut = '$nomorUrutSebelumnya' and tabel_anggaran.tahun ='$this->tahun' and tabel_anggaran.jenis_anggaran = '$this->jenisAnggaran' and tabel_anggaran.c1 = '$selectedC1' and tabel_anggaran.c = '$selectedC' and tabel_anggaran.d = '$selectedD'  and tabel_anggaran.q='0'  ");
	$pSama = "";
	$arrayP = array() ;
	while($rows = sqlArray($codeAndNameProgram)){
		foreach ($rows as $key => $value) { 
				  $$key = $value; 
		}
			$concat = $bk.".".$ck.".".$p ;
			if($concat != ".."){
				if($concat == $pSama){		
				}else{
					array_push($arrayP,
				 	  array($concat,$nama  )
					);
				}
			}
		$pSama = $concat;		
	}
	
	$program = "<input type='hidden' id='bk' name='bk' value='$selectedBK'> <input type='hidden' id='ck' name='ck' value='$selectedCK'> <input type='hidden' id='hiddenP' name='hiddenP' value='$selectedP'>".cmbArray('p',$selectedBK.".".$selectedCK.".".$selectedP,$arrayP,'-- PROGRAM --',"onchange=$this->Prefix.programChanged(); disabled");
	
	$codeAndNameKegiatan = sqlQuery("select tabel_anggaran.bk, tabel_anggaran.ck, tabel_anggaran.p, tabel_anggaran.q, ref_program.nama from tabel_anggaran  inner join ref_program on tabel_anggaran.bk = ref_program.bk and tabel_anggaran.ck = ref_program.ck and tabel_anggaran.p = ref_program.p and tabel_anggaran.q = ref_program.q  inner join ref_tahap_anggaran on tabel_anggaran.id_tahap = ref_tahap_anggaran.id_tahap where tabel_anggaran.dk='0' and ref_tahap_anggaran.no_urut = '$nomorUrutSebelumnya' and tabel_anggaran.tahun ='$this->tahun' and tabel_anggaran.jenis_anggaran = '$this->jenisAnggaran' and tabel_anggaran.c1 = '$selectedC1' and tabel_anggaran.c = '$selectedC' and tabel_anggaran.d = '$selectedD'  and tabel_anggaran.q !='0' and tabel_anggaran.bk='$selectedBK' and tabel_anggaran.ck='$selectedCK' and tabel_anggaran.p='$selectedP'  ");
	$qSama = "";
	$arrayQ = array() ;
	while($rows = sqlArray($codeAndNameKegiatan)){
		foreach ($rows as $key => $value) { 
				  $$key = $value; 
		}
		if($q != 0) {
			if($q == $qSama){		
			}else{
				array_push($arrayQ,
				   array($q,$nama)
				);
			}
		}

		$qSama = $q;		
	}
	
	$kegiatan = cmbArray('q',$selectedQ,$arrayQ,'-- KEGIATAN --',"onchange=$this->Prefix.refreshList(true); disabled");
	
	$volumeBarang = $volume_barang;
	$kodeBarang = $f.".".$g.".".$h.".".$i.".".$j ;
	$codeAndNamePekerjaan = "select id, nama_pekerjaan from ref_pekerjaan2 ";
	$cmbPekerjaan = cmbQuery('o1', $o1, $codeAndNamePekerjaan," onchange=$this->Prefix.setNoUrut(); ",'-- PEKERJAAN --');
	
	$codeAndNameSatuanRekening = "select satuan_rekening, satuan_rekening from ref_satuan_rekening where type='volume'";
	$cmbSatuan = cmbQuery('satuan', $satuan, $codeAndNameSatuanRekening,' ','-- SATUAN --');
	  
	$filterSKPD = $c1.".".$c.".".$d.".".$e.".".$e1;
	if($this->statusForm != "EDIT"){
		$finish = "<tr valign='middle' align='center'> 
					<td class='border:none'> 
						<a class='toolbar' id='finish' href='javascript:formRkaSkpd221_v2.finish()'> 
						<img src='images/administrator/images/checkin.png' alt='BATAL' name='BATAL' width='32' height='32' border='0' align='middle' title='SIMPAN'> SELESAI</a> 
					</td> 
					</tr> 
					</tbody>";
			
	}else{
		$readonly = "readonly";
		$pemicu = "<button type='button'  onclick='$this->Prefix.detailVolume();' id='pemicuDetailVolume'>Detail Volume</button>
												<input type='hidden' name='statusDetail' id ='statusDetail'>";
	}
	$TampilOpt =
			
			
	$vOrder=
			genFilterBar(
				array(
					$this->isiform(
						array(
							array(
								'label'=>'URUSAN',
								'name'=>'urusan',
								'label-width'=>'200px;',
								'type'=>'text',
								'value'=>$c1.". ".$namaUrusan,
								'align'=>'left',
								'parrams'=>"style='width:600px;' readonly",
							),
							array(
								'label'=>'BIDANG',
								'name'=>'bidang',
								'label-width'=>'200px;',
								'type'=>'text',
								'value'=>$c.'. '.$namaBidang,
								'align'=>'left',
								'parrams'=>"style='width:600px;' readonly",
							),
							array(
								'label'=>'SKPD',
								'name'=>'skpd',
								'label-width'=>'200px;',
								'type'=>'text',
								'value'=>$d.'. '.$namaSKPD,
								'align'=>'left',
								'parrams'=>"style='width:600px;' readonly",
							),
							/*array(
								'label'=>'UNIT',
								'name'=>'unit',
								'label-width'=>'200px;',
								'type'=>'text',
								'value'=>$e.'. '.$namaUnit,
								'align'=>'left',
								'parrams'=>"style='width:600px;' readonly",
							),
							array(
								'label'=>'SUB UNIT',
								'name'=>'subunit',
								'label-width'=>'200px;',
								'type'=>'text',
								'value'=>$e1.'. '.$namaSubUnit,
								'align'=>'left',
								'parrams'=>"style='width:600px;' readonly",
							),*/
							
						)
					)
				
				),'','','').
				genFilterBar(
				array(
					$this->isiform(
						array(
							
							array( 
								'label'=>'PROGRAM',
								'label-width'=>'200px;',
								'value'=>$program				
							),
							array( 
								'label'=>'KEGIATAN',
								'label-width'=>'200px;',
								'value'=>$kegiatan	
							),
						)
					)
				
				),'','','').	
				genFilterBar(
				array(
					$this->isiform(
						array(
							
							array(
									'label'=>'KODE REKENING',
									'label-width'=>'200px;',
									'value'=>"<input type='text' name='kodeRekening'  id='kodeRekening' placeholder='KODE' style='width:80px;' value='".$dt['kodeRekening']."' readonly /> 
										<input type='text' name='namaRekening' id='namaRekening' placeholder='NAMA REKENING' style='width:520px;' readonly value='".$dt['nm_rekening']."' />
										<button type='button' id='findRekening' onclick=$this->Prefix.findRekening('2.2.1'); > Cari </button>
									",
								),
							array( 
									'label'=>'RINCIAN PERHITUNGAN',
									'label-width'=>'200px;',
								    'value' => "<input type='hidden' id='kodeBarang' value='$kodeBarang'>  <input style='width:600px;' placeholder='RINCIAN PERHITUNGAN'  type='text' name='rincianPerhitungan' id='rincianPerhitungan'  >"
									
								),
							array( 
									'label'=>'VOLUME',
									'label-width'=>'200px;',
								    'value' => "<input style='width:60px; text-align:right;' placeholder='VOLUME' $readonly type='text' name='volumeBarang' id='volumeBarang' value='$volumeBarang' onkeypress='return event.charCode >= 48 && event.charCode <= 57' onkeyup='$this->Prefix.resetRincian();'>  &nbsp  $pemicu
												"
									
								),
							array(
									'label'=>'SATUAN',
									'label-width'=>'200px;',
									'value'=>$cmbSatuan."&nbsp <button type='button' onclick='$this->Prefix.newSatuan();'>Baru</button>
									",
								),
							array(
									'label'=>'HARGA SATUAN',
									'label-width'=>'200px;',
									'value'=> "<input style='width:200px;' placeholder='HARGA SATUAN' onkeypress='return event.charCode >= 48 && event.charCode <= 57' onkeyup='$this->Prefix.bantu();' type='text' name='hargaSatuan' id='hargaSatuan' value='$hargaSatuan' > <input type='hidden' id='teralokasi'> &nbsp <button type='button' onclick='$this->Prefix.setSatuanHarga();'>SSH</button> &nbsp <span id='bantuSatuanHarga' style='color:red;'></span>"
								
								),
							array(
									'label'=>'JUMLAH HARGA',
									'label-width'=>'200px;',
									'value'=> "<input style='width:200px;' placeholder='JUMLAH HARGA' type='text' name='jumlahHarga' id='jumlahHarga' value='$jumlahHarga' readonly>  &nbsp <span id='bantuJumlahHarga' style='color:red;'></span>"
								
								),
						)
					)
				
				),'','','').
				"<div id='tbl_pemeliharaan' style='width:100%;'></div>".
				genFilterBar(
					array(
					"
						<input type='hidden' name='".$this->Prefix."_idplh' id='".$this->Prefix."_idplh' value='$idplhnya' />
					<input type='hidden' name='refid_terimanya' id='refid_terimanya' value='".$dt['Id']."' />
					<input type='hidden' name='FMST_penerimaan_det' id='FMST_penerimaan_det' value='".$dt['FMST_penerimaan_det']."' />
					<table>
						<tr>
							<td><table cellpadding='0' cellspacing='0' border='0' id='toolbar'>
					<tbody><tr valign='middle' align='center'> 
					<td class='border:none'> 
						<a class='toolbar' id='btsave' href='javascript:formRkaSkpd221_v2.$tujuan'> 
						<img src='images/administrator/images/save_f2.png' alt='BATAL' name='BATAL' width='32' height='32' border='0' align='middle' title='SIMPAN'> SIMPAN</a> 
					</td> 
					</tr> 
					</tbody></table></td>
							<td><table cellpadding='0' cellspacing='0' border='0' id='toolbar'>
					<tbody><tr valign='middle' align='center'> 
					<td class='border:none'> 
						<a class='toolbar' id='btcancel' href='javascript:formRkaSkpd221_v2.closeTab()'> 
						<img src='images/administrator/images/cancel_f2.png' alt='BATAL' name='BATAL' width='32' height='32' border='0' align='middle' title='SIMPAN'> BATAL</a> 
					</td> 
					</tr> 
					</tbody></table></td>
							<td><table cellpadding='0' cellspacing='0' border='0' id='toolbar'>
					<tbody>
					".$finish."</table></td>
							
						</tr>".
					"</table>"
				
					
					
				),'','','')
							
			;
			
			
		return array('TampilOpt'=>$TampilOpt);
	}
	
	
	
	function isiform($value){
		$isinya = '';
		$tbl ='<table width="100%">';
		for($i=0;$i<count($value);$i++){
			if(!isset($value[$i]['align']))$value[$i]['align'] = "left";
			if(!isset($value[$i]['valign']))$value[$i]['valign'] = "top";
			
			if(isset($value[$i]['type'])){
				switch ($value[$i]['type']){
					case "text" :
						$isinya = "<input type='text' name='".$value[$i]['name']."' id='".$value[$i]['name']."' ".$value[$i]['parrams']." value='".$value[$i]['value']."' />";
					break;
					case "hidden" :
						$isinya = "<input type='hidden' name='".$value[$i]['name']."' id='".$value[$i]['name']."' ".$value[$i]['parrams']." value='".$value[$i]['value']."' />";
					break;
					case "password" :
						$isinya = "<input type='password' name='".$value[$i]['name']."' id='".$value[$i]['name']."' ".$value[$i]['parrams']." value='".$value[$i]['value']."' />";
					break;
					default:
						$isinya = $value[$i]['value'];
					break;					
				}
			}else{
				$isinya = $value[$i]['value'];
			}
			
			$tbl .= "
				<tr>
					<td width='".$value[$i]['label-width']."' valign='top'>".$value[$i]['label']."</td>
					<td width='10px' valign='top'>:<br></td>
					<td align='".$value[$i]['align']."' valign='".$value[$i]['valign']."'> $isinya</td>
				</tr>
			";		
		}
		$tbl .= '</table>';
		
		return $tbl;
	}
	
				
	
	
	
	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID']; 
		//kondisi -----------------------------------
		$username = $_COOKIE['coID'];		
		$arrKondisi = array();		
		$username = $_COOKIE['coID'];
		$getAll = sqlQuery("select * from temp_rka_221_v2 where rincian_perhitungan ='' and f='00' and user = '$username' and o1!='0'");
		while($rows = sqlArray($getAll)){
			foreach ($rows as $key => $value) { 
				 	 	$$key = $value; 
			}
			if(sqlNumRow(sqlQuery("select * from temp_rka_221_v2 where user ='$username' and (rincian_perhitungan !='' or f!='00' ) and o1='$o1' and delete_status = '0'")) == 0){
				sqlQuery("delete from temp_rka_221_v2 where id='$id'");			
			}else{
				
			}
		}
		
		
			
		$arrKondisi[] = "user  = '$username'";
		$arrKondisi[] = "delete_status  = '0'";
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();

		$Order= join(',',$arrOrders);	
		$OrderDefault = '';// Order By no_terima desc ';
		$Order =  $Order ==''? $OrderDefault : ' Order By '.$Order;
		
		
		return array('Kondisi'=>$Kondisi, 'Order'=>$Order ,'Limit'=>$Limit, 'NoAwal'=>$NoAwal);
		
	}
	

function genForm2($withForm=TRUE){	
		$form_name = $this->Prefix.'_form';	
				
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
		return $form;
	}	
	

	
	
	
	
	
}
$formRkaSkpd221_v2 = new formRkaSkpd221_v2Obj();

$arrayResult = VulnWalkerTahap_v2('RKA');
$jenisForm = $arrayResult['jenisForm'];
$nomorUrut = $arrayResult['nomorUrut'];
$tahun = $arrayResult['tahun'];
$jenisAnggaran = $arrayResult['jenisAnggaran'];
$idTahap = $arrayResult['idTahap'];




$formRkaSkpd221_v2->jenisForm = $jenisForm;
$formRkaSkpd221_v2->nomorUrut = $nomorUrut;
$formRkaSkpd221_v2->tahun = $tahun;
$formRkaSkpd221_v2->jenisAnggaran = $jenisAnggaran;
$formRkaSkpd221_v2->idTahap = $idTahap;
$formRkaSkpd221_v2->username = $_COOKIE['coID'];

$cekKondisi = sqlNumRow(sqlQuery("select * from temp_rka_221_v2 where user= '$formRkaSkpd221_v2->username' and j !='000'"));
if($cekKondisi != 0 ){
	$formRkaSkpd221_v2->statusForm = "EDIT";
}else{
	$formRkaSkpd221_v2->statusForm = "BARU";}
?>