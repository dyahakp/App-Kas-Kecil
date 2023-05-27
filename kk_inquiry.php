<?php
include "kk_ceklogin.php";
include "kk_konek2.php";

$userid = $_SESSION['User'];
$today = getdate();
$txtLogDate = $today["year"] . "-" . $today["mon"] . "-" . $today["mday"];
$txtLogTime = date("H:i:s");
$txtLogDesc = "Accessing : Inquiry Data";

$query = "INSERT INTO LOGACTIVITY (LOGUSER, LOGDATE, LOGTIME, LOGDESC) VALUES ('$userid', '$txtLogDate', '$txtLogTime', '$txtLogDesc')";
$result = sqlsrv_query($conn2, $query);

sqlsrv_close($conn2);
?>
<html>

<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="js/jquery-easyui-1.3.4/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="js/jquery-easyui-1.3.4/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="js/jquery-easyui-1.3.4/demo/demo.css">
	<style type="text/css">
		#fm {
			margin: 0;
			padding: 10px 30px;
		}

		.ftitle {
			font-size: 14px;
			font-weight: bold;
			color: #666;
			padding: 5px 0;
			margin-bottom: 10px;
			border-bottom: 1px solid #ccc;
		}

		.fitem {
			margin-bottom: 5px;
		}

		.fitem label {
			display: inline-block;
			width: 100px;
		}
	</style>
	<script type="text/javascript" src="js/jquery-easyui-1.3.4/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery-easyui-1.3.4/jquery.easyui.min.js"></script>
	<script type="text/javascript">
		var url;

		function seekDetail() {
			$('#dlg').dialog('open').dialog('setTitle', 'Inquiry');
			$('#fm').form('clear');
			url = 'kk_getdtnq.php';
		}

		function reloadData() {
			$('#fm').form('submit', {
				url: url,
				onSubmit: function() {
					$('#dlg').dialog('close'); // close the dialog
					$('#dg').datagrid('reload'); // reload the user data
				},
				success: function() {
					$('#dlg').dialog('close'); // close the dialog
					$('#dg').datagrid('reload'); // reload the user data
				}
			});
		}

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
	<table id="dg" title="Inquiry Data Transaksi Kas Kecil" class="easyui-datagrid" style="width:1300px;height:450px" url="kk_getinq.php" toolbar="#tb" rownumbers="true" fitColumns="true" singleSelect="true">
		<thead>
			<tr>
				<th field="trstopc" width="100"><b>Kode Kas</b></th>
				<th field="trsnota" width="100"><b>No. Nota</b></th>
				<th field="trscode" width="100"><b>Kode Trans.</b></th>
				<th field="trsvaluta" width="100"><b>Tanggal</b></th>
				<th field="trsdesc" width="250"><b>Keterangan</b></th>
				<th field="trsdbcr" width="50"><b>D/K</b></th>
				<th field="trsreff" width="150"><b>No. Bukti</b></th>
				<th field="trsnilai" width="80" align="right"><b>Jumlah</b></th>
				<th field="trstorf" width="100"><b>Kode Ref.</b></th>
				<th field="trsusrinp" width="100"><b>Input</b></th>
				<th field="trsusraut" width="100"><b>Author</b></th>
			</tr>
		</thead>
	</table>
	<div id="tb" style="padding:15px;height:auto">
		<div style="margin-bottom:5px">
		</div>
		<div>
			<a href="#" class="easyui-linkbutton" iconCls="icon-search" plain="true" onClick="seekDetail()">Cari per Tanggal</a>
		</div>
	</div>
	<div id="dlg" class="easyui-dialog" style="width:400px;height:280px;padding:10px 20px" closed="true" buttons="#dlg-buttons">
		<div class="ftitle">Cari Data per Tanggal</div>
		<form id="fm" method="post" novalidate>
			<div class="fitem">
				<label><span class="style3">Tanggal Input</span></label>
				<input id="d1" name="trsvaluta" type="text" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser">
			</div>
		</form>
	</div>
	<div id="dlg-buttons">
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onClick="reloadData()">Cari</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onClick="javascript:$('#dlg').dialog('close')">Cancel</a>
	</div>
</body>

</html>