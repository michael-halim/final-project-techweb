<?php
    header('Content-type: application/json');
    include 'connect.php';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // declare + assign
        $name = $_POST['name'];
        $date = $_POST['date'];
        $phone = $_POST['phone'];
        // memisah provinsi dengan kota
        $city = $_POST['city'];
        if ($city == "") {
            echo json_encode(['notif'=>'Masukkan Kota dengan benar!']);
        }
        else {
            $postcode = $_POST['postcode'];
            $address = $_POST['address'];
            $account = $_POST['account'];
            $email = $_POST['email'];
            $cekemail = '%'.$email.'%';
            $password = $_POST['password'];
    
            // check data duplicate
            $sql = "SELECT * FROM user WHERE email LIKE ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$cekemail]);
            $stmt = $stmt->fetch();
            
            if(!$stmt) {
                // query
                $sql = "INSERT INTO user VALUES (DEFAULT,?,?,?,?,?,?,?,?,?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$email, $password, $name, $phone, $date, $city, $address, $postcode, $account]);

                $_SESSION['email'] = $email;
                echo json_encode(['location'=>'/tokopetra/home.php']);
            }
            else {
                echo json_encode(['notif'=>'Email yang anda masukkan telah terdaftar!']);
            }
        }
    }
?>