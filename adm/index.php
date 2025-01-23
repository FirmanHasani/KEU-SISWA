<?php
session_start();

//ambil nilai
require("../inc/config.php");
require("../inc/fungsi.php");
require("../inc/koneksi.php");
require("../inc/cek/adm.php");
require("../inc/class/paging.php");
$tpl = LoadTpl("../template/adm.html");

nocache;

//nilai
$filenya = "index.php";
$judul = "Selamat Datang....";
$judulku = "$judul  [$bdh_session]";








//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//nilai
$judul = "Admin Bendahara";
$judulku = $judul;




//postdate entri
$qyuk = mysqli_query($koneksi, "SELECT * FROM user_log_entri ".
									"ORDER BY postdate DESC");
$ryuk = mysqli_fetch_assoc($qyuk);
$yuk_entri_terakhir = balikin($ryuk['postdate']);





//isi *START
ob_start();


echo '<div class="row">

  <div class="col-lg-12">
    <div class="info-box mb-3 bg-primary">
      <span class="info-box-icon"><i class="fa fa-user"></i></span>

      <div class="info-box-content">
        <span class="info-box-number">
        		'.$judul.'
			</span>

      </div>
    </div>

	</div>
</div>';




//isi
$judulku = ob_get_contents();
ob_end_clean();
              


























//isi *START
ob_start();

//tanggal sekarang
$m = date("m");
$de = date("d");
$y = date("Y");

//ambil 14hari terakhir
for($i=0; $i<=14; $i++)
	{
	$nilku = date('Ymd',mktime(0,0,0,$m,($de-$i),$y)); 

	echo "$nilku, ";
	}


//isi
$isi_data1 = ob_get_contents();
ob_end_clean();










//isi *START
ob_start();

//tanggal sekarang
$m = date("m");
$de = date("d");
$y = date("Y");

//ambil 14hari terakhir
for($i=0; $i<=14; $i++)
	{
	$nilku = date('Y-m-d',mktime(0,0,0,$m,($de-$i),$y)); 


	//pecah
	$ipecah = explode("-", $nilku);
	$itahun = trim($ipecah[0]);  
	$ibln = trim($ipecah[1]);
	$itgl = trim($ipecah[2]);    


	//ketahui ordernya...
	$qyuk = mysqli_query($koneksi, "SELECT SUM(nilai) AS totalnya ".
										"FROM siswa_bayar ".
										"WHERE round(DATE_FORMAT(tgl_bayar, '%d')) = '$itgl' ".
										"AND round(DATE_FORMAT(tgl_bayar, '%m')) = '$ibln' ".
										"AND round(DATE_FORMAT(tgl_bayar, '%Y')) = '$itahun'");
	$ryuk = mysqli_fetch_assoc($qyuk);
	$tyuk = mysqli_num_rows($qyuk);
	$yuk_total = balikin($ryuk['totalnya']);
									
									
	if (!empty($yuk_total))
		{
		$tyuk = $yuk_total;
		}
	else
		{
		$tyuk = 0;
		}
		
	echo "$tyuk, ";
	}


//isi
$isi_data2 = ob_get_contents();
ob_end_clean();











//isi *START
ob_start();

//tanggal sekarang
$m = date("m");
$de = date("d");
$y = date("Y");

//ambil 14hari terakhir
for($i=0; $i<=14; $i++)
	{
	$nilku = date('Y-m-d',mktime(0,0,0,$m,($de-$i),$y)); 


	//pecah
	$ipecah = explode("-", $nilku);
	$itahun = trim($ipecah[0]);  
	$ibln = trim($ipecah[1]);
	$itgl = trim($ipecah[2]);    


	//ketahui ordernya...
	$qyuk = mysqli_query($koneksi, "SELECT COUNT(kd) AS totalnya ".
										"FROM siswa_bayar ".
										"WHERE round(DATE_FORMAT(tgl_bayar, '%d')) = '$itgl' ".
										"AND round(DATE_FORMAT(tgl_bayar, '%m')) = '$ibln' ".
										"AND round(DATE_FORMAT(tgl_bayar, '%Y')) = '$itahun'");
	$ryuk = mysqli_fetch_assoc($qyuk);
	$tyuk = mysqli_num_rows($qyuk);
	$yuk_total = balikin($ryuk['totalnya']);
									
									
	if (!empty($yuk_total))
		{
		$tyuk = $yuk_total;
		}
	else
		{
		$tyuk = 0;
		}
		
	echo "$tyuk, ";
	}


//isi
$isi_data3 = ob_get_contents();
ob_end_clean();

























//isi *START
ob_start();


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jumlah 
$qx = mysqli_query($koneksi, "SELECT * FROM m_siswa");
$rowx = mysqli_fetch_assoc($qx);
$e_total_siswa = mysqli_num_rows($qx);



//jumlah 
$qx = mysqli_query($koneksi, "SELECT SUM(nilai) AS totalnya ".
								"FROM siswa_bayar");
$rowx = mysqli_fetch_assoc($qx);
$e_total_bayar = balikin($rowx['totalnya']);





//entri terakhir 
$qx = mysqli_query($koneksi, "SELECT postdate FROM siswa_bayar ".
								"ORDER BY postdate DESC");
$rowx = mysqli_fetch_assoc($qx);
$e_log_terakhir = balikin($rowx['postdate']);

?>




<!-- Bootstrap core JavaScript -->
<script src="../template/vendors/jquery/jquery.min.js"></script>
<script src="../template/vendors/bootstrap/js/bootstrap.bundle.min.js"></script>





		<!-- Info boxes -->
      <div class="row">

        <!-- /.col -->
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-danger"><i class="fa fa-users"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">SISWA</span>
              <span class="info-box-number"><?php echo $e_total_siswa;?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->



        <!-- /.col -->
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-success"><i class="fa fa-money"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">TOTAL PEMBAYARAN</span>
              <span class="info-box-number"><?php echo xduit3($e_total_bayar);?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->






        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-primary"><i class="fa fa-calendar-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">ENTRI TERAKHIR</span>
              <span class="info-box-number"><?php echo $e_log_terakhir;?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->





		<?php
		//list jenis
		$qku = mysqli_query($koneksi, "SELECT * FROM m_cara_bayar ".
										"ORDER BY nama ASC");
		$rku = mysqli_fetch_assoc($qku);

		do
			{
			//nilai
			$ku_nama = balikin($rku['nama']);
			$ku_nama2 = cegah($rku['nama']);
			
			
		
			//cek nilai 
			$qku21 = mysqli_query($koneksi, "SELECT SUM(nilai) AS totalnya ".
											"FROM siswa_bayar ".
											"WHERE jenis = '$ku_nama2'");
			$rku21 = mysqli_fetch_assoc($qku21);
			$tku21 = mysqli_num_rows($qku21);
			$ku21_nilai = nosql($rku21['totalnya']);


			?>
					


		        <div class="col-md-4 col-sm-6 col-xs-12">
		          <div class="info-box">
		            <span class="info-box-icon bg-yellow"><i class="fa fa-money"></i></span>
		
		            <div class="info-box-content">
		              <span class="info-box-text"><?php echo $ku_nama;?></span>
		              <span class="info-box-number"><?php echo xduit3($ku21_nilai);?></span>
		            </div>
		            <!-- /.info-box-content -->
		          </div>
		          <!-- /.info-box -->
		        </div>
		        <!-- /.col -->
	
			<?php
			}
		while ($rku = mysqli_fetch_assoc($qku));
		?>
        






		<?php
		//list cara
		$qku = mysqli_query($koneksi, "SELECT * FROM m_uang_jenis ".
										"ORDER BY nama ASC");
		$rku = mysqli_fetch_assoc($qku);

		do
			{
			//nilai
			$ku_nama = balikin($rku['nama']);
			$ku_nama2 = cegah($rku['nama']);
			
			
		
			//cek nilai 
			$qku21 = mysqli_query($koneksi, "SELECT SUM(nilai) AS totalnya ".
											"FROM siswa_bayar ".
											"WHERE cara_bayar = '$ku_nama2'");
			$rku21 = mysqli_fetch_assoc($qku21);
			$tku21 = mysqli_num_rows($qku21);
			$ku21_nilai = nosql($rku21['totalnya']);


			?>
					


		        <div class="col-md-3 col-sm-6 col-xs-12">
		          <div class="info-box">
		            <span class="info-box-icon bg-red"><i class="fa fa-money"></i></span>
		
		            <div class="info-box-content">
		              <span class="info-box-text"><?php echo $ku_nama;?></span>
		              <span class="info-box-number"><?php echo xduit3($ku21_nilai);?></span>
		            </div>
		            <!-- /.info-box-content -->
		          </div>
		          <!-- /.info-box -->
		        </div>
		        <!-- /.col -->
	
			<?php
			}
		while ($rku = mysqli_fetch_assoc($qku));
		?>
        



                
      </div>
      <!-- /.row -->







				<script>
					$(function () {
					  'use strict'
					
					  var ticksStyle = {
					    fontColor: '#495057',
					    fontStyle: 'bold'
					  }
					
					  var mode      = 'index'
					  var intersect = true
					
					
					  var $visitorsChart = $('#visitors-chart')
					  var visitorsChart  = new Chart($visitorsChart, {
					    data   : {
					      labels  : [<?php echo $isi_data1;?>],
					      datasets: [{
					        type                : 'line',
					        data                : [<?php echo $isi_data2;?>],
					        backgroundColor     : 'transparent',
					        borderColor         : 'blue',
					        pointBorderColor    : 'blue',
					        pointBackgroundColor: 'blue',
					        fill                : false
					        // pointHoverBackgroundColor: '#007bff',
					        // pointHoverBorderColor    : '#007bff'
					      }, 
					      {
					        type                : 'line',
					        data                : [<?php echo $isi_data3;?>],
					        backgroundColor     : 'transparent',
					        borderColor         : 'orange',
					        pointBorderColor    : 'orange',
					        pointBackgroundColor: 'orange',
					        fill                : false
					        // pointHoverBackgroundColor: '#007bff',
					        // pointHoverBorderColor    : '#007bff'
					      }]
					    },
					    options: {
					      maintainAspectRatio: false,
					      tooltips           : {
					        mode     : mode,
					        intersect: intersect
					      },
					      hover              : {
					        mode     : mode,
					        intersect: intersect
					      },
					      legend             : {
					        display: false
					      },
					      scales             : {
					        yAxes: [{
					          // display: false,
					          gridLines: {
					            display      : true,
					            lineWidth    : '4px',
					            color        : 'rgba(0, 0, 0, .2)',
					            zeroLineColor: 'transparent'
					          },
					          ticks    : $.extend({
					            beginAtZero : true,
					            suggestedMax: 200
					          }, ticksStyle)
					        }],
					        xAxes: [{
					          display  : true,
					          gridLines: {
					            display: false
					          },
					          ticks    : ticksStyle
					        }]
					      }
					    }
					  })
					})
	
				</script>
	
	
	
	
	
	

		<!-- Info boxes -->
      <div class="row">
	
        <!-- /.col -->
        <div class="col-md-12">
	
	

	            <div class="card">
	              <div class="card-header border-transparent">
	                <h3 class="card-title">Grafik : Nominal Pembayaran, Transaksi Pembayaran</h3>
	
	                <div class="card-tools">
	                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
	                    <i class="fas fa-minus"></i>
	                  </button>
	                </div>
	              </div>
	              <div class="card-body">
	
	
	
	                <div class="position-relative mb-4">
	                  <canvas id="visitors-chart" height="200"></canvas>
	                </div>
	
	                <div class="d-flex flex-row justify-content-end">
	                  <span class="mr-2">
	                    <i class="fas fa-square text-blue"></i> Nominal Pembayaran
	                  </span>
	                  &nbsp;
	                  
	                  
	                  <span class="mr-2">
	                    <i class="fas fa-square text-orange"></i> Transaksi Pembayaran
	                  </span>
	                  &nbsp;
	                </div>
	
	
	                
	                
	              </div>
	            </div>
	
			</div>
			
		</div>
			            
	          

	





	
            
		<!-- Info boxes -->
      <div class="row">
	
        <!-- /.col -->
        <div class="col-md-12">
            
			<?php
			$limit = 100;
			$sqlcount = "SELECT * FROM siswa_bayar ".
							"ORDER BY postdate DESC";

			//query
			$p = new Pager();
			$start = $p->findStart($limit);
			
			$sqlresult = $sqlcount;
			
			$count = mysqli_num_rows(mysqli_query($koneksi, $sqlcount));
			$pages = $p->findPages($count, $limit);
			$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
			$pagelist = $p->pageList($_GET['page'], $pages, $target);
			$data = mysqli_fetch_array($result);
			?>
			
			
            <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">ENTRI TERAKHIR</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
                    <thead>
                    <tr>
                      <th>POSTDATE</th>
                      <th>NAMA</th>
                      <th>KELAS</th>
                      <th>TGL.BAYAR</th>
                      <th>JENIS</th>
                      <th>NOMINAL</th>
                    </tr>
                    </thead>
                    <tbody>
                    	
                    <?php
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
							$i_swnama = balikin($data['siswa_nama']);
							$i_kelas = balikin($data['kelas']);
							$i_nominal = balikin($data['nilai']);
							$i_tgl_bayar = balikin($data['tgl_bayar']);
							$i_jenis = balikin($data['jenis']);

								
						
						

						
							echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
							echo '<td>'.$i_postdate.'</td>
							<td>'.$i_swnama.'</td>
							<td>'.$i_kelas.'</td>
							<td>'.$i_tgl_bayar.'</td>
							<td>'.$i_jenis.'</td>
							<td align="right">'.xduit3($i_nominal).'</td>
					        </tr>';
							}
						while ($data = mysqli_fetch_assoc($result));
						?>
						
						
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>

              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <a href="<?php echo $sumber;?>/adm/b/bayar_excel.php" class="btn btn-sm btn-danger float-right">SELENGKAPNYA >></a>
              </div>
              <!-- /.card-footer -->


              <!-- /.card-footer -->
            </div>
            <!-- /.card -->



		</div>
		

		
		
		

		</div>
	</div>



            


		<!-- OPTIONAL SCRIPTS -->
		<script src="../template/adminlte3/plugins/chart.js/Chart.min.js"></script>
		




	
	<script language='javascript'>
	//membuat document jquery
	$(document).ready(function(){
	
	$.noConflict();

	});
	
	</script>
	


<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//isi
$isi = ob_get_contents();
ob_end_clean();

require("../inc/niltpl.php");



//diskonek
xfree($qbw);
xclose($koneksi);
exit();
?>