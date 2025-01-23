<?php
session_start();

require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/class/paging.php");

nocache;

//nilai
$filenya = "bayar_pdf.php";
$judul = "[PEMBAYARAN]. Siswa Bayar";
$judulku = "$judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);

$swnis = cegah($_REQUEST['swnis']);
$swtapel = cegah($_REQUEST['tapel']);
$swkelas = cegah($_REQUEST['kelas']);
$tglnya = balikin($_REQUEST['tglnya']);





//bikin pdf
require_once("../../inc/class/dompdf/autoload.inc.php");

use Dompdf\Dompdf;
$dompdf = new Dompdf();






//detail 
$qx = mysqli_query($koneksi, "SELECT SUM(nilai) AS totalnya ".
								"FROM siswa_bayar ".
								"WHERE siswa_nis = '$swnis' ".
								"AND tapel = '$swtapel' ".
								"AND kelas = '$swkelas' ".
								"AND tgl_bayar = '$tglnya'");
$rowx = mysqli_fetch_assoc($qx);
$e_nominal = balikin($rowx['totalnya']);




//detail 
$qx = mysqli_query($koneksi, "SELECT * FROM siswa_bayar ".
								"WHERE siswa_nis = '$swnis' ".
								"AND tapel = '$swtapel' ".
								"AND kelas = '$swkelas' ".
								"AND tgl_bayar = '$tglnya'");
$rowx = mysqli_fetch_assoc($qx);
$e_swnama = balikin($rowx['siswa_nama']);





//pecah
$pecahnya = explode("-", $tglnya);
$p_thn = trim($pecahnya[0]);
$p_bln = trim($pecahnya[1]);
$p_tgl = trim($pecahnya[2]);




						
						


//bikin folder
$foldernya = "../../filebox/pdf/$swnis/";
			
			
//buat folder...
if (!file_exists('../../filebox/pdf/'.$swnis.'')) {
    mkdir('../../filebox/pdf/'.$swnis.'', 0777, true);
	}
	

//bikin pdf ///////////////////////////////////////////////////////////////////////////////////////

?>


<style>
div.page_break + div.page_break{
    page-break-before: always;
}



</style>





<?php

//isi *START
ob_start();




echo '<table width="530" cellpadding="1" cellspacing="1" border="0">
<tr valign="top">
<td align="center" width="50">
	<img src="../../img/logo.png" width="50" height="50">
</td>
<td align="center">

	<font size="5">
	<b>'.$sek_nama.'</b>
	<br>

	<font size="4">
	'.$sek_alamat.'
	</font>
</td>

<td align="center" width="50">
	&nbsp;
</td>


</tr>
</table>



<hr>



<br>
<table width="530" cellpadding="1" cellspacing="1" border="0">
<tr valign="top">
<td align="center">
	
	<font size="4">
	<u><b>NOTA BAYAR</b></u>
	</font>
	
</td>
</tr>
</table>

<br>



<table width="530" cellpadding="1" cellspacing="1" border="0">
<tr valign="top">
<td align="left" width="10">
a.
</td>
<td align="left" width="150">
NIS
</td>
<td align="left" width="10">
:
</td>
<td align="left">
'.strtoupper($swnis).'
</td>
</tr>

<tr valign="top">
<td align="left" width="10">
b.
</td>
<td align="left" width="150">
NAMA
</td>
<td align="left" width="10">
:
</td>
<td align="left">
'.strtoupper($e_swnama).'
</td>
</tr>


<tr valign="top">
<td align="left" width="10">
c.
</td>
<td align="left" width="150">
KELAS
</td>
<td align="left" width="10">
:
</td>
<td align="left">
'.strtoupper($swkelas).'
</td>
</tr>


<tr valign="top">
<td align="left" width="10">
d.
</td>
<td align="left" width="150">
NOMINAL
</td>
<td align="left" width="10">
:
</td>
<td align="left">
'.xduit3($e_nominal).'
</td>
</tr>


<tr valign="top">
<td align="left" width="10">
e.
</td>
<td align="left" width="150">
UNTUK MEMBAYAR
</td>
<td align="left" width="10">
:
</td>
<td align="left">';


//list
$qx = mysqli_query($koneksi, "SELECT * FROM siswa_bayar ".
								"WHERE siswa_nis = '$swnis' ".
								"AND tapel = '$swtapel' ".
								"AND kelas = '$swkelas' ".
								"AND tgl_bayar = '$tglnya' ".
								"ORDER BY jenis ASC");
$rowx = mysqli_fetch_assoc($qx);

do
	{
	$e_jenis = balikin($rowx['jenis']);
	$e_nilai = balikin($rowx['nilai']);
	$e_nilai2 = xduit3($e_nilai);
	
	echo "$e_jenis : $e_nilai2<br>";
	}
while ($rowx = mysqli_fetch_assoc($qx));



  
echo '</td>
</tr>



</table>
<br>
<br>



<table width="530" cellpadding="1" cellspacing="1" border="0">
<tr valign="top">

<td align="center" width="250">
	<br>
	<br>
	Siswa
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	
	<u><b>'.$e_swnama.'</b></u>

</td>


<td align="center">

</td>


<td align="center" width="150">
	'.$sek_kota.', '.$p_tgl.' '.$arrbln1[$p_bln].' '.$p_thn.'
	
	<br>
	<br>
	Bendahara
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	
	<u><b>'.$sek_bendahara.'</b></u>
	
</td>


</tr>
</table>

<hr>

<i>[Postdate Cetak : '.$today.'].</i>';




//isi
$isix = ob_get_contents();
ob_end_clean();







$dompdf->loadHtml($isix);

// Setting ukuran dan orientasi kertas
$dompdf->setPaper('A4', 'potrait');
// Rendering dari HTML Ke PDF
$dompdf->render();


// Melakukan output file Pdf




//auto save ke server
//777
chmod("../../filebox/pdf/$swnis", 0777);

$namaku = seo_friendly_url($e_swnama);
$filename = "../../filebox/pdf/$swnis/$swnis-$namaku-$tglnya.pdf";



//hapus dulu...
unlink($filename);

//777
chmod("../../filebox/pdf/$swnis", 0777);
	




$output = $dompdf->output();
file_put_contents($filename, $output);



//755
chmod("../../filebox/pdf/$swnis", 0755);
	



//re-direct
xloc($filename);
exit();




require("../../inc/niltpl.php");



//null-kan
xfree($qbw);
xclose($koneksi);
exit();
?>