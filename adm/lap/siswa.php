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
$filenya = "siswa.php";
$judul = "[LAPORAN]. Per Siswa";
$judulku = "$judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
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
require("../../inc/js/jumpmenu.js");
require("../../inc/js/checkall.js");
require("../../inc/js/swap.js");


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<div class="row">
	<div class="col-md-12">

	<form action="'.$filenya.'" method="post" name="formx2">

		<p>
		SISWA :
		<br> 
		<input type="text" name="kunci" id="kunci" class="btn btn-warning" placeholder="Nama Siswa" value="'.$e_swnamax.'" required>
		<input type="hidden" name="e_swkd" id="e_swkd" value="'.$e_swkd.'">

		<input name="s" type="hidden" value="'.$s.'">
		<input name="kd" type="hidden" value="'.$kdx.'">
		<input name="page" type="hidden" value="'.$page.'">
		
		<input name="btnSMP" type="submit" value="LANJUT >>" class="btn btn-danger">
		</p>
		
		</form>
		
	</div>
</div>';



//jika entri
if ($s == "entri")
	{
	echo '<hr>
	<div class="row">
		<div class="col-md-12">
		<form action="'.$filenya.'" method="post" name="formx3">
		
		
		
			<p>
			Tahun Pelajaran, Kelas :
			<br>
			<b>'.$swtapelx.', '.$swkelasx.'</b>
			</p>
			
			


	
			<input name="s" type="hidden" value="'.$s.'">
			<input name="sukd" type="hidden" value="'.$sukd.'">
			<input name="swkd" type="hidden" value="'.$swkd.'">
			<input name="swnama" type="hidden" value="'.$swnama.'">
			<input name="swnis" type="hidden" value="'.$swnis.'">
			<input name="swtapel" type="hidden" value="'.$swtapel.'">
			<input name="swkelas" type="hidden" value="'.$swkelas.'">';



		
			//daftar 
			$qbt = mysqli_query($koneksi, "SELECT * FROM m_siswa ".
												"WHERE tapel = '$swtapel' ".
												"AND kelas = '$swkelas' ".
												"AND kd = '$swkd' ".
												"ORDER BY nama ASC");
			$rowbt = mysqli_fetch_assoc($qbt);
			$tbt = mysqli_num_rows($qbt);
		
			

				//ketahui update terakhir
				$qyuk = mysqli_query($koneksi, "SELECT * FROM siswa_bayar ".
													"WHERE tapel = '$swtapel' ".
													"AND kelas = '$swkelas' ".
													"AND siswa_nis = '$swnis' ".
													"ORDER BY postdate DESC");
				$ryuk = mysqli_fetch_assoc($qyuk);
				$yuk_postdate = balikin($ryuk['postdate']);
			
		
		
		
		
				$xtapelku = explode("xgmringx", $swtapel);
				$xtapel1 = trim($xtapelku[0]);
				$xtapel2 = trim($xtapelku[1]);
				
			
			
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
					echo '<td valign="top"><b>'.$ku_nama.'</b></td>';
						
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
														"AND tapel = '$swtapel' ".
														"AND kelas = '$swkelas' ".
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
													"AND tapel = '$swtapel' ".
													"AND kelas = '$swkelas' ".
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
						echo '<td valign="top"><b>'.$ku_nama.'</b></td>';
							
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
															"AND tapel = '$swtapel' ".
															"AND kelas = '$swkelas' ".
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
														"AND tapel = '$swtapel' ".
														"AND kelas = '$swkelas' ".
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
					echo '<td valign="top" bgcolor="orange"><b>TOTAL</b></td>';
						
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
														"AND tapel = '$swtapel' ".
														"AND kelas = '$swkelas' ".
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
													"AND tapel = '$swtapel' ".
													"AND kelas = '$swkelas'");
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
			

				echo '</tbody>
				</table>
				
				
				
				
				</div>
			
				<input name="tapel" type="hidden" value="'.$tapel.'">
				<input name="tapel2" type="hidden" value="'.$tapel2.'">


			
		
			</form>
			
		</div>
		

	</div>';
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