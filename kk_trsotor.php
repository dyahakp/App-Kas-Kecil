<?php
include "kk_ceklogin.php";
include "kk_konek2.php";

$userid = $_SESSION['User'];
$today = getdate();
$txtLogDate = $today["year"] . "-" . $today["mon"] . "-" . $today["mday"];
$txtLogTime = date("H:i:s");
$txtLogDesc = "Accessing : Otorisasi Data";

$query = "INSERT INTO LOGACTIVITY (LOGUSER, LOGDATE, LOGTIME, LOGDESC) VALUES ('$userid', '$txtLogDate', '$txtLogTime', '$txtLogDesc')";
$result = sqlsrv_query($conn2, $query);

sqlsrv_close($conn2);
?>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="keywords" content="jquery,ui,easy,easyui,web">
	<meta name="description" content="easyui help you build your web page easily!">
	<title>jQuery EasyUI CRUD Demo</title>
	<link rel="stylesheet" type="text/css" href="js/jquery-easyui-1.3.4/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="js/jquery-easyui-1.3.4/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="js/jquery-easyui-1.3.4/demo/demo.css">
	<script type="text/javascript" src="js/jquery-easyui-1.3.4/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery-easyui-1.3.4/jquery.easyui.min.js"></script>
	<link rel="stylesheet" href="css/bootstrap5/bootstrap.min.css" />
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
	<script type="text/javascript">
		var url;

		function saveData() {
			$('#fn').form('submit', {
				url: url,
				onSubmit: function() {
					return $(this).form('validate');
				},
				success: function(result) {
					var result = eval('(' + result + ')');
					if (result.success) {
						$('#dig').dialog('close');
						$('#dg').datagrid('reload');
					} else {
						$.messager.show({
							title: 'Error',
							msg: result.msg
						});
					}
				}
			});
		}

		function removeUser() {
			var row = $('#dg').datagrid('getSelected');
			if (row) {
				$('#dig').dialog('open').dialog('setTitle', 'Otorisasi');
				$('#fn').form('load', row);
				url = 'kk_trsotor3.php';
			}
		}

		// function otorisasiSemua() {
		// 	$.get('kk_trsotor4.php', function(data) {
        //         alert("Server Returned: " + data);
        //     });
        //     return false;

			
		// }
		$(function() {
        $('.click-button').click(function() {
            $.get('kk_trsotor4.php', function(data) {
				var result = eval('(' + data + ')');
					if (result.success) {
						$('#dg').datagrid('reload');
						alert("Otorisasi Kolektif Sukses Brow")
					} else {
						$.messager.show({
							title: 'Error',
							msg: result.msg
						});
					}
            });
            return false;
        });
    });

		function myformatter(date) {
			var y = date.getFullYear();
			var m = date.getMonth() + 1;
			var d = date.getDate();
			return (d < 10 ? ('0' + d) : d) + '/' + (m < 10 ? ('0' + m) : m) + '/' + y;
		}

		function myparser(s) {
			if (!s) return new Date();
			var ss = s.split('/');
			var y = parseInt(ss[2], 10);
			var m = parseInt(ss[1], 10);
			var d = parseInt(ss[0], 10);
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
	<table id="dg" title="Otorisasi Data Transaksi Kas Kecil" class="easyui-datagrid" style="width:950px;height:400px" url="kk_trsotor1.php" toolbar="#toolbar" rownumbers="true" fitColumns="true" singleSelect="false">
		<thead>
			<tr>
				<th field="trstopc" width="100"><b>Kode Kas</b></th>
				<th field="trsnota" width="100"><b>No. Nota</b></th>
				<th field="trscode" width="100"><b>Kode Trans.</b></th>
				<th field="trsvaluta" width="100"><b>Tanggal</b></th>
				<th field="trsdesc" width="250"><b>Keterangan</b></th>
				<th field="trsdbcr" width="50"><b>D/K</b></th>
				<th field="trsreff" width="150"><b>No. Bukti</b></th>
				<th field="trsnilai" width="100"><b>Jumlah</b></th>
				<th field="trstorf" width="100"><b>Kode Reff.</b></th>
			</tr>
		</thead>
	</table>
	<div id="toolbar">
		<a href="#" class="easyui-linkbutton" iconCls="icon-reload" plain="true" onClick="removeUser()">Otorisasi</a>
		<a href="#" class="click-button easyui-linkbutton" iconCls="icon-reload" plain="true">Otorisasi Semua</a>
	</div>

	<div class="total-nomina mt-4">
		<div class="card" style="width: 24rem;">
			<div class="card-body">
				<h5 class="card-title fs-4">Informasi Total Transaksi</h5>
				<h6 class="card-subtitle mb-2 text-muted fs-5">Total Pemakaian Kasbon : 600.000 </h6>
				<h6 class="card-subtitle mb-2 text-muted fs-5">Total Pemakaian Biaya : 700.000 </h6>
			</div>
		</div>
	</div>

	<div id="dig" class="easyui-dialog" style="width:400px;height:380px;padding:10px 20px" closed="true" buttons="#dig-buttons">
		<div class="ftitle">Kas Kecil</div>
		<form id="fn" method="post" novalidate>
			<div class="fitem">
				<label><span class="style3">No. Nota</span></label>
				<input name="trsnota" class="easyui-validatebox">
			</div>
			<div class="fitem">
				<label><span class="style3">Kode Trans.</span></label>
				<input name="trscode" class="easyui-validatebox">
			</div>
			<div class="fitem">
				<label><span class="style3">Tanggal</span></label>
				<input name="trsvaluta" class="easyui-validatebox">
			</div>
			<div class="fitem">
				<label><span class="style3">Keterangan</span></label>
				<input name="trsdesc" class="easyui-validatebox">
			</div>
			<div class="fitem">
				<label><span class="style3">Debet/Kredit</span></label>
				<input name="trsdbcr" class="easyui-validatebox">
			</div>
			<div class="fitem">
				<label><span class="style3">No. Bukti</span></label>
				<input name="trsreff" class="easyui-validatebox">
			</div>
			<div class="fitem">
				<label><span class="style3">Jumlah</span></label>
				<input name="trsnilai" class="easyui-numberbox" value="0.00" data-options="precision:2,groupSeparator:',',decimalSeparator:'.'">
			</div>
			<div class="fitem">
				<label><span class="style3">Kode Ref.</span></label>
				<input name="trstorf" class="easyui-validatebox">
			</div>
		</form>
	</div>
	<div id="dig-buttons">
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onClick="saveData()">Save</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onClick="javascript:$('#dig').dialog('close')">Cancel</a>
	</div>


</body>

</html>