<?php
	include 'connect.php';
	if (!isset($_SESSION['email'])) {
		header('location: login.php');
	}
	else if ($_SESSION['email'] != "admintokopetra@gmail.com") {
		header('location: home.php');
	}
?>

<!doctype html>
<html lang="en">
<head>
	<title>Proyek Tekweb</title>

	<?php include('assets/header.php'); ?>
	<script src="js/home_func.js"></script>
	<link rel="stylesheet" type="text/css" href="assets/sidebar_seller.css">
	<link rel="stylesheet" type="text/css" href="css/seller_settings_style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
		.f-12 {
			font-size: 12px;
		}
		
		.f-14 {
			font-size: 14px;
		}
		.f-17 {
			font-size: 17px;
		}
		.f-22 {
			font-size: 22px;
		}
		.w-25 {
			width: 25%;
		}

		
	</style>
</head>
<body>
	<?php include('assets/navbar_seller.php'); ?>

	<div class="fluid-container" style="overflow-x: hidden;">
		<div class="row">
			<?php include('assets/sidebar_seller.php'); ?>
			<div class="col-10 mt-4 ml-3">	
				<h5><i class="fas fa-home my-3"></i>&nbsp; TOKOPETRA </h5>
				<div class="card border-dark">
					<div class="card-header header-btn f-12">
						<a href="#" class="btn-active text-success">Informasi</a>
					</div>
					<!-- Informasi Toko -->
					<div class="card-body p-4">						
						<h6>Informasi Toko</h6>
						<div class="row">
							<div class="col-5 info-toko">
								<p class="f-12 my-2">Slogan</p>
								<input type="text" name="slogan" id="slogan">
								<p class="f-12 my-2">Deskripsi Toko</p>
								<textarea rows="4" class="w-100 textarea" id="deskripsi"></textarea>
								<div class="text-right">
									<input type="button" class="btn btn-success my-2 f-12 btn-simpan" name="simpan" id="simpan" value="Simpan">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
		function load_data() {
			// untuk memberikan info provinsi dan kota
			$.ajax({
				url: "seller_settings_ajax.php",
				method: "GET",
				success: function(result) {
					var slogan = "";
					var deskripsi = "";
					if (result.data) {
						slogan = result.data['slogan'];
						deskripsi = result.data['deskripsi'];
					}
					$('#slogan').val(slogan);
					$('#deskripsi').val(deskripsi);
				},
				error: function(result) {

				}
			});
		}
		$(function(){
			load_data();
		});
		$("[id='simpan']").click(function(){
			var varslogan = $("[id='slogan']").val();
			var vardeskripsi = $("[id='deskripsi']").val();
			$.ajax({
				url: "seller_settings_ajax.php",
				method: "POST",
				data : {slogan:varslogan, deskripsi:vardeskripsi},
				success: function(result) {
					if(result.notif){
						alert(result.notif);
						load_data();
					}
				},
				error: function(result) {

				}
			});
		});
	</script>
</body>
</html>