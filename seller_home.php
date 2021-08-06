<?php
	include 'connect.php';
	if (!isset($_SESSION['email'])) {
		header('location: login.php');
	}
	else if ($_SESSION['email'] != "admintokopetra@gmail.com") {
		header('location: home.php');
	}
?>

<!DOCTYPE html>
<html>

<head>
	<title>Proyek Tekweb</title>
	<?php include('assets/header.php'); ?>
	<script src="js/all_home_func.js"></script>
	<script src="js/seller_home_func.js"></script>
	<link rel="stylesheet" type="text/css" href="assets/sidebar_seller.css">
	<link rel="stylesheet" type="text/css" href="css/seller_home_style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
	<?php include('assets/navbar_seller.php'); ?>

	<div class="fluid-container" style="overflow-x: hidden;">
		<div class="row">
			<?php include('assets/sidebar_seller.php'); ?>
			<div class="col-10 ml-3 mt-4">
				<h4>Penting hari ini</h4>
				<div class="row">
					<div class="card col-3 m-2 border rounded glow">
						<div class="card-content">
							<p>Pesanan baru</p>
							<div id="pesananBaru"> </div>
						</div>
					</div>
					<div class="card col-3 m-2 border rounded glow">
						<div class="card-content">
							<p>Siap dikirim</p>
							<div id="siapDikirim"> </div>
						</div>
					</div>
					<div class="card col-3 m-2 border rounded glow">
						<div class="card-content">
							<p>Komplain pesanan</p>
							<div id="komplainPesanan"> </div>
						</div>
					</div>
					<div class="card col-3 m-2 border rounded glow">
						<div class="card-content">
							<p>Diskusi baru</p>
							<div id="diskusiBaru"> </div>
						</div>
					</div>
					<div class="card col-3 m-2 border rounded glow">
						<div class="card-content">
							<p>Ulasan baru</p>
							<div id="ulasanBaru"> </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>

</html>