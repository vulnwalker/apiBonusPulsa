<?php 
 
	$Id =$_GET["Id"];
	$idBI=$_GET["idbi"];
	$uid=$_GET["uid"];
	$err="";
	$tgl_update=date('Y/m/d h:i:s');
	
 	$query = "select * FROM gambar WHERE Id='$Id' ";	 
	$hasil = sqlQuery($query);
	$hapus = sqlArray($hasil);
	if (sqlNumRow($hasil) > 0) {
		$response = array();
				
		$query1 = "update gambar set".
				" stat='1',".
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
		 	$query2 = "update gambar set".
				" stat='',".
				" uid='$uid',".
				" tgl_update='$tgl_update'".
				" where idbi='$idBI' and Id<>'$Id'";	 
			$hasil2 = sqlQuery($query2);
			if($hasil2==FALSE){
				$response["success"] = "0";
				$response["message"] = "Query salah ".mysql_error();
				$err=$response["message"];
		 }
		 }
		 
		 if ($err==""){
		 	$response["success"] = "1";
		 	$response["message"] = "Data Default Sukses"; 
		 }
		 
		echo json_encode($response);
	} else {
	    $response["success"] = "0";
	    $response["message"] = "Tidak ada data ".$query;
	    echo json_encode($response);
	}	

?>