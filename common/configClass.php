<?php

class configClass extends DaftarObj2 {
  var $arrayMetodeTransaksi = array(
    array("1","CASH"),
    array("2","TRANSFER"),
    array("3","CEK"),
  );
  var $listMetodeTransaksi = array("CASH","TRANSFER","CEK");
  function __construct()  {
    global $Main;
    $this->userName = $_COOKIE['coID'];
    $getSetting = $this->getSetting();
    $this->tahunAnggaran = $_COOKIE['coTahunAnggaran'];
    $getDataTahunAnggaran = sqlArray(sqlQuery("select * from ref_tahun_anggaran where tahun = '$this->tahunAnggaran'"));
    $this->tanggalSaldoAwal = $getDataTahunAnggaran['tanggal_saldo_awal'];
    $getDataUser = sqlArray(sqlQuery("select * from admin where uid ='$this->userName'"));
    $this->jsonHakAkses = $getDataUser['hak_akses'];
    $this->levelUser = $getDataUser['jenis_user'];

    $hakAkses = json_decode($this->jsonHakAkses);
    for ($i=0; $i < sizeof($hakAkses) ; $i++) {
			if($hakAkses[$i]->jenis == 'bank'){
        $this->arrayAllowIdBank[] = $hakAkses[$i]->id;
			}else{
        $this->arrayAllowIdKas[] = $hakAkses[$i]->id;
			}
		}

    $this->allowIdBank = " and id in (".implode(",",$this->arrayAllowIdBank).") ";
    $this->allowIdKas = " and id in (".implode(",",$this->arrayAllowIdKas).") ";
    if(sizeof($this->arrayAllowIdBank) == 1 && sizeof($this->arrayAllowIdKas) == 0){
      $this->oneJenisTransaksi = "1";
      $this->oneIdBank = $this->arrayAllowIdBank[0];
    }elseif(sizeof($this->arrayAllowIdKas) == 1 && sizeof($this->arrayAllowIdBank) == 0){
      $this->oneJenisTransaksi = "2";
      $this->oneIdKas = $this->arrayAllowIdKas[0];
    }else{
      $this->oneJenisTransaksi = "";
    }

  }
  function isiform($value){
    $isinya = '';
    $tbl ='<table width="100%">';
    for($i=0;$i<count($value);$i++){
      if(!isset($value[$i]['align']))$value[$i]['align'] = "left";
      if(!isset($value[$i]['valign']))$value[$i]['valign'] = "top";

      if(isset($value[$i]['type'])){
        switch ($value[$i]['type']){
          case "text" :
            $isinya = "<input type='text' name='".$value[$i]['name']."' id='".$value[$i]['name']."' ".$value[$i]['parrams']." value='".$value[$i]['value']."' />";
          break;
          case "hidden" :
            $isinya = "<input type='hidden' name='".$value[$i]['name']."' id='".$value[$i]['name']."' ".$value[$i]['parrams']." value='".$value[$i]['value']."' />";
          break;
          case "password" :
            $isinya = "<input type='password' name='".$value[$i]['name']."' id='".$value[$i]['name']."' ".$value[$i]['parrams']." value='".$value[$i]['value']."' />";
          break;
          default:
            $isinya = $value[$i]['value'];
          break;
        }
      }else{
        $isinya = $value[$i]['value'];
      }

      $tbl .= "
        <tr>
          <td width='".$value[$i]['label-width']."' valign='top'>".$value[$i]['label']."</td>
          <td width='10px' valign='top'>:<br></td>
          <td align='".$value[$i]['align']."' valign='".$value[$i]['valign']."'> $isinya</td>
        </tr>
      ";
    }
    $tbl .= '</table>';
    return $tbl;
  }
  function buttonComponent($js,$img,$name,$alt,$judul){
  return "<table cellpadding='0' cellspacing='0' border='0' id='toolbar'>
        <tbody><tr valign='middle' align='center'>
        <td class='border:none'>
          <a class='toolbar' id='btsave'
            href='javascript:$js'>
          <img src='images/administrator/images/$img' alt='$alt' name='$name' width='32' height='32' border='0' align='middle' title='$judul'> $judul</a>
        </td>
        </tr>
        </tbody></table> ";
}
    function genForm2($withForm=TRUE){
  		$form_name = $this->Prefix."_form";

  		if($withForm){
  			$params->tipe=1;
  			$form= "<form name='$form_name' id='$form_name' method='post' action=''>".
  				createDialog(
  					$form_name.'_div',
  					$this->setForm_content(),
  					$this->form_width,
  					$this->form_height,
  					$this->form_caption,
  					'',
  					$this->form_menubawah.
  					"<input type='hidden' id='".$this->Prefix."_idplh' name='".$this->Prefix."_idplh' value='$this->form_idplh' >
  					<input type='hidden' id='".$this->Prefix."_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >"
  					,//$this->setForm_menubawah_content(),
  					$this->form_menu_bawah_height,
  					'',$params
  					).
  				"</form>";

  		}else{
  			$form=
  				createDialog(
  					$form_name.'_div',
  					$this->setForm_content(),
  					$this->form_width,
  					$this->form_height,
  					$this->form_caption,
  					'',
  					$this->form_menubawah.
  					"<input type='hidden' id='".$this->Prefix."_idplh' name='".$this->Prefix."_idplh' value='$this->form_idplh' >
  					<input type='hidden' id='".$this->Prefix."_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >"
  					,//$this->setForm_menubawah_content(),
  					$this->form_menu_bawah_height
  				);


  		}
  		return $form;
  	}
    function genForm2KB($withForm=TRUE){
  		$form_name = $this->Prefix."_KBform";

  		if($withForm){
  			$params->tipe=1;
  			$form= "<form name='$form_name' id='$form_name' method='post' action=''>".
  				createDialog(
  					$form_name.'_div',
  					$this->setForm_content(),
  					$this->form_width,
  					$this->form_height,
  					$this->form_caption,
  					'',
  					$this->form_menubawah.
  					"<input type='hidden' id='".$this->Prefix."_idplh' name='".$this->Prefix."_idplh' value='$this->form_idplh' >
  					<input type='hidden' id='".$this->Prefix."_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >"
  					,//$this->setForm_menubawah_content(),
  					$this->form_menu_bawah_height,
  					'',$params
  					).
  				"</form>";

  		}else{
  			$form=
  				createDialog(
  					$form_name.'_div',
  					$this->setForm_content(),
  					$this->form_width,
  					$this->form_height,
  					$this->form_caption,
  					'',
  					$this->form_menubawah.
  					"<input type='hidden' id='".$this->Prefix."_idplh' name='".$this->Prefix."_idplh' value='$this->form_idplh' >
  					<input type='hidden' id='".$this->Prefix."_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >"
  					,//$this->setForm_menubawah_content(),
  					$this->form_menu_bawah_height
  				);


  		}
  		return $form;
  	}
    function numberFormat($value,$angka = 0){
      return number_format($value,$angka,',','.');
    }
    function loadCalendar(){
      return '

      <script src="lib/jQuery-Mask-Plugin-master/src/jquery.mask.js"></script>
        <link rel="stylesheet" href="datepicker/jquery-ui.css">
				<script src="datepicker/jquery-ui.js"></script>';
    }
    function getImageReport(){
        $getLokasiGambar = sqlArray(sqlQuery("select * from settingperencanaan"));
        return $getLokasiGambar['logo'];
    }
    function getVersiName(){
      $getVersiName = sqlArray(sqlQuery("SELECT * FROM setting where Id = 'VERSI_NAME'"));
      return $getVersiName['nilai'];
    }
    function titiMangsa($date) {
        $BulanIndo    = array("Januari", "Februari", "Maret","April", "Mei", "Juni","Juli", "Agustus", "September","Oktober", "November", "Desember");
        $tahun        = substr($date, 0, 4);
        $bulan        = substr($date, 5, 2);
        $tgl          = substr($date, 8, 2);
        $result       = $tgl." ".$BulanIndo[(int)$bulan-1]." ".$tahun;
        return($result);
    }
    function generateDate($tanggal){
        $tanggal = explode('-',$tanggal);
        $tanggal = $tanggal[2]."-".$tanggal[1]."-".$tanggal[0];
        return $tanggal;
    }
    function getPageHeader($fileName){
      $getModulPersediaan = sqlArray(sqlQuery("select * from setting where Id = 'PERENCANAAN_PERSEDIAAN'"));
      $modulPersediaan = $getModulPersediaan['nilai'];
      switch ($fileName) {
        case 'pemusnahanPersediaan':{
          $header =
             "<table width='100%' class='menubar' cellpadding='0' cellspacing='0' border='0' style='margin:0 0 0 0'>
            <tr><td class='menudottedline' width='40%' height='20' style='text-align:right'><B>
            <A href='pages.php?Pg=pemusnahanPersediaan' title='PEMUSNAHAN' style='color : blue;' > PEMUSNAHAN </a> |
            <A href='pages.php?Pg=daftarPemusnahanPersediaan' title='DAFTAR PEMUSNAHAN '  > DAFTAR PEMUSNAHAN </a>
            &nbsp&nbsp
            </td></tr>
            </table>";
          break;
        }
        case 'daftarPemusnahanPersediaan':{
          $header =
             "<table width='100%' class='menubar' cellpadding='0' cellspacing='0' border='0' style='margin:0 0 0 0'>
            <tr><td class='menudottedline' width='40%' height='20' style='text-align:right'><B>
            <A href='pages.php?Pg=pemusnahanPersediaan' title='PEMUSNAHAN'  > PEMUSNAHAN </a> |
            <A href='pages.php?Pg=daftarPemusnahanPersediaan' title='DAFTAR PEMUSNAHAN ' style='color : blue;'  > DAFTAR PEMUSNAHAN </a>
            &nbsp&nbsp
            </td></tr>
            </table>";
          break;
        }


      }

      return $header;
    }

    function cmbQuery($name='txtField', $value='', $query='', $param='', $Atas='Pilih', $vAtas='') {
        global $Ref;
        $Input = "<option value='$vAtas'>$Atas</option>";
        $Query = sqlQuery($query);
        while ($Hasil = mysqli_fetch_row($Query)) {
            $Hasil2 = array_map('utf8_encode', $Hasil);
            $Sel = $Hasil2[0] == $value ? "selected" : "";
            $Input .= "<option $Sel value='{$Hasil2[0]}'>{$Hasil2[1]}";
        }
        $Input = "<select $param name='$name' id='$name'>$Input</select>";
        return $Input;
    }
    function getSetting(){
        $dataPengaturan = sqlArray(sqlQuery("select * from setting"));
        return $dataPengaturan;
    }
    function loadCSS(){
      return "
			<script src='js/jquery.fixedTableHeader.js'></script>
      <script src='js/fixedHeader.js'></script>
		";
    }
    function textBox($arrayOption){
      if(!isset($arrayOption['class'])){
        $className = "form-control";
      }else{
        $className = $arrayOption['class'];
      }
      return "<input type='text' name='".$arrayOption['id']."' id = '".$arrayOption['id']."' value='".$arrayOption['value']."' class='$className' ".$arrayOption['params']." >";
    }
    function textArea($arrayOption){
      if(!isset($arrayOption['class'])){
        $className = "form-control";
      }else{
        $className = $arrayOption['class'];
      }
      return "<textarea  name='".$arrayOption['id']."' id = '".$arrayOption['id']."' class='$className' ".$arrayOption['params']." >".$arrayOption['value']."</textarea>";
    }
    function numberText($arrayOption){
      if(!isset($arrayOption['class'])){
        $className = "form-control";
      }else{
        $className = $arrayOption['class'];
      }
      return "<input type='text' name='".$arrayOption['id']."' id = '".$arrayOption['id']."' value='".$arrayOption['value']."' class='$className' ".$arrayOption['params']." onkeypress='return event.charCode >= 48 && event.charCode <= 57' onkeyup=$this->Prefix.numberMark(this); >";
    }
    function button($arrayOption){
      if(!isset($arrayOption['class'])){
        $className = "form-control";
      }else{
        $className = $arrayOption['class'];
      }
      return "<input type='button' name='".$arrayOption['id']."' id = '".$arrayOption['id']."' value='".$arrayOption['value']."' class='$className' ".$arrayOption['params']." >";
    }
    function genFormKB($withForm=TRUE, $params=NULL, $center=TRUE){
  		$form_name = $this->Prefix.'_KBform';

  		if($withForm){
  			$form= "<form name='$form_name' id='$form_name' method='post' action=''>".
  				createDialog(
  					$form_name.'_div',
  					$this->setForm_content(),
  					$this->form_width,
  					$this->form_height,
  					$this->form_caption,
  					'',
  					$this->form_menubawah.
  					"<input type='hidden' id='".$this->Prefix."_idplh' name='".$this->Prefix."_idplh' value='$this->form_idplh' >
  					<input type='hidden' id='".$this->Prefix."_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >",
  					$this->form_menu_bawah_height,'',$params).
  				"</form>";

  		}else{
  			$form=
  				createDialog(
  					$form_name.'_div',
  					$this->setForm_content(),
  					$this->form_width,
  					$this->form_height,
  					$this->form_caption,
  					'',
  					$this->form_menubawah.
  					"<input type='hidden' id='".$this->Prefix."_idplh' name='".$this->Prefix."_idplh' value='$this->form_idplh' >
  					<input type='hidden' id='".$this->Prefix."_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >",
  					$this->form_menu_bawah_height,'',$params
  				);
  		}

  		if($center){
  			$form = centerPage( $form );
  		}
  		return $form;
  	}

    function removeDot($angka){
      $angka = str_replace(".","",$angka);
      return $angka;
    }
    function filterSaldo($Prefix){
      foreach ($_REQUEST as $key => $value) {
   			$$key = $value;
   		}
      $arrayJenisSaldo = array(
        array('1',"BANK"),
        array('2',"KAS")
      );
      if(empty($filterJenisTransaksi)){
        if($_COOKIE['coJenisTransaksi'] =='1'){
          $queryBankKas = "select id, nama_bank from ref_bank where 1=1 $this->allowIdBank";
          $filterBankKas = $_COOKIE['coIdBank'];
          $filterJenisTransaksi =1;
        }elseif($_COOKIE['coJenisTransaksi'] =='2'){
          $queryBankKas = "select id, nama_kas from ref_kas where 1=1 $this->allowIdKas";
          $filterJenisTransaksi =2;
          $filterBankKas = $_COOKIE['coIdKas'];
        }
      }else{
        if($filterJenisTransaksi == '1'){
          $queryBankKas = "select id, nama_bank from ref_bank where 1=1 $this->allowIdBank";
        }else{
          $queryBankKas = "select id, nama_kas from ref_kas where 1=1 $this->allowIdKas";
        }
        if(!empty($filterJenisTransaksi)){
    			setCookie("coJenisTransaksi",$filterJenisTransaksi);
    			if($filterJenisTransaksi == '1'){
    				if(!empty($filterBankKas)){
    					$arrKondisi[] = "id_bank = '$filterBankKas'";
    					setCookie("coIdBank",$filterBankKas);
    				}
    			}else{
    				if(!empty($filterBankKas)){
    					setCookie("coIdKas",$filterBankKas);
    				}
    			}
    		}
      }
      if(!empty($this->oneJenisTransaksi)){
        if($this->oneJenisTransaksi == 1){
          $filterJenisTransaksi = 1;
          $queryBankKas = "select id, nama_bank from ref_bank where 1=1 $this->allowIdBank";
          $filterBankKas = $this->oneIdBank;
        }else{
          $filterJenisTransaksi = 2;
          $queryBankKas = "select id, nama_kas from ref_kas where 1=1 $this->allowIdKas";
          $filterBankKas = $this->oneIdKas;
        }
      }
      $genDaftar = "<tr>
        <td>JENIS TRANSAKSI </td>
        <td>:</td>
        <td style='width:86%;'>
          ".cmbArray("filterJenisTransaksi",$filterJenisTransaksi,$arrayJenisSaldo,"-- JENIS TRANSAKSI --" , "onchange=$Prefix.refreshList(true)")."
        </td>
      </tr>
      <tr>
        <td>NAMA BANK / KAS </td>
        <td>:</td>
        <td style='width:86%;'>
          ".cmbQuery("filterBankKas",$filterBankKas,$queryBankKas, "onchange=$Prefix.refreshList(true)","-- NAMA BANK / KAS --" )."
        </td>
      </tr>";
      return $genDaftar;
    }

    function filterSaldoMiring($Prefix){
      foreach ($_REQUEST as $key => $value) {
        $$key = $value;
      }
      $arrayJenisSaldo = array(
        array('1',"BANK"),
        array('2',"KAS")
      );
      if(empty($filterJenisTransaksi) && !isset($_REQUEST['filterJenisTransaksi'])){
        if($_COOKIE['coJenisTransaksi'] =='1'){
          $queryBankKas = "select id, nama_bank from ref_bank where 1=1 $this->allowIdBank";
          $filterBankKas = $_COOKIE['coIdBank'];
          $filterJenisTransaksi =1;
        }elseif($_COOKIE['coJenisTransaksi'] =='2'){
          $queryBankKas = "select id, nama_kas from ref_kas where 1=1 $this->allowIdKas";
          $filterJenisTransaksi =2;
          $filterBankKas = $_COOKIE['coIdKas'];
        }
      }else{
        if($filterJenisTransaksi == '1'){
          $queryBankKas = "select id, nama_bank from ref_bank where 1=1 $this->allowIdBank";
        }else{
          $queryBankKas = "select id, nama_kas from ref_kas where 1=1 $this->allowIdKas";
        }
        if(!empty($filterJenisTransaksi)){
          setCookie("coJenisTransaksi",$filterJenisTransaksi);
          if($filterJenisTransaksi == '1'){
            if(!empty($filterBankKas)){
              $arrKondisi[] = "id_bank = '$filterBankKas'";
              setCookie("coIdBank",$filterBankKas);
            }
          }else{
            if(!empty($filterBankKas)){
              setCookie("coIdKas",$filterBankKas);
            }
          }
        }
      }
      if(!empty($this->oneJenisTransaksi)){
        if($this->oneJenisTransaksi == 1){
          $filterJenisTransaksi = 1;
          $queryBankKas = "select id, nama_bank from ref_bank where 1=1 $this->allowIdBank";
          $filterBankKas = $this->oneIdBank;
        }else{
          $filterJenisTransaksi = 2;
          $queryBankKas = "select id, nama_kas from ref_kas where 1=1 $this->allowIdKas";
          $filterBankKas = $this->oneIdKas;
        }
      }


      $genDaftar = " <span style='color:black;'>BANK / KAS : &nbsp</span>
          ".cmbArray("filterJenisTransaksi",$filterJenisTransaksi,$arrayJenisSaldo,"-- BANK / KAS --" , "onchange=$Prefix.filterJenisSaldoChanged() ")."&nbsp

          <span style='color:black;'>&nbsp&nbsp NAMA BANK / KAS : &nbsp</span> ".cmbQuery("filterBankKas",$filterBankKas,$queryBankKas, "onchange=$Prefix.filterBankKasChanged()  ","-- NAMA BANK / KAS --" )." &nbsp
          <span style='color:black;'>&nbsp&nbsp SALDO : &nbsp <span  id='spanFilterSaldo'>".$this->getSisaSaldo($filterJenisTransaksi,$filterBankKas)."</span> </span>
        ";
      return $genDaftar;
    }
    function getSisaSaldo($jenisTransaksi,$idBankKas){
      if($jenisTransaksi == '1'){
        $getDataBukuUmum = sqlQuery("select * from buku_umum where id_bank ='$idBankKas' and year(tanggal) = '$this->tahunAnggaran' order by tanggal asc, kredit desc, id asc ");
      }elseif($jenisTransaksi == '2'){
        $getDataBukuUmum = sqlQuery("select * from buku_umum where id_kas ='$idBankKas' and year(tanggal) = '$this->tahunAnggaran' order by tanggal asc, kredit desc, id asc ");
      }
      while ($dataBukuUmum = sqlArray($getDataBukuUmum)) {
        $totalKreditSaldo += $dataBukuUmum['kredit'];
        $totalDebitSaldo += $dataBukuUmum['debit'];
      }
      if(empty($idBankKas)){
        $totalKreditSaldo = 0;
        $totalDebitSaldo = 0;
      }
      return $this->numberFormat($totalKreditSaldo - $totalDebitSaldo,2);

    }
    function hiddenInputJenisSaldo(){
      foreach ($_REQUEST as $key => $value) {
   			 $$key = $value;
   		 }
       $spanJenisTransaksi .= "<input type='hidden' name='jenisTransaksi' id='jenisTransaksi' value='$filterJenisTransaksi' >";
       if($_REQUEST['filterJenisTransaksi'] == '1'){
    		 $spanJenisTransaksi .= "<input type='hidden' name='idBank' id='idBank' value='$filterBankKas' >";
    	 }elseif($_REQUEST['filterJenisTransaksi'] == '2'){
    		 $spanJenisTransaksi .= "<input type='hidden' name='idKas' id='idKas' value='$filterBankKas' >";
    	 }
       return $spanJenisTransaksi;
    }
    function checkFilter(){
      foreach ($_REQUEST as $key => $value) {
   			 $$key = $value;
 		  }
      $err = "";
      if(empty($filterJenisTransaksi)){
        $err = "Pilih Bank / Kas";
      }elseif(empty($filterBankKas)){
        $err = "Pilih Nama Bank / Kas";
      }
      return $err;
    }


}


?>
