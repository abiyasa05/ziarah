<?php
session_start();
//koneksi ke database
include "koneksi.php";

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
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <style>
        .cards-wrapper {
            display: flex;
            justify-content: center;
        }

        .card img {
            max-width: 100%;
            max-height: 100%;
        }

        .card {
            margin: 0 0.5em;
            box-shadow: 2px 6px 8px 0 rgba(22, 22, 26, 0.18);
            border: none;
            border-radius: 0;
        }

        .carousel-inner {
            padding: 1em;
        }

        .carousel-control-prev,
        .carousel-control-next {
            background-color: #e1e1e1;
            width: 5vh;
            height: 5vh;
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
        }

        @media (min-width: 768px) {
            .card img {
                height: 11em;
            }
        }
    </style>

    <title>SI - DO'I Panduan Doa</title>

    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/brands.min.css">
    <link rel="stylesheet" href="assets/css/solid.min.css">

    <!-- JS -->
    <script src="/scripts/jquery.min.js"></script>
    <script src="assets/js/solid.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/fontawesome.min.js"></script>
    <script src="assets/js/brands.min.js"></script>
</head>

<body>
    <!--Navbar -->
    <nav class="mb-1 navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="tour_builder.php">SI - DO'I</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-333" aria-controls="navbarSupportedContent-333" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent-333">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="tour_builder.php">Tour Builder
                        <span class="sr-only">(current)</span>
                    </a>
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
    <!-- /javascript-->

    <!-- konten -->
    <section class="riwayat">
        <div class="container" style="margin-bottom: 50px;">
            <h2 style="margin-top: 35px;">Panduan Doa <?php echo $_SESSION["pelanggan"]["nama_pelanggan"]; ?></h2>

            <hr color="black">

            <table class="table table-bordered table-responsive-md">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $nomor = 1;

                    //mendapatkan email_pelanggan yang login dari session
                    $email_pelanggan = $_SESSION["pelanggan"]['email_pelanggan'];

                    $ambil = $koneksi->query("SELECT * FROM pembelian WHERE email_pelanggan='$email_pelanggan'");
                    while ($pecah = $ambil->fetch_assoc()) {
                    ?>
                        <tr>
                            <td><?php echo $nomor; ?></td>
                            <td><?php echo $pecah["tanggal_pembelian"]; ?></td>
                            <td>
                                <?php echo $pecah["status_pembelian"]; ?>
                                <br>
                                <?php if (!empty($pecah['resi_pengiriman'])) : ?>
                                    <strong>
                                        Resi: <?php echo $pecah['resi_pengiriman']; ?>
                                    <?php endif ?>
                                    </strong>
                            </td>
                            <td>Rp. <?php echo number_format($pecah["total_pembelian"]); ?></td>
                            <td>
                                <a href="nota.php?id=<?php echo $pecah["id_pembelian"] ?>" class="btn btn-info mb-1">Nota</a>

                                <?php if ($pecah['status_pembelian'] == "pending") : ?>
                                    <a href="pembayaran.php?id=<?php echo $pecah["id_pembelian"]; ?>" class="btn btn-success mb-1">
                                        Input Pembayaran
                                    </a>
                                <?php elseif ($pecah['status_pembelian'] == "sudah kirim pembayaran" || $pecah['status_pembelian'] == "barang dikirim") : ?>
                                    <a href="lihat_pembayaran.php?id=<?php echo $pecah["id_pembelian"]; ?>" class="btn btn-secondary mb-1">
                                        Lihat Pembayaran
                                    </a>
                                <?php else : ?>
                                    <a href="hapuspembelian.php?id=<?php echo $pecah["id_pembelian"] ?>" class="btn btn-danger mb-1" onclick="return confirm('Apakah anda yakin ingin menghapus ini?')">
                                        Hapus
                                    </a>
                                <?php endif ?>
                                <?php if ($pecah['status_pembelian'] == "pending") : ?>
                                    <a href="batalpembelian.php?id=<?php echo $pecah["id_pembelian"] ?>" class="btn btn-warning mb-1" onclick="return confirm('Apakah anda yakin ingin membatalkan ini?')">Batalkan</a>
                                <?php endif ?>
                            </td>
                        </tr>
                        <?php $nomor++; ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </section>
    <!-- /konten -->

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