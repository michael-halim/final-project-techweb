<?php
    include $_SERVER['DOCUMENT_ROOT']."/tokopetra/connect.php";
    header('Content-type: application/json');

    // Get Complain
    $sql = "SELECT * FROM `ulasan`  WHERE `rating` <= 2";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $Complain = $stmt->rowCount();

    // Get New Order
    $sql = "SELECT * FROM `transaksi` WHERE `id_status` = 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $NewOrder = $stmt->rowCount();

    // Get New Diskusi
    $sql = "SELECT * FROM `diskusi` WHERE `id_terbaca` = 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $Diskusi = $stmt->rowCount();

    // Get New Ulasan
    $sql = "SELECT * FROM `ulasan` WHERE `id_terbaca` = 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $Ulasan = $stmt->rowCount();
    
    // Get Ready Order
    $sql = "SELECT * FROM `transaksi` WHERE `id_status` = 3";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $ReadyOrder = $stmt->rowCount();

    echo json_encode(array('varComplain' => $Complain, 'varNewOrder' => $NewOrder, 'varDiskusi' => $Diskusi, 'varUlasan' => $Ulasan, 'varReadyOrder' => $ReadyOrder));
?>