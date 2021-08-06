<?php
    $nama_user = "";
    $navbarlogin = "";
    if(!isset($_SESSION['email'])) {
        $navbarlogin = "<a class='dropdown-item' href='login.php'> Login </a>";
    }
    else {
        $sql = "SELECT * FROM user WHERE email=?";
        $stmtNama = $pdo->prepare($sql);
        $stmtNama->execute([$_SESSION['email']]);
        $stmtNama = $stmtNama->fetch();
        $nama_user = $stmtNama['nama'];
        $navbarlogin = "<a class='dropdown-item' href='logout.php'> Log Out </a>";
    }
?>

<!-- LINK LOCAL -->
<link rel="stylesheet" href="assets/navbar_style.css">
<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
    <!-- untuk judul -->
    <a class="navbar-brand" href="home.php"><img src="img/tokopetra-text.png" width="150" height="25"></a>
    <!-- untuk burger -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <!-- untuk navbar -->
    <div class="collapse navbar-collapse" id="navbarNav">
        <!-- untuk search button -->
        <div class="input-group">
            <input type="text" class="form-control" id="search" placeholder="Search">
            <div class="input-group-append">
                <button class="input-group-text"><i class="fa fa-search"></i></button>
            </div>
        </div>
        <ul class="navbar-nav">
            <!-- button cart -->
            <li class="nav-item dropdown">
                <a class="nav-link" href="cart.php"><i class="fa fa-shopping-cart"></i></a>
            </li>
            <!-- button notif -->
            <li class="nav-item dropdown">
                <a class="nav-link" href="status_pembayaran.php"><i class="fas fa-bell"></i></a>
            </li>
            <!-- button inbox -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"><i class="fas fa-envelope"></i></a>
                <ul class="dropdown-menu fade-down">
                    <li><a class="dropdown-item" href="#"> Diskusi </a></li>
                    <li><a class="dropdown-item" href="#"> Ulasan </a></li>
                </ul>
            </li>
            <!-- vertical line -->
            <div class="vl"></div>
            <!-- account -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"><i class="fas fa-user"> <span style='font-family: Gotham-Black;'> <?php echo $nama_user ?> </span></i></a>
                <ul class="dropdown-menu dropdown-menu-right fade-down">
                    <li id="sign">
                        <?php echo $navbarlogin; ?>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>

<script>
	function acc_number(nominal) {
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
		return nominal;
	}
	$(document).ready(function(){
		$('body').on('keyup','#search',function(){
			if(window.location != 'http://localhost/tokopetra/home.php'){
				window.location.href = 'home.php';
			}
			var keyword = $('#search').val();
			$.ajax({
				url: 'search_action.php',
				method: 'GET',
				data: {
						keyword:keyword
				},
				success: function(result){
					$("#content").html('');
					result.forEach(function(item){
						item['harga'];

						var col1 = $("<a href = 'item.php?nama="+ item['nama'] +"' class='col-2 mb-3'></a>");
						var col2 = $("<div class='card'></div>");
						var col3 = $("<div class='card-body'></div>");
						var gambar = $("<img class='card-img-top' src='img/" + item['gambar'] + "' alt='Card image'>");
						var body = $("<h4 class='card-title nama'>" + item['nama'] + "</h4>	<h5 class='card-text harga'>Rp. " + acc_number(item['harga']) + "</h5>	<p class='card-text tipe'>" + item['kategori'] + "</p>");
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
				error:function(result){

				}
			});
		});	
	});
</script>