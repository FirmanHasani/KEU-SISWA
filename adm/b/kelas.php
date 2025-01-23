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
$filenya = "kelas.php";
$judul = "Per Kelas";
$judulku = "[PEMBAYARAN]. $judul";
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

		TOTAL : <font color="red"><b>'.$tbt.'</b></font> SISWA.
		<div class="table-responsive">          
		<table class="table" border="1">
		<thead>
		<tr bgcolor="'.$warnaheader.'">
		<td width="10" valign="top"><strong><font color="'.$warnatext.'">NO</font></strong></td>
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
		
		
		echo '<td width="100" valign="top" bgcolor="blue"><strong><font color="'.$warnatext.'">TOTAL BAYAR</font></strong></td>
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
											"ORDER BY nama ASC");
			$rku = mysqli_fetch_assoc($qku);
			
			
			do
				{
				$ku_no = $ku_no + 1;
				$ku_nama = balikin($rku['nama']);
				$ku_nama2 = cegah($rku['nama']);
	
	
				//jika awal, munculkan nama siswa
				if ($ku_no == "1")
					{
					echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna01';\">";
					echo '<td valign="top">
					<b>'.$btno.'</b>.
					</td>
					<td valign="top">
					<b>'.$btnama.'</b>
					<br>
					NIS.'.$btnis.'
					</td>
					<td valign="top"><b>'.$ku_nama.'</b></td>';
					}
				else
					{
					echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna01';\">";
					echo '<td valign="top">&nbsp;</td>
					<td valign="top">&nbsp;</td>
					<td valign="top"><b>'.$ku_nama.'</b></td>';
					}

				
				
					
					
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
						
						
					$xyz = md5("$btkd$k$kk$ktahun$ku_nama2");
	
					
					
									
					//total bayar
					$qku21 = mysqli_query($koneksi, "SELECT SUM(nilai) AS totalnya ".
														"FROM siswa_bayar ".
														"WHERE siswa_nis = '$btnis' ".
														"AND tapel = '$tapel' ".
														"AND kelas = '$kelas' ".
														"AND jenis = '$ku_nama2' ".
														"AND round(DATE_FORMAT(tgl_bayar, '%m')) = '$kk' ".
														"AND round(DATE_FORMAT(tgl_bayar, '%Y')) = '$ktahun'");
					$rku21 = mysqli_fetch_assoc($qku21);
					$tku21 = mysqli_num_rows($qku21);
					$ku21_nilai = nosql($rku21['totalnya']);

						
					
								
					
					echo '<td valign="top" align="right">
					<font color="black">
					'.xduit3($ku21_nilai).'
					</font>
					</td>';
					}

					

	
	
	
				//ketahui totalnya
				$qku21 = mysqli_query($koneksi, "SELECT SUM(nilai) AS totalnya ".
													"FROM siswa_bayar ".
													"WHERE siswa_nis = '$btnis' ".
													"AND tapel = '$tapel' ".
													"AND kelas = '$kelas' ".
													"AND jenis = '$ku_nama2'");
				$rku21 = mysqli_fetch_assoc($qku21);
				$tku21 = mysqli_num_rows($qku21);
				$ku21_nilai1 = nosql($rku21['totalnya']);
		
		
	
		

	

					
				echo '<td valign="top" align="right"><b>'.xduit3($ku21_nilai1).'</b></td>
				</tr>';
				}
			while ($rku = mysqli_fetch_assoc($qku));
			
			
			




			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna01';\">";
			echo '<td valign="top">&nbsp;</td>
			<td valign="top">&nbsp;</td>
			<td valign="top" bgcolor="orange"><b>TOTAL BAYAR</b></td>';
				
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
													"WHERE siswa_nis = '$btnis' ".
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
				<br>
				
				<a href="bayar.php?s=entri&swkd='.$btkd.'&swnama='.$btnama.'&swnis='.$btnis.'&swtapel='.$tapel.'&swkelas='.$kelas.'&ubln='.$kk.'" class="btn btn-danger">BAYAR >></a>
				</td>';
				}
			
			
			
			

			//ketahui nilainya
			$qku21 = mysqli_query($koneksi, "SELECT SUM(nilai) AS totalnya ".
												"FROM siswa_bayar ".
												"WHERE siswa_nis = '$btnis' ".
												"AND tapel = '$tapel' ".
												"AND kelas = '$kelas'");
			$rku21 = mysqli_fetch_assoc($qku21);
			$tku21 = mysqli_num_rows($qku21);
			$ku21_nilai1 = nosql($rku21['totalnya']);
	
	
	



				
							
			echo '<td valign="top" bgcolor="orange" align="right"><b>'.xduit3($ku21_nilai1).'</b></td>
			</tr>';
			
			
			
				
				
				
			//netralkan
			$ku_no = 0;
			}
		while ($rowbt = mysqli_fetch_assoc($qbt));
	
	
	


		//cek
		$qku214 = mysqli_query($koneksi, "SELECT SUM(nilai) AS totalnya ".
											"FROM siswa_bayar ".
											"WHERE tapel = '$tapel' ".
											"AND kelas = '$kelas'");
		$rku214 = mysqli_fetch_assoc($qku214);
		$ku214_nilai = nosql($rku214['totalnya']);
		
		//jika null
		if (empty($ku214_nilai))
			{
			$ku214_nilai = 0;
			}
						




	
	
		echo '<tr bgcolor="'.$warnaheader.'">
		<td valign="top"><strong><font color="'.$warnatext.'"></font></strong></td>
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
				$ku21_nilaix = "0";	
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






		//saat ini
		$qku214 = mysqli_query($koneksi, "SELECT SUM(belum_bayar) AS totalnya ".
											"FROM siswa_tagihan_tapel ".
											"WHERE tapel = '$tapel' ".
											"AND kelas = '$kelas'");
		$rku214 = mysqli_fetch_assoc($qku214);
		$ku214_nilai2 = nosql($rku214['totalnya']);
		
		//jika null
		if (empty($ku214_nilai2))
			{
			$ku214_nilai2 = 0;
			}
		else
			{
			$ku214_nilai2 = xduit3($ku214_nilai2);
			}





		//saat ini
		$qku214 = mysqli_query($koneksi, "SELECT SUM(nilai) AS totalnya ".
											"FROM siswa_bayar ".
											"WHERE tapel = '$tapel' ".
											"AND kelas = '$kelas'");
		$rku214 = mysqli_fetch_assoc($qku214);
		$ku214_nilai21 = nosql($rku214['totalnya']);
		
		//jika null
		if (empty($ku214_nilai21))
			{
			$ku214_nilai21 = 0;
			}
		else
			{
			$ku214_nilai21 = xduit3($ku214_nilai21);
			}





				
		
		echo '<td valign="top" bgcolor="cyan" align="right"><strong><font color="black">'.$ku214_nilai21.'</font></strong></td>
		</tr>
		
		
		</tbody>
		</table>
		
		
		
		
		</div>
	
		<input name="tapel" type="hidden" value="'.$tapel.'">
		<input name="tapel2" type="hidden" value="'.$tapel2.'">
		<input name="kelas" type="hidden" value="'.$kelas.'">';
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