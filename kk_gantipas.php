<?php
include "kk_ceklogin.php";
?>
<html>

<head>
	<meta charset="UTF-8">
	<title>Basic Form - jQuery EasyUI Demo</title>
	<link rel="stylesheet" type="text/css" href="js/jquery-easyui-1.3.4/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="js/jquery-easyui-1.3.4/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="js/jquery-easyui-1.3.4/demo/demo.css">
	<script type="text/javascript" src="js/jquery-easyui-1.3.4/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery-easyui-1.3.4/jquery.easyui.min.js"></script>
	<script type="text/javascript">
		function myformatter(date) {
			var y = date.getFullYear();
			var m = date.getMonth() + 1;
			var d = date.getDate();
			return (d < 10 ? ('0' + d) : d) + '/' + (m < 10 ? ('0' + m) : m) + '/' + y;
		}

		function myparser(s) {
			if (!s) return new Date();
			var ss = (s.split('-'));
			var y = parseInt(ss[0], 10);
			var m = parseInt(ss[1], 10);
			var d = parseInt(ss[2], 10);
			if (!isNaN(y) && !isNaN(m) && !isNaN(d)) {
				return new Date(y, m - 1, d);
			} else {
				return new Date();
			}
		}
	</script>
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
	<div class="easyui-panel" title="Ganti Password" style="width:400px">
		<div style="padding:10px 0 10px 60px">
			<form id="ff" method="post">
				<table>
					<tr>
						<td><span class="style3">Password Lama</span></td>
						<td><input class="easyui-validatebox" type="password" name="txtLama"></td>
					</tr>
					<tr>
						<td><span class="style3">Password Baru</span></td>
						<td><input class="easyui-validatebox" type="password" name="txtBaru1"></td>
					</tr>
					<tr>
						<td><span class="style3">Sekali Lagi</span></td>
						<td><input class="easyui-validatebox" type="password" name="txtBaru2"></td>
					</tr>
					<tr>
						<td><input type="submit" name="btnChange" value="Ganti" formaction="kk_gantipas1.php"></input></td>
					</tr>
				</table>
			</form>
		</div>
</body>

</html>