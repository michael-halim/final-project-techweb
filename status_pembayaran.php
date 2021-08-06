<?php
include 'connect.php';
if(isset($_SESSION['email'])){
	$email = $_SESSION['email'];
}
else{
	echo "<script>alert('Harap Login Terlebih Dahulu');</script>";
	header('Location: login.php');
}?>
<!doctype html>
<html lang="en">
<head>
	<title>Status Pembayaran</title>
	<?php include('assets/header.php'); ?>
	<link rel="stylesheet" href="css/status_pembayaran_style.css">
	<script src="js/status_pembayaran_func.js"></script>
	<script>
		$(document).ready(function(){
			$.ajax({
				url:'status_pembayaran_action.php',
				method: 'POST',
				data:{
					type:'show',
					id_status: '1'
				},
				success: function(result){
					$('.wrapper-transaksi').html(result.outputTrf);
				}
			});
			$('body').on('click','#deleteTrf',function(){
				var id_trf = $(this).data('idtrf');
				
				$.ajax({
					url:'status_pembayaran_action.php',
					method:'POST',
					data:{
						id_trf: id_trf,
						type:'delete',
						id_status:'1'
					},
					success: function(result){
						$('.wrapper-transaksi').html(result.outputTrf);
					}
				});
			});
			$('body').on('click','#arrivedBtn',function(){
				var id_trf = $(this).data('idtrf');
				$.ajax({
					url:'status_pembayaran_action.php',
					method:'POST',
					data:{
						id_trf: id_trf,
						type:'update',
						id_status: '3'
					},
					success: function(result){
						$('.wrapper-transaksi').html(result.outputTrf);
					}
				});
			});
			$('.btnStatus').click(function(){
				$('.btnStatus').removeClass('text-white bg-success');
				$(this).addClass('text-white bg-success');

				var id_status = $(this).data('id');
				
				$.ajax({
					url:'status_pembayaran_action.php',
					method:'POST',
					data:{
						id_status:id_status,
						type: 'change_page'
					},
					success: function(result){
						$('.wrapper-transaksi').html(result.outputTrf);
					}
				});	
			});
		});
	</script>
</head>
<body>
	<?php include('assets/navbar.php'); ?>
	<div class="container my-5" style="max-width:75%;">
		<div class="row">
			<div class="col-12 border">
				<div class="row my-2 m-1 text-center">
					<div class="col-4"><b data-id = "1" class="btnStatus btn btn-block clicky text-white bg-success">Menunggu Konfirmasi</b></div>
					<div class="col-4"><b data-id = "3" class="btnStatus btn btn-block clicky">Sedang Dikirim</b></div>
					<div class="col-4"><b data-id = "4" class="btnStatus btn btn-block clicky">Paket Telah Diterima</b></div>
				</div>

				<div class='wrapper-transaksi my-4'>
					<!-- Isi Halaman Yang dirubah - rubah -->
				</div>
			</div>
		</div>
	</div>
</body>
</html>
