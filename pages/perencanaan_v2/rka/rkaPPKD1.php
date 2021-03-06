<?php

class rkaPPKD1_v2Obj  extends DaftarObj2{	
	var $Prefix = 'rkaPPKD1_v2';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'view_rka_ppkd_1'; //bonus
	var $TblName_Hapus = 'tabel_anggaran';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('id_anggaran');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $checkbox_rowspan = 2;
	var $PageTitle = 'RKA-PPKD';
	var $PageIcon = 'images/masterData_01.gif';
	var $pagePerHal ='';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='rkaPPKD1_v2.xls';
	var $namaModulCetak='RKA';
	var $Cetak_Judul = 'RKA';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'rkaPPKD1_v2Form';
	var $modul = "RKA-PPKD";
	var $jenisForm = "";
	var $tahun = "";
	var $nomorUrut = "";
	var $jenisAnggaran = "";
	var $idTahap = "";
	var $currentTahap = "";
	var $namaTahapTerakhir = "";
	var $masaTerakhir = "";
	//buatview
	var $urutTerakhir = "";
	var $urutSebelumnya = "";
	var $jenisFormTerakhir = "";
	
	var $username = "";
	
	var $wajibValidasi = "";
	
	var $sqlValidasi = "";
	//buatview
	var $TampilFilterColapse = 0; //0
	
	var $publicVar = "";
	
	var $provinsi = "";
	var $kota = "";
	var $pengelolaBarang = "";
	var $pejabatPengelolaBarang = "";
	var $pengurusPengelolaBarang = "";
	var $nipPengelola = "";
	var $nipPejabat = "";
	var $nipPengurus ="";
	
	function setTitle(){
		return 'RKA-PPKD 1 '.$this->jenisAnggaran.' TAHUN '.$this->tahun;
	}
	function setMenuView(){
		return 			
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Laporan()","print_f2.png",'Laporan',"Laporan")."</td>";				
			
	}
	function setMenuEdit(){
	 	 $arrayResult = VulnWalkerTahap_v2('RKA');
		 $jenisForm = $arrayResult['jenisForm'];
		 $nomorUrut = $arrayResult['nomorUrut'];
		 $tahun = $arrayResult['tahun'];
		 $jenisAnggaran = $arrayResult['jenisAnggaran'];
		 $query = $arrayResult['query'];
	 if ($jenisForm == "PENYUSUNAN"){
	 	$listMenu = 
					"<td>".genPanelIcon("javascript:".$this->Prefix.".Gruping()","publishdata.png","Gruping ", 'Gruping ')."</td>".
					"<td>".genPanelIcon("javascript:".$this->Prefix.".Baru()","sections.png","Baru ", 'Baru ')."</td>".
					"<td>".genPanelIcon("javascript:".$this->Prefix.".Edit()","edit_f2.png","Edit", 'Edit')."</td>".
					"<td>".genPanelIcon("javascript:".$this->Prefix.".Remove()","delete_f2.png","Hapus", 'Hapus')."</td>".
					"<td>".genPanelIcon("javascript:".$this->Prefix.".Info()","info.png","Info", 'Info')."</td>"
					;	
	 }elseif ($jenisForm == "KOREKSI"){
	 	$listMenu = "<td>".genPanelIcon("javascript:".$this->Prefix.".Info()","info.png","Info", 'Info')."</td>";
	 }else{
	 	$listMenu = "<td>".genPanelIcon("javascript:".$this->Prefix.".Info()","info.png","Info", 'Info')."</td>";
	 }
	 
		return $listMenu ;
	}
	function genRowSum($ColStyle, $Mode, $Total){
		foreach ($_REQUEST as $key => $value) { 
		  	$$key = $value; 
		 } 
		 if($cmbSubUnit != ''){
			$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit'";
		if(!empty($hiddenP)){
				$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit' and bk='$bk' and ck='$ck' and p='$hiddenP'";
					if(!empty($q)){
				$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit' and bk='$bk' and ck='$ck' and p='$hiddenP' and q='$q'";
		}
		}						
		}elseif($cmbUnit != ''){
			$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' ";
		}elseif($cmbSKPD != ''){
			$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD'  ";
		}elseif($cmbBidang != ''){
			$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang'  ";
		}elseif($cmbUrusan != ''){
			$kondisiSKPD = "and c1='$cmbUrusan'";
		}
	 	/*if(!empty($cmbBelanja)){
				if($cmbBelanja == "BELANJA PEGAWAI"){
					$kondisiRekening = "and k='5' and l ='2' and m ='1'";
				}elseif($cmbBelanja == "BELANJA BELANJA BARANG & JASA"){
					$kondisiRekening = "and k='5' and l ='2' and m ='2'";
				}elseif($cmbBelanja == "BELANJA MODAL"){
					$kondisiRekening = "and k='5' and l ='2' and m ='3'";
				}
				
		}*/
		if ($this->jenisForm == "PENYUSUNAN" || $this->jenisForm == "KOREKSI" ){
			$idTahap = $this->idTahap;
		}else{
			$getIdTahapRKATerakhir = sqlArray(sqlQuery("select max(id_tahap) as max from tabel_anggaran where tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and jenis_rka !='' and o1 !='0' and (rincian_perhitungan !='' or f !='00' ) and nama_modul ='RKA-PPKD' "));
		 	$idTahap = $getIdTahapRKATerakhir['max'];
		}

		
		$getData = sqlArray(sqlQuery("select sum(jumlah_harga) from tabel_anggaran where  (rincian_perhitungan !='' or f !='00' ) and id_tahap='$idTahap' and tahun ='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and nama_modul ='RKA-PPKD' and jenis_rka = '1' $kondisiSKPD $kondisiRekening"));
		$Total = $getData['sum(jumlah_harga)'];
		
		$ContentTotalHal=''; $ContentTotal='';
			$TampilTotalHalRp = number_format($this->SumValue[0],2, ',', '.');
			$TotalColSpan1 = $this->FieldSum_Cp1[$Mode-1];//$Mode ==1 ? 5 : 4;
			$TotalColSpan2 = $this->FieldSum_Cp2[$Mode-1];//$Mode ==1 ? 5 : 4;	
			if($this->jenisForm == "PENYUSUNAN"){
				if($this->wajibValidasi == TRUE)$tergantung = "<td class='GarisDaftar'  align='center'></td>";
				$ContentTotal = 
				"<tr>
					<td class='$ColStyle' colspan='6' align='center'><b>Total</td>
					<td class='GarisDaftar' align='right'><b><div  id='{$this->Prefix}_cont_sum'>".number_format($Total,2,',','.')."</div></td>
					$tergantung
				</tr>" ;
			}elseif($this->jenisForm == "KOREKSI"){
				$urutSebelumnya = $this->nomorUrut - 1;
				$getRApbd = sqlArray(sqlQuery("select * from view_rka_ppkd_1 where no_urut = '$urutSebelumnya' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' "));
				if($getRApbd['jenis_form_modul'] != "PENYUSUNAN" && $getRApbd['jenis_form_modul'] != "KOREKSI"){
					$urutSebelumnya = $urutSebelumnya - 1;		
				}
				$getDataSebelumnya = sqlArray(sqlQuery("select sum(jumlah_harga) from view_rka_ppkd_1 where (rincian_perhitungan !='' or f !='00' ) and no_urut='$urutSebelumnya' and tahun ='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran'  $kondisiSKPD $kondisiRekening"));
		    	$TotalTahapSebelumnya = $getDataSebelumnya['sum(jumlah_harga)']; 
				$TotalBertambahBerkurang = $TotalTahapSebelumnya - $Total;
				if($TotalBertambahBerkurang   > 0){
					
					$TotalBertambahBerkurang= "( ". number_format($TotalBertambahBerkurang,2,',','.') ." )";
				}else{
					$TotalBertambahBerkurang = $Total  -  $TotalTahapSebelumnya;
					$TotalBertambahBerkurang = number_format($TotalBertambahBerkurang,2,',','.');
				}
				$ContentTotal = 
				"<tr>
					<td class='$ColStyle' colspan='5' align='center'><b>Total</td>
					<td class='GarisDaftar' align='right'><b><div  id='{$this->Prefix}_cont_sum'>".number_format($TotalTahapSebelumnya,2,',','.')."</div></td>
					<td class='GarisDaftar'  align='center' colspan='2'></td>
					<td class='GarisDaftar' align='right'><b><div  id='{$this->Prefix}_cont_sum'>".number_format($Total,2,',','.')."</div></td>
					<td class='GarisDaftar'  align='center' colspan='2'></td>
					<td class='GarisDaftar' align='right'><b><div  id='{$this->Prefix}_cont_sum'>".$TotalBertambahBerkurang."</div></td>
					<td class='GarisDaftar'  align='center'></td>
				</tr>" ;
			}else{
				if($this->wajibValidasi == TRUE)$tergantung = "<td class='GarisDaftar'  align='center'></td>";
				if($this->jenisFormTerakhir == "PENYUSUNAN"){
					$ContentTotal = 
					"<tr>
						<td class='$ColStyle' colspan='5' align='center'><b>Total</td>
						<td class='GarisDaftar' align='right'><b><div  id='{$this->Prefix}_cont_sum'>".number_format($Total,2,',','.')."</div></td>
						$tergantung
					</tr>" ;
				}elseif($this->jenisFormTerakhir == "KOREKSI"){
				$urutSebelumnya = $this->urutTerakhir - 1;
				$getRApbd = sqlArray(sqlQuery("select * from view_rka_ppkd_1 where no_urut = '$urutSebelumnya' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' "));
				if($getRApbd['jenis_form_modul'] != "PENYUSUNAN" && $getRApbd['jenis_form_modul'] != "KOREKSI"){
					$urutSebelumnya = $urutSebelumnya - 1;		
				}
				$getDataSebelumnya = sqlArray(sqlQuery("select sum(jumlah_harga) from view_rka_ppkd_1 where (rincian_perhitungan !='' or f !='00' ) and no_urut='$urutSebelumnya' and tahun ='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran'  $kondisiSKPD $kondisiRekening"));
		    	$TotalTahapSebelumnya = $getDataSebelumnya['sum(jumlah_harga)']; 
				$TotalBertambahBerkurang = $TotalTahapSebelumnya - $Total;
				if($TotalBertambahBerkurang   > 0){
					
					$TotalBertambahBerkurang= "( ". number_format($TotalBertambahBerkurang,2,',','.') ." )";
				}else{
					$TotalBertambahBerkurang = $Total  -  $TotalTahapSebelumnya;
					$TotalBertambahBerkurang = number_format($TotalBertambahBerkurang,2,',','.');
				}
				$ContentTotal = 
				"<tr>
					<td class='$ColStyle' colspan='5' align='center'><b>Total</td>
					<td class='GarisDaftar' align='right'><b><div  id='{$this->Prefix}_cont_sum'>".number_format($TotalTahapSebelumnya,2,',','.')."</div></td>
					<td class='GarisDaftar'  align='center' colspan='2'></td>
					<td class='GarisDaftar' align='right'><b><div  id='{$this->Prefix}_cont_sum'>".number_format($Total,2,',','.')."</div></td>
					<td class='GarisDaftar'  align='center' colspan='2'></td>
					<td class='GarisDaftar' align='right'><b><div  id='{$this->Prefix}_cont_sum'>".$TotalBertambahBerkurang."</div></td>
					<td class='GarisDaftar'  align='center'></td>
				</tr>" ;
			}
				
			}	

			

				
			if($Mode == 2){			
				$ContentTotal = '';
			}else if($Mode == 3){
				$ContentTotalHal='';			
			}
			
		return $ContentTotalHal.$ContentTotal;
	}
	function simpan(){
	 global $HTTP_COOKIE_VARS;
	 global $Main;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	//get data -----------------
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];

	 foreach ($_REQUEST as $key => $value) { 
		  $$key = $value; 
	 } 
	
	
	
	$user = $_COOKIE['coID'];
	$arrayKodeRekening = explode(".",$kodeRekening);
	$k = $arrayKodeRekening[0];
	$l = $arrayKodeRekening[1];
	$m = $arrayKodeRekening[2];
	$n = $arrayKodeRekening[3];
	$o = $arrayKodeRekening[4];
	
	$getJumlahBarang = sqlArray(sqlQuery("select * from tabel_anggaran where id_anggaran = '$rkaPPKD1_v2_idplh'"));
	$jumlahBarang = $getJumlahBarang['volume_barang'];
	$total = $hargaSatuan * $jumlahBarang;
	
	/* $getIdTahapRenjaTerakhir = sqlArray(sqlQuery("select max(id_tahap) as max from view_renja "));
  	 $idTahapRenja = $getIdTahapRenjaTerakhir['max'];
	$getPaguIndikatif = sqlArray(sqlQuery("select * from view_renja where c1= '$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and p='$p' and q='$q' and id_tahap = '$idTahapRenja' "));*/
	$getPaguYangTelahTerpakai = sqlArray(sqlQuery("select sum(jumlah_harga) as paguYangTerpakai from view_rka_ppkd_1 where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and p='$p' and q='$q' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'  and no_urut = '$this->nomorUrut' and id_anggaran!='$rkaPPKD1_v2_idplh' "));
	$sisaPaguIndikatif = $paguIndikatif - $getPaguYangTelahTerpakai['paguYangTerpakai'];
    
	 if(sqlNumRow(sqlQuery("select * from view_rka_ppkd_1 where c1='0' and f = '00' and k = '$k' and l ='$l' and m='$m' and n='$n' and o='$o'  and id_tahap='$this->idTahap' ")) > 0){
				 	
					}else{
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
											'tahun' => $this->tahun,
											'jenis_anggaran' => $this->jenisAnggaran,
											'id_tahap' => $this->idTahap,
											'nama_modul' => 'RKA-PPKD'
											);
						$queryRekening = VulnWalkerInsert('tabel_anggaran',$arrayRekening);
						sqlQuery($queryRekening);
					}
	 	
 	 if(empty($cmbJenisRKAForm) ){
	   	$err= 'Pilih Jenis RKA ';
	 }elseif(empty($kodeRekening)){
	 	$err = 'Pilih Rekening';
	 }elseif(empty($hargaSatuan) || $hargaSatuan == '0'){
	 	$err = 'Isi Harga Satuan';
	 }elseif($total > $sisaPaguIndikatif){
	 	$err = 'Tidak dapat Melebihi Pagu Indikatif';
	 }else{
	 	$data = array(
						'k' => $k,
						'l' => $l,
						'm' => $m,
						'n' => $n,
						'o' => $o,
						'satuan_rek' => $hargaSatuan,
						'jenis_rka' => $cmbJenisRKAForm,
						'jumlah_harga' => $total
							
					   );
		$query = VulnWalkerUpdate('tabel_anggaran',$data,"id_anggaran = '$rkaPPKD1_v2_idplh'");
		sqlQuery($query);
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
		
				case 'setGrup':{
				foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
			 	}
				
				
				if(sqlNumRow(sqlQuery("select * from tabel_anggaran where o1 = '$pekerjaan' and id_tahap = '$this->idTahap' and jenis_rka = '1' and nama_modul ='RKA-PPKD'")) == 0){
					$data = array(
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
												 'k' => '0',
												 'l' => '0',
												 'm' => '0',
												 'n' => '0',
												 'o' => '0',
												 'o1' => $pekerjaan,
												 'jenis_rka' => '1',
												 'tahun' => $this->tahun,
												 'jenis_anggaran' => $this->jenisAnggaran,
												 'id_tahap' => $this->idTahap,
												 'nama_modul' => 'RKA-PPKD'
													);	
					sqlQuery(VulnWalkerInsert('tabel_anggaran',$data));		
				}
				if(strpos($anggota, ',') !== false) {
				    $arrayRekening = explode(',',$anggota);
					$huge = sizeof($arrayRekening);
					
					for($i = 0 ; $i < $huge; $i++){
						
						$id_rekening =  $arrayRekening[$i];
						$getRekening = sqlArray(sqlQuery("select * from tabel_anggaran where id_anggaran = '$id_rekening'"));
						/*foreach ($getRekening as $key => $value) { 
						  $$key = $value; 
					 	}*/
						
						$data = array('o1' => $pekerjaan);
						$query = VulnWalkerUpdate('tabel_anggaran',$data," k='".$getRekening['k']."' and l='".$getRekening['l']."' and m='".$getRekening['m']."' and n='".$getRekening['n']."' and o='".$getRekening['o']."' and id_tahap = '$this->idTahap'");
						sqlQuery($query);
						
					}
				}else{
						$id_rekening =  $anggota;
						$getRekening = sqlArray(sqlQuery("select * from tabel_anggaran where id_anggaran = '$id_rekening'"));
						foreach ($getRekening as $key => $value) { 
						  $$key = $value; 
					 	}
						
						$data = array('o1' => $pekerjaan);
						$query = VulnWalkerUpdate('tabel_anggaran',$data," k='$k' and l='$l' and m='$m' and n='$n' and o='$o' and id_tahap = '$this->idTahap'");
						$content = "2";
						sqlQuery($query);
				}
				
				
				
				 								
		break;
		}
		case 'SaveEditJob':{
			$username = $_COOKIE['coID'];
	    	foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
			 } 
			
			 $getMaxLeftUrut = sqlArray(sqlQuery("select left_urut  from ref_pekerjaan where  id ='$o1'"));
			 $left_urut = $getMaxLeftUrut['left_urut'];
			 
			 $data = array( 'nama_pekerjaan' => $namaPekerjaan
							
			 				);
			 $query = VulnWalkerUpdate("ref_pekerjaan",$data,"id = '$pekerjaan'");
			 
			 if(empty($namaPekerjaan)){
			 	$err = "input gagal";
			 }else{
				$execute = sqlQuery($query);
			 }
			$codeAndNamePekerjaan = "select id, nama_pekerjaan from ref_pekerjaan  ";
			$getCurrentInsert = sqlArray(sqlQuery("select max(id) from ref_pekerjaan "));
			$cmbPekerjaan = cmbQuery('pekerjaan', $getCurrentInsert['max(id)'], $codeAndNamePekerjaan,"  ",'-- PEKERJAAN --');
			
			$getUrut = sqlArray(sqlQuery("select * from temp_rka_221_v2 where o1='$o1'"));
			$urut = $getUrut['urut'];
			
			$content = array('cmbPekerjaan' => $cmbPekerjaan, 'left_urut' => $left_urut, 'urut' => $urut, 'query' => "select left_urut , urut as urut from ref_pekerjaan where  id ='$o1'" );
		break;
	    }
		case 'editJob':{
				$dt = $_REQUEST['pekerjaan'];
				$fm = $this->editJob($dt);				
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];										
		break;
		}
		
		case 'Gruping':{	
			foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
			} 
			if(!isset($rkaPPKD1_v2_cb)){
				$err = "Pilih Data";
			}
			$dt = implode(',',$rkaPPKD1_v2_cb);
			if($this->jenisForm !='PENYUSUNAN')$err = "Tahap Penyusunan Telah Habis";
				 if($err == ''){
						$fm = $this->Gruping($dt);				
						$cek = $fm['cek'];
						$err = $fm['err'];
						$content = $fm['content'];
				 }			
															
		break;
		}
		
		case 'newJob':{
				$fm = $this->newJob($dt);				
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];										
		break;
		}
		case 'SaveJob':{
			$username = $_COOKIE['coID'];
	    	foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
			 } 
			
			 
			 $data = array( 'nama_pekerjaan' => $namaPekerjaan
			 				);
			 $query = VulnWalkerInsert("ref_pekerjaan",$data);
			 
			 if(empty($namaPekerjaan)){
			 	$err = "input gagal";
			 }else{
				$execute = sqlQuery($query);
			 }
			$codeAndNamePekerjaan = "select id, nama_pekerjaan from ref_pekerjaan ";
			$getCurrentInsert = sqlArray(sqlQuery("select max(id) from ref_pekerjaan"));
			$cmbPekerjaan = cmbQuery('pekerjaan', $getCurrentInsert['max(id)'], $codeAndNamePekerjaan,"  ",'-- PEKERJAAN --');
			$getMaxUrut = sqlArray(sqlQuery("select max(urut) from temp_rka_221_v2 where user ='$username'"));
			$urut = $getMaxUrut['max(urut)'] + 1;
			$content = array('cmbPekerjaan' => $cmbPekerjaan, 'left_urut' => $left_urut, 'urut' => $urut );
		break;
	    }
		case 'Report':{	
			foreach ($_REQUEST as $key => $value) { 
			 	 $$key = $value; 
			}
			
				if(sqlNumRow(sqlQuery("select * from skpd_report_rka_ppkd_1 where username= '$this->username'")) == 0){
					$data = array(
								  'username' => $this->username,
								  'c1' => $cmbUrusan,
								  'c' => $cmbBidang,
								  'd' => $cmbSKPD
								  
								  );
					$query = VulnWalkerInsert('skpd_report_rka_ppkd_1',$data);
					sqlQuery($query);
				}else{
					$data = array(
								  'username' => $this->username,
								  'c1' => $cmbUrusan,
								  'c' => $cmbBidang,
								  'd' => $cmbSKPD
								  
								  
								  );
					$query = VulnWalkerUpdate('skpd_report_rka_ppkd_1',$data,"username = '$this->username'");
					sqlQuery($query);
				}
				
														
		break;
		}
		case 'Laporan':{	
			$json = FALSE;
			$this->Laporan();										
		break;
		}
			
		case 'formBaru':{		
			foreach ($_REQUEST as $key => $value) { 
			 	 $$key = $value; 
			}
			
			if(empty($cmbUrusan)){
				$err = "Pilih Urusan";
			}elseif(empty($cmbBidang)){
				$err = "Pilih Bidang";
			}elseif(empty($cmbSKPD)){
				$err = "Pilih SKPD";
			}elseif(empty($cmbUnit)){
				$err = "Pilih Unit";
			}elseif(empty($cmbBidang)){
				$err = "Pilih Bidang";
			}elseif(empty($q)){
				$err = "Pilih Kegiatan";
			}elseif(empty($cmbJenisRKA)){
				$err = "Pilih Jenis RKA";
			}else{
				$fm = $this->setFormBaru();				
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];	
			}
			
														
		break;
		}
		case 'Info':{
				$fm = $this->Info();				
				$cek .= $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];										
		break;
		}
		case 'clearTemp':{
				$username =$_COOKIE['coID'];
				sqlQuery("delete from temp_rka_ppkd_1_v2 where user ='$username'");	
				foreach ($_REQUEST as $key => $value) { 
			 	 $$key = $value; 
				}
				$getIDTahapRenja = sqlArray(sqlQuery("select max(id_tahap) as idTahapRenja from view_renja where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' ")); 
				$idTahapRenja = $getIDTahapRenja['idTahapRenja'];
				$getDetailAboutRenja = sqlArray(sqlQuery("select * from view_renja where id_tahap ='$idTahapRenja' and tahun = '$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' "));						
				$jenisFormModulRenja = $getDetailAboutRenja['jenis_form_modul'];
				
				$cekRelationRenjaWithSKPD = sqlNumRow(sqlQuery("select *  from view_renja where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and q !='0' and  id_tahap ='$idTahapRenja' and tahun = '$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'"));
				if($jenisFormModulRenja == "VALIDASI"){
				$cekRelationRenjaWithSKPD = sqlNumRow(sqlQuery("select *  from view_renja where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and q !='0' and status_validasi = '1' and id_tahap ='$idTahapRenja' and tahun = '$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'"));
				}
				/*if($cekRelationRenjaWithSKPD == 0){
					$err = "SKPD tidak memiliki pagu indikatif";
				}*/
				
				
		break;
		}
		case 'BidangAfterForm':{
			 $kondisiBidang = "";
			 $cmbUrusan = $_REQUEST['fmSKPDUrusan'];
			 $cmbBidang = $_REQUEST['fmSKPDBidang'];
			 
			 $codeAndNameUrusan = "select c1, concat(c1, '. ', nm_skpd) as vnama from ref_skpd where d='00' and c ='00' order by c1";
		
		     $codeAndNameBidang = "SELECT c, concat(c, '. ', nm_skpd) as vnama FROM ref_skpd where d = '00' and e = '00' and c!='00'and c1 = '$cmbUrusan'  and e1='000'";	
		
		     $codeAndNameskpd = "SELECT d, concat(d, '. ', nm_skpd) as vnama FROM ref_skpd  where c='$cmbBidang' and c1='$cmbUrusan' and d != '00' and  e = '00' and e1='000' ";
			
			
				$bidang =  cmbQuery('cmbBidangForm', $cmbBidang, $codeAndNameBidang,' '.$cmbRo.' onChange=\''.$this->Prefix.'.BidangAfterform()\'','-- Pilih Semua --');	
				$skpd = cmbQuery('cmbSKPDForm', $cmbSKPD, $codeAndNameskpd,''.$cmbRo.'','-- Pilih Semua --');
				$content = array('bidang' => $bidang, 'skpd' =>$skpd ,'queryGetBidang' => $kondisiBidang);
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
		
		case 'sesuai':{
			foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
			} 
			$queryRows = "select * from tabel_anggaran where id_anggaran = '$idAwal'";
			$getrkaPPKD1_v2nya = sqlArray(sqlQuery($queryRows));
			foreach ($getrkaPPKD1_v2nya as $key => $value) { 
				  $$key = $value; 
			} 
			$cmbUrusanForm = $c1;
			$cmbBidangForm = $c;
			
			$cekUrusan =  sqlNumRow(sqlQuery("select * from tabel_anggaran where c1 = '$cmbUrusanForm' and c='00' and d = '00' and e='00' and e1='000' and bk='0' and ck='0' and p = '0' and q='0'  and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap'"));
					if($cekUrusan > 0 ){
						
					}else{
						$data = array(
									    'c1' => $cmbUrusanForm,
										'c' => '00',
										'd' => '00',
										'e' => '00',
										'e1' => '000',
										'bk' => '0',
										'ck' => '0',
										'p' => '0',
										'q' => '0',
										'id_tahap' => $this->idTahap,
										'jenis_anggaran' => $this->jenisAnggaran,
										'tahun' => $this->tahun,
										"nama_modul" => $this->modul
										);
						$query = VulnWalkerInsert("tabel_anggaran", $data);
						$content .= "mampir";
						sqlQuery($query)	;				
					}
					
					$cekBidang =  sqlNumRow(sqlQuery("select * from tabel_anggaran where c1 = '$cmbUrusanForm' and c='$cmbBidangForm' and d = '00' and e='00' and e1='000' and bk='0' and ck='0' and p = '0' and q='0' and p = '00' and q='00'   and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap' "));
					if($cekBidang > 0 ){
						
					}else{
						$data = array(
									    'c1' => $cmbUrusanForm,
										'c'  => $cmbBidangForm,
										'd'  => '00',
										'e'  => '00',
										'e1' => '000',
										'bk' => '0',
										'ck' => '0',
										'p' => '0',
										'q' => '0',
										'id_tahap' => $this->idTahap,
										'jenis_anggaran' => $this->jenisAnggaran,
										'tahun' => $this->tahun,
										"nama_modul" => $this->modul
										
										);
						$query = VulnWalkerInsert("tabel_anggaran", $data);
						$content .= $query;
						sqlQuery($query)	;				
					}
			
			
			$dataSesuai = array("tahun" => $tahun,
								"c1" => $c1,
								"c" => $c,
								"d" => $d,
								"e" => $e,
								"e1" => $e1,
								"p" => '0',
								"q" => '0',
								"bk" => '0',
								"ck" => '0',
								'jumlah' => $jumlah,
								'id_tahap' => $this->idTahap,
								'jenis_anggaran' => $this->jenisAnggaran,
								'tahun' => $this->tahun,
								"nama_modul" => $this->modul
										
 								);			
			$cekSKPD =  sqlNumRow(sqlQuery("select * from tabel_anggaran where c1 = '$cmbUrusanForm' and c='$cmbBidangForm' and d = '$d' and e='00' and e1='000' and bk='0' and ck='0' and p = '0' and q='0' and p = '00' and q='00'   and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap' "));
					if($cekSKPD > 0 ){
						$getID = sqlArray(sqlQuery("select * from tabel_anggaran where c1 = '$cmbUrusanForm' and c='$cmbBidangForm' and d = '$d' and e='00' and e1='000' and bk='0' and ck='0' and p = '0' and q='0' and p = '00' and q='00'   and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap' "));
					    $idnya = $getID['id_anggaran'];
						sqlQuery("update tabel_anggaran set jumlah = '$jumlah' where id_anggaran='$idnya'");
					}else{
						sqlQuery(VulnWalkerInsert("tabel_anggaran", $dataSesuai));	
						$content .=VulnWalkerInsert("tabel_anggaran", $dataSesuai);	
					}
			
			
			/*$content = array("query" => $query, "sesuai" => number_format($jumlah,2,',','.'), "QUERY ROWS" => $queryData);*/
			 
		break;
	    }
		
		case 'koreksi':{
			foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
			} 
			$queryRows = "select * from tabel_anggaran where id_anggaran = '$idAwal'";
			$getrkaPPKD1_v2nya = sqlArray(sqlQuery($queryRows));
			foreach ($getrkaPPKD1_v2nya as $key => $value) { 
				  $$key = $value; 
			} 
			 
			 $hasilKali = $koreksiSatuanHarga * $koreksiVolumebarang ;
			 if($this->jenisForm !='KOREKSI'){
			 	$err = "Tahap Koreksi Talah Habis";
			 }else{
			 	
			 	if($err == ""){
				 	if(sqlNumRow(sqlQuery("select * from view_rka_ppkd_1 where  o1='$o1' and rincian_perhitungan='' and rincian_perhitungan ='' and id_tahap='$this->idTahap' ")) > 0){
				 	
						 }else{
							$arrayPekerjaan = array(
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
												 'k' => '0',
												 'l' => '0',
												 'm' => '0',
												 'n' => '0',
												 'o' => '0',
												 'o1' => $o1,
												 'jenis_rka' => '1',
												 'tahun' => $this->tahun,
												 'jenis_anggaran' => $this->jenisAnggaran,
												 'id_tahap' => $this->idTahap,
												 'nama_modul' => 'RKA-PPKD'
												);
							$queryPekerjaan = VulnWalkerInsert('tabel_anggaran',$arrayPekerjaan);
							sqlQuery($queryPekerjaan);
					}
			 		
				 	if(sqlNumRow(sqlQuery("select * from view_rka_ppkd_1 where  rincian_perhitungan ='' and c1='0' and k='$k' and l='$l' and m='$m' and n='$n' and o='$o' and id_tahap='$this->idTahap'  ")) > 0){
				 	
					 }else{
						$data = array(
										"tahun" => $tahun,
										"c1" => '0',
										"c" => '00',
										"d" => '00',
										"e" => '00',
										"e1" => '000',
										"bk" => '0',
										"ck" => '0',
										"dk" => '0',
										"p" => '0',
										"q" => '0',
										"f1" => '0',
										"f2" => '0',
										"f" => '00',
										"g" => '00',
										"h" => '00',
										"i" => '00',
										"j" => '000',
										"k" => $k,
										"l" => $l,
										"m" => $m,
										"n" => $n,
										"o" => $o,
										'o1' => $o1,
										"jenis_rka" => '1',
										"jenis_anggaran" => $this->jenisAnggaran,
										"id_tahap" => $this->idTahap,
										"nama_modul" => $this->modul,
										"user_update" => $_COOKIE['coID'],
										"tanggal_update" => date("Y-m-d")
									
									);
							$query = VulnWalkerInsert('tabel_anggaran',$data);
							sqlQuery($query);	 	
					 }
					
					 $dataSesuai = array("tahun" => $tahun,
										 "c1" => $c1,
										 "c" => $c,
										 "d" => $d,
										 "e" => $e,
										 "e1" => $e1,
										 "f" => $f,
										 "g" => $g,
										 "h" => $h,
										 "i" => $i,
										 "j" => $j,
										 "id_jenis_pemeliharaan" => $id_jenis_pemeliharaan,
										 "uraian_pemeliharaan" => $uraian_pemeliharaan,
										 "k" => $k,
										 "l" => $l,
										 "m" => $m,
										 "n" => $n,
										 "o" => $o,
										 "o1" => $o1,
										 "rincian_perhitungan" => $rincian_perhitungan,
										 "jumlah" => $koreksiSatuanHarga,
										 "volume_rek" => $koreksiVolumebarang,
										 "satuan_rek" => $satuan_rek,
										 "jumlah_harga" => $hasilKali,
										 "jenis_anggaran" => $this->jenisAnggaran,
										 "jenis_rka" => '1',
										 "id_tahap" => $this->idTahap,
										 "nama_modul" => $this->modul,
										 "user_update" => $_COOKIE['coID'],
										 "tanggal_update" => date("Y-m-d"),
										 
		 								);			
					
					$cekRKA =  sqlNumRow(sqlQuery("select * from view_rka_ppkd_1 where c1 = '$c1' and c='$c' and d = '$d' and e='$e' and e1='$e1'  and k='$k' and l='$l' and m='$m' and n='$n' and o='$o' and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap' and o1='$o1' and rincian_perhitungan = '$rincian_perhitungan'"));
							if($cekRKA > 0 ){
								$getID = sqlArray(sqlQuery("select * from view_rka_ppkd_1 where c1 = '$c1' and c='$c' and d = '$d' and e='$e' and e1='$e1'  and k='$k' and l='$l' and m='$m' and n='$n' and o='$o' and o1 !='0' and rincian_perhitungan !='' and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap' "));
							    $idnya = $getID['id_anggaran'];
								sqlQuery(VulnWalkerUpdate("tabel_anggaran", $dataSesuai, "id_anggaran = '$idnya'"));
							}else{
								sqlQuery(VulnWalkerInsert("tabel_anggaran", $dataSesuai));	
								$content.=VulnWalkerInsert("tabel_anggaran", $dataSesuai);
							}
			 }
			 }
			 
			
			 			
		break;
	    }

	    case 'SaveValid':{
	    	foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
			 } 
			 if ($validasi == 'on') {
			 	 $status_validasi = "1";
			 }else{
			 	$status_validasi = "0";
			 }
			 


			 $data = array( "status_validasi" => $status_validasi,
			 				'user_validasi' => $_COOKIE['coID'],
			 				'tanggal_validasi' => date("Y-m-d"),
							'id_tahap' => $this->idTahap
			 				);
			 $query = VulnWalkerUpdate("tabel_anggaran",$data," id_anggaran = '$rkaPPKD1_v2_idplh'");
			 sqlQuery($query);

			$content .= $query;
		break;
	    }
		
		 case 'SaveCatatan':{
	    	foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
			 } 
			 
			 $data = array( "catatan" => $catatan
			 				);
			 $query = VulnWalkerUpdate("tabel_anggaran",$data," id_anggaran = '$id'");
			 sqlQuery($query);

			$content .= $query;
		break;
	    }
		
		
		case 'editTab':{
			$id = $_REQUEST['rkaPPKD1_v2_cb'];
			foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
			} 
			
			$username = $_COOKIE['coID'];

			$get = sqlArray(sqlQuery("select * from tabel_anggaran where id_anggaran ='$id[0]'"));		
			$kodeRek = $get['k'].".".$get['l'].".".$get['m'].".".$get['n'].".".$get['o'] ;
			
			$getAll = sqlQuery("select * from view_rka_ppkd_1 where concat(k,'.',l,'.',m,'.',n,'.',o) ='$kodeRek' and id_tahap='$this->idTahap' and rincian_perhitungan !=''   and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD'  and status_validasi !='1'  order by o1, rincian_perhitungan");
			sqlQuery("delete from temp_rka_ppkd_1_v2 where user='$username'");
			sqlQuery("delete from temp_rincian_volume_21 where user='$username'");
		    sqlQuery("delete from temp_alokasi_rka_ppkd_1_v2 where user='$username'");
			$noUrutPekerjaan = 0;
			$angkaO2 = 0;
			$lastO1 = 0;
			while($rows = sqlArray($getAll)){
				foreach ($rows as $key => $value) { 
				  $$key = $value; 
				} 
				$getMaxID = sqlArray(sqlQuery("select  max(id) as gblk from temp_rka_ppkd_1_v2 where user ='$username'"));
				$maxID = $getMaxID['gblk'];
				$lastO1 = $o1;
				
				$getLastO1 = sqlArray(sqlQuery("select o1 from temp_rka_ppkd_1_v2 where id='$maxID' "));
				if($getLastO1['o1'] != $lastO1){
					$noUrutPekerjaan = $noUrutPekerjaan + 1;
					if($o1 == '0'){
						$noUrutPekerjaan = 0;
					}
					$angkaO2 = 1;
				}
				
			 	$data = array(
								'c1' => $c1,
								'c' => $c,
								'd' => $d,
								'e' => '00',
								'e1' => '000',
								'f' => $f,
								'g' => $g,
								'h' => $h,
								'i' => $i,
								'j' => $j,
								'k' => $k,
								'l' => $l,
								'm' => $m,
								'n' => $n,
								'o' => $o,
								'o1' => $o1,
								'volume_rek' => $volume_rek,
								'satuan' => $satuan_rek,
								'user' => $username,
								'rincian_perhitungan' => $rincian_perhitungan,
								'harga_satuan' => $jumlah,
								'jumlah_harga' => $jumlah_harga,
								'id_awal' => $id_anggaran
								);
				$query = VulnWalkerInsert('temp_rka_ppkd_1_v2',$data);
				sqlQuery($query);
				$angkaO2 = $angkaO2 + 1;
				
			}
				
				$content = array('kodeRek' => $kodeRek);
			break;
		}
		
		case 'Remove':{
			$id = $_REQUEST['rkaPPKD1_v2_cb'];
			foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
			} 
			
			$username = $_COOKIE['coID'];

			$get = sqlArray(sqlQuery("select * from tabel_anggaran where id_anggaran ='$id[0]'"));		
			$kodeRek = $get['k'].".".$get['l'].".".$get['m'].".".$get['n'].".".$get['o'] ;
			
			$getAll = sqlQuery("select * from view_rka_ppkd_1 where concat(k,'.',l,'.',m,'.',n,'.',o) ='$kodeRek' and id_tahap='$this->idTahap' and rincian_perhitungan !=''   and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and status_validasi !='1'  order by o1, rincian_perhitungan");
			sqlQuery("delete from temp_rka_ppkd_1_v2 where user='$username'");
			sqlQuery("delete from temp_rincian_volume_21 where user='$username'");
		    sqlQuery("delete from temp_alokasi_rka_ppkd_1 where user='$username'");
			while($rows = sqlArray($getAll)){
				foreach ($rows as $key => $value) { 
				  $$key = $value; 
				} 
				sqlQuery("delete from tabel_anggaran where id_anggaran = '$id_anggaran'");
				//sqlQuery("delete from tabel_anggaran where concat(k,'.',l,'.',m,'.',n,'.',o) ='$kodeRek' and o1 ='$o1' and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit' and jenis_rka='1' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'");
				
			}
			
			break;
		}
		
	    case 'Validasi':{
				$dt = array();
				$err='';
				$content='';
				$uid = $HTTP_COOKIE_VARS['coID'];
				
				$cbid = $_REQUEST[$this->Prefix.'_cb'];
				$idplh = $_REQUEST['id_anggaran'];
				$this->form_idplh = $_REQUEST['id_anggaran'];
				
				
					$qry = "SELECT * FROM tabel_anggaran WHERE id_anggaran = '$idplh' ";$cek=$qry;
					$aqry = sqlQuery($qry);
					$dt = sqlArray($aqry);
					$username = $_COOKIE['coID'];
					$user_validasi = $dt['user_validasi'];
					$user_update = $dt['user_update'];
		
					if ($username != $user_validasi && $dt['status_validasi'] == '1') {
						$getNamaOrang = sqlArray(sqlQuery("select * from admin where uid = '$user_validasi'"));
						$err = "Data Sudah di Validasi, Perubahan Hanya Bisa Dilakukan oleh ".$getNamaOrang['nama']." !";
					}else{
						if($username == $user_update){
							$err = "User yang membuat tidak dapat melakukan VALIDASI";
						}
					}
					if($this->jenisForm !='PENYUSUNAN')$err = "Tahap Penyusunan Telah Habis";
					if($err == ''){
						$fm = $this->Validasi($dt);				
						$cek .= $fm['cek'];
						$err = $fm['err'];
						$content = $fm['content'];
					}
				
								
															
			break;
		}
		
		
		 case 'Catatan':{
			foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
			 } 
			
			$getData = sqlArray(sqlQuery("SELECT * FROM tabel_anggaran WHERE id_anggaran = '$idAwal'"));
			foreach ($getData as $key => $value) { 
				  $$key = $value; 
			}
			$getMaxID = sqlArray(sqlQuery("select max(id_anggaran) as maxID from tabel_anggaran where tahun = '$tahun'  and c1 ='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and p='$p' and q='$q' and jenis_anggaran = '$jenis_anggaran'  ")); 
			$maxID = $getMaxID['maxID'];
			$aqry = "select * from tabel_anggaran where id_anggaran ='$maxID' ";
			$dt = sqlArray(sqlQuery($aqry));
			if($dt['id_tahap'] != $this->idTahap){
				$err = "Data Belum Di Koreksi ";
			}
			if($err == ''){
				$fm = $this->Catatan($dt);				
				$cek .= $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
			}				
															
		break;
		}
		
		case 'formAlokasi':{
				$dt[] = $_REQUEST['jumlahHarga'];
				$dt[] = $_REQUEST['id'];
				$fm = $this->formAlokasi($dt);				
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
					
															
		break;
		}
		case 'formAlokasiTriwulan':{
				$jumlahHargaForm = $_REQUEST['jumlahHarga'];
				$id = $_REQUEST['id'];
				$fm = $this->formAlokasiTriwulan($dt);				
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
		 
	 }//end switch
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
   }
    function setPage_HeaderOther(){
   		
	return 
			"<table width=\"100%\" class=\"menubar\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style='margin:0 0 0 0'>
	<tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>

	<A href=\"pages.php?Pg=rka-ppkd-1_v2\" title='RKA-PPKD MURNI' style='color:blue;' > RKA-PPKD 1 </a> |
	<A href=\"pages.php?Pg=rka-ppkd-2.1_v2\" title='RKA-PPKD MURNI'  > RKA-PPKD 2.1 </a> |
	<A href=\"pages.php?Pg=rka-ppkd-3.1_v2\" title='RKA-PPKD MURNI'  > RKA-PPKD 3.1 </a> |
	<A href=\"pages.php?Pg=rka-ppkd-3.2_v2\" title='RKA-PPKD MURNI'  > RKA-PPKD 3.2 </a> |
	<A href=\"pages.php?Pg=rka-ppkd_v2\" title='RKA-PPKD MURNI'  > RKA-PPKD </a> 
	
	&nbsp&nbsp&nbsp	
	</td></tr>
	</table>";
	}
   function setPage_OtherScript(){
		$scriptload = 
					"<script>
						$(document).ready(function(){ 
							".$this->Prefix.".loading();
						});
					</script>";
		return 	
			"
			<script src='js/skpd.js' type='text/javascript'></script>
			<script type='text/javascript' src='js/perencanaan/rka/popupBarang.js' language='JavaScript' ></script>
			<script type='text/javascript' src='js/perencanaan/rka/popupRekening.js' language='JavaScript' ></script>
			<script type='text/javascript' src='js/perencanaan_v2/rka/rkaPPKD1.js' language='JavaScript' ></script> 
			  <link rel='stylesheet' href='datepicker/jquery-ui.css'>
			  <script src='datepicker/jquery-1.12.4.js'></script>
			  <script src='datepicker/jquery-ui.js'></script>
			  
			".
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
			$aqry = "SELECT * FROM  tabel_anggaran WHERE id_anggaran='".$this->form_idplh."' "; $cek.=$aqry;
			$dt = sqlArray(sqlQuery($aqry));
			$fm = $this->setForm($dt);
		}
		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$err.$fm['err'], 'content'=>$fm['content']);
	}	
	function Info(){	
	 global $SensusTmp;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 500;
	 $this->form_height = 100;
	 $this->form_caption = 'INFO RKA';

	 
	 if($this->jenisFormTerakhir == "VALIDASI"){
	 	$getJumlahSKPDYangMengisiPlafon = sqlNumRow(sqlQuery("select * from view_plafon where tahun='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and no_urut ='$this->noUrutTerakhirPlafon' and d!='00' and status_validasi = '1' "));
	 }else{
	 	$getJumlahSKPDYangMengisiPlafon = sqlNumRow(sqlQuery("select * from view_plafon where tahun='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and no_urut ='$this->noUrutTerakhirPlafon' and d!='00' "));
	 }
	 
	 
	 	
	 //items ----------------------
	  $this->form_fields = array(
			'1' => array( 
						'label'=>'ANGGARAN',
						'labelWidth'=>150, 
						'value'=>$this->jenisAnggaran. " TAHUN  ". $this->tahun,
						 ),
			'2' => array( 
						'label'=>'NAMA TAHAP TERAKHIR',
						'labelWidth'=>150, 
						'value'=>$this->namaTahapTerakhir,
						 ),	
			'3' => array( 
						'label'=>'WAKTU',
						'labelWidth'=>150, 
						'value'=>$this->masaTerakhir,
						 ),		
			'4' => array( 
						'label'=>'TAHAP SEKARANG',
						'labelWidth'=>150, 
						'value'=>$this->currentTahap,
						 )
						 				
			
			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
		
	function setForm($dt){	
	 global $SensusTmp;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 700;
	 $this->form_height = 400;
	  if ($this->form_fmST==0) {
		
			
	  }else{
		$this->form_caption = 'Edit';			
		foreach ($dt as $key => $value) { 
			 	 $$key = $value; 
		 }
		 $getNamaUrusan = sqlArray(sqlQuery("select concat(c1,'. ',nm_skpd) as nama from ref_skpd where c1='$c1'  and c='00' and d='00' and e='00' and e1 = '000'"));
		 $namaUrusan = $getNamaUrusan['nama'];
		 $urusan = "<input type ='hidden' name='c1' id='c1' value = '$c1' > <input type ='text'  value = '$namaUrusan' style='width:400px;' readonly>";
		 
		 $getNamaBidang = sqlArray(sqlQuery("select concat(c,'. ',nm_skpd) as nama from ref_skpd where c1='$c1'  and c='$c' and d='00' and e='00' and e1 = '000'"));
		 $namaBidang = $getNamaBidang['nama'];
		 $bidang = "<input type ='hidden' name='c' id='c' value = '$c' > <input type ='text'  value = '$namaBidang' style='width:400px;' readonly>";
		 
		 $getNamaSKPD = sqlArray(sqlQuery("select concat(d,'. ',nm_skpd) as nama from ref_skpd where c1='$c1'  and c='$c' and d='$d' and e='00' and e1 = '000'"));
		 $namaSKPD = $getNamaSKPD['nama'];
		 $skpd = "<input type ='hidden' name='d' id='d' value = '$d' > <input type ='text'  value = '$namaSKPD' style='width:400px;' readonly>";
		 
		 $getNamaUnit = sqlArray(sqlQuery("select concat(e,'. ',nm_skpd) as nama from ref_skpd where c1='$c1'  and c='$c' and d='$e' and e='$e' and e1 = '000'"));
		 $namaUnit = $getNamaUnit['nama'];
		 $unit = "<input type ='hidden' name='e' id='e' value = '$e' > <input type ='text'  value = '$namaUnit' style='width:400px;' readonly>";
		 
		 $getNamaSubUnit = sqlArray(sqlQuery("select concat(e1,'. ',nm_skpd) as nama from ref_skpd where c1='$c1'  and c='$c' and d='$d' and e='$e' and e1 = '$e1'"));
		 $namaSubUnit = $getNamaSubUnit['nama'];
		 $subunit = "<input type ='hidden' name='e1' id='e1' value = '$e1' > <input type ='text'  value = '$namaSubUnit' style='width:400px;' readonly>";
		 
		 $getProgram = sqlArray(sqlQuery("select concat(p,'. ',nama) as nama from ref_program where bk='$bk' and ck='$ck' and dk = '0' and p = '$p' and q= '0'"));
		 $namaProgram = $getProgram['nama'];
		 $program = "<input type ='hidden' name='bk' id='bk' value = '$bk' > <input type ='hidden' name='ck' id='ck' value = '$ck' > <input type ='hidden' name='p' id='p' value = '$p' > <input type ='text'  value = '$namaProgram' style='width:400px;' readonly>";
	   	 
		 $getKegiatan = sqlArray(sqlQuery("select concat(q,'. ',nama) as nama from ref_program where bk='$bk' and ck='$ck' and dk = '0' and p = '$p' and q= '$q'"));
		 $namaKegiatan = $getKegiatan['nama'];
		 $kegiatan = "<input type ='hidden' name='q' id='q' value = '$q' > <input type ='text'  value = '$namaKegiatan' style='width:400px;' readonly>";
	  	 
		 $kodeRENJA = $c1.".".$c.".".$d.".".$e.".".$e1.".".$bk.".".$ck.".".$p.".".$q;
		 $hargaSatuan = $satuan_rek;
		 $kodeBarang = $f.".".$g.".".$h.".".$i.".".$j ;
		 $getNamaBarang = sqlArray(sqlQuery("select * from ref_barang where  f='$f' and g='$g' and h='$h' and i='$i' and j='$j'"));
		 $namaBarang = $getNamaBarang['nm_barang'];	
		 $kodeRekening = $k.".".$l.".".$m.".".$n.".".$o ;
		 $getNamaRekening = sqlArray(sqlQuery("select * from ref_rekening where k='$k' and l='$l' and m='$m' and n='$n' and o='$o'"));
		 $namaRekening = $getNamaRekening['nm_rekening'];
		 $arrayJenisRKA = array(
						array("1","RKA-PPKD 1"),
						array("1","RKA-PPKD 1")
						
						);
		 $jenis_rka = $jenis_rka;
		 $cmbJenisRKA = cmbArray('cmbJenisRKAForm',$jenis_rka,$arrayJenisRKA,'-- JENIS RKA --','onchange=rkaPPKD1_v2.unlockFindRekening();');
	 	 if(empty($jenis_rka)){
		 	$tergantungJenis = "disabled";
		 }
		 
		 $getIdTahapRenjaTerakhir = sqlArray(sqlQuery("select max(id_tahap) as max from view_renja where tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' "));
		 $idTahapRenja = $getIdTahapRenjaTerakhir['max'];
		 $getPaguIndikatif = sqlArray(sqlQuery("select * from view_renja where c1= '$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and p='$p' and q='$q' and id_tahap = '$idTahapRenja' "));
		 $angkaPaguIndikatif = number_format($getPaguIndikatif['jumlah'] ,2,',','.');
		 
		 $formPaguIndikatif  = " <input type='hidden' id='paguIndifkatif' name='paguIndikatif' value='".$getPaguIndikatif['jumlah']."' ><input type='text' value='$angkaPaguIndikatif' readonly >";
	  }

	
	
	 //items ----------------------
	  $this->form_fields = array(
	  	  	'kode0' => array(
	  					'label'=>'URUSAN',
						'labelWidth'=>150, 
						'value'=> $urusan
						 ),
	  		'kode1' => array(
	  					'label'=>'BIDANG',
						'labelWidth'=>150, 
						'value'=> $bidang
						 ),
			'kode2' => array( 
						'label'=>'SKPD',
						'labelWidth'=>150, 
						'value'=> $skpd
						 ),
			'kode3' => array( 
						'label'=>'UNIT',
						'labelWidth'=>150, 
						'value'=> $unit
						 ),
			'kode4' => array( 
						'label'=>'SUB UNIT',
						'labelWidth'=>150, 
						'value'=> $subunit
						 ),
			'kode5' => array( 
						'label'=>'PROGRAM',
						'labelWidth'=>150, 
						'value'=> "<input type='hidden' name = 'bk' id = 'bk' value='$bk'> <input type='hidden' name = 'ck' id = 'ck' value='$ck'>".$program
						 ),
			'kode6' => array( 
						'label'=>'KEGIATAN',
						'labelWidth'=>150, 
						'value'=> $kegiatan
						 ),
			'kode12' => array( 
						'label'=>'PAGU INDIKATIF',
						'labelWidth'=>150, 
						'value'=> $formPaguIndikatif 
						 ),		
			'kode11' => array( 
						'label'=>'JENIS RKA',
						'labelWidth'=>150, 
						'value'=> $cmbJenisRKA,
						 ),	
			'kode9' => array( 
						'label'=>'BARANG',
						'labelWidth'=>150,
						'value'=> "<input type='text' id='kodeBarang' name='kodeBarang' style='width:120px;' readonly value = '$kodeBarang'> &nbsp&nbsp
						 <input type='text' id='namaBarang' name='namaBarang' style='width:300px;' readonly value = '$namaBarang'> "
						 ),				 
			'kode7' => array( 
						'label'=>'REKENING',
						'labelWidth'=>150,
						'value'=> "<input type='text' id='kodeRekening' name='kodeRekening' style='width:120px;' readonly value = '$kodeRekening'> &nbsp&nbsp
						 <input type='text' id='namaRekening' name='namaRekening' style='width:300px;' readonly value = '$namaRekening'>
						 <button type='button' id='findRekening' onclick=rkaPPKD1_v2.findRekening('$jenis_rka'); $tergantungJenis> CARI </button> "
						 ),
			'kode8' => array( 
						'label'=>'HARGA SATUAN',
						'labelWidth'=>150, 
						'value'=> "<input type='text' name='hargaSatuan' id='hargaSatuan' value='$hargaSatuan' onkeypress='return event.charCode >= 48 && event.charCode <= 57' onkeyup='rkaPPKD1_v2.bantu();' > <span id='bantu' style='color:red;'> </span>"
						 ),	
			
			
			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan()' title='Simpan' >  &nbsp  ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	

		
	//daftar =================================
	function setKolomHeader($Mode=1, $Checkbox=''){
	
		
		 $arrayResult = VulnWalkerTahap_v2('RKA');
		 $jenisForm = $arrayResult['jenisForm'];
		 $nomorUrut = $arrayResult['nomorUrut'];
		 $tahun = $arrayResult['tahun'];
		 $jenisAnggaran = $arrayResult['jenisAnggaran'];
		 $id_tahap = $arrayResult['id_tahap'];
	 if($jenisForm == "PENYUSUNAN"){
	 	if($this->wajibValidasi==TRUE)$tergantung="<th class='th01' rowspan='2' width='100' >VALIDASI</th>";
		
		$headerTable =
		  "<thead>
		   <tr>
	  	   $Checkbox		
		   <th class='th01' width='100'  rowspan='2' >KODE REKENING</th>
		   <th class='th01' width='500'  rowspan='2' >NAMA REKENING</th>
		   <th class='th02' colspan='3'  rowspan='1' width='1000' >RINCIAN PERHITUNGAN</th>
		   <th class='th01' rowspan='2' width='100' >JUMLAH</th>
		   $tergantung
		 
		   </tr>
		   <tr>
		   
		   <th class='th01' >VOLUME</th>
		   <th class='th01' >SATUAN</th>
		   <th class='th01' >TARIF / HARGA</th>
		   
		   
		   </tr>
		   </thead>";
	 }elseif ($jenisForm == "KOREKSI"){
	 	$Checkbox = "";
	 	$tergantungJenisForm = "
		<th class='th02' rowspan='1' colspan='3' width='600'>KOREKSI</th>
		<th class='th02' rowspan='1' colspan='3' width='600'>BERTAMBAH/(BERKURANG)</th>
		<th class='th01' rowspan='2' width='200'>AKSI</th>
		";
		$headerTable =
		  "<thead>
		   <tr>
		   <th class='th01' width='100'  rowspan='2' >KODE REKENING</th>
		   <th class='th01' width='900'  rowspan='2' >NAMA REKENING</th>
		   <th class='th02' colspan='3'  rowspan='1' width='600' >RINCIAN PERHITUNGAN</th>
		   <th class='th01' width='200'  rowspan='2' >JUMLAH HARGA</th>
		   $tergantungJenisForm 
		 
		   </tr>
		   <tr>
		   <th class='th01'  >VOLUME</th>
		   <th class='th01'  >SATUAN</th>
		   <th class='th01' width='200' >TARIF / HARGA</th>
		   <th class='th01' width='200' >VOLUME REKENING</th>
		   <th class='th01' width='200' >TARIF / HARGA</th>
		   <th class='th01' width='200' >JUMLAH HARGA</th>
		   <th class='th01' width='200' >VOLUME REKENING</th>
		   <th class='th01' width='200' >TARIF / HARGA</th>
		   <th class='th01' width='200' >JUMLAH HARGA</th>
		   </tr>
		   </thead>";
	 }else{
	    $Checkbox = "";
		if($this->jenisFormTerakhir == "PENYUSUNAN"){
		if($this->wajibValidasi==TRUE)$tergantung= "<th class='th01' rowspan='2' width='100' >VALIDASI</th>";
		$headerTable =
		  "<thead>
		   <tr>
	  	   $Checkbox		
		   <th class='th01' width='100'  rowspan='2' >KODE REKENING</th>
		   <th class='th01' width='500'  rowspan='2' >NAMA REKENING</th>
		   <th class='th02' colspan='3'  rowspan='1' width='1000' >RINCIAN PERHITUNGAN</th>
		   <th class='th01' rowspan='2' width='100' >JUMLAH</th>
		   $tergantung 
		 
		   </tr>
		   <tr>
		   
		   <th class='th01' >VOLUME</th>
		   <th class='th01' >SATUAN</th>
		   <th class='th01' >TARIF / HARGA</th>
		   
		   
		   </tr>
		   </thead>";
		}elseif($this->jenisFormTerakhir == "KOREKSI"){
			$Checkbox = "";
	 	$tergantungJenisForm = "
		<th class='th02' rowspan='1' colspan='3' width='600'>KOREKSI</th>
		<th class='th02' rowspan='1' colspan='3' width='600'>BERTAMBAH/(BERKURANG)</th>
		";
		$headerTable =
		  "<thead>
		   <tr>
		   <th class='th01' width='100'  rowspan='2' >KODE REKENING</th>
		   <th class='th01' width='900'  rowspan='2' >NAMA REKENING</th>
		   <th class='th02' colspan='3'  rowspan='1' width='600' >RINCIAN PERHITUNGAN</th>
		   <th class='th01' width='200'  rowspan='2' >JUMLAH HARGA</th>
		   $tergantungJenisForm 
		 
		   </tr>
		   <tr>
		   <th class='th01'  >VOLUME</th>
		   <th class='th01'  >SATUAN</th>
		   <th class='th01' width='200' >TARIF / HARGA</th>
		   <th class='th01' width='200' >VOLUME REKENING</th>
		   <th class='th01' width='200' >TARIF / HARGA</th>
		   <th class='th01' width='200' >JUMLAH HARGA</th>
		   <th class='th01' width='200' >VOLUME REKENING</th>
		   <th class='th01' width='200' >TARIF / HARGA</th>
		   <th class='th01' width='200' >JUMLAH HARGA</th>
		   </tr>
		   </thead>";
		}
	 	
	 }
	 $NomorColSpan = $Mode==1? 2: 1;
	 
	 
		return $headerTable;
	}	
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	 foreach ($isi as $key => $value) { 
		  			$$key = $value; 
	 }
	 foreach ($_REQUEST as $key => $value) { 
		  			$$key = $value; 
	 }
	 	if($cmbSubUnit != ''){
			$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit'";					
		}elseif($cmbUnit != ''){
			$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' ";
		}elseif($cmbSKPD != ''){
			$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD'  ";
		}elseif($cmbBidang != ''){
			$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang'  ";
		}elseif($cmbUrusan != ''){
			$kondisiSKPD = "and c1='$cmbUrusan'";
		}
	 	
	 
	 
	 //TAHAP PENYUSUNAN
	 
	 if($this->jenisForm == 'PENYUSUNAN'){
	 			
			 $getNamaRekening = sqlArray(sqlQuery("select * from ref_rekening where k='$k' and l ='$l' and m='$m' and n='$n' and o='$o'"));
			 $namaRekening = $getNamaRekening['nm_rekening'];
			 $getNamaBarang = sqlArray(sqlQuery("select * from ref_barang where  f='$f' and g='$g' and h='$h' and i='$i' and j='$j'"));
			 $namaBarang = $getNamaBarang['nm_barang'];
			 $satuanBarang = $getNamaBarang['satuan'];
			 
			
			 
			 $Koloms = array();
		 	
			 if($c1 == '0'){
			 	if($k == '0' && $n == '0')  $TampilCheckBox = '';
			 	$Koloms[] = array(" align='center'  ", $TampilCheckBox);
				if(strlen($k) > 1){
					$Koloms[] = array(' align="left"', "<span style='color:red;'>x.x.x.xx.xx</span>" );
				}else{
					if($k == '0' && $n == '0'){
						
						$Koloms[] = array(' align="left"',"<span style='font-weight:bold'></span>" );
					}else{
						$Koloms[] = array(' align="left"',"<span>".$k.".".$l.".".$m.".".$n.".".$o ."</span>" );
					}
				}	
			 	
			 }else{
			 	if($k == ''){
					$Koloms[] = array(" align='center'  ", '');
					$Koloms[] = array(' align="center"', "" );
				}else{
					$Koloms[] = array(" align='center'  ", '');
					$Koloms[] = array(' align="left"', '' );
				}
			 	
			 }
			 
			 if($jumlah1 == 0 && $satuan1 =='' ){
			 	$ilustrasi = "";	
			 }
			 elseif($jumlah3 == 0 && $satuan3 == ''){
			 	$ilustrasi = $jumlah1." ".$satuan1." x ". " ".$jumlah2." ".$satuan2;
			 }else{
			 	$ilustrasi = $jumlah1." ".$satuan1." x ". " ".$jumlah2." ".$satuan2." x ".$jumlah3." ".$satuan3;
			 }
			 if($c1 == '0'){
			 	if(strlen($k) > 1){
					$Koloms[] = array('align="left"',"<span style='color:red;'> Belanja xxx </span>" );
				}else{
					if($k == '0' && $n == '0'){
						$getNamaPekerjaan = sqlArray(sqlQuery("select * from ref_pekerjaan where id = '$o1'"));
						
						$this->publicVar += 1;
						
						$Koloms[] = array('align="left"',"<span style='font-weight:bold;'>$this->publicVar. ".$getNamaPekerjaan['nama_pekerjaan']."</span>" );
					}else{
						$jarak = '15px';
				 		$cekAdaParent = sqlNumRow(sqlQuery("select * from view_rka_ppkd_1 where id_tahap = '$this->idTahap' and o1 = '$o1' and o1 !='0' and o1 !='' "));
						if($cekAdaParent == 0)$jarak = "0px";
						$Koloms[] = array('align="left"',"<span style='margin-left:$jarak;font-weight:bold;'>".$namaRekening."</span>" );
					}
					
				}
				$ilustrasi = "";
				$getSumJumlahBarang = sqlArray(sqlQuery("select sum(volume_rek) as total from view_rka_ppkd_1 where k='$k' and l='$l' and m='$m' and n='$n' and o='$o' $kondisiSKPD and id_tahap='$this->idTahap'"));
				$Koloms[] = array('align="left"',"" );
				$jumlahBarang = $getSumJumlahBarang['total'];
				//$Koloms[] = array('align="right"', number_format($jumlahBarang ,0,',','.') );
				
			 }else{
			 	if($f != '00' && empty($rincian_perhitungan) ){
					$Koloms[] = array('align="left"',"<span style='margin-left:20px;'>&nbsp&nbsp".$namaBarang."</span>" );
					$jumlah = number_format($jumlah ,2,',','.');
					$volume_rek = number_format($volume_rek ,0,',','.');
				}else{
					
					$Koloms[] = array('align="left"',"<span style='margin-left:20px;'>&nbsp&nbsp".$rincian_perhitungan."</span>" );
					$jumlah = number_format($jumlah ,2,',','.');
					$volume_rek = number_format($volume_rek ,0,',','.');
				}
			 	
				

				$Koloms[] = array('align="right"', $volume_rek );
			 }
			 
			 $Koloms[] = array('align="left"', $satuan_rek );
			 $getSumSatuanRek = sqlArray(sqlQuery("select sum(jumlah) as total from view_rka_ppkd_1 where k='$k' and l='$l' and m='$m' and n='$n'  and o='$o' $kondisiSKPD and id_tahap='$this->idTahap'"));
			 $sumSatuanRek = $getSumSatuanRek['total'];
			 if($c1 == '0'){
			 	//$Koloms[] = array('align="right"', number_format($sumSatuanRek ,2,',','.') );
				$Koloms[] = array('align="right"','' );
			 }else{
			 	$Koloms[] = array('align="right"', $jumlah );
			 }
			 
			 if($c1 == '0'){
			 if($k == '0' && $n =='0'){
			 	$getTotalJumalhHarga = sqlArray(sqlQuery("select sum(jumlah_harga) as total from view_rka_ppkd_1 where o1='$o1' $kondisiSKPD $kondisiBelanja and id_tahap='$this->idTahap'"));
			 }else{
			 	$getTotalJumalhHarga = sqlArray(sqlQuery("select sum(jumlah_harga) as total from view_rka_ppkd_1 where k='$k' and l='$l' and m='$m' and n='$n' and o='$o' $kondisiSKPD and id_tahap='$this->idTahap'"));	
			 }
			 $Koloms[] = array('align="right"', "<span style='font-weight:bold;'>".number_format($getTotalJumalhHarga['total'] ,2,',','.')."</span>" );
			 if($this->wajibValidasi == TRUE)$Koloms[] = array('align="center"', "");
			 }else{
			 	$Koloms[] = array('align="right"', number_format($jumlah_harga ,2,',','.') );
				if ($status_validasi =='1') {
			 	$validnya = "valid.png";
			 }else{
			 	$validnya = "invalid.png";
			 }
			 
			 
			 if($this->wajibValidasi == TRUE){
			 	if($rincian_perhitungan != '' ){
				 $Koloms[] = array('align="center"', "<img src='images/administrator/images/$validnya' width='20px' heigh='20px' style='cursor:pointer;' onclick=$this->Prefix.Validasi('$id_anggaran') >;");
				 
				 }else{
				 $Koloms[] = array('align="center"', "");
				 }
			 }
			 
			 
			 }
	 
	 
	 //TAHAP PENYUSUNAN
	 }elseif($this->jenisForm=="KOREKSI"){
	 		 $nomorBefore = $this->nomorUrut - 1;
			 $getRApbd = sqlArray(sqlQuery("select * from view_rka_ppkd_1 where no_urut = '$nomorBefore' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' "));
			 if($getRApbd['jenis_form_modul'] != "PENYUSUNAN" && $getRApbd['jenis_form_modul'] != "KOREKSI"){
					$nomorBefore = $nomorBefore - 1;		
			 }
			 $getLastTahap = sqlArray(sqlQuery("select * from view_rka_ppkd_1 where no_urut = '$nomorBefore' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'"));
			 $blackList = "";
			 if($getLastTahap['jenis_form_modul'] == "PENYUSUNAN" && $this->wajibValidasi == TRUE){
				$getAllChild = sqlQuery("select * from view_rka_ppkd_1 where id_tahap = '".$getLastTahap['id_tahap']."' and (rincian_perhitungan !='' or j !='000'  and status_validasi !='1' )");			
				while($black = sqlArray($getAllChild)){
					$blackList .= " and id_anggaran !='".$black['id_anggaran']."'";
				}
		     }
			 
			 $getNamaRekening = sqlArray(sqlQuery("select * from ref_rekening where k='$k' and l ='$l' and m='$m' and n='$n' and o='$o'"));
			 $namaRekening = $getNamaRekening['nm_rekening'];
			 $getNamaBarang = sqlArray(sqlQuery("select * from ref_barang where  f='$f' and g='$g' and h='$h' and i='$i' and j='$j'"));
			 $namaBarang = $getNamaBarang['nm_barang'];
			 $satuanBarang = $getNamaBarang['satuan'];
			 $Koloms = array();
		 	 $bk = $isi['bk'];
			 $ck = $isi['ck'];
			 $p = $isi['p'];
			 $q = $isi['q'];
			 if($c1 == '0'){
				if(strlen($k) > 1){
					$Koloms[] = array(' align="left"', "<span style='color:red;'>x.x.x.xx.xx</span>" );
				}else{
					if($k == '0' && $n == '0'){
						
						$Koloms[] = array(' align="left"',"<span style='font-weight:bold'></span>" );
					}else{
						$Koloms[] = array(' align="left"',"<span>".$k.".".$l.".".$m.".".$n.".".$o ."</span>" );
					}
				}	
			 	
			 }else{
			 	if($k == ''){
					$Koloms[] = array(' align="center"', "" );
				}else{
					$Koloms[] = array(' align="left"', '' );
				}
			 	
			 }
			 
			 if($jumlah1 == 0 && $satuan1 =='' ){
			 	$ilustrasi = "";	
			 }
			 elseif($jumlah3 == 0 && $satuan3 == ''){
			 	$ilustrasi = $jumlah1." ".$satuan1." x ". " ".$jumlah2." ".$satuan2;
			 }else{
			 	$ilustrasi = $jumlah1." ".$satuan1." x ". " ".$jumlah2." ".$satuan2." x ".$jumlah3." ".$satuan3;
			 }
			 if($c1 == '0'){
			 	if(strlen($k) > 1){
					$Koloms[] = array('align="left"',"<span style='color:red;'> Belanja xxx </span>" );
				}else{
					if($k == '0' && $n == '0'){
						$getNamaPekerjaan = sqlArray(sqlQuery("select * from ref_pekerjaan where id = '$o1'"));
						
						$this->publicVar += 1;
						
						$Koloms[] = array('align="left"',"<span style='font-weight:bold;'>$this->publicVar. ".$getNamaPekerjaan['nama_pekerjaan']."</span>" );
					}else{
						$jarak = '15px';
				 		$cekAdaParent = sqlNumRow(sqlQuery("select * from view_rka_ppkd_1 where no_urut = '$nomorBefore' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and o1 = '$o1' and o1 !='0' and o1 !='' "));
						if($cekAdaParent == 0)$jarak = "0px";
						$Koloms[] = array('align="left"',"<span style='margin-left:$jarak;font-weight:bold;'>".$namaRekening."</span>" );
					}
				}
				$ilustrasi = "";
				//$Koloms[] = array('align="left"',"" );
				$getSumJumlahBarang = sqlArray(sqlQuery("select sum(volume_rek) as total from view_rka_ppkd_1 where k='$k' and l='$l' and m='$m' and n='$n' and o='$o' $kondisiSKPD and no_urut ='$nomorBefore' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'"));
				
				$jumlahBarang = $getSumJumlahBarang['total'];
				//$Koloms[] = array('align="right"', number_format($jumlahBarang ,0,',','.') );
				$Koloms[] = array('align="right"',  );
			 }else{
			 	if($f != '00' && empty($rincian_perhitungan) ){
					$Koloms[] = array('align="left"',"<span style='margin-left:10px;'>&nbsp&nbsp".$namaBarang."</span>" );
					$jumlah = number_format($jumlah ,2,',','.');
					$volume_rek = number_format($volume_rek ,0,',','.');
				}else{
					
					$Koloms[] = array('align="left"',"<span style='margin-left:10px;'>&nbsp&nbsp".$rincian_perhitungan."</span>" );
					$jumlah =  "<input type='hidden' id='hargaSatuanSesuai$id_anggaran' value='$jumlah'>".number_format($jumlah ,2,',','.');
					$volume_rek = "<input type='hidden' id='volumeRekSesuai$id_anggaran' value='$volume_rek'>".number_format($volume_rek ,0,',','.');
				}
			 	
				
				//$Koloms[] = array('align="left"',$ilustrasi );
				$Koloms[] = array('align="right"', $volume_rek );
			 }
			 
			 $Koloms[] = array('align="left"', $satuan_rek );
			 $getSumSatuanRek = sqlArray(sqlQuery("select sum(jumlah) as total from view_rka_ppkd_1 where k='$k' and l='$l' and m='$m' and n='$n'  and o='$o' $kondisiSKPD and no_urut ='$nomorBefore' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'"));
			 $sumSatuanRek = $getSumSatuanRek['total'];
			 if($c1 == '0'){
			 	//$Koloms[] = array('align="right"', number_format($sumSatuanRek ,2,',','.') );
				$Koloms[] = array('align="right"','' );
			 }else{
			 	$Koloms[] = array('align="right"', $jumlah );
			 }
			 
			 if($c1 == '0'){
			 if($k == '0' && $n =='0'){
			 	$getTotalJumalhHarga = sqlArray(sqlQuery("select sum(jumlah_harga) as total from view_rka_ppkd_1 where o1='$o1' $kondisiSKPD $kondisiBelanja and no_urut ='$nomorBefore' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' $blackList"));
			 }else{
			 	$getTotalJumalhHarga = sqlArray(sqlQuery("select sum(jumlah_harga) as total from view_rka_ppkd_1 where k='$k' and l='$l' and m='$m' and n='$n' and o='$o' $kondisiSKPD and no_urut ='$nomorBefore' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' $blackList"));	
			 }
			 $Koloms[] = array('align="right"', " <span style='font-weight:bold;'>".number_format($getTotalJumalhHarga['total'] ,2,',','.')." </span>" );

			 }else{
			 	$Koloms[] = array('align="right"', number_format($jumlah_harga ,2,',','.') );
				
			 }
			 $getAngkaKoreksi = sqlArray(sqlQuery("select * from view_rka_ppkd_1 where c1='$c1' and c='$c' and d='$d'  and e='$e' and e1='$e1'  and id_jenis_pemeliharaan='$id_jenis_pemeliharaan' and  f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and k='$k' and l='$l' and m='$m' and n='$n' and o='$o' and o1='$o1' and rincian_perhitungan ='$rincian_perhitungan'  and id_tahap='$this->idTahap'"));
			 $koreksiVolumeBarang = number_format($getAngkaKoreksi['volume_rek'] ,0,',','.');
			 $koreksiSatuanHarga = number_format($getAngkaKoreksi['jumlah'] ,2,',','.');
			 $koreksiJumlahHarga = number_format($getAngkaKoreksi['volume_rek']  * $getAngkaKoreksi['jumlah'] ,2,',','.');
			 if($getAngkaKoreksi['volume_rek'] > $isi['volume_rek'] ){
			 	$bertambahBerkurangVolumeBarang = number_format($getAngkaKoreksi['volume_rek'] - $isi['volume_rek'] ,0,',','.'); 
			 }elseif($isi['volume_rek'] > $getAngkaKoreksi['volume_rek']){
			 	$bertambahBerkurangVolumeBarang = "( ". number_format( $isi['volume_rek'] - $getAngkaKoreksi['volume_rek'],0,',','.') ." )" ; 
			 }else{
			 	$bertambahBerkurangVolumeBarang = "0";
			 }
			 if(empty($getAngkaKoreksi['c1'])){
				$bertambahBerkurangVolumeBarang = "";			 	
			 }
			 
			 if($getAngkaKoreksi['jumlah'] > $isi['jumlah'] ){
			 	$bertambahBerkurangSatuanHarga = number_format($getAngkaKoreksi['jumlah'] - $isi['jumlah'] ,2,',','.'); 
			 }elseif($isi['jumlah'] > $getAngkaKoreksi['jumlah']){
			 	$bertambahBerkurangSatuanHarga = "( ". number_format( $isi['jumlah'] - $getAngkaKoreksi['jumlah'],2,',','.') ." )" ; 
			 }else{
			 	$bertambahBerkurangSatuanHarga = "0";
			 }
			 if(empty($getAngkaKoreksi['c1'])){
				$bertambahBerkurangSatuanHarga = "";			 	
			 }
			 
			 if($getAngkaKoreksi['jumlah_harga'] > $jumlah_harga ){
			 	$bertambahBerkurangJumlahHarga = number_format($getAngkaKoreksi['jumlah_harga'] - $jumlah_harga ,2,',','.'); 
			 }elseif($jumlah_harga > $getAngkaKoreksi['jumlah_harga']){
			 	$bertambahBerkurangJumlahHarga = "( ". number_format( $jumlah_harga - $getAngkaKoreksi['jumlah_harga'],2,',','.') ." )" ; 
			 }else{
			 	$bertambahBerkurangJumlahHarga = "0";
			 }
			 if(empty($getAngkaKoreksi['c1'])){
				$bertambahBerkurangJumlahHarga = "";			 	
			 }
			 
			 
			 if(empty($rincian_perhitungan)){
			 	$Koloms[] = array('align="right"',"");
			    $Koloms[] = array('align="right"',"");
				 if($c1 =='0'){
				 	if($k == '0' && $n =='0'){
					 	$getTotalJumalhHargaKoreksi = sqlArray(sqlQuery("select sum(jumlah_harga) as total from view_rka_ppkd_1 where  o1='$o1' $kondisiSKPD and id_tahap ='$this->idTahap' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'"));
					 }else{
					   $getTotalJumalhHargaKoreksi = sqlArray(sqlQuery("select sum(jumlah_harga) as total from view_rka_ppkd_1 where k='$k' and l='$l' and m='$m' and n='$n' and o='$o' and o1='$o1' $kondisiSKPD and id_tahap ='$this->idTahap' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'")); 	
					}
					
				 	
				 	
					$Koloms[] = array('align="right"',number_format($getTotalJumalhHargaKoreksi['total'] ,2,',','.'));
				 }
			 }else{
			 	$Koloms[] = array('align="right"',"<span id='spanVolumeBarang".$id_anggaran."'> $koreksiVolumeBarang  </span>");
			    $Koloms[] = array('align="right"',"<span id='spanSatuanHarga".$id_anggaran."'> $koreksiSatuanHarga </span>");
				$Koloms[] = array('align="right"',"<span id='spanJumlahHarga$id_anggaran'>".$koreksiJumlahHarga."</span>");
			 }
			 
		     
			 $aksi  = "<img src='images/administrator/images/valid.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=$this->Prefix.sesuai('$id_anggaran');></img>&nbsp  &nbsp <img src='images/administrator/images/invalid.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=$this->Prefix.koreksi('$id_anggaran');></img> ";
			 if ($rincian_perhitungan == '') {
			 $aksi = "";
			 }
			 if(empty($rincian_perhitungan)){
			 	 $Koloms[] = array('align="right" id="alignButton'.$id_anggaran.'" ',"");
				 $Koloms[] = array('align="right"',"");
				 if($k == '0' && $n =='0'){
					$getTotalJumalhHargaKoreksi = sqlArray(sqlQuery("select sum(jumlah_harga) as total from view_rka_ppkd_1 where  o1='$o1' $kondisiSKPD and id_tahap ='$this->idTahap' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'"));
					$kurangLebihPekerjaan = $getTotalJumalhHarga['total'] - $getTotalJumalhHargaKoreksi['total'];
					if($kurangLebihPekerjaan == 0){
						$Koloms[] = array('align="right"','0');
					}else{
						if($kurangLebihPekerjaan < 0){
							$kurangLebihPekerjaan = $getTotalJumalhHargaKoreksi['total'] - $getTotalJumalhHarga['total']  ;
							$Koloms[] = array('align="right"',number_format($kurangLebihPekerjaan ,2,',','.'));
						}else{
							$Koloms[] = array('align="right"',"( ".number_format($kurangLebihPekerjaan ,2,',','.')." )");
						}
						
					}
					
				 }else{
				   $getTotalJumalhHargaKoreksi = sqlArray(sqlQuery("select sum(jumlah_harga) as total from view_rka_ppkd_1 where k='$k' and l='$l' and m='$m' and n='$n' and o='$o' and o1='$o1' $kondisiSKPD and id_tahap ='$this->idTahap' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'")); 	
					$kurangLebihRekening = $getTotalJumalhHarga['total'] - $getTotalJumalhHargaKoreksi['total'];
					if($kurangLebihRekening == 0){
						$Koloms[] = array('align="right"',"<span style='font-weight:bold;'>".'0'."</span>");
					}else{
						if($kurangLebihRekening < 0){
							$kurangLebihRekening =  $getTotalJumalhHargaKoreksi['total'] - $getTotalJumalhHarga['total']   ;
							$Koloms[] = array('align="right"',"<span style='font-weight:bold;'>".number_format($kurangLebihRekening ,2,',','.')."</span>");
						}else{
							$Koloms[] = array('align="right"',"<span style='font-weight:bold;'>"."( ".number_format($kurangLebihRekening ,2,',','.')." )"."</span>");
						}
						
					}
				 }
				 
			 }else{
			 	$Koloms[] = array('align="right" id="alignButton'.$id_anggaran.'" ',$bertambahBerkurangVolumeBarang."</span>");
			 	$Koloms[] = array('align="right"',$bertambahBerkurangSatuanHarga);
			 	$Koloms[] = array('align="right"',$bertambahBerkurangJumlahHarga);
			 }
			 
			 $Koloms[] = array('align="center"',"<span id='buttonSubmitKoreksi$id_anggaran' >".$aksi."</span>");
	 }else{
	 	if($this->jenisFormTerakhir == "KOREKSI"){
			 $nomorBefore = $this->urutTerakhir - 1;
			 $getRApbd = sqlArray(sqlQuery("select * from view_rka_ppkd_1 where no_urut = '$nomorBefore' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' "));
			 if($getRApbd['jenis_form_modul'] != "PENYUSUNAN" && $getRApbd['jenis_form_modul'] != "KOREKSI"){
					$nomorBefore = $nomorBefore - 1;		
			 }
			 $getLastTahap = sqlArray(sqlQuery("select * from view_rka_ppkd_1 where no_urut = '$nomorBefore' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'"));
			 $blackList = "";
			 if($getLastTahap['jenis_form_modul'] == "PENYUSUNAN" && $this->wajibValidasi == TRUE){
				$getAllChild = sqlQuery("select * from view_rka_ppkd_1 where id_tahap = '".$getLastTahap['id_tahap']."' and (rincian_perhitungan !='' or j !='000'  and status_validasi !='1' )");			
				while($black = sqlArray($getAllChild)){
					$blackList .= " and id_anggaran !='".$black['id_anggaran']."'";
				}
		     }
			 
			 $getNamaRekening = sqlArray(sqlQuery("select * from ref_rekening where k='$k' and l ='$l' and m='$m' and n='$n' and o='$o'"));
			 $namaRekening = $getNamaRekening['nm_rekening'];
			 $getNamaBarang = sqlArray(sqlQuery("select * from ref_barang where  f='$f' and g='$g' and h='$h' and i='$i' and j='$j'"));
			 $namaBarang = $getNamaBarang['nm_barang'];
			 $satuanBarang = $getNamaBarang['satuan'];
			 $Koloms = array();
		 	 $bk = $isi['bk'];
			 $ck = $isi['ck'];
			 $p = $isi['p'];
			 $q = $isi['q'];
			 if($c1 == '0'){
				if(strlen($k) > 1){
					$Koloms[] = array(' align="left"', "<span style='color:red;'>x.x.x.xx.xx</span>" );
				}else{
					if($k == '0' && $n == '0'){
						
						$Koloms[] = array(' align="left"',"<span style='font-weight:bold'></span>" );
					}else{
						$Koloms[] = array(' align="left"',"<span>".$k.".".$l.".".$m.".".$n.".".$o ."</span>" );
					}
				}	
			 	
			 }else{
			 	if($k == ''){
					$Koloms[] = array(' align="center"', "" );
				}else{
					$Koloms[] = array(' align="left"', '' );
				}
			 	
			 }
			 
			 if($jumlah1 == 0 && $satuan1 =='' ){
			 	$ilustrasi = "";	
			 }
			 elseif($jumlah3 == 0 && $satuan3 == ''){
			 	$ilustrasi = $jumlah1." ".$satuan1." x ". " ".$jumlah2." ".$satuan2;
			 }else{
			 	$ilustrasi = $jumlah1." ".$satuan1." x ". " ".$jumlah2." ".$satuan2." x ".$jumlah3." ".$satuan3;
			 }
			 if($c1 == '0'){
			 	if(strlen($k) > 1){
					$Koloms[] = array('align="left"',"<span style='color:red;'> Belanja xxx </span>" );
				}else{
					if($k == '0' && $n == '0'){
						$getNamaPekerjaan = sqlArray(sqlQuery("select * from ref_pekerjaan where id = '$o1'"));
						
						$this->publicVar += 1;
						
						$Koloms[] = array('align="left"',"<span style='font-weight:bold;'>$this->publicVar. ".$getNamaPekerjaan['nama_pekerjaan']."</span>" );
					}else{
						$jarak = '15px';
				 		$cekAdaParent = sqlNumRow(sqlQuery("select * from view_rka_ppkd_1 where no_urut = '$nomorBefore' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and o1 = '$o1' and o1 !='0' and o1 !='' "));
						if($cekAdaParent == 0)$jarak = "0px";
						$Koloms[] = array('align="left"',"<span style='margin-left:$jarak;font-weight:bold;'>".$namaRekening."</span>" );
					}
				}
				$ilustrasi = "";
				//$Koloms[] = array('align="left"',"" );
				$getSumJumlahBarang = sqlArray(sqlQuery("select sum(volume_rek) as total from view_rka_ppkd_1 where k='$k' and l='$l' and m='$m' and n='$n' and o='$o' $kondisiSKPD and no_urut ='$nomorBefore' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'"));
				
				$jumlahBarang = $getSumJumlahBarang['total'];
				//$Koloms[] = array('align="right"', number_format($jumlahBarang ,0,',','.') );
				$Koloms[] = array('align="right"',  );
			 }else{
			 	if($f != '00' && empty($rincian_perhitungan) ){
					$Koloms[] = array('align="left"',"<span style='margin-left:10px;'>&nbsp&nbsp".$namaBarang."</span>" );
					$jumlah = number_format($jumlah ,2,',','.');
					$volume_rek = number_format($volume_rek ,0,',','.');
				}else{
					
					$Koloms[] = array('align="left"',"<span style='margin-left:10px;'>&nbsp&nbsp".$rincian_perhitungan."</span>" );
					$jumlah =  "<input type='hidden' id='hargaSatuanSesuai$id_anggaran' value='$jumlah'>".number_format($jumlah ,2,',','.');
					$volume_rek = "<input type='hidden' id='volumeRekSesuai$id_anggaran' value='$volume_rek'>".number_format($volume_rek ,0,',','.');
				}
			 	
				
				//$Koloms[] = array('align="left"',$ilustrasi );
				$Koloms[] = array('align="right"', $volume_rek );
			 }
			 
			 $Koloms[] = array('align="left"', $satuan_rek );
			 $getSumSatuanRek = sqlArray(sqlQuery("select sum(jumlah) as total from view_rka_ppkd_1 where k='$k' and l='$l' and m='$m' and n='$n'  and o='$o' $kondisiSKPD and no_urut ='$nomorBefore' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'"));
			 $sumSatuanRek = $getSumSatuanRek['total'];
			 if($c1 == '0'){
			 	//$Koloms[] = array('align="right"', number_format($sumSatuanRek ,2,',','.') );
				$Koloms[] = array('align="right"','' );
			 }else{
			 	$Koloms[] = array('align="right"', $jumlah );
			 }
			 
			 if($c1 == '0'){
			 if($k == '0' && $n =='0'){
			 	$getTotalJumalhHarga = sqlArray(sqlQuery("select sum(jumlah_harga) as total from view_rka_ppkd_1 where o1='$o1' $kondisiSKPD $kondisiBelanja and no_urut ='$nomorBefore' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' $blackList"));
			 }else{
			 	$getTotalJumalhHarga = sqlArray(sqlQuery("select sum(jumlah_harga) as total from view_rka_ppkd_1 where k='$k' and l='$l' and m='$m' and n='$n' and o='$o' $kondisiSKPD and no_urut ='$nomorBefore' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' $blackList"));	
			 }
			 $Koloms[] = array('align="right"', " <span style='font-weight:bold;'>".number_format($getTotalJumalhHarga['total'] ,2,',','.')." </span>" );

			 }else{
			 	$Koloms[] = array('align="right"', number_format($jumlah_harga ,2,',','.') );
				
			 }
			 $getAngkaKoreksi = sqlArray(sqlQuery("select * from view_rka_ppkd_1 where c1='$c1' and c='$c' and d='$d'  and e='$e' and e1='$e1'  and id_jenis_pemeliharaan='$id_jenis_pemeliharaan' and  f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and k='$k' and l='$l' and m='$m' and n='$n' and o='$o' and o1='$o1' and rincian_perhitungan ='$rincian_perhitungan'  and no_urut='$this->urutTerakhir' and tahun='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran'"));
			 $koreksiVolumeBarang = number_format($getAngkaKoreksi['volume_rek'] ,0,',','.');
			 $koreksiSatuanHarga = number_format($getAngkaKoreksi['jumlah'] ,2,',','.');
			 $koreksiJumlahHarga = number_format($getAngkaKoreksi['volume_rek']  * $getAngkaKoreksi['jumlah'] ,2,',','.');
			 if($getAngkaKoreksi['volume_rek'] > $isi['volume_rek'] ){
			 	$bertambahBerkurangVolumeBarang = number_format($getAngkaKoreksi['volume_rek'] - $isi['volume_rek'] ,0,',','.'); 
			 }elseif($isi['volume_rek'] > $getAngkaKoreksi['volume_rek']){
			 	$bertambahBerkurangVolumeBarang = "( ". number_format( $isi['volume_rek'] - $getAngkaKoreksi['volume_rek'],0,',','.') ." )" ; 
			 }else{
			 	$bertambahBerkurangVolumeBarang = "0";
			 }
			 if(empty($getAngkaKoreksi['c1'])){
				$bertambahBerkurangVolumeBarang = "";			 	
			 }
			 
			 if($getAngkaKoreksi['jumlah'] > $isi['jumlah'] ){
			 	$bertambahBerkurangSatuanHarga = number_format($getAngkaKoreksi['jumlah'] - $isi['jumlah'] ,2,',','.'); 
			 }elseif($isi['jumlah'] > $getAngkaKoreksi['jumlah']){
			 	$bertambahBerkurangSatuanHarga = "( ". number_format( $isi['jumlah'] - $getAngkaKoreksi['jumlah'],2,',','.') ." )" ; 
			 }else{
			 	$bertambahBerkurangSatuanHarga = "0";
			 }
			 if(empty($getAngkaKoreksi['c1'])){
				$bertambahBerkurangSatuanHarga = "";			 	
			 }
			 
			 if($getAngkaKoreksi['jumlah_harga'] > $jumlah_harga ){
			 	$bertambahBerkurangJumlahHarga = number_format($getAngkaKoreksi['jumlah_harga'] - $jumlah_harga ,2,',','.'); 
			 }elseif($jumlah_harga > $getAngkaKoreksi['jumlah_harga']){
			 	$bertambahBerkurangJumlahHarga = "( ". number_format( $jumlah_harga - $getAngkaKoreksi['jumlah_harga'],2,',','.') ." )" ; 
			 }else{
			 	$bertambahBerkurangJumlahHarga = "0";
			 }
			 if(empty($getAngkaKoreksi['c1'])){
				$bertambahBerkurangJumlahHarga = "";			 	
			 }
			 
			 
			 if(empty($rincian_perhitungan)){
			 	$Koloms[] = array('align="right"',"");
			    $Koloms[] = array('align="right"',"");
				 if($c1 =='0'){
				 	if($k == '0' && $n =='0'){
					 	$getTotalJumalhHargaKoreksi = sqlArray(sqlQuery("select sum(jumlah_harga) as total from view_rka_ppkd_1 where  o1='$o1' $kondisiSKPD and no_urut='$this->urutTerakhir' and tahun='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran'"));
					 }else{
					   $getTotalJumalhHargaKoreksi = sqlArray(sqlQuery("select sum(jumlah_harga) as total from view_rka_ppkd_1 where k='$k' and l='$l' and m='$m' and n='$n' and o='$o' and o1='$o1' $kondisiSKPD and no_urut='$this->urutTerakhir' and tahun='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran'")); 	
					}
					
				 	
				 	
					$Koloms[] = array('align="right"',number_format($getTotalJumalhHargaKoreksi['total'] ,2,',','.'));
				 }
			 }else{
			 	$Koloms[] = array('align="right"',"<span id='spanVolumeBarang".$id_anggaran."'> $koreksiVolumeBarang  </span>");
			    $Koloms[] = array('align="right"',"<span id='spanSatuanHarga".$id_anggaran."'> $koreksiSatuanHarga </span>");
				$Koloms[] = array('align="right"',"<span id='spanJumlahHarga$id_anggaran'>".$koreksiJumlahHarga."</span>");
			 }
			 
		     
			 $aksi  = "<img src='images/administrator/images/valid.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=$this->Prefix.sesuai('$id_anggaran');></img>&nbsp  &nbsp <img src='images/administrator/images/invalid.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=$this->Prefix.koreksi('$id_anggaran');></img> ";
			 if ($rincian_perhitungan == '') {
			 $aksi = "";
			 }
			 if(empty($rincian_perhitungan)){
			 	 $Koloms[] = array('align="right" id="alignButton'.$id_anggaran.'" ',"");
				 $Koloms[] = array('align="right"',"");
				 if($k == '0' && $n =='0'){
					$getTotalJumalhHargaKoreksi = sqlArray(sqlQuery("select sum(jumlah_harga) as total from view_rka_ppkd_1 where  o1='$o1' $kondisiSKPD and no_urut='$this->urutTerakhir' and tahun='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran'"));
					$kurangLebihPekerjaan = $getTotalJumalhHarga['total'] - $getTotalJumalhHargaKoreksi['total'];
					if($kurangLebihPekerjaan == 0){
						$Koloms[] = array('align="right"','0');
					}else{
						if($kurangLebihPekerjaan < 0){
							$kurangLebihPekerjaan = $getTotalJumalhHargaKoreksi['total'] - $getTotalJumalhHarga['total']  ;
							$Koloms[] = array('align="right"',number_format($kurangLebihPekerjaan ,2,',','.'));
						}else{
							$Koloms[] = array('align="right"',"( ".number_format($kurangLebihPekerjaan ,2,',','.')." )");
						}
						
					}
					
				 }else{
				   $getTotalJumalhHargaKoreksi = sqlArray(sqlQuery("select sum(jumlah_harga) as total from view_rka_ppkd_1 where k='$k' and l='$l' and m='$m' and n='$n' and o='$o' and o1='$o1' $kondisiSKPD and no_urut='$this->urutTerakhir' and tahun='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran'")); 	
					$kurangLebihRekening = $getTotalJumalhHarga['total'] - $getTotalJumalhHargaKoreksi['total'];
					if($kurangLebihRekening == 0){
						$Koloms[] = array('align="right"',"<span style='font-weight:bold;'>".'0'."</span>");
					}else{
						if($kurangLebihRekening < 0){
							$kurangLebihRekening =  $getTotalJumalhHargaKoreksi['total'] - $getTotalJumalhHarga['total']   ;
							$Koloms[] = array('align="right"',"<span style='font-weight:bold;'>".number_format($kurangLebihRekening ,2,',','.')."</span>");
						}else{
							$Koloms[] = array('align="right"',"<span style='font-weight:bold;'>"."( ".number_format($kurangLebihRekening ,2,',','.')." )"."</span>");
						}
						
					}
				 }
				 
			 }else{
			 	$Koloms[] = array('align="right" id="alignButton'.$id_anggaran.'" ',$bertambahBerkurangVolumeBarang."</span>");
			 	$Koloms[] = array('align="right"',$bertambahBerkurangSatuanHarga);
			 	$Koloms[] = array('align="right"',$bertambahBerkurangJumlahHarga);
			 }
			 
		}elseif($this->jenisFormTerakhir == "PENYUSUNAN"){
			 $getIDTahap = sqlArray(sqlQuery("select * from ref_tahap_anggaran where no_urut ='$this->urutTerakhir' and tahun ='$this->tahun' and anggaran='$this->jenisAnggaran'"));			
			 $idTahap = $getIDTahap['id_tahap'];
			 $getNamaRekening = sqlArray(sqlQuery("select * from ref_rekening where k='$k' and l ='$l' and m='$m' and n='$n' and o='$o'"));
			 $namaRekening = $getNamaRekening['nm_rekening'];
			 $getNamaBarang = sqlArray(sqlQuery("select * from ref_barang where  f='$f' and g='$g' and h='$h' and i='$i' and j='$j'"));
			 $namaBarang = $getNamaBarang['nm_barang'];
			 $satuanBarang = $getNamaBarang['satuan'];
			 $Koloms = array();
		 	
			 if($c1 == '0'){
			 	if($k == '0' && $n == '0')  $TampilCheckBox = '';
				if(strlen($k) > 1){
					$Koloms[] = array(' align="left"', "<span style='color:red;'>x.x.x.xx.xx</span>" );
				}else{
					if($k == '0' && $n == '0'){
						
						$Koloms[] = array(' align="left"',"<span style='font-weight:bold'></span>" );
					}else{
						$Koloms[] = array(' align="left"',"<span>".$k.".".$l.".".$m.".".$n.".".$o ."</span>" );
					}
				}	
			 	
			 }else{
			 	if($k == ''){
					$Koloms[] = array(' align="center"', "" );
				}else{
					$Koloms[] = array(' align="left"', '' );
				}
			 	
			 }
			 
			 if($jumlah1 == 0 && $satuan1 =='' ){
			 	$ilustrasi = "";	
			 }
			 elseif($jumlah3 == 0 && $satuan3 == ''){
			 	$ilustrasi = $jumlah1." ".$satuan1." x ". " ".$jumlah2." ".$satuan2;
			 }else{
			 	$ilustrasi = $jumlah1." ".$satuan1." x ". " ".$jumlah2." ".$satuan2." x ".$jumlah3." ".$satuan3;
			 }
			 if($c1 == '0'){
			 	if(strlen($k) > 1){
					$Koloms[] = array('align="left"',"<span style='color:red;'> Belanja xxx </span>" );
				}else{
					if($k == '0' && $n == '0'){
						$getNamaPekerjaan = sqlArray(sqlQuery("select * from ref_pekerjaan where id = '$o1'"));
						
						$this->publicVar += 1;
						
						$Koloms[] = array('align="left"',"<span style='font-weight:bold;'>$this->publicVar. ".$getNamaPekerjaan['nama_pekerjaan']."</span>" );
					}else{
						$jarak = '15px';
				 		$cekAdaParent = sqlNumRow(sqlQuery("select * from view_rka_ppkd_1 where id_tahap = '$idTahap' and o1 = '$o1' and o1 !='0' and o1 !='' "));
						if($cekAdaParent == 0)$jarak = "0px";
						$Koloms[] = array('align="left"',"<span style='margin-left:$jarak;font-weight:bold;'>".$namaRekening."</span>" );
					}
					
				}
				$ilustrasi = "";
				$getSumJumlahBarang = sqlArray(sqlQuery("select sum(volume_rek) as total from view_rka_ppkd_1 where k='$k' and l='$l' and m='$m' and n='$n' and o='$o' $kondisiSKPD and id_tahap='$idTahap'"));
				$Koloms[] = array('align="left"',"" );
				$jumlahBarang = $getSumJumlahBarang['total'];
				//$Koloms[] = array('align="right"', number_format($jumlahBarang ,0,',','.') );
				
			 }else{
			 	if($f != '00' && empty($rincian_perhitungan) ){
					$Koloms[] = array('align="left"',"<span style='margin-left:20px;'>&nbsp&nbsp".$namaBarang."</span>" );
					$jumlah = number_format($jumlah ,2,',','.');
					$volume_rek = number_format($volume_rek ,0,',','.');
				}else{
					
					$Koloms[] = array('align="left"',"<span style='margin-left:20px;'>&nbsp&nbsp".$rincian_perhitungan."</span>" );
					$jumlah = number_format($jumlah ,2,',','.');
					$volume_rek = number_format($volume_rek ,0,',','.');
				}
			 	
				
				$Koloms[] = array('align="right"', $volume_rek );
			 }
			 
			 $Koloms[] = array('align="left"', $satuan_rek );
			 $getSumSatuanRek = sqlArray(sqlQuery("select sum(jumlah) as total from view_rka_ppkd_1 where k='$k' and l='$l' and m='$m' and n='$n'  and o='$o' $kondisiSKPD and id_tahap='$idTahap'"));
			 $sumSatuanRek = $getSumSatuanRek['total'];
			 if($c1 == '0'){
			 	//$Koloms[] = array('align="right"', number_format($sumSatuanRek ,2,',','.') );
				$Koloms[] = array('align="right"','' );
			 }else{
			 	$Koloms[] = array('align="right"', $jumlah );
			 }
			 
			 if($c1 == '0'){
			 if($k == '0' && $n =='0'){
			 	$getTotalJumalhHarga = sqlArray(sqlQuery("select sum(jumlah_harga) as total from view_rka_ppkd_1 where o1='$o1' $kondisiSKPD $kondisiBelanja and id_tahap='$idTahap'"));
			 }else{
			 	$getTotalJumalhHarga = sqlArray(sqlQuery("select sum(jumlah_harga) as total from view_rka_ppkd_1 where k='$k' and l='$l' and m='$m' and n='$n' and o='$o' $kondisiSKPD and id_tahap='$idTahap'"));	
			 }
			 $Koloms[] = array('align="right"', "<span style='font-weight:bold;'>".number_format($getTotalJumalhHarga['total'] ,2,',','.')."</span>" );
			 if($this->wajibValidasi == TRUE)$Koloms[] = array('align="center"', "");
			 }else{
			 	$Koloms[] = array('align="right"', number_format($jumlah_harga ,2,',','.') );
				if ($status_validasi =='1') {
			 	$validnya = "valid.png";
			 }else{
			 	$validnya = "invalid.png";
			 }
			 
			 
			 if($this->wajibValidasi == TRUE){
			 	if($rincian_perhitungan != '' ){
				 $Koloms[] = array('align="center"', "<img src='images/administrator/images/$validnya' width='20px' heigh='20px' style='cursor:pointer;' >;");
				 
				 }else{
				 $Koloms[] = array('align="center"', "");
				 }
			 }
			 
		}
		}
	 }

	 return $Koloms;
	}


	function Validasi($dt){	
	 global $SensusTmp;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 400;
	 $this->form_height = 120;
	 $this->form_caption = 'VALIDASI RKA-PPKD 1';
	  $kode = $dt['c1'].".".$dt['c'].".".$dt['d'].".".$dt['e'].".".$dt['e1'].".".$dt['bk'].".".$dt['ck'].".".$dt['p'].".".$dt['q'].".".$dt['o1'];
	  if ($dt['status_validasi'] == '1') {
	  	//2017-03-30 17:12:16
		// $tglvalidnya = $dt['tgl_validasi'];
		// $thn1 = substr($tglvalidnya,0,4); 
		// $bln1 = substr($tglvalidnya,5,2); 
		// $tgl1 = substr($tglvalidnya,8,2); 
		// $jam1 = substr($tglvalidnya,11,8);
		$arrayTanggalValidasi = explode("-", $dt['tanggal_validasi']);

		$tglvalid = $arrayTanggalValidasi[2]."-".$arrayTanggalValidasi[1]."-".$arrayTanggalValidasi[0];
		$username = $dt['user_validasi'];
		$checked = "checked='checked'";			
	  }else{			
		$tglvalid = date("d-m-Y");
		$checked = "";	
		$username = $_COOKIE['coID'];
	  }
	    //ambil data trefditeruskan
	  	$query = "" ;$cek .=$query;
	  	$res = sqlQuery($query);
		
	 //items ----------------------
	  $this->form_fields = array(
			'kode' => array( 
						'label'=>'KODE',
						'labelWidth'=>100, 
						'value'=>$kode, 
						'type'=>'text',
						'param'=>"style='width:250px;' readonly"
						 ),
			'tgl_validasi' => array( 
						'label'=>'TANGGAL',
						'labelWidth'=>100, 
						'value'=>$tglvalid, 
						'type'=>'text',
						'param'=>"style='width:125px;' readonly"
						 ),

			'username' => array( 
						'label'=>'USERNAME',
						'labelWidth'=>100, 
						'value'=>$username ,
						'type'=>'text',
						'param'=>"style='width:250px;' readonly"
						 ),
			'validasi' => array( 
						'label'=>'VALIDASI DATA',
						'labelWidth'=>100, 
						'value'=>"<input type='checkbox' name='validasi' $checked style='margin-left:-1px;' />",
						 ),					
			
			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SaveValid()' title='Simpan' >   ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function Catatan($dt){	
	 global $SensusTmp;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 400;
	 $this->form_height = 120;
	 $this->form_caption = 'CATATAN';
	 $catatan = $dt['catatan'];
	 $idnya = $dt['id_anggaran'];
	 	
	 //items ----------------------
	  $this->form_fields = array(
			'catatan' => array( 
						'label'=>'CATATAN',
						'labelWidth'=>100, 
						'value'=>"<textarea id='catatan' name='catatan' style='width:100%; height : 100px;'>".$catatan."</textarea>",
						 ),					
			
			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SaveCatatan($idnya)' title='Simpan' >   ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	
	function genDaftarOpsi(){
	 global $Ref, $Main;
	 
	 
	 $arrOrder = array(
				     	array('nama_tahap','NAMA TAHAP'),		
						array('waktu_aktif','WAKTU AKTIF'),	
						array('waktu_pasif','WAKTU PASIF'),
						array('modul','MODUL'),
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
	
	$selectedC1 = $_REQUEST['cmbUrusan'];
	$selectedC  = $_REQUEST['cmbBidang'];
	$selectedD = $_REQUEST['cmbSKPD'];
	$selectedE = $_REQUEST['cmbUnit'];
	$selectedE1 = $_REQUEST['cmbSubUnit'];
	
	
	if(!isset($selectedC1) ){
	   		$arrayData = sqlArray(sqlQuery("select * from current_filter where username ='".$_COOKIE['coID']."'"));
			foreach ($arrayData as $key => $value) { 
			  $$key = $value; 
			 }
			if($CurrentSKPD !='00' ){
				$selectedD = $CurrentSKPD;
				$selectedC = $CurrentBidang;
				$selectedC1 = $CurrentUrusan;
				
			}elseif($CurrentBidang !='00'){
				$selectedC = $CurrentBidang;
				$selectedC1 = $CurrentUrusan;
	
			}elseif($CurrentUrusan !='0'){
				$selectedC1 = $CurrentUrusan;
			}
	   }
	
	
	
	
	foreach ($_COOKIE as $key => $value) { 
				  $$key = $value; 
			}
		if($VulnWalkerSKPD != '00'){
			$selectedD = $VulnWalkerSKPD;
			$selectedC = $VulnWalkerBidang;
			$selectedC1 = $VulnWalkerUrusan;
		}elseif($VulnWalkerBidang != '00'){
			$selectedC = $VulnWalkerBidang;
			$selectedC1 = $VulnWalkerUrusan;
		}elseif($VulnWalkerUrusan != '0'){
			$selectedC1 = $VulnWalkerUrusan;
		}
		$codeAndNameUrusan = "select c1, concat(c1, '. ', nm_skpd) from ref_skpd where c='00' and d='00' and e='00' and e1='000' ";
		$urusan = cmbQuery('cmbUrusan',$selectedC1,$codeAndNameUrusan,'onchange=rkaPPKD1_v2.refreshList(true);','-- URUSAN --');
		
		$codeAndNameBidang = "select c, concat(c, '. ', nm_skpd) from ref_skpd where c1='$selectedC1' and c !='00' and d='00' and e='00' and e1='000' ";
		$bidang = cmbQuery('cmbBidang',$selectedC,$codeAndNameBidang,'onchange=rkaPPKD1_v2.refreshList(true);','-- BIDANG --');
		
		$codeAndNameSKPD = "select d, concat(d, '. ', nm_skpd) from ref_skpd where c1='$selectedC1' and c='$selectedC' and d!='00' and e='00' and e1='000' ";
		$skpd= cmbQuery('cmbSKPD',$selectedD,$codeAndNameSKPD,'onchange=rkaPPKD1_v2.refreshList(true);','-- SKPD --');
		
		$codeAndNameUnit = "select e, concat(e, '. ', nm_skpd) from ref_skpd where c1='$selectedC1' and c='$selectedC' and d='$selectedD' and e!='00' and e1='000' ";
		$unit = cmbQuery('cmbUnit',$selectedE,$codeAndNameUnit,'onchange=rkaPPKD1_v2.refreshList(true);','-- UNIT --');
		
		
		$codeAndNameSubUnit = "select e1, concat(e1, '. ', nm_skpd) from ref_skpd where c1='$selectedC1' and c='$selectedC' and d='$selectedD' and e='$selectedE' and e1!='000' ";
		$subunit = cmbQuery('cmbSubUnit',$selectedE1,$codeAndNameSubUnit,'onchange=rkaPPKD1_v2.refreshList(true);','-- SUB UNIT --');
	
	
	
	$get1 = sqlArray(sqlQuery("select max(id_anggaran) as max from view_rkbmd "));
	$maxID = $get1['max'];
	$get2 = sqlArray(sqlQuery("select * from view_rkbmd where id_anggaran = '$maxID' "));
	$nomorUrutSebelumnya =  $get2['no_urut'];

	
	
	
	
	
	
	
	
	$TampilOpt = 
			"<div class='FilterBar' style='margin-top:5px;'>".
			"<table style='width:100%'>
			<tr>
			<td>URUSAN </td>
			<td>:</td>
			<td style='width:86%;'> 
			".$urusan."
			</td>
			</tr>
			<tr>
			<td>BIDANG</td>
			<td>:</td>
			<td style='width:86%;'>
			".$bidang."
			</td>
			</tr>
			<tr>
			<td>SKPD</td>
			<td>:</td>
			<td style='width:86%;'>
			".$skpd."
			</td>
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
		$nomorUrutSebelumnya = $this->nomorUrut - 1;		
		$arrKondisi = array();		
		$arrKondisi[] = ' 1 = 1';
		$fmPILCARI = $_REQUEST['fmPILCARI'];	
		$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];
		//cari tgl,bln,thn

	
		$cmbJenisRKA = $_REQUEST['cmbJenisRKA'];
		
		foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
			 }
			
		
		if(isset($cmbSKPD)){
			$data = array("CurrentUrusan" => $cmbUrusan,
					  "CurrentBidang" => $cmbBidang,
					  "CurrentSKPD" => $cmbSKPD,
					  
					  );
		}elseif(isset($cmbBidang)){
			$data = array("CurrentUrusan" => $cmbUrusan,
					  "CurrentBidang" => $cmbBidang,
					  
					  );
		}elseif(isset($cmbUrusan)){
			$data = array("CurrentUrusan" => $cmbUrusan
			
			 );
		}
		
		sqlQuery(VulnWalkerUpdate("current_filter",$data,"username='$this->username'"));
		
		if(!isset($cmbUrusan) ){
	   		$arrayData = sqlArray(sqlQuery("select * from current_filter where username ='".$_COOKIE['coID']."'"));
			foreach ($arrayData as $key => $value) { 
			  $$key = $value; 
			 }
			 if($CurrentSKPD !='00' ){
				$cmbSKPD = $CurrentSKPD;
				$cmbBidang = $CurrentBidang;
				$cmbUrusan = $CurrentUrusan;
				
			}elseif($CurrentBidang !='00'){
				$cmbBidang = $CurrentBidang;
				$cmbUrusan = $CurrentUrusan;
	
			}elseif($CurrentUrusan !='0'){
				$cmbUrusan = $CurrentUrusan;
			}
	   }
	  if(isset($cmbUrusan) && $cmbUrusan== ''){
	   		$cmbBidang = "";
			$cmbSKPD = "";
	   }elseif(isset($cmbBidang) && $cmbBidang== ''){
			$cmbSKPD = "";

	   }elseif(isset($cmbSKPD) && $cmbSKPD== ''){
	   }
		
			if($cmbSKPD != ''){
				$arrKondisi[] = "c1 = '$cmbUrusan'";
				$arrKondisi[] = "c = '$cmbBidang'";
				$arrKondisi[] = "d = '$cmbSKPD'";
				$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD'  ";
			}elseif($cmbBidang != ''){
				$arrKondisi[] = "c1 = '$cmbUrusan'";
				$arrKondisi[] = "c = '$cmbBidang'";
				$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang'  ";
			}elseif($cmbUrusan != ''){
				$arrKondisi[] = "c1 = '$cmbUrusan'";
				$kondisiSKPD = "and c1='$cmbUrusan'";
			}
		
		
		
		
			$arrKondisi[] = "c1 != '0'";
		if($this->jenisForm == 'PENYUSUNAN'){
			$getAllParent = sqlQuery("select * from view_rka_ppkd_1 where id_tahap ='$this->idTahap'  and o1 !='0' and k='0' and n='0' and rincian_perhitungan=''  ");	
			while($rows = sqlArray($getAllParent)){
				foreach ($rows as $key => $value) { 
			 	 $$key = $value; 
				}
				$cekPekerjaan = sqlNumRow(sqlQuery("select * from view_rka_ppkd_1 where o1 = '$o1' and id_tahap ='$this->idTahap' $kondisiRekening $kondisiSKPD and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
				if($cekPekerjaan == 0){
					$arrKondisi[] = "o1 !='$o1'";
				}else{
					$arrKondisi[] = " id_tahap='$this->idTahap'  or id_anggaran = '$id_anggaran' ";
					$getAllRekening = sqlQuery("select * from view_rka_ppkd_1 where id_tahap = '$this->idTahap'  and c1 = '0' and j ='000' and rincian_perhitungan = '' and k!='0' and n !='0'  ");				
					while($row2s = sqlArray($getAllRekening)){
						foreach ($row2s as $key => $value) { 
					 	 $$key = $value; 
						}
						$cekRekening = sqlNumRow(sqlQuery("select * from view_rka_ppkd_1 where k ='$k' and l='$l' and m='$m' and n='$n' and o='$o' and id_tahap ='$this->idTahap' $kondisiRekening $kondisiSKPD and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
						if($cekRekening == 0){
							$concat = $k.".".$l.".".$m.".".$n.".".$o;
							$arrKondisi[] = "concat(k,'.',l,'.',m,'.',n,'.',o)  !='$concat'";
						}else{
							$arrKondisi[] = " id_tahap='$this->idTahap'  or id_anggaran = '$id_anggaran'  ";
							
							
						}	
					}	
				}
			}
		
					
				$grabNonMapingRekening= sqlQuery("select * from view_rka_ppkd_1 where id_tahap ='$this->idTahap' and (LENGTH(k) > 1) and rincian_perhitungan=''");
				while($got = sqlArray($grabNonMapingRekening)){
					if(sqlNumRow(sqlQuery("select * from view_rka_ppkd_1 where id_tahap ='$this->idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and rincian_perhitungan!=''  $kondisiSKPD ")) != 0){
						$arrKondisi[] = "id_tahap = '$this->idTahap' or id_anggaran ='".$got['id_anggaran']."'";
					}
					
				}
				$grabNonHostedRekening= sqlQuery("select * from view_rka_ppkd_1 where id_tahap ='$this->idTahap' and (LENGTH(k) = 1 and k !='0') and rincian_perhitungan=''");
				while($got = sqlArray($grabNonHostedRekening)){
					if(sqlNumRow(sqlQuery("select * from view_rka_ppkd_1 where id_tahap ='$this->idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and rincian_perhitungan!=''  $kondisiSKPD ")) != 0){
						$arrKondisi[] = "id_tahap = '$this->idTahap' or id_anggaran ='".$got['id_anggaran']."'";
					}
					
				}
				
					
			$arrKondisi[] = "id_tahap = '$this->idTahap' ";
			
		}elseif($this->jenisForm == 'KOREKSI'){
			$nomorUrutSebelumnya = $this->nomorUrut - 1;
			$getRApbd = sqlArray(sqlQuery("select * from view_rka_ppkd_1 where no_urut = '$nomorUrutSebelumnya' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' "));
			if($getRApbd['jenis_form_modul'] != "PENYUSUNAN" && $getRApbd['jenis_form_modul'] != "KOREKSI"){
				$nomorUrutSebelumnya = $nomorUrutSebelumnya - 1;		
			}
			$getLastTahap = sqlArray(sqlQuery("select * from view_rka_ppkd_1 where no_urut = '$nomorUrutSebelumnya' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'"));
			$blackList = "";
			if($getLastTahap['jenis_form_modul'] == "PENYUSUNAN" && $this->wajibValidasi == TRUE){
				$getAllChild = sqlQuery("select * from view_rka_ppkd_1 where id_tahap = '".$getLastTahap['id_tahap']."' and (rincian_perhitungan !='' or j !='000'  and status_validasi !='1' )");			
				while($black = sqlArray($getAllChild)){
					$blackList .= " and id_anggaran !='".$black['id_anggaran']."'";
				}
			}
			
			$getIDTahap = sqlArray(sqlQuery("select * from ref_tahap_anggaran where no_urut = '$nomorUrutSebelumnya' and tahun ='$this->tahun' and anggaran ='$this->jenisAnggaran'"));
			$idTahap = $getIDTahap['id_tahap'];
			$getAllParent = sqlQuery("select * from view_rka_ppkd_1 where id_tahap = '$idTahap'  and o1 !='0' and k='0' and n='0' and rincian_perhitungan=''  ");	
			while($rows = sqlArray($getAllParent)){
				foreach ($rows as $key => $value) { 
			 	 $$key = $value; 
				}
				$cekPekerjaan = sqlNumRow(sqlQuery("select * from view_rka_ppkd_1 where o1 = '$o1' and id_tahap = '$idTahap' $kondisiRekening $kondisiSKPD $blackList and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
				if($cekPekerjaan == 0){
					$arrKondisi[] = "o1 !='$o1'";
				}else{
					$arrKondisi[] = " id_tahap = '$idTahap'  or id_anggaran = '$id_anggaran' ";
					$getAllRekening = sqlQuery("select * from view_rka_ppkd_1 where id_tahap = '$idTahap' and c1 = '0' and j ='000' and rincian_perhitungan = '' and k!='0' and n !='0'  ");				
					while($row2s = sqlArray($getAllRekening)){
						foreach ($row2s as $key => $value) { 
					 	 $$key = $value; 
						}
						$cekRekening = sqlNumRow(sqlQuery("select * from view_rka_ppkd_1 where k ='$k' and l='$l' and m='$m' and n='$n' and o='$o' and id_tahap = '$idTahap' $kondisiRekening $kondisiSKPD $blackList and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
						if($cekRekening == 0){
							$concat = $k.".".$l.".".$m.".".$n.".".$o;
							$arrKondisi[] = "concat(k,'.',l,'.',m,'.',n,'.',o)  !='$concat'";
						}else{
							$arrKondisi[] = " id_tahap = '$idTahap'  or id_anggaran = '$id_anggaran'  ";
							$getAllProgram = sqlQuery("select * from view_rka_ppkd_1 where id_tahap = '$idTahap' and p != '0' and q ='0' and j ='000' and rincian_perhitungan = ''   ");				
							while($row3s = sqlArray($getAllProgram)){
								foreach ($row3s as $key => $value) { 
							 	 $$key = $value; 
								}
								$cekProgram = sqlNumRow(sqlQuery("select * from view_rka_ppkd_1 where bk ='$bk' and ck='$ck' and p='$p' and id_tahap = '$idTahap' $kondisiRekening $kondisiSKPD $blackList and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
								if($cekProgram == 0){
									$concat = $bk.".".$ck.".".$p;
									$arrKondisi[] = "concat(bk,'.',ck,'.',p)  !='$concat'";
								}else{
									$arrKondisi[] = " id_tahap = '$idTahap'  or id_anggaran = '$id_anggaran'   ";
									$getAllKegiatan = sqlQuery("select * from view_rka_ppkd_1 where id_tahap = '$idTahap' and bk ='$bk' and ck='$ck' and p='$p' and q != '0'  and j ='000' and rincian_perhitungan = ''   ");				
									while($row4s = sqlArray($getAllKegiatan)){
										foreach ($row4s as $key => $value) { 
									 	 $$key = $value; 
										}
										$cekKegiatan = sqlNumRow(sqlQuery("select * from view_rka_ppkd_1 where bk ='$bk' and ck='$ck' and p='$p' and q='$q' and id_tahap = '$idTahap' $kondisiRekening $kondisiSKPD  $blackList and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
										if($cekKegiatan == 0){
											$concat = $bk.".".$ck.".".$p;
											$arrKondisi[] = "concat(bk,'.',ck,'.',p)  !='$concat'";
										}else{
											$arrKondisi[] = " id_tahap='$this->idTahap'  or id_anggaran = '$id_anggaran'   ";
											
											
										}	
									}
									
								}	
							}
							
						}	
					}	
				}
			}
		
					
				$grabNonMapingRekening= sqlQuery("select * from view_rka_ppkd_1 where id_tahap = '$idTahap' and (LENGTH(k) > 1) and rincian_perhitungan=''");
				while($got = sqlArray($grabNonMapingRekening)){
					if(sqlNumRow(sqlQuery("select * from view_rka_ppkd_1 where id_tahap = '$idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and rincian_perhitungan!='' $kondisiRekening $kondisiSKPD $blackList")) != 0){
						$arrKondisi[] = "id_tahap = '$idTahap' or id_anggaran ='".$got['id_anggaran']."'";
					}
					
				}
				
				$grabNonHostedRekening= sqlQuery("select * from view_rka_ppkd_1 where id_tahap = '$idTahap' and (LENGTH(k) = 1 and k !='0') and rincian_perhitungan=''");
				while($got = sqlArray($grabNonHostedRekening)){
					if(sqlNumRow(sqlQuery("select * from view_rka_ppkd_1 where id_tahap = '$idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and rincian_perhitungan!='' $kondisiRekening $kondisiSKPD $blackList")) != 0){
						$arrKondisi[] = "id_tahap = '$idTahap' or id_anggaran ='".$got['id_anggaran']."'";
					}
					
				}
			
			
			
			
			
			$arrKondisi[] =  "no_urut = '$nomorUrutSebelumnya' ";
			

		}else{
			if($this->jenisFormTerakhir == "KOREKSI"){
				$nomorUrutSebelumnya = $this->urutTerakhir - 1;
				$getRApbd = sqlArray(sqlQuery("select * from view_rka_ppkd_1 where no_urut = '$nomorUrutSebelumnya' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' "));
				if($getRApbd['jenis_form_modul'] != "PENYUSUNAN" && $getRApbd['jenis_form_modul'] != "KOREKSI"){
					$nomorUrutSebelumnya = $nomorUrutSebelumnya - 1;		
				}
				$getLastTahap = sqlArray(sqlQuery("select * from view_rka_ppkd_1 where no_urut = '$nomorUrutSebelumnya' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'"));
				$blackList = "";
				if($getLastTahap['jenis_form_modul'] == "PENYUSUNAN" && $this->wajibValidasi == TRUE){
					$getAllChild = sqlQuery("select * from view_rka_ppkd_1 where id_tahap = '".$getLastTahap['id_tahap']."' and (rincian_perhitungan !='' or j !='000'  and status_validasi !='1' )");			
					while($black = sqlArray($getAllChild)){
						$blackList .= " and id_anggaran !='".$black['id_anggaran']."'";
					}
				}
				
				$getIDTahap = sqlArray(sqlQuery("select * from ref_tahap_anggaran where no_urut = '$nomorUrutSebelumnya' and tahun ='$this->tahun' and anggaran ='$this->jenisAnggaran'"));
				$idTahap = $getIDTahap['id_tahap'];
				$getAllParent = sqlQuery("select * from view_rka_ppkd_1 where id_tahap = '$idTahap'  and o1 !='0' and k='0' and n='0' and rincian_perhitungan=''  ");	
				while($rows = sqlArray($getAllParent)){
					foreach ($rows as $key => $value) { 
				 	 $$key = $value; 
					}
					$cekPekerjaan = sqlNumRow(sqlQuery("select * from view_rka_ppkd_1 where o1 = '$o1' and id_tahap = '$idTahap' $kondisiRekening $kondisiSKPD $blackList and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
					if($cekPekerjaan == 0){
						$arrKondisi[] = "o1 !='$o1'";
					}else{
						$arrKondisi[] = " id_tahap = '$idTahap'  or id_anggaran = '$id_anggaran' ";
						$getAllRekening = sqlQuery("select * from view_rka_ppkd_1 where id_tahap = '$idTahap' and c1 = '0' and j ='000' and rincian_perhitungan = '' and k!='0' and n !='0'  ");				
						while($row2s = sqlArray($getAllRekening)){
							foreach ($row2s as $key => $value) { 
						 	 $$key = $value; 
							}
							$cekRekening = sqlNumRow(sqlQuery("select * from view_rka_ppkd_1 where k ='$k' and l='$l' and m='$m' and n='$n' and o='$o' and id_tahap = '$idTahap' $kondisiRekening $kondisiSKPD $blackList and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
							if($cekRekening == 0){
								$concat = $k.".".$l.".".$m.".".$n.".".$o;
								$arrKondisi[] = "concat(k,'.',l,'.',m,'.',n,'.',o)  !='$concat'";
							}else{
								$arrKondisi[] = " id_tahap = '$idTahap'  or id_anggaran = '$id_anggaran'  ";
								$getAllProgram = sqlQuery("select * from view_rka_ppkd_1 where id_tahap = '$idTahap' and p != '0' and q ='0' and j ='000' and rincian_perhitungan = ''   ");				
								while($row3s = sqlArray($getAllProgram)){
									foreach ($row3s as $key => $value) { 
								 	 $$key = $value; 
									}
									$cekProgram = sqlNumRow(sqlQuery("select * from view_rka_ppkd_1 where bk ='$bk' and ck='$ck' and p='$p' and id_tahap = '$idTahap' $kondisiRekening $kondisiSKPD $blackList and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
									if($cekProgram == 0){
										$concat = $bk.".".$ck.".".$p;
										$arrKondisi[] = "concat(bk,'.',ck,'.',p)  !='$concat'";
									}else{
										$arrKondisi[] = " id_tahap = '$idTahap'  or id_anggaran = '$id_anggaran'   ";
										$getAllKegiatan = sqlQuery("select * from view_rka_ppkd_1 where id_tahap = '$idTahap' and bk ='$bk' and ck='$ck' and p='$p' and q != '0'  and j ='000' and rincian_perhitungan = ''   ");				
										while($row4s = sqlArray($getAllKegiatan)){
											foreach ($row4s as $key => $value) { 
										 	 $$key = $value; 
											}
											$cekKegiatan = sqlNumRow(sqlQuery("select * from view_rka_ppkd_1 where bk ='$bk' and ck='$ck' and p='$p' and q='$q' and id_tahap = '$idTahap' $kondisiRekening $kondisiSKPD  $blackList and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
											if($cekKegiatan == 0){
												$concat = $bk.".".$ck.".".$p;
												$arrKondisi[] = "concat(bk,'.',ck,'.',p)  !='$concat'";
											}else{
												$arrKondisi[] = " id_tahap='$idTahap'  or id_anggaran = '$id_anggaran'   ";
												
												
											}	
										}
										
									}	
								}
								
							}	
						}	
					}
				}
			
						
					$grabNonMapingRekening= sqlQuery("select * from view_rka_ppkd_1 where id_tahap = '$idTahap' and (LENGTH(k) > 1) and rincian_perhitungan=''");
					while($got = sqlArray($grabNonMapingRekening)){
						if(sqlNumRow(sqlQuery("select * from view_rka_ppkd_1 where id_tahap = '$idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and rincian_perhitungan!='' $kondisiRekening $kondisiSKPD $blackList")) != 0){
							$arrKondisi[] = "id_tahap = '$idTahap' or id_anggaran ='".$got['id_anggaran']."'";
						}
						
					}
					
					$grabNonHostedRekening= sqlQuery("select * from view_rka_ppkd_1 where id_tahap = '$idTahap' and (LENGTH(k) = 1 and k !='0') and rincian_perhitungan=''");
					while($got = sqlArray($grabNonHostedRekening)){
						if(sqlNumRow(sqlQuery("select * from view_rka_ppkd_1 where id_tahap = '$idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and rincian_perhitungan!='' $kondisiRekening $kondisiSKPD $blackList")) != 0){
							$arrKondisi[] = "id_tahap = '$idTahap' or id_anggaran ='".$got['id_anggaran']."'";
						}
						
					}
				
				
				
				
				
				$arrKondisi[] =  "no_urut = '$nomorUrutSebelumnya' ";
			}elseif($this->jenisFormTerakhir == "PENYUSUNAN"){
				$getIDTahap = sqlArray(sqlQuery("select * from ref_tahap_anggaran where no_urut ='$this->urutTerakhir' and tahun ='$this->tahun' and anggaran='$this->jenisAnggaran'"));			
				$idTahap = $getIDTahap['id_tahap'];
				$getAllParent = sqlQuery("select * from view_rka_ppkd_1 where id_tahap ='$idTahap'  and o1 !='0' and k='0' and n='0' and rincian_perhitungan=''  ");	
				while($rows = sqlArray($getAllParent)){
					foreach ($rows as $key => $value) { 
				 	 $$key = $value; 
					}
					$cekPekerjaan = sqlNumRow(sqlQuery("select * from view_rka_ppkd_1 where o1 = '$o1' and id_tahap ='$idTahap' $kondisiRekening $kondisiSKPD and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
					if($cekPekerjaan == 0){
						$arrKondisi[] = "o1 !='$o1'";
					}else{
						$arrKondisi[] = " id_tahap='$idTahap'  or id_anggaran = '$id_anggaran' ";
						$getAllRekening = sqlQuery("select * from view_rka_ppkd_1 where id_tahap = '$idTahap'  and c1 = '0' and j ='000' and rincian_perhitungan = '' and k!='0' and n !='0'  ");				
						while($row2s = sqlArray($getAllRekening)){
							foreach ($row2s as $key => $value) { 
						 	 $$key = $value; 
							}
							$cekRekening = sqlNumRow(sqlQuery("select * from view_rka_ppkd_1 where k ='$k' and l='$l' and m='$m' and n='$n' and o='$o' and id_tahap ='$idTahap' $kondisiRekening $kondisiSKPD and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
							if($cekRekening == 0){
								$concat = $k.".".$l.".".$m.".".$n.".".$o;
								$arrKondisi[] = "concat(k,'.',l,'.',m,'.',n,'.',o)  !='$concat'";
							}else{
								$arrKondisi[] = " id_tahap='$idTahap'  or id_anggaran = '$id_anggaran'  ";
								$getAllProgram = sqlQuery("select * from view_rka_ppkd_1 where id_tahap = '$idTahap' and p != '0' and q ='0' and j ='000' and rincian_perhitungan = ''   ");				
								while($row3s = sqlArray($getAllProgram)){
									foreach ($row3s as $key => $value) { 
								 	 $$key = $value; 
									}
									$cekProgram = sqlNumRow(sqlQuery("select * from view_rka_ppkd_1 where bk ='$bk' and ck='$ck' and p='$p' and id_tahap ='$idTahap' $kondisiRekening $kondisiSKPD and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
									if($cekProgram == 0){
										$concat = $bk.".".$ck.".".$p;
										$arrKondisi[] = "concat(bk,'.',ck,'.',p)  !='$concat'";
									}else{
										$arrKondisi[] = " id_tahap='$idTahap'  or id_anggaran = '$id_anggaran'   ";
										$getAllKegiatan = sqlQuery("select * from view_rka_ppkd_1 where id_tahap = '$idTahap' and bk ='$bk' and ck='$ck' and p='$p' and q != '0'  and j ='000' and rincian_perhitungan = ''   ");				
										while($row4s = sqlArray($getAllKegiatan)){
											foreach ($row4s as $key => $value) { 
										 	 $$key = $value; 
											}
											$cekKegiatan = sqlNumRow(sqlQuery("select * from view_rka_ppkd_1 where bk ='$bk' and ck='$ck' and p='$p' and q='$q' and id_tahap ='$idTahap' $kondisiRekening $kondisiSKPD and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
											if($cekKegiatan == 0){
												$concat = $bk.".".$ck.".".$p;
												$arrKondisi[] = "concat(bk,'.',ck,'.',p)  !='$concat'";
											}else{
												$arrKondisi[] = " id_tahap='$idTahap'  or id_anggaran = '$id_anggaran'   ";
												
												
											}	
										}
										
									}	
								}
								
							}	
						}	
					}
				}
		
					
				$grabNonMapingRekening= sqlQuery("select * from view_rka_ppkd_1 where id_tahap ='$idTahap' and (LENGTH(k) > 1) and rincian_perhitungan=''");
				while($got = sqlArray($grabNonMapingRekening)){
					if(sqlNumRow(sqlQuery("select * from view_rka_ppkd_1 where id_tahap ='$idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and rincian_perhitungan!='' $kondisiRekening $kondisiSKPD ")) != 0){
						$arrKondisi[] = "id_tahap = '$idTahap' or id_anggaran ='".$got['id_anggaran']."'";
					}
					
				}
				
				$grabNonHostedRekening= sqlQuery("select * from view_rka_ppkd_1 where id_tahap ='$idTahap' and (LENGTH(k) = 1 and k !='0') and rincian_perhitungan=''");
				while($got = sqlArray($grabNonHostedRekening)){
					if(sqlNumRow(sqlQuery("select * from view_rka_ppkd_1 where id_tahap ='$idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and rincian_perhitungan!='' $kondisiRekening $kondisiSKPD ")) != 0){
						$arrKondisi[] = "id_tahap = '$idTahap' or id_anggaran ='".$got['id_anggaran']."'";
					}
					
				}
				
				
				
				$arrKondisi[] = "id_tahap = '$idTahap' ";
			}
		}
		
  

		
		
	
		$arrKondisi[] = "tahun = '$this->tahun'";
		$arrKondisi[] = "jenis_anggaran = '$this->jenisAnggaran'";
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi ;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
		$arrOrders[] = "urut, rincian_perhitungan  asc";
		$Order= join(',',$arrOrders);	
		$OrderDefault = '';
		$Order =  $Order ==''? $OrderDefault : ' Order By '.$Order;
		
		return array('Kondisi'=>$Kondisi, 'Order'=>$Order ,'Limit'=>$Limit, 'NoAwal'=>$NoAwal );
		
	}
	
	function Hapus($ids){ //validasi hapus ref_kota
		 $err=''; $cek='';
		for($i = 0; $i<count($ids); $i++)	{
		
		
			$qy = "DELETE FROM $this->TblName_Hapus WHERE id_anggaran='".$ids[$i]."' ";$cek.=$qy;
			$qry = sqlQuery($qy);				
				
		}
		return array('err'=>$err,'cek'=>$cek);
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
		
		if($this->jenisForm =="PENYUSUNAN" || $this->jenisForm =="VALIDASI" || $this->jenisFormTerakhir == "PENYUSUNAN" || $this->jenisFormTerakhir == "VALIDASI" ){
			$tergantung = "100";
		}else{
			$tergantung = "100";
		}
		return
				
		"<html>".
			$this->genHTMLHead().
			"<body >".
							
			"<table id='KerangkaHal' class='menubar' cellspacing='0' cellpadding='0' border='0'  height='100%' >".	
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
		</html>
		<style>
			#kerangkaHal {
						width:$tergantung%;
			}
			
		</style>
		"; 
	}		
function Laporan($xls =FALSE){
		global $Main;
		
	
		
		if($xls){
			header("Content-type: application/msexcel");
			header("Content-Disposition: attachment; filename=$this->fileNameExcel");
			header("Pragma: no-cache");
			header("Expires: 0");
		}
		
		
		
		$arrKondisi = array();
		$grabSKPD = sqlArray(sqlQuery("select * from skpd_report_rka_ppkd_1 where username='$this->username'"));
		foreach ($grabSKPD as $key => $value) { 
				  $$key = $value; 
			}
		$cmbUrusan = $c1;
		$cmbBidang = $c;
		$cmbSKPD = $d;
		$cmbUnit = $e;
		$cmbSubUnit = $e1;
		
		/*if($cmbSubUnit != ''){
			$arrKondisi[] = "c1 = '$cmbUrusan'";
			$arrKondisi[] = "c = '$cmbBidang'";
			$arrKondisi[] = "d = '$cmbSKPD'";
			$arrKondisi[] = "e = '$cmbUnit'";
			$arrKondisi[] = "e1 = '$cmbSubUnit'";
			$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit'";
			

			}elseif($cmbUnit != ''){
				$arrKondisi[] = "c1 = '$cmbUrusan'";
				$arrKondisi[] = "c = '$cmbBidang'";
				$arrKondisi[] = "d = '$cmbSKPD'";
				$arrKondisi[] = "e = '$cmbUnit'";
				$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' ";
			}elseif($cmbSKPD != ''){
				$arrKondisi[] = "c1 = '$cmbUrusan'";
				$arrKondisi[] = "c = '$cmbBidang'";
				$arrKondisi[] = "d = '$cmbSKPD'";
				$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD'  ";
			}elseif($cmbBidang != ''){
				$arrKondisi[] = "c1 = '$cmbUrusan'";
				$arrKondisi[] = "c = '$cmbBidang'";
				$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang'  ";
			}elseif($cmbUrusan != ''){
				$arrKondisi[] = "c1 = '$cmbUrusan'";
				$kondisiSKPD = "and c1='$cmbUrusan'";
			}*/
			$arrKondisi[] = "c1 != '0'";
		if($this->jenisForm == 'PENYUSUNAN'){
			$getAllParent = sqlQuery("select * from view_rka_ppkd_1 where id_tahap ='$this->idTahap'  and o1 !='0' and k='0' and n='0' and rincian_perhitungan=''  ");	
			while($rows = sqlArray($getAllParent)){
				foreach ($rows as $key => $value) { 
			 	 $$key = $value; 
				}
				$cekPekerjaan = sqlNumRow(sqlQuery("select * from view_rka_ppkd_1 where o1 = '$o1' and id_tahap ='$this->idTahap' $kondisiRekening $kondisiSKPD and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
				if($cekPekerjaan == 0){
					$arrKondisi[] = "o1 !='$o1'";
				}else{
					$arrKondisi[] = " id_tahap='$this->idTahap'  or id_anggaran = '$id_anggaran' ";
					$getAllRekening = sqlQuery("select * from view_rka_ppkd_1 where id_tahap = '$this->idTahap'  and c1 = '0' and j ='000' and rincian_perhitungan = '' and k!='0' and n !='0'  ");				
					while($row2s = sqlArray($getAllRekening)){
						foreach ($row2s as $key => $value) { 
					 	 $$key = $value; 
						}
						$cekRekening = sqlNumRow(sqlQuery("select * from view_rka_ppkd_1 where k ='$k' and l='$l' and m='$m' and n='$n' and o='$o' and id_tahap ='$this->idTahap' $kondisiRekening $kondisiSKPD and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
						if($cekRekening == 0){
							$concat = $k.".".$l.".".$m.".".$n.".".$o;
							$arrKondisi[] = "concat(k,'.',l,'.',m,'.',n,'.',o)  !='$concat'";
						}else{
							$arrKondisi[] = " id_tahap='$this->idTahap'  or id_anggaran = '$id_anggaran'  ";
							
							
						}	
					}	
				}
			}
		
					
				$grabNonMapingRekening= sqlQuery("select * from view_rka_ppkd_1 where id_tahap ='$this->idTahap' and (LENGTH(k) > 1) and rincian_perhitungan=''");
				while($got = sqlArray($grabNonMapingRekening)){
					if(sqlNumRow(sqlQuery("select * from view_rka_ppkd_1 where id_tahap ='$this->idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and rincian_perhitungan!=''  $kondisiSKPD ")) != 0){
						$arrKondisi[] = "id_tahap = '$this->idTahap' or id_anggaran ='".$got['id_anggaran']."'";
					}
					
				}
				$grabNonHostedRekening= sqlQuery("select * from view_rka_ppkd_1 where id_tahap ='$this->idTahap' and (LENGTH(k) = 1 and k !='0') and rincian_perhitungan=''");
				while($got = sqlArray($grabNonHostedRekening)){
					if(sqlNumRow(sqlQuery("select * from view_rka_ppkd_1 where id_tahap ='$this->idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and rincian_perhitungan!=''  $kondisiSKPD ")) != 0){
						$arrKondisi[] = "id_tahap = '$this->idTahap' or id_anggaran ='".$got['id_anggaran']."'";
					}
					
				}
				
					
			$arrKondisi[] = "id_tahap = '$this->idTahap' ";
			
		}elseif($this->jenisForm == 'KOREKSI'){
			$nomorUrutSebelumnya = $this->nomorUrut ;
			$getRApbd = sqlArray(sqlQuery("select * from view_rka_ppkd_1 where no_urut = '$nomorUrutSebelumnya' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' "));
			if($getRApbd['jenis_form_modul'] != "PENYUSUNAN" && $getRApbd['jenis_form_modul'] != "KOREKSI"){
				$nomorUrutSebelumnya = $nomorUrutSebelumnya - 1;		
			}
			$getLastTahap = sqlArray(sqlQuery("select * from view_rka_ppkd_1 where no_urut = '$nomorUrutSebelumnya' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'"));
			$blackList = "";
			if($getLastTahap['jenis_form_modul'] == "PENYUSUNAN" && $this->wajibValidasi == TRUE){
				$getAllChild = sqlQuery("select * from view_rka_ppkd_1 where id_tahap = '".$getLastTahap['id_tahap']."' and (rincian_perhitungan !='' or j !='000'  and status_validasi !='1' )");			
				while($black = sqlArray($getAllChild)){
					$blackList .= " and id_anggaran !='".$black['id_anggaran']."'";
				}
			}
			
			$getIDTahap = sqlArray(sqlQuery("select * from ref_tahap_anggaran where no_urut = '$nomorUrutSebelumnya' and tahun ='$this->tahun' and anggaran ='$this->jenisAnggaran'"));
			$idTahap = $getIDTahap['id_tahap'];
			$getAllParent = sqlQuery("select * from view_rka_ppkd_1 where id_tahap = '$idTahap'  and o1 !='0' and k='0' and n='0' and rincian_perhitungan=''  ");	
			while($rows = sqlArray($getAllParent)){
				foreach ($rows as $key => $value) { 
			 	 $$key = $value; 
				}
				$cekPekerjaan = sqlNumRow(sqlQuery("select * from view_rka_ppkd_1 where o1 = '$o1' and id_tahap = '$idTahap' $kondisiRekening $kondisiSKPD $blackList and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
				if($cekPekerjaan == 0){
					$arrKondisi[] = "o1 !='$o1'";
				}else{
					$arrKondisi[] = " id_tahap = '$idTahap'  or id_anggaran = '$id_anggaran' ";
					$getAllRekening = sqlQuery("select * from view_rka_ppkd_1 where id_tahap = '$idTahap' and c1 = '0' and j ='000' and rincian_perhitungan = '' and k!='0' and n !='0'  ");				
					while($row2s = sqlArray($getAllRekening)){
						foreach ($row2s as $key => $value) { 
					 	 $$key = $value; 
						}
						$cekRekening = sqlNumRow(sqlQuery("select * from view_rka_ppkd_1 where k ='$k' and l='$l' and m='$m' and n='$n' and o='$o' and id_tahap = '$idTahap' $kondisiRekening $kondisiSKPD $blackList and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
						if($cekRekening == 0){
							$concat = $k.".".$l.".".$m.".".$n.".".$o;
							$arrKondisi[] = "concat(k,'.',l,'.',m,'.',n,'.',o)  !='$concat'";
						}else{
							$arrKondisi[] = " id_tahap = '$idTahap'  or id_anggaran = '$id_anggaran'  ";
							$getAllProgram = sqlQuery("select * from view_rka_ppkd_1 where id_tahap = '$idTahap' and p != '0' and q ='0' and j ='000' and rincian_perhitungan = ''   ");				
							while($row3s = sqlArray($getAllProgram)){
								foreach ($row3s as $key => $value) { 
							 	 $$key = $value; 
								}
								$cekProgram = sqlNumRow(sqlQuery("select * from view_rka_ppkd_1 where bk ='$bk' and ck='$ck' and p='$p' and id_tahap = '$idTahap' $kondisiRekening $kondisiSKPD $blackList and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
								if($cekProgram == 0){
									$concat = $bk.".".$ck.".".$p;
									$arrKondisi[] = "concat(bk,'.',ck,'.',p)  !='$concat'";
								}else{
									$arrKondisi[] = " id_tahap = '$idTahap'  or id_anggaran = '$id_anggaran'   ";
									$getAllKegiatan = sqlQuery("select * from view_rka_ppkd_1 where id_tahap = '$idTahap' and bk ='$bk' and ck='$ck' and p='$p' and q != '0'  and j ='000' and rincian_perhitungan = ''   ");				
									while($row4s = sqlArray($getAllKegiatan)){
										foreach ($row4s as $key => $value) { 
									 	 $$key = $value; 
										}
										$cekKegiatan = sqlNumRow(sqlQuery("select * from view_rka_ppkd_1 where bk ='$bk' and ck='$ck' and p='$p' and q='$q' and id_tahap = '$idTahap' $kondisiRekening $kondisiSKPD  $blackList and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
										if($cekKegiatan == 0){
											$concat = $bk.".".$ck.".".$p;
											$arrKondisi[] = "concat(bk,'.',ck,'.',p)  !='$concat'";
										}else{
											$arrKondisi[] = " id_tahap='$this->idTahap'  or id_anggaran = '$id_anggaran'   ";
											
											
										}	
									}
									
								}	
							}
							
						}	
					}	
				}
			}
		
					
				$grabNonMapingRekening= sqlQuery("select * from view_rka_ppkd_1 where id_tahap = '$idTahap' and (LENGTH(k) > 1) and rincian_perhitungan=''");
				while($got = sqlArray($grabNonMapingRekening)){
					if(sqlNumRow(sqlQuery("select * from view_rka_ppkd_1 where id_tahap = '$idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and rincian_perhitungan!='' $kondisiRekening $kondisiSKPD $blackList")) != 0){
						$arrKondisi[] = "id_tahap = '$idTahap' or id_anggaran ='".$got['id_anggaran']."'";
					}
					
				}
				
				$grabNonHostedRekening= sqlQuery("select * from view_rka_ppkd_1 where id_tahap = '$idTahap' and (LENGTH(k) = 1 and k !='0') and rincian_perhitungan=''");
				while($got = sqlArray($grabNonHostedRekening)){
					if(sqlNumRow(sqlQuery("select * from view_rka_ppkd_1 where id_tahap = '$idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and rincian_perhitungan!='' $kondisiRekening $kondisiSKPD $blackList")) != 0){
						$arrKondisi[] = "id_tahap = '$idTahap' or id_anggaran ='".$got['id_anggaran']."'";
					}
					
				}
			
			
			
			
			
			$arrKondisi[] =  "no_urut = '$nomorUrutSebelumnya' ";
			

		}else{
			if($this->jenisFormTerakhir == "KOREKSI"){
				$nomorUrutSebelumnya = $this->urutTerakhir;
				$getRApbd = sqlArray(sqlQuery("select * from view_rka_ppkd_1 where no_urut = '$nomorUrutSebelumnya' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' "));
				if($getRApbd['jenis_form_modul'] != "PENYUSUNAN" && $getRApbd['jenis_form_modul'] != "KOREKSI"){
					$nomorUrutSebelumnya = $nomorUrutSebelumnya - 1;		
				}
				$getLastTahap = sqlArray(sqlQuery("select * from view_rka_ppkd_1 where no_urut = '$nomorUrutSebelumnya' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'"));
				$blackList = "";
				if($getLastTahap['jenis_form_modul'] == "PENYUSUNAN" && $this->wajibValidasi == TRUE){
					$getAllChild = sqlQuery("select * from view_rka_ppkd_1 where id_tahap = '".$getLastTahap['id_tahap']."' and (rincian_perhitungan !='' or j !='000'  and status_validasi !='1' )");			
					while($black = sqlArray($getAllChild)){
						$blackList .= " and id_anggaran !='".$black['id_anggaran']."'";
					}
				}
				
				$getIDTahap = sqlArray(sqlQuery("select * from ref_tahap_anggaran where no_urut = '$nomorUrutSebelumnya' and tahun ='$this->tahun' and anggaran ='$this->jenisAnggaran'"));
				$idTahap = $getIDTahap['id_tahap'];
				$getAllParent = sqlQuery("select * from view_rka_ppkd_1 where id_tahap = '$idTahap'  and o1 !='0' and k='0' and n='0' and rincian_perhitungan=''  ");	
				while($rows = sqlArray($getAllParent)){
					foreach ($rows as $key => $value) { 
				 	 $$key = $value; 
					}
					$cekPekerjaan = sqlNumRow(sqlQuery("select * from view_rka_ppkd_1 where o1 = '$o1' and id_tahap = '$idTahap' $kondisiRekening $kondisiSKPD $blackList and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
					if($cekPekerjaan == 0){
						$arrKondisi[] = "o1 !='$o1'";
					}else{
						$arrKondisi[] = " id_tahap = '$idTahap'  or id_anggaran = '$id_anggaran' ";
						$getAllRekening = sqlQuery("select * from view_rka_ppkd_1 where id_tahap = '$idTahap' and c1 = '0' and j ='000' and rincian_perhitungan = '' and k!='0' and n !='0'  ");				
						while($row2s = sqlArray($getAllRekening)){
							foreach ($row2s as $key => $value) { 
						 	 $$key = $value; 
							}
							$cekRekening = sqlNumRow(sqlQuery("select * from view_rka_ppkd_1 where k ='$k' and l='$l' and m='$m' and n='$n' and o='$o' and id_tahap = '$idTahap' $kondisiRekening $kondisiSKPD $blackList and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
							if($cekRekening == 0){
								$concat = $k.".".$l.".".$m.".".$n.".".$o;
								$arrKondisi[] = "concat(k,'.',l,'.',m,'.',n,'.',o)  !='$concat'";
							}else{
								$arrKondisi[] = " id_tahap = '$idTahap'  or id_anggaran = '$id_anggaran'  ";
								$getAllProgram = sqlQuery("select * from view_rka_ppkd_1 where id_tahap = '$idTahap' and p != '0' and q ='0' and j ='000' and rincian_perhitungan = ''   ");				
								while($row3s = sqlArray($getAllProgram)){
									foreach ($row3s as $key => $value) { 
								 	 $$key = $value; 
									}
									$cekProgram = sqlNumRow(sqlQuery("select * from view_rka_ppkd_1 where bk ='$bk' and ck='$ck' and p='$p' and id_tahap = '$idTahap' $kondisiRekening $kondisiSKPD $blackList and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
									if($cekProgram == 0){
										$concat = $bk.".".$ck.".".$p;
										$arrKondisi[] = "concat(bk,'.',ck,'.',p)  !='$concat'";
									}else{
										$arrKondisi[] = " id_tahap = '$idTahap'  or id_anggaran = '$id_anggaran'   ";
										$getAllKegiatan = sqlQuery("select * from view_rka_ppkd_1 where id_tahap = '$idTahap' and bk ='$bk' and ck='$ck' and p='$p' and q != '0'  and j ='000' and rincian_perhitungan = ''   ");				
										while($row4s = sqlArray($getAllKegiatan)){
											foreach ($row4s as $key => $value) { 
										 	 $$key = $value; 
											}
											$cekKegiatan = sqlNumRow(sqlQuery("select * from view_rka_ppkd_1 where bk ='$bk' and ck='$ck' and p='$p' and q='$q' and id_tahap = '$idTahap' $kondisiRekening $kondisiSKPD  $blackList and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
											if($cekKegiatan == 0){
												$concat = $bk.".".$ck.".".$p;
												$arrKondisi[] = "concat(bk,'.',ck,'.',p)  !='$concat'";
											}else{
												$arrKondisi[] = " id_tahap='$idTahap'  or id_anggaran = '$id_anggaran'   ";
												
												
											}	
										}
										
									}	
								}
								
							}	
						}	
					}
				}
			
						
					$grabNonMapingRekening= sqlQuery("select * from view_rka_ppkd_1 where id_tahap = '$idTahap' and (LENGTH(k) > 1) and rincian_perhitungan=''");
					while($got = sqlArray($grabNonMapingRekening)){
						if(sqlNumRow(sqlQuery("select * from view_rka_ppkd_1 where id_tahap = '$idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and rincian_perhitungan!='' $kondisiRekening $kondisiSKPD $blackList")) != 0){
							$arrKondisi[] = "id_tahap = '$idTahap' or id_anggaran ='".$got['id_anggaran']."'";
						}
						
					}
					
					$grabNonHostedRekening= sqlQuery("select * from view_rka_ppkd_1 where id_tahap = '$idTahap' and (LENGTH(k) = 1 and k !='0') and rincian_perhitungan=''");
					while($got = sqlArray($grabNonHostedRekening)){
						if(sqlNumRow(sqlQuery("select * from view_rka_ppkd_1 where id_tahap = '$idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and rincian_perhitungan!='' $kondisiRekening $kondisiSKPD $blackList")) != 0){
							$arrKondisi[] = "id_tahap = '$idTahap' or id_anggaran ='".$got['id_anggaran']."'";
						}
						
					}
				
				
				
				
				
				$arrKondisi[] =  "no_urut = '$nomorUrutSebelumnya' ";
			}elseif($this->jenisFormTerakhir == "PENYUSUNAN"){
				$getIDTahap = sqlArray(sqlQuery("select * from ref_tahap_anggaran where no_urut ='$this->urutTerakhir' and tahun ='$this->tahun' and anggaran='$this->jenisAnggaran'"));			
				$idTahap = $getIDTahap['id_tahap'];
				$getAllParent = sqlQuery("select * from view_rka_ppkd_1 where id_tahap ='$idTahap'  and o1 !='0' and k='0' and n='0' and rincian_perhitungan=''  ");	
				while($rows = sqlArray($getAllParent)){
					foreach ($rows as $key => $value) { 
				 	 $$key = $value; 
					}
					$cekPekerjaan = sqlNumRow(sqlQuery("select * from view_rka_ppkd_1 where o1 = '$o1' and id_tahap ='$idTahap' $kondisiRekening $kondisiSKPD and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
					if($cekPekerjaan == 0){
						$arrKondisi[] = "o1 !='$o1'";
					}else{
						$arrKondisi[] = " id_tahap='$idTahap'  or id_anggaran = '$id_anggaran' ";
						$getAllRekening = sqlQuery("select * from view_rka_ppkd_1 where id_tahap = '$idTahap'  and c1 = '0' and j ='000' and rincian_perhitungan = '' and k!='0' and n !='0'  ");				
						while($row2s = sqlArray($getAllRekening)){
							foreach ($row2s as $key => $value) { 
						 	 $$key = $value; 
							}
							$cekRekening = sqlNumRow(sqlQuery("select * from view_rka_ppkd_1 where k ='$k' and l='$l' and m='$m' and n='$n' and o='$o' and id_tahap ='$idTahap' $kondisiRekening $kondisiSKPD and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
							if($cekRekening == 0){
								$concat = $k.".".$l.".".$m.".".$n.".".$o;
								$arrKondisi[] = "concat(k,'.',l,'.',m,'.',n,'.',o)  !='$concat'";
							}else{
								$arrKondisi[] = " id_tahap='$idTahap'  or id_anggaran = '$id_anggaran'  ";
								$getAllProgram = sqlQuery("select * from view_rka_ppkd_1 where id_tahap = '$idTahap' and p != '0' and q ='0' and j ='000' and rincian_perhitungan = ''   ");				
								while($row3s = sqlArray($getAllProgram)){
									foreach ($row3s as $key => $value) { 
								 	 $$key = $value; 
									}
									$cekProgram = sqlNumRow(sqlQuery("select * from view_rka_ppkd_1 where bk ='$bk' and ck='$ck' and p='$p' and id_tahap ='$idTahap' $kondisiRekening $kondisiSKPD and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
									if($cekProgram == 0){
										$concat = $bk.".".$ck.".".$p;
										$arrKondisi[] = "concat(bk,'.',ck,'.',p)  !='$concat'";
									}else{
										$arrKondisi[] = " id_tahap='$idTahap'  or id_anggaran = '$id_anggaran'   ";
										$getAllKegiatan = sqlQuery("select * from view_rka_ppkd_1 where id_tahap = '$idTahap' and bk ='$bk' and ck='$ck' and p='$p' and q != '0'  and j ='000' and rincian_perhitungan = ''   ");				
										while($row4s = sqlArray($getAllKegiatan)){
											foreach ($row4s as $key => $value) { 
										 	 $$key = $value; 
											}
											$cekKegiatan = sqlNumRow(sqlQuery("select * from view_rka_ppkd_1 where bk ='$bk' and ck='$ck' and p='$p' and q='$q' and id_tahap ='$idTahap' $kondisiRekening $kondisiSKPD and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
											if($cekKegiatan == 0){
												$concat = $bk.".".$ck.".".$p;
												$arrKondisi[] = "concat(bk,'.',ck,'.',p)  !='$concat'";
											}else{
												$arrKondisi[] = " id_tahap='$idTahap'  or id_anggaran = '$id_anggaran'   ";
												
												
											}	
										}
										
									}	
								}
								
							}	
						}	
					}
				}
		
					
				$grabNonMapingRekening= sqlQuery("select * from view_rka_ppkd_1 where id_tahap ='$idTahap' and (LENGTH(k) > 1) and rincian_perhitungan=''");
				while($got = sqlArray($grabNonMapingRekening)){
					if(sqlNumRow(sqlQuery("select * from view_rka_ppkd_1 where id_tahap ='$idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and rincian_perhitungan!='' $kondisiRekening $kondisiSKPD ")) != 0){
						$arrKondisi[] = "id_tahap = '$idTahap' or id_anggaran ='".$got['id_anggaran']."'";
					}
					
				}
				
				$grabNonHostedRekening= sqlQuery("select * from view_rka_ppkd_1 where id_tahap ='$idTahap' and (LENGTH(k) = 1 and k !='0') and rincian_perhitungan=''");
				while($got = sqlArray($grabNonHostedRekening)){
					if(sqlNumRow(sqlQuery("select * from view_rka_ppkd_1 where id_tahap ='$idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and rincian_perhitungan!='' $kondisiRekening $kondisiSKPD ")) != 0){
						$arrKondisi[] = "id_tahap = '$idTahap' or id_anggaran ='".$got['id_anggaran']."'";
					}
					
				}
				
				
				
				$arrKondisi[] = "id_tahap = '$idTahap' ";
			}
		}
		
		
  

		
		
	
		$arrKondisi[] = "tahun = '$this->tahun'";
		$arrKondisi[] = "jenis_anggaran = '$this->jenisAnggaran'";
		
		$Kondisi= join(' and ',$arrKondisi);
		/*if(sizeof($arrKondisi) == 0){
			$Kondisi= '';
		}else{
			$Kondisi = " and ".$Kondisi;
		}*/
		$qry ="select * from view_rka_ppkd_1 where $Kondisi ";
		$aqry = sqlQuery($qry);
		$getKuasapenggunaBarang = sqlArray(sqlQuery("select * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
		$kuasaPenggunaBarang = $getKuasapenggunaBarang['nm_skpd'];		
		
		
		$getUrusan = sqlArray(sqlQuery("select * from ref_skpd where c1='$cmbUrusan' and c='00'"));
		$urusan = $getUrusan['nm_skpd'];
		$getBidang = sqlArray(sqlQuery("select * from ref_skpd where c1='$cmbUrusan' and c='$cmbBidang' and d='00'"));
		$bidang = $getBidang['nm_skpd'];
		$getSKPD = sqlArray(sqlQuery("select * from ref_skpd where c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='00'"));
		$skpd = $getBidang['nm_skpd'];
		$getSubUnit = sqlArray(sqlQuery("select * from ref_skpd where c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit' "));
		$subUnit = $getSubUnit['nm_skpd'];
		$getProgram = sqlArray(sqlQuery("select * from ref_program where bk='$hublaBK' and ck='$hublaCK' and dk='0' and p='$hublaP' and q='0'"));
		$program = $getProgram['nama'];
		$getKegiatan = sqlArray(sqlQuery("select * from ref_program where bk='$hublaBK' and ck='$hublaCK' and dk='0' and p='$hublaP' and q='$hublaQ'"));
		$kegiatan = $getKegiatan['nama'];
		
		//
				
		//MULAI Halaman Laporan ------------------------------------------------------------------------------------------ 
		$css = $xls	? "<style>.nfmt5 {mso-number-format:'\@';}</style>":"<link rel=\"stylesheet\" href=\"css/template_css.css\" type=\"text/css\" />";
		echo 
			"<html>".
				"<head>
					<title>$Main->Judul</title>
					$css					
					$this->Cetak_OtherHTMLHead
					<style>
						.ukurantulisan{
							font-size:17px;
						}
						.ukurantulisan1{
							font-size:20px;
						}
						.ukurantulisanIdPenerimaan{
							font-size:16px;
						}
					</style>
				</head>".
			"<body >
				<div style='width:$this->Cetak_WIDTH_Landscape;'>
					<table class=\"rangkacetak\" style='width:33cm;font-family:Times New Roman;margin-left:2cm;margin-top:2cm;'>
						<tr>
							<td valign=\"top\"> <div style='text-align:center;'>
				<span style='font-size:18px;font-weight:bold;text-decoration: '>
					RENCANA KERJA DAN ANGGARAN<br>
					PEJABAT PENGELOLA KEUANGAN DAERAH 
				</span><br>
				<span style='font-size:14px;font-weight:text-decoration: '>
					PROVINSI/Kabupaten/Kota $this->kota<br>
					Tahun Anggaran $this->tahun 
				</span><br>
				
				
				<br>
				
				
				";
		echo "
				<span style='font-size:16px;font-weight:bold;text-decoration: '>
					Rincian Anggaran Pendapatan Pejabat Pengelola Keuangan Daerah
				</span><br>
								<table table width='100%' class='cetak' border='1' style='margin:4 0 0 0;width:100%;'>
									<tr>
										<th class='th01' rowspan='2' colspan='5' >KODE REKENING</th>
										<th class='th01' rowspan='2' >URAIAN</th>
										<th class='th02' rowspan='1' colspan='3' >Rincian Perhitungan</th>
										<th class='th01' rowspan='2' >JUMLAH (Rp)</th>
										
									</tr>
									<tr>
										<th class='th01' >VOLUME</th>
										<th class='th01' >SATUAN</th>
										<th class='th01' >HARGA SATUAN</th>
									</tr>
								
									
		";
		$getTotal = sqlArray(sqlQuery("select sum(jumlah_harga) from view_rka_ppkd_1 where $Kondisi  "));
		$total = number_format($getTotal['sum(jumlah_harga)'],2,',','.');
		$no = 1;
		while($daqry = sqlArray($aqry)){
			foreach ($daqry as $key => $value) { 
				  $$key = $value; 
			} 
			$kondisiFilter = "and no_urut = '$this->urutTerakhir' and tahun  ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'";
			if($k == '0' && $n =='0' ){
				$k = "";
				$l = "";
			    $m = "";
				$n = "";
				$o = "";
				$this->publicVar += 1;
				$getPekerjaan = sqlArray(sqlQuery("select * from ref_pekerjaan where id='$o1' "));
				$uraian = "<span style='font-weight:bold;'>$this->publicVar.". $getPekerjaan['nama_pekerjaan'] . "</span>";
				$getSumJumlahHarga = sqlArray(sqlQuery("select sum(jumlah_harga) from view_rka_ppkd_1 where  o1 ='$o1' $kondisiSKPD $kondisiFilter  "));
				$jumlah_harga = "<span style='font-weight:bold;'>".number_format($getSumJumlahHarga['sum(jumlah_harga)'],2,',','.') . "</span>";
				
				
			}elseif($c1 == '0'){
				$getNamaRekening = sqlArray(sqlQuery("select * from ref_rekening where k='$k' and l='$l' and m='$m' and n='$n' and o='$o'"));
				$jarak = "0px";
				if($o1 !='0' && $o1 !='')$jarak = "10px";
				$uraian = "<span style='font-weight:bold;margin-left:$jarak;'>".$getNamaRekening['nm_rekening']."</b>";
				$getSumJumlahHarga = sqlArray(sqlQuery("select sum(jumlah_harga) from view_rka_ppkd_1 where  k = '$k' and l='$l' and m='$m' and n='$n' and o='$o'  $kondisiSKPD $kondisiFilter"));
				$jumlah_harga = "<b>".number_format($getSumJumlahHarga['sum(jumlah_harga)'],2,',','.');
			}else{
				$k = "";
				$l = "";
			    $m = "";
				$n = "";
				$o = "";
				if($j != '000'){
					$getNamaBarang = sqlArray(sqlQuery("select * from ref_barang where f='$f' and g='$g' and h='$h' and i='$i' and j='$j'"));
					$uraian = "<span style='margin-left:20px;'> ". $getNamaBarang['nm_barang'] . "</span>";
				}else{
					$uraian = "<span style='margin-left:20px;'> ". $rincian_perhitungan . "</span>";
				}
				$jumlah = number_format($jumlah,2,',','.');
				$jumlah_harga = number_format($jumlah_harga,2,',','.');
				$volume_rek = number_format($volume_rek,0,',','.');
				
			}
			
			echo "
								<tr valign='top'>
									<td align='center' class='GarisCetak' >".$k."</td>
									<td align='center' class='GarisCetak' >".$l."</td>
									<td align='center' class='GarisCetak' >".$m."</td>
									<td align='center' class='GarisCetak' >".$n."</td>
									<td align='center' class='GarisCetak' >".$o."</td>
									<td align='left' class='GarisCetak' >".$uraian."</td>
									<td align='right' class='GarisCetak' >".$volume_rek."</td>
									<td align='left' class='GarisCetak'>$satuan_rek</td>
									<td align='right' class='GarisCetak' >".$jumlah."</td>
									<td align='right' class='GarisCetak' >".$jumlah_harga."</td>
								</tr>
			";
			$no++;
			
			
			
			
		}
		echo 				"<tr valign='top'>
									<td align='right' colspan='9' class='GarisCetak'>Jumlah</td>
									<td align='right' class='GarisCetak' ><b>".$total."</b></td>
									
								</tr>
							 </table>";		
		echo 			
						"<br><div class='ukurantulisan' style ='float:right;'>
						$this->kota, ".VulnWalkerTitiMangsa(date('Y-m-d'))."<br>
						PPKD
						<br>
						<br>
						<br>
						<br>
						<br>
						
						<u>".$this->pejabatPengelolaBarang."</u><br>
						NIP	".$this->nipPejabat."
					
						
						</div>	
			</body>	
		</html>";
	}		
function formAlokasi($dt){	
	 global $SensusTmp;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 600;
	 $this->form_height = 430;
	 $this->form_caption = 'ALOKASI KAS';
	 $jumlahHargaForm = $_REQUEST['jumlahHarga'];
	 $id = $_REQUEST['id'];
	 $arrayJenisAlokasi = array(
	 							array('BULANAN','BULANAN'),
								array('TRIWULAN','TRIWULAN')
						  );
	$arrayJenisPerhitungan = array(
	 							array('SEMI OTOMATIS','SEMI OTOMATIS'),
								array('MANUAL','MANUAL')
						  );
						  

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
	 $cmbJenisAlokasi = cmbArray('jenisAlokasi','BULANAN',$arrayJenisAlokasi,'-- JENIS ALOKASI --',"onchange=$this->Prefix.jenisAlokasiChanged($id);") ;
	 $cmbJenisPerhitungan = cmbArray('jenisPerhitungan',$jenisPerhitungan,$arrayJenisPerhitungan,'-- JENIS PERHITUNGAN --',"onchange=$this->Prefix.jenisPerhitunganChanged();") ;
	 //items ----------------------
	  $this->form_fields = array(
			'1' => array( 
						'label'=>'JUMLAH HARGA ',
						'labelWidth'=>150, 
						'value'=>"<input type='hidden' name='jumlahHargaForm' id ='jumlahHargaForm'  value='$jumlahHargaForm'> 
						<input type='text' value='Rp. ".number_format($jumlahHargaForm,2,',','.')."' readonly style='width:210px;'> ",
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
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SaveAlokasi($id);' title='Simpan' >   ".
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
	 $jumlahHargaForm = $_REQUEST['jumlahHarga'];
	 $id = $_REQUEST['id'];
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
	 $cmbJenisAlokasi = cmbArray('jenisAlokasi','TRIWULAN',$arrayJenisAlokasi,'-- JENIS ALOKASI --',"onchange=$this->Prefix.jenisAlokasiChanged($id);") ;
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
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SaveAlokasi($id);' title='Simpan' >   ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
							
		$form = $this->genForm();		
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
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";
							
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
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function Gruping($dt){	
	 global $SensusTmp;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';	
	 foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
			} 			
	 $this->form_width = 600;
	 $this->form_height = 80;
	 $this->form_caption = 'Gruping Pekerjaan';
	 $codeAndNamePekerjaan = "select id, nama_pekerjaan from ref_pekerjaan  ";
	 $cmbPekerjaan = cmbQuery('pekerjaan', $pekerjaan, $codeAndNamePekerjaan,"  ",'-- PEKERJAAN --');
		
	 //items ----------------------
	  $this->form_fields = array(
			'pekerjaan' => array( 
						'label'=>'PEKERJAAN',
						'labelWidth'=>100, 
						'value'=>$cmbPekerjaan." &nbsp <button type='button' onclick=$this->Prefix.newJob(); >Tambah</button>  &nbsp <button type='button' onclick=$this->Prefix.editJob(); >Edit</button>
								<input type='hidden' name='anggota' id='anggota' value='$dt'>
								",
						 ),
			
			
			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".setGrup()' title='Simpan' >   ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}


}
$rkaPPKD1_v2 = new rkaPPKD1_v2Obj();

$arrayResult = VulnWalkerTahap_v2('RKA');
$jenisForm = $arrayResult['jenisForm'];
$nomorUrut = $arrayResult['nomorUrut'];
$tahun = $arrayResult['tahun'];
$jenisAnggaran = $arrayResult['jenisAnggaran'];
$idTahap = $arrayResult['idTahap'];

$rkaPPKD1_v2->jenisForm = $jenisForm;
$rkaPPKD1_v2->nomorUrut = $nomorUrut;
$rkaPPKD1_v2->urutTerakhir = $nomorUrut;
$rkaPPKD1_v2->tahun = $tahun;
$rkaPPKD1_v2->jenisAnggaran = $jenisAnggaran;
$rkaPPKD1_v2->idTahap = $idTahap;

$rkaPPKD1_v2->username = $_COOKIE['coID'];

$rkaPPKD1_v2->wajibValidasi = $Main->wajibValidasi;
if($Main->wajibValidasi == TRUE){
	$rkaPPKD1_v2->sqlValidasi = " and status_validasi ='1' ";
}else{
	$rkaPPKD1_v2->sqlValidasi = " ";
}

if(empty($rkaPPKD1_v2->tahun)){
    
	$get1 = sqlArray(sqlQuery("select max(id_anggaran)  from view_rka_ppkd_1 "));
	$maxAnggaran = $get1['max(id_anggaran)'];
	$get2 = sqlArray(sqlQuery("select * from view_rka_ppkd_1 where id_anggaran = '$maxAnggaran'"));
	/*$rkaPPKD1_v2->tahun = "select max(id_anggaran) as max from view_rka_ppkd_1 where nama_modul = 'rkaPPKD1_v2'";*/
	$rkaPPKD1_v2->tahun  = $get2['tahun'];
	$rkaPPKD1_v2->jenisAnggaran = $get2['jenis_anggaran'];
	$rkaPPKD1_v2->urutTerakhir = $get2['no_urut'];
	$rkaPPKD1_v2->jenisFormTerakhir = $get2['jenis_form_modul'];
	$rkaPPKD1_v2->urutSebelumnya = $rkaPPKD1_v2->urutTerakhir - 1;
	
	
	$idtahapTerakhir = $get2['id_tahap'];
	$namaTahap = sqlArray(sqlQuery("select * from ref_tahap_anggaran where id_tahap = '$idtahapTerakhir'"));
	$rkaPPKD1_v2->namaTahapTerakhir = $namaTahap['nama_tahap'];
	$arrayMasa = explode("-",$namaTahap['tanggal_mulai']);
	$lastTanggalMulai = $arrayMasa[2]."-".$arrayMasa[1]."-".$arrayMasa[0];
	$arrayMasa2 = explode("-",$namaTahap['tanggal_selesai']);
	$lastTanggalSelesai = $arrayMasa2[2]."-".$arrayMasa2[1]."-".$arrayMasa2[0];
	$rkaPPKD1_v2->masaTerakhir = $lastTanggalMulai." JAM : ".$namaTahap['jam_mulai']."  s/d  ".$lastTanggalSelesai." JAM : ".$namaTahap['jam_selesai'];
	
	$arrayHasil =  VulnWalkerLASTTahap_v2();
	$rkaPPKD1_v2->currentTahap = $arrayHasil['currentTahap'];
}else{
	$getCurrenttahap = sqlArray(sqlQuery("select * from ref_tahap_anggaran where id_tahap = '$rkaPPKD1_v2->idTahap'"));
	$rkaPPKD1_v2->currentTahap = $getCurrenttahap['nama_tahap'];
	
	$namaTahap = sqlArray(sqlQuery("select * from ref_tahap_anggaran where id_tahap = '$rkaPPKD1_v2->idTahap'"));
	$rkaPPKD1_v2->jenisFormTerakhir =  $namaTahap['jenis_form_modul'];
	$rkaPPKD1_v2->namaTahapTerakhir = $namaTahap['nama_tahap'];
	$arrayMasa = explode("-",$namaTahap['tanggal_mulai']);
	$lastTanggalMulai = $arrayMasa[2]."-".$arrayMasa[1]."-".$arrayMasa[0];
	$arrayMasa2 = explode("-",$namaTahap['tanggal_selesai']);
	$lastTanggalSelesai = $arrayMasa2[2]."-".$arrayMasa2[1]."-".$arrayMasa2[0];
	$rkaPPKD1_v2->masaTerakhir = $lastTanggalMulai." JAM : ".$namaTahap['jam_mulai']."  s/d  ".$lastTanggalSelesai." JAM : ".$namaTahap['jam_selesai'];
}

$setting = settinganPerencanaan_v2();
$rkaPPKD1_v2->provinsi = $setting['provinsi'];
$rkaPPKD1_v2->kota = $setting['kota'];
$rkaPPKD1_v2->pengelolaBarang = $setting['pengelolaBarang'];
$rkaPPKD1_v2->pejabatPengelolaBarang = $setting['pejabat'];
$rkaPPKD1_v2->pengurusPengelolaBarang = $setting['pengurus'];
$rkaPPKD1_v2->nipPengelola = $setting['nipPengelola'];
$rkaPPKD1_v2->nipPengurus = $setting['nipPengurus'];
$rkaPPKD1_v2->nipPejabat = $setting['nipPejabat'];

?>