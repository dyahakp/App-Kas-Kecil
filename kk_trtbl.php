<?php
include "kk_ceklogin.php";
?>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="keywords" content="jquery,ui,easy,easyui,web">
	<meta name="description" content="easyui help you build your web page easily!">
	<title></title>
	<link rel="stylesheet" type="text/css" href="js/jquery-easyui-1.3.4/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="js/jquery-easyui-1.3.4/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="js/jquery-easyui-1.3.4/demo.css">
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
			width: 150px;
		}
	</style>
	<script type="text/javascript" src="js/jquery-easyui-1.3.4/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery-easyui-1.3.4/jquery.easyui.min.js"></script>
	<script type="text/javascript">
		var url;

		function newUser() {
			$('#dlg').dialog('open').dialog('setTitle', 'Baru');
			$('#fm').form('clear');
			url = 'kk_trtbl2.php';
		}

		function editUser() {
			var row = $('#dgtr').datagrid('getSelected');
			if (row) {
				$('#dlg').dialog('open').dialog('setTitle', 'Koreksi');
				$('#fm').form('load', row);
				url = 'kk_trtbl4.php?id=' + row.trcode;
			}
		}

		function otorUser() {
			var row = $('#dgtr').datagrid('getSelected');
			if (row) {
				$('#dlg').dialog('open').dialog('setTitle', 'Otorisasi');
				$('#fm').form('load', row);
				url = 'kk_trtbl5.php';
			}
		}

		function saveUser() {
			$('#fm').form('submit', {
				url: url,
				onSubmit: function() {
					return $(this).form('validate');
				},
				success: function(result) {
					var result = eval('(' + result + ')');
					if (result.success) {
						$('#dlg').dialog('close'); // close the dialog
						$('#dgtr').datagrid('reload'); // reload the user data
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
			var row = $('#dgtr').datagrid('getSelected');
			if (row) {
				$('#dlg').dialog('open').dialog('setTitle', 'Hapus');
				$('#fm').form('load', row);
				url = 'kk_trtbl3.php';
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
	<table id="dgtr" title="Table Kode Transaksi" class="easyui-datagrid" url='kk_trtbl1.php' toolbar="#toolbar" rownumbers="true" fitColumns="true" singleSelect="true" style='width:700px;height:450px'>
		<thead>
			<tr>
				<th field="trcode" width="50"><b>Kode</b></th>
				<th field="trdesc" width="250"><b>Keterangan</b></th>
				<th field="trtopc" width="75"><b>Kas Kecil</b></th>
				<th field="trnosl" width="75"><b>No. Ledger</b></th>
				<th field="trvalid" width="50"><b>Valid</b></th>
			</tr>
		</thead>
	</table>
	<div id="toolbar">
		<a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onClick="newUser()">Baru</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onClick="editUser()">Koreksi</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onClick="removeUser()">Hapus</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" plain="true" onClick="otorUser()">Otorisasi</a>
	</div>

	<div id="dlg" class="easyui-dialog" style="width:420px;height:280px;padding:10px 20px" closed="true" buttons="#dlg-buttons">
		<div class="ftitle">Kode Transaksi</div>
		<form id="fm" method="post" novalidate>
			<div class="fitem">
				<label><span class="style3">Kode Transaksi</span></label>
				<input name="trcode" class="easyui-validatebox" required="true">
			</div>
			<div class="fitem">
				<label><span class="style3">Keterangan</span></label>
				<input name="trdesc" class="easyui-validatebox" required="true">
			</div>
			<div class="fitem">
				<label><span class="style3">Kode Kas Kecil</span></label>
				<input id="u3" class="easyui-combobox" name="trtopc" data-options="valueField:'pccode',textField:'pccode',url:'kk_getpc.php'">
			</div>
			<div class="fitem">
				<label><span class="style3">No. Ledger</span></label>
				<input id="u4" class="easyui-combobox" name="trnosl" data-options="valueField:'glcode',textField:'glcode',url:'kk_getsl.php'">
			</div>
		</form>
	</div>
	<div id="dlg-buttons">
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onClick="saveUser()">Save</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onClick="javascript:$('#dlg').dialog('close')">Cancel</a>
	</div>
</body>

</html>