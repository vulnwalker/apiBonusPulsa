<?phpinclude("common/vars.php"); include("config.php"); $qry= sqlQuery('select * from v_double2 limit 500');//$list='';while ($row= sqlArray($qry) ){	//$list.='<tr><td>'.$row['id'].'</td></tr>';	//echo $row['id'];	$bhapus='';	$qry2= sqlQuery('select * from buku_induk where id='.$row['id']);	while($row2 = sqlArray($qry2)){		switch($row2['f']){			case '01': $kib = 'kib_a';			case '02': $kib = 'kib_b';			case '03': $kib = 'kib_c';			case '04': $kib = 'kib_d';			case '05': $kib = 'kib_e';			case '06': $kib = 'kib_f';		}				$qry3= sqlQuery(			'select * from '.$kib.' where concat(a,b,c,d,e,f,g,h,i,j) = "'.			$row2['a'].$row2['b'].$row2['c'].$row2['d'].$row2['e'].$row2['f'].$row2['g'].			$row2['h'].$row2['i'].$row2['j'].'"'			);		if (sqlNumRow($qry3) == 0){			$bhapus = $row2['b'];		} 			}	sqlQuery('delete from buku_induk where id = '.$row['id'].' and b="'.$bhapus.'"');			}echo 'selesai';?>