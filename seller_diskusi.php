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
	<link rel="stylesheet" type="text/css" href="css/seller_diskusi_style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<?php include('assets/navbar_seller.php'); ?>
	<div class="fluid-container" style="overflow-x: hidden;">
		<div class="row">
			<?php include('assets/sidebar_seller.php'); ?>
			<div class="col-10 mt-4 ml-3">
				<h4>Diskusi</h4>
				<div class="row no-gutters">
					<div class="card col-10 border border-dark rounded">
						<div class="card-body no-gutters">
							<span>Tampilkan</span>
							<input type="button" class="btn btn-outline-success mx-1 pilihan text-white bg-success" id="semuaDiskusi" value="Semua">
							<input type="button" class="btn btn-outline-success mx-1 pilihan" id="belumDibalas" value="Belum Dibalas">
							<!-- Diskusi 1 -->
							<div class="no-gutters" id="replace">
							</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
		$(".pilihan").click(function(){
			$(".pilihan").removeClass("text-white");
			$(".pilihan").removeClass("bg-success");
			$(this).addClass("text-white");
			$(this).addClass("bg-success");
			load_data();
		});
		function load_data() {
			var varkondisiterbaca;
			if ($("#semuaDiskusi").hasClass("bg-success")) {
				varkondisiterbaca = 1;
			}
			else if ($("#belumDibalas").hasClass("bg-success")) {
				varkondisiterbaca = 0;
			}
			$.ajax({
				url: "seller_diskusi_ajax.php",
				method: "GET",
				async: false,
				data: {kondisiterbaca:varkondisiterbaca},
				success: function(row) {
					var output = '';
					var count = 0;
					row.forEach(function(datadiskusi) {
						output += '<div class="card col-12 border border-dark rounded my-3">'+
							'<div class="card-header">'+
								'<div class="row">'+
									'<!-- Gambar barang -->'+
									'<div class="col-1">'+
										'<img src="img/'+datadiskusi['gambar']+'" width="40px" height="40px" class="rounded">'+
									'</div>'+
									'<!-- Nama barang, harga -->'+
									'<div class="col-6">'+
										'<a href = "item.php?nama='+ datadiskusi['produk'] +'" class="product-name" id="namaProduk">'+datadiskusi['produk']+'</a>'+
										'<span class="product-price">'+datadiskusi['harga']+'</span>'+
									'</div>'+
									'<!-- Like, add to card, buy button -->'+
									'<div class="col-5 text-right">'+
										'<button type="button" class="btn btn-outline-dark deletebutton" data-produk="'+datadiskusi['produk']+'" data-nama="'+datadiskusi['pengirim']+'"><i class="fas fa-trash"></i></button>'+
									'</div>'+
								'</div>'+
							'</div>'+
							'<div class="card-body">'+
								'<div class="row">';
						$.ajax({
							url: "seller_diskusi_ajax.php",
							method: "GET",
							async: false,
							data: {kondisiterbaca:2,produk:datadiskusi['produk'], nama:datadiskusi['pengirim']},
							success: function(message) {
								message.forEach(function(datamessage) {
									output += '<div class="col-11">'+
												'<span class="product-name" id="namaOrang">'+datamessage['pengirim']+'</span>'+
												'<span class="datetime"> &nbsp; • '+datamessage['tanggal']+' - '+datamessage['jam']+'</span>'+
												'<p>'+datamessage['message']+'</p>'+
											'</div>';
								});
							}
						});
						output += '</div>'+
									'</div>'+
									'<div class="card-footer no-gutters">'+
										'<div class="row ml-5">'+
											'<div class="col-11 text-right">'+
												'<input type="text" class="border border-dark rounded p-1 w-100" id="'+count+'" placeholder="Isi komentar disini...">'+
												'<button type="button" class="btn submit" data-produk="'+datadiskusi['produk']+'" data-nama="'+datadiskusi['pengirim']+'" data-text="'+count+'"><i class="fas fa-paper-plane"></i></button>'+
											'</div>'+
										'</div>'+
									'</div>'+
								'</div>';
						count++;
					});
					$("#replace").html(output);
				}
			});
		}
		$(function(){
			load_data();
		});
		$('body').on('click', '.submit', function(){
			var text = $(this).data('text');
			text = '#'+text;
			text = $(text).val();
			var produk = $(this).data('produk');
			var nama = $(this).data('nama');
			$.ajax({
				url: "seller_diskusi_ajax.php",
				method: "POST",
				data: {type:0,text:text,produk:produk,nama:nama},
				success: function(result) {
					if(result.notif){
						alert(result.notif);
					}
					load_data();
				}
			});
		});
		$('body').on('click', '.deletebutton', function(){
			var produk = $(this).data('produk');
			var nama = $(this).data('nama');
			$.confirm({
				title: 'Confirm!',
				content: 'You cannot recover deleted data!',
				autoClose: 'cancel|10000',
				buttons: {
					confirm: {
						text: 'Confirm',
						btnClass: 'btn-success',
						keys: ['enter'],
						action: function(){
							$.ajax({
								url: "seller_diskusi_ajax.php",
								method: "POST",
								data: {type:1,produk:produk,nama:nama},
								success: function(result) {
									if(result.notif){
										alert(result.notif);
									}
									load_data();
								}
							});
						}
					},
					cancel: {
						text: 'Cancel',
						btnClass: 'btn-secondary',
						keys: ['shift'],
						action: function(){
							// alert("Cancel");
						}
					}
				}
			});
		});
	</script>
</body>
</html>