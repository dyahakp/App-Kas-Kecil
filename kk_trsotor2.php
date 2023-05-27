<?php
include "kk_ceklogin.php";
?>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="keywords" content="jquery,ui,easy,easyui,web">
	<meta name="description" content="easyui help you build your web page easily!">
	<title>jQuery EasyUI CRUD Demo</title>
	<link rel="stylesheet" type="text/css" href="jquery-easyui-1.10.16/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="jquery-easyui-1.10.16/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="jquery-easyui-1.10.16/demo/demo.css">
	<script type="text/javascript" src="jquery-easyui-1.10.16/jquery.min.js"></script>
	<script type="text/javascript" src="jquery-easyui-1.10.16/jquery.easyui.min.js"></script>
	<style type="text/css">
		#fn {
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
			width: 80px;
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
						$('#dig').dialog('close'); // close the dialog
						$('#dg').datagrid('reload'); // reload the user data
					} else {
						$.messager.show({
							title: 'Error',
							msg: result.msg
						});
					}
				}
			});
		}

		function otorUser() {
			var row = $('#dg').datagrid('getSelected');
			if (row) {
				$('#dig').dialog('open').dialog('setTitle', 'Otorisasi');
				$('#fn').form('load', row);
				url = 'kk_trsotor3.php';
			}
		}
	</script>
</head>

<body>
	<table id="dg" title="Otorisasi Data Transaksi Kas Kecil" class="easyui-datagrid" style="width:1100px;height:450px" url="kk_trsotor1.php" toolbar="#toolbar" rownumbers="true" fitColumns="true" singleSelect="true">
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
				<th field="trstorf" width="100"><b>Kode Ref.</b></th>
			</tr>
		</thead>
	</table>
	<div id="toolbar">
		<a href="#" class="easyui-linkbutton" iconCls="icon-reload" plain="true" onClick="otorUser()">Otorisasi</a>
	</div>
	<div id="dig" class="easyui-dialog" style="width:400px;height:380px;padding:10px 20px" closed="true" buttons="#dig-buttons">
		<div class="ftitle">Kas Kecil</div>
		<form id="fn" method="post" novalidate>
			<div class="fitem">
				<label>No. Nota</label>
				<input name="trsnota" class="easyui-validatebox">
			</div>
			<div class="fitem">
				<label>Kode Trans.</label>
				<input name="trscode" class="easyui-validatebox">
			</div>
			<div class="fitem">
				<label>Tanggal</label>
				<input name="trsvaluta" class="easyui-validatebox">
			</div>
			<div class="fitem">
				<label>Keterangan</label>
				<input name="trsdesc" class="easyui-validatebox">
			</div>
			<div class="fitem">
				<label>Debet/Kredit</label>
				<input name="trsdbcr" class="easyui-validatebox">
			</div>
			<div class="fitem">
				<label>No. Bukti</label>
				<input name="trsreff" class="easyui-validatebox">
			</div>
			<div class="fitem">
				<label>Jumlah</label>
				<input name="trsnilai" class="easyui-validatebox">
			</div>
			<div class="fitem">
				<label>Kode Ref.</label>
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