<?php

include $_SERVER['DOCUMENT_ROOT']."/tokopetra/connect.php";

header("Content-Type: application/json");

if($_SERVER['REQUEST_METHOD'] == "POST")  {
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	$nama = test_input($_POST['nama']);
	$kategori = test_input($_POST['kategori']);
	$kondisi = test_input($_POST['kondisi']);
	if ($kondisi == 'baru') {
		$kondisi = 1;
	}
	else if ($kondisi == 'bekas') {
		$kondisi = 2;
	}
	$deskripsi = "";
	$deskripsi = test_input($_POST['deskripsi']);
	$harga = test_input($_POST['harga']);
	$stok = test_input($_POST['stok']);
	$berat = test_input($_POST['berat']);
	$satuanBerat = test_input($_POST['satuanBerat']);

	$allowed = array('png', 'jpg', 'jpeg');

	$file = $_FILES['file'];
	$file_name = $file["name"];
	$destination = "img/".$file_name;
    // var_dump($file);
    // untuk keamanan
	$ext = pathinfo($file_name, PATHINFO_EXTENSION);

	if (empty($nama) || empty($kategori)|| empty($kondisi) || empty($harga) || empty($stok) || empty($berat)  || empty($satuanBerat) || empty($file_name)) {
		header("Location:seller_addproduct.php?stat=1");
	}
	else {
		if (in_array($ext, $allowed)) {
			move_uploaded_file($file['tmp_name'], $destination);
		}
		else {
			echo "error";
		}

		$sql = "INSERT INTO item VALUES(default,?,?,?,  ?,?,?,  ?,?,?)";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$nama, $file_name, $harga, $stok, $berat, $satuanBerat, $kondisi, $deskripsi, $kategori]);
		header("Location:seller_addproduct.php?stat=2");
	}
}
else {
	header("HTTP/1.1 400 Bad Request");
	$error = array(
		'error' => 'Method not Allowed'
	);
	echo json_encode($error);
}
?>