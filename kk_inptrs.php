<?php
session_start();
include "kk_ceklogin.php";
include "kk_konek2.php";

$userid = $_SESSION['User'];
$today = getdate();
$txtLogDate = $today['year'] . "-" . $today['mon'] . "-" . $today['mday'];
$txtLogTime = date("H:i:s");
$txtLogDesc = "Accessing: Pemasukan Data";

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
	<link rel="stylesheet" type="text/css" href="js/jquery-easyui-1.3.4/demo.css">
	<script type="text/javascript" src="js/jquery-easyui-1.3.4/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery-easyui-1.3.4/jquery.easyui.min.js"></script>
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

		function newUser() {
			$('#dlg').dialog('open').dialog('setTitle', 'Baru');
			$('#fm').form('clear');
			url = 'kk_inptrs2.php';
		}

		function editUser() {
			var row = $('#dg').datagrid('getSelected');
			if (row) {
				$('#dtg').dialog('open').dialog('setTitle', 'Koreksi');
				$('#fr').form('load', row);
				url = 'kk_inptrs4.php?id=' + row.pccode;
			}
		}

		function saveUser() {
			$('#fm').form('submit', {
				url: url,
				onSubmit: function() {
					return $(this).form('validate');
				},
				success: function(result) {
					var result = eval(result);
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

		function saveData() {
			$('#fn').form('submit', {
				url: url,
				onSubmit: function() {
					return $(this).form('validate');
				},
				success: function(result) {
					var result = eval(result);
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

		function saveDetail() {
			$('#fr').form('submit', {
				url: url,
				onSubmit: function() {
					return $(this).form('validate');
				},
				success: function(result) {
					var result = eval(result);
					if (result.success) {
						$('#dtg').dialog('close'); // close the dialog
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
				$('#dig').dialog('open').dialog('setTitle', 'Hapus');
				$('#fn').form('load', row);
				url = 'kk_inptrs3.php';
			}
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
	<table id="dg" title="Pemasukan Data Transaksi Kas Kecil" class="easyui-datagrid" style="width:800px;height:450px" url="kk_inptrs1.php" toolbar="#toolbar" rownumbers="true" fitColumns="true" singleSelect="true">
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
		<a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onClick="newUser()">Baru</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onClick="editUser()">Koreksi</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onClick="removeUser()">Hapus</a>
	</div>
	<div id="dlg" class="easyui-dialog" style="width:400px;height:380px;padding:10px 20px" closed="true" buttons="#dlg-buttons">
		<div class="ftitle">Kas Kecil</div>
		<form id="fm" method="post" novalidate>
			<div class="fitem">
				<label><span class="style3">Kode Trans.</span></label>
				<input class="easyui-combobox" name="trscode" data-options="valueField:'trcode',textField:'trcode',url:'kk_gettr.php'">
			</div>
			<div class="fitem">
				<label><span class="style3">Tanggal</span></label>
				<input name="trsvaluta" type="text" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser">
			</div>
			<div class="fitem">
				<label><span class="style3">Keterangan</span></label>
				<input name="trsdesc" class="easyui-validatebox">
			</div>
			<div class="fitem">
				<label><span class="style3">Debet/Kredit</span></label>
				<select class="easyui-combobox" name="trsdbcr" style="width:70px;">
					<option value="D">Debet</option>
					<option value="K">Kredit</option>
				</select>
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
				<input class="easyui-combobox" name="trstorf" data-options="valueField:'rfcode',textField:'rfcode',url:'kk_getref.php'">
			</div>
		</form>
	</div>
	<div id="dlg-buttons">
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onClick="saveUser()">Save</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onClick="javascript:$('#dlg').dialog('close')">Cancel</a>
	</div>
	<div id="dtg" class="easyui-dialog" style="width:400px;height:380px;padding:10px 20px" closed="true" buttons="#dtg-buttons">
		<div class="ftitle">Kas Kecil</div>
		<form id="fr" method="post" novalidate>
			<div class="fitem">
				<label><span class="style3">No. Nota</span></label>
				<input name="trsnota" class="easyui-validatebox">
			</div>
			<div class="fitem">
				<label><span class="style3">Kode Trans.</span></label>
				<input id="u8" class="easyui-combobox" name="trscode" data-options="valueField:'trcode',textField:'trcode',url:'kk_gettr.php'">
			</div>
			<div class="fitem">
				<label><span class="style3">Tanggal</span></label>
				<input id="d2" name="trsvaluta" type="text" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser">
			</div>
			<div class="fitem">
				<label><span class="style3">Keterangan</span></label>
				<input name="trsdesc" class="easyui-validatebox">
			</div>
			<div class="fitem">
				<label><span class="style3">Debet/Kredit</span></label>
				<select id="u9" class="easyui-combobox" name="trsdbcr" style="width:70px;">
					<option value="D">Debet</option>
					<option value="K">Kredit</option>
				</select>
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
				<input id="u0" class="easyui-combobox" name="trstorf" data-options="valueField:'rfcode',textField:'rfcode',url:'kk_getref.php'">
			</div>
		</form>
	</div>
	<div id="dtg-buttons">
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onClick="saveDetail()">Save</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onClick="javascript:$('#dtg').dialog('close')">Cancel</a>
	</div>
	<div id="dig" class="easyui-dialog" style="width:400px;height:380px;padding:10px 20px" closed="true" buttons="#dig-buttons">
		<div class="ftitle"><span class="style3">Kas Kecil</span></div>
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