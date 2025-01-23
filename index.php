<?php
session_start();


//ambil nilai
require("inc/config.php");
require("inc/fungsi.php");
require("inc/koneksi.php");
require("inc/class/paging.php");
$tpl = LoadTpl("template/login.html");



nocache;

//nilai
$filenya = "index.php";
$filenya_ke = $sumber;
$judul = "Keuangan SISWA";
$judulku = $judul;
$pesan = "User atau Password Salah. Harap Dicek...!!";






//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika batal
if ($_POST['btnBTL'])
	{
	//re-direct
	xloc($filenya);
	exit();
	}





if ($_POST['btnOK'])
	{
	//ambil nilai
	$username = cegah($_POST["usernamex"]);
	$password = md5(cegah($_POST["passwordx"]));

	//cek null
	if ((empty($username)) OR (empty($password)))
		{
		//diskonek
		xclose($koneksi);

		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		pekem($pesan,$filenya);
		exit();
		}
	else
		{
		//query
		$q = mysqli_query($koneksi, "SELECT * FROM adminx ".
									"WHERE usernamex = '$username' ".
									"AND passwordx = '$password'");
		$row = mysqli_fetch_assoc($q);
		$total = mysqli_num_rows($q);

		//cek login
		if ($total != 0)
			{
			session_start();

			//bikin session
			$_SESSION['kd1_session'] = nosql($row['kd']);
			$_SESSION['tipe_session'] = "BENDAHARA";
			$_SESSION['no1_session'] = cegah($row['usernamex']);
			$_SESSION['nip1_session'] = cegah($row['usernamex']);
			$_SESSION['nm1_session'] = balikin($row['nama']);
			
			$_SESSION['kd8_session'] = cegah($row['usernamex']);
			$_SESSION['nip8_session'] = cegah($row['usernamex']);
			$_SESSION['username8_session'] = $username;
			$_SESSION['pass8_session'] = $password;
			$_SESSION['bdh_session'] = "BENDAHARA";
			$_SESSION['nm8_session'] = balikin($row['nama']);
			$_SESSION['hajirobe_session'] = $hajirobe;
			$_SESSION['janiskd'] = "admbdh";

			//diskonek
			xfree($q);
			xclose($koneksi);

			//re-direct
			$ke = "adm/index.php";
			xloc($ke);
			exit();
			}
		else
			{
			//diskonek
			xfree($q);
			xclose($koneksi);

			//re-direct
			pekem($pesan, $filenya);
			exit();
			}
		}
	//...................................................................................................
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////








//isi *START
ob_start();



//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

echo '<form action="'.$filenya.'" method="post" name="formx">


<p>
Username :
<br>
<input name="usernamex" type="text" size="15" class="btn btn-block btn-warning" required>
</p>


<p>
Password :
<br>
<input name="passwordx" type="password" size="15" class="btn btn-block btn-warning" required>
</p>


<p>
<input name="btnOK" type="submit" value="LOGIN &gt;&gt;&gt;" class="btn btn-block btn-danger">
</p>




</form>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//isi
$isi = ob_get_contents();
ob_end_clean();

require("inc/niltpl.php");


//diskonek
xclose($koneksi);
exit();
?>
