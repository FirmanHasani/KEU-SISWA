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
$filenya = "set_siswa.php";
$judul = "Set MAX Uang SISWA Per Tahun Pelajaran";
$judulku = "[SISWA]. $judul";
$judulx = $judul;
$tapel = cegah($_REQUEST['tapel']);
$tapel2 = balikin($_REQUEST['tapel']);

$ke = "$filenya?tapel=$tapel";





//focus...
if (empty($tapel))
	{
	$diload = "document.formx.tapel.focus();";
	}





//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$tapel = cegah($_POST['tapel']);
	$tapel2 = cegah($_POST['tapel2']);


	//daftar kelas
	$qccx = mysqli_query($koneksi, "SELECT DISTINCT(kelas) AS kelasnya ".
										"FROM m_siswa ".
										"WHERE tapel = '$tapel' ".
										"ORDER BY kelas ASC");
	$rccx = mysqli_fetch_assoc($qccx);
	$tccx = mysqli_num_rows($qccx);

	do
		{
		//nilai
		$nomer = $nomer + 1;
		$ccx_nis = cegah($rccx['kelasnya']);



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
	
	
			
			//ambil nilai
			$xyz = md5("$x$nomer$ku_kd");
		
		
			$xnkomite = "nilku";
			$xnkomite1 = "$nomer$xnkomite$ku_kd";
			$xnkomitexx = nosql($_POST["$xnkomite1"]);
	
	
	
			//cek
			$qcc = mysqli_query($koneksi, "SELECT * FROM m_uang_siswa ".
												"WHERE tapel = '$tapel' ".
												"AND kelas = '$ccx_nis' ".
												"AND jenis = '$ku_nama2'");
			$rcc = mysqli_fetch_assoc($qcc);
			$tcc = mysqli_num_rows($qcc);
	
			//nek ada
			if (!empty($tcc))
				{
				///update
				mysqli_query($koneksi, "UPDATE m_uang_siswa SET nilai = '$xnkomitexx' ".
											"WHERE tapel = '$tapel' ".
											"AND kelas = '$ccx_nis' ".
											"AND jenis = '$ku_nama2'");
				}
			else
				{
				//baru
				mysqli_query($koneksi, "INSERT INTO m_uang_siswa (kd, tapel, kelas, ".
											"jenis, nilai, postdate) VALUES ".
											"('$xyz', '$tapel', '$ccx_nis', ".
											"'$ku_nama2', '$xnkomitexx', '$today')");
				}
				
				


			}
		while ($rku = mysqli_fetch_assoc($qku));


					
			
			
			
		}
	while ($rccx = mysqli_fetch_assoc($qccx));





	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	$ke = "$filenya?tapel=$tapel";
	xloc($ke);
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
<table bgcolor="'.$warnaover.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Tahun Pelajaran : ';
echo "<select name=\"tapel\" onChange=\"MM_jumpMenu('self',this,0)\">";
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
</td>
</tr>
</table>';


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
	
	
	
		echo '<br>
		[Update Terakhir : <b>'.$yuk_postdate.'</b>]. 
		
		<table width="100%" border="1" cellpadding="3" cellspacing="0">
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
		
		
		echo '</tr>';
	
	
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
				$qku21 = mysqli_query($koneksi, "SELECT * FROM m_uang_siswa ".
												"WHERE tapel = '$tapel' ".
												"AND kelas = '$btnis2' ".
												"AND jenis = '$ku_nama2'");
				$rku21 = mysqli_fetch_assoc($qku21);
				$tku21 = mysqli_num_rows($qku21);
				$ku21_nilai = nosql($rku21['nilai']);
	

				
				echo '<td valign="top" bgcolor="'.$warnax2.'" align="right">
				Rp.	<input name="'.$btno.'nilku'.$ku_kd.'" type="text" size="10" value="'.$ku21_nilai.'" style="text-align:right" onKeyPress="return numbersonly(this, event)">,-
				</td>';
				}
			while ($rku = mysqli_fetch_assoc($qku));
			
			
			
			echo '</tr>';
			}
		while ($rowbt = mysqli_fetch_assoc($qbt));
	
		echo '</table>
	
		<input name="tapel" type="hidden" value="'.$tapel.'">
		<input name="tapel2" type="hidden" value="'.$tapel2.'">
		<input name="btnSMP" type="submit" class="btn btn-danger" value="SIMPAN">
		<input name="btnBTL" type="submit" class="btn btn-primary" value="BATAL">';
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