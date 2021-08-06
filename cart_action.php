<?php 
    include 'connect.php';
    header('Content-type: application/json');

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if($_POST['type'] == 'delete'){
            $itemID = $_POST['itemID'];
            $userID = $_POST['userID'];
    
            //mendelete data yang dipilih
            $deleteSQL = "DELETE FROM keranjang WHERE id_user = ? AND id_item = ?";
            $stmtDelete = $pdo->prepare($deleteSQL);
            $stmtDelete->execute([$userID,$itemID]);
        }
        else if ($_POST['type'] == 'add'){
            $itemID = $_POST['itemID'];
            $userID = $_POST['userID'];

            $addSQL = "UPDATE keranjang SET qty = qty + 1 WHERE id_user = ? AND id_item = ?";
            $stmtAdd = $pdo->prepare($addSQL);
            $stmtAdd->execute([$userID,$itemID]);
        }
        else if ($_POST['type'] == 'min'){
            $itemID = $_POST['itemID'];
            $userID = $_POST['userID'];

            $minSQL = "UPDATE keranjang SET qty = qty - 1 WHERE id_user = ? AND id_item = ?";
            $stmtMin = $pdo->prepare($minSQL);
            $stmtMin->execute([$userID,$itemID]);
        }
        $userID = $_POST['userID'];
            //mengembalikan data yang sudah di update
            $getCartSQL = "SELECT i.id AS id ,i.nama AS nama, i.harga AS harga, k.qty AS qty, i.gambar AS gambar
                           FROM keranjang k 
                           JOIN user u 
                           ON u.id = k.id_user
                           JOIN item i 
                           ON i.id = k.id_item
                           WHERE k.id_user = ?";
            
            $stmtCart = $pdo->prepare($getCartSQL);
            $stmtCart->execute([$userID]);
    
            $output = '';
            $hargaTotal = 0;
            while($rowDetail = $stmtCart->fetch()) {
                $output .=
                '<div class="root Product'. $rowDetail["id"] .'">
                    <div class="row my-3">
                       
                        <div class="col-3 mt-mb-auto"><img src="img/'.$rowDetail["gambar"].'" alt="Gambar" width="90px;"></div>
                        <div class="col-8 mt-mb-auto">
                            <b>'.$rowDetail["nama"].'</b> <br>
                            <b>Rp. '. number_format($rowDetail["harga"], 2, ",", "."). '  </b>
                        </div>
                    </div>
                    <div class="row text-right">                    
                        <div class="col-8"></div>
                        <div class="col-1">
                            <svg width="25px" height="25px" viewBox="0 0 16 16" class="remove bi bi-trash clicky" fill="rgba(49, 53, 59, 0.32)" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                            </svg>
                        </div>
                        <div class="col-1">
                            <svg width="25px" height="25px" viewBox="0 0 16 16" class="min bi bi-dash-circle clicky" fill="rgb(3, 172, 14)" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z"/>
                            </svg>
                        </div>
                        <div class="col-1 counterProduct' . $rowDetail["id"] . ' text-center" style="border-bottom:1px solid rgba(49, 53, 59, 0.32);">
                            '. $rowDetail['qty'].'       
                        </div> 
                        
                        <div class="col-1">
                            <svg width="25px" height="25px" viewBox="0 0 16 16" class="plus bi bi-plus-circle-fill clicky" fill="rgb(3, 172, 14)" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
                            </svg>
                        </div>
                    </div>
                    <hr class="line line-4px">           
    
                </div>';
                $hargaTotal = $hargaTotal + ($rowDetail['harga'] * $rowDetail['qty']);
            }
            $outputHarga = '<div data-harga='. $hargaTotal .' class="col-6 text-right orange bold total-harga">Rp. '. number_format($hargaTotal, 2, ",", ".") .'</div>';
            echo json_encode(array('output' => $output, 'hargaTotal' => $outputHarga));           
    }


?>
 