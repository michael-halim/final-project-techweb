<?php
include $_SERVER['DOCUMENT_ROOT']."/tokopetra/connect.php";
header("Content-Type: application/json");

if($_SERVER['REQUEST_METHOD'] == 'POST')  {
	$id_status = $_POST['id_status'];
	$id_trf = $_POST['id_trf'];

	if($_POST['type'] == 'update') {
		$sql = "UPDATE transaksi SET id_status = 3 WHERE id = ?";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$id_trf]);
	}

	$sql = "SELECT t.id AS id, u.nama as nama_user, u.alamat AS alamat, total_harga,DATE_FORMAT(tanggalwaktu, '%d %b %Y') AS tanggal , DATE_FORMAT(tanggalwaktu, '%H:%i:%s') AS waktu
	FROM transaksi t
	JOIN user u
	ON u.id = t.id_user
	WHERE id_status = ? 
	";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$id_status]);

	$output = '';
	while($row = $stmt->fetch()){
		$output .= '<div class="card card-penjualan col-12 border border-dark rounded my-3">
						<div class="card-body">
							<div class="row">
								<div class="col-4">
									<a href="#" class="product-name f-17" id="namaUser">'. $row['nama_user'] .'</a>
									<div class="f-17 my-1" id="alamat">Alamat &nbsp;: '. $row['alamat'] .'</div>
									<div class="f-17 my-1" id="tanggal">Tanggal  : '. $row['tanggal'] . ' ' . $row['waktu'] . '</div>
									<div class="f-17 my-1 font-weight-bold">BNI Virtual Account</div>
								</div>
								<div class="col-5 text-center">		
									<div class="f-17 font-weight-bold my-2">Total Harga</div>
									<span class="f-22 my-1 text-success font-weight-bold" id="hargaTotal">'. 'Rp. '. number_format($row['total_harga'], 2, ",", ".") .'</span>
								</div>';
								if($id_status == 1) {
									$output .= '<div class="col-3 text-center mt-4">
													<button type="submit" class="btn btn-success f-17 terima-pesanan" data-idtrf="'. $row['id'].'">Terima Pesanan</button>
												</div>';
								}
				$output .= '</div>
						</div>
					</div>';
	}
	echo json_encode(array ('output' => $output));
}
?>

