<?php
session_start();
$userid = $_SESSION['User'];

include "kk_ceklevel1.php";
include "kk_cekstatus.php";
include "kk_konek2.php";

$hariini = getdate();
$iddriver = $_REQUEST['iddriver'];
$namadriver = $_REQUEST['namadriver'];
$nominalkasbon = $_REQUEST['nominalkasbon'];
$trsnow = $hariini["year"] . "-" . $hariini["mon"] . "-" . $hariini["mday"];

$sql = "update tbdriver set namadriver='$namadriver', nominalkasbon='$nominalkasbon', date_updated= '$trsnow', user_updated= '$userid' from tbdriver where iddriver='$iddriver'";

			$result = @sqlsrv_query($conn2, $sql);

			if ($result) {
				echo json_encode(array('success' => true));
			} else {
				echo json_encode(array('msg' => 'Koreksi Data Gagal'));
			}
sqlsrv_close($conn2);
