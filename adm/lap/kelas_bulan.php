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
$filenya = "kelas_bulan.php";
$judul = "Per Kelas Bulan";
$judulku = "[LAPORAN]. $judul";
$judulx = $judul;
$tapel = cegah($_REQUEST['tapel']);
$tapel2 = balikin($_REQUEST['tapel']);
$kelas = cegah($_REQUEST['kelas']);
$kelas2 = balikin($_REQUEST['kelas']);

$ke = "$filenya?tapel=$tapel&kelas=$kelas";



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
	$kelas2 = balikin($_POST['kelas']);
	$kelas = cegah($_POST['kelas']);
	$fileku = "lap_per_kelas-bulan-$tapel2-$kelas2.xls";


	$nilku = explode("xgmringx", $tapel);
	$nilku1 = trim($nilku[0]);
	$nilku2 = trim($nilku[1]);


	
	//isi *START
	ob_start();
	

	

	echo '<div class="table-responsive">
	<h3>LAPORAN PER KELAS BULAN, '.$tapel2.'. '.$kelas2.'</h3>';
         


	//daftar 
	$qbt = mysqli_query($koneksi, "SELECT * FROM m_siswa ".
										"WHERE tapel = '$tapel' ".
										"AND kelas = '$kelas' ".
										"ORDER BY nama ASC");
	$rowbt = mysqli_fetch_assoc($qbt);
	$tbt = mysqli_num_rows($qbt);


		//ketahui update terakhir
		$qyuk = mysqli_query($koneksi, "SELECT * FROM siswa_bayar ".
											"WHERE tapel = '$tapel' ".
											"AND kelas = '$kelas' ".
											"ORDER BY postdate DESC");
		$ryuk = mysqli_fetch_assoc($qyuk);
		$yuk_postdate = balikin($ryuk['postdate']);
	




		$xtapelku = explode("xgmringx", $tapel);
		$xtapel1 = trim($xtapelku[0]);
		$xtapel2 = trim($xtapelku[1]);
		
	
	
		echo '<table class="table" border="1">
		<thead>
		<tr bgcolor="'.$warnaheader.'">
		<td width="5" valign="top"><strong><font color="'.$warnatext.'">NIS</font></strong></td>
		<td width="200" valign="top"><strong><font color="'.$warnatext.'">NAMA</font></strong></td>
		<td width="100" valign="top"><strong><font color="'.$warnatext.'">KETERANGAN</font></strong></td>';
		
		//list bulan
		for ($k=1;$k<=12;$k++)
			{
			//jika ganjil
			if ($k <= 6)
				{
				$kk = $k + 6;
				$ktahun = $xtapel1;
				}
				
			//jika genap
			else if ($k >= 6)
				{
				$kk = $k - 6;
				$ktahun = $xtapel2;
				}
			
			
			echo '<td valign="top" align="center">
			<font color="'.$warnatext.'">
			<strong>'.$arrbln2[$kk].' '.$ktahun.'</strong>
			</font>
			</td>';
			}
		
		
		echo '<td width="100" valign="top" bgcolor="orange"><strong><font color="'.$warnatext.'">TOTAL</font></strong></td>
		</tr>
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
			$btnis = balikin($rowbt['nis']);
			$btnama = balikin($rowbt['nama']);
	
	
	
			//list jenis
			$qku = mysqli_query($koneksi, "SELECT * FROM m_cara_bayar ".
											"ORDER BY nama ASC LIMIT 0,1");
			$rku = mysqli_fetch_assoc($qku);
			$ku_nama = balikin($rku['nama']);
			$ku_nama2 = cegah($rku['nama']);
	
			
	
				
	
			
			
			
			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna01';\">";
			echo '<td align="center" valign="top">'.$btnis.'.</td>
			<td valign="top">'.$btnama.'</td>
			<td valign="top"><b>'.$ku_nama.'</b></td>';
				
			//list bulan
			for ($k=1;$k<=12;$k++)
				{
				//jika ganjil
				if ($k <= 6)
					{
					$kk = $k + 6;
					$ktahun = $xtapel1;
					}
					
				//jika genap
				else if ($k >= 6)
					{
					$kk = $k - 6;
					$ktahun = $xtapel2;
					}

				
				//ketahui nilainya
				$qku21 = mysqli_query($koneksi, "SELECT SUM(nilai) AS totalnya ".
												"FROM siswa_bayar ".
												"WHERE siswa_kd = '$btkd' ".
												"AND tapel = '$tapel' ".
												"AND kelas = '$kelas' ".
												"AND jenis = '$ku_nama2' ".
												"AND round(DATE_FORMAT(tgl_bayar, '%m')) = '$kk' ".
												"AND round(DATE_FORMAT(tgl_bayar, '%Y')) = '$ktahun'");
				$rku21 = mysqli_fetch_assoc($qku21);
				$tku21 = mysqli_num_rows($qku21);
				$ku21_nilai = nosql($rku21['totalnya']);
		
		
				//jika null
				if (empty($ku21_nilai))
					{
					$ku21_nilaix = "-";	
					}
				else
					{
					$ku21_nilaix = xduit3($ku21_nilai);
					}
				
				
				
				echo '<td valign="top" align="right">
				<font color="black">
				'.$ku21_nilaix.'
				</font>
				</td>';
				}

				
			//ketahui nilainya
			$qku21 = mysqli_query($koneksi, "SELECT SUM(nilai) AS totalnya ".
											"FROM siswa_bayar ".
											"WHERE siswa_kd = '$btkd' ".
											"AND tapel = '$tapel' ".
											"AND kelas = '$kelas' ".
											"AND jenis = '$ku_nama2'");
			$rku21 = mysqli_fetch_assoc($qku21);
			$tku21 = mysqli_num_rows($qku21);
			$ku21_nilai = nosql($rku21['totalnya']);
	
	
			//jika null
			if (empty($ku21_nilai))
				{
				$ku21_nilaix = "-";	
				}
			else
				{
				$ku21_nilaix = xduit3($ku21_nilai);
				}
						
			echo '<td valign="top" align="right"><b>'.$ku21_nilaix.'</b></td>
			</tr>';
			
			
			
			
			
			//list jenis
			$qku = mysqli_query($koneksi, "SELECT * FROM m_cara_bayar ".
											"ORDER BY nama ASC LIMIT 1,10");
			$rku = mysqli_fetch_assoc($qku);
	
			do
				{
				//nilai
				$ku_nama = balikin($rku['nama']);
				$ku_nama2 = cegah($rku['nama']);
	

				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna01';\">";
				echo '<td align="center" valign="top">&nbsp;</td>
				<td valign="top">&nbsp;</td>
				<td valign="top"><b>'.$ku_nama.'</b></td>';
					
				//list bulan
				for ($k=1;$k<=12;$k++)
					{
					//jika ganjil
					if ($k <= 6)
						{
						$kk = $k + 6;
						$ktahun = $xtapel1;
						}
						
					//jika genap
					else if ($k >= 6)
						{
						$kk = $k - 6;
						$ktahun = $xtapel2;
						}
	
					
					//ketahui nilainya
					$qku21 = mysqli_query($koneksi, "SELECT SUM(nilai) AS totalnya ".
													"FROM siswa_bayar ".
													"WHERE siswa_kd = '$btkd' ".
													"AND tapel = '$tapel' ".
													"AND kelas = '$kelas' ".
													"AND jenis = '$ku_nama2' ".
													"AND round(DATE_FORMAT(tgl_bayar, '%m')) = '$kk' ".
													"AND round(DATE_FORMAT(tgl_bayar, '%Y')) = '$ktahun'");
					$rku21 = mysqli_fetch_assoc($qku21);
					$tku21 = mysqli_num_rows($qku21);
					$ku21_nilai = nosql($rku21['totalnya']);
			
					

					//jika null
					if (empty($ku21_nilai))
						{
						$ku21_nilaix = "-";	
						}
					else
						{
						$ku21_nilaix = xduit3($ku21_nilai);
						}
					
					
					
					echo '<td valign="top" align="right">
					<font color="black">
					'.$ku21_nilaix.'
					</font>
					</td>';
					}


				//ketahui nilainya
				$qku21 = mysqli_query($koneksi, "SELECT SUM(nilai) AS totalnya ".
												"FROM siswa_bayar ".
												"WHERE siswa_kd = '$btkd' ".
												"AND tapel = '$tapel' ".
												"AND kelas = '$kelas' ".
												"AND jenis = '$ku_nama2'");
				$rku21 = mysqli_fetch_assoc($qku21);
				$tku21 = mysqli_num_rows($qku21);
				$ku21_nilai = nosql($rku21['totalnya']);
		
		
				//jika null
				if (empty($ku21_nilai))
					{
					$ku21_nilaix = "-";	
					}
				else
					{
					$ku21_nilaix = xduit3($ku21_nilai);
					}
				
				echo '<td valign="top" align="right"><b>'.$ku21_nilaix.'</b></td>
				</tr>';
			
				}
			while ($rku = mysqli_fetch_assoc($qku));
			
			
			
			
			


			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna01';\">";
			echo '<td align="center" valign="top">&nbsp;</td>
			<td valign="top">&nbsp;</td>
			<td valign="top" bgcolor="orange"><b>TOTAL</b></td>';
				
			//list bulan
			for ($k=1;$k<=12;$k++)
				{					//jika ganjil
				if ($k <= 6)
					{
					$kk = $k + 6;
					$ktahun = $xtapel1;
					}
					
				//jika genap
				else if ($k >= 6)
					{
					$kk = $k - 6;
					$ktahun = $xtapel2;
					}

				
				//ketahui nilainya
				$qku21 = mysqli_query($koneksi, "SELECT SUM(nilai) AS totalnya ".
												"FROM siswa_bayar ".
												"WHERE siswa_kd = '$btkd' ".
												"AND tapel = '$tapel' ".
												"AND kelas = '$kelas' ".
												"AND round(DATE_FORMAT(tgl_bayar, '%m')) = '$kk' ".
												"AND round(DATE_FORMAT(tgl_bayar, '%Y')) = '$ktahun'");
				$rku21 = mysqli_fetch_assoc($qku21);
				$tku21 = mysqli_num_rows($qku21);
				$ku21_nilai = nosql($rku21['totalnya']);
		
				

				//jika null
				if (empty($ku21_nilai))
					{
					$ku21_nilaix = "-";	
					}
				else
					{
					$ku21_nilaix = xduit3($ku21_nilai);
					}
				
				
				
				echo '<td valign="top" align="right" bgcolor="orange">
				<font color="black">
				<b>'.$ku21_nilaix.'</b>
				</font>
				</td>';
				}
			
			
			
			//ketahui nilainya
			$qku21 = mysqli_query($koneksi, "SELECT SUM(nilai) AS totalnya ".
											"FROM siswa_bayar ".
											"WHERE siswa_kd = '$btkd' ".
											"AND tapel = '$tapel' ".
											"AND kelas = '$kelas'");
			$rku21 = mysqli_fetch_assoc($qku21);
			$tku21 = mysqli_num_rows($qku21);
			$ku21_nilai = nosql($rku21['totalnya']);
	
	
			//jika null
			if (empty($ku21_nilai))
				{
				$ku21_nilaix = "-";	
				}
			else
				{
				$ku21_nilaix = xduit3($ku21_nilai);
				}
		
			
			echo '<td valign="top" bgcolor="orange" align="right"><b>'.$ku21_nilaix.'</b></td>
			</tr>';
			}
		while ($rowbt = mysqli_fetch_assoc($qbt));
	
		echo '<tr bgcolor="'.$warnaheader.'">
		<td width="5" valign="top"><strong><font color="'.$warnatext.'"></font></strong></td>
		<td valign="top"><strong><font color="'.$warnatext.'"></font></strong></td>
		<td valign="top"><strong><font color="'.$warnatext.'"></font></strong></td>';
		

		//list bulan
		for ($k=1;$k<=12;$k++)
			{
			if ($k <= 6)
				{
				$kk = $k + 6;
				$ktahun = $xtapel1;
				}
				
			//jika genap
			else if ($k >= 6)
				{
				$kk = $k - 6;
				$ktahun = $xtapel2;
				}

			
			//ketahui nilainya
			$qku21 = mysqli_query($koneksi, "SELECT SUM(nilai) AS totalnya ".
											"FROM siswa_bayar ".
											"WHERE tapel = '$tapel' ".
											"AND kelas = '$kelas' ".
											"AND round(DATE_FORMAT(tgl_bayar, '%m')) = '$kk' ".
											"AND round(DATE_FORMAT(tgl_bayar, '%Y')) = '$ktahun'");
			$rku21 = mysqli_fetch_assoc($qku21);
			$tku21 = mysqli_num_rows($qku21);
			$ku21_nilai = nosql($rku21['totalnya']);
	
			

			//jika null
			if (empty($ku21_nilai))
				{
				$ku21_nilaix = "-";	
				}
			else
				{
				$ku21_nilaix = xduit3($ku21_nilai);
				}
			
			
			
			echo '<td valign="top" align="right">
			<font color="'.$warnatext.'">
			<strong>'.$ku21_nilaix.'</strong>
			</font>
			</td>';
			}




		//ketahui nilainya
		$qku21 = mysqli_query($koneksi, "SELECT SUM(nilai) AS totalnya ".
										"FROM siswa_bayar ".
										"WHERE tapel = '$tapel' ".
										"AND kelas = '$kelas'");
		$rku21 = mysqli_fetch_assoc($qku21);
		$tku21 = mysqli_num_rows($qku21);
		$ku21_nilai = nosql($rku21['totalnya']);

		

		//jika null
		if (empty($ku21_nilai))
			{
			$ku21_nilaix = "-";	
			}
		else
			{
			$ku21_nilaix = xduit3($ku21_nilai);
			}
		
		
				
		
		echo '<td valign="top" align="right"><strong><font color="'.$warnatext.'">'.$ku21_nilaix.'</font></strong></td>
		</tr>
		
		
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

echo '</select>,

Kelas : ';
echo "<select name=\"kelas\" class=\"btn btn-warning\" onChange=\"MM_jumpMenu('self',this,0)\">";
echo '<option value="'.$kelas.'" selected>'.$kelas2.'</option>';

//tapel
$qdt = mysqli_query($koneksi, "SELECT DISTINCT(kelas) FROM m_siswa ".
								"ORDER BY kelas ASC");
$rdt = mysqli_fetch_assoc($qdt);
$tdt = mysqli_num_rows($qdt);

do
	{
	$dt_kd = nosql($rdt['kd']);
	$dt_tahun1 = balikin($rdt['kelas']);
	$dt_tahun2 = cegah($rdt['kelas']); 

	echo '<option value="'.$filenya.'?tapel='.$tapel.'&kelas='.$dt_tahun1.'">'.$dt_tahun2.'</option>';
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
	
else if (empty($kelas))
	{
	echo '<p>
	<font color="#FF0000"><strong>KELAS Belum Dipilih...!</strong></font>
	</p>';
	}
else
	{
	//daftar 
	$qbt = mysqli_query($koneksi, "SELECT * FROM m_siswa ".
										"WHERE tapel = '$tapel' ".
										"AND kelas = '$kelas' ".
										"ORDER BY nama ASC");
	$rowbt = mysqli_fetch_assoc($qbt);
	$tbt = mysqli_num_rows($qbt);

	
	//jika ada
	if (!empty($tbt))
		{
		//ketahui update terakhir
		$qyuk = mysqli_query($koneksi, "SELECT * FROM siswa_bayar ".
											"WHERE tapel = '$tapel' ".
											"AND kelas = '$kelas' ".
											"ORDER BY postdate DESC");
		$ryuk = mysqli_fetch_assoc($qyuk);
		$yuk_postdate = balikin($ryuk['postdate']);
	




		$xtapelku = explode("xgmringx", $tapel);
		$xtapel1 = trim($xtapelku[0]);
		$xtapel2 = trim($xtapelku[1]);
		
	
	
		echo '<input name="tapel" type="hidden" value="'.$tapel.'">
		<input name="kelas" type="hidden" value="'.$kelas.'">
		
		<input name="btnEX" type="submit" value="Cetak EXCEL" class="btn btn-danger">
			
		<div class="table-responsive">          
		<table class="table" border="1">
		<thead>
		<tr bgcolor="'.$warnaheader.'">
		<td width="5" valign="top"><strong><font color="'.$warnatext.'">NIS</font></strong></td>
		<td width="200" valign="top"><strong><font color="'.$warnatext.'">NAMA</font></strong></td>
		<td width="100" valign="top"><strong><font color="'.$warnatext.'">KETERANGAN</font></strong></td>';
		
		//list bulan
		for ($k=1;$k<=12;$k++)
			{
			//jika ganjil
			if ($k <= 6)
				{
				$kk = $k + 6;
				$ktahun = $xtapel1;
				}
				
			//jika genap
			else if ($k >= 6)
				{
				$kk = $k - 6;
				$ktahun = $xtapel2;
				}
			
			
			echo '<td valign="top" align="center">
			<font color="'.$warnatext.'">
			<strong>'.$arrbln2[$kk].' '.$ktahun.'</strong>
			</font>
			</td>';
			}
		
		
		echo '<td width="100" valign="top" bgcolor="orange"><strong><font color="'.$warnatext.'">TOTAL</font></strong></td>
		</tr>
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
			$btnis = balikin($rowbt['nis']);
			$btnama = balikin($rowbt['nama']);
	
	
	
			//list jenis
			$qku = mysqli_query($koneksi, "SELECT * FROM m_cara_bayar ".
											"ORDER BY nama ASC LIMIT 0,1");
			$rku = mysqli_fetch_assoc($qku);
			$ku_nama = balikin($rku['nama']);
			$ku_nama2 = cegah($rku['nama']);
	
			
	
				
	
			
			
			
			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna01';\">";
			echo '<td align="center" valign="top">'.$btnis.'.</td>
			<td valign="top">'.$btnama.'</td>
			<td valign="top"><b>'.$ku_nama.'</b></td>';
				
			//list bulan
			for ($k=1;$k<=12;$k++)
				{
				//jika ganjil
				if ($k <= 6)
					{
					$kk = $k + 6;
					$ktahun = $xtapel1;
					}
					
				//jika genap
				else if ($k >= 6)
					{
					$kk = $k - 6;
					$ktahun = $xtapel2;
					}

				
				//ketahui nilainya
				$qku21 = mysqli_query($koneksi, "SELECT SUM(nilai) AS totalnya ".
												"FROM siswa_bayar ".
												"WHERE siswa_kd = '$btkd' ".
												"AND tapel = '$tapel' ".
												"AND kelas = '$kelas' ".
												"AND jenis = '$ku_nama2' ".
												"AND round(DATE_FORMAT(tgl_bayar, '%m')) = '$kk' ".
												"AND round(DATE_FORMAT(tgl_bayar, '%Y')) = '$ktahun'");
				$rku21 = mysqli_fetch_assoc($qku21);
				$tku21 = mysqli_num_rows($qku21);
				$ku21_nilai = nosql($rku21['totalnya']);
		
		
				//jika null
				if (empty($ku21_nilai))
					{
					$ku21_nilaix = "-";	
					}
				else
					{
					$ku21_nilaix = xduit3($ku21_nilai);
					}
				
				
				
				echo '<td valign="top" align="right">
				<font color="black">
				'.$ku21_nilaix.'
				</font>
				</td>';
				}

				
			//ketahui nilainya
			$qku21 = mysqli_query($koneksi, "SELECT SUM(nilai) AS totalnya ".
											"FROM siswa_bayar ".
											"WHERE siswa_kd = '$btkd' ".
											"AND tapel = '$tapel' ".
											"AND kelas = '$kelas' ".
											"AND jenis = '$ku_nama2'");
			$rku21 = mysqli_fetch_assoc($qku21);
			$tku21 = mysqli_num_rows($qku21);
			$ku21_nilai = nosql($rku21['totalnya']);
	
	
			//jika null
			if (empty($ku21_nilai))
				{
				$ku21_nilaix = "-";	
				}
			else
				{
				$ku21_nilaix = xduit3($ku21_nilai);
				}
						
			echo '<td valign="top" align="right"><b>'.$ku21_nilaix.'</b></td>
			</tr>';
			
			
			
			
			
			//list jenis
			$qku = mysqli_query($koneksi, "SELECT * FROM m_cara_bayar ".
											"ORDER BY nama ASC LIMIT 1,10");
			$rku = mysqli_fetch_assoc($qku);
	
			do
				{
				//nilai
				$ku_nama = balikin($rku['nama']);
				$ku_nama2 = cegah($rku['nama']);
	

				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna01';\">";
				echo '<td align="center" valign="top">&nbsp;</td>
				<td valign="top">&nbsp;</td>
				<td valign="top"><b>'.$ku_nama.'</b></td>';
					
				//list bulan
				for ($k=1;$k<=12;$k++)
					{
					//jika ganjil
					if ($k <= 6)
						{
						$kk = $k + 6;
						$ktahun = $xtapel1;
						}
						
					//jika genap
					else if ($k >= 6)
						{
						$kk = $k - 6;
						$ktahun = $xtapel2;
						}
	
					
					//ketahui nilainya
					$qku21 = mysqli_query($koneksi, "SELECT SUM(nilai) AS totalnya ".
													"FROM siswa_bayar ".
													"WHERE siswa_kd = '$btkd' ".
													"AND tapel = '$tapel' ".
													"AND kelas = '$kelas' ".
													"AND jenis = '$ku_nama2' ".
													"AND round(DATE_FORMAT(tgl_bayar, '%m')) = '$kk' ".
													"AND round(DATE_FORMAT(tgl_bayar, '%Y')) = '$ktahun'");
					$rku21 = mysqli_fetch_assoc($qku21);
					$tku21 = mysqli_num_rows($qku21);
					$ku21_nilai = nosql($rku21['totalnya']);
			
					

					//jika null
					if (empty($ku21_nilai))
						{
						$ku21_nilaix = "-";	
						}
					else
						{
						$ku21_nilaix = xduit3($ku21_nilai);
						}
					
					
					
					echo '<td valign="top" align="right">
					<font color="black">
					'.$ku21_nilaix.'
					</font>
					</td>';
					}


				//ketahui nilainya
				$qku21 = mysqli_query($koneksi, "SELECT SUM(nilai) AS totalnya ".
												"FROM siswa_bayar ".
												"WHERE siswa_kd = '$btkd' ".
												"AND tapel = '$tapel' ".
												"AND kelas = '$kelas' ".
												"AND jenis = '$ku_nama2'");
				$rku21 = mysqli_fetch_assoc($qku21);
				$tku21 = mysqli_num_rows($qku21);
				$ku21_nilai = nosql($rku21['totalnya']);
		
		
				//jika null
				if (empty($ku21_nilai))
					{
					$ku21_nilaix = "-";	
					}
				else
					{
					$ku21_nilaix = xduit3($ku21_nilai);
					}
				
				echo '<td valign="top" align="right"><b>'.$ku21_nilaix.'</b></td>
				</tr>';
			
				}
			while ($rku = mysqli_fetch_assoc($qku));
			
			
			
			
			


			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna01';\">";
			echo '<td align="center" valign="top">&nbsp;</td>
			<td valign="top">&nbsp;</td>
			<td valign="top" bgcolor="orange"><b>TOTAL</b></td>';
				
			//list bulan
			for ($k=1;$k<=12;$k++)
				{					//jika ganjil
				if ($k <= 6)
					{
					$kk = $k + 6;
					$ktahun = $xtapel1;
					}
					
				//jika genap
				else if ($k >= 6)
					{
					$kk = $k - 6;
					$ktahun = $xtapel2;
					}

				
				//ketahui nilainya
				$qku21 = mysqli_query($koneksi, "SELECT SUM(nilai) AS totalnya ".
												"FROM siswa_bayar ".
												"WHERE siswa_kd = '$btkd' ".
												"AND tapel = '$tapel' ".
												"AND kelas = '$kelas' ".
												"AND round(DATE_FORMAT(tgl_bayar, '%m')) = '$kk' ".
												"AND round(DATE_FORMAT(tgl_bayar, '%Y')) = '$ktahun'");
				$rku21 = mysqli_fetch_assoc($qku21);
				$tku21 = mysqli_num_rows($qku21);
				$ku21_nilai = nosql($rku21['totalnya']);
		
				

				//jika null
				if (empty($ku21_nilai))
					{
					$ku21_nilaix = "-";	
					}
				else
					{
					$ku21_nilaix = xduit3($ku21_nilai);
					}
				
				
				
				echo '<td valign="top" align="right" bgcolor="orange">
				<font color="black">
				<b>'.$ku21_nilaix.'</b>
				</font>
				</td>';
				}
			
			
			
			//ketahui nilainya
			$qku21 = mysqli_query($koneksi, "SELECT SUM(nilai) AS totalnya ".
											"FROM siswa_bayar ".
											"WHERE siswa_kd = '$btkd' ".
											"AND tapel = '$tapel' ".
											"AND kelas = '$kelas'");
			$rku21 = mysqli_fetch_assoc($qku21);
			$tku21 = mysqli_num_rows($qku21);
			$ku21_nilai = nosql($rku21['totalnya']);
	
	
			//jika null
			if (empty($ku21_nilai))
				{
				$ku21_nilaix = "-";	
				}
			else
				{
				$ku21_nilaix = xduit3($ku21_nilai);
				}
		
			
			echo '<td valign="top" bgcolor="orange" align="right"><b>'.$ku21_nilaix.'</b></td>
			</tr>';
			}
		while ($rowbt = mysqli_fetch_assoc($qbt));
	
		echo '<tr bgcolor="'.$warnaheader.'">
		<td width="5" valign="top"><strong><font color="'.$warnatext.'"></font></strong></td>
		<td valign="top"><strong><font color="'.$warnatext.'"></font></strong></td>
		<td valign="top"><strong><font color="'.$warnatext.'"></font></strong></td>';
		

		//list bulan
		for ($k=1;$k<=12;$k++)
			{
			if ($k <= 6)
				{
				$kk = $k + 6;
				$ktahun = $xtapel1;
				}
				
			//jika genap
			else if ($k >= 6)
				{
				$kk = $k - 6;
				$ktahun = $xtapel2;
				}

			
			//ketahui nilainya
			$qku21 = mysqli_query($koneksi, "SELECT SUM(nilai) AS totalnya ".
											"FROM siswa_bayar ".
											"WHERE tapel = '$tapel' ".
											"AND kelas = '$kelas' ".
											"AND round(DATE_FORMAT(tgl_bayar, '%m')) = '$kk' ".
											"AND round(DATE_FORMAT(tgl_bayar, '%Y')) = '$ktahun'");
			$rku21 = mysqli_fetch_assoc($qku21);
			$tku21 = mysqli_num_rows($qku21);
			$ku21_nilai = nosql($rku21['totalnya']);
	
			

			//jika null
			if (empty($ku21_nilai))
				{
				$ku21_nilaix = "-";	
				}
			else
				{
				$ku21_nilaix = xduit3($ku21_nilai);
				}
			
			
			
			echo '<td valign="top" align="right">
			<font color="'.$warnatext.'">
			<strong>'.$ku21_nilaix.'</strong>
			</font>
			</td>';
			}




		//ketahui nilainya
		$qku21 = mysqli_query($koneksi, "SELECT SUM(nilai) AS totalnya ".
										"FROM siswa_bayar ".
										"WHERE tapel = '$tapel' ".
										"AND kelas = '$kelas'");
		$rku21 = mysqli_fetch_assoc($qku21);
		$tku21 = mysqli_num_rows($qku21);
		$ku21_nilai = nosql($rku21['totalnya']);

		

		//jika null
		if (empty($ku21_nilai))
			{
			$ku21_nilaix = "-";	
			}
		else
			{
			$ku21_nilaix = xduit3($ku21_nilai);
			}
		
		
				
		
		echo '<td valign="top" align="right"><strong><font color="'.$warnatext.'">'.$ku21_nilaix.'</font></strong></td>
		</tr>
		
		
		</tbody>
		</table>
		
		
		
		
		</div>
	
		<input name="tapel" type="hidden" value="'.$tapel.'">
		<input name="tapel2" type="hidden" value="'.$tapel2.'">';
		}


	else
		{
		echo '<font color="red">
		<h3>Belum Ada Daftar SISWA...</h3>
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