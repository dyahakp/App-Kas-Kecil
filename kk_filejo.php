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
	<link rel="stylesheet" type="text/css" href="css/bootstrap5/bootstrap-grid.min.css">
	<style type="text/css">
		.style3 {
			font-family: Georgia, "Times New Roman", Times, serif;
			font-size: 12px;
			font-weight: bold;
		}

		.button-like-input {
			appearance: button;
			-moz-appearance: button;
			-webkit-appearance: button;
			padding: 8px 16px;
			border: none;
			background-color: #4cade6;
			color: #fff;
			cursor: pointer;
			font-weight: bold;
			text-align: center;
			text-decoration: none;
		}
	</style>
</head>

<body>
	<div style="margin:10px 0;"></div>
	<div class="easyui-panel" title="Create File Teks JO" style="width:400px">
		<div style="padding:10px 0 10px 60px">
			<form id="ff" method="post">
				<table>
					<tr>
						<td><span class="style3">Tanggal</span></td>
						<td><input id="d1" name="txtTgl" type="text" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser"></td>
					</tr>
					<tr>
						<td><span class="style3">Nama File</span></td>
						<td><input class="easyui-validatebox" type="text" name="txtFile"></td>
					</tr>
					<tr>
						<td><input class="btn btn-primary" type="submit" name="btnCreate" value="Create JO" formaction="kk_filejo1.php"></input></td>
						<td><input class="btn btn-primary" type="submit" name="btnCreate" value="Create JO BY" formaction="kk_filejo2.php"></input></td>
					</tr>
					<tr>

					</tr>
				</table>
			</form>
		</div>

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
</body>

</html>