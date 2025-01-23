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
$filenya = "bayar_excel.php";
$judul = "[PEMBAYARAN] Daftar Pembayaran Siswa";
$judulku = "$judul";
$judulx = $judul;
$kd = nosql($_REQUEST['kd']);
$s = nosql($_REQUEST['s']);
$kunci = cegah($_REQUEST['kunci']);
$kunci2 = balikin($_REQUEST['kunci']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}



$limit = 5;


//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika import
if ($_POST['btnIM'])
	{
	//re-direct
	$ke = "$filenya?s=import";
	xloc($ke);
	exit();
	}












//lama
//import sekarang
if ($_POST['btnIMX'])
	{
	$filex_namex2 = strip(strtolower($_FILES['filex_xls']['name']));

	//nek null
	if (empty($filex_namex2))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		$ke = "$filenya?s=import";
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
			$filex_namex2 = "bayarya.xls";

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
			    // karena data yang di excel di mulai dari baris ke 2
			    // maka jika $i lebih dari 1 data akan di masukan ke database
			    if ($i > 1) 
			    	{
				      // nama ada di kolom A
				      // sedangkan alamat ada di kolom B
				      $i_no = cegah($sheet['A']);
				      $i_tapel = cegah($sheet['B']);
				      $i_kelas = cegah($sheet['C']);
				      $i_swnis = cegah($sheet['D']);
				      $i_swnama = cegah($sheet['E']);
				      $i_jenis = cegah($sheet['F']);
				      $i_cara = cegah($sheet['G']);
					  
				      $i_tgl = balikin($sheet['H']);
					  
					  
					  
				      $i_nilai = cegah($sheet['I']);
				      $i_ket = cegah($sheet['J']);
					  $i_swkd = md5("$i_swnis$i_swnama");

				      $i_xyz = md5("$i_swnis$i_tapel$i_kelas$i_jenis$i_cara$i_tgl");
					  


					//insert
					mysqli_query($koneksi, "INSERT INTO siswa_bayar(kd, siswa_kd, siswa_nis, siswa_nama, ".
											"tapel, kelas, jenis, cara_bayar, ".
											"tgl_bayar, nilai, ket, postdate) VALUES ".
											"('$i_xyz', '$i_swkd', '$i_swnis', '$i_swnama', ".
											"'$i_tapel', '$i_kelas', '$i_jenis', '$i_cara', ".
											"'$i_tgl', '$i_nilai', '$i_ket', '$today')");
				    }
			
			    $i++;
			  }





			//hapus file, jika telah import
			$path1 = "../../filebox/excel/$filex_namex2";
			chmod($path1,0777);
			unlink ($path1);




			//re-direct
			xloc($filenya);
			exit();
			}
		else
			{
			//salah
			$pesan = "Bukan File .xls . Harap Diperhatikan...!!";
			$ke = "$filenya?s=import";
			pekem($pesan,$ke);
			exit();
			}
		}
	}











//jika export
//export
if ($_POST['btnEX'])
	{
	//require
	require('../../inc/class/excel/OLEwriter.php');
	require('../../inc/class/excel/BIFFwriter.php');
	require('../../inc/class/excel/worksheet.php');
	require('../../inc/class/excel/workbook.php');


	
	//nama file e...
	$i_filename = "data_pembayaran_siswa.xls";
	$i_judul = "siswa_bayar";
	
	
	
	
	//header file
	function HeaderingExcel($i_filename)
		{
		header("Content-type:application/vnd.ms-excel");
		header("Content-Disposition:attachment;filename=$i_filename");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
		header("Pragma: public");
		}
	
	
	
	
	//bikin...
	HeaderingExcel($i_filename);
	$workbook = new Workbook("-");
	$worksheet1 =& $workbook->add_worksheet($i_judul);
	$worksheet1->write_string(0,0,"NO.");
	$worksheet1->write_string(0,1,"TAPEL");
	$worksheet1->write_string(0,2,"KELAS");
	$worksheet1->write_string(0,3,"NIS");
	$worksheet1->write_string(0,4,"NAMA");
	$worksheet1->write_string(0,5,"JENIS");
	$worksheet1->write_string(0,6,"CARA_BAYAR");
	$worksheet1->write_string(0,7,"TGL_BAYAR");
	$worksheet1->write_string(0,8,"NOMINAL");
	$worksheet1->write_string(0,9,"KETERANGAN");
	$worksheet1->write_string(0,10,"POSTDATE_ENTRI");
	
	
	//data
	$qdt = mysqli_query($koneksi, "SELECT * FROM siswa_bayar ".
										"ORDER BY postdate DESC");
	$rdt = mysqli_fetch_assoc($qdt);
	
	do
		{
		//nilai
		$dt_nox = $dt_nox + 1;
		$i_tapel = balikin($rdt['tapel']);
		$i_kelas = balikin($rdt['kelas']);
		$i_nis = balikin($rdt['siswa_nis']);
		$i_nama = balikin($rdt['siswa_nama']);
		$i_jenis = balikin($rdt['jenis']);
		$i_cara_bayar = balikin($rdt['cara_bayar']);
		$i_tgl_bayar = balikin($rdt['tgl_bayar']);
		$i_nominal = balikin($rdt['nilai']);
		$i_ket = balikin($rdt['ket']);
		$i_postdate = balikin($rdt['postdate']);
	
	
	
	
		//ciptakan
		$worksheet1->write_string($dt_nox,0,$dt_nox);
		$worksheet1->write_string($dt_nox,1,$i_tapel);
		$worksheet1->write_string($dt_nox,2,$i_kelas);
		$worksheet1->write_string($dt_nox,3,$i_nis);
		$worksheet1->write_string($dt_nox,4,$i_nama);
		$worksheet1->write_string($dt_nox,5,$i_jenis);
		$worksheet1->write_string($dt_nox,6,$i_cara_bayar);
		$worksheet1->write_string($dt_nox,7,$i_tgl_bayar);
		$worksheet1->write_string($dt_nox,8,$i_nominal);
		$worksheet1->write_string($dt_nox,9,$i_ket);
		$worksheet1->write_string($dt_nox,10,$i_postdate);
		}
	while ($rdt = mysqli_fetch_assoc($qdt));


	//close
	$workbook->close();

	
	
	//re-direct
	xloc($filenya);
	exit();
	}








//nek batal
if ($_POST['btnBTL'])
	{
	//re-direct
	xloc($filenya);
	exit();
	}





//jika cari
if ($_POST['btnCARI'])
	{
	//nilai
	$kunci = cegah($_POST['kunci']);


	//re-direct
	$ke = "$filenya?kunci=$kunci";
	xloc($ke);
	exit();
	}




//nek entri baru
if ($_POST['btnBARU'])
	{
	//re-direct
	$ke = "bayar.php";
	xloc($ke);
	exit();
	}





//jika hapus
if ($_POST['btnHPS'])
	{
	//ambil nilai
	$jml = nosql($_POST['jml']);
	$page = nosql($_POST['page']);
	$ke = "$filenya?page=$page";

	//ambil semua
	for ($i=1; $i<=$jml;$i++)
		{
		//ambil nilai
		$yuk = "item";
		$yuhu = "$yuk$i";
		$kd = nosql($_POST["$yuhu"]);

		//del
		mysqli_query($koneksi, "DELETE FROM siswa_bayar ".
						"WHERE kd = '$kd'");
		}

	//auto-kembali
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
	//jika null
	if (empty($kunci))
		{
		$sqlcount = "SELECT * FROM siswa_bayar ".
						"ORDER BY postdate DESC";
		}
		
	else
		{
		$sqlcount = "SELECT * FROM siswa_bayar ".
						"WHERE tapel LIKE '%$kunci%' ".
						"OR kelas LIKE '%$kunci%' ".
						"OR siswa_nis LIKE '%$kunci%' ".
						"OR siswa_nama LIKE '%$kunci%' ".
						"OR jenis LIKE '%$kunci%' ".
						"OR cara_bayar LIKE '%$kunci%' ".
						"OR tgl_bayar LIKE '%$kunci%' ".
						"OR nilai LIKE '%$kunci%' ".
						"OR ket LIKE '%$kunci%' ".
						"OR postdate LIKE '%$kunci%' ".
						"ORDER BY postdate DESC";
		}
		
	
	//query
	$p = new Pager();
	$start = $p->findStart($limit);
	
	$sqlresult = $sqlcount;
	
	$count = mysqli_num_rows(mysqli_query($koneksi, $sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysqli_fetch_array($result);
	
	
	
	echo '<form action="'.$filenya.'" method="post" name="formxx">
	<p>
	<input name="btnBARU" type="submit" value="Masukkan BARU" class="btn btn-danger">
	<input name="btnIM" type="submit" value="Masukkan EXCEL" class="btn btn-primary">
	<input name="btnEX" type="submit" value="Cetak EXCEL" class="btn btn-success">
	</p>
	<br>
	
	</form>



	<form action="'.$filenya.'" method="post" name="formx">
	<p>
	<input name="kunci" type="text" value="'.$kunci2.'" size="20" class="btn btn-warning" placeholder="Kata Kunci...">
	<input name="btnCARI" type="submit" value="CARI" class="btn btn-danger">
	<input name="btnBTL" type="submit" value="RESET" class="btn btn-info">
	</p>
		
	
	<div class="table-responsive">          
	<table class="table" border="1">
	<thead>
	
	<tr valign="top" bgcolor="'.$warnaheader.'">
	<td width="20">&nbsp;</td>
	<td width="50"><strong><font color="'.$warnatext.'">POSTDATE_ENTRI</font></strong></td>
	<td width="100"><strong><font color="'.$warnatext.'">TAPEL</font></strong></td>
	<td width="100"><strong><font color="'.$warnatext.'">KELAS</font></strong></td>
	<td width="50"><strong><font color="'.$warnatext.'">NIS</font></strong></td>
	<td><strong><font color="'.$warnatext.'">NAMA</font></strong></td>
	<td width="50"><strong><font color="'.$warnatext.'">JENIS</font></strong></td>
	<td width="50"><strong><font color="'.$warnatext.'">CARA_BAYAR</font></strong></td>
	<td width="50"><strong><font color="'.$warnatext.'">TGL_BAYAR</font></strong></td>
	<td width="150"><strong><font color="'.$warnatext.'">NOMINAL</font></strong></td>
	<td width="150"><strong><font color="'.$warnatext.'">KETERANGAN</font></strong></td>
	</tr>
	</thead>
	<tbody>';
	
	if ($count != 0)
		{
		do 
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
	
			$nomer = $nomer + 1;
			$i_kd = nosql($data['kd']);
			$i_tapel = balikin($data['tapel']);
			$i_kelas = balikin($data['kelas']);
			$i_nis = balikin($data['siswa_nis']);
			$i_nama = balikin($data['siswa_nama']);
			$i_jenis = balikin($data['jenis']);
			$i_cara_bayar = balikin($data['cara_bayar']);
			$i_tgl_bayar = balikin($data['tgl_bayar']);
			$i_nilai = balikin($data['nilai']);
			$i_ket = balikin($data['ket']);
			$i_postdate = balikin($data['postdate']);


			
			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>
			<input type="checkbox" name="item'.$nomer.'" value="'.$i_kd.'">
	        </td>
			<td>'.$i_postdate.'</td>
			<td>'.$i_tapel.'</td>
			<td>'.$i_kelas.'</td>
			<td>'.$i_nis.'</td>
			<td>'.$i_nama.'</td>
			<td>'.$i_jenis.'</td>
			<td>'.$i_cara_bayar.'</td>
			<td>'.$i_tgl_bayar.'</td>
			<td align="right">'.xduit3($i_nilai).'</td>
			<td>'.$i_ket.'</td>
	        </tr>';
			}
		while ($data = mysqli_fetch_assoc($result));
		}
	
	
	echo '</tbody>
	  </table>
	  </div>
	
	
	<table width="100%" border="0" cellspacing="0" cellpadding="3">
	<tr>
	<td>
	<strong><font color="#FF0000">'.$count.'</font></strong> Data. '.$pagelist.'
	<br>
	<br>

	<input name="jml" type="hidden" value="'.$count.'">
	<input name="s" type="hidden" value="'.$s.'">
	<input name="kd" type="hidden" value="'.$kdx.'">
	<input name="page" type="hidden" value="'.$page.'">
	
	<input name="btnALL" type="button" value="SEMUA" onClick="checkAll('.$count.')" class="btn btn-primary">
	<input name="btnBTL" type="reset" value="BATAL" class="btn btn-warning">
	<input name="btnHPS" type="submit" value="HAPUS" class="btn btn-danger">
	</td>
	</tr>
	</table>
	</form>';
	}








//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../inc/niltpl.php");


//null-kan
xclose($koneksi);
exit();
?>