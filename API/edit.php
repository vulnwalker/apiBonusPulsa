<?php 
 
	$Id =$_GET["Id"];
	$ket=$_GET["ket"];
	$uid=$_GET["uid"];
	$err="";
	$tgl_update=date('Y/m/d h:i:s');
	
 	$query = "select * FROM gambar WHERE Id='$Id' ";	 
	$hasil = sqlQuery($query);
	$hapus = sqlArray($hasil);
	if (sqlNumRow($hasil) > 0) {
		$response = array();
				
		$query1 = "update gambar set".
				" ket='$ket',".
				" uid='$uid',".
				" tgl_update='$tgl_update'".
				" where Id='$Id' ";	 
		$hasil1 = sqlQuery($query1);
			if($hasil1==FALSE){
				$response["success"] = "0";
				$response["message"] = "Query salah ".mysql_error();
				$err=$response["message"];
			}			
				
		 if ($err==""){
		 	$response["success"] = "1";
		 	$response["message"] = "Data Sukses Edit"; 
		 }
		 
		echo json_encode($response);
	} else {
	    $response["success"] = "0";
	    $response["message"] = "Tidak ada data ".$query;
	    echo json_encode($response);
	}	

?>