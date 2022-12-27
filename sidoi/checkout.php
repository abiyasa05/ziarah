<?php
session_start();
//script koneksi
include "koneksi.php";
// 
//jika belum login akan dilarikan ke halaman login
if (!isset($_SESSION["pelanggan"])) {
	echo "<script>alert('Silahkan login dulu!');</script>";
	echo "<script>location='login.php';</script>";
}
?>
<?php
$ambil = $koneksi->query("SELECT * FROM profil");
$em = $ambil->fetch_assoc();
?>
<?php
$email_pelanggan = $_SESSION["pelanggan"]["email_pelanggan"];
$data = $koneksi->query("SELECT * FROM keranjang WHERE email_pelanggan='$email_pelanggan'");

$jum = mysqli_num_rows($data);

if ($jum == 0) {
	echo "<script>alert('Checkout kosong, silahkan beli produk!');</script>";
	echo "<script>location='index2.php';</script>";
}
?>
<?php
//query ambil data
$email_pelanggan = $_SESSION["pelanggan"]["email_pelanggan"];
$ambil = $koneksi->query("SELECT * FROM produk JOIN keranjang
					ON produk.id_produk=keranjang.id_produk
					WHERE keranjang.email_pelanggan='$email_pelanggan'");
$detail = $ambil->fetch_assoc();
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<title>SI - DO'I - Checkout</title>

	<!-- CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/css/brands.min.css">
	<link rel="stylesheet" href="assets/css/solid.min.css">

	<!-- JS -->
	<script src="assets/js/solid.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/fontawesome.min.js"></script>
	<script src="assets/js/brands.min.js"></script>
</head>

<body>
	<!--Navbar -->
	<nav class="mb-1 navbar navbar-expand-lg navbar-dark bg-dark">
		<a class="navbar-brand" href="index2.php">SI - DO'I</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-333" aria-controls="navbarSupportedContent-333" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent-333">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
					<a class="nav-link" href="index2.php">Tour Builder</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="paket_ziarah.php">Paket Ziarah</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="panduan_doa.php">Panduan Doa</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="history_pesanan.php">History Pesanan</a>
				</li>
			</ul>
			<form action="pencarian.php" method="get" class="form-inline my-2 my-lg-0 mr-5">
				<input class="form-control mr-sm-2" type="search" name="keyword" placeholder="Pencarian" aria-label="Search">
				<button class="btn btn-outline-light my-2 my-sm-0" type="submit">Cari</button>
			</form>
			<ul class="navbar-nav mr-2">
				<a class="nav-link" href="wishlist.php">
					<i class="fas fa-bookmark"></i>
				</a>
			</ul>
			<ul class="navbar-nav mr-2">
				<a class="nav-link" href="keranjang.php">
					<i class="fas fa-shopping-cart"></i>
				</a>
			</ul>
			<ul class="navbar-nav">
				<li class="nav-item dropdown">
					<a href="#" class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<?php echo $_SESSION["pelanggan"]["nama_pelanggan"] ?></a>
					<div class="dropdown-menu dropdown-menu-right dropdown-info" aria-labelledby="navbarDropdownMenuLink-4">
						<a class="dropdown-item" href="profil.php?email=<?php echo $_SESSION["pelanggan"]["email_pelanggan"]; ?>">Profil</a>
						<a class="dropdown-item" href="logout.php">Logout</a>
					</div>
				</li>
			</ul>
		</div>
	</nav>
	<!--/.Navbar -->

	<!-- jQuery CDN - Slim version (=without AJAX) -->
	<script src="assets/js/jquery-3.3.1.slim.min.js"></script>
	<!-- Popper.JS -->
	<script src="assets/js//popper.min.js"></script>
	<!-- Bootstrap JS -->
	<script src="assets/js/bootstrap.min.js"></script>

	<script type="text/javascript">
		$(document).ready(function() {
			$('#sidebarCollapse').on('click', function() {
				$('#sidebar').toggleClass('active');
			});
		});
	</script>

	<!-- Konten -->
	<section class="konten">
		<div class="container" style="margin-bottom: 50px;">
			<h3 style="margin-top: 35px;">Checkout</h3>
			<hr color="black">
			<table class="table table-bordered table-responsive-md" style="margin-top: 20px;">
				<thead>
					<tr>
						<td>No</td>
						<td>Produk</td>
						<td>Harga</td>
						<td>Jumlah Orang</td>
						<td>Total Harga</td>
					</tr>
				</thead>
				<tbody>
					<?php $nomor = 1; ?>
					<?php $totalbelanja = 0; ?>
					<?php $email = $_SESSION["pelanggan"]["email_pelanggan"]; ?>
					<?php $ambil = $koneksi->query("SELECT * FROM keranjang WHERE email_pelanggan='$email'"); ?>
					<?php while ($pecah = $ambil->fetch_assoc()) { ?>
						<!--menampilkan produk yang sedang diperulangkan berdasarkan id produk -->
						<?php
						$id_produk = $pecah["id_produk"];
						$am = $koneksi->query("SELECT * FROM produk WHERE id_produk='$id_produk'");
						$perproduk = $am->fetch_assoc();
						$id_keranjang = $pecah["id_keranjang"];
						$jumlah = $pecah["jumlah"];
						$subharga = $perproduk["harga_produk"] * $jumlah;
						?>
						<tr>
							<td><?php echo $nomor; ?></td>
							<td><?php echo $perproduk["nama_produk"]; ?></td>
							<td>Rp. <?php echo number_format($perproduk["harga_produk"]); ?></td>
							<td><?php echo $jumlah; ?></td>
							<td>Rp. <?php echo number_format($subharga); ?></td>
						</tr>
						<?php $nomor++; ?>
						<?php $totalbelanja += $subharga; ?>
					<?php } ?>
				</tbody>
				<tfoot>
					<tr>
						<th colspan="4">Total Belanja</th>
						<th>Rp. <?php echo number_format($totalbelanja) ?></th>
					</tr>
				</tfoot>
			</table>
			<form method="post">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<input type="text" readonly style="background-color: white;" value="<?php echo $_SESSION["pelanggan"]["nama_pelanggan"] ?>" class="form-control">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<input type="text" readonly style="background-color: white;" value="<?php echo $_SESSION["pelanggan"]["telepon_pelanggan"] ?>" class="form-control">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Tanggal Penjemputan</label>
							<input type="date" style="background-color: white;" class="form-control" name="tgl_penyusulan">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Jam Penjemputan</label>
							<select class="form-control" name="id_jamsul">
								<option value="">Pilih Jam Penjemputan</option>
								<?php
								$ambil = $koneksi->query("SELECT * FROM jamsul");
								while ($perjamsul = $ambil->fetch_assoc()) {
								?>
									<option value="<?php echo $perjamsul["id_jamsul"] ?>">
										<?php echo $perjamsul['jam_penyusulan'] ?>
									</option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label>Rute Perjalanan</label>
					<input type="text" readonly style="background-color: white;" class="form-control" value="<?php echo $detail["rute_perjalanan"]; ?>">
				</div>
				<div class="form-group">
					<label>Tujuan Awal</label>
					<input type="text" class="form-control" name="tujuan_awal" placeholder="Masukkan tujuan awal berjasarkan rute perjalanan diatas!">
				</div>
				<div class="form-group">
					<label>Alamat Lengkap Penjemputan</label>
					<textarea class="form-control" name="alamat_penyusulan" placeholder="Masukkan alamat penjemputan secara lengkap beserta kode pos!"></textarea>
				</div>
				<a href="keranjang.php" class="btn btn-secondary">Kembali</a>
				<button class="btn btn-primary" name="checkout">Selanjutnya</button>
			</form>

			<?php
			if (isset($_POST["checkout"])) {
				$email_pelanggan = $_SESSION["pelanggan"]["email_pelanggan"];
				$id_jamsul = $_POST["id_jamsul"];
				$tanggal_pembelian = date("Y-m-d");
				$tgl_penyusulan = $_POST['tgl_penyusulan'];
				$tujuan_awal = $_POST['tujuan_awal'];
				$alamat_penyusulan = $_POST['alamat_penyusulan'];

				$ambil = $koneksi->query("SELECT * FROM jamsul WHERE id_jamsul='$id_jamsul'");
				$arrayjamsul = $ambil->fetch_assoc();
				$jam_penyusulan = $arrayjamsul['jam_penyusulan'];

				$total_pembelian = $totalbelanja;

				//menyimpan data ke dalam tabel pembelian
				$koneksi->query("INSERT INTO pembelian (email_pelanggan,id_jamsul,tanggal_pembelian,total_pembelian,
					tgl_penyusulan,jam_penyusulan,tujuan_awal,alamat_penyusulan) VALUES ('$email_pelanggan','$id_jamsul','$tanggal_pembelian',
					'$total_pembelian','$tgl_penyusulan','$jam_penyusulan','$tujuan_awal','$alamat_penyusulan')");

				//mendapatkan id_pembelian yang barusan terjadi
				$id_pembelian_barusan = $koneksi->insert_id;

				$ambi = $koneksi->query("SELECT * FROM keranjang WHERE email_pelanggan='$email_pelanggan'");
				while ($data = $ambi->fetch_assoc()) {
					//mendapatkan data produk berdasarkan id produk
					$id_produk = $data['id_produk'];
					$amb = $koneksi->query("SELECT * FROM produk WHERE id_produk='$id_produk'");
					$produk = $amb->fetch_assoc();
					$jumlah = $data["jumlah"];

					$nama = $produk['nama_produk'];
					$harga = $produk['harga_produk'];

					$subharga = $produk['harga_produk'] * $jumlah;

					$koneksi->query("INSERT INTO pembelian_produk (id_pembelian, id_produk, nama, harga, subharga, jumlah) 
						VALUES ('$id_pembelian_barusan','$id_produk','$nama','$harga','$subharga','$jumlah')");

					//update stok
					// $koneksi->query("UPDATE produk SET stok_produk=stok_produk - $jumlah WHERE id_produk='$id_produk'");
				}

				//menghapus keranjang
				$koneksi->query("DELETE FROM keranjang WHERE email_pelanggan='$email_pelanggan'");

				//tampilan dialihkan ke halaman nota
				echo "<script>location='nota.php?id=$id_pembelian_barusan';</script>";
			}
			?>
		</div>
	</section>
	<!-- Konten -->

	<!-- Footer -->
	<footer class="page-footer bg-dark font-small stylish-color-dark pt-4" style="color: white">

		<!-- Footer Links -->
		<div class="container text-center text-md-left">

			<!-- Grid row -->
			<div class="row">

				<!-- Grid column -->
				<div class="col-md-3">
					<!-- Content -->
					<img class="img-fluid img-thumbnail" src="images/sidoi.jpeg">
				</div>

				<!-- Grid column -->
				<div class="col-md-3 mx-auto">

					<!-- Content -->
					<h5 class="font-weight-bold mt-3 mb-4">Tentang Kami</h5>

					<hr color="white">

					<p>
						Aplikasi “Si-Do'i” (Solusi Dolan Islami) merupakan sebuah aplikasi yang berguna untuk memudahkan
						peziarah dalam melakukan ziarah wali songo.
					</p>

				</div>
				<!-- Grid column -->

				<hr class="clearfix w-100 d-md-none">

				<!-- Grid column -->
				<div class="col-md-3 mx-auto">

					<!-- Links -->
					<h5 class="font-weight-bold mt-3 mb-4">Kontak Kami</h5>

					<hr color="white">

					<ul class="list-unstyled">
						<p>
							<i class="fas fa-home mr-3"></i> Malang, Indonesia
						</p>
						<p>
							<i class="fas fa-envelope mr-3"></i> sido'i@gmail.com
						</p>
						<p>
							<i class="fas fa-phone mr-3"></i> +6282-301-329-134
						</p>
					</ul>
					<!-- Links -->

				</div>
				<!-- Grid column -->

				<hr class="clearfix w-100 d-md-none">

				<!-- Grid column -->
				<div class="col-md-2 mx-auto">

					<!-- Links -->
					<h5 class="font-weight-bold mt-3 mb-4">Sosial Media</h5>

					<hr color="white">

					<ul class="list-unstyled">
						<li class="list-inline-item">
							<a class="mx-1" href="#">
								<i class="fab fa-facebook-f text-light waves-dark"></i>
							</a>
						</li>
						<li class="list-inline-item">
							<a class="mx-1" href="#">
								<i class="fab fa-twitter text-light"></i>
							</a>
						</li>
						<li class="list-inline-item">
							<a class="mx-1" href="#">
								<i class="fab fa-instagram text-light"></i>
							</a>
						</li>
						<li class="list-inline-item">
							<a class="mx-1" href="#">
								<i class="fab fa-youtube text-light"></i>
							</a>
						</li>
					</ul>

				</div>
				<!-- Grid column -->

				<!-- Grid column -->
				<div class="col-md-3">

					<!-- Content -->
					<h5 class="font-weight-bold mt-3 mb-4">Partner Pembayaran</h5>
					<hr color="white">

					<img class="img-fluid img-thumbnail" width="60" height="60" src="images/bri.png">
					<img class="img-fluid img-thumbnail" width="70" height="70" src="images/bca.png">
					<img class="img-fluid img-thumbnail" width="90" height="90" src="images/mandiri.png">

				</div>

			</div>
			<!-- Grid row -->

		</div>
		<!-- Footer Links -->

		<hr>

		<!-- Copyright -->
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="text-center mb-3">
						&copy; Copyright 2022 Si-Do'i. All rights reserved.
					</div>
				</div>
			</div>
		</div>
		<!-- Copyright -->

	</footer>
	<!-- Footer -->
</body>

</html>