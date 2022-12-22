<h2>Detail Pembelian</h2>
<hr color="black">

<?php
	$ambil = $koneksi->query("SELECT * FROM pembelian JOIN pelanggan
		ON pembelian.email_pelanggan=pelanggan.email_pelanggan
		WHERE pembelian.id_pembelian='$_GET[id]'");
	$detail = $ambil->fetch_assoc();
?>

<div class="row">
	<div class="col-md-4">
		<h4>Pembelian</h4>
		<p>
			Tanggal: <?php echo $detail['tanggal_pembelian']; ?> <br>
			Total: Rp. <?php echo number_format($detail['total_pembelian']); ?> <br>
			Status: <?php echo $detail['status_pembelian']; ?>
		</p>
	</div>
	<div class="col-md-4">
		<h4>Pelanggan</h4>
		<p>
			<strong>Nama: <?php echo $detail['nama_pelanggan']; ?></strong> <br>
			<?php echo $detail['telepon_pelanggan']; ?> <br>
			<?php echo $detail['email_pelanggan']; ?>
		</p>
	</div>
	<div class="col-md-4">
		<h4>Pengiriman</h4>
		<p>
			<strong>Lokasi pulau: <?php echo $detail["nama_pulau"]; ?></strong> <br>
			Tarif: Rp. <?php echo number_format($detail["tarif"]); ?> <br>
			Alamat: <?php echo $detail["alamat_pengiriman"]; ?>
		</p>
	</div>
</div>

<table class="table table-bordered">
	<thead>
		<tr>
			<th>No</th>
			<th>Nama Produk</th>
			<th>Harga</th>
			<th>Jumlah</th>
			<th>Subtotal</th>
		</tr>
	</thead>
	<tbody>
		<?php $nomor=1; ?>
		<?php $ambil=$koneksi->query("SELECT * FROM pembelian_produk JOIN produk
			ON pembelian_produk.id_produk=produk.id_produk
			WHERE pembelian_produk.id_pembelian='$_GET[id]'"); ?>
		<?php while($pecah=$ambil->fetch_assoc()) { ?>
		<tr>
			<td><?php echo $nomor; ?></td>
			<td><?php echo $pecah['nama_produk']; ?></td>
			<td>Rp. <?php echo number_format($pecah['harga_produk']); ?></td>
			<td><?php echo $pecah['jumlah']; ?></td>
			<td>
				Rp. <?php echo number_format($pecah['harga_produk']*$pecah['jumlah']); ?>
			</td>
		</tr>
		<?php $nomor++; ?>
		<?php } ?>
	</tbody>
</table>