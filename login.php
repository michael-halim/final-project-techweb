<?php
include 'connect.php';
if(isset($_SESSION['email'])){
	if ($_SESSION['email'] == "admintokopetra@gmail.com") {
		header('location: seller_home.php');
	}
	else {
		header('location: home.php');
	}
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Tokopetra</title>

    <?php include('assets/header.php'); ?>
    <link rel="stylesheet" href="css/login_style.css">
</head>

<body>
    <img src="img/tokopetra-text.png" class="vertical-align-center">
    <div class="text-center">
        <button type="button" class="btn btn-outline-primary btn-lg bg-primary text-white" data-toggle="modal"
            data-target="#myModal">Sign In</button>
        <button type="button" class="btn btn-outline-success btn-lg bg-success text-white" data-toggle="modal"
            data-target="#myModal2">Sign Up</button>
    </div>

    <!-- SIGN IN -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="vertical-alignment-helper">
            <div class="modal-dialog vertical-align-center">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="card-title text-center mx-4 mt-2">Sign In</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body" method="POST">
                        <form class="form-signin">
                            <div class="form-label-group">
                                <input type="email" id="inputEmailIn" class="form-control" placeholder="Email address"
                                    required autofocus />
                                <label for="inputEmailIn">Email address</label>
                            </div>

                            <div class="form-label-group">
                                <input type="password" id="inputPasswordIn" class="form-control" placeholder="Password"
                                    required />
                                <label for="inputPasswordIn">Password</label>
                            </div>
                            <button id="signin" class="btn btn-lg btn-primary btn-block text-uppercase"
                                type="submit">Sign in</button>
                            <hr class="my-2">
                            <p class="text-center">Belum punya akun Tokopetra?
                                <a href="signup.html" class="text-*-right" data-dismiss="modal" data-toggle="modal"
                                    data-target="#myModal2">Daftar</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- SIGN UP -->
    <div id="myModal2" class="modal fade" role="dialog">
        <div class="vertical-alignment-helper">
            <div class="modal-dialog vertical-align-center">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="card-title text-center mx-4 mt-2">Sign Up</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-label-group ml-3">
                                <input type="text" id="inputFirstName" class="form-control" placeholder="First Name"
                                    required>
                                <label for="inputFirstName">First Name</label>
                            </div>
                            <div class="form-label-group ml-3">
                                <input type="text" id="inputLastName" class="form-control" placeholder="Last Name"
                                    required>
                                <label for="inputLastName">Last Name</label>
                            </div>
                        </div>
                        <div class="form-label-group">
                            <input type="date" id="inputDate" class="form-control" required>
                            <label for="inputDate">Date of Birth</label>
                        </div>
                        <div class="form-label-group">
                            <input type="text" id="inputPhone" class="form-control" placeholder="Phone Number" required>
                            <label for="inputPhone">Phone Number</label>
                        </div>
                        <div class="form-label-group">
                            <select id="inputCity" name="inputCity" class="form-control rounded">

                            </select>
                        </div>
                        <div class="form-label-group">
                            <input type="number" id="inputPostalCode" class="form-control" placeholder="Postal Code"
                                required>
                            <label for="inputPostalCode">Postal Code</label>
                        </div>
                        <div class="form-label-group">
                            <input type="text" id="inputAddress" class="form-control" placeholder="Address" required>
                            <label for="inputAddress">Address</label>
                        </div>
                        <div class="form-label-group">
                            <input type="text" id="inputAccount" class="form-control" placeholder="Address" required>
                            <label for="inputAccount">Account Number</label>
                        </div>
                        <div class="form-label-group">
                            <input type="email" id="inputEmailUp" class="form-control" placeholder="Email address"
                                required autofocus>
                            <label for="inputEmailUp">Email address</label>
                        </div>
                        <div class="form-label-group">
                            <input type="password" id="inputPasswordUp" class="form-control" placeholder="Password"
                                required>
                            <label for="inputPasswordUp">Password</label>
                        </div>
                        <button type="submit" id="signup" class="btn btn-lg btn-success btn-block text-uppercase">Sign
                            up</button>
                        <hr class="my-2">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    $(function() {
        // untuk memberikan info provinsi dan kota
        $.ajax({
            url: "get_province.php",
            method: "GET",
            success: function(result) {
                $("#inputCity").html('<option value="" hidden>City</option>');
                result.forEach(function(kota) {
                    var row = $("<option value=" + kota['id'] + ">" + kota['nama'] +
                        "</option>");
                    $("#inputCity").append(row);
                });
            },
            error: function(result) {

            }
        });
    });
    $("[id='signin']").click(function() {
        var varemail = $("[id='inputEmailIn']").val();
        var varpassword = $("[id='inputPasswordIn']").val();
        $.ajax({
            url: "signin.php",
            method: "POST",
            data: {
                email: varemail,
                password: varpassword
            },
            success: function(result) {
                if (result.notif) {
                    alert(result.notif);
                }
                if (result.location) {
                    window.location.href = result.location;
                }
            },
            error: function(result) {

            }
        });
    });
    $("[id='signup']").click(function() {
        var varname = $("[id='inputFirstName']").val() + " " + $("[id='inputLastName']").val();
        var vardate = $("[id='inputDate']").val();
        var varphone = $("[id='inputPhone']").val();
        var varcity = $("[id='inputCity']").val();
        var varpostcode = $("[id='inputPostalCode']").val();
        var varaddress = $("[id='inputAddress']").val();
        var varaccount = $("[id='inputAccount']").val();
        var varemail = $("[id='inputEmailUp']").val();
        var varpassword = $("[id='inputPasswordUp']").val();
        $.ajax({
            url: "signup.php",
            method: "POST",
            data: {
                name: varname,
                date: vardate,
                phone: varphone,
                city: varcity,
                postcode: varpostcode,
                address: varaddress,
                account: varaccount,
                email: varemail,
                password: varpassword
            },
            success: function(result) {
                if (result.notif) {
                    alert(result.notif);
                }
                if (result.location) {
                    window.location.href = result.location;
                }
            },
            error: function(result) {

            }
        });
    });
    </script>
</body>

</html>