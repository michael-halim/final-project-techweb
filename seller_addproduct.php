<?php
include $_SERVER['DOCUMENT_ROOT']."/tokopetra/connect.php";

if(isset($_GET['stat'])){
	if($_GET['stat'] == 1){
		echo "<script>alert('Pastikan semua field terisi!');</script>";
	}
	else if($_GET['stat'] == 2){
		echo "<script>alert('Produk berhasil ditambahkan!');</script>";
	}
	else if($_GET['stat'] == 400){
		echo "<script>alert('ERROR : Bad Request!');</script>";
	}
}
?>

<!doctype html>
<html lang="en">
<head>
	<title>Proyek Tekweb</title>

	<?php include('assets/header.php'); ?>
	<script src="js/home_func.js"></script>
	<link rel="stylesheet" type="text/css" href="assets/sidebar_seller.css">
	<link rel="stylesheet" type="text/css" href="css/seller_addproduct_style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<?php include('assets/navbar_seller.php'); ?>

	<div class="fluid-container" style="overflow-x: hidden;">
		<div class="row">
			<?php include('assets/sidebar_seller.php'); ?>
			<form action="seller_addproduct_action.php" method="POST" enctype="multipart/form-data">
				<div class="col-12 mt-4">
					<h4>Add Product</h4>
					<!-- Foto Produk -->
					<div class="col-10 border border-secondary rounded p-4 my-3">
						<h5>Upload Produk</h5>
						<br>
						<p class="f-12">Format gambar .jpg .jpeg .png dan ukuran minimum 300 x 300px (Untuk gambar optimal gunakan ukuran minimum 700 x 700 px)</p>
						<div class="text-center my-3">
							<!-- Submit -->
							<input type="file" value="+ Pilih Gambar Produk" name="file" id="file" class="btn btn-outline-success rounded text-center">
						</div>
					</div>
					<div class="col-10 border border-secondary rounded p-4">
						<h5>Informasi Produk</h5>
						<br>
						<!-- Nama Produk -->
						<div class="row my-3">
							<div class="col-4">
								<h6>Nama Produk</h6>
							</div>
							<div class="col-8 text-right">
								<input type="text" name="nama" id="nama" placeholder="Input nama produk">
							</div>
						</div>
						<!-- Kategori -->
						<div class="row my-3">
							<div class="col-4">
								<h6>Kategori</h6>
							</div>
							<div class="col-8">
								<select id="kategori" name="kategori">

								</select>
							</div>
						</div>
					</div>

					<!-- Detail Produk -->
					<div class="col-10 border border-secondary rounded p-4 my-3">
						<h5>Detail Produk</h5>
						<br>
						<!-- Kondisi -->
						<div class="row my-3">
							<div class="col-4">
								<h6>Kondisi</h6>
							</div>
							<div class="col-8">
								<div class="form-check-inline">
									<label class="form-check-label">
										<input type="radio" class="form-check-input radio-btn" name="kondisi" id="kondisi" value="baru" checked>
										Baru
									</label>
								</div>
								<div class="form-check-inline">
									<label class="form-check-label">
										<input type="radio" class="form-check-input radio-btn" name="kondisi" id="kondisi" value="bekas">
										Bekas
									</label>
								</div>
							</div>
						</div>
						<!-- Deskripsi Produk -->
						<div class="row my-3">
							<div class="col-4">
								<h6>Deskripsi Produk</h6>
								<p class="f-12">Pastikan deskripsi produk memuat spesifikasi, ukuran, bahan, masa berlaku, dan lainnya. Semakin detail, semakin berguna bagi pembeli.
								</p>
							</div>
							<div class="col-8">
								<textarea rows="13" class="w-100 textarea"
								placeholder="Input deskripsi produk" id="deskripsi" name="deskripsi"></textarea>
							</div>
						</div>
					</div>

					<!-- Harga -->
					<div class="col-10 border border-secondary rounded p-4 my-3">
						<h5>Harga</h5>
						<br>
						<!-- Harga Satuan -->
						<div class="row my-3">
							<div class="col-4">
								<h6>Harga Satuan</h6>
							</div>
							<div class="col-8">
								<div class="box-harga">
									<div class="rp">Rp</div>
									<input type="text" name="harga" id="harga" placeholder="Masukkan Harga" onkeypress="return isNumber(event)" onpaste="return false;">
								</div>

							</div>
						</div>
					</div>

					<!-- Pengelolaan Produk -->
					<div class="col-10 border border-secondary rounded p-4 my-3">
						<h5>Pengelolaan Produk</h5>
						<br>
						<!-- Stok Produk -->
						<div class="row my-3">
							<div class="col-4">
								<h6>Stok Produk</h6>
							</div>
							<div class="col-8">
								<input type="text" name="stok" id="stok" placeholder="Input jumlah stok" onkeypress="return isNumber(event)" onpaste="return false;">
							</div>
						</div>
					</div>

					<!-- Berat & Pengiriman-->
					<div class="col-10 border border-secondary rounded p-4 my-3">
						<h5>Berat & Pengiriman</h5>
						<br>
						<!-- Stok Produk -->
						<div class="row my-3">
							<div class="col-4">
								<h6>Berat Produk</h6>
								<p class="f-12">Masukkan berat dengan menimbang produk setelah dikemas.</p>
							</div>
							<div class="col-8">
								<input type="text" name="berat" id="berat" class="w-50" placeholder="Input berat produk" onkeypress="return isNumber(event)" onpaste="return false;">
								<select id="satuanBerat" name="satuanBerat" style="width: 40%;">

								</select>
							</div>
						</div>
					</div>
					<div class="row my-3 text-right">
						<div class="col-10 footer-btn">
							<input type="submit" class="btn btn-success ml-1 f-12 font-weight-bold" id="add-product-btn" value="Simpan">
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	<script>
		function isNumber(evt) {
			evt = (evt) ? evt : window.event;
			var charCode = (evt.which) ? evt.which : evt.keyCode;
			if ( (charCode > 31 && charCode < 48) || charCode > 57) { return false; }
			return true;
		}
		function isnotNumber(evt) {
			evt = (evt) ? evt : window.event;
			var charCode = (evt.which) ? evt.which : evt.keyCode;
			if ( (charCode > 32 && charCode < 65) || charCode > 90 && charCode < 97 || charCode > 122) { return false; }
			return true;
		}
		$(function(){
			// get kategori
			$.ajax({
				url: "get_kategori.php",
				method: "GET",
				success: function(result) {
					$("#kategori").html('<option value="" hidden>Pilih Kategori</option>');
					result.forEach(function(kategori){
						var row = $("<option value=" + kategori['id'] + ">" + kategori['nama'] +"</option>");
						$("#kategori").append(row);
					});
				},
				error: function(result) {

				}
			});
			$.ajax({
				url: "get_berat.php",
				method: "GET",
				success: function(result) {
					$("#satuanBerat").html('<option value="" hidden>Pilih Satuan</option>');
					result.forEach(function(berat){
						var row = $("<option value=" + berat['id'] + ">" + berat['nama'] +"</option>");
						$("#satuanBerat").append(row);
					});
				},
				error: function(result) {

				}
			});
		});
	</script>

</body>
</html>