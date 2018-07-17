<?php

error_reporting(0);
set_time_limit(0);


$Main->versi = '';

$HTTP_SERVER_VARS = isset($_SERVER)? $_SERVER : @$HTTP_SERVER_VARS;
$HTTP_POST_VARS = isset($_POST)? $_POST : @$HTTP_POST_VARS;
$HTTP_GET_VARS = isset($_GET)? $_GET : @$HTTP_GET_VARS;
$HTTP_COOKIE_VARS = isset($_COOKIE)? $_COOKIE : @$HTTP_COOKIE_VARS;

$Main->Judul = "KEUANGAN PILAR";
$Main->CopyRightText = 'Copyright &copy; 2018. Alim Rugi Productions.';
$Main->CopyRight =
	"<br>
	<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" class=\"hakcipta\">
	<tr><td>".
		$Main->CopyRightText .
	"</td></tr>
	</table>";

$Main->HeadScript ='
	<!--<script language="JavaScript" src="lib/js/JSCookMenu_mini.js" type="text/javascript"></script>
	<script language="JavaScript" src="lib/js/ThemeOffice/theme.js" type="text/javascript"></script>
	-->
	<script language="JavaScript" src="lib/js/joomla.javascript.js" type="text/javascript"></script>

	<script language="JavaScript" src="js/ajaxc2.js" type="text/javascript"></script>

	<script src="js/jquery.js" type="text/javascript"></script>

	<script language="JavaScript" src="dialog/dialog.js" type="text/javascript"></script>
	<script language="JavaScript" src="js/global.js" type="text/javascript"></script>
	<script language="JavaScript" src="js/base.js" type="text/javascript"></script>
	<script language="JavaScript" src="js/encoder.js" type="text/javascript"></script>
	<script language="JavaScript" src="lib/chatx/chatx.js" type="text/javascript"></script>
	<script src="js/daftarobj.js" type="text/javascript"></script>
	';

$Main->HeadStyle = "
	<link rel='stylesheet' href='css/menu.css' type='text/css' />
	<link rel='stylesheet' href='css/template_css.css' type='text/css' />
	<link rel='stylesheet' href='css/theme.css' type='text/css' />
	<link rel='stylesheet' href='dialog/dialog.css' type='text/css' />
	<link rel='stylesheet' href='lib/chatx/chatx.css' type='text/css' />

	<link rel='stylesheet' href='css/base.css' type='text/css' />
	<!--<link rel='stylesheet' href='css/sislog.css' type='text/css' />-->
	<!--<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"js/jscalendar-1.0/calendar-win2k-cold-1.css\" title=\"win2k-cold-1\" />-->

	";

$Main->NavAtas="";
$Main->NavBawah="";
$Main->Isi = "";
$Main->ImageLeft="";

$Main->KondisiBarang = array(
	array("1","Baik"),
	array("2","Kurang Baik"),
	array("3","Rusak Berat")
);



/*
$Main->Modul = array(
"00"=>array("","",""),
"01"=>array("01","Perencanaan Kebutuhan dan Penganggaran","tempate_01.gif"),
"02"=>array("02","Pengadaan","pengadaan_01.gif"),
"03"=>array("03","Penerimaan, Penyimpanan dan Penyaluran","penerimaan_01.gif"),
"04"=>array("04","Penggunaan","penerimaan_01.gif"),
"05"=>array("05","Penatausahaan","penatausahaan_ico.gif"),
"06"=>array("06","Pemanfaatan","pemanfaatan_ico.gif"),
"07"=>array("07","Pengamanan dan Pemeliharaan","pengamanan_ico.gif"),
"08"=>array("08","Penilaian","penilaian_ico.gif"),
"09"=>array("09","Penghapusan","penghapusan_ico.gif"),
"10"=>array("10","Pemindahtanganan","pemindahtanganan_ico.gif"),
"11"=>array("11","Pembiayaan","pembiayaan_01.gif"),
"12"=>array("12","Tuntutan Ganti Rugi","gantirugi_ico.gif"),
"13"=>array("13","Pembinaan Pengawasan dan Pengendalian","pengawasan_01.gif"),
"14"=>array("14","Referensi Data","masterData_01.gif"),
"15"=>array("15","Administrasi","penggunaan_01.gif"),
"16"=>array("16","Laporan-laporan","penggunaan_01.gif"),
"ref"=>array("14","Referensi Data","masterData_01.gif"),
"Admin"=>array("15","Administrasi","administrasi_01.gif"),
"Menu"=>array("16","Chating","cpanel.png")
);
*/

$Ref->NamaBulan  = array(
	"Januari", "Pebruari", "Maret", "April","Mei",
	"Juni",	"Juli",	"Agustus",	"September","Oktober",
	"Nopember","Desember"
);
$Ref->NamaBulan2  = array(
	array("01","Januari"),
	array("02","Pebruari"),
	array("03","Maret"),
	array("04","April"),
	array("05","Mei"),
	array("06","Juni"),
	array("07","Juli"),
	array("08","Agustus"),
	array("09","September"),
	array("10","Oktober"),
	array("11","Nopember"),
	array("12","Desember")
);

$Main->UserModul = array("Disabled","Write","Read");
$Main->UserLevel = array("Guest","Adminisrator","Operator");

$Main->ArYaTidak = array(
	array('1','Ya'),
	array('2','Tidak')
);

$Main->ArrAda = array(
	array("1","Ada"),
	array("2","Tidak Ada"),
);

$Main->batas = "<div style='float:left;margin: 0 8 0 4;border-left: 1px solid #E5E5E5;height:22'></div>"; //batas kolom filter
$Main->baris = "<div style='border-top: 1px solid #E5E5E5;height:1'></div>"; //batas baris filter

$Main->arrKunjungan = array(
	array ('1', 'Rawat Jalan'),
	array ('2', 'Rawat Inap'),
	array ('3', 'IGD'),
);

$Main->arrGolDarah = array(
	array ('A', 'A'),
	array ('B', 'B'),
	array ('AB', 'AB'),
	array ('O', 'O'),
);
$Main->arrStatusKawin = array(
	array ('1', 'Kawin'),
	array ('2', 'Belum Kawin'),
	array ('3', 'Janda'),
	array ('4', 'Duda'),
);


$Main->arrStatusBayar =array(
	array('1', 'Belum Bayar'),
	array('2', 'Belum Lunas'),
	array('3', 'Lunas'),
);

$Main->arrStatusBerkas = array(
	array('1', 'Permintaan'),
	array('2', 'Keluar'),
	array('3', 'Masuk'),
);
$Main->arrStatusGizi = array(
	array('1', 'Permintaan'),
	array('2', 'Rencana'),
	array('3', 'Keluar'),
);
$Main->arrStatusPenunjang = array(
	array('1', 'Permintaan'), 	//permintaan u/ diperiksa
	array('2', 'Periksa'),		//sudah diperiksa dan entry hasil
	array('3', 'Ambil Hasil'), 	//pasien sudah ambil hasil
);
$Main->arrStatusFarmasi = array(
	array('1', 'Pesan'),		//pesan obat
	array('2', 'Ambil Obat'),	//obat sudah diambil
);



//---------- DEFAULT SYSTEM -----------------
$USER_TIME_OUT = 30;//menit
$Main->PagePerHal 		= 50;
$Main->JmlDataHal 		= 0;
$Main->SHOW_CEK = TRUE;
$Main->bgcolor = '#005608';


$Main->kopLaporan =
	"<span style='font-size:12;'><b>KEMENTRIAN ENERGI DAN SUMBERDAYA MINERAL REPUBLIK INDONESIA</b></span><br>".
	"<span style='font-size:14;'><b>B A D A N &nbsp;&nbsp;  G E O L O G I</b></span><br>".
	"<span style='font-size:10;'>Jl. Diponegoro No. 57 Bandung, Telp. 022-7206515 Fax: 7218154</span><br>".
	"<span style='font-size:10;'>jl. Jend. Gatot Subroto kav. 49 Jakarta 12950, Telp.021-5228371 Fax: 5228372".
	"<hr>".
	//"website: http://www.rsudalihsan.jabarprov<br>".
	"";
$Main->KOTA_ASAL = '01';
$Main->PROV_ASAL = '01';
$Main->k1 = '1';
$Main->k2 = '1';
$Main->k3 = '7';

?>
