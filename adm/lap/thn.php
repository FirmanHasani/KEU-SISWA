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
$filenya = "thn.php";
$judul = "[LAPORAN]. Per Tahun";
$judulku = "$judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$kd = nosql($_REQUEST['kd']);




$limit = 100;














//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//nek excel
if ($_POST['btnEX'])
	{
	//nilai
	$fileku = "lap_per_tahun.xls";



	
	//isi *START
	ob_start();
	

	echo '<div class="table-responsive">
	<h3>LAPORAN PER TAHUN</h3>
	          
	<table class="table" border="1">
	<thead>
	
		<tr valign="top" bgcolor="'.$warnaheader.'">
		<th><strong><font color="'.$warnatext.'">TAHUN</font></strong></th>';
	
	
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
		
		
		echo '<td align="center"><strong><font color="'.$warnatext.'">TOTAL</font></strong></td>';
		echo '</tr>
	
	</thead>
	<tbody>';
	
	
	
	for ($k=$tahun-1;$k<=$tahun;$k++)
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
	
	
	
		
		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>'.$k.'</td>';
		
	
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
												"AND round(DATE_FORMAT(tgl_bayar, '%Y')) = '$k'");
			$tyuk3 = mysqli_num_rows($qyuk3);
	
	
			//nilainya
			$qyuk31 = mysqli_query($koneksi, "SELECT SUM(nilai) AS totalnya ".
												"FROM siswa_bayar ".
												"WHERE jenis = '$yuk2_desa2' ".
												"AND round(DATE_FORMAT(tgl_bayar, '%Y')) = '$k'");
			$ryuk31 = mysqli_fetch_assoc($qyuk31);
			$yuk31_total = balikin($ryuk31['totalnya']);
	
	
			
			//jika ada
			if (!empty($tyuk3))
				{
				$yuk31_totalx = xduit3( $yuk31_total);
				$tyuk3x = "<font color='green'>$tyuk3 SISWA <br>$yuk31_totalx</font>";
				}
			else
				{
				$tyuk3x = "<font color='red'>$tyuk3 SISWA</font>";
				}
	
			
			echo '<td align="center"><strong><font color="'.$warnatext.'">'.$tyuk3x.'</font></strong></td>';
			}
		while ($ryuk2 = mysqli_fetch_assoc($qyuk2));
	
	
	
		//nilainya
		$qyuk3 = mysqli_query($koneksi, "SELECT DISTINCT(siswa_nis) FROM siswa_bayar ".
											"WHERE round(DATE_FORMAT(tgl_bayar, '%Y')) = '$k'");
		$tyuk3 = mysqli_num_rows($qyuk3);
	
	
		//nilainya
		$qyuk31 = mysqli_query($koneksi, "SELECT SUM(nilai) AS totalnya ".
											"FROM siswa_bayar");
		$ryuk31 = mysqli_fetch_assoc($qyuk31);
		$yuk31_total = balikin($ryuk31['totalnya']);
	
				
		//jika ada
		if (!empty($tyuk3))
			{
			$yuk31_totalx = xduit3($yuk31_total);
			$tyuk3x = "<font color='green'>$tyuk3 SISWA <br>$yuk31_totalx</font>";
			}
		else
			{
			$tyuk3x = "<font color='red'>$tyuk3 SISWA</font>";
			}
	
		
		echo '<td align="center"><strong>'.$tyuk3x.'</td>';
	    echo '</tr>';
		}
	
	
	
	echo '</tbody>	
		<tfoot>
	
		<tr valign="top" bgcolor="'.$warnaheader.'">
		<th><strong><font color="'.$warnatext.'">TOTAL</font></strong></th>';
		
		
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
													"WHERE jenis = '$yuk2_desa2'");
				$tyuk3 = mysqli_num_rows($qyuk3);
	
				//nilainya
				$qyuk31 = mysqli_query($koneksi, "SELECT SUM(nilai) AS totalnya ".
													"FROM siswa_bayar ".
													"WHERE jenis = '$yuk2_desa2'");
				$ryuk31 = mysqli_fetch_assoc($qyuk31);
				$yuk31_total = balikin($ryuk31['totalnya']);
	
	
				//jika ada
				if (!empty($tyuk3))
					{
					$yuk31_totalx = xduit3($yuk31_total);
					$tyuk3x = "<font color='white'>$tyuk3 SISWA <br>$yuk31_totalx</font>";
					}
				else
					{
					$tyuk3x = $tyuk3;
					}
	
				
				echo '<td align="center"><strong><font color="'.$warnatext.'">'.$tyuk3x.'</font></strong></td>';
				}
			while ($ryuk2 = mysqli_fetch_assoc($qyuk2));
				
	
	
			//nilainya
			$qyuk3 = mysqli_query($koneksi, "SELECT DISTINCT(siswa_nis) FROM siswa_bayar");
			$tyuk3 = mysqli_num_rows($qyuk3);
	
	
	
			//nilainya
			$qyuk31 = mysqli_query($koneksi, "SELECT SUM(nilai) AS totalnya ".
												"FROM siswa_bayar");
			$ryuk31 = mysqli_fetch_assoc($qyuk31);
			$yuk31_total = balikin($ryuk31['totalnya']);
	
	
			//jika ada
			if (!empty($tyuk3))
				{
				$yuk31_totalx = xduit3($yuk31_total);
				$tyuk3x = "<font color='white'>$tyuk3 SISWA <br>$yuk31_totalx</font>";
				}
			else
				{
				$tyuk3x = $tyuk3;
				}
	
			
			echo '<td align="center"><strong>'.$tyuk3x.'</strong></td>
			</tr>';
	
	
		echo '</tfoot>

	  </table>';
	
	




	
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
require("../../inc/js/jumpmenu.js");
require("../../inc/js/checkall.js");
require("../../inc/js/swap.js");


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>


	<script>
	$(document).ready(function() {
	  		
		$.noConflict();
	    
	});
	</script>
	  
	

<?php
echo '<form action="'.$filenya.'" method="post" name="formx">


<input name="btnEX" type="submit" value="EXPORT EXCEL >>" class="btn btn-danger">


<div class="table-responsive">          
<table class="table" border="1">
<thead>

	<tr valign="top" bgcolor="'.$warnaheader.'">
	<th><strong><font color="'.$warnatext.'">TAHUN</font></strong></th>';


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
	
	
	echo '<td align="center"><strong><font color="'.$warnatext.'">TOTAL</font></strong></td>';
	echo '</tr>

</thead>
<tbody>';



for ($k=$tahun-1;$k<=$tahun;$k++)
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




	echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
	echo '<td>'.$k.'</td>';
	

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
											"AND round(DATE_FORMAT(tgl_bayar, '%Y')) = '$k'");
		$tyuk3 = mysqli_num_rows($qyuk3);


		//nilainya
		$qyuk31 = mysqli_query($koneksi, "SELECT SUM(nilai) AS totalnya ".
											"FROM siswa_bayar ".
											"WHERE jenis = '$yuk2_desa2' ".
											"AND round(DATE_FORMAT(tgl_bayar, '%Y')) = '$k'");
		$ryuk31 = mysqli_fetch_assoc($qyuk31);
		$yuk31_total = balikin($ryuk31['totalnya']);


		
		//jika ada
		if (!empty($tyuk3))
			{
			$yuk31_totalx = xduit3( $yuk31_total);
			$tyuk3x = "<font color='green'>$tyuk3 SISWA <br>$yuk31_totalx</font>";
			}
		else
			{
			$tyuk3x = "<font color='red'>$tyuk3 SISWA</font>";
			}

		
		echo '<td align="center"><strong><font color="'.$warnatext.'">'.$tyuk3x.'</font></strong></td>';
		}
	while ($ryuk2 = mysqli_fetch_assoc($qyuk2));



	//nilainya
	$qyuk3 = mysqli_query($koneksi, "SELECT DISTINCT(siswa_nis) FROM siswa_bayar ".
										"WHERE round(DATE_FORMAT(tgl_bayar, '%Y')) = '$k'");
	$tyuk3 = mysqli_num_rows($qyuk3);


	//nilainya
	$qyuk31 = mysqli_query($koneksi, "SELECT SUM(nilai) AS totalnya ".
										"FROM siswa_bayar");
	$ryuk31 = mysqli_fetch_assoc($qyuk31);
	$yuk31_total = balikin($ryuk31['totalnya']);

			
	//jika ada
	if (!empty($tyuk3))
		{
		$yuk31_totalx = xduit3($yuk31_total);
		$tyuk3x = "<font color='green'>$tyuk3 SISWA <br>$yuk31_totalx</font>";
		}
	else
		{
		$tyuk3x = "<font color='red'>$tyuk3 SISWA</font>";
		}

	
	echo '<td align="center"><strong>'.$tyuk3x.'</td>';
    echo '</tr>';
	}



echo '</tbody>	
	<tfoot>

	<tr valign="top" bgcolor="'.$warnaheader.'">
	<th><strong><font color="'.$warnatext.'">TOTAL</font></strong></th>';
	
	
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
												"WHERE jenis = '$yuk2_desa2'");
			$tyuk3 = mysqli_num_rows($qyuk3);

			//nilainya
			$qyuk31 = mysqli_query($koneksi, "SELECT SUM(nilai) AS totalnya ".
												"FROM siswa_bayar ".
												"WHERE jenis = '$yuk2_desa2'");
			$ryuk31 = mysqli_fetch_assoc($qyuk31);
			$yuk31_total = balikin($ryuk31['totalnya']);


			//jika ada
			if (!empty($tyuk3))
				{
				$yuk31_totalx = xduit3($yuk31_total);
				$tyuk3x = "<font color='white'>$tyuk3 SISWA <br>$yuk31_totalx</font>";
				}
			else
				{
				$tyuk3x = $tyuk3;
				}

			
			echo '<td align="center"><strong><font color="'.$warnatext.'">'.$tyuk3x.'</font></strong></td>';
			}
		while ($ryuk2 = mysqli_fetch_assoc($qyuk2));
			


		//nilainya
		$qyuk3 = mysqli_query($koneksi, "SELECT DISTINCT(siswa_nis) FROM siswa_bayar");
		$tyuk3 = mysqli_num_rows($qyuk3);



		//nilainya
		$qyuk31 = mysqli_query($koneksi, "SELECT SUM(nilai) AS totalnya ".
											"FROM siswa_bayar");
		$ryuk31 = mysqli_fetch_assoc($qyuk31);
		$yuk31_total = balikin($ryuk31['totalnya']);


		//jika ada
		if (!empty($tyuk3))
			{
			$yuk31_totalx = xduit3($yuk31_total);
			$tyuk3x = "<font color='white'>$tyuk3 SISWA <br>$yuk31_totalx</font>";
			}
		else
			{
			$tyuk3x = $tyuk3;
			}

		
		echo '<td align="center"><strong>'.$tyuk3x.'</strong></td>
		</tr>';


	echo '</tfoot>

  </table>





<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
<input name="jml" type="hidden" value="'.$count.'">
</td>
</tr>
</table>


</div>



</form>';


//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../inc/niltpl.php");



//null-kan
xfree($qbw);
xclose($koneksi);
exit();
?>