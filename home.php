<?php
	include 'connect.php';
?>

<!doctype html>
<html lang="en">

<head>
	<title>Proyek Tekweb</title>

	<?php include('assets/header.php'); ?>
	<script src="js/all_home_func.js"></script>
	<link rel="stylesheet" type="text/css" href="css/home_style.css">
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

	<!-- carousel promo -->
	<div class="container-fluid" style="padding: 0px;">
		<!-- Promo -->
		<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
			<ol class="carousel-indicators">
				<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
				<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
				<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
			</ol>
			<div class="carousel-inner">
				<div class="carousel-item active">
					<a href="#">
						<img class="d-block w-100" style="max-width: 100%; height: 350px;" src="img/promo1.jpg" alt="First slide">
					</a>
				</div>
				<div class="carousel-item">
					<a href="#">
						<img class="d-block w-100" style="max-width: 100%; height: 350px;" src="img/promo2.jpg" alt="First slide">
					</a> </div>
				<div class="carousel-item">
					<a href="#">
						<img class="d-block w-100" style="max-width: 100%; height: 350px;" src="img/promo3.jpg" alt="First slide">
					</a> </div>
			</div>
			<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>
	</div>

	<!-- carousel kategori -->
	<div class="container-fluid">
		<!-- Category -->
		<h2 class="text-center pt-5">Pilih Kategori</h2>
		<div class="row">
			<div class="col-2">
				<a class="carousel-control-prev" href="#carouselExampleIndicators2" role="button" data-slide="prev" style="left: 200px;">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				</a>
			</div>
			<div class="col-8">
				<div id="carouselExampleIndicators2" class="carousel slide" data-interval="false">
					<div class="carousel-inner">
						<div class="carousel-item active no-gutters">
							<div class="col-4 float-left" id="category">
								<a href="home.php?kategori=1">
									<img src="img/icons/1.png" alt="" width="128" class="img-fluid">
									<h6>Elektronik</h6>
								</a>
							</div>
							<div class="col-4 float-left" id="category">
								<a href="home.php?kategori=2">
									<img src="img/icons/2.png" alt="" class="img-fluid">
									<h6>Aksesoris</h6>
								</a>
							</div>
							<div class="col-4 float-left" id="category">
								<a href="home.php?kategori=3">
									<img src="img/icons/3.png" alt="" class="img-fluid">
									<h6>Makanan</h6>
								</a>
							</div>
							<div class="col-4 float-left" id="category">
								<a href="home.php?kategori=4">
									<img src="img/icons/4.png" alt="">
									<h6>HP & Gadget</h6>
								</a>
							</div>
							<div class="col-4 float-left" id="category">
								<a href="home.php?kategori=5">
									<img src="img/icons/5.png" alt="">
									<h6>Gaming</h6>
								</a>
							</div>
							<div class="col-4 float-left" id="category">
								<a href="home.php?kategori=6">
									<img src="img/icons/6.png" alt="">
									<h6>PC & Laptop</h6>
								</a>
							</div>
						</div>
						<div class="carousel-item no-gutters">
							<div class="col-4 float-left" id="category">
								<a href="home.php?kategori=7">
									<img src="img/icons/7.png" alt="">
									<h6>Pakaian Pria</h6>
								</a>
							</div>
							<div class="col-4 float-left" id="category">
								<a href="home.php?kategori=8">
									<img src="img/icons/8.png" alt="">
									<h6>Pakaian Wanita</h6>
								</a>
							</div>
							<div class="col-4 float-left" id="category">
								<a href="home.php?kategori=9">
									<img src="img/icons/9.png" alt="">
									<h6>Pakaian Bayi</h6>
								</a>
							</div>
							<div class="col-4 float-left" id="category">
								<a href="home.php?kategori=10">
									<img src="img/icons/10.png" alt="">
									<h6>Peralatan Rumah Tangga</h6>
								</a>
							</div>
							<div class="col-4 float-left" id="category">
								<a href="home.php?kategori=11">
									<img src="img/icons/11.png" alt="">
									<h6>Hobi</h6>
								</a>
							</div>
							<div class="col-4 float-left" id="category">
								<a href="home.php?kategori=12">
									<img src="img/icons/12.png" alt="">
									<h6>Hadiah</h6>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-2">
				<a class="carousel-control-next" href="#carouselExampleIndicators2" role="button" data-slide="next" style="right: 200px;">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
				</a>
			</div>
		</div>
	</div>
	<div class="container">
		<h2 class="text-center pt-5">Get Started</h2>
		<div class="row pb-5" id="content">

		</div>
	</div>

	<!-- Footer -->
	<?php include('assets/footer-peter.php')?>

	<script>
		function accounting_number(nominal) {
			// membuat total harga dengan tanda titik setiap akhir 3 digit
			nominal = String(nominal);
			var output = '';
			for (let i = nominal.length - 1, j = 0; i >= 0; i--, j++) {
				// alert(totalharga[i]);
				if (j % 3 == 0 && j != 0) {
					output += '.';
				}
				output += nominal[i];
			}
			// reverse string output
			nominal = '';
			for (let i = 0, j = output.length - 1; i < output.length; i++, j--) {
				nominal += output[j];
			}
			nominal = 'Rp. ' + nominal;
			return nominal;
		}

		$(function(){
			var kategori = 0;
			<?php
			if(isset($_GET['kategori'])) {
				?>
				kategori = <?php echo $_GET['kategori'] ?>;
				<?php
			}
			?>
			$.ajax({
				url: "get_item.php",
				method: "GET",
				data: {kategori:kategori},
				success: function(result) {
					result.forEach(function(item){
						item['harga'] = accounting_number(item['harga']);

						var col1 = $("<a href = 'item.php?nama="+ item['nama'] +"' class='col-2 mb-3 p-1'></a>");
						var col2 = $("<div class='card'></div>");
						var col3 = $("<div class='card-body'></div>");
						var gambar = $("<img class='card-img-top' src='img/" + item['gambar'] + "' alt='Card image'>");
						var body = $("<h4 class='card-title nama'>" + item['nama'] + "</h4>	<h5 class='card-text harga'>" + item['harga'] + "</h5>	<p class='card-text tipe'>" + item['kategori'] + "</p>");
						var rating = Math.round(item['rating']);

						col2.appendTo(col1);
						gambar.appendTo(col2);
						col3.appendTo(col2);
						body.appendTo(col3);

						if (rating != 0) {
							for (let i = 1; i <= 5; i++) {
								if (rating > i) {
									col3.append("<span class='fa fa-star checked'>");
								}
								else {
									col3.append("<span class='fa fa-star'>");
								}
							}
						}
						$("#content").append(col1);
					});
				},
				error: function(result) {

				}
			});
		});
	</script>
</body>
</html>