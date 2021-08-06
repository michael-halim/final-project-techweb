<?php 
    include $_SERVER['DOCUMENT_ROOT']."/tokopetra/connect.php";
    header("Content-Type: application/json");

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $sql = "";
        if($_GET['kategori'] == 0) {
            $sql = "SELECT i.nama, gambar, harga, k.nama AS kategori, AVG(u.rating) AS rating FROM item i
                    JOIN kategori k ON i.id_kategori = k.id
                    LEFT JOIN ulasan u ON i.id = u.id_item
                    GROUP BY i.id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
        }
        else {
            $sql = "SELECT i.nama, gambar, harga, k.nama AS kategori, AVG(u.rating) AS rating FROM item i
                    JOIN kategori k ON i.id_kategori = k.id
                    LEFT JOIN ulasan u ON i.id = u.id_item
                    WHERE k.id = ?
                    GROUP BY i.id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$_GET['kategori']]);
        }

        $result = array();
        while($row = $stmt->fetch()) {
            array_push($result, $row);
        }
        echo json_encode($result);
    }
    else {
        header("HTTP/1.1 400 Bad Request");
        $error = array(
            'error' => 'Method not Allowed'
        );
        echo json_encode($error);
    }
?>