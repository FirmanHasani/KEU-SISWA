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
$filenya = "history.php";
$judul = "Per History Entri";
$judul = "[LAPORAN]. Per History Entri";
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











//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
//jika null
if (empty($kunci))
	{
	$sqlcount = "SELECT * FROM siswa_uang ".
					"ORDER BY postdate DESC";
	}
	
else
	{
	$sqlcount = "SELECT * FROM siswa_uang ".
					"WHERE siswa_nis LIKE '%$kunci%' ".
					"OR siswa_nama LIKE '%$kunci%' ".
					"OR kelas LIKE '%$kunci%' ".
					"OR tapel LIKE '%$kunci%' ".
					"OR nilai LIKE '%$kunci%' ".
					"OR jenis LIKE '%$kunci%' ".
					"OR cara_bayar LIKE '%$kunci%' ".
					"OR ket LIKE '%$kunci%' ".
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



echo '<form action="'.$filenya.'" method="post" name="formx">
<p>
<input name="kunci" type="text" value="'.$kunci2.'" size="20" class="btn btn-warning" placeholder="Kata Kunci...">
<input name="btnCARI" type="submit" value="CARI" class="btn btn-danger">
<input name="btnBTL" type="submit" value="RESET" class="btn btn-info">
</p>
	

<div class="table-responsive">          
<table class="table" border="1">
<thead>

<tr valign="top" bgcolor="'.$warnaheader.'">
<td width="100"><strong><font color="'.$warnatext.'">POSTDATE</font></strong></td>
<td><strong><font color="'.$warnatext.'">SISWA</font></strong></td>
<td><strong><font color="'.$warnatext.'">KETERANGAN</font></strong></td>
<td><strong><font color="'.$warnatext.'">JENIS</font></strong></td>
<td><strong><font color="'.$warnatext.'">CARA BAYAR</font></strong></td>
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
		$i_postdate = balikin($data['postdate']);
		$i_swnis = balikin($data['siswa_nis']);
		$i_swnama = balikin($data['siswa_nama']);
		$i_kelas = balikin($data['kelas']);
		$i_tapel = balikin($data['tapel']);
		$i_ket = balikin($data['ket']);
		$i_nilai = balikin($data['nilai']);
		$i_jenis = balikin($data['jenis']);
		$i_cara_bayar = balikin($data['cara_bayar']);

		
		
		
		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>'.$i_postdate.'</td>
		<td>
		'.$i_swnama.'
		<br>
		[NIS:'.$i_swnis.']. 
		[KELAS:'.$i_kelas.'].
		</td>
		<td>'.$i_ket.'</td>
		<td>'.$i_jenis.'</td>
		<td>'.$i_cara_bayar.'</td>
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

<input name="jml" type="hidden" value="'.$count.'">
<input name="s" type="hidden" value="'.$s.'">
<input name="kd" type="hidden" value="'.$kdx.'">
<input name="page" type="hidden" value="'.$page.'">
</td>
</tr>
</table>
</form>';



//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../inc/niltpl.php");


//null-kan
xclose($koneksi);
exit();
?>