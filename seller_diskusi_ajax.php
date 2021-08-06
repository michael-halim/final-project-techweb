<?php
    header('Content-type: application/json');
    date_default_timezone_set("Asia/Bangkok");
    include 'connect.php';
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if ($_GET['kondisiterbaca'] == 1) {
            // check data slogan & deskripsi
            $sql = "SELECT i.gambar, i.nama AS produk, i.harga, ua.nama AS penerima, ub.nama AS pengirim, DATE_FORMAT(d.tanggalwaktu, '%d %b %Y') AS tanggal, DATE_FORMAT(d.tanggalwaktu, '%h:%i') AS jam, d.message, t.nama AS terbaca FROM diskusi d
                    JOIN item i ON d.id_item = i.id
                    JOIN user ua ON d.id_user_penerima = ua.id
                    JOIN user ub ON d.id_user_pengirim = ub.id
                    JOIN terbaca t ON d.id_terbaca = t.id
                    WHERE ub.nama != 'Admin'
                    GROUP BY i.nama, ub.nama
                    ORDER BY tanggalwaktu ASC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            // data per row diskusi
            $row = array();
            while($data = $stmt->fetch()) {
                array_push($row, $data);
            }
            echo json_encode($row);
        }
        else if ($_GET['kondisiterbaca'] == 0) {
            // check data slogan & deskripsi
            $sql = "SELECT i.gambar, i.nama AS produk, i.harga, ua.nama AS penerima, ub.nama AS pengirim, DATE_FORMAT(d.tanggalwaktu, '%d %b %Y') AS tanggal, DATE_FORMAT(d.tanggalwaktu, '%h:%i') AS jam, d.message, t.nama AS terbaca FROM diskusi d
                    JOIN item i ON d.id_item = i.id
                    JOIN user ua ON d.id_user_penerima = ua.id
                    JOIN user ub ON d.id_user_pengirim = ub.id
                    JOIN terbaca t ON d.id_terbaca = t.id
                    WHERE ub.nama != 'Admin' AND t.id = 1
                    GROUP BY i.nama, ub.nama
                    ORDER BY tanggalwaktu ASC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            // data per row diskusi
            $row = array();
            while($data = $stmt->fetch()) {
                array_push($row, $data);
            }
            echo json_encode($row);
        }
        else if ( isset($_GET['produk']) && isset($_GET['nama']) ) {
            $produk = $_GET['produk'];
            $nama = $_GET['nama'];
            // fetching
            $sql = "SELECT i.gambar, i.nama AS produk, i.harga, ua.nama AS penerima, ub.nama AS pengirim, DATE_FORMAT(d.tanggalwaktu, '%d %b %Y') AS tanggal, DATE_FORMAT(d.tanggalwaktu, '%h:%i') AS jam, d.message, t.nama AS terbaca FROM diskusi d
                    JOIN item i ON d.id_item = i.id
                    JOIN user ua ON d.id_user_penerima = ua.id
                    JOIN user ub ON d.id_user_pengirim = ub.id
                    JOIN terbaca t ON d.id_terbaca = t.id
                    WHERE i.nama=? AND ((ub.nama=? AND ua.nama='Admin') OR (ua.nama=? AND ub.nama='Admin'))
                    ORDER BY tanggalwaktu ASC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$produk, $nama, $nama]);
            
            $row_akhir = array();
            while($data_akhir = $stmt->fetch()) {
                array_push($row_akhir, $data_akhir);
            }
            echo json_encode($row_akhir);
        }
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if ($_POST['type'] == 0) {
            if (isset($_POST['text']) && isset($_POST['produk']) && isset($_POST['nama'])) {
                if ($_POST['text'] != "") {
                    $text = $_POST['text'];
                    $produk = $_POST['produk'];
                    $nama = $_POST['nama'];

                    $sql = "SELECT id FROM user WHERE nama=?";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([$nama]);
                    $nama = $stmt->fetch();
                    $nama = $nama['id'];

                    $sql = "SELECT id FROM item WHERE nama=?";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([$produk]);
                    $produk = $stmt->fetch();
                    $produk = $produk['id'];

                    $sql = "INSERT INTO diskusi VALUES (DEFAULT,?,?,?,?,?,?)";
                    $stmt = $pdo->prepare($sql);
                    
                    $now = date('Y-m-d H:i:s');
                    $stmt->execute([$produk, $nama, 0, $now, $text, 2]);

                    $sql = "UPDATE diskusi SET id_terbaca=2 WHERE id_item=? AND id_user_pengirim=? AND id_terbaca=1";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([$produk, $nama]);

                    echo json_encode(['notif'=>'Telah Terkirim!']);
                }
                else {
                    echo json_encode(['notif'=>'Jangan dikosongi!']);
                }
            }
        }
        if ($_POST['type'] == 1) {
            if (isset($_POST['produk']) && isset($_POST['nama'])) {
                $produk = $_POST['produk'];
                $nama = $_POST['nama'];

                $sql = "SELECT id FROM user WHERE nama=?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$nama]);
                $nama = $stmt->fetch();
                $nama = $nama['id'];

                $sql = "SELECT id FROM item WHERE nama=?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$produk]);
                $produk = $stmt->fetch();
                $produk = $produk['id'];

                $sql = "DELETE FROM diskusi WHERE id_item=? AND ((id_user_pengirim=? AND id_user_penerima=?) OR (id_user_penerima=? AND id_user_pengirim=?))";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$produk, $nama, 0, $nama, 0]);

                echo json_encode(['notif'=>'Telah Terhapus!']);
            }
        }
    }
?>