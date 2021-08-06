<!-- LINK LOCAL -->
<link rel="stylesheet" href="assets/navbar_style.css">

<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
    <!-- untuk judul -->
    <a class="navbar-brand" href="seller_home.php"><img src="img/tokopetra_seller.png" width="150" height="25"></a>
    <!-- untuk burger -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <!-- untuk navbar -->
    <div class="collapse navbar-collapse" id="navbarNav">
        <!-- untuk search button -->
        <div class="input-group">
        </div>
        <ul class="navbar-nav">
            <!-- vertical line -->
            <div class="vl"></div>
            <!-- account -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"><i class="fas fa-user"> <span style='font-family: Gotham-Black;'> TOKOPETRA </span> </i></a>
                <ul class="dropdown-menu dropdown-menu-right fade-down">
                <li><a class="dropdown-item" href="logout.php"> Logout </a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>