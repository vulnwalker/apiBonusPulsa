<?php
	 
	$query = "select * from ref_barang limit 5 ";
	$hasil = sqlQuery($query);
	if (sqlNumRow($hasil) > 0) {
		$response = array();
		$response["barang"] = array();
		while ($data = sqlArray($hasil)){
			$h['nm_barang']     = $data['nm_barang'] ;
			$h['f']      = $data['f'] ;
			$h['g']      = $data['g'] ;
			$h['h']      = $data['h'];
			$h['i']      = $data['i'];
			$h['j']      = $data['j']; 
			
			array_push($response["barang"], $h);
		}
		$response["success"] = "1";
		echo json_encode($response);
	} else {
	    $response["success"] = "0";
	    $response["message"] = "Tidak ada data";
	    echo json_encode($response);
	}
?>