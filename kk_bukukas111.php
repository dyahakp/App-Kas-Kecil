<?php

include "kk_ceklogin.php";
?>
<html>

<head>
	<meta charset="UTF-8">
	<title>Basic Form - jQuery EasyUI Demo</title>
	<link rel="stylesheet" type="text/css" href="jquery-easyui-1.10.16/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="jquery-easyui-1.10.16/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="jquery-easyui-1.10.16/demo/demo.css">
	<!-- Menyisipkan Bootstrap -->
	<link rel="stylesheet" href="css/bootstrap5/bootstrap.min.css" />
	<!-- Menyisipkan JQuery dan Javascript Bootstrap -->
	<script src="js/bootstrap5/bootstrap.min.js"></script>
	<style type="text/css">
		.style3 {
			font-family: Georgia, "Times New Roman", Times, serif;
			font-size: 12px;
			font-weight: bold;
		}
	</style>
</head>

<body>
	<div style="margin:10px 0;"></div>
	<div class="easyui-panel" title="Buku Kas Kecil" style="width:400px">
		<div style="padding:10px 0 10px 60px">
			<form id="ff" method="post">
				<table>
					<tr>
						<td><span class="style3">Mulai Tanggal</span></td>
						<td><input id="d1" name="txtTgl1" type="text" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser"></td>
					</tr>
					<tr>
						<td><span class="style3">Sampai Tanggal</span></td>
						<td><input id="d2" name="txtTgl2" type="text" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser"></td>
					</tr>
					<tr>
						<td><input type="submit" name="btnDisplay" value="Tampilkan" formaction="kk_bukukas1.php"></input></td>
						<td><input type="submit" name="btnCetak" value="Cetak" formaction="kk_bukukas2.php"></input></td>
					</tr>
				</table>
			</form>
		</div>
	</div>
	<script type="text/javascript">
		function myformatter(date) {
			var y = date.getFullYear();
			var m = date.getMonth() + 1;
			var d = date.getDate();
			return (d < 10 ? '0' + d : d) + '/' + (m < 10 ? '0' + m : m) + '/' + y;
		}

		function myparser(s) {
			if (!s) return new Date();
			var parts = s.split('/');
			var y = parseInt(parts[2], 10);
			var m = parseInt(parts[1], 10);
			var d = parseInt(parts[0], 10);
			if (!isNaN(y) && !isNaN(m) && !isNaN(d)) {
				return new Date(y, m - 1, d);
			} else {
				return new Date();
			}
		}
	</script>
	<script type="text/javascript" src="jquery-easyui-1.10.16/jquery.min.js"></script>
	<script type="text/javascript" src="jquery-easyui-1.10.16/jquery.easyui.min.js"></script>
</body>

</html>