<?php
session_start();

require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/adm.php");
$tpl = LoadTpl("../../template/adm.html");

nocache;

//nilai
$filenya = "tgl.php";
$judul = "Per Tanggal";
$judul = "[LAPORAN]. Per Tanggal";
$judulku = "$judul";
$judulx = $judul;
$ubln = nosql($_REQUEST['ubln']);
$uthn = nosql($_REQUEST['uthn']);

$s = nosql($_REQUEST['s']);
$kunci = cegah($_REQUEST['kunci']);
$kunci2 = balikin($_REQUEST['kunci']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}


//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//nek excel
if ($_POST['btnEX'])
	{
	//nilai
	$ubln = balikin($_POST['ubln']);
	$uthn = balikin($_POST['uthn']);
	$fileku = "lap_per_tanggal-$ubln-$uthn.xls";



	
	//isi *START
	ob_start();
	

	$month = round($ubln);
	$year = round($uthn);
	
	//tanggal terakhir  
	$days_in_month = date('t',mktime(0,0,0,$month,1,$year));
		
	
	echo '<div class="table-responsive">
	<h3>LAPORAN PER TANGGAL, '.$arrbln[$ubln].' '.$uthn.'</h3>
	

	<table class="table" border="1">
	<thead>
	
	<tr valign="top" bgcolor="'.$warnaheader.'">
	<td width="100"><strong><font color="'.$warnatext.'">TANGGAL</font></strong></td>
	<td><strong><font color="'.$warnatext.'">JUMLAH SISWA MEMBAYAR</font></strong></td>';


	//list 
	$qyuk2 = mysqli_query($koneksi, "SELECT * FROM m_cara_bayar ".
										"ORDER BY nama ASC");
	$ryuk2 = mysqli_fetch_assoc($qyuk2);
	
	do
		{
		//nilai
		$yuk2_desa = balikin($ryuk2['nama']);
		
		
		echo '<td align="center"><strong><font color="'.$warnatext.'">'.$yuk2_desa.'</font></strong></td>';
		}
	while ($ryuk2 = mysqli_fetch_assoc($qyuk2));
	
	echo '</tr>
	</thead>
	<tbody>';
	
	for ($k=1;$k<=$days_in_month;$k++) 
		{
		if ($warna_set ==0)
			{
			$warna = $warna01;
			$warna_set = 1;
			}
		else
			{
			$warna = $warna02;
			$warna_set = 0;
			}


		
		//jumlahnya
		$qku = mysqli_query($koneksi, "SELECT DISTINCT(siswa_nis) FROM siswa_bayar ".
										"WHERE round(DATE_FORMAT(tgl_bayar, '%d')) = '$k' ".
										"AND round(DATE_FORMAT(tgl_bayar, '%m')) = '$ubln' ".
										"AND round(DATE_FORMAT(tgl_bayar, '%Y')) = '$uthn'");
		$rku = mysqli_fetch_assoc($qku);
		$tku = mysqli_num_rows($qku);

		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>'.$k.'.</td>
		<td>';
		
		//jika null
		if (empty($tku))
			{
			echo '<font color="red">'.$tku.'</font>';
			}
		else
			{
			echo '<font color="green">'.$tku.'</font>';				
			}
		
		
		
		//nilainya
		$qyuk31 = mysqli_query($koneksi, "SELECT SUM(nilai) AS totalnya ".
											"FROM siswa_bayar ".
											"WHERE round(DATE_FORMAT(tgl_bayar, '%d')) = '$k' ".
											"AND round(DATE_FORMAT(tgl_bayar, '%m')) = '$ubln' ".
											"AND round(DATE_FORMAT(tgl_bayar, '%Y')) = '$uthn'");
		$ryuk31 = mysqli_fetch_assoc($qyuk31);
		$yuk31_total = balikin($ryuk31['totalnya']);
	
	
		
		
		echo ' SISWA
	
		<br>
		<b>'.xduit3($yuk31_total).'</b>
		</td>';
	
	
		//list 
		$qyuk2 = mysqli_query($koneksi, "SELECT * FROM m_cara_bayar ".
											"ORDER BY nama ASC");
		$ryuk2 = mysqli_fetch_assoc($qyuk2);
		
		do
			{
			//nilai
			$yuk2_desa = balikin($ryuk2['nama']);
			$yuk2_desa2 = cegah($ryuk2['nama']);
			
	
			//nilainya
			$qyuk3 = mysqli_query($koneksi, "SELECT DISTINCT(siswa_nis) FROM siswa_bayar ".
												"WHERE jenis = '$yuk2_desa2' ".
												"AND round(DATE_FORMAT(tgl_bayar, '%d')) = '$k' ".
												"AND round(DATE_FORMAT(tgl_bayar, '%m')) = '$ubln' ".
												"AND round(DATE_FORMAT(tgl_bayar, '%Y')) = '$uthn'");
			$tyuk3 = mysqli_num_rows($qyuk3);
			
			//jika ada
			if (!empty($tyuk3))
				{
				$tyuk3x = "<font color='green'>$tyuk3</font>";
				}
			else
				{
				$tyuk3x = "<font color='red'>$tyuk3</font>";
				}
	
	
		
			//nilainya
			$qyuk31 = mysqli_query($koneksi, "SELECT SUM(nilai) AS totalnya ".
												"FROM siswa_bayar ".
												"WHERE jenis = '$yuk2_desa2' ".
												"AND round(DATE_FORMAT(tgl_bayar, '%d')) = '$k' ".
												"AND round(DATE_FORMAT(tgl_bayar, '%m')) = '$ubln' ".
												"AND round(DATE_FORMAT(tgl_bayar, '%Y')) = '$uthn'");
			$ryuk31 = mysqli_fetch_assoc($qyuk31);
			$yuk31_total = balikin($ryuk31['totalnya']);
		
		
		
			
			echo '<td align="center">
			<strong><font color="'.$warnatext.'">'.$tyuk3x.'</font></strong> SISWA
			<br>
			<b>'.xduit3($yuk31_total).'</b>
			</td>';
			}
		while ($ryuk2 = mysqli_fetch_assoc($qyuk2));
			
						
	    echo '</tr>';
		}
	



	//nilainya
	$qyuk3 = mysqli_query($koneksi, "SELECT DISTINCT(siswa_nis) FROM siswa_bayar ".
										"WHERE round(DATE_FORMAT(tgl_bayar, '%m')) = '$ubln' ".
										"AND round(DATE_FORMAT(tgl_bayar, '%Y')) = '$uthn'");
	$tyuk3 = mysqli_num_rows($qyuk3);

	//jika ada
	if (!empty($tyuk3))
		{
		$tyuk3x = "<font color='yellow'>$tyuk3</font>";
		}
	else
		{
		$tyuk3x = $tyuk3;
		}

		

	//nilainya
	$qyuk31 = mysqli_query($koneksi, "SELECT SUM(nilai) AS totalnya ".
										"FROM siswa_bayar ".
										"WHERE round(DATE_FORMAT(tgl_bayar, '%m')) = '$ubln' ".
										"AND round(DATE_FORMAT(tgl_bayar, '%Y')) = '$uthn'");
	$ryuk31 = mysqli_fetch_assoc($qyuk31);
	$yuk31_total = balikin($ryuk31['totalnya']);


	
	
	echo '<tr valign="top" bgcolor="'.$warnaheader.'">
	<td>&nbsp;</td>
	<td>
	<font color="white">
	<strong>'.$tyuk3x.'</strong> SISWA
	<br>
	<b>'.xduit3($yuk31_total).'</b>
	</font>
	</td>';


	//list 
	$qyuk2 = mysqli_query($koneksi, "SELECT * FROM m_cara_bayar ".
										"ORDER BY nama ASC");
	$ryuk2 = mysqli_fetch_assoc($qyuk2);
	
	do
		{
		//nilai
		$yuk2_desa = balikin($ryuk2['nama']);
		$yuk2_desa2 = cegah($ryuk2['nama']);
		



		//nilainya
		$qyuk3 = mysqli_query($koneksi, "SELECT DISTINCT(siswa_nis) FROM siswa_bayar ".
											"WHERE jenis = '$yuk2_desa2' ".
											"AND round(DATE_FORMAT(tgl_bayar, '%m')) = '$ubln' ".
											"AND round(DATE_FORMAT(tgl_bayar, '%Y')) = '$uthn'");
		$tyuk3 = mysqli_num_rows($qyuk3);
	
		//jika ada
		if (!empty($tyuk3))
			{
			$tyuk3x = "<font color='yellow'>$tyuk3</font>";
			}
		else
			{
			$tyuk3x = $tyuk3;
			}
	

	
	
		
		//nilainya
		$qyuk31 = mysqli_query($koneksi, "SELECT SUM(nilai) AS totalnya ".
											"FROM siswa_bayar ".
											"WHERE jenis = '$yuk2_desa2' ".
											"AND round(DATE_FORMAT(tgl_bayar, '%m')) = '$ubln' ".
											"AND round(DATE_FORMAT(tgl_bayar, '%Y')) = '$uthn'");
		$ryuk31 = mysqli_fetch_assoc($qyuk31);
		$yuk31_total = balikin($ryuk31['totalnya']);
	


		
		echo '<td align="center">
		<font color="white">
		<strong>'.$tyuk3x.'</strong> SISWA
	
		<br>
		<b>'.xduit3($yuk31_total).'</b>
		</font>
		</td>';
		}
	while ($ryuk2 = mysqli_fetch_assoc($qyuk2));
	
	echo '</tr>
	
	
	</tbody>
	  </table>
	  </div>';



	
	//isi
	$isiku = ob_get_contents();
	ob_end_clean();


	
	
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=$fileku");
	echo $isiku;


	exit();
	}	
	
	











//nek batal
if ($_POST['btnBTL'])
	{
	//re-direct
	xloc($filenya);
	exit();
	}





/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////












//isi *START
ob_start();


//require
require("../../template/js/jumpmenu.js");
require("../../template/js/checkall.js");
require("../../template/js/swap.js");
?>
	
	
	  
  <script>
  	$(document).ready(function() {
    $('#table-responsive').dataTable( {
        "scrollX": true
    } );
} );
  </script>
  
<?php
//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


echo '<form action="'.$filenya.'" method="post" name="formx">
<div class="row">
	<div class="col-md-12">';
	

	echo "<p>
	Bulan : 
	<br>
	<select name=\"ublnx\" onChange=\"MM_jumpMenu('self',this,0)\" class=\"btn btn-warning\">";
	echo '<option value="'.$ubln.'" selected>'.$arrbln[$ubln].'</option>';
	
	for ($i=1;$i<=12;$i++)
		{
		echo '<option value="'.$filenya.'?ubln='.$i.'">'.$arrbln[$i].'</option>';
		}
				
	echo '</select>';
	


	echo "<select name=\"ublnx\" onChange=\"MM_jumpMenu('self',this,0)\" class=\"btn btn-warning\">";
	echo '<option value="'.$uthn.'" selected>'.$uthn.'</option>';
	
	for ($i=$tahun;$i<=$tahun+1;$i++)
		{
		echo '<option value="'.$filenya.'?ubln='.$ubln.'&uthn='.$i.'">'.$i.'</option>';
		}
				
	echo '</select>
	</p>		
	
	
	
	</div>
</div>

<hr>';


if (empty($ubln))
	{
	echo '<font color="red">
	<h3>BULAN Belum Dipilih...!!</h3>
	</font>';
	}


else if (empty($uthn))
	{
	echo '<font color="red">
	<h3>TAHUN Belum Dipilih...!!</h3>
	</font>';
	}
	
else
	{
	$month = round($ubln);
	$year = round($uthn);
	
	//tanggal terakhir  
	$days_in_month = date('t',mktime(0,0,0,$month,1,$year));
		
	
	echo '<input name="ubln" type="hidden" value="'.$ubln.'">
	<input name="uthn" type="hidden" value="'.$uthn.'">

	<input name="btnEX" type="submit" value="Cetak EXCEL" class="btn btn-danger">
		
	<div class="table-responsive">          
	<table class="table" border="1">
	<thead>
	
	<tr valign="top" bgcolor="'.$warnaheader.'">
	<td width="100"><strong><font color="'.$warnatext.'">TANGGAL</font></strong></td>
	<td><strong><font color="'.$warnatext.'">JUMLAH SISWA MEMBAYAR</font></strong></td>';


	//list 
	$qyuk2 = mysqli_query($koneksi, "SELECT * FROM m_cara_bayar ".
										"ORDER BY nama ASC");
	$ryuk2 = mysqli_fetch_assoc($qyuk2);
	
	do
		{
		//nilai
		$yuk2_desa = balikin($ryuk2['nama']);
		
		
		echo '<td align="center"><strong><font color="'.$warnatext.'">'.$yuk2_desa.'</font></strong></td>';
		}
	while ($ryuk2 = mysqli_fetch_assoc($qyuk2));
	
	echo '</tr>
	</thead>
	<tbody>';
	
	for ($k=1;$k<=$days_in_month;$k++) 
		{
		if ($warna_set ==0)
			{
			$warna = $warna01;
			$warna_set = 1;
			}
		else
			{
			$warna = $warna02;
			$warna_set = 0;
			}


		
		//jumlahnya
		$qku = mysqli_query($koneksi, "SELECT DISTINCT(siswa_nis) FROM siswa_bayar ".
										"WHERE round(DATE_FORMAT(tgl_bayar, '%d')) = '$k' ".
										"AND round(DATE_FORMAT(tgl_bayar, '%m')) = '$ubln' ".
										"AND round(DATE_FORMAT(tgl_bayar, '%Y')) = '$uthn'");
		$rku = mysqli_fetch_assoc($qku);
		$tku = mysqli_num_rows($qku);

		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>'.$k.'.</td>
		<td>';
		
		//jika null
		if (empty($tku))
			{
			echo '<font color="red">'.$tku.'</font>';
			}
		else
			{
			echo '<font color="green">'.$tku.'</font>';				
			}
		
		
		
		//nilainya
		$qyuk31 = mysqli_query($koneksi, "SELECT SUM(nilai) AS totalnya ".
											"FROM siswa_bayar ".
											"WHERE round(DATE_FORMAT(tgl_bayar, '%d')) = '$k' ".
											"AND round(DATE_FORMAT(tgl_bayar, '%m')) = '$ubln' ".
											"AND round(DATE_FORMAT(tgl_bayar, '%Y')) = '$uthn'");
		$ryuk31 = mysqli_fetch_assoc($qyuk31);
		$yuk31_total = balikin($ryuk31['totalnya']);
	
	
		
		
		echo ' SISWA
	
		<br>
		<b>'.xduit3($yuk31_total).'</b>
		</td>';
	
	
		//list 
		$qyuk2 = mysqli_query($koneksi, "SELECT * FROM m_cara_bayar ".
											"ORDER BY nama ASC");
		$ryuk2 = mysqli_fetch_assoc($qyuk2);
		
		do
			{
			//nilai
			$yuk2_desa = balikin($ryuk2['nama']);
			$yuk2_desa2 = cegah($ryuk2['nama']);
			
	
			//nilainya
			$qyuk3 = mysqli_query($koneksi, "SELECT DISTINCT(siswa_nis) FROM siswa_bayar ".
												"WHERE jenis = '$yuk2_desa2' ".
												"AND round(DATE_FORMAT(tgl_bayar, '%d')) = '$k' ".
												"AND round(DATE_FORMAT(tgl_bayar, '%m')) = '$ubln' ".
												"AND round(DATE_FORMAT(tgl_bayar, '%Y')) = '$uthn'");
			$tyuk3 = mysqli_num_rows($qyuk3);
			
			//jika ada
			if (!empty($tyuk3))
				{
				$tyuk3x = "<font color='green'>$tyuk3</font>";
				}
			else
				{
				$tyuk3x = "<font color='red'>$tyuk3</font>";
				}
	
	
		
			//nilainya
			$qyuk31 = mysqli_query($koneksi, "SELECT SUM(nilai) AS totalnya ".
												"FROM siswa_bayar ".
												"WHERE jenis = '$yuk2_desa2' ".
												"AND round(DATE_FORMAT(tgl_bayar, '%d')) = '$k' ".
												"AND round(DATE_FORMAT(tgl_bayar, '%m')) = '$ubln' ".
												"AND round(DATE_FORMAT(tgl_bayar, '%Y')) = '$uthn'");
			$ryuk31 = mysqli_fetch_assoc($qyuk31);
			$yuk31_total = balikin($ryuk31['totalnya']);
		
		
		
			
			echo '<td align="center">
			<strong><font color="'.$warnatext.'">'.$tyuk3x.'</font></strong> SISWA
			<br>
			<b>'.xduit3($yuk31_total).'</b>
			</td>';
			}
		while ($ryuk2 = mysqli_fetch_assoc($qyuk2));
			
						
	    echo '</tr>';
		}
	



	//nilainya
	$qyuk3 = mysqli_query($koneksi, "SELECT DISTINCT(siswa_nis) FROM siswa_bayar ".
										"WHERE round(DATE_FORMAT(tgl_bayar, '%m')) = '$ubln' ".
										"AND round(DATE_FORMAT(tgl_bayar, '%Y')) = '$uthn'");
	$tyuk3 = mysqli_num_rows($qyuk3);

	//jika ada
	if (!empty($tyuk3))
		{
		$tyuk3x = "<font color='yellow'>$tyuk3</font>";
		}
	else
		{
		$tyuk3x = $tyuk3;
		}

		

	//nilainya
	$qyuk31 = mysqli_query($koneksi, "SELECT SUM(nilai) AS totalnya ".
										"FROM siswa_bayar ".
										"WHERE round(DATE_FORMAT(tgl_bayar, '%m')) = '$ubln' ".
										"AND round(DATE_FORMAT(tgl_bayar, '%Y')) = '$uthn'");
	$ryuk31 = mysqli_fetch_assoc($qyuk31);
	$yuk31_total = balikin($ryuk31['totalnya']);


	
	
	echo '<tr valign="top" bgcolor="'.$warnaheader.'">
	<td>&nbsp;</td>
	<td>
	<font color="white">
	<strong>'.$tyuk3x.'</strong> SISWA
	<br>
	<b>'.xduit3($yuk31_total).'</b>
	</font>
	</td>';


	//list 
	$qyuk2 = mysqli_query($koneksi, "SELECT * FROM m_cara_bayar ".
										"ORDER BY nama ASC");
	$ryuk2 = mysqli_fetch_assoc($qyuk2);
	
	do
		{
		//nilai
		$yuk2_desa = balikin($ryuk2['nama']);
		$yuk2_desa2 = cegah($ryuk2['nama']);
		



		//nilainya
		$qyuk3 = mysqli_query($koneksi, "SELECT DISTINCT(siswa_nis) FROM siswa_bayar ".
											"WHERE jenis = '$yuk2_desa2' ".
											"AND round(DATE_FORMAT(tgl_bayar, '%m')) = '$ubln' ".
											"AND round(DATE_FORMAT(tgl_bayar, '%Y')) = '$uthn'");
		$tyuk3 = mysqli_num_rows($qyuk3);
	
		//jika ada
		if (!empty($tyuk3))
			{
			$tyuk3x = "<font color='yellow'>$tyuk3</font>";
			}
		else
			{
			$tyuk3x = $tyuk3;
			}
	

	
	
		
		//nilainya
		$qyuk31 = mysqli_query($koneksi, "SELECT SUM(nilai) AS totalnya ".
											"FROM siswa_bayar ".
											"WHERE jenis = '$yuk2_desa2' ".
											"AND round(DATE_FORMAT(tgl_bayar, '%m')) = '$ubln' ".
											"AND round(DATE_FORMAT(tgl_bayar, '%Y')) = '$uthn'");
		$ryuk31 = mysqli_fetch_assoc($qyuk31);
		$yuk31_total = balikin($ryuk31['totalnya']);
	


		
		echo '<td align="center">
		<font color="white">
		<strong>'.$tyuk3x.'</strong> SISWA
	
		<br>
		<b>'.xduit3($yuk31_total).'</b>
		</font>
		</td>';
		}
	while ($ryuk2 = mysqli_fetch_assoc($qyuk2));
	
	echo '</tr>
	
	
	</tbody>
	  </table>
	  </div>';

	}


echo '</form>';



//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../inc/niltpl.php");


//null-kan
xclose($koneksi);
exit();
?>