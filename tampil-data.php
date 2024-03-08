<?php
if (isset($_POST['cari'])) {
     $cari = $_POST['cari'];
} else {
     $cari = "";
}
?>

<div class="row">
     <div class="col-md-12">
          <div class="page-header">
               <h4>
                    <i class="glyphicon glyphicon-user"></i> Data Peserta Qris

                    <div class="pull-right btn-tambah">
                         <form class="form-inline" method="POST" action="index.php">
                              <div class="form-group">
                                   <div class="input-group">
                                        <div class="input-group-addon">
                                             <i class="glyphicon glyphicon-search"></i>
                                        </div>
                                        <input type="text" class="form-control" name="cari" placeholder="Cari ..."
                                             autocomplete="off" value="<?php echo $cari; ?>">

                                   </div>
                              </div>

                         </form>
                    </div>

               </h4>
          </div>

          <?php
          if (empty($_GET['alert'])) {
               echo "";
          } elseif ($_GET['alert'] == 1) {
               echo "<div class='alert alert-danger alert-dismissible' role='alert'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
            </button>
            <strong><i class='glyphicon glyphicon-alert'></i> Gagal!</strong> Terjadi kesalahan.
          </div>";
          } elseif ($_GET['alert'] == 2) {
               echo "<div class='alert alert-success alert-dismissible' role='alert'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
            </button>
            <strong><i class='glyphicon glyphicon-ok-circle'></i> Sukses!</strong> Data berhasil disimpan.
          </div>";
          } elseif ($_GET['alert'] == 3) {
               echo "<div class='alert alert-success alert-dismissible' role='alert'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
            </button>
            <strong><i class='glyphicon glyphicon-ok-circle'></i> Sukses!</strong> Data berhasil diubah.
          </div>";
          } elseif ($_GET['alert'] == 4) {
               echo "<div class='alert alert-success alert-dismissible' role='alert'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
            </button>
            <strong><i class='glyphicon glyphicon-ok-circle'></i> Sukses!</strong> Data berhasil dihapus.
          </div>";
          }
          ?>

          <div class="panel panel-default">
               <div class="panel-heading">
                    <h3 class="panel-title">Data Peserta Qris</h3>
               </div>
               <div class="panel-body">
                    <div class="table-responsive">
                         <table class="table table-striped table-hover">
                              <thead>
                                   <tr>
                                        <th class="text-center">Id</th>
                                        <th>Nik</th>
                                        <th>Pemilik Qris</th>
                                        <th>Nama bisnis</th>
                                        <th>Verified</th>

                                   </tr>
                              </thead>

                              <tbody>
                                   <?php
                                   /* Pagination */
                                   $batas = 10;

                                   if (isset($cari)) {
                                        $jumlah_record = mysqli_query($db, "SELECT * FROM peserta_qris
                                                    WHERE pemilik_qris LIKE '%$cari%' OR pemilik_qris LIKE '%$cari%'")
                                             or die('Ada kesalahan pada query jumlah_record: ' . mysqli_error($db));
                                   } else {
                                        $jumlah_record = mysqli_query($db, "SELECT * FROM peserta_qris")
                                             or die('Ada kesalahan pada query jumlah_record: ' . mysqli_error($db));
                                   }

                                   $jumlah  = mysqli_num_rows($jumlah_record);
                                   $halaman = ceil($jumlah / $batas);
                                   $page    = (isset($_GET['hal'])) ? (int)$_GET['hal'] : 1;
                                   $mulai   = ($page - 1) * $batas;
                                   /*-------------------------------------------------------------------*/
                                   $no = 1;
                                   if (isset($cari)) {
                                        $query = mysqli_query($db, "SELECT * FROM peserta_qris
                                            WHERE pemilik_qris LIKE '%$cari%' OR pemilik_qris LIKE '%$cari%' 
                                            ORDER BY pemilik_qris DESC LIMIT $mulai, $batas")
                                             or die('Ada kesalahan pada query barang: ' . mysqli_error($db));
                                   } else {
                                        $query = mysqli_query($db, "SELECT * FROM peserta_qris
                                            ORDER BY pemilik_qris DESC LIMIT $mulai, $batas")
                                             or die('Ada kesalahan pada query barang: ' . mysqli_error($db));
                                   }

                                   while ($data = mysqli_fetch_assoc($query)) {

                                        echo "  <tr>
                      <td width='50' class='center'>$no</td>
                      <td width='60'>$data[nik]</td>
                      <td width='100'>$data[pemilik_qris]</td>
                      <td width='100'>$data[nama_bisnis]</td>
                      <td width='100'>$data[verified]</td>
                     
                      
                    </tr>";
                                        $no++;
                                   }
                                   ?>
                              </tbody>
                         </table>
                         <?php
                         if (empty($_GET['hal'])) {
                              $halaman_aktif = '1';
                         } else {
                              $halaman_aktif = $_GET['hal'];
                         }
                         ?>

                         <a>
                              Halaman <?php echo $halaman_aktif; ?> dari <?php echo $halaman; ?> |
                              Total <?php echo $jumlah; ?> data
                         </a>
                    </div>
               </div>
          </div> <!-- /.panel -->

          <div class="panel panel-default">
               <div class="panel-heading">
                    <h3 class="panel-title">Top 5 Transaksi QRIS Tertinggi Tahun 2023</h3>
               </div>
               <div class="panel-body">
                    <div class="table-responsive">
                         <table class="table table-striped table-hover">
                              <thead>
                                   <tr>
                                        <th class="text-center">Id</th>
                                        <th>Nik</th>
                                        <th>Nama Produk</th>
                                        <th>Tanggal Transaksi</th>
                                        <th>Jumlah Transaksi</th>
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php
                                   /* Pagination */
                                   $batas = 5;
                                   $page = (isset($_GET['hal'])) ? (int)$_GET['hal'] : 1;
                                   $mulai = ($page - 1) * $batas;

                                   $query = mysqli_query($db, "SELECT * FROM transaksi_qris WHERE YEAR(tanggal_transaksi) = 2023 ORDER BY jumlah_transaksi DESC LIMIT $mulai, $batas")
                                        or die('Ada kesalahan pada query barang: ' . mysqli_error($db));

                                   $no = 1;
                                   while ($data = mysqli_fetch_assoc($query)) {
                                        echo "
                        <tr>
                            <td width='50' class='center'>$no</td>
                            <td width='60'>$data[nik]</td>
                            <td width='100'>$data[nama_produk]</td>
                            <td width='100'>$data[tanggal_transaksi]</td>
                            <td width='100'>$data[jumlah_transaksi]</td>
                        </tr>";
                                        $no++;
                                   }
                                   ?>
                              </tbody>
                         </table>
                         <?php
                         if (empty($_GET['hal'])) {
                              $halaman_aktif = '1';
                         } else {
                              $halaman_aktif = $_GET['hal'];
                         }
                         ?>
                         <a>
                              Halaman <?php echo $halaman_aktif; ?> dari <?php echo $halaman; ?> |
                              Total <?php echo $jumlah; ?> data
                         </a>
                    </div>
               </div>
          </div>
          <!DOCTYPE html>
          <html lang="en">

          <head>
               <meta charset="UTF-8">
               <meta name="viewport" content="width=device-width, initial-scale=1.0">
               <title>Informasi Transaksi QRIS per Bulan Tahun 2023</title>
               <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
          </head>

          <body>
               <div class="panel panel-default">
                    <div class="panel-heading">
                         <h3 class="panel-title">Informasi Transaksi QRIS per Bulan Tahun 2023</h3>
                    </div>
                    <div class="panel-body">
                         <canvas id="myChart"></canvas>
                    </div>
               </div> <!-- /.panel -->

               <script>
               var ctx = document.getElementById('myChart').getContext('2d');
               var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                         labels: [
                              "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                              "Juli", "Agustus", "September", "Oktober", "November", "Desember"
                         ],
                         datasets: [{
                              label: 'Jumlah Transaksi',
                              data: [
                                   <?php
                                             $query = mysqli_query($db, "SELECT MONTH(tanggal_transaksi) AS bulan, COUNT(*) AS jumlah_transaksi FROM transaksi_qris WHERE YEAR(tanggal_transaksi) = 2023 GROUP BY MONTH(tanggal_transaksi) ORDER BY bulan ASC")
                                                  or die('Ada kesalahan pada query: ' . mysqli_error($db));

                                             while ($data = mysqli_fetch_assoc($query)) {
                                                  echo $data['jumlah_transaksi'] . ",";
                                             }
                                             ?>
                              ],
                              backgroundColor: 'rgba(54, 162, 235, 0.2)',
                              borderColor: 'rgba(54, 162, 235, 1)',
                              borderWidth: 1
                         }]
                    },
                    options: {
                         scales: {
                              y: {
                                   beginAtZero: true
                              }
                         }
                    }
               });
               </script>
          </body>

          </html>


     </div> <!-- /.col -->
</div> <!-- /.row -->