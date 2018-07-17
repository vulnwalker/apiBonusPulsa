<?php 
 
	$uid    = $_GET["uid"];
	$pass=md5($_GET["password"]);
	$password = $pass;
 
	$query = "select * from admin where uid='$uid' and password='$password' ";
	 
	$hasil = sqlQuery($query);
	if (sqlNumRow($hasil) > 0) {
		$response = array();
		$response["login"] = array();
		while ($data = sqlArray($hasil)){
			$h['uid']            = $data['uid'] ;
			$h['nama']          = $data['nama'] ;
			$h['group']         = $data['group'] ;
			$h['password']      = $data['password'];
			 
			array_push($response["login"], $h);
		}
		$response["success"] = "1";
		echo json_encode($response);
	} else {
	    $response["success"] = "0";
	    $response["message"] = "Tidak ada data";
	    echo json_encode($response);
	}

?>