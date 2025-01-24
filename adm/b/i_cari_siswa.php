<?php
session_start();

//ambil nilai
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");

nocache;

//nilai
$filenya = "$sumber/adm/b/i_cari_siswa.php";
$filenyax = "$sumber/adm/b/i_cari_siswa.php";
$judul = "cari nama";
$juduli = $judul;




/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//nilai
$searchTerm = cegah($_GET['query']);


$query = "SELECT * FROM m_siswa ".
			"WHERE nama LIKE '%".$searchTerm."%' ".
			"ORDER BY tapel DESC, ".
			"nama ASC";
$result = mysqli_query($koneksi, $query);

$data = array();


if (mysqli_num_rows($result) > 0)
    {
    while ($row = mysqli_fetch_assoc($result))
	    {
	    $i_nama = balikin($row["nama"]);
	    $i_kelas = balikin($row["kelas"]);
	    $data[] = "$i_nama KELAS.$i_kelas";
	    }

    echo json_encode($data);
	}



exit();
?>