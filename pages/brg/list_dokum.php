<?phpset_time_limit(0);$Act = $_POST["Act"];$byId = $_GET[ "byId" ]; //echo "<br>sidBI=$idBI";Dok_Page($byId);$Page_Content = "	<script>		function ket_resize(){			var sp = document.getElementById('span_dok_ket');						sp.style.width=getBrowserWidth() *0.7 ;		}		function body_onload(){			ket_resize();		}		function body_onresize(){			ket_resize();					}	</script>	<form action='' method='post' name='adminForm' id='adminForm' enctype='multipart/form-data'>	$dok_page	</form>	";echo"<html><head><title>$Main->Judul</title>$Main->HeadScript<script language='JavaScript' type='text/javascript'>	function body_onload(){	}	function body_onclick(){}	function body_onresize(){}</script>$Main->HeadStyle</head><body style='' onload='body_onload()' onclick='body_onclick()' onresize='body_onresize()'>$Page_Content</body></html>";/*//Form Entry upload -------------------------------$FormUpload = "		<input type='hidden' name='nmFile'  value='$nmFile'>		<table class ='' style=''>			<tr>			<td ><b>File</b></td>					<td ><input type='file' id='selFile' name='uploadedfile'  value='Ganti' onchange='' onclick='' style='opacity:0.9' size='56' />	</td>		</tr>		<tr valign='top'>			<td > <b>Keterangan</b>	</td>					<td ><textarea name='fmKET' cols='64' style='overflow-y:scroll;overflow:-moz-scrollbars-vertical;height:50'></textarea></td>					</tr>				<tr>			<td colspan='2' align='right'> 							<div style='float:right'>				<input type='button' id='btsimpan' name='btsimpan'  value='Simpan' onclick='uploadFile()'  /> 				<input type='button' id='btbatal' name='btbatal'  value='Batal' onclick='closeEntry()'  /> 				</div>				<div style='float:right;padding:5 5 0 0'>					<img src='$imgLoadSrc' id=$idImgLoad style='visibility:hidden;display: block; vertical-align: middle; margin-left: auto;  margin-right: auto'> 				</div>			</td>					</tr>	</table>		";$EntryKet = "	<table>			<tr valign='top'><td id='EntryKet_File' colspan=2></td></tr>			<tr valign='top'>			<td><b>Keterangan</b></td>			<td><textarea id='fmKET2' name='fmKET2' cols='64' style='overflow-y:scroll;overflow:-moz-scrollbars-vertical;height:50'></textarea></td>		</tr>		<tr ><td colspan=2>			<div style='float:right'>			<input type='button' id='btSimpanKet' name='btSimpanKet'  value='Simpan' onclick='simpanEntryKet()'  /> 			<input type='button' id='btBatalKet' name='btBatalKet'  value='Batal' onclick='closeEntryKet()'  /> 			</div>					</td></tr>	</table>	";//dokumen list --------------------------------------//$Hal = cekPOST("Hal",1);//$LimitHal = " limit ".(($Hal*1) - 1) * $Main->PagePerHal.",".$Main->PagePerHal;$Kondisi = " where idbi = $idBI";Dokumen_GetList();if ($viewHeadTblNo){ 	$tableHeader = ""; }else{ 		//$tableHeader = "	//	<table id='tblHeadDok' border='1' class='koptable' style='border-width:0; width :100%' >	//	$tableHeader 	//	</table>	//";}$tablewidth = $embed==1? '583px':'100%';$tampilList= "	<table id='tblListDok' border='1' class='koptable' style='border-width:0; width :$tablewidth' >		$tableHeader 		$listTable		$listHalaman	</table>	";	$menuwidth = $embed==1? '573px':'';$tampilMenu = 	"<!--<div id='menuku' style='height:18;padding:0;background-color: black; 	    border-color: black; border-style: solid; border-width: 2px;'>-->	<div id='menuh' style='width:$menuwidth'>	<ul>	<li><a class='dok_btdel' title='Hapus Dokumen' onclick='prosesHapus()'></a></li>	<li><a class='dok_btedit' title='Edit Dokumen' onclick='showEntryKet()'></a>		<ul id='ulEntryKet'>			<li >				".setBackTransparan( setCenterPage(setShadowForm2( FormContainer($EntryKet))), "onclick='closeEntryKet()'" )."							</li>		</ul>	</li>	<li ><a class='dok_btadd' title='Tambah Dokumen' onclick='showEntry()'></a>		<ul id='ulFormEntry'>			<li >											". setBackTransparan( setCenterPage(setShadowForm2( FormContainer($FormUpload) )), "onclick='closeEntry()'" )."							</li>		</ul>	</li>	</ul>	<a title='Jumlah Dokumen' style='cursor:default;position:relative;left:2;top:2;color:gray;font-size:11;'>[ $jmlData ]</a>	</div>	";//javascript -----------------------------------if(empty($viewHeadTblNo)){	$scriptGetCel = "var cel = document.getElementById('tblListDok').rows[i+1].cells;";	}else{	$scriptGetCel = "var cel = document.getElementById('tblListDok').rows[i].cells;";}	$scriptUpload = "	<script type='text/javascript'>				function body_onload(){	//alert('tes2');		}		function body_onclick(){//alert('tes3');		}		function uploadFile(){	//alert(document.getElementById('selFile').value);								if (document.getElementById('selFile').value != ''){								document.getElementById('".$idImgLoad."').style.visibility= 'visible';				document.adminForm.Act.value=1;				document.adminForm.submit();			}		}		function showEntry(){//alert('tes');			document.body.style.overflow='hidden';			document.getElementById('ulFormEntry').style.visibility='visible';		}		function closeEntry(){						document.body.style.overflow='auto';			document.getElementById('ulFormEntry').style.visibility='hidden';		}		function simpanEntryKet(){						document.adminForm.Act.value=2;			document.adminForm.submit();		}		function showEntryKet(){						var errmsg = '';			if((errmsg=='') && (adminForm.boxchecked.value >1 )){errmsg= 'Pilih Hanya Satu Data!';}			if((errmsg=='') && (adminForm.boxchecked.value == 0 )){	errmsg= 'Data belum dipilih!';}			if(errmsg ==''){								for(var i=0; i < ".$jmlData."; i++){					var str = 'document.adminForm.cb' + i; 										if (eval(str)){						box = eval( str );	//alert( i+' '+ box.value);											if( box.checked){							document.body.style.overflow='hidden';							var id = box.value;								$scriptGetCel							document.getElementById('EntryKet_File').innerHTML =  cel[1].getElementsByTagName('a')[0].innerHTML;//alert(cel[2].innerHTML);							var ket = cel[2].getElementsByTagName('pre')[0].innerHTML;							//var ket = cel[2].innerHTML;							document.getElementById('fmKET2').value = Encoder.htmlDecode(ket);							document.getElementById('ulEntryKet').style.visibility='visible';						}					}				}			}else{				alert(errmsg);			}					}		function closeEntryKet(){						document.body.style.overflow='auto';			document.getElementById('ulEntryKet').style.visibility='hidden';		}		function prosesHapus(){						if (adminForm.boxchecked.value >0 ){				if(confirm('Yakin '+adminForm.boxchecked.value+' data akan di hapus?')){										adminForm.Act.value=3;										adminForm.submit();				}			}		}	</script>";//info barang -------------------------------if (empty($viewInfoBrgNo)){	$sqry = "select * from view_buku_induk2 where id = $idBI";	$qry = sqlQuery($sqry);	$isi = sqlArray($qry);	$infoBrg = "		<table>		<tr>			<td height='60' width='100' align=center style='	background-color:#EFEFF1; background-image: url(http:images/administrator/images/blank.jpg); background-repeat-x: no-repeat;	background-repeat-y: no-repeat;	border: 2px solid #EFEFF1'>					<img src='view_img.php?fname={$isi['gambar']}&sw=80&sh=60' alt='' >			</td>			<td>				<span><b>{$isi['a1']}.{$isi['a']}.{$isi['b']}.{$isi['c']}.{$isi['d']}.{$isi['e']}  {$isi['f']}.{$isi['g']}.{$isi['h']}.{$isi['i']}.{$isi['j']} {$isi['thn_perolehan']}.{$isi['noreg']} </b></span><br>				{$isi['nmbidang']} - {$isi['nmopd']} - {$isi['nmunit']}<br>				{$isi['nm_barang']}<br>				Tahun Perolehan {$isi['thn_perolehan']}<br>				Rp. ".number_format($isi['jml_harga'],2,',','.')."			</td>			</tr>		</table>		";}//page ----------------------------------------------if (empty($viewInfoBrgNo)){ $topList= '97';}else{$topList= '26'; }$Page_Content = "	 	$scriptUpload 	<form action='' method='post' name='adminForm' id='adminForm' enctype='multipart/form-data'> 		<div id='dok_head' style='min-width:400;position:fixed; top:0; width:100%;z-index:100;background:white'>	$infoBrg	$tampilMenu				<!--$tableHeader-->	</div>		<div id='dok_body' style='position:relative;top:$topList'>		$tampilList		</div>		$hidden	<input type='hidden' name='Act' id='Act' value =''>	</form>	";*/?>