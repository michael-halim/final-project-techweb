<?php
	include 'connect.php';
	if(isset($_SESSION['email'])){
		$email = $_SESSION['email'];
		$getUserSQL = "SELECT id FROM user WHERE email = '$email' LIMIT 1";
		$getUserID = $pdo->prepare($getUserSQL);
		$stmtUser = $pdo->query($getUserSQL);
		$getUserID = $stmtUser->fetch();
		$getCartSQL = "SELECT i.id AS id ,i.nama AS nama, i.harga AS harga, k.qty AS qty, i.gambar AS gambar
					   FROM keranjang k 
					   JOIN user u 
					   ON u.id = k.id_user
					   JOIN item i 
					   ON i.id = k.id_item
					   WHERE k.id_user = ?";
		$stmtCart = $pdo->prepare($getCartSQL);
		$stmtCart->execute([$getUserID['id']]);
	}
	else{
		header('Location: login.php');
	}
?>
<!doctype html>
<html lang="en">
<head>
	<title>Keranjang</title>
	
	<?php include('assets/header.php'); ?>
	<link rel="stylesheet" href="css/cart_style.css">
	<script src="js/cart_func.js"></script>
	<script>
		$(document).ready(function(){
			var type = 'show';
			var userID = "<?php echo $getUserID['id']; ?>";
			
			$.ajax({
				url: 'cart_action.php',
				method: 'POST',
				data: {
					userID:userID,
					type:type
				},
				success: function(result){
					$('.product-wrapper').html(result.output);
					$('.wrapper-harga').html(result.hargaTotal);
				}
			});
			$('#checkAllBox').change(function(){
				$("input:checkbox.custom-control-input").prop('checked',this.checked);
			});
			var tempDeleteID;
			$('body').on('click','.remove',function(){
				tempDeleteID = $(this).closest('.root').attr('class');
				tempDeleteID = tempDeleteID.substr(12,tempDeleteID.length);
				$('#confirmDeleteEach').modal('show');
			});
			$('#executeDeleteEach').click(function(){
				$('#confirmDeleteEach').modal('toggle');
				type = 'delete';
				$.ajax({
				    url: 'cart_action.php',
				    method: 'POST',
				    data: {
							itemID:tempDeleteID,
							userID:userID,
							type:type,
							counter: 0
				    },
				    success: function(result){
						$('.product-wrapper').html(result.output);
						$('.wrapper-harga').html(result.hargaTotal);
				    }
				});
			});	
			$('body').on('click','.plus',function(){
				var obj = $(this).closest('.row .text-right');
				var className = obj.find('div:eq(3)').attr('class');
				className = className.substr(6,16);
				var counter = parseInt($('.' + className).text());  
				$('.' + className).html(++counter);
				var minColor = obj.find('div:eq(2)').find('svg').attr('fill', 'rgb(3, 172, 14)');
				var itemID = $(this).closest('.root').attr('class');
				itemID = itemID.substr(12,itemID.length);

				$.ajax({
				    url: 'cart_action.php',
				    method: 'POST',
				    data: {
							itemID:itemID,
							userID:userID,
							type: 'add',
							counter:counter
				    },
				    success: function(result){
						$('.product-wrapper').html(result.output);
						$('.wrapper-harga').html(result.hargaTotal);
				    }
				});
			});
			$('.min').ready(function(){
				var obj = $('.min').closest('.row .text-right');
				var className = obj.find('div:eq(3)').attr('class');
				className = className.substr(6,16);
				var counter = parseInt($('.' + className).text());  
				
				if(counter <= 1){
					$('.min').attr('fill','rgba(49, 53, 59, 0.32)');   
				}
				else{
					$('.min').attr('fill', 'rgb(3, 172, 14)');
				}
			});
			$('body').on('click','.min',function(){
				var obj = $(this).closest('.row .text-right');
				
				var className = obj.find('div:eq(3)').attr('class');
				className = className.substr(6,16);
				var counter = parseInt($('.' + className).text());  
				counter--;
				if(counter < 1){
					$('.min').attr('fill','rgba(49, 53, 59, 0.32)');                    
				}
				else{
					$('.' + className).html(counter);
					
					if (counter < 1) {
						$('.min').attr('fill','rgba(49, 53, 59, 0.32)');     
					}
					
					var itemID = $(this).closest('.root').attr('class');
					itemID = itemID.substr(12,itemID.length);
					$.ajax({
						url: 'cart_action.php',
						method: 'POST',
						data: {
								itemID:itemID,
								userID:userID,
								type: 'min',
								counter:counter
						},
						success: function(result){
							$('.product-wrapper').html(result.output);
							$('.wrapper-harga').html(result.hargaTotal);
						}
					});               
				}
			});
		});
	</script>
</head>
<body>
	<?php include('assets/navbar.php'); ?>
	<div class="container my-5" style="max-width:75%;">
		<div class="row">
			<div class="col-7">
				<b>Nama Toko</b>
				<hr class="line line-4px">
				<div class="product-wrapper">
					<?php while($rowDetail = $stmtCart->fetch()) {?>
						<div class="root Product<?php echo $rowDetail['id'];?>">
							<div class="row my-3">
								
								<div class="col-3 mt-mb-auto"><img src="img/<?php echo $rowDetail['gambar'];?>" alt="Gambar" width="90px;"></div>
								<div class="col-8 mt-mb-auto">
									<b><?php echo $rowDetail['nama'];?></b> <br>
									<b><?php $angka = $rowDetail['harga']; 
											echo "Rp. " . number_format($angka, 2, ",", ".");
										?>
									</b>
								</div>
							</div>
							<div class="row text-right">                    
								<div class="col-8"></div>
								<div class="col-1">
									<svg width="25px" height="25px" viewBox="0 0 16 16" class="remove bi bi-trash clicky" fill="rgba(49, 53, 59, 0.32)" xmlns="http://www.w3.org/2000/svg">
										<path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
										<path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
									</svg>
								</div>
								<div class="col-1">
									<svg width="25px" height="25px" viewBox="0 0 16 16" class="min bi bi-dash-circle clicky" fill="" xmlns="http://www.w3.org/2000/svg">
										<path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
										<path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z"/>
									</svg>
								</div>
								<div id= "qty" class="col-1 counterProduct<?php echo $rowDetail['id'];?> text-center" style="border-bottom:1px solid rgba(49, 53, 59, 0.32);">
									<?php echo $rowDetail['qty'];?>          
								</div> 
								
								<div class="col-1">
									<svg width="25px" height="25px" viewBox="0 0 16 16" class="plus bi bi-plus-circle-fill clicky" fill="rgb(3, 172, 14)" xmlns="http://www.w3.org/2000/svg">
										<path fill-rule="evenodd" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
									</svg>
								</div>
							</div>
							<hr class="line line-4px">
						</div>
					<?php } ?>
				</div>
				
                <!-- modal remove -->
                <div class="modalDeleteEach modal fade" id="confirmDeleteEach" tabindex="-1">
						<div class="modal-dialog round" style="max-width:400px; max-height:200px;">
							<div class="modal-content">
								<div class="modal-body">
									<div class="text-center"><h3><b>Hapus Barang ?</b></h3></div> <br>
									<div class="text-center">Barang ini akan dihapus dari keranjangmu.</div>
									<br><br> 
									<div class="row">
										<div class="col-6 text-center"> <button type="button" class="btn btn-block greenBorder h-48" data-dismiss="modal"><b class="cGreen"> Kembali</b></button></div>
										<div class="col-6 text-center"><button type="button" id="executeDeleteEach" class="btn btn-success btn-block h-48"> <b style="color:white;">Hapus Barang</b>  </button></div>    
									</div>
								</div>
							</div>
						</div>
					</div>
			</div>
			<div class="col-4 ml-5 text-right round float-effect" style="max-width:350px; max-height:220px;">
                <div class="row">
                    <div class="col-12 text-left my-2">
                        <div class="receiptBox" >
                            <b>Ringkasan Belanja</b>
                            <div class="row my-3 f-15" style="font-family:Sans-serif;">
								<div class="col-12 ml-3">Total Harga</div>
							</div>
							<div class="row">
								<div class="col-12 wrapper-harga">
									
								</div>
							</div>
                        </div>
                    </div>
                    <div class="col-12 text-center my-3">
                        <a href="checkout.php">
							<button type="button" class="btn btn-block bgOrange round h-60 buy">
								<b class="cWhite">Beli</b>
							</button>
						</a>
                    </div>
                </div>
            </div>
		</div>
	</div>
</body>
</html>