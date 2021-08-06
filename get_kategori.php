<?php 
    include $_SERVER['DOCUMENT_ROOT']."/tokopetra/connect.php";
    header("Content-Type: application/json");

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $sql = "SELECT * FROM `kategori` ORDER BY nama ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

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