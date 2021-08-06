<?php 
include 'connect.php';
header("Content-Type: application/json");

if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $keyword = '%' . $_GET['keyword'] . '%';
        $sql = "SELECT i.nama, gambar, harga, k.nama AS kategori, AVG(u.rating) AS rating FROM item i
                        JOIN kategori k ON i.id_kategori = k.id
                        LEFT JOIN ulasan u ON i.id = u.id_item
                        WHERE i.nama LIKE ?
                        GROUP BY i.id
                        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$keyword]);
    
        $result = array();
        while($row = $stmt->fetch()) {
            array_push($result, $row);
        }
        echo json_encode($result);
}

?>