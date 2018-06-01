<?php
//header("Content-Type: text/javascript; charset=utf-8");
ob_start("ob_gzhandler");
/* ganti selector di index */
// include("common/vars.php");
include("config.php");

$Pg = isset($HTTP_GET_VARS["Pg"]) ? $HTTP_GET_VARS["Pg"] : "";

//if (CekLogin ()) {
  //  setLastAktif();

    switch ($Pg) {


		case 'aksi':{
  			include('pages/perencanaan/daftarobj.php');

  					include("pages/aksi/aksi.php"); //break;
  					$aksi->selector();

  			break;
		}

    case 'api':{
  			include('pages/perencanaan/daftarobj.php');

  					include("pages/api/api.php"); //break;
  					$api->selector();

  			break;
		}



	 }

	ob_flush();
	flush();

//} else {  header("Location: http://atisisbada.net/");}
?>
