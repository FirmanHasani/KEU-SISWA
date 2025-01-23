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
$filenya = "penagihan.php";
$judul = "Per Kelas";
$judulku = "[PENAGIHAN SISWA]. $judul";
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
		$qyuk = mysqli_query($koneksi, "SELECT * FROM siswa_tagihan ".
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
		<td width="100" valign="top"><strong><font color="'.$warnatext.'">KETERANGAN</font></strong></td>
		<td valign="top"><strong><font color="'.$warnatext.'">TUNGGAKAN TAPEL SEBELUMNYA</font></strong></td>';
		
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
		
		
		echo '<td width="100" valign="top" bgcolor="orange"><strong><font color="'.$warnatext.'">TOTAL TUNGGAKAN</font></strong></td>
		<td width="100" valign="top" bgcolor="blue"><strong><font color="'.$warnatext.'">TOTAL BAYAR</font></strong></td>
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
			$btnama = balikin($rowbt['nama']);
	
	
	
	
			//update kelasnow
			mysqli_query($koneksi, "UPDATE siswa_tagihan_tapel SET kelasnow = '$kelas' ".
										"WHERE tapelnow = '$tapel' ".
										"AND siswa_nis = '$btnis'");
	
	
	
	
	
	
	
	
			//list jenis
			$qku = mysqli_query($koneksi, "SELECT * FROM m_cara_bayar ".
											"ORDER BY nama ASC LIMIT 0,1");
			$rku = mysqli_fetch_assoc($qku);
			$ku_nama = balikin($rku['nama']);
			$ku_nama2 = cegah($rku['nama']);
	
			
	
				
	
			//ketahui total tunggakan tapel sebelumnya
			$ktahun211 = $xtapel1 - 1;
			$ktahun212 = $xtapel2 - 1;
			$tapel4 = cegah("$ktahun211/$ktahun212");
			
			//cek
			$qku214 = mysqli_query($koneksi, "SELECT belum_bayar FROM siswa_tagihan_tapel ".
												"WHERE tapel = '$tapel4' ".
												"AND jenis = '$ku_nama2'");
			$rku214 = mysqli_fetch_assoc($qku214);
			$ku214_nilai = nosql($rku214['belum_bayar']);
			
			//jika null
			if (empty($ku214_nilai))
				{
				$ku214_nilai = 0;
				}
						
			
			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna01';\">";
			echo '<td valign="top"><b>'.$btno.'.</b></td>
			<td valign="top">
			'.$btnama.'
			<br>
			NIS.'.$btnis.'
			<br>
			
			<a href="../b/bayar.php?s=entri&swkd='.$btkd.'&swnama='.$btnama.'&swnis='.$btnis.'&swtapel='.$tapel.'&swkelas='.$kelas.'" class="btn btn-block btn-danger">BAYAR TAGIHAN >></a>
			
			</td>
			<td valign="top"><b>'.$ku_nama.'</b></td>
			<td valign="top" align="right"><b>'.xduit3($ku214_nilai).'</b></td>';
				
				
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


				

				//cek tagihan
				$qku21 = mysqli_query($koneksi, "SELECT * FROM siswa_tagihan ".
												"WHERE siswa_nis = '$btnis' ".
												"AND tapel = '$tapel' ".
												"AND kelas = '$kelas' ".
												"AND jenis = '$ku_nama2' ".
												"AND bulan = '$kk' ".
												"AND tahun = '$ktahun' LIMIT 0,1");
				$rku21 = mysqli_fetch_assoc($qku21);
				$tku21 = mysqli_num_rows($qku21);
				$ku21_nilai = nosql($rku21['nilai']);
				$ku21_terbayar = balikin($rku21['terbayar']);
				$ku21_terbayar_postdate = balikin($rku21['terbayar_postdate']);
		
				//jika true
				if ($ku21_terbayar == "true")
					{
					$ku21_terbayar_status = "<b><font color='green'>TERBAYAR</font>. <br>$ku21_terbayar_postdate</b>";
					}
					
				else
					{
					$ku21_terbayar_status = "<font color='orange'>Belum Bayar</font>";
					}



					


				/*		
				//jika null
				if (empty($ku21_nilai))
					{
					//ambilkan dari set nominal
					$qku22 = mysqli_query($koneksi, "SELECT * FROM m_set_nominal ".
														"WHERE tapel = '$tapel' ".
														"AND kelas = '$kelas' ".
														"AND jenis = '$ku_nama2' ".
														"AND bulan = '$kk' ".
														"AND tahun = '$ktahun'");
					$rku22 = mysqli_fetch_assoc($qku22);
					$ku22_nilai = nosql($rku22['nominal']);
					$ku21_nilaix = xduit3($ku22_nilai);
					

					//hapus dulu, trus insert
					mysqli_query($koneksi, "DELETE FROM siswa_tagihan ".
												"WHERE siswa_nis = '$btnis' ".
												"AND tapel = '$tapel' ".
												"AND kelas = '$kelas' ".
												"AND jenis = '$ku_nama2' ".
												"AND bulan = '$kk' ".
												"AND tahun = '$ktahun'");					
					
					//insert kan...
					mysqli_query($koneksi, "INSERT INTO siswa_tagihan(kd, siswa_kd, siswa_nis, siswa_nama, ".
												"tapel, kelas, jenis, ".
												"bulan, tahun, terbayar, ".
												"nilai, postdate) VALUES ".
												"('$xyz', '$btkd', '$btnis', '$btnama', ".
												"'$tapel', '$kelas', '$ku_nama2', ".
												"'$kk', '$ktahun', 'false', ".
												"'$ku22_nilai', '$today')");
					}
				else
					{
					$ku21_nilaix = xduit3($ku21_nilai);
					
					
					//hapus dulu, trus insert
					mysqli_query($koneksi, "DELETE FROM siswa_tagihan ".
												"WHERE siswa_nis = '$btnis' ".
												"AND tapel = '$tapel' ".
												"AND kelas = '$kelas' ".
												"AND jenis = '$ku_nama2' ".
												"AND bulan = '$kk' ".
												"AND tahun = '$ktahun'");					
					
					//insert kan...
					mysqli_query($koneksi, "INSERT INTO siswa_tagihan(kd, siswa_kd, siswa_nis, siswa_nama, ".
												"tapel, kelas, jenis, ".
												"bulan, tahun, terbayar, ".
												"nilai, postdate) VALUES ".
												"('$xyz', '$btkd', '$btnis', '$btnama', ".
												"'$tapel', '$kelas', '$ku_nama2', ".
												"'$kk', '$ktahun', 'false', ".
												"'$ku21_nilai', '$today')");
					
					}
				*/
				
				
			
				echo '<td valign="top" align="right">
				<font color="black">
				'.$ku21_nilaix.'
				</font>
				
				'.$ku21_terbayar_status.'
				</td>';
				}
				
				
				
			//ketahui nilainya
			$qku21 = mysqli_query($koneksi, "SELECT SUM(nilai) AS totalnya ".
												"FROM siswa_tagihan ".
												"WHERE siswa_nis = '$btnis' ".
												"AND tapel = '$tapel' ".
												"AND kelas = '$kelas' ".
												"AND jenis = '$ku_nama2' ".
												"AND terbayar = 'false'");
			$rku21 = mysqli_fetch_assoc($qku21);
			$tku21 = mysqli_num_rows($qku21);
			$ku21_nilai1 = nosql($rku21['totalnya']);
	

			//ketahui total tunggakan tapel sebelumnya
			$ktahun211 = $xtapel1 - 1;
			$ktahun212 = $xtapel2 - 1;
			$tapel4 = cegah("$ktahun211/$ktahun212");
			
			//cek
			$qku214 = mysqli_query($koneksi, "SELECT belum_bayar FROM siswa_tagihan_tapel ".
												"WHERE siswa_nis = '$btnis' ".
												"AND tapel = '$tapel4' ".
												"AND jenis = '$ku_nama2'");
			$rku214 = mysqli_fetch_assoc($qku214);
			$ku214_nilai = nosql($rku214['belum_bayar']);
			
			//jika null
			if (empty($ku214_nilai))
				{
				$ku214_nilai = 0;
				}




			$ku21_nilai = $ku21_nilai1 + $ku214_nilai;


			//jika null
			if (empty($ku21_nilai))
				{
				$ku21_nilaix = "0";	
				}
			else
				{
				$ku21_nilaix = xduit3($ku21_nilai);
				}












			//ketahui nilainya, terbayar
			$qku211 = mysqli_query($koneksi, "SELECT SUM(nilai) AS totalnya ".
												"FROM siswa_tagihan ".
												"WHERE siswa_nis = '$btnis' ".
												"AND tapel = '$tapel' ".
												"AND kelas = '$kelas' ".
												"AND jenis = '$ku_nama2' ".
												"AND terbayar = 'true'");
			$rku211 = mysqli_fetch_assoc($qku211);
			$tku211 = mysqli_num_rows($qku211);
			$ku211_nilai = nosql($rku211['totalnya']);



			//jika null
			if (empty($ku211_nilai))
				{
				$ku211_nilaix = "0";	
				}
			else
				{
				$ku211_nilaix = xduit3($ku211_nilai);
				}




			$ku21_nilai = $ku21_nilai1 + $ku214_nilai;


			//jika null
			if (empty($ku21_nilai))
				{
				$ku21_nilaix = "0";	
				}
			else
				{
				$ku21_nilaix = xduit3($ku21_nilai);
				}







			//masukkan ke daftar tunggakan tapel ///////////////////////////////////////////////
			//ketahui tapel berikutnya...
			$ktahun211 = $xtapel1 + 1;
			$ktahun212 = $xtapel2 + 1;
			$tapel4 = cegah("$ktahun211/$ktahun212");
			
			
			$xyz2 = md5("$btkd$k$kk$ktahun$ku_nama2");
			
			
			
			//ambilkan dari set nominal
			$qku22 = mysqli_query($koneksi, "SELECT SUM(nominal) AS totalnya ".
												"FROM m_set_nominal ".
												"WHERE tapel = '$tapel' ".
												"AND kelas = '$kelas' ".
												"AND jenis = '$ku_nama2'");
			$rku22 = mysqli_fetch_assoc($qku22);
			$ku22_nilai = nosql($rku22['totalnya']);
	
			
			//insert
			$qku212 = mysqli_query($koneksi, "SELECT * FROM siswa_tagihan_tapel ".
												"WHERE siswa_nis = '$btnis' ".
												"AND tapel = '$tapel' ".
												"AND kelas = '$kelas' ".
												"AND jenis = '$ku_nama2'");
			$rku212 = mysqli_fetch_assoc($qku212);
			$tku212 = mysqli_num_rows($qku212);
			
			//jika null, kasi insert
			if (empty($tku212))
				{
				//insert kan...
				mysqli_query($koneksi, "INSERT INTO siswa_tagihan_tapel(kd, siswa_kd, siswa_nis, siswa_nama, ".
											"tapel, tapelnow, kelas, jenis, ".
											"total, belum_bayar, terbayar, postdate) VALUES ".
											"('$xyz2', '$btkd', '$btnis', '$btnama', ".
											"'$tapel', '$tapel4', '$kelas', '$ku_nama2', ".
											"'$ku22_nilai', '$ku21_nilai', '$ku211_nilai', '$today')");
				}
				
			else
				{
				//hapus dulu, trus insert
				mysqli_query($koneksi, "DELETE FROM siswa_tagihan_tapel ".
												"WHERE siswa_nis = '$btnis' ".
												"AND tapel = '$tapel' ".
												"AND kelas = '$kelas' ".
												"AND jenis = '$ku_nama2'");
				
				
				//insert kan...
				mysqli_query($koneksi, "INSERT INTO siswa_tagihan_tapel(kd, siswa_kd, siswa_nis, siswa_nama, ".
											"tapel, tapelnow, kelas, jenis, ".
											"total, belum_bayar, terbayar, postdate) VALUES ".
											"('$xyz2', '$btkd', '$btnis', '$btnama', ".
											"'$tapel', '$tapel4', '$kelas', '$ku_nama2', ".
											"'$ku22_nilai', '$ku21_nilai', '$ku211_nilai', '$today')");
				}


	
	
	
	
	
							
			echo '<td valign="top" align="right"><b>'.$ku21_nilaix.'</b></td>
			<td valign="top" align="right"><b>'.$ku211_nilaix.'</b></td>
			</tr>';
			
			
			






			//list jenis
			$qku = mysqli_query($koneksi, "SELECT * FROM m_cara_bayar ".
											"ORDER BY nama ASC LIMIT 1,10");
			$rku = mysqli_fetch_assoc($qku);
			
			
			do
				{
				$ku_nama = balikin($rku['nama']);
				$ku_nama2 = cegah($rku['nama']);
	
	
				
		
				//ketahui total tunggakan tapel sebelumnya
				$ktahun211 = $xtapel1 - 1;
				$ktahun212 = $xtapel2 - 1;
				$tapel4 = cegah("$ktahun211/$ktahun212");
				
				//cek
				$qku214 = mysqli_query($koneksi, "SELECT belum_bayar FROM siswa_tagihan_tapel ".
													"WHERE siswa_nis = '$btnis' ".
													"AND tapel = '$tapel4' ".
													"AND jenis = '$ku_nama2'");
				$rku214 = mysqli_fetch_assoc($qku214);
				$ku214_nilai = nosql($rku214['belum_bayar']);
				
				//jika null
				if (empty($ku214_nilai))
					{
					$ku214_nilai = 0;
					}
								
				
				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna01';\">";
				echo '<td valign="top">&nbsp;</td>
				<td valign="top">&nbsp;</td>
				<td valign="top"><b>'.$ku_nama.'</b></td>
				<td valign="top" align="right"><b>'.xduit3($ku214_nilai).'</b></td>';
					
					
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
	
					
					
									
					//cek tagihan
					$qku21 = mysqli_query($koneksi, "SELECT * FROM siswa_tagihan ".
														"WHERE siswa_nis = '$btnis' ".
														"AND tapel = '$tapel' ".
														"AND kelas = '$kelas' ".
														"AND jenis = '$ku_nama2' ".
														"AND bulan = '$kk' ".
														"AND tahun = '$ktahun'");
					$rku21 = mysqli_fetch_assoc($qku21);
					$tku21 = mysqli_num_rows($qku21);
					$ku21_nilai = nosql($rku21['nilai']);
					$ku21_terbayar = balikin($rku21['terbayar']);
					$ku21_terbayar_postdate = balikin($rku21['terbayar_postdate']);
			
					//jika true
					if ($ku21_terbayar == "true")
						{
						$ku21_terbayar_status = "<b><font color='green'>TERBAYAR</font>. <br>$ku21_terbayar_postdate</b>";
						}
						
					else
						{
						$ku21_terbayar_status = "<font color='orange'>Belum Bayar</font>";
						}
	
	
						
			
			
					/*
					//jika null
					if (empty($ku21_nilai))
						{
						//ambilkan dari set nominal
						$qku22 = mysqli_query($koneksi, "SELECT * FROM m_set_nominal ".
															"WHERE tapel = '$tapel' ".
															"AND kelas = '$kelas' ".
															"AND jenis = '$ku_nama2' ".
															"AND bulan = '$kk' ".
															"AND tahun = '$ktahun'");
						$rku22 = mysqli_fetch_assoc($qku22);
						$ku22_nilai = nosql($rku22['nominal']);
						$ku21_nilaix = xduit3($ku22_nilai);
						
						
						
						//insert kan...
						mysqli_query($koneksi, "INSERT INTO siswa_tagihan(kd, siswa_kd, siswa_nis, siswa_nama, ".
													"tapel, kelas, jenis, ".
													"bulan, tahun, terbayar, ".
													"nilai, postdate) VALUES ".
													"('$xyz', '$btkd', '$btnis', '$btnama', ".
													"'$tapel', '$kelas', '$ku_nama2', ".
													"'$kk', '$ktahun', 'false', ".
													"'$ku22_nilai', '$today')");
						}
					else
						{
						$ku21_nilaix = xduit3($ku21_nilai);
							
							
						//hapus dulu, trus insert
						mysqli_query($koneksi, "DELETE FROM siswa_tagihan ".
													"WHERE siswa_nis = '$btnis' ".
													"AND tapel = '$tapel' ".
													"AND kelas = '$kelas' ".
													"AND jenis = '$ku_nama2' ".
													"AND bulan = '$kk' ".
													"AND tahun = '$ktahun'");					
						
						//insert kan...
						mysqli_query($koneksi, "INSERT INTO siswa_tagihan(kd, siswa_kd, siswa_nis, siswa_nama, ".
													"tapel, kelas, jenis, ".
													"bulan, tahun, terbayar, ".
													"nilai, postdate) VALUES ".
													"('$xyz', '$btkd', '$btnis', '$btnama', ".
													"'$tapel', '$kelas', '$ku_nama2', ".
													"'$kk', '$ktahun', 'false', ".
													"'$ku21_nilai', '$today')");
						}
					*/
					
					
								
					
					echo '<td valign="top" align="right">
					<font color="black">
					'.$ku21_nilaix.'
					</font>
					<br>
					
					'.$ku21_terbayar_status.'
					</td>';
					}

					

	
	
	
				//ketahui nilainya
				$qku21 = mysqli_query($koneksi, "SELECT SUM(nilai) AS totalnya ".
													"FROM siswa_tagihan ".
													"WHERE siswa_nis = '$btnis' ".
													"AND tapel = '$tapel' ".
													"AND kelas = '$kelas' ".
													"AND jenis = '$ku_nama2' ".
													"AND terbayar = 'false'");
				$rku21 = mysqli_fetch_assoc($qku21);
				$tku21 = mysqli_num_rows($qku21);
				$ku21_nilai1 = nosql($rku21['totalnya']);
		
		
	
		
				//ketahui total tunggakan tapel sebelumnya
				$ktahun211 = $xtapel1 - 1;
				$ktahun212 = $xtapel2 - 1;
				$tapel4 = cegah("$ktahun211/$ktahun212");
				
				//cek
				$qku214 = mysqli_query($koneksi, "SELECT belum_bayar FROM siswa_tagihan_tapel ".
													"WHERE siswa_nis = '$btnis' ".
													"AND tapel = '$tapel4' ".
													"AND jenis = '$ku_nama2'");
				$rku214 = mysqli_fetch_assoc($qku214);
				$ku214_nilai = nosql($rku214['belum_bayar']);
				
				//jika null
				if (empty($ku214_nilai))
					{
					$ku214_nilai = 0;
					}
	
	
	
	
				$ku21_nilai = $ku21_nilai1 + $ku214_nilai;
				//$ku21_nilai = $ku214_nilai;
	
	
				//jika null
				if (empty($ku21_nilai))
					{
					$ku21_nilaix = "0";	
					}
				else
					{
					$ku21_nilaix = xduit3($ku21_nilai);
					}
	
	

	
	
	
		
	
	
				//ketahui nilainya, terbayar
				$qku211 = mysqli_query($koneksi, "SELECT SUM(nilai) AS totalnya ".
													"FROM siswa_tagihan ".
													"WHERE siswa_nis = '$btnis' ".
													"AND tapel = '$tapel' ".
													"AND kelas = '$kelas' ".
													"AND jenis = '$ku_nama2' ".
													"AND terbayar = 'true'");
				$rku211 = mysqli_fetch_assoc($qku211);
				$tku211 = mysqli_num_rows($qku211);
				$ku211_nilai = nosql($rku211['totalnya']);
	
	
	
				//jika null
				if (empty($ku211_nilai))
					{
					$ku211_nilaix = "0";	
					}
				else
					{
					$ku211_nilaix = xduit3($ku211_nilai);
					}
	
	
	
	
				/*
				//masukkan ke daftar tunggakan tapel ///////////////////////////////////////////////
				//ketahui tapel berikutnya...
				$ktahun211 = $xtapel1 + 1;
				$ktahun212 = $xtapel2 + 1;
				$tapel4 = cegah("$ktahun211/$ktahun212");
					
				
				
				//ambilkan dari set nominal
				$qku22 = mysqli_query($koneksi, "SELECT SUM(nominal) AS totalnya ".
													"FROM m_set_nominal ".
													"WHERE tapel = '$tapel' ".
													"AND kelas = '$kelas' ".
													"AND jenis = '$ku_nama2'");
				$rku22 = mysqli_fetch_assoc($qku22);
				$ku22_nilai = nosql($rku22['totalnya']);
		
				
				//insert
				$qku212 = mysqli_query($koneksi, "SELECT * FROM siswa_tagihan_tapel ".
													"WHERE siswa_nis = '$btnis' ".
													"AND tapel = '$tapel' ".
													"AND kelas = '$kelas' ".
													"AND jenis = '$ku_nama2'");
				$rku212 = mysqli_fetch_assoc($qku212);
				$tku212 = mysqli_num_rows($qku212);
				
				//jika null, kasi insert
				if (empty($tku212))
					{
					//insert kan...
					mysqli_query($koneksi, "INSERT INTO siswa_tagihan_tapel(kd, siswa_kd, siswa_nis, siswa_nama, ".
												"tapel, tapelnow, kelas, jenis, ".
												"total, belum_bayar, terbayar, postdate) VALUES ".
												"('$xyz', '$btkd', '$btnis', '$btnama', ".
												"'$tapel', '$tapel4', '$kelas', '$ku_nama2', ".
												"'$ku22_nilai', '$ku21_nilai', '$ku211_nilai', '$today')");
					}
				else
					{
					//hapus dulu... trus update
					//delete
					mysqli_query($koneksi, "DELETE FROM siswa_tagihan_tapel ".
												"WHERE siswa_nis = '$btnis' ".
												"AND tapel = '$tapel' ".
												"AND kelas = '$kelas' ".
												"AND jenis = '$ku_nama2'");
					
					
					
					//insert kan...
					mysqli_query($koneksi, "INSERT INTO siswa_tagihan_tapel(kd, siswa_kd, siswa_nis, siswa_nama, ".
												"tapel, tapelnow, kelas, jenis, ".
												"total, belum_bayar, terbayar, postdate) VALUES ".
												"('$xyz', '$btkd', '$btnis', '$btnama', ".
												"'$tapel', '$tapel4', '$kelas', '$ku_nama2', ".
												"'$ku22_nilai', '$ku21_nilai', '$ku211_nilai', '$today')");
					
					}
				*/		
		

	

					
				echo '<td valign="top" align="right"><b>'.$ku21_nilaix.'</b></td>
				<td valign="top" align="right"><b>'.$ku211_nilaix.'</b></td>
				</tr>';
		
				}
			while ($rku = mysqli_fetch_assoc($qku));
			
			
			





			//ketahui total tunggakan tapel sebelumnya
			$ktahun211 = $xtapel1 - 1;
			$ktahun212 = $xtapel2 - 1;
			$tapel4 = cegah("$ktahun211/$ktahun212");
			
			//cek
			$qku214 = mysqli_query($koneksi, "SELECT SUM(belum_bayar) AS totalnya ".
												"FROM siswa_tagihan_tapel ".
												"WHERE siswa_nis = '$btnis' ".
												"AND tapel = '$tapel4'");
			$rku214 = mysqli_fetch_assoc($qku214);
			$ku214_nilai = nosql($rku214['totalnya']);
			
			//jika null
			if (empty($ku214_nilai))
				{
				$ku214_nilai = 0;
				}
							
			
			


			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna01';\">";
			echo '<td valign="top">&nbsp;</td>
			<td valign="top">&nbsp;</td>
			<td valign="top" bgcolor="orange"><b>TOTAL TUNGGAKAN</b></td>
			<td valign="top" bgcolor="orange" align="right"><b>'.xduit3($ku214_nilai).'</b></td>';
				
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
													"FROM siswa_tagihan ".
													"WHERE siswa_nis = '$btnis' ".
													"AND tapel = '$tapel' ".
													"AND kelas = '$kelas' ".
													"AND bulan = '$kk' ".
													"AND tahun = '$ktahun' ".
													"AND terbayar = 'false'");
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
												"FROM siswa_tagihan ".
												"WHERE siswa_nis = '$btnis' ".
												"AND tapel = '$tapel' ".
												"AND kelas = '$kelas' ".
												"AND terbayar = 'false'");
			$rku21 = mysqli_fetch_assoc($qku21);
			$tku21 = mysqli_num_rows($qku21);
			$ku21_nilai1 = nosql($rku21['totalnya']);
	
	
	
	
			//tunggakan saat ini
			$ku21_nilai = $ku214_nilai + $ku21_nilai1;
				
				
				
			//jika null
			if (empty($ku21_nilai))
				{
				$ku21_nilaix = "0";	
				}
			else
				{
				$ku21_nilaix = xduit3($ku21_nilai);
				}





			//ketahui nilainya
			$qku21x = mysqli_query($koneksi, "SELECT SUM(nilai) AS totalnya ".
												"FROM siswa_tagihan ".
												"WHERE siswa_nis = '$btnis' ".
												"AND tapel = '$tapel' ".
												"AND tapel = '$tapel4' ".
												"AND kelas = '$kelas' ".
												"AND terbayar = 'true'");
			$rku21x = mysqli_fetch_assoc($qku21x);
			$tku21x = mysqli_num_rows($qku21x);
			$ku21x_nilai1 = nosql($rku21x['totalnya']);
	
	
			//jika null
			if (empty($ku21x_nilai1))
				{
				$ku21x_nilaix = "0";	
				}
			else
				{
				$ku21x_nilaix = xduit3($ku21x_nilai1);
				}





			//ketahui total tunggakan tapel sebelumnya
			$ktahun211 = $xtapel1 - 1;
			$ktahun212 = $xtapel2 - 1;
			$tapel4 = cegah("$ktahun211/$ktahun212");
			
			//cek
			$qku214 = mysqli_query($koneksi, "SELECT SUM(terbayar) AS totalnya ".
												"FROM siswa_tagihan_tapel ".
												"WHERE siswa_nis = '$btnis' ".
												"AND tapel = '$tapel4'");
			$rku214 = mysqli_fetch_assoc($qku214);
			$ku214_nilai = nosql($rku214['totalnya']);
			
			//jika null
			if (empty($ku214_nilai))
				{
				$ku214_nilai = 0;
				}
							



	
			//tunggakan saat ini
			$ku21_nilai = $ku214_nilai + $ku21x_nilai1;
				
				
				
			//jika null
			if (empty($ku21_nilai))
				{
				$ku21x_nilaix = "0";	
				}
			else
				{
				$ku21x_nilaix = xduit3($ku21_nilai);
				}





				
							
			echo '<td valign="top" bgcolor="orange" align="right"><b>'.$ku21_nilaix.'</b></td>
			<td valign="top" bgcolor="blue" align="right"><b>'.$ku21x_nilaix.'</b></td>
			</tr>';
			}
		while ($rowbt = mysqli_fetch_assoc($qbt));
	
	
	



		//ketahui total tunggakan tapel sebelumnya
		$ktahun211 = $xtapel1 - 1;
		$ktahun212 = $xtapel2 - 1;
		$tapel4 = cegah("$ktahun211/$ktahun212");
		
		//cek
		$qku214 = mysqli_query($koneksi, "SELECT SUM(belum_bayar) AS totalnya ".
											"FROM siswa_tagihan_tapel ".
											"WHERE tapel = '$tapel4' ".
											"AND kelasnow = '$kelas'");
		$rku214 = mysqli_fetch_assoc($qku214);
		$ku214_nilai = nosql($rku214['totalnya']);
		
		//jika null
		if (empty($ku214_nilai))
			{
			$ku214_nilai = 0;
			}
						




		//tunggakan saat ini
		$ku21_nilai = $ku214_nilai;
			
			
			
		//jika null
		if (empty($ku21_nilai))
			{
			$ku21x_nilaix = "0";	
			}
		else
			{
			$ku21x_nilaix = xduit3($ku21_nilai);
			}



	
	
		echo '<tr bgcolor="'.$warnaheader.'">
		<td valign="top"><strong><font color="'.$warnatext.'"></font></strong></td>
		<td valign="top"><strong><font color="'.$warnatext.'"></font></strong></td>
		<td valign="top"><strong><font color="'.$warnatext.'"></font></strong></td>
		<td valign="top" bgcolor="yellow"><strong><font color="black">'.$ku21x_nilaix.'</font></strong></td>';
		

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
											"FROM siswa_tagihan ".
											"WHERE tapel = '$tapel' ".
											"AND kelas = '$kelas' ".
											"AND bulan = '$kk' ".
											"AND tahun = '$ktahun' ".
											"AND terbayar = 'false'");
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
		$qku214 = mysqli_query($koneksi, "SELECT SUM(terbayar) AS totalnya ".
											"FROM siswa_tagihan_tapel ".
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





				
		
		echo '<td valign="top" bgcolor="yellow" align="right"><strong><font color="black">'.$ku214_nilai2.'</font></strong></td>
		<td valign="top" bgcolor="cyan" align="right"><strong><font color="black">'.$ku214_nilai21.'</font></strong></td>
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