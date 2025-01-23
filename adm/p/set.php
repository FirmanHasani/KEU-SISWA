<?php
session_start();

require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/adm.php");
$tpl = LoadTpl("../../template/adm.html");

nocache;

//nilai
$filenya = "set.php";
$judul = "Set Nominal";
$judul = "[PENAGIHAN SISWA]. Set Nominal";
$judulku = "$judul";
$judulx = $judul;
$uthn = cegah($_REQUEST['uthn']);
$ukelas = cegah($_REQUEST['ukelas']);

$s = nosql($_REQUEST['s']);
$kunci = cegah($_REQUEST['kunci']);
$kunci2 = balikin($_REQUEST['kunci']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}



//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika import
if ($_POST['btnIM'])
	{
	//nilai
	$uthn = balikin($_POST['uthn']);
	$uthn2 = cegah($_POST['uthn']);
	$ukelas = balikin($_POST['ukelas']);
	$ukelas2 = cegah($_POST['ukelas']);
	
	//re-direct
	$ke = "$filenya?uthn=$uthn2&ukelas=$ukelas2&s=import";
	xloc($ke);
	exit();
	}












//import sekarang
if ($_POST['btnIMX'])
	{
	//nilai
	$uthn = balikin($_POST['uthn']);
	$uthn2 = cegah($_POST['uthn']);
	$ukelas = balikin($_POST['ukelas']);
	$ukelas2 = cegah($_POST['ukelas']);
		
	$filex_namex2 = strip(strtolower($_FILES['filex_xls']['name']));

	//nek null
	if (empty($filex_namex2))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		$ke = "$filenya?uthn=$uthn2&ukelas=$ukelas2&s=import";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//deteksi .xls
		$ext_filex = substr($filex_namex2, -4);

		if ($ext_filex == ".xls")
			{
			//nilai
			$path1 = "../../filebox";
			$path2 = "../../filebox/excel";
			chmod($path1,0777);
			chmod($path2,0777);

			//nama file import, diubah menjadi baru...
			$filex_namex2 = "setnya.xls";

			//mengkopi file
			copy($_FILES['filex_xls']['tmp_name'],"../../filebox/excel/$filex_namex2");

			//chmod
            $path3 = "../../filebox/excel/$filex_namex2";
			chmod($path1,0755);
			chmod($path2,0777);
			chmod($path3,0777);

			//file-nya...
			$uploadfile = $path3;





			//require
			require('../../inc/class/PHPExcel.php');
			require('../../inc/class/PHPExcel/IOFactory.php');


			  // load excel
			  $load = PHPExcel_IOFactory::load($uploadfile);
			  $sheets = $load->getActiveSheet()->toArray(null,true,true,true);
			
			  $i = 1;
			  foreach ($sheets as $sheet) 
			  	{
			    // karena data yang di excel di mulai dari baris ke 4
			    // maka jika $i lebih dari 1 data akan di masukan ke database
			    if ($i > 3) 
			    	{
				      // nilai
				      $i_bulan = cegah($sheet['A']);
				      $i_tahun = cegah($sheet['B']);
				      $i_kol1 = cegah($sheet['C']);
				      $i_kol2 = cegah($sheet['D']);
				      $i_kol3 = cegah($sheet['E']);
				      $i_kol4 = cegah($sheet['F']);
				      $i_kol5 = cegah($sheet['G']);
				      $i_kol6 = cegah($sheet['H']);


					  $inirand1 = "1";
					  $inirand2 = "2";
					  $inirand3 = "3";
					  $inirand4 = "4";
					  $inirand5 = "5";
					  $inirand6 = "6";					  
				      $i_xyz = md5("$ukelas$i_tahun$i_bulan$inirand1");
				      $i_xyz2 = md5("$ukelas$i_tahun$i_bulan$inirand2");
				      $i_xyz3 = md5("$ukelas$i_tahun$i_bulan$inirand3");
				      $i_xyz4 = md5("$ukelas$i_tahun$i_bulan$inirand4");
				      $i_xyz5 = md5("$ukelas$i_tahun$i_bulan$inirand5");
				      $i_xyz6 = md5("$ukelas$i_tahun$i_bulan$inirand6");
					  
					  


					//insert
					$ujenis = "ANTAR JEMPUT";
					mysqli_query($koneksi, "INSERT INTO m_set_nominal(kd, tapel, kelas, ".
											"jenis, bulan, tahun, nominal, postdate) VALUES ".
											"('$i_xyz', '$uthn2', '$ukelas2', ".
											"'$ujenis', '$i_bulan', '$i_tahun', '$i_kol1', '$today')");

					
					//insert
					$ujenis = "BUKU PAKET";
					mysqli_query($koneksi, "INSERT INTO m_set_nominal(kd, tapel, kelas, ".
											"jenis, bulan, tahun, nominal, postdate) VALUES ".
											"('$i_xyz2', '$uthn2', '$ukelas2', ".
											"'$ujenis', '$i_bulan', '$i_tahun', '$i_kol2', '$today')");
					  


					
					//insert
					$ujenis = "KEGIATAN";
					mysqli_query($koneksi, "INSERT INTO m_set_nominal(kd, tapel, kelas, ".
											"jenis, bulan, tahun, nominal, postdate) VALUES ".
											"('$i_xyz3', '$uthn2', '$ukelas2', ".
											"'$ujenis', '$i_bulan', '$i_tahun', '$i_kol3', '$today')");



					//insert
					$ujenis = "SPI xkkurixPEMBANGUNANxkkurnanx";
					mysqli_query($koneksi, "INSERT INTO m_set_nominal(kd, tapel, kelas, ".
											"jenis, bulan, tahun, nominal, postdate) VALUES ".
											"('$i_xyz4', '$uthn2', '$ukelas2', ".
											"'$ujenis', '$i_bulan', '$i_tahun', '$i_kol4', '$today')");


					//insert
					$ujenis = "SYAHRIYAH";
					mysqli_query($koneksi, "INSERT INTO m_set_nominal(kd, tapel, kelas, ".
											"jenis, bulan, tahun, nominal, postdate) VALUES ".
											"('$i_xyz5', '$uthn2', '$ukelas2', ".
											"'$ujenis', '$i_bulan', '$i_tahun', '$i_kol5', '$today')");


					//insert
					$ujenis = "TABUNGAN";
					mysqli_query($koneksi, "INSERT INTO m_set_nominal(kd, tapel, kelas, ".
											"jenis, bulan, tahun, nominal, postdate) VALUES ".
											"('$i_xyz6', '$uthn2', '$ukelas2', ".
											"'$ujenis', '$i_bulan', '$i_tahun', '$i_kol6', '$today')");

					  
				    }
			
			    $i++;
			  }





			//hapus file, jika telah import
			$path1 = "../../filebox/excel/$filex_namex2";
			chmod($path1,0777);
			unlink ($path1);


			//re-direct
			$ke = "$filenya?uthn=$uthn2&ukelas=$ukelas2";
			xloc($ke);
			exit();
			}
		else
			{
			//salah
			$pesan = "Bukan File .xls . Harap Diperhatikan...!!";
			$ke = "$filenya?uthn=$uthn2&ukelas=$ukelas2&s=import";
			pekem($pesan,$ke);
			exit();
			}
		}
	}
















//nek excel
if ($_POST['btnEX'])
	{
	//nilai
	$uthn = balikin($_POST['uthn']);
	$uthn2 = cegah($_POST['uthn']);
	$ukelas = balikin($_POST['ukelas']);
	$ukelas2 = cegah($_POST['ukelas']);
	$fileku = "set_nominal-$uthn-$ukelas.xls";



	
	//isi *START
	ob_start();
	

	

	echo '<div class="table-responsive">
	<h3>SET NOMINAL PER KELAS '.$ukelas.', '.$uthn.'</h3>
         
	<div class="table-responsive">          
	<table class="table" border="1">
	<thead>
	
	<tr valign="top" bgcolor="'.$warnaheader.'">
	<td width="50"><strong><font color="'.$warnatext.'">BULAN</font></strong></td>
	<td width="50"><strong><font color="'.$warnatext.'">TAHUN</font></strong></td>';


	//list 
	$qyuk2 = mysqli_query($koneksi, "SELECT * FROM m_cara_bayar ".
										"ORDER BY nama ASC");
	$ryuk2 = mysqli_fetch_assoc($qyuk2);
	
	do
		{
		//nilai
		$yuk2_desa = balikin($ryuk2['nama']);
		
		
		echo '<td align="center" width="100"><strong><font color="'.$warnatext.'">'.$yuk2_desa.'</font></strong></td>';
		}
	while ($ryuk2 = mysqli_fetch_assoc($qyuk2));
	
	echo '</tr>
	</thead>
	<tbody>';
	
	for ($k=1;$k<=12;$k++) 
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


		//tapel
		$uthnxx = balikin($uthn);
		$uthn1x = explode("/", $uthnxx); 
		$uthn1x1 = balikin($uthn1x[0]); 
		$uthn1x2 = balikin($uthn1x[1]); 
	
	
		
		//jika smt ganjil
		if ($k <= 6)
			{
			$kk = $k + 6;
			$bulanku = $arrbln[$kk];
			$tahunku = $uthn1x1;
			}
			
		else if ($k>6)
			{
			$kk = $k - 6;
			$bulanku = $arrbln[$kk];
			$tahunku = $uthn1x2;
			}

	
	
		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>'.$kk.'</td>
		<td>'.$tahunku.'</td>';
	
	
		//list 
		$qyuk2 = mysqli_query($koneksi, "SELECT * FROM m_cara_bayar ".
											"ORDER BY nama ASC");
		$ryuk2 = mysqli_fetch_assoc($qyuk2);
		
		do
			{
			//nilai
			$yuk2_kd = balikin($ryuk2['kd']);
			$yuk2_nama = cegah($ryuk2['nama']);
	
	
	
			//nilai
			$qcc = mysqli_query($koneksi, "SELECT * FROM m_set_nominal ".
												"WHERE tapel = '$uthn2' ".
												"AND kelas = '$ukelas2' ".
												"AND jenis = '$yuk2_nama' ".
												"AND bulan = '$kk'");
			$rcc = mysqli_fetch_assoc($qcc);
			$cc_nilai = balikin($rcc['nominal']);
	
	
			
			echo '<td align="right">
			'.$cc_nilai.'
			</td>';
			}
		while ($ryuk2 = mysqli_fetch_assoc($qyuk2));
			
						
	    echo '</tr>';
		}
	
	
	


	
	echo '</tbody>
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















//jika simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$uthn = cegah($_POST['uthn']);
	$ukelas = cegah($_POST['ukelas']);


	//daftar bulan
	for ($k=1;$k<=12;$k++) 
		{
		//tapel
		$uthnxx = balikin($uthn);
		$uthn1x = explode("/", $uthnxx); 
		$uthn1x1 = balikin($uthn1x[0]); 
		$uthn1x2 = balikin($uthn1x[1]); 



		//jika smt.ganjil
		if ($k <= 6)
			{
			$kk = $k + 6;
			$utahun = $uthn1x2;
			}
			
		else if ($k > 6)
			{
			$kk = $k - 6;
			$utahun = $uthn1x1;
			}






		//list jenis
		$qku = mysqli_query($koneksi, "SELECT * FROM m_cara_bayar ".
										"ORDER BY nama ASC");
		$rku = mysqli_fetch_assoc($qku);

		do
			{
			//nilai
			$ku_no = $ku_no + 1;
			$ku_kd = balikin($rku['kd']);
			$ku_nama = balikin($rku['nama']);
			$ku_nama2 = cegah($rku['nama']);
	
	
			
			//ambil nilai
			//$xyz = md5("$uthn$k$ku_kd");
		
		
			//jika 1
			if ($ku_no == "1")
				{
				$inirand1 = "1";
				$xyz = md5("$ukelas$utahun$kk$inirand1");
				}
				
		
			//jika 2
			else if ($ku_no == "2")
				{
				$inirand1 = "2";
				$xyz = md5("$ukelas$utahun$kk$inirand1");
				}
				
				
			//jika 3
			else if ($ku_no == "3")
				{
				$inirand1 = "3";
				$xyz = md5("$ukelas$utahun$kk$inirand1");
				}
				
		
				
				
					  
					  
					  
					  
		
		
			$xnkomite = "xnilku";
			$xnkomite1 = "$k$xnkomite$ku_kd";
			$xnkomitexx = nosql($_POST["$xnkomite1"]);
	
	
	
			//cek
			$qcc = mysqli_query($koneksi, "SELECT * FROM m_set_nominal ".
												"WHERE tapel = '$uthn' ".
												"AND kelas = '$ukelas' ".
												"AND jenis = '$ku_nama2' ".
												"AND bulan = '$k' ".
												"AND tahun = '$utahun'");
			$rcc = mysqli_fetch_assoc($qcc);
			$tcc = mysqli_num_rows($qcc);
	
			//nek ada
			if (!empty($tcc))
				{
				///update
				mysqli_query($koneksi, "UPDATE m_set_nominal SET nominal = '$xnkomitexx' ".
											"WHERE tapel = '$uthn' ".
											"AND kelas = '$ukelas' ".
											"AND jenis = '$ku_nama2' ".
											"AND bulan = '$k' ".
											"AND tahun = '$utahun'");
				}
			else
				{
				//baru
				mysqli_query($koneksi, "INSERT INTO m_set_nominal (kd, tapel, kelas, ".
											"jenis, bulan, tahun, nominal, postdate) VALUES ".
											"('$xyz', '$uthn', '$ukelas', ".
											"'$ku_nama2', '$k', '$utahun', '$xnkomitexx', '$today')");
				}
				
				


			}
		while ($rku = mysqli_fetch_assoc($qku));
		}




	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	$ke = "$filenya?uthn=$uthn&ukelas=$ukelas";
	xloc($ke);
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
require("../../inc/js/number.js");
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


echo '<div class="row">
	<div class="col-md-12">';
	
	echo "<p>
	Tahun Pelajaran : 
	<br>
	<select name=\"ublnx\" onChange=\"MM_jumpMenu('self',this,0)\" class=\"btn btn-warning\">";
	echo '<option value="'.$uthn.'" selected>'.balikin($uthn).'</option>';
	
	
	//list 
	$qyuk2 = mysqli_query($koneksi, "SELECT * FROM m_tapel ".
										"ORDER BY tahun1 ASC, ".
										"tahun2 ASC");
	$ryuk2 = mysqli_fetch_assoc($qyuk2);
	
	do
		{
		//nilai
		$yuk2_tahun1 = balikin($ryuk2['tahun1']);
		$yuk2_tahun2 = balikin($ryuk2['tahun2']);
		$yuk2_tahunx = "$yuk2_tahun1/$yuk2_tahun2";
		
		
		echo '<option value="'.$filenya.'?uthn='.$yuk2_tahunx.'">'.$yuk2_tahunx.'</option>';
		}
	while ($ryuk2 = mysqli_fetch_assoc($qyuk2));

	echo '</select>, 
	
	Kelas : ';
	echo "<select name=\"ublnx2\" onChange=\"MM_jumpMenu('self',this,0)\" class=\"btn btn-warning\">";
	echo '<option value="'.$ukelas.'" selected>'.balikin($ukelas).'</option>';
	
	
	//list 
	$qyuk2 = mysqli_query($koneksi, "SELECT DISTINCT(kelas) AS kelasnya ".
										"FROM m_siswa ".
										"ORDER BY kelas ASC");
	$ryuk2 = mysqli_fetch_assoc($qyuk2);
	
	do
		{
		//nilai
		$yuk2_kelasnya = balikin($ryuk2['kelasnya']);
		
		
		echo '<option value="'.$filenya.'?uthn='.$uthn.'&ukelas='.$yuk2_kelasnya.'">'.$yuk2_kelasnya.'</option>';
		}
	while ($ryuk2 = mysqli_fetch_assoc($qyuk2));

	echo '</select>
	</p>		

	
	
	</div>
</div>

<hr>';


if (empty($uthn))
	{
	echo '<font color="red">
	<h3>TAHUN Belum Dipilih...!!</h3>
	</font>';
	}


else if (empty($ukelas))
	{
	echo '<font color="red">
	<h3>KELAS Belum Dipilih...!!</h3>
	</font>';
	}
	
else
	{
	//jika import
	if ($s == "import")
		{
		?>
		<div class="row">
	
		<div class="col-md-12">
			
		<?php
		echo '<form action="'.$filenya.'" method="post" enctype="multipart/form-data" name="formxx2">
		<p>
			<input name="filex_xls" type="file" size="30" class="btn btn-warning">
		</p>
	
		<p>
			<input name="ukelas" type="hidden" value="'.$ukelas.'">
			<input name="uthn" type="hidden" value="'.$uthn.'">
			<input name="btnBTL" type="submit" value="BATAL" class="btn btn-info">
			<input name="btnIMX" type="submit" value="IMPORT >>" class="btn btn-danger">
		</p>
		
		
		</form>';	
		?>
			
	
	
		</div>
		
		</div>
	
	
		<?php
		}
	
	
	
	else
		{
		echo '<form action="'.$filenya.'" method="post" name="formx2">
		
		<input name="ukelas" type="hidden" value="'.$ukelas.'">
		<input name="uthn" type="hidden" value="'.$uthn.'">
		<input name="btnIM" type="submit" value="IMPORT EXCEL >>" class="btn btn-primary">
		<input name="btnEX" type="submit" value="EXPORT EXCEL >>" class="btn btn-danger">
		
		</form>
		
		
		<form action="'.$filenya.'" method="post" name="formx">
		<div class="table-responsive">          
		<table class="table" border="1">
		<thead>
		
		<tr valign="top" bgcolor="'.$warnaheader.'">
		<td width="200"><strong><font color="'.$warnatext.'">BULAN</font></strong></td>';
	
	
		//list 
		$qyuk2 = mysqli_query($koneksi, "SELECT * FROM m_cara_bayar ".
											"ORDER BY nama ASC");
		$ryuk2 = mysqli_fetch_assoc($qyuk2);
		
		do
			{
			//nilai
			$yuk2_desa = balikin($ryuk2['nama']);
			
			
			echo '<td align="center" width="100"><strong><font color="'.$warnatext.'">'.$yuk2_desa.'</font></strong></td>';
			}
		while ($ryuk2 = mysqli_fetch_assoc($qyuk2));
		
		echo '</tr>
		</thead>
		<tbody>';
		
		for ($k=1;$k<=12;$k++) 
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
	
	
			//tapel
			$uthnxx = balikin($uthn);
			$uthn1x = explode("/", $uthnxx); 
			$uthn1x1 = balikin($uthn1x[0]); 
			$uthn1x2 = balikin($uthn1x[1]); 
		
		
			
			//jika smt ganjil
			if ($k <= 6)
				{
				$kk = $k + 6;
				$bulanku = $arrbln[$kk];
				$tahunku = $uthn1x1;
				}
				
			else if ($k>6)
				{
				$kk = $k - 6;
				$bulanku = $arrbln[$kk];
				$tahunku = $uthn1x2;
				}
	
		
		
			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>'.$bulanku.' '.$tahunku.'</td>';
		
		
			//list 
			$qyuk2 = mysqli_query($koneksi, "SELECT * FROM m_cara_bayar ".
												"ORDER BY nama ASC");
			$ryuk2 = mysqli_fetch_assoc($qyuk2);
			
			do
				{
				//nilai
				$yuk2_kd = balikin($ryuk2['kd']);
				$yuk2_nama = cegah($ryuk2['nama']);
		
		
		
				//nilai
				$qcc = mysqli_query($koneksi, "SELECT * FROM m_set_nominal ".
													"WHERE tapel = '$uthn' ".
													"AND kelas = '$ukelas' ".
													"AND jenis = '$yuk2_nama' ".
													"AND bulan = '$kk'");
				$rcc = mysqli_fetch_assoc($qcc);
				$cc_nilai = balikin($rcc['nominal']);
		
		
				
				echo '<td align="center">
				Rp.<input name="'.$kk.'xnilku'.$yuk2_kd.'" type="text" value="'.$cc_nilai.'" size="10" class="btn btn-warning" style="text-align:right" onKeyPress="return numbersonly(this, event)" required>,-
				</td>';
				}
			while ($ryuk2 = mysqli_fetch_assoc($qyuk2));
				
							
		    echo '</tr>';
			}
		
		
		
	
	
		
		echo '</tbody>
		  </table>
		  
		  
			<input name="ukelas" type="hidden" value="'.$ukelas.'">
			<input name="uthn" type="hidden" value="'.$uthn.'">
			<input name="btnSMP" type="submit" value="SIMPAN >>" class="btn btn-block btn-danger">
		  </div>';

		echo '</form>';	
		}
	}




//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../inc/niltpl.php");


//null-kan
xclose($koneksi);
exit();
?>