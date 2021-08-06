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
	<link rel="stylesheet" type="text/css" href="css/seller_penjualan_style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script>
		$(function() {
			$.ajax ({
				url:'seller_penjualan_ajax.php',
				method:'POST',
				data: {
					id_status : '1',
					type : 'ready',
					id_trf : 0
				},
				success:function(data) {
					$('#wrapper-item').html(data.output);
				},
				error:function(data) {

				}
			});
			$(".bt").click(function() {
				$(".bt").removeClass("btn-active text-success");
				$(this).addClass("btn-active text-success");

				var id_status = $(this).data('id');

				$.ajax ({
					url:'seller_penjualan_ajax.php',
					method:'POST',
					data: {
						id_status : id_status,
						type : 'page',
						id_trf : 0
					},
					success:function(data) {
						$('#wrapper-item').html(data.output);
					},
					error:function(data) {

					}
				});
			});
			$('body').on('click', '.terima-pesanan', function(){
				var id_trf = $(this).data('idtrf');
				$.ajax ({
					url:'seller_penjualan_ajax.php',
					method:'POST',
					data: {
						id_status : '1',
						type : 'update',
						id_trf : id_trf
					},
					success:function(data) {
						alert("Pesanan diterima!");
						$('#wrapper-item').html(data.output);
					},
					error:function(data) {

					}
				});
			});
		});
	</script>
</head>
<body>
	<?php include('assets/navbar_seller.php'); ?>

	<div class="fluid-container" style="overflow-x: hidden;">
		<div class="row no-gutters">

			<?php include('assets/sidebar_seller.php'); ?>

			<div class="col-10 mt-4 ml-3">
				<h4>Daftar Pesanan</h4>
				<div class="card border-dark my-3">

					<div class="card-header header-btn f-12">
						<a href="#" class="bt btn-active text-success" data-id="1">Menunggu Konfirmasi</a>
						<a href="#" class="bt" data-id="3">Sedang Dikirim</a>
						<a href="#" class="bt" data-id="4">Sampai Tujuan</a>
					</div>
				</div>
				
				<div class="row no-gutters" id="wrapper-item">

				</div>
			</div>			
		</div>
	</div>
</body>
</html>