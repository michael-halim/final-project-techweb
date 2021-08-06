<?php 
include 'connect.php';
header('Content-type: application/json');
date_default_timezone_set("Asia/Bangkok");
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = $_SESSION['email'];

    if($_POST['type'] == 'show'){
        $getDataSQL = "SELECT email, u.nama AS nama_orang, no_hp, alamat, kode_pos, k.nama AS nama_kota
                    FROM user u 
                    JOIN kota k 
                    ON k.id = u.id_kota
                    WHERE email = '$email' 
                    ";
        $stmtData = $pdo->prepare($getDataSQL);
        $stmtData->execute();

        $getHargaSQL = "SELECT SUM(i.harga * k.qty) AS total_harga, COUNT(k.id) AS jumlah
                        FROM keranjang k
                        JOIN user u 
                        ON u.id = k.id_user
                        JOIN item i 
                        ON i.id = k.id_item
                        WHERE email = '$email'
                        ";
        $stmtHarga = $pdo->prepare($getHargaSQL);
        $stmtHarga->execute();

        $dataHarga = $stmtHarga->fetch();
        $output = '';

        while($rowData = $stmtData->fetch()){
            $output .= '
                <b class="f-17">'. $rowData['nama_orang'] .'</b><br>	
                <b class="normal f-16">'. $rowData['no_hp'] .'</b><br>
                <b class="normal f-14 grey">'.$rowData['alamat'].'</b><br>
                <b class="normal f-14 grey">'.$rowData['nama_kota'] . ", " . $rowData['kode_pos']. '</b>
            ';
        }
        $outputSubtotal = '<b data-subtotal = ' . $dataHarga['total_harga'] . ' id="subtotal">Rp. ' . number_format($dataHarga['total_harga'], 0, ",", ".") . '</b>';

        echo json_encode(array('output' => $output,'totalHarga' => $dataHarga['total_harga'], 'jumlahBarang'=> $dataHarga['jumlah'],
                                'outputSubtotal'=> $outputSubtotal));
    }
    else if($_POST['type'] == 'checkout'){
        $totalHarga = $_POST['totalHarga'];
        
        //get User ID by email
        $getUserSQL = "SELECT id FROM user WHERE email = '$email' LIMIT 1";
        $getUserID = $pdo->prepare($getUserSQL);
        $stmtUser = $pdo->query($getUserSQL);
        $getUserID = $stmtUser->fetch();

        $userID = $getUserID['id'];     //id user
        $now = date("Y-m-d H:i:s");     //waktu sekarang

        //Insert to transaksi
        $insertTrfSQL = "INSERT INTO transaksi VALUES (DEFAULT , ? , 1, ?, ?)";
        $stmtInsert = $pdo->prepare($insertTrfSQL);
        $stmtInsert->execute([$userID, $now , $totalHarga]);

        //ambil id transaksi yang baru saja di insert utk dimasukkan ke detail transaksi
        $getTrfIDSQL = "SELECT id 
                        FROM transaksi 
                        WHERE id_user = ? 
                            AND tanggalwaktu = ? 
                            AND total_harga = ? 
                        LIMIT 1";

        $stmtGetID = $pdo->prepare($getTrfIDSQL);
        $stmtGetID->execute([$userID , $now , $totalHarga]);

        $getTrfID = $stmtGetID->fetch();
        $trfID = $getTrfID['id'];       //id transaksi

        //ambil data dari keranjang
        $getCartSQL = "SELECT i.id AS id , k.qty AS qty , k.deskripsi AS deskripsi
                        FROM keranjang k 
                        JOIN user u 
                        ON u.id = k.id_user
                        JOIN item i 
                        ON i.id = k.id_item
                        WHERE k.id_user = ?";
        
        $stmtCart = $pdo->prepare($getCartSQL);
        $stmtCart->execute([$userID]);
        
        //insert ke detail transaksi   
        while($rowCart = $stmtCart->fetch()){
            $insertDetailTrfSQL = "INSERT INTO detail_transaksi VALUES (DEFAULT, ? , ? , ? , ? )";
            $stmtInsertDetail = $pdo->prepare($insertDetailTrfSQL);
            $stmtInsertDetail->execute([$trfID, $rowCart['id'] , $rowCart['deskripsi'] , $rowCart['qty'] ]);
        }

        //delete barang yang ada di keranjang sebelumnya
        $deleteCartSQL = "DELETE FROM keranjang WHERE id_user = ?";
        $stmtDeleteCart = $pdo->prepare($deleteCartSQL);
        $stmtDeleteCart->execute([$userID]);

        echo json_encode(array('output' => 'nice'));
    }
}
?>