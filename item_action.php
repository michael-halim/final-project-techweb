<?php 
    header('Content-type: application/json');
    include 'connect.php';

    if($_SERVER['REQUEST_METHOD'] = 'POST'){
        $userID = $_POST['userID'];
        $itemID = $_POST['itemID'];
        
        //cek apakah item yang sama sudah dipesan oleh orang yang sama
        $checkSQL = "SELECT COUNT(*) 
                     FROM keranjang 
                     WHERE id_user = ? && id_item = ?";
        $stmtCheck = $pdo->prepare($checkSQL);
        $stmtCheck->execute([$userID,$itemID]);
        $num_rows = $stmtCheck->fetchColumn();

        if($num_rows > 0){
            $getQty = "SELECT qty 
                    FROM `keranjang`
                    WHERE id_user = ? && id_item = ?";
            $stmtQty = $pdo->prepare($getQty);
            $stmtQty->execute([$userID,$itemID]);
            $qty = $stmtQty->fetchColumn();

            $qty++;
            $updateSQL = "UPDATE keranjang 
                          SET qty = ?
                          WHERE id_user = ? && id_item = ?";

            $stmtUpdate = $pdo->prepare($updateSQL);
            $stmtUpdate->execute([$qty,$userID,$itemID]);
        }
        else{
            // SQL INSERT untuk ke tabel keranjang
            $addItem = "INSERT INTO keranjang VALUE (DEFAULT, ?,?,'-',1)";
            $stmt = $pdo->prepare($addItem);
            $stmt->execute([$userID, $itemID]);          
        }
        echo json_encode(['data'=>'1']);
    }
    else{
        echo json_encode(['data'=>'0']);
    }
?>