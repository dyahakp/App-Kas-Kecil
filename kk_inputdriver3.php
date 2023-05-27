<?php
include "kk_ceklevel1.php";
include "kk_cekstatus.php";
include "kk_konek2.php";

$hariini = getdate();
$iddriver = $_REQUEST['iddriver'];
$namadriver = $_REQUEST['namadriver'];
$nominalkasbon = $_REQUEST['nominalkasbon'];


$sql = "delete from tbdriver where iddriver = '$iddriver'";
$result = @sqlsrv_query($conn2, $sql);
if (!$result) {
	echo json_encode(array('msg' => 'Gagal Membuka Database'));
} else {

		if ($result) {
			echo json_encode(array('success' => true));
		} else {
			echo json_encode(array('msg' => 'Hapus Data Gagal'));
		}
	
		
	}
sqlsrv_close($conn2);
