<?php
include 'config.php';
echo 'Konversi Alamat kecamatan ke kode kecamatan<br>';
$sqry = "select * from ref_kotakec where kd_kota=14";
$qry=sqlQuery($sqry);
$no = 1;
while ($isi = sqlArray($qry)){


$kondisi=" and (alamat_kec like '%".$isi['nm_wilayah']."%' or alamat like '%kec. ".$isi['nm_wilayah']."%' )";

$uqry = "update kib_a set alamat_c='".$isi['kd_kec']."' where alamat_b=14 $kondisi";

$qry1=sqlQuery($uqry);
$uqry = "update kib_c set alamat_c='".$isi['kd_kec']."' where kd_kota=14 $kondisi";
$qry1=sqlQuery($uqry);
$uqry = "update kib_d set alamat_c='".$isi['kd_kec']."' where kd_kota=14 $kondisi";
$qry1=sqlQuery($uqry);
$uqry = "update kib_f set alamat_c='".$isi['kd_kec']."' where kd_kota=14 $kondisi";
$qry1=sqlQuery($uqry);

echo $uqry."<br>";

}
?>