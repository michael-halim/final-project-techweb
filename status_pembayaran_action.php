<?php 
include 'connect.php';
header('Content-type: application/json');

//id status 1 = Menunggu Konfirmasi
          //2 = Paket Sedang Dikirim
          //3 = Paket Telah Sampai

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_SESSION['email'];    
        $id_status = $_POST['id_status'];

        if($_POST['type'] == 'delete'){         //kalo mencet tombol delete di page "menunggu konfirmasi"
            $id_trf = $_POST['id_trf'];
            
            //delete dari transaksi
            $deleteTransaksiSQL = "DELETE FROM transaksi WHERE id = ?";
            $stmtDeleteTrf = $pdo->prepare($deleteTransaksiSQL);
            $stmtDeleteTrf->execute([$id_trf]);

            //delete dari detail transaksi
            $deleteDetailTransaksiSQL = "DELETE FROM detail_transaksi WHERE id_transaksi = ?";
            $stmtDeleteDetailTrf = $pdo->prepare($deleteDetailTransaksiSQL);
            $stmtDeleteDetailTrf->execute([$id_trf]);
        }
        else if($_POST['type'] == 'update'){        //kalo mencet tombol "Barang telah diterima" di page "Sedang Dikirim"
            $id_trf = $_POST['id_trf'];
            
            //update status dari transaksi
            $updateTransaksiSQL = "UPDATE transaksi
                                    SET id_status = 4
                                    WHERE id = ?";

            $stmtUpdateTrf = $pdo->prepare($updateTransaksiSQL);
            $stmtUpdateTrf->execute([$id_trf]);
        }   

        //code dibawah ini tidak diberi IF karena bila selesai mengupdate atau mendelete yang atas bisa langsung turun dan mengambil data realtime
            $getTransaksiSQL = "SELECT t.id AS id,total_harga,DATE_FORMAT(tanggalwaktu, '%d %b %Y') AS tanggal , DATE_FORMAT(tanggalwaktu, '%H:%i:%s') AS waktu
                                FROM transaksi t
                                JOIN user u
                                ON u.id = t.id_user
                                WHERE email = ?
                                AND id_status = ? 
                                ";
            $stmtTransaksi = $pdo->prepare($getTransaksiSQL);
            $stmtTransaksi->execute([$email,$id_status]);

            $outputTrf = '';


            //kalo status nya 1 itu artinya, kalo page "Menunggu Konfirmasi" dipencet
            //perbedaannya adalah tombol di page menunggu konfirmasi ada tombol delete,
            // di page "Sedang Dikirim" ada tombol "Barang Telah Sampai", dan di page "Paket telah Diterima" tidak ada tombol apapun
  
            if($id_status == 1){
                while($rowTrf = $stmtTransaksi->fetch()){
                    $outputTrf .= '<div class="border my-3 round float-effect2">
                                        <div class="row my-4">
                                            <div class="col-7 mb-2 ml-5">
                                                <b>Belanja</b>  <br>
                                                <span>Total Pembelian <b>' .  "Rp. " . number_format($rowTrf['total_harga'], 2, ",", ".") . '</b> </span>  <br>   
                                                <span>Tanggal Pembelian '.$rowTrf['tanggal'] . " ". $rowTrf['waktu'] .'</span> <br>
                                                <b>Metode Pembayaran :  BNI Virtual Account</b>
                                            
                                            </div>
                                            <div class="col-3 text-right clicky cGreen bold" data-idtrf = "'.$rowTrf['id'].'" id="deleteTrf">Batalkan Transaksi</div>
                                        </div>
                                    </div>';
                }
            }
            else if ($id_status == 3){
                while($rowTrf = $stmtTransaksi->fetch()){
                    $outputTrf .= '<div class="border my-3 round float-effect2">
                                        <div class="row my-4">
                                            <div class="col-7 mb-2 ml-5">
                                                <b>Belanja</b>  <br>
                                                <span>Total Pembelian <b>' .  "Rp. " . number_format($rowTrf['total_harga'], 2, ",", ".") . '</b> </span>  <br>   
                                                <span>Tanggal Pembelian '.$rowTrf['tanggal'] . " ". $rowTrf['waktu'] .'</span> <br>
                                                <b>Metode Pembayaran :  BNI Virtual Account</b>
                                            </div>
                                            <div class="col-3 text-right clicky cGreen bold" data-idtrf = "'.$rowTrf['id'].'" id="arrivedBtn">Barang Telah Sampai</div>
                                        </div>
                                    </div>';
                }
            }
            else if($id_status == 4){
                while($rowTrf = $stmtTransaksi->fetch()){
                    $outputTrf .= '<div class="border my-3 round float-effect2">
                                        <div class="row my-4">
                                            <div class="col-7 mb-2 ml-5">
                                                <b>Belanja</b>  <br>
                                                <span>Total Pembelian <b>' .  "Rp. " . number_format($rowTrf['total_harga'], 2, ",", ".") . '</b> </span>  <br>   
                                                <span>Tanggal Pembelian '.$rowTrf['tanggal'] . " ". $rowTrf['waktu'] .'</span> <br>
                                                <b>Metode Pembayaran :  BNI Virtual Account</b>
                                            </div>
                                        </div>
                                    </div>';
                }
            }

            echo json_encode(array('outputTrf' => $outputTrf));
    }
?>