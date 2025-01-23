<?php
session_start();

//fungsi - fungsi
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/adm.php");
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/adm.html");


nocache;

//nilai
$filenya = "cara_bayar.php";
$judul = "Per Cara Bayar";
$judulku = "[LAPORAN]. $judul";
$judulx = $judul;
$tapel = cegah($_REQUEST['tapel']);
$tapel2 = balikin($_REQUEST['tapel']);

$ke = "$filenya?tapel=$tapel";




$nilku = explode("xgmringx", $tapel);
$nilku1 = trim($nilku[0]);
$nilku2 = trim($nilku[1]);





//focus...
if (empty($tapel))
	{
	$diload = "document.formx.tapel.focus();";
	}





//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//nek excel
if ($_POST['btnEX'])
	{
	//nilai
	$tapel2 = balikin($_POST['tapel']);
	$tapel = cegah($_POST['tapel']);
	$fileku = "lap_per_cara_bayar-$tapel2.xls";


	$nilku = explode("xgmringx", $tapel);
	$nilku1 = trim($nilku[0]);
	$nilku2 = trim($nilku[1]);


	
	//isi *START
	ob_start();
	

	//daftar kelas
	$qbt = mysqli_query($koneksi, "SELECT DISTINCT(kelas) AS kelasnya ".
										"FROM m_siswa ".
										"WHERE tapel = '$tapel' ".
										"ORDER BY kelas ASC");
	$rowbt = mysqli_fetch_assoc($qbt);
	$tbt = mysqli_num_rows($qbt);

	

	echo '<div class="table-responsive">
	<h3>LAPORAN PER CARA BAYAR, '.$tapel2.'</h3>
         
		<table class="table" border="1">
		<thead>
		<tr bgcolor="'.$warnaheader.'">
		<td width="5" valign="top"><strong>NO</strong></td>
		<td valign="top"><strong>KELAS</strong></td>';
		
		//list jenis
		$qku = mysqli_query($koneksi, "SELECT * FROM m_uang_jenis ".
										"ORDER BY nama ASC");
		$rku = mysqli_fetch_assoc($qku);

		do
			{
			//nilai
			$ku_nama = balikin($rku['nama']);
	
			echo '<td valign="top" width="200" align="center"><strong>'.$ku_nama.'</strong></td>';
			}
		while ($rku = mysqli_fetch_assoc($qku));
		
		
		echo '</tr>
		</thead>
		<tbody>';
	
	
		do
			{
			//nilai
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
	
			$btno = $btno + 1;
			$btkd = nosql($rowbt['kd']);
			$btnis = balikin($rowbt['kelasnya']);
			$btnis2 = cegah($rowbt['kelasnya']);
	
	
			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna01';\">";
			echo '<td align="center" valign="top">'.$btno.'.</td>
			<td valign="top">'.$btnis.'</td>';
			
			
			//list jenis
			$qku = mysqli_query($koneksi, "SELECT * FROM m_uang_jenis ".
											"ORDER BY nama ASC");
			$rku = mysqli_fetch_assoc($qku);
	
			do
				{
				//nilai
				$ku_kd = balikin($rku['kd']);
				$ku_nama = balikin($rku['nama']);
				$ku_nama2 = cegah($rku['nama']);
	
	
				//cek nilai 
				$qku21 = mysqli_query($koneksi, "SELECT SUM(nilai) AS totalnya ".
												"FROM siswa_bayar ".
												"WHERE tapel = '$tapel' ".
												"AND kelas = '$btnis2' ".
												"AND cara_bayar = '$ku_nama2'");
				$rku21 = mysqli_fetch_assoc($qku21);
				$tku21 = mysqli_num_rows($qku21);
				$ku21_nilai = nosql($rku21['totalnya']);
	


	
				//ketahui total siswa
				$qku1 = mysqli_query($koneksi, "SELECT DISTINCT(siswa_nis) AS total ".
												"FROM siswa_bayar ".
												"WHERE tapel = '$tapel' ".
												"AND kelas = '$btnis2' ".
												"AND cara_bayar = '$ku_nama2'");
				$rku1 = mysqli_fetch_assoc($qku1);
				$ku1_total = mysqli_num_rows($qku1);
				
				
			
			
				
				echo '<td valign="top" align="right">
				<b>'.$ku1_total.'</b> SISWA.
				<br>
				
				'.xduit3($ku21_nilai).'
				</td>';
				}
			while ($rku = mysqli_fetch_assoc($qku));
			
			
			
			echo '</tr>';
			}
		while ($rowbt = mysqli_fetch_assoc($qbt));
	
	
		
		
		//nilainya
		$qyuk31 = mysqli_query($koneksi, "SELECT SUM(nilai) AS totalnya ".
											"FROM siswa_bayar ".
											"WHERE round(DATE_FORMAT(tgl_bayar, '%Y')) = '$uthn'");
		$ryuk31 = mysqli_fetch_assoc($qyuk31);
		$yuk31_total = balikin($ryuk31['totalnya']);
		
		
		
		echo '<tr valign="top" bgcolor="'.$warnaheader.'">
		<td>&nbsp;</td>
		<td></td>';
	
	
		//list 
		$qyuk2 = mysqli_query($koneksi, "SELECT * FROM m_uang_jenis ".
											"ORDER BY nama ASC");
		$ryuk2 = mysqli_fetch_assoc($qyuk2);
		
		do
			{
			//nilai
			$yuk2_desa = balikin($ryuk2['nama']);
			$yuk2_desa2 = cegah($ryuk2['nama']);
			
			
	
			//nilainya
			$qyuk3 = mysqli_query($koneksi, "SELECT DISTINCT(siswa_nis) FROM siswa_bayar ".
												"WHERE cara_bayar = '$yuk2_desa2' ".
												"AND (round(DATE_FORMAT(tgl_bayar, '%Y')) = '$nilku1' ".
												"OR round(DATE_FORMAT(tgl_bayar, '%Y')) = '$nilku2')");
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
												"WHERE cara_bayar = '$yuk2_desa2' ".
												"AND (round(DATE_FORMAT(tgl_bayar, '%Y')) = '$nilku1' OR round(DATE_FORMAT(tgl_bayar, '%Y')) = '$nilku2')");
			$ryuk31 = mysqli_fetch_assoc($qyuk31);
			$yuk31_total = balikin($ryuk31['totalnya']);
			
				
			
			echo '<td align="right">
			<strong><font color="'.$warnatext.'">'.$tyuk3x.'</font></strong> SISWA
			<br>
			<strong><font color="'.$warnatext.'">'.xduit3($yuk31_total).'</font></strong> 
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



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////






//isi *START
ob_start();

//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
require("../../inc/js/checkall.js");
require("../../inc/js/number.js");


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" action="'.$filenya.'">
Tahun Pelajaran : ';
echo "<select name=\"tapel\" class=\"btn btn-warning\" onChange=\"MM_jumpMenu('self',this,0)\">";
echo '<option value="'.$tapel.'" selected>'.$tapel2.'</option>';

//tapel
$qdt = mysqli_query($koneksi, "SELECT * FROM m_tapel ".
								"ORDER BY tahun1 ASC");
$rdt = mysqli_fetch_assoc($qdt);
$tdt = mysqli_num_rows($qdt);

do
	{
	$dt_kd = nosql($rdt['kd']);
	$dt_tahun1 = balikin($rdt['tahun1']);
	$dt_tahun2 = balikin($rdt['tahun2']);
	$dt_tapel = cegah("$dt_tahun1/$dt_tahun2");
	$dt_tapel2 = balikin("$dt_tahun1/$dt_tahun2"); 

	echo '<option value="'.$filenya.'?tapel='.$dt_tapel.'">'.$dt_tapel2.'</option>';
	}
while ($rdt = mysqli_fetch_assoc($qdt));

echo '</select>
<hr>';


//nek blm dipilih
if (empty($tapel))
	{
	echo '<p>
	<font color="#FF0000"><strong>TAHUN PELAJARAN Belum Dipilih...!</strong></font>
	</p>';
	}
else
	{
	//daftar kelas
	$qbt = mysqli_query($koneksi, "SELECT DISTINCT(kelas) AS kelasnya ".
										"FROM m_siswa ".
										"WHERE tapel = '$tapel' ".
										"ORDER BY kelas ASC");
	$rowbt = mysqli_fetch_assoc($qbt);
	$tbt = mysqli_num_rows($qbt);

	
	//jika ada
	if (!empty($tbt))
		{
		//ketahui update terakhir
		$qyuk = mysqli_query($koneksi, "SELECT * FROM m_uang_siswa ".
											"ORDER BY postdate DESC");
		$ryuk = mysqli_fetch_assoc($qyuk);
		$yuk_postdate = balikin($ryuk['postdate']);
	
	
	
		echo '<input name="tapel" type="hidden" value="'.$tapel.'">
	
	
		<input name="btnEX" type="submit" value="EXPORT EXCEL >>" class="btn btn-danger">
			

		<div class="table-responsive">          
		<table class="table" border="1">
		<thead>
		<tr bgcolor="'.$warnaheader.'">
		<td width="5" valign="top"><strong><font color="'.$warnatext.'">NO</font></strong></td>
		<td valign="top"><strong><font color="'.$warnatext.'">KELAS</font></strong></td>';
		
		//list jenis
		$qku = mysqli_query($koneksi, "SELECT * FROM m_uang_jenis ".
										"ORDER BY nama ASC");
		$rku = mysqli_fetch_assoc($qku);

		do
			{
			//nilai
			$ku_nama = balikin($rku['nama']);
	
			echo '<td valign="top" width="200" align="center"><strong><font color="'.$warnatext.'">'.$ku_nama.'</font></strong></td>';
			}
		while ($rku = mysqli_fetch_assoc($qku));
		
		
		echo '</tr>
		</thead>
		<tbody>';
	
	
		do
			{
			//nilai
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
	
			$btno = $btno + 1;
			$btkd = nosql($rowbt['kd']);
			$btnis = balikin($rowbt['kelasnya']);
			$btnis2 = cegah($rowbt['kelasnya']);
	
	
			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna01';\">";
			echo '<td align="center" valign="top">'.$btno.'.</td>
			<td valign="top">'.$btnis.'</td>';
			
			
			//list jenis
			$qku = mysqli_query($koneksi, "SELECT * FROM m_uang_jenis ".
											"ORDER BY nama ASC");
			$rku = mysqli_fetch_assoc($qku);
	
			do
				{
				//nilai
				$ku_kd = balikin($rku['kd']);
				$ku_nama = balikin($rku['nama']);
				$ku_nama2 = cegah($rku['nama']);
	
	
				//cek nilai 
				$qku21 = mysqli_query($koneksi, "SELECT SUM(nilai) AS totalnya ".
												"FROM siswa_bayar ".
												"WHERE tapel = '$tapel' ".
												"AND kelas = '$btnis2' ".
												"AND cara_bayar = '$ku_nama2'");
				$rku21 = mysqli_fetch_assoc($qku21);
				$tku21 = mysqli_num_rows($qku21);
				$ku21_nilai = nosql($rku21['totalnya']);
	


	
				//ketahui total siswa
				$qku1 = mysqli_query($koneksi, "SELECT DISTINCT(siswa_nis) AS total ".
												"FROM siswa_bayar ".
												"WHERE tapel = '$tapel' ".
												"AND kelas = '$btnis2' ".
												"AND cara_bayar = '$ku_nama2'");
				$rku1 = mysqli_fetch_assoc($qku1);
				$ku1_total = mysqli_num_rows($qku1);
				
				
			
			
				
				echo '<td valign="top" bgcolor="'.$warnax2.'" align="right">
				<b>'.$ku1_total.'</b> SISWA.
				<br>
				'.xduit3($ku21_nilai).'
				</td>';
				}
			while ($rku = mysqli_fetch_assoc($qku));
			
			
			
			echo '</tr>';
			}
		while ($rowbt = mysqli_fetch_assoc($qbt));
	
	
		
		
		//nilainya
		$qyuk31 = mysqli_query($koneksi, "SELECT SUM(nilai) AS totalnya ".
											"FROM siswa_bayar ".
											"WHERE round(DATE_FORMAT(tgl_bayar, '%Y')) = '$uthn'");
		$ryuk31 = mysqli_fetch_assoc($qyuk31);
		$yuk31_total = balikin($ryuk31['totalnya']);
		
		
		
		echo '<tr valign="top" bgcolor="'.$warnaheader.'">
		<td>&nbsp;</td>
		<td></td>';
	
	
		//list 
		$qyuk2 = mysqli_query($koneksi, "SELECT * FROM m_uang_jenis ".
											"ORDER BY nama ASC");
		$ryuk2 = mysqli_fetch_assoc($qyuk2);
		
		do
			{
			//nilai
			$yuk2_desa = balikin($ryuk2['nama']);
			$yuk2_desa2 = cegah($ryuk2['nama']);
			
			
	
			//nilainya
			$qyuk3 = mysqli_query($koneksi, "SELECT DISTINCT(siswa_nis) FROM siswa_bayar ".
												"WHERE cara_bayar = '$yuk2_desa2' ".
												"AND (round(DATE_FORMAT(tgl_bayar, '%Y')) = '$nilku1' ".
												"OR round(DATE_FORMAT(tgl_bayar, '%Y')) = '$nilku2')");
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
												"WHERE cara_bayar = '$yuk2_desa2' ".
												"AND (round(DATE_FORMAT(tgl_bayar, '%Y')) = '$nilku1' OR round(DATE_FORMAT(tgl_bayar, '%Y')) = '$nilku2')");
			$ryuk31 = mysqli_fetch_assoc($qyuk31);
			$yuk31_total = balikin($ryuk31['totalnya']);
			
				
			
			echo '<td align="right">
			<strong><font color="'.$warnatext.'">'.$tyuk3x.'</font></strong> SISWA
			<br>
			<strong><font color="'.$warnatext.'">'.xduit3($yuk31_total).'</font></strong> 
			</td>';
			}
		while ($ryuk2 = mysqli_fetch_assoc($qyuk2));
		
		echo '</tr>
		</tbody>
		</table>
		
		
		
		
		</div>
	
		<input name="tapel" type="hidden" value="'.$tapel.'">
		<input name="tapel2" type="hidden" value="'.$tapel2.'">';
		}


	else
		{
		echo '<font color="red">
		<h3>Belum Ada Daftar KELAS...</h3>
		</font>';
		}
	}

echo '</form>
<br>
<br>
<br>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//isi
$isi = ob_get_contents();
ob_end_clean();


require("../../inc/niltpl.php");


//diskonek
xfree($qbw);
xclose($koneksi);
exit();
?>