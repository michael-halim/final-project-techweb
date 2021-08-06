<?php
include 'connect.php';

if($_SERVER['REQUEST_METHOD'] == 'GET'){
	$itemName = $_GET['nama'];
	//SQL 
	$sql = "SELECT i.nama AS nama_barang, gambar , harga , stock_tersisa , nominal_berat , deskripsi, b.nama AS satuan_berat, k.nama AS kondisi
			FROM item i 
			JOIN berat b 
			ON b.id = i.id_berat
			JOIN kondisi k 
			ON k.id = i.id_kondisi	
			WHERE i.nama = '$itemName'
		";
	//SQL Prepare
	$stmt = $pdo->prepare($sql);
	//SQL Query
	$stmt = $pdo->query($sql);
	
	$catatanToko = "SELECT * FROM catatan_toko";
	$stmtToko = $pdo->prepare($catatanToko);
	$stmtToko = $pdo->query($catatanToko);
	
	$kota = "SELECT * FROM kota";
	$stmtKota = $pdo->prepare($kota);
	$stmtKota = $pdo->query($kota);

	$review =  "SELECT i.nama AS nama_barang,  k.nama AS kondisi, u.message , u.rating ,DATE_FORMAT(u.tanggalwaktu, '%M, %d %Y %H:%i') AS tanggalwaktu, user.nama
				FROM item i 
				JOIN kondisi k 
				ON k.id = i.id_kondisi	
				JOIN ulasan u 
				ON u.id_item = i.id
				JOIN user 
				ON user.id = u.id_user
				WHERE i.nama = '$itemName'
				";
				
	$stmtReview = $pdo->prepare($review);
	$stmtReview = $pdo->query($review);

	$stat = "SELECT AVG(rating) AS avgRating ,COUNT(i.nama) AS totalReview
			 FROM item i 
			 JOIN ulasan u 
			 ON u.id_item = i.id
			 JOIN user 
			 ON user.id = u.id_user
			 WHERE i.nama = '$itemName'
			 ";
	$stmtStat = $pdo->prepare($stat);
	$stmtStat = $pdo->query($stat);
}
if(isset($_SESSION['email'])){
	if($_SERVER['REQUEST_METHOD'] == 'GET'){
		$itemName = $_GET['nama'];
		$email = $_SESSION['email'];
		$getUserSQL = "SELECT id FROM user WHERE email = '$email' LIMIT 1";
		$getItemSQL = "SELECT id from item WHERE nama = '$itemName' LIMIT 1";	

		$getUserID = $pdo->prepare($getUserSQL);
		$getItemID = $pdo->prepare($getItemSQL);

		$stmtUser = $pdo->query($getUserSQL);
		$stmtItem = $pdo->query($getItemSQL);

		$getUserID = $stmtUser->fetch();
		$getItemID = $stmtItem->fetch();

		$_SESSION['id'] = $getUserID['id'];
	}
}
?>

<!doctype html>
<html lang="en">
<head>
	<title>Proyek Tekweb</title>

	<?php include('assets/header.php'); ?>
	<link rel="stylesheet" href="css/item_style.css">
	<script src="js/item_func.js"></script>
	<script>
		$(document).ready(function(){
			$('#addToCartButton').click(function(){
				var userID = "<?php echo $getUserID['id'];?>";
				var itemID = "<?php echo $getItemID['id'];?>";

				$.ajax({
					url: 'item_action.php',
					method: 'POST',
					data : {userID: userID, itemID : itemID}, 
					success: function(result){
						if(result.data == '1'){
							$('#addToCart').modal('show');
						}
					}
				});
			});
		});
	</script>
</head>
<body>
	<?php
		if(isset($_SESSION['email'])) {
			if($_SESSION['email'] == "admintokopetra@gmail.com") {
				include('assets/navbar_seller.php');
			}
			else {
				include('assets/navbar.php');
			}
		}
		else {
			include('assets/navbar.php');
		}
	?>
	<div class="container-fluid">
		<?php while($row = $stmt->fetch()) { ?>
		<div class="keranjang" style="">
			<div class="row">
				<div class="col-6"></div>
				<div class="col-6">
					<div class="row">
						<div class="col-6 text-center">
							<b style="color:grey;">Total</b>	
							<br>
							<b>
								<?php 
									$angka = $row['harga']; 
									echo "Rp. " . number_format($angka, 2, ",", ".");
								?>
							</b>	
						</div>
						<div class="col-6 text-left">
							<div class="text-left m-2 mr-5"><input id="addToCartButton" type="button" data-toggle="modal" class="btn btn-warning cWhite bold" value="+ Keranjang"></div>
						</div>
					</div>
				</div>				
			</div>
		</div>
		<div class="modal fade" id="addToCart" tabindex="-1">
			<div class="modal-dialog" style="max-width:1000px;">
				<div class="modal-content">
					<div class="modal-header ">
						<h3 class="modal-title w-100 text-center grey" id="exampleModalLabel">Berhasil Ditambahkan</h3>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-10 offset-1 successItemBox" >
								<div class="row my-4">
									<div class="col-2"><img src="img/<?php echo $row['gambar'];?>" alt="Gambar" width="50px;" class="align-center"></div>
									<div class="col-7"><?php echo $row['nama_barang'];?></div>
									<div class="col-3"><a class="btn btn-success round" href="cart.php" role="button"><b class="cWhite">Lihat Keranjang</b> </a></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container">
		<?php while($rowStat = $stmtStat->fetch()) { ?>
			<div class="row my-5">
				<div class="col-4"><img src="img/<?php echo $row['gambar'];?>" style="max-width: 300px; max-height:200px;"></div>
				<div class="col-8">
					<p><?php echo $row['nama_barang']; ?></p>
					<span><?php echo substr($rowStat['avgRating'],0,3);?></span>
					<?php 
						for($i = 0 ; $i < round($rowStat['avgRating'],0); $i++) { ?>
							<span class="fa fa-star checked"></span>
					<?php } ?>
					<span>(<?php echo $rowStat['totalReview'];?>)</span>

					<span class='pl-3'>Terjual</span>
					<span>213</span>
					<span>Produk</span>
					<hr>
					<div class="row">
						<div class="col-2">Harga</div>
						<div class="col-8"><h4>
						<?php 
							$angka = $row['harga']; 
							echo "Rp. " . number_format($angka, 2, ",", ".");
						?>
						</h4></div>
					</div>
					<hr>
					<div class="row">
						<div class="col-2">Jumlah</div>
						<div class="col-8 my-1"><h6><?php echo $row['stock_tersisa']; ?></h6></div>
					</div>
					<hr>
					<div class="row">
						<div class="col-2">Info <br>Produk</div>
						<div id="info-produk" class="col-8">
							<div class="row">
								<div class="col-3"><h6>Berat<br><h6><?php echo $row['nominal_berat'] . ' ' .$row['satuan_berat']; ?></h6> </h6></div>
								<div class="col-2 border-left"><h6>Kondisi <br> <h6><?php echo $row['kondisi'];?></h6></h6></div>		
							</div>
												
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-2">Ongkos <br>Kirim</div>
						<div class="col-8">
							<span>Ke</span>

							<span class="dropdown">
								<b id="dropdownMenuButton" class="kotaTujuan dropdown dropdown-toggle clicky" data-toggle="dropdown">Jakarta Selatan , Cengkareng</b>
								<span class="dropdown-menu" >
									<div style="min-height: 120px; min-width: 700px;">
										<div class="row my-3 ml-3">
											<div class="text col-3">Kota</div>
											<div class="text col-9">
												<select id="kota">
													<?php while($rowKota = $stmtKota->fetch()) { ?>
														<option value="<?=$rowKota['nama']; ?>"><?=$rowKota['nama']; ?></option>
													<?php } ?>
												</select>
											</div>

										</div>
										<div class="row my-3 ml-3">
											<div class="text col-3">Kode Pos</div>
											<div class="text col-9">
												<select id="kodepos">
													<option class="kodepos-content" value="15252">15252</option>
													<option class="kodepos-content" value="15253">15253</option>
													<option class="kodepos-content" value="15254">15254</option>
													<option class="kodepos-content" value="15255">15255</option>
												</select>
											</div>
										</div>
									</span>
									<div class="row my-3 ml-3">
										<div class="col-11 text-right"><input type="button" value="Submit" class="submitBtn btn btn-success"></div>

									</div>
								</div>
							</span> 
							<p class="text-secondary">Dari Kota Administrasi Jakarta</p>
						</div>		
					</div>
				</div>
				
			</div>
			<hr>
			<div>
				<p class="text-secondary ml-2 f-15">Deskripsi <?php echo $row['nama_barang'];?></p>
				<p class="text-secondary ml-2 f-15"><?php echo $row['deskripsi'];?></p>
				
			</div>
		
			<hr>
			<div>
				
				<p class="text-secondary ">Catatan Toko</p>
				<?php while($toko = $stmtToko->fetch()) { ?>
					<div>
						<span class="ml-4"><b class="f-30">.    </b></span>
						<span class="ml-2"><b class="f-14"><?php echo $toko['judul'];?></b></span>
						
						<div class="ml-5">
							<p><?php echo substr($toko['deskripsi'],0,510) . "....";?></p> 
							<p class="text-right clicky bold cGreen" data-toggle="modal" data-target="#exampleModal<?php echo $toko['id']?>">Selengkapnya</p>
							<div class="modal fade" id="exampleModal<?php echo $toko['id']?>" tabindex="-1">
								<div class="modal-dialog"  style="max-width:1000px;">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="exampleModalLabel">Catatan Toko</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<div class="modal-body">
											<b class="ml-3 ">Kebijakan Pengembalian Produk</b>	

											<p class="ml-3"><?php echo $toko['deskripsi'];?></p> 
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<hr>
				<?php } ?>	<!-- query toko , toko -->
				<div class="row">
				
					<div class="col-6 my-3">
						<b class="f-20">Ulasan (<?php echo $rowStat['totalReview'];?>)</b>
						<p class="my-3" ><?php echo $row['nama_barang'];?></p>
						<div class="row">
							<div class="col-4">
								<span><b class="normal" style="font-size:70px;"><?php echo substr($rowStat['avgRating'],0,3);?></b></span>
								<span>/5</span>
								<br>
								<?php for($i = 0 ; $i < round($rowStat['avgRating'],0); $i++) { ?>
									<span class="fa fa-star checked"></span>
								<?php } ?>
								<p class="text-secondary">(<?= $rowStat['totalReview'];?>) Ulasan</p>
							</div>
						</div>
					</div>	
				
				</div>
				<?php while($rowReview = $stmtReview->fetch()) { ?>
					<div class="row">
						<div class="col-3">
							<div><?php echo $rowReview['nama'];?></div>
							<div><?php echo $rowReview['tanggalwaktu']?></div>
						</div>
						<div class="col-8">
								<?php for($i = 0 ; $i < $rowReview['rating']; $i++) { ?>
									<span class="fa fa-star checked"></span>
									
								<?php } ?>
								<?php if( $rowReview['rating'] - 5 != 0 ){ 
											for($i = 0 ; $i < abs($rowReview['rating'] - 5); $i++) {?>
												<span class="fa fa-star"></span>
								<?php 		} 
									}
								?>
							<br>
							<div class="msg">
								<?php echo $rowReview['message'];?>	
							</div>
							<br>
							<div class="p-4"style="background-color: rgb(243, 244, 245); border-radius:16px;">
								Lorem ipsum dolor sit, amet consectetur adipisicing elit. Animi rerum suscipit ullam odio eos sunt at sequi earum maxime veritatis corrupti, temporibus quis ducimus voluptate hic quisquam dignissimos! Sequi, porro.
							</div>
							
						</div>	
					</div>
					<hr>
				<?php } ?><!-- query review , rowReview -->
			</div>
		<?php } ?>  <!-- query statistik , rowStmt -->
		</div>
			br><br><br><br>
		 <?php } ?> <!-- query utama , row -->
	</div>

</body>
</html>