<?php
include 'connect.php';
if(isset($_SESSION['email'])){
	$email = $_SESSION['email'];
}
else{
	echo "<script>alert('Harap Login Terlebih Dahulu');</script>";
	header('Location: login.php');
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Checkout</title>

    <?php include('assets/header.php'); ?>
    <link rel="stylesheet" href="css/checkout_style.css">
    <script src="js/checkout_func.js"></script>
    <script>
    $(document).ready(function() {
        var email = "<?php echo $email; ?>";

        $.ajax({
            url: 'checkout_action.php',
            method: 'POST',
            data: {
                email: email,
                type: 'show'
            },
            success: function(result) {
                var rupiah = acc_number(result.totalHarga);
                $('.data-user').html(result.output);
                $('.wrapper-subtotal').html(result.outputSubtotal);
                $('#hargaBarang').html('Rp. ' + rupiah);
            },
            error: function(result) {

            }
        });
        $('.choice').click(function() {
            var ongkirSebelumnya = $('#ongkosKirim').data('ongkir');

            var hargaBarang = $('#subtotal').data('subtotal');
            var hargaOngkir = $(this).data('harga');

            var total_harga = parseInt(hargaBarang) + parseInt(hargaOngkir) - parseInt(
            ongkirSebelumnya);
            $('#ongkosKirim').data('ongkir', hargaOngkir);
            $('#subtotal').data('subtotal', total_harga);
            hargaOngkir = acc_number(hargaOngkir);

            $('#courierChoice').html('Rp. ' + hargaOngkir);
            $('#ongkosKirim').html('Rp. ' + hargaOngkir);
            $('#subtotal').html('Rp. ' + acc_number(total_harga));
        });
        $('.bayarSekarang').click(function() {
            var total_harga = $('#subtotal').data('subtotal');
            total_harga = acc_number(total_harga);
            $('#confirmSubtotal').html('Rp. ' + total_harga);
        });
        $('.triggerConfirm').click(function() {
            var totalHarga = $('#confirmSubtotal').html();
            totalHarga = totalHarga.replace('Rp. ', '');
            totalHarga = totalHarga.replace(/\./g, ''); //global replacement by regex,gunakan \ untuk .

            $.ajax({
                url: 'checkout_action.php',
                method: 'POST',
                data: {
                    type: 'checkout',
                    totalHarga: totalHarga
                },
                success: function(result) {
                    if (result.output == 'nice') {
                        window.location.href = 'status_pembayaran.php';
                    }
                }
            });
        });
    });

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
    </script>
</head>

<body>
    <?php include('assets/navbar.php'); ?>
    <div class="container my-5" style="max-width:75%;">
        <div class="row">
            <div class="col-2"></div>
            <div class="col-8">
                <p class="bold f-22">Checkout</p>

                <p class="bold f-17">Alamat Pengiriman</p>
                <hr class="line line-2px">

                <div class="data-user">

                </div>


                <hr class="line line-2px">

                <div class="root Product1">
                    <b>Nama Toko</b>
                    <div class="row my-3">
                        <div class="col-6">
                            <b class="f-14">Pilih Durasi</b>
                            <div class="dropdown">
                                <button class="btn btn-block dropdown-toggle bgGreen round cWhite bold f-15 h-45"
                                    type="button" id="dropdownMenuButton1" data-toggle="dropdown">
                                    Pengiriman
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <div class="scroll h-200">
                                        <div data-harga="50000" class="row choice borderBottom clicky">
                                            <div class="col-12 my-2">
                                                <div class="row text-center my-2 align-top">
                                                    <div class="col-5">
                                                        <b class="type f-14">Instan (3 Jam)</b>
                                                    </div>
                                                    <div class="col-5 m-auto">
                                                        <b class="price f-13 normal">Mulai Dari Rp. 50.000</b>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div data-harga="30000" class="row choice borderBottom clicky">
                                            <div class="col-12 my-2">
                                                <div class="row text-center">
                                                    <div class="col-5">
                                                        <b class="type f-14">Same-Day (6-8 Jam)</b>
                                                    </div>
                                                    <div class="col-5 m-auto">
                                                        <b class="price f-13 normal">Mulai Dari Rp. 30.000</b>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div data-harga="12000" class="row choice borderBottom clicky">
                                            <div class="col-12 my-2">
                                                <div class="row text-center">
                                                    <div class="col-5">
                                                        <b class="type f-14">Next Day (1 Hari)</b>
                                                    </div>
                                                    <div class="col-5 m-auto">
                                                        <b class="price f-13 normal">Mulai Dari Rp. 12.000</b>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div data-harga="8000" class="row choice borderBottom clicky">
                                            <div class="col-12 my-2">
                                                <div class="row m-1">
                                                    <div class="col-5">
                                                        <b class="type f-14">Reguler (2-4 Hari)</b>
                                                    </div>
                                                    <div class="col-5 m-auto">
                                                        <b class="price f-13 normal">Mulai Dari Rp. 8.000</b>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-6 my-3">
                            <div class="optionCourier">
                                <b class="f-15">Harga Kurir</b>
                                <div id="courierChoice" style="color:rgba(49, 53, 59, 0.32);">Belum Memilih Kurir</div>
                            </div>
                        </div>
                    </div>
                    <hr class="line line-1px">
                    <div class="subtotal">
                        <div class="row">
                            <div class="col-6"><b class="grey">Total Tagihan</b> </div>
                            <div class="col-5 text-right trigger orange clicky wrapper-subtotal" data-toggle="collapse"
                                data-target="#collapseExample">

                            </div>
                            <svg width="18px" height="18px" viewBox="0 0 16 16"
                                class="bi bi-caret-down-fill trigger my-1 clicky" fill="currentColor"
                                data-toggle="collapse" data-target="#collapseExample"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z" />
                            </svg>
                        </div>
                        <div class="collapse" id="collapseExample">
                            <div class="row">
                                <div class="col-6 grey">Harga Barang</div>
                                <div class="col-5 text-right"><b id="hargaBarang"></b></div>
                            </div>
                            <div class="row">
                                <div class="col-6 grey">Ongkos Kirim</div>
                                <div class="col-5 text-right"><b id='ongkosKirim' data-ongkir='0'>Rp. 0 </b></div>
                            </div>
                        </div>
                    </div>
                    <hr class="line line-4px">
                </div>

                <button type="button" class="btn btn-block round bgOrange h-60 bayarSekarang" data-toggle="modal"
                    data-target="#checkOutPayment"><b class="cWhite">Bayar Sekarang</b></button>

                <div class="modal fade" id="checkOutPayment" tabindex="-1">
                    <div class="modal-dialog" style="max-height:1000px;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Pembayaran</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row my-1">
                                    <div class="col-6"><b>BNI Virtual Account</b></div>
                                    <div class="col-6 text-right"><b>0862746131900234</b></div>
                                </div>
                                <hr class="line line-8px">
                                <div class="row">
                                    <div class="col-6">
                                        <b>Total Bayar</b>
                                        <br>
                                        <b class="orange f-17" id="confirmSubtotal"></b>
                                    </div>
                                    <div class="col-5 my-1 text-right">
                                        <input type="button"
                                            class="triggerConfirm btn btn-block round bgOrange bold f-16 cWhite"
                                            value="Bayar">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-2"></div>
        </div>

    </div>
</body>

</html>