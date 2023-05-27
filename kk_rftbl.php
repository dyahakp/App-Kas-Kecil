<?php
include "kk_ceklogin.php";
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
			url = 'kk_rftbl2.php';
		}

		function editUser() {
			var row = $('#dg').datagrid('getSelected');
			if (row) {
				$('#dlg').dialog('open').dialog('setTitle', 'Koreksi');
				$('#fm').form('load', row);
				url = 'kk_rftbl4.php?id=' + row.pccode;
			}
		}

		function otorUser() {
			var row = $('#dg').datagrid('getSelected');
			if (row) {
				$('#dlg').dialog('open').dialog('setTitle', 'Otorisasi');
				$('#fm').form('load', row);
				url = 'kk_rftbl5.php';
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

		function removeUser() {
			var row = $('#dg').datagrid('getSelected');
			if (row) {
				$('#dlg').dialog('open').dialog('setTitle', 'Hapus');
				$('#fm').form('load', row);
				url = 'kk_rftbl3.php';
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
	<table id="dg" title="Table Kode Referensi" class="easyui-datagrid" url="kk_rftbl1.php" toolbar="#toolbar" rownumbers="true" fitColumns="true" singleSelect="true" style="width:700px;height:450px">
		<thead>
			<tr>
				<th field="rfcode" width="50"><b>Kode</b></th>
				<th field="rfdesc" width="250"><b>Keterangan</b></th>
				<th field="rftopc" width="75"><b>Kas Kecil</b></th>
				<th field="rfvalid" width="50"><b>Valid</b></th>
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
		<div class="ftitle">Kode Referensi</div>
		<form id="fm" method="post" novalidate>
			<div class="fitem">
				<label><span class="style3">Kode Referensi</span></label>
				<input name="rfcode" class="easyui-validatebox" required="true">
			</div>
			<div class="fitem">
				<label><span class="style3">Keterangan</span></label>
				<input name="rfdesc" class="easyui-validatebox" required="true">
			</div>
			<div class="fitem">
				<label><span class="style3">Kode Kas Kecil</span></label>
				<input id="cc" class="easyui-combobox" name="rftopc" data-options="valueField:'pccode',textField:'pccode',url:'kk_getpc.php'">
			</div>
		</form>
	</div>
	<div id="dlg-buttons">
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onClick="saveUser()">Save</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onClick="javascript:$('#dlg').dialog('close')">Cancel</a>
	</div>
</body>

</html>