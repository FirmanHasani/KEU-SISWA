<?php
session_start();

require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/adm.php");
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/adm.html");

nocache;

//nilai
$filenya = "bayar.php";
$judul = "[PEMBAYARAN]. Per Siswa";
$judulku = "$judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$d = nosql($_REQUEST['d']);
$sukd = cegah($_REQUEST['sukd']);
$swkd = cegah($_REQUEST['swkd']);
$swnama = cegah($_REQUEST['swnama']);
$swnamax = balikin($swnama);
$swnis = cegah($_REQUEST['swnis']);
$swnisx = balikin($swnis);
$swtapel = cegah($_REQUEST['swtapel']);
$swtapelx = balikin($swtapel);
$swkelas = cegah($_REQUEST['swkelas']);
$swkelasx = balikin($swkelas);
$ecara = balikin($_REQUEST['ecara']);
$enominal = balikin($_REQUEST['enominal']);
$ubln = balikin($_REQUEST['ubln']);




//bikin pdf
require_once("../../inc/class/dompdf/autoload.inc.php");

use Dompdf\Dompdf;
$dompdf = new Dompdf();





//jika entri
if (!empty($s))
	{
	$e_swnamax = "$swnamax NIS.$swnisx KELAS.$swkelasx";
	}







//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//nek batal
if ($_POST['btnBTL'])
	{
	//re-direct
	xloc($filenya);
	exit();
	}




//jika simpan
if ($_POST['btnSMP'])
	{
	$s = nosql($_POST['s']);
	$kd = nosql($_POST['kd']);
	$page = nosql($_POST['page']);
	$e_kunci = cegah($_POST['kunci']);

	
	
	
 
	//pecah nis
	$nipku = explode("NIS.", $e_kunci);
	$e_swnama = trim($nipku[0]);
	$e_swnana = trim($nipku[1]);
	
	
	$nipku = explode("KELAS.", $e_swnana);
	$e_swnis = trim($nipku[0]);
	$e_swkelas = trim($nipku[1]);
	 
	 

		
	//detail 
	$qx = mysqli_query($koneksi, "SELECT * FROM m_siswa ".
									"WHERE nama = '$e_swnama' ".
									"AND nis = '$e_swnis' ".
									"AND kelas = '$e_swkelas'");
	$rowx = mysqli_fetch_assoc($qx);
	$e_swkd = cegah($rowx['kd']);
	$e_swnama = cegah($rowx['nama']);
	$e_swnis = cegah($rowx['nis']);
	$e_swtapel = cegah($rowx['tapel']);
	$e_swkelas = cegah($rowx['kelas']);


	//jika ada, lanjutkan
	if (!empty($e_swkd))
		{
		//true re-direct
		$ke = "$filenya?s=entri&swkd=$e_swkd&swnama=$e_swnama&swnis=$e_swnis&swtapel=$e_swtapel&swkelas=$e_swkelas";
		xloc($ke);
		exit();
		}
		
	else
		{
		//re-direct
		xloc($filenya);
		exit();	
		}
	 	 
	}










//jika simpan2
if ($_POST['btnSMP2'])
	{
	$s = nosql($_POST['s']);
	$kd = nosql($_POST['kd']);
	$page = nosql($_POST['page']);

	$e_cara = cegah($_POST['e_cara']);
	$e_nominal = cegah($_POST['e_nominal']);
	
	$swkd = cegah($_POST['swkd']);
	$swnama = cegah($_POST['swnama']);
	$swnis = cegah($_POST['swnis']);
	$swtapel = cegah($_POST['swtapel']);
	$swkelas = cegah($_POST['swkelas']);


	$e_tgl3 = cegah($_POST['e_tgl_bayar']);
	
	


	//pecah tanggal
	$tgl2_pecah = balikin($e_tgl3);
	$tgl2_pecahku = explode("-", $tgl2_pecah);
	$tgl2_tgl = trim($tgl2_pecahku[2]);
	$tgl2_bln = trim($tgl2_pecahku[1]);
	$tgl2_thn = trim($tgl2_pecahku[0]);
	$e_tgl_bayar = "$tgl2_thn:$tgl2_bln:$tgl2_tgl";



	
				
	//list 
	$qku = mysqli_query($koneksi, "SELECT * FROM m_cara_bayar ".
									"ORDER BY nama ASC");
	$rku = mysqli_fetch_assoc($qku);
	$tku = mysqli_num_rows($qku);



	do
		{
		//nilai
		$ku_no = $ku_no + 1;;
		$ku_nama = balikin($rku['nama']);
		$ku_nama2 = cegah($rku['nama']);
		
		
		//ambil nilai
		$yuk = "e_nominal";
		$yuhu = "$yuk$ku_no";
		$nilku = nosql($_POST["$yuhu"]);
		

		$xyz = "$x$ku_no";







		
		//hanya yg ada
		if (!empty($nilku))
			{
			//entri
			mysqli_query($koneksi, "INSERT INTO siswa_bayar(kd, siswa_kd, siswa_nis, siswa_nama, ". 
										"tapel, kelas, jenis, ".
										"cara_bayar, tgl_bayar, nilai, ". 
										"ket, postdate) VALUES ".
										"('$xyz', '$swkd', '$swnis', '$swnama', ".
										"'$swtapel', '$swkelas', '$ku_nama2', ".
										"'$e_cara', '$e_tgl_bayar', '$nilku', ".
										"'$e_ket', '$today')");
			}
									
									
	



		


		
		}
	while ($rku = mysqli_fetch_assoc($qku));
					









									
	//re-direct
	$ke = "$filenya?s=entri&d=edit&sukd=$xyz&swkd=$swkd&swnama=$swnama&swnis=$swnis&swtapel=$swtapel&swkelas=$swkelas&enominal=$e_nominal&ecara=$e_cara";
	xloc($ke);
	exit();	
	}



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//isi *START
ob_start();


?>



	
<script>
$(document).ready(function() {
  		
	$.noConflict();
    
});
</script>
  




<?php
//require
require("../../inc/js/number.js");
require("../../inc/js/jumpmenu.js");
require("../../inc/js/checkall.js");
require("../../inc/js/swap.js");


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<div class="row">
	<div class="col-md-12">
	
	<a href="bayar_excel.php" class="btn btn-primary">DAFTAR PEMBAYARAN SISWA >></a>
	
	<hr>
	<form action="'.$filenya.'" method="post" name="formx2">

		<p>
		SISWA :
		<br> 
		<input type="text" name="kunci" id="kunci" class="btn btn-warning" placeholder="Nama Siswa" value="'.$e_swnamax.'" required>
		<input type="hidden" name="e_swkd" id="e_swkd" value="'.$e_swkd.'">

		<input name="s" type="hidden" value="'.$s.'">
		<input name="kd" type="hidden" value="'.$kdx.'">
		<input name="page" type="hidden" value="'.$page.'">
		
		<input name="btnSMP" type="submit" value="ENTRI BAYAR >>" class="btn btn-danger">
		</p>
		
		</form>
		
	</div>
</div>';



//jika entri
if ($s == "entri")
	{
	$diload = "document.formx3.e_bayar.focus();";

	
	//jika null
	if (empty($ubln))
		{
		$e_tgl_bayar = "$tahun-$bulan-$tanggal";
		}
	else
		{
		//jika satu digit
		if (strlen($ubln) == 1)
			{
			$ublnx = "0$ubln";
			}
		else
			{
			$ublnx = $ubln;
			}
			
		$e_tgl_bayar = "$tahun-$ublnx-01";
		}
	
	?>
	
	
	
	<!-- Bootstrap core JavaScript -->
	<script src="<?php echo $sumber;?>/template/vendors/jquery/jquery.min.js"></script>
	<script src="<?php echo $sumber;?>/template/vendors/bootstrap/js/bootstrap.bundle.min.js"></script>


	<?php		
	//jika null, kasi cash
	if (empty($ecara))
		{
		$ecara = "Cash";
		}	

	echo '<hr>

		<p>
		Tahun Pelajaran, Kelas :
		<br>
		<b>'.$swtapelx.', '.$swkelasx.'</b>
		</p>

		
		<div class="row">
			<div class="col-md-4">

				<form action="'.$filenya.'" method="post" name="formx3">
		
				<p>
				Metode Bayar :
				<br>
							
				<select name="e_cara" id="e_cara" class="btn btn-block btn-warning"  
				onKeyDown="var keyCode = event.keyCode;
				if (keyCode == 13)
					{
					document.formx3.e_nominal.focus();
					}" 
				required>
				<option value="'.$ecara.'" selected>'.$ecara.'</option>';
				
				//list 
				$qku = mysqli_query($koneksi, "SELECT * FROM m_uang_jenis ".
												"ORDER BY nama ASC");
				$rku = mysqli_fetch_assoc($qku);
		
				do
					{
					//nilai
					$ku_nama = balikin($rku['nama']);
					$ku_nama2 = cegah($rku['nama']);
			
					echo '<option value="'.$ku_nama2.'">'.$ku_nama.'</option>';
					}
				while ($rku = mysqli_fetch_assoc($qku));
				
				
				echo '</select>
				
				</p>';
				?>
	
		
					
				<script>
				$(document).ready(function () {
			
				    function hitungkabeh() {
			            	var e_nil1 = parseInt($('#e_nominal1').val());
			            	var e_nil2 = parseInt($('#e_nominal2').val());
			            	var e_nil3 = parseInt($('#e_nominal3').val());
			            	
				            totalnya = e_nil1 + e_nil2 + e_nil3;
				            

							$('#e_total').val(totalnya);
						}
						
						
						
						
							
					<?php			
					//list 
					$qku = mysqli_query($koneksi, "SELECT * FROM m_cara_bayar ".
													"ORDER BY nama ASC");
					$rku = mysqli_fetch_assoc($qku);
					$tku = mysqli_num_rows($qku);
			
					
					do
						{
						//nilai
						$ku_nox = $ku_nox + 1;;
						$ku_nama = balikin($rku['nama']);
						$ku_nama2 = cegah($rku['nama']);
						?>					
		
					    $('#e_nominal<?php echo $ku_nox;?>').on("keyup", function () {
							hitungkabeh();
					    })
				
		
				
					    
						<?php	
						}
					while ($rku = mysqli_fetch_assoc($qku));
					?>
				
	
														
				
			
			
						
				});
				</script>		
								
			
			

	
	
				
	
				<?php
				echo '<ul>';
				
				//ketahui total tunggakan tapel sebelumnya
				$xtapelku = explode("xgmringx", $swtapel);
				$xtapel1 = trim($xtapelku[0]);
				$xtapel2 = trim($xtapelku[1]);
				
				
				$ktahun211 = $xtapel1 - 1;
				$ktahun212 = $xtapel2 - 1;
				$tapel4 = cegah("$ktahun211/$ktahun212");
				
				
				
				//list 
				$qku = mysqli_query($koneksi, "SELECT * FROM m_cara_bayar ".
												"ORDER BY nama ASC");
				$rku = mysqli_fetch_assoc($qku);
				$tku = mysqli_num_rows($qku);
		
		
		
				do
					{
					//nilai
					$ku_no = $ku_no + 1;;
					$ku_nama = balikin($rku['nama']);
					$ku_nama2 = cegah($rku['nama']);
					
					
						
					//kasi nol
					$enomku = 0;


			
					echo '<li>'.$ku_nama.'
					<br>
					Rp.<input name="e_nominal'.$ku_no.'" id="e_nominal'.$ku_no.'" type="text" size="10" class="btn btn-warning" value="'.$enomku.'" style="text-align:right" onKeyPress="return numbersonly(this, event)" required>,-
					<br>
					<br>
					</li>';
					}
				while ($rku = mysqli_fetch_assoc($qku));
								
				echo '</ul>
				</p>
				
					
				<p>
				Total Bayar Rp. :
				<br>
				<input name="e_total" id="e_total" type="text" size="10" class="btn btn-block btn-default" value="'.$enomku.'" style="text-align:right" readonly>
				<p>
	

		
				<p>
				Tanggal Bayar :
				<input name="e_tgl_bayar" id="e_tgl_bayar" type="date" value="'.$e_tgl_bayar.'" size="10" class="btn btn-warning" required>
				</p>
			
			
		
				<p>
				<input name="s" type="hidden" value="'.$s.'">
				<input name="sukd" type="hidden" value="'.$sukd.'">
				<input name="swkd" type="hidden" value="'.$swkd.'">
				<input name="swnama" type="hidden" value="'.$swnama.'">
				<input name="swnis" type="hidden" value="'.$swnis.'">
				<input name="swtapel" type="hidden" value="'.$swtapel.'">
				<input name="swkelas" type="hidden" value="'.$swkelas.'">
				<input name="btnSMP2" id="btnSMP2" type="submit" value="SIMPAN BAYAR >>" class="btn btn-block btn-danger">
				</p>
			
				</form>
			
			</div>


			
			<div class="col-md-8">';
			

				//rincian dalam satu tapel
				$btkd = $swkd;
				$btnis = $swnis;
				$btnama = $swnama;
		
		
			
				
				$tapel = $swtapel;
				$tapel2 = balikin($rowbt['tapel']);
				$kelas = $swkelas;
				$kelas2 = balikin($rowbt['kelas']);
					
				
				$xtapelku = explode("xgmringx", $tapel);
				$xtapel1 = trim($xtapelku[0]);
				$xtapel2 = trim($xtapelku[1]);
				
			
			
				echo '<input name="tapel" type="hidden" value="'.$tapel.'">
				<input name="kelas" type="hidden" value="'.$kelas.'">';
				
				
				echo '<div class="table-responsive">          
				<table class="table" border="1">
				<thead>
				<tr bgcolor="'.$warnaheader.'">
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
			
			
		
		
		
		
		
		
				//list jenis
				$qku = mysqli_query($koneksi, "SELECT * FROM m_cara_bayar ".
												"ORDER BY nama ASC");
				$rku = mysqli_fetch_assoc($qku);
				
				
				do
					{
					$ku_no = $ku_no + 1;;
					$ku_nama = balikin($rku['nama']);
					$ku_nama2 = cegah($rku['nama']);
		
				
				
					
					//total tagihan per tahun
					$qjon22 = mysqli_query($koneksi, "SELECT SUM(nominal) AS totalnya ".
														"FROM m_set_nominal ".
														"WHERE tapel = '$tapel' ".
														"AND kelas = '$kelas' ".
														"AND jenis = '$ku_nama2'");
					$rjon22 = mysqli_fetch_assoc($qjon22);
					$jon22_tagihan = balikin($rjon22['totalnya']);
										
										
										
										
					
					
					
					//totalnya..
					$qku24 = mysqli_query($koneksi, "SELECT SUM(nilai) AS totalnya ".
													"FROM siswa_bayar ".
													"WHERE siswa_kd = '$btkd' ".
													"AND tapel = '$tapel' ".
													"AND kelas = '$kelas' ".
													"AND jenis = '$ku_nama2'");
					$rku24 = mysqli_fetch_assoc($qku24);
					$tku24 = mysqli_num_rows($qku24);
					$ku24_nilai = nosql($rku24['totalnya']);
					
					
					
					
					
			
					echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna01';\">";
					echo '<td valign="top">
					<b>'.$ku_nama.'</b>
					
					
					</td>';



					//ketahui total bayarnya
					$qjon31 = mysqli_query($koneksi, "SELECT SUM(nilai) AS totalnya ".
														"FROM siswa_bayar ".
														"WHERE siswa_kd = '$btkd' ".
														"AND tapel = '$tapel' ".
														"AND kelas = '$kelas' ".
														"AND jenis = '$ku_nama2'");
					$rjon31 = mysqli_fetch_assoc($qjon31);
					$tjon31 = mysqli_num_rows($qjon31);
					$jon31_nilai = balikin($rjon31['totalnya']);
						
	
						
						
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
							
							
	
	
						//ketahui set nominal 
						$qjon2 = mysqli_query($koneksi, "SELECT * FROM m_set_nominal ".
															"WHERE tapel = '$tapel' ".
															"AND kelas = '$kelas' ".
															"AND jenis = '$ku_nama2' ".
															"AND tahun = '$ktahun' ".
															"AND bulan = '$kk'");
						$rjon2 = mysqli_fetch_assoc($qjon2);
						$tjon2 = mysqli_num_rows($qjon2);
						$jon2_nominal = balikin($rjon2['nominal']);
						$jon2_nominalx = xduit3($jon2_nominal);
	
	
	
						//berbulan ah...
						$bulananya = $bulananya + $jon2_nominal;
	
	
	
	
						//ketahui jumlah bayar 
						$qjon3 = mysqli_query($koneksi, "SELECT SUM(nilai) AS totalnya ".
															"FROM siswa_bayar ".
															"WHERE siswa_kd = '$btkd' ".
															"AND tapel = '$tapel' ".
															"AND kelas = '$kelas' ".
															"AND jenis = '$ku_nama2' ".
															"AND round(DATE_FORMAT(tgl_bayar, '%m')) = '$kk' ".
															"AND round(DATE_FORMAT(tgl_bayar, '%Y')) = '$ktahun'");
						$rjon3 = mysqli_fetch_assoc($qjon3);
						$tjon3 = mysqli_num_rows($qjon3);
						$jon3_nilai = balikin($rjon3['totalnya']);
						
						//jika ada
						if (!empty($jon3_nilai))
							{
							$jon3_nilku2 = xduit3($jon3_nilai);
							$jon3_nilku = $jon3_nilku2;
							}
						else
							{							
							$jon3_nilku = "-";
							$ku21_terbayar_status = "";								
							}
	
	
	


					
						echo '<td valign="top" align="right">
						<font color="black">
						'.$jon3_nilku.'
						</font>
						</td>';
						}
						
	
	

					 	

					//ketahui nilainya
					$qku21 = mysqli_query($koneksi, "SELECT SUM(nilai) AS totalnya ".
														"FROM siswa_bayar ".
														"WHERE siswa_nis = '$btnis' ".
														"AND jenis = '$ku_nama2' ".
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
	


											
					echo '<td valign="top" align="right"><b>'.$ku21_nilaix.'</b></td>
					</tr>';
					
					
					
					
					//netralkan
					$bulananya = 0;
					}
				while ($rku = mysqli_fetch_assoc($qku));
				
				
				
		
		
		
		


		
				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna01';\">";
				echo '<td valign="top" bgcolor="orange"><b>TOTAL BAYAR</b></td>';
					
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
					
					<br>
					<a href="'.$filenya.'?s=entri&d=edit&sukd='.$sukd.'&swkd='.$btkd.'&swnama='.$btnama.'&swnis='.$btnis.'&swtapel='.$tapel.'&swkelas='.$swkelas.'&ecara=Cash&ubln='.$kk.'" class="btn btn-block btn-danger">ENTRI BAYAR >></a>
					<br>';
					
					
					/*
					//history bayar
					$qku214 = mysqli_query($koneksi, "SELECT * FROM siswa_bayar ".
														"WHERE siswa_nis = '$btnis' ".
														"AND tapel = '$tapel' ".
														"AND kelas = '$kelas' ".
														"AND round(DATE_FORMAT(tgl_bayar, '%m')) = '$kk' ".
														"AND round(DATE_FORMAT(tgl_bayar, '%Y')) = '$ktahun' ".
														"AND nilai <> '0' ".
														"ORDER BY tgl_bayar DESC");
					$rku214 = mysqli_fetch_assoc($qku214);
					$tku214 = mysqli_num_rows($qku214);
					
					do
						{
						$ku214_tgl_bayar = balikin($rku214['tgl_bayar']);
						$ku214_nilai = balikin($rku214['nilai']);
						$ku214_nilaix = xduit3($ku214_nilai);
						
						echo "$ku214_tgl_bayar
						<br>
						<b>$ku214_nilaix</b>
						<hr>";
						}
					while ($rku214 = mysqli_fetch_assoc($qku214));
					*/
					
					
					
					//history bayar
					$qku214 = mysqli_query($koneksi, "SELECT DISTINCT(tgl_bayar) AS tglnya ".
														"FROM siswa_bayar ".
														"WHERE siswa_nis = '$btnis' ".
														"AND tapel = '$tapel' ".
														"AND kelas = '$kelas' ".
														"AND round(DATE_FORMAT(tgl_bayar, '%m')) = '$kk' ".
														"AND round(DATE_FORMAT(tgl_bayar, '%Y')) = '$ktahun' ".
														"AND nilai <> '0' ".
														"ORDER BY tgl_bayar DESC");
					$rku214 = mysqli_fetch_assoc($qku214);
					$tku214 = mysqli_num_rows($qku214);
					
					//jika ada
					if (!empty($tku214))
						{
						do
							{
							$ku214_tgl_bayar = balikin($rku214['tglnya']);
							
							echo "<b>$ku214_tgl_bayar</b> <br>";
							
							
							//detailnya..
							$qku214x = mysqli_query($koneksi, "SELECT * FROM siswa_bayar ".
																"WHERE siswa_nis = '$btnis' ".
																"AND tapel = '$tapel' ".
																"AND kelas = '$kelas' ".
																"AND tgl_bayar = '$ku214_tgl_bayar' ".
																"AND round(DATE_FORMAT(tgl_bayar, '%m')) = '$kk' ".
																"AND round(DATE_FORMAT(tgl_bayar, '%Y')) = '$ktahun' ".
																"AND nilai <> '0' ".
																"ORDER BY tgl_bayar DESC");
							$rku214x = mysqli_fetch_assoc($qku214x);
							$tku214x = mysqli_num_rows($qku214x);
							
							do
								{
								//nilai
								$ku214x_jenis = balikin($rku214x['jenis']);
								$ku214x_nilai = balikin($rku214x['nilai']);
								$ku214x_nilaix = xduit3($ku214x_nilai);
							
								echo "<font color='red'>$ku214x_jenis</font>
								<br>
								<font color='blue'>$ku214x_nilaix</font>
								<br>
								<br>";
								}
							while ($rku214x = mysqli_fetch_assoc($qku214x));
							
							
							echo '<a href="bayar_pdf.php?swnis='.$btnis.'&tapel='.$tapel.'&kelas='.$kelas.'&tglnya='.$ku214_tgl_bayar.'" class="btn btn-block btn-success" target="_blank">PRINT PDF NOTA >></a>';
							echo "<hr>";
							}
						while ($rku214 = mysqli_fetch_assoc($qku214));
						}
			
			
			
			
			
					echo '</td>';
					}
				
				
				
				
		

				//ketahui nilainya
				$qku21 = mysqli_query($koneksi, "SELECT SUM(nilai) AS totalnya ".
													"FROM siswa_bayar ".
													"WHERE siswa_nis = '$btnis' ".
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

					
								
				echo '<td valign="top" bgcolor="blue" align="right"><b>'.$ku21_nilaix.'</b></td>
				</tr>';
		
		
			
		
				
				echo '</tbody>
				</table>
				
				</div>

			
			</div>
			
		</div>
		
		
		<hr>';
		
		
		
	}








echo '<br><br><br>';
?>





<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous" charset="utf-8"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/css/tokenfield-typeahead.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js" charset="utf-8"></script>




<script language='javascript'>
//membuat document jquery
$(document).ready(function(){

	$('#e_nominal').bind('keyup paste', function(){
		this.value = this.value.replace(/[^0-9]/g, '');
		});


	$('#kunci').on('click', function(){
		$('#kunci').val("");
		});

		
});

</script>







<script type="text/javascript">
  $(function() {
  	
  	$.noConflict();



	$('#kunci').typeahead({
      source: function(query, result)
	      {
	      $.ajax({
		      url:"i_cari_siswa.php",
		      method:"POST",
		      data:{query:query},
		      dataType:"json",
		      success:function(data)
			      {
			      result($.map(data, function(item){
				      return item;
				      }));
			      }
		      })
	      }
      });
     
     
  });


</script>






<?php
//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../inc/niltpl.php");



//null-kan
xfree($qbw);
xclose($koneksi);
exit();
?>