<?php
    header('Content-type: application/json');
    include 'connect.php';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if ($_POST['slogan'] != "" && $_POST['deskripsi'] != "") {
            // declare + assign
            $slogan = $_POST['slogan'];
            $deskripsi = $_POST['deskripsi'];
    
            // check data slogan & deskripsi
            $sql = "SELECT * FROM informasi_toko";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $stmt = $stmt->rowCount();
            
            // jika data slogan & deskripsi sudah ada, maka insert
            if (!$stmt) {
                $sql = "INSERT INTO informasi_toko VALUES (?,?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$slogan, $deskripsi]);
                echo json_encode(['notif'=>'Telah Berhasil di Insert!']);
            }
            // jika data slogan & deskripsi tidak ada, maka update
            else {
                $sql = "UPDATE informasi_toko SET slogan=?,deskripsi=?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$slogan, $deskripsi]);
                echo json_encode(['notif'=>'Telah Berhasil di Update!']);
            }
        }
        else {
            echo json_encode(['notif'=>'Tidak bisa merubah data menjadi kosong']);
        }
    }
    else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        // check data slogan & deskripsi
        $sql = "SELECT * FROM informasi_toko";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $stmt = $stmt->rowCount();

        // jika data slogan & deskripsi sudah ada, maka get data slogan & deskripsi
        if ($stmt) {
            $sql = "SELECT * FROM informasi_toko";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $stmt = $stmt->fetch();
            echo json_encode(['data'=>$stmt]);
        }
    }
?>