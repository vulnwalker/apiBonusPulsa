<?php
/*
	pesan dari usr2 sukses diterima
*/
include ('../../config.php');

$idt = $_GET['idt'];
$idk = $_GET['idk'];

$err='';

$arr=explode(',',$idt);
for ($i=0;$i<sizeof($arr);$i++){	
	$sqry = 'update chatx set terkirim2 = 1 where Id= '.$arr[$i].'';
	//$err .=$sqry.'<br>';
	$qry = sqlQuery($sqry);
}

$arr=explode(',',$idk);
for ($i=0;$i<sizeof($arr);$i++){	
	$sqry = 'update chatx set terkirim1 = 1 where Id= '.$arr[$i].'';//$err .=$sqry.'<br>';
	$qry = sqlQuery($sqry);
}

$sqry = 'delete from chatx where terkirim1=1 and terkirim2=1';
$qry = sqlQuery($sqry);

echo $err;




?>