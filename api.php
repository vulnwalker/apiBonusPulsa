<?php
header("Access-Control-Allow-Origin: *");
//ob_start("ob_gzhandler");
/* ganti selector di index */
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT');

//include("common/vars.php");
include("config.php");
include("common/menu.php");


$Pg = isset($HTTP_GET_VARS["Pg"]) ? $HTTP_GET_VARS["Pg"] : "";
/**
switch ($Pg) {
		case 'jurnalxml':{
			include('pages/jurnal/jurnalxml.php');
			$Jurnalxml->selector();
			break;
		}
		default: {
			header("Location:index.php?");
			break;
		}		
}
*/

switch ($Pg) {
		case 'jurnalxml':{
			include('pages/jurnal/jurnalxml.php');
			$Jurnalxml->selector();
			break;
		}
		case 'daftarBI':{
			include('API/daftarbi.php');
			break;
		}
		case 'upload':{
			include('API/upload.php');
			break;
		}
		case 'hapus_gambar':{
			include('API/hapus.php');
			break;
		}
		case 'skpd':{
			include('API/skpd.php');
			break;
		}
		case 'edit_gambar':{
			include('API/edit.php');
			break;
		}
		case 'default_gambar':{
			include('API/default_gambar.php');
			break;
		}
		case 'bast_post':{//tes bast lewat ajax
			$barang = $_REQUEST['barang'];
			if($barang==1){
				$vbrg = "&barang=1";
			}
			echo 
				"<html>".
				"<head>".
					"<script src='js/jquery.js' type='text/javascript'></script>".	
					"<script>".
						" function test(){ ".
							"
							var objectData = { tgl_ba: document.getElementById('tgl_ba').value  };

							var objectDataString = JSON.stringify(objectData);
							
							$.ajax({
								type:'POST', 
								//data:$('#'+'adminForm').serialize(),
								data :  { o: objectDataString },
								data :  { tgl_ba: document.getElementById('tgl_ba').value ,
									tgl_ba_ak: document.getElementById('tgl_ba_ak').value   },
								//data :  objectDataString ,
								//dataType: 'json',
								//contentType:'application/json',
								//url: this.url+'&tipe=formBaruBI',
								//url: 'http://123.231.253.26/api.php?Pg=bast&tes=2&tgl_ba=2015-03-19',
								url: 'http://180.250.129.116/api.php?Pg=bast&tes=1$vbrg',
								//url : 'http://123.231.253.228/api.php?Pg=bast&tes=1',
								//url: 'api.php?Pg=bast&tes=1',
								//url: 'http://123.231.253.26/api.php?Pg=bast',
								//url: 'api.php?Pg=bast&tes=1&tgl_ba=2015-03-19',
								//crossDomain: true,
							  	success: function(data) {		
									var resp = eval('(' + data + ')');	
									//if (resp.err ==''){		
										//document.getElementById(cover).innerHTML = resp.content;
										//me.AfterFormBaru(resp);	
									/*}else{
										alert(resp.err);
										delElem(cover);
										document.body.style.overflow='auto';
									}*/
							  	}
							});".
						"}".
					"</script>".
				"</head>".
				"<body>
					<form action='' method='post' name='adminForm' id='adminForm'>
					Tgl BA Awal <input type='text' nama='tgl_ba' id='tgl_ba' value='2016-09-30'  ><br>
					Tgl BA Akhir <input type='text' nama='tgl_ba_ak' id='tgl_ba_ak' value='2016-09-30'  >
					<input type='button' nama='bttes' value='tes' onclick='test()' >
					</form>
				</body>".
				"</html>";
			break;	
		}
		case 'bast_post2':{//tes bast lewat post json
			$tgl_ba = $_GET['tgl_ba'];
			$tgl_ba_ak = $_GET['tgl_ba_ak'];
			$barang = $_REQUEST['barang'];
			if($barang==1){
				$vbrg = "&barang=1";
			}
			$url = "http://180.250.129.116/api.php?Pg=bast$vbrg";
			//$url = 'http://123.231.253.228/api.php?Pg=bast';
			//$url = 'http://180.250.129.116/api.php?Pg=bast';
			//data
			$jsonData = array(
				'tgl_ba' => $tgl_ba,
				'tgl_ba_ak' => $tgl_ba_ak,					
			);
			$content = json_encode($jsonData);
			
			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_HEADER, false);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_HTTPHEADER,
			        array("Content-type: application/json"));
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
			
			$json_response = curl_exec($curl);
			
			$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
			/**
			if ( $status != 201 ) {
			    die("Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
				//die($json_response);
			}
			//**/
			
			curl_close($curl);
			//echo $json_response;
			$response = json_decode($json_response, true);
			var_dump( $response);
			/*************************************************************
			http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html

			[Informational 1xx]
			100="Continue"
			101="Switching Protocols"
			
			[Successful 2xx]
			200="OK"
			201="Created"
			202="Accepted"
			203="Non-Authoritative Information"
			204="No Content"
			205="Reset Content"
			206="Partial Content"
			
			[Redirection 3xx]
			300="Multiple Choices"
			301="Moved Permanently"
			302="Found"
			303="See Other"
			304="Not Modified"
			305="Use Proxy"
			306="(Unused)"
			307="Temporary Redirect"
			
			[Client Error 4xx]
			400="Bad Request"
			401="Unauthorized"
			402="Payment Required"
			403="Forbidden"
			404="Not Found"
			405="Method Not Allowed"
			406="Not Acceptable"
			407="Proxy Authentication Required"
			408="Request Timeout"
			409="Conflict"
			410="Gone"
			411="Length Required"
			412="Precondition Failed"
			413="Request Entity Too Large"
			414="Request-URI Too Long"
			415="Unsupported Media Type"
			416="Requested Range Not Satisfiable"
			417="Expectation Failed"
			
			[Server Error 5xx]
			500="Internal Server Error"
			501="Not Implemented"
			502="Bad Gateway"
			503="Service Unavailable"
			504="Gateway Timeout"
			505="HTTP Version Not Supported"

			**************************************************************/


			break;	
		}
		case 'bast':{
			$cek ='';$error='';
			$tes = $_REQUEST['tes'];
			$barang = $_REQUEST['barang'];
			
			//ambil data tanggal
			
			if($tes==1){	
				
				$tg_ba = $_REQUEST['tgl_ba'];
				$tg_ba_ak = $_REQUEST['tgl_ba_ak'];	
				if ($tg_ba_ak == '' || $tg_ba_ak == NULL|| empty($tg_ba_ak) || $tg_ba_ak==FALSE) $tg_ba_ak = $tg_ba;			
			}
			else if($tes==2){	
				$o=$_POST['o'];	//echo $o;
				$o=stripslashes($o); //echo $o;
				//$o = '{"tgl_ba":"2015-03-19"}';//$_POST['o'];	
				//echo $o;
				//$decoded = json_decode($o,true);
				//$tg_ba = $decoded['tgl_ba'];
				//echo 'tgl_ba='.$tg_ba;
				$o=preg_replace('/\s+/', '',$o); 
				$o = str_replace('&quot;', '"', $o);//echo $o;
				$o=preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $o);//	echo $o;
				$decoded =json_decode( $o, true );  //var_dump($decoded);
				/**
				$content = trim(file_get_contents("php://input"));		
				$decoded = json_decode($content);	
							
				**/
				$tg_ba = $decoded['tgl_ba'];	
				//$cek.= $tg_ba;
			}
			else if($tes==3){
				//echo 'tes3';
				//**
				//get param tgl ba ----------------------------------------------------------------------
				//Make sure that it is a POST request.
				
				if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0){
				    throw new Exception('Request method must be POST!');
					//echo 'Request method must be POST!';
				}			
				//Make sure that the content type of the POST request has been set to application/json
				$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
				if(strcasecmp($contentType, 'application/json') != 0){
				    throw new Exception('Content type must be: application/json');
					//echo 'Content type must be: application/json';
				}			
				//Receive the RAW post data.
				$content = trim(file_get_contents("php://input"));	//echo $content;		
				//Attempt to decode the incoming RAW post data from JSON.
				$content=stripslashes($content); //echo $o;				
				$content=preg_replace('/\s+/', '',$content); 
				$content = str_replace('&quot;', '"', $content);//echo $o;
				$content=preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $content);//	echo $o;
				$decoded = json_decode($content, true);			
				//If json_decode failed, the JSON is invalid.
				if(!is_array($decoded)){
				    throw new Exception('Received content contained invalid JSON!');
				}
				$tg_ba = $decoded['tgl_ba']; //echo ' $tg_ba = '.$tg_ba;
				//**/
			
			}
			else if($tes==4){
				//**
				//get param tgl ba ----------------------------------------------------------------------
				//Make sure that it is a POST request.
				if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0){
				    throw new Exception('Request method must be POST!');
				}			
				//Make sure that the content type of the POST request has been set to application/json
				$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
				if(strcasecmp($contentType, 'application/json') != 0){
				    throw new Exception('Content type must be: application/json');
				}			
				//Receive the RAW post data.
				$content = trim(file_get_contents("php://input"));			
				//Attempt to decode the incoming RAW post data from JSON.
				$decoded = json_decode($content, true);			
				//If json_decode failed, the JSON is invalid.
				if(!is_array($decoded)){
				    throw new Exception('Received content contained invalid JSON!');
				}
				$tg_ba = $decoded['tgl_ba'];
				//**/
			}
			else{
				
				//**
				//get param tgl ba from aplication\json ----------------------------------------------------------------------
				//Make sure that it is a POST request.
				
				if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0){
				    //throw new Exception('Request method must be POST!');
					$error.= 'Request method must be POST!';
				}			
				//Make sure that the content type of the POST request has been set to application/json
				$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
				if(strcasecmp($contentType, 'application/json') != 0){
				    //throw new Exception('Content type must be: application/json');
					$error.= 'Content type must be: application/json';
				}			
				//Receive the RAW post data.
				$content = trim(file_get_contents("php://input"));	//echo $content;		
				//Attempt to decode the incoming RAW post data from JSON.
				$decoded = json_decode($content, true);			
				//If json_decode failed, the JSON is invalid.
				if(!is_array($decoded)){
				    //throw new Exception('Received content contained invalid JSON!');
					$error.= 'Received content contained invalid JSON!';
				}
				$tg_ba = $decoded['tgl_ba']; //echo ' $tg_ba = '.$tg_ba;
				//$tg_ba_ak = '';
				$tg_ba_ak = $decoded['tgl_ba_ak']? $decoded['tgl_ba_ak']: $tg_ba ; //echo ' $tg_ba = '.$tg_ba;
				//$barang = $decoded['barang'];
				//if ($tg_ba_ak == '' || $tg_ba_ak == NULL|| empty($tg_ba_ak) || $tg_ba_ak==FALSE) $tg_ba_ak = $tg_ba;
				
				//**/
			}
			//$tg_ba='2016-05-16';
			if($tg_ba != ''){
				
			
				//**
				//kirim balik data bast -----------------------------------------------
				/**
				$qry4 = "select no_ba,no_spk, bk,ck,dk, bk_p,ck_p,dk_p, p,q, count(*) as jml_akun from buku_induk ".
				 	" where tgl_ba='".$tg_ba."' and (id_lama is null or id_lama ='') ". 
					" group by no_ba,no_spk, bk,ck,dk, bk_p,ck_p,dk_p, p,q "; $cek.= $qry4;
				**/
				$qry4 =
					" select tgl_ba, no_ba, no_spk, tgl_spk, bk,ck,dk, bk_p,ck_p,dk_p , p,q, ".
					" count(*) as jml_akun ".
					//, sum(jml_barang) as jml_barang, sum(harga_beli), sum(harga_atribusi) ".
					" from v1_bast ".
					" where 1=1 ".
					//*
					" and no_ba <> '' and no_ba is not null and no_spk<>'' and no_spk is not null ".
					" and tgl_spk <> '0000-00-00' and tgl_spk is not null ".
					" and p<>0 and q<>0 ". 
					//*/
					//" and tgl_ba='".$tg_ba."' ".
					" and tgl_ba>='".$tg_ba."' and tgl_ba<='".$tg_ba_ak."' ".
					" group by tgl_ba, no_ba, no_spk, tgl_spk, bk,ck,dk, bk_p,ck_p,dk_p, p,q ;"
				; $cek.= $qry4;
				$qrba = sqlQuery($qry4) ;			
				$jml_ba = 0;
				$bast = array();
				while($isiba = sqlArray($qrba) ){
					$kd_unit = '';$kd_bidang='';$kd_urus=''; $nm_urus='';
					$no_ba  = $isiba['no_ba'];
					$no_kontrak=$isiba['no_spk'];
					$tgl_kontrak = $isiba['tgl_spk'];
					//$aqrskpd = "select * from ref_skpd where c='".$isiba['c']."' and d='".$isiba['d']."' and e='00' and e1='000' ;"; $cek.= $aqrskpd;
					//$skpd = sqlArray(sqlQuery($aqrskpd));
					//$nm_unit = $skpd['nm_skpd'];
					
					//urusan - bidang ---------------------------------------------------------
					$kd_urus = $isiba['bk'];
					$kd_bidang = $isiba['ck']; 
					$kd_unit= $isiba['dk'];
					/**if($kd_urus == ''){	
						//ambil mapping
						$get = sqlArray(sqlQuery(
							"select * from ref_skpd_urusan where c='".$isiba['c']."' and d='".$isiba['d']."' "
						));
						$kd_urus = $get['bk']; $kd_bidang = $get['ck']; $kd_unit=$get['dk'];
					}**/
					
					$get = sqlArray(sqlQuery( "select * from ref_urusan where bk='$kd_urus' and ck='0' "	));
					$nm_urus = $get['nm_urusan'];
					$get = sqlArray(sqlQuery( "select * from ref_urusan where bk='$kd_urus' and ck='$kd_bidang' and dk=0 "	));
					$nm_bidang = $get['nm_urusan'];
					$get = sqlArray(sqlQuery( "select * from ref_urusan where bk='$kd_urus' and ck='$kd_bidang' and dk='$kd_unit' "	));
					$nm_unit = $get['nm_urusan'];
					
					
					//program - kegiatan -------------------------------------------------------
					$kd_prog=$isiba['bk_p'].'.'.$isiba['ck_p'].'.'. $isiba['p'];
					$get = sqlArray(sqlQuery( "select * from ref_program ".
						"where bk='".$isiba['bk_p']."' and ck='".$isiba['ck_p']."' and dk='".$isiba['dk_p']."' and p='$kd_prog' and q=0 "	));				
					$nm_prog =$get['nama'];				
					
					$kd_keg=$isiba['bk_p'].'.'.$isiba['ck_p'].'.'. $isiba['p'].'.'.$isiba['q'];
					$get = sqlArray(sqlQuery( "select * from ref_program ".
						"where bk='".$isiba['bk_p']."' and ck='".$isiba['ck_p']."' and dk='".$isiba['dk_p']."' and p='$kd_prog' and q='$kd_keg' "	));
					$nm_keg=$get['nama']; 
					
					
					
					//data akun --------------------------------------------------------------
					$jml_akun =0;// $isiba['jml_akun'];
					$akun = array();
					
					//**
					/**
					if($barang==1){
						$aqrbi = 
							"select * from buku_induk ".
							" where no_ba='$no_ba' and tgl_ba='$tg_ba' and tgl_spk='".$isiba['tgl_spk']."' ".
							" and bk='".$isiba['bk']."' and ck='".$isiba['ck']."' and dk='".$isiba['dk']."'  ".
							" and bk_p='".$isiba['bk_p']."' and ck_p='".$isiba['ck_p']."' and dk_p='".$isiba['dk_p']."'  ".
							" and p='".$isiba['p']."' and q='".$isiba['q']."' ".
							" and (id_lama is null or id_lama ='') "
							; 	
					}else{
					**/
						$aqrbi = 
							" select m1,m2,m3,m4,m5 , sum(jml_barang) as jml_barang, sum(harga_beli) as jml_harga,  sum(harga_atribusi) as harga_atribusi from v1_bast ".
							" where no_ba='$no_ba' and tgl_ba='$tg_ba' and no_spk='$no_kontrak' and tgl_spk='".$isiba['tgl_spk']."' ".
							" and bk='".$isiba['bk']."' and ck='".$isiba['ck']."' and dk='".$isiba['dk']."'  ".
							" and bk_p='".$isiba['bk_p']."' and ck_p='".$isiba['ck_p']."' and dk_p='".$isiba['dk_p']."'  ".
							" and p='".$isiba['p']."' and q='".$isiba['q']."' ".
							" group by  m1,m2,m3,m4,m5  ".
							"";	
					//}

					$cek .= $aqrbi;
					$qrbi = sqlQuery($aqrbi);
					while($bi = sqlArray($qrbi)){
						//cari akun belanja modal dari ref_barang
						
						
						$kd_akun = $bi['m1'].'.'.$bi['m2'].'.'.$bi['m3'].'.'.genNumber($bi['m4'],2).'.'. genNumber( $bi['m5'],2 );
						$isiakun = sqlArray(sqlQuery(
							" select * from ref_jurnal where ka='".$bi['m1']."' and kb='".$bi['m2']."' and kc='".$bi['m3']."' and kd='".$bi['m4']."' and ke='".$bi['m5']."' and kf='0' "
						));
						
						
						if($barang==1){
							$aqrbi2 = 
								"select aa.* from buku_induk aa join ref_barang bb on aa.f=bb.f and aa.g=bb.g and aa.h=bb.h and aa.i=bb.i and aa.j=bb.j ".
								" where no_ba='$no_ba' and tgl_ba='$tg_ba' and tgl_spk='".$isiba['tgl_spk']."' ".
								" and bk='".$isiba['bk']."' and ck='".$isiba['ck']."' and dk='".$isiba['dk']."'  ".
								" and bk_p='".$isiba['bk_p']."' and ck_p='".$isiba['ck_p']."' and dk_p='".$isiba['dk_p']."'  ".
								" and p='".$isiba['p']."' and q='".$isiba['q']."' ".
								" and bb.m1='".$bi['m1']."' and bb.m2='".$bi['m2']."' and bb.m3='".$bi['m3']."' and bb.m4='".$bi['m4']."' and bb.m5='".$bi['m5']."' ".
								" and (id_lama is null or id_lama ='') "
								; $cekbrg = $aqrbi2;
							$qrbi2 = sqlQuery($aqrbi2);
							$jml_brg = 0; $data_brg = array();
							while($bi2 = sqlArray($qrbi2)){
								$brg = sqlArray(sqlQuery(
									" select * from ref_barang  ".						
									" where f='".$bi2['f']."' and g='".$bi2['g']."' and h='".$bi2['h']."' and i='".$bi2['i']."' and j='".$bi2['j']."' "
								));	
								$kd_brg = $bi2['f'].".".$bi2['g'].".".$bi2['h'].".".$bi2['i'].".".$bi2['j'];
								$nm_brg=$brg['nm_barang'];
								$data_brg[] = array(
									//'kd_akun' => $kd_akun, // '5.2.3.51.03', belanja modal
									//'nm_akun' => $isiakun['nm_account'],
									'kd_brg' => $kd_brg, 'nm_brg' => $nm_brg, //'nilai' => $bi['jml_harga']
									'nilai' => $bi2['jml_harga']-$bi2['harga_atribusi'],
									'atribusi'=> $bi2['harga_atribusi'],
									'idbrg' => $bi2['id'],
									//'cek' => $cekbrg
								);	
								$jml_brg++;
							}
							
							
						}
						if($barang==1){
							$akun[] = array(
								'kd_akun' => $kd_akun, // '5.2.3.51.03', belanja modal
								'nm_akun' => $isiakun['nm_account'],								
								'nilai' => $bi['jml_harga']-$bi['harga_atribusi'],
								'atribusi'=> $bi['harga_atribusi'],								
								'jml_barang'=>$jml_brg,
								'barang' =>$data_brg
							);
						}else{
							$akun[] = array(
								'kd_akun' => $kd_akun, // '5.2.3.51.03', belanja modal
								'nm_akun' => $isiakun['nm_account'],								
								'nilai' => $bi['jml_harga']-$bi['harga_atribusi'],
								'atribusi'=> $bi['harga_atribusi'],								
								'jml_barang'=>$bi['jml_barang'],
								//'barang' =>$data_brg
							);		
						}
						
						$jml_akun ++;				
					}
					$bast[]= array(
					
						'kd_urus' => $kd_urus, 'nm_urus' => $nm_urus, 
						'kd_bidang' =>  $kd_bidang, 'nm_bidang' => $nm_bidang, 
						'kd_unit' => $kd_unit, 'nm_unit' => $nm_unit, 
						'kd_prog' => $kd_prog, 'nm_prog' => $nm_prog, 
						'kd_keg' => $kd_keg, 	'nm_keg' => $nm_keg,
						'no_ba' => $no_ba, 'tg_ba' => $tg_ba, 
						'no_kontrak' => $no_kontrak, 'tg_kontrak' => $tgl_kontrak,
						'urai_ba' => $urai_ba, 'tg_valid' => $tgl_valid,
						'jml_akun' => $jml_akun, 'akun' => $akun,
						
					);
					$jml_ba++;
				}
			}
			//$jml_ba = 2;
			//$jsonData = array( 'tgl_ba' => $tgl_ba,);
			
			
			$jsonData = array(
				//'cek' => htmlspecialchars( $cek ) ,
				'tgl_ba' => $tg_ba,
				'tgl_ba_ak' => $tg_ba_ak,
				'jml_ba' => $jml_ba,
				'BAST' => $bast,
				'error'=>$error,
			);
			/**if($tes==3){
			$jsonData = array(
				'cek' => $cek,
				'jml_ba' => $jml_ba,
				'BAST' => $bast,
			);
			}**/
			
			
			if($tes==1 || $tes==2 || $tes==3){
				//header('Content-type: application/json');
				echo json_encode( $jsonData );	
			}else if($tes==4){
				//**
				//kirim response ke url lain
				//API Url
				//$url = 'http://localhost/atisisbada_srg/bastp.php';
				$url = 'http://123.231.253.26/bastp.php';
				//Initiate cURL.
				$ch = curl_init($url);
				//Encode the array into JSON.
				$jsonDataEncoded = json_encode($jsonData);			
				//Tell cURL that we want to send a POST request.
				curl_setopt($ch, CURLOPT_POST, 1);			
				//Attach our encoded JSON string to the POST fields.
				curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);			
				//Set the content type to application/json
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 			
				//Execute the request
				$result = curl_exec($ch);
				if(curl_errno($ch)){
				    echo 'Request Error:' . curl_error($ch);
				}
				//**/
			}else{
				header('Content-type: application/json');
				echo json_encode( $jsonData );	
			}
			
				
			
			break;
		}
		case 'bast_akun':{
			$cek ='';$error='';
			$tes = $_REQUEST['tes'];
			//ambil data tanggal
			
			if($tes==1){	
				$tg_ba = $_REQUEST['tgl_ba'];				
			}
			else if($tes==2){	
				$o=$_POST['o'];	//echo $o;
				$o=stripslashes($o); //echo $o;
				//$o = '{"tgl_ba":"2015-03-19"}';//$_POST['o'];	
				//echo $o;
				//$decoded = json_decode($o,true);
				//$tg_ba = $decoded['tgl_ba'];
				//echo 'tgl_ba='.$tg_ba;
				$o=preg_replace('/\s+/', '',$o); 
				$o = str_replace('&quot;', '"', $o);//echo $o;
				$o=preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $o);//	echo $o;
				$decoded =json_decode( $o, true );  //var_dump($decoded);
				/**
				$content = trim(file_get_contents("php://input"));		
				$decoded = json_decode($content);	
							
				**/
				$tg_ba = $decoded['tgl_ba'];	
				//$cek.= $tg_ba;
			}
			else if($tes==3){
				//echo 'tes3';
				//**
				//get param tgl ba ----------------------------------------------------------------------
				//Make sure that it is a POST request.
				
				if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0){
				    throw new Exception('Request method must be POST!');
					//echo 'Request method must be POST!';
				}			
				//Make sure that the content type of the POST request has been set to application/json
				$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
				if(strcasecmp($contentType, 'application/json') != 0){
				    throw new Exception('Content type must be: application/json');
					//echo 'Content type must be: application/json';
				}			
				//Receive the RAW post data.
				$content = trim(file_get_contents("php://input"));	//echo $content;		
				//Attempt to decode the incoming RAW post data from JSON.
				$content=stripslashes($content); //echo $o;				
				$content=preg_replace('/\s+/', '',$content); 
				$content = str_replace('&quot;', '"', $content);//echo $o;
				$content=preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $content);//	echo $o;
				$decoded = json_decode($content, true);			
				//If json_decode failed, the JSON is invalid.
				if(!is_array($decoded)){
				    throw new Exception('Received content contained invalid JSON!');
				}
				$tg_ba = $decoded['tgl_ba']; //echo ' $tg_ba = '.$tg_ba;
				//**/
			
			}
			else if($tes==4){
				//**
				//get param tgl ba ----------------------------------------------------------------------
				//Make sure that it is a POST request.
				if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0){
				    throw new Exception('Request method must be POST!');
				}			
				//Make sure that the content type of the POST request has been set to application/json
				$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
				if(strcasecmp($contentType, 'application/json') != 0){
				    throw new Exception('Content type must be: application/json');
				}			
				//Receive the RAW post data.
				$content = trim(file_get_contents("php://input"));			
				//Attempt to decode the incoming RAW post data from JSON.
				$decoded = json_decode($content, true);			
				//If json_decode failed, the JSON is invalid.
				if(!is_array($decoded)){
				    throw new Exception('Received content contained invalid JSON!');
				}
				$tg_ba = $decoded['tgl_ba'];
				//**/
			}
			else{
				
				//**
				//get param tgl ba from aplication\json ----------------------------------------------------------------------
				//Make sure that it is a POST request.
				
				if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0){
				    //throw new Exception('Request method must be POST!');
					$error.= 'Request method must be POST!';
				}			
				//Make sure that the content type of the POST request has been set to application/json
				$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
				if(strcasecmp($contentType, 'application/json') != 0){
				    //throw new Exception('Content type must be: application/json');
					$error.= 'Content type must be: application/json';
				}			
				//Receive the RAW post data.
				$content = trim(file_get_contents("php://input"));	//echo $content;		
				//Attempt to decode the incoming RAW post data from JSON.
				$decoded = json_decode($content, true);			
				//If json_decode failed, the JSON is invalid.
				if(!is_array($decoded)){
				    //throw new Exception('Received content contained invalid JSON!');
					$error.= 'Received content contained invalid JSON!';
				}
				$tg_ba = $decoded['tgl_ba']; //echo ' $tg_ba = '.$tg_ba;
				//$tg_ba_ak = $decoded['tgl_ba_ak']; //echo ' $tg_ba = '.$tg_ba;
				//if ($tg_ba_ak == '') $tg_ba_ak = $tg_ba;
				//**/
			}
			//$tg_ba='2016-05-16';
			if($tg_ba != ''){
				
			
				//**
				//kirim balik data bast -----------------------------------------------
				/**
				$qry4 = "select no_ba,no_spk, bk,ck,dk, bk_p,ck_p,dk_p, p,q, count(*) as jml_akun from buku_induk ".
				 	" where tgl_ba='".$tg_ba."' and (id_lama is null or id_lama ='') ". 
					" group by no_ba,no_spk, bk,ck,dk, bk_p,ck_p,dk_p, p,q "; $cek.= $qry4;
				**/
				$qry4 =
					" select tgl_ba, no_ba, no_spk, tgl_spk, bk,ck,dk, bk_p,ck_p,dk_p , p,q, ".
					" count(*) as jml_akun ".
					//, sum(jml_barang) as jml_barang, sum(harga_beli), sum(harga_atribusi) ".
					" from v1_bast ".
					" where 1=1 ".
					//*
					" and no_ba <> '' and no_ba is not null and no_spk<>'' and no_spk is not null ".
					" and tgl_spk <> '0000-00-00' and tgl_spk is not null ".
					" and p<>0 and q<>0 ". 
					//*/
					" and tgl_ba='".$tg_ba."' ".
					//" and tgl_ba>='".$tg_ba."' and tgl_ba<='".$tg_ba_ak."' ".
					" group by tgl_ba, no_ba, no_spk, tgl_spk, bk,ck,dk, bk_p,ck_p,dk_p, p,q ;"
				; $cek.= $qry4;
				$qrba = sqlQuery($qry4) ;			
				$jml_ba = 0;
				$bast = array();
				while($isiba = sqlArray($qrba) ){
					$kd_unit = '';$kd_bidang='';$kd_urus=''; $nm_urus='';
					$no_ba  = $isiba['no_ba'];
					$no_kontrak=$isiba['no_spk'];
					//$aqrskpd = "select * from ref_skpd where c='".$isiba['c']."' and d='".$isiba['d']."' and e='00' and e1='000' ;"; $cek.= $aqrskpd;
					//$skpd = sqlArray(sqlQuery($aqrskpd));
					//$nm_unit = $skpd['nm_skpd'];
					
					//urusan - bidang ---------------------------------------------------------
					$kd_urus = $isiba['bk'];
					$kd_bidang = $isiba['ck']; 
					$kd_unit= $isiba['dk'];
					/**if($kd_urus == ''){	
						//ambil mapping
						$get = sqlArray(sqlQuery(
							"select * from ref_skpd_urusan where c='".$isiba['c']."' and d='".$isiba['d']."' "
						));
						$kd_urus = $get['bk']; $kd_bidang = $get['ck']; $kd_unit=$get['dk'];
					}**/
					
					$get = sqlArray(sqlQuery( "select * from ref_urusan where bk='$kd_urus' and ck='0' "	));
					$nm_urus = $get['nm_urusan'];
					$get = sqlArray(sqlQuery( "select * from ref_urusan where bk='$kd_urus' and ck='$kd_bidang' and dk=0 "	));
					$nm_bidang = $get['nm_urusan'];
					$get = sqlArray(sqlQuery( "select * from ref_urusan where bk='$kd_urus' and ck='$kd_bidang' and dk='$kd_unit' "	));
					$nm_unit = $get['nm_urusan'];
					
					
					//program - kegiatan -------------------------------------------------------
					$kd_prog=$isiba['bk_p'].'.'.$isiba['ck_p'].'.'. $isiba['p'];
					$get = sqlArray(sqlQuery( "select * from ref_program ".
						"where bk='".$isiba['bk_p']."' and ck='".$isiba['ck_p']."' and dk='".$isiba['dk_p']."' and p='$kd_prog' and q=0 "	));				
					$nm_prog =$get['nama'];				
					
					$kd_keg=$isiba['bk_p'].'.'.$isiba['ck_p'].'.'. $isiba['p'].'.'.$isiba['q'];
					$get = sqlArray(sqlQuery( "select * from ref_program ".
						"where bk='".$isiba['bk_p']."' and ck='".$isiba['ck_p']."' and dk='".$isiba['dk_p']."' and p='$kd_prog' and q='$kd_keg' "	));
					$nm_keg=$get['nama']; 
					
					
					
					//data akun --------------------------------------------------------------
					$jml_akun =0;// $isiba['jml_akun'];
					$akun = array();
					
					/**
					$aqrbi = 
						"select m1,m2,m3,m4,m5 ,  sum(harga_beli) as jml_harga,  sum(harga_atribusi) as harga_atribusi from ".
						" (select bb.m1,bb.m2,bb.m3,bb.m4,bb.m5 from buku_induk aa ".
						" join ref_barang bb on aa.f=bb.f and aa.g=bb.g and aa.h=bb.h and aa.i=bb.i and aa.j = bb.j ". 
						" where aa.no_ba='$no_ba' and aa.tgl_ba='$tg_ba' and aa.no_spk='$no_kontrak' ".
						" and aa.bk='".$isiba['bk']."' and aa.ck='".$isiba['ck']."' and aa.dk='".$isiba['dk']."'  ".
						" and aa.bk_p='".$isiba['bk_p']."' and aa.ck_p='".$isiba['ck_p']."' and aa.dk_p='".$isiba['dk_p']."'  ".
						" and aa.p='".$isiba['p']."' and aa.q='".$isiba['q']."' ".
						" and (id_lama is null or id_lama ='') ".
						" )"
						; 
					**/
					$aqrbi = 
						" select m1,m2,m3,m4,m5 , sum(jml_barang) as jml_barang, sum(harga_beli) as jml_harga,  sum(harga_atribusi) as harga_atribusi from v1_bast ".
						" where no_ba='$no_ba' and tgl_ba='$tg_ba' and no_spk='$no_kontrak' and tgl_spk='".$isiba['tgl_spk']."' ".
						" and bk='".$isiba['bk']."' and ck='".$isiba['ck']."' and dk='".$isiba['dk']."'  ".
						" and bk_p='".$isiba['bk_p']."' and ck_p='".$isiba['ck_p']."' and dk_p='".$isiba['dk_p']."'  ".
						" and p='".$isiba['p']."' and q='".$isiba['q']."' ".
						" group by  m1,m2,m3,m4,m5  ".
						"";	
					

					$cek .= $aqrbi;
					$qrbi = sqlQuery($aqrbi);
					while($bi = sqlArray($qrbi)){
						//cari akun belanja modal dari ref_barang
						/**$brg = sqlArray(sqlQuery(
							" select * from ref_barang  ".						
							" where f='".$bi['f']."' and g='".$bi['g']."' and h='".$bi['h']."' and i='".$bi['i']."' and j='".$bi['j']."' "
						));**/
						$kd_akun = $bi['m1'].'.'.$bi['m2'].'.'.$bi['m3'].'.'.genNumber($bi['m4'],2).'.'. genNumber( $bi['m5'],2 );
						$isiakun = sqlArray(sqlQuery(
							" select * from ref_jurnal where ka='".$bi['m1']."' and kb='".$bi['m2']."' and kc='".$bi['m3']."' and kd='".$bi['m4']."' and ke='".$bi['m5']."' and kf='0' "
						));
						
						$kd_brg = $bi['f'].".".$bi['g'].".".$bi['h'].".".$bi['i'].".".$bi['j'];
						$nm_brg=$brg['nm_barang'];
						$akun[] = array(
							'kd_akun' => $kd_akun, // '5.2.3.51.03', belanja modal
							'nm_akun' => $isiakun['nm_account'],
							//'kd_brg' => $kd_brg, //'nm_brg' => $nm_brg, //'nilai' => $bi['jml_harga']
							'nilai' => $bi['jml_harga']-$bi['harga_atribusi'],
							'atribusi'=> $bi['harga_atribusi'],
							//'idbrg' => $bi['id'],
						);	
						$jml_akun ++;				
					}
					$bast[]= array(
					
					'kd_urus' => $kd_urus, 'nm_urus' => $nm_urus, 
					'kd_bidang' =>  $kd_bidang, 'nm_bidang' => $nm_bidang, 
					'kd_unit' => $kd_unit, 'nm_unit' => $nm_unit, 
					'kd_prog' => $kd_prog, 
					'nm_prog' => $nm_prog, 
					'kd_keg' => $kd_keg, 
					'nm_keg' => $nm_keg,
						'no_ba' => $no_ba, 'tg_ba' => $tg_ba, 'no_kontrak' => $no_kontrak,
								'urai_ba' => $urai_ba, 'tg_valid' => $tgl_valid,
								'jml_akun' => $jml_akun, 'akun' => $akun
							);
					$jml_ba++;
				}
			}
			//$jml_ba = 2;
			//$jsonData = array( 'tgl_ba' => $tgl_ba,);
			
			
			$jsonData = array(
				//'cek' => htmlspecialchars( $cek ) ,
				'jml_ba' => $jml_ba,
				'BAST' => $bast,
				'error'=>$error,
			);
			/**if($tes==3){
			$jsonData = array(
				'cek' => $cek,
				'jml_ba' => $jml_ba,
				'BAST' => $bast,
			);
			}**/
			
			
			if($tes==1 || $tes==2 || $tes==3){
				//header('Content-type: application/json');
				echo json_encode( $jsonData );	
			}else if($tes==4){
				//**
				//kirim response ke url lain
				//API Url
				//$url = 'http://localhost/atisisbada_srg/bastp.php';
				$url = 'http://123.231.253.26/bastp.php';
				//Initiate cURL.
				$ch = curl_init($url);
				//Encode the array into JSON.
				$jsonDataEncoded = json_encode($jsonData);			
				//Tell cURL that we want to send a POST request.
				curl_setopt($ch, CURLOPT_POST, 1);			
				//Attach our encoded JSON string to the POST fields.
				curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);			
				//Set the content type to application/json
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 			
				//Execute the request
				$result = curl_exec($ch);
				if(curl_errno($ch)){
				    echo 'Request Error:' . curl_error($ch);
				}
				//**/
			}else{
				header('Content-type: application/json');
				echo json_encode( $jsonData );	
			}
			
				
			
			break;
		}
		
		default: {
			include('API/login.php');
			break;
		}		
}


?>