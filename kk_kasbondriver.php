<?php
session_start();
include "kk_ceklogin.php";
include "kk_konek2.php";

$userid = $_SESSION['User'];
$today = getdate();
$txtLogDate = $today['year'] . "-" . $today['mon'] . "-" . $today['mday'];
$txtLogTime = date("H:i:s");
$txtLogDesc = "Accessing: Pemasukan Data Kasbon Driver";

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

		.window-shadow{
			display:none !important;
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
			url = 'kk_inputdriver2.php';
		}

		function editUser() {
			var row = $('#dg').datagrid('getSelected');
			if (row) {
				$('#dtg').dialog('open').dialog('setTitle', 'Koreksi');
				$('#fr').form('load', row);
				url = 'kk_inputdriver4.php';
			}
		}


		$( document ).ready(function() {
			$('#dlg').panel('move',{
    left:100,
    top:100
}); 
}); 
	
		function saveUser()
		{
			$('#fm').form('submit',{
				url: url,
				onSubmit: function(){
					return $(this).form('validate');
				},
				success: function(result){
					var result = eval('('+result+')');
					if (result.success){
						$('#dlg').dialog('close');		// close the dialog
						$('#dg').datagrid('reload');	// reload the user data
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
					var result = eval('('+result+')');
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
					var result = eval('('+result+')');
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
				url = 'kk_inputdriver3.php';
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
	<table id="dg" title="Pemasukan Data Kasbon Driver" class="easyui-datagrid" style="width:800px;height:450px" url="kk_inputdriver1.php" toolbar="#toolbar" rownumbers="true" fitColumns="true" singleSelect="true">
		<thead>
			<tr>
            <th field="iddriver" width="250"><b>ID Driver</b></th>
				<th field="namadriver" width="250"><b>Nama Driver</b></th>
				<th field="nominalkasbon" width="100"><b>Nominal Kasbon</b></th>
                <th field="date_updated" width="100"><b>Tanggal Edit</b></th>
			</tr>
		</thead>
	</table>
	<div id="toolbar">
		<a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onClick="newUser()">Baru</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onClick="editUser()">Koreksi</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onClick="removeUser()">Hapus</a>
	</div>
	<div id="dlg" class="easyui-dialog" style="width:400px;height:380px;padding:10px 20px" closed="true" buttons="#dlg-buttons">
		<div class="ftitle">Kasbon Driver</div>
		<form id="fm" method="post" novalidate>
            <div class="fitem">
				<label><span class="style3">Nama Driver</span></label>
				<input name="namadriver" class="easyui-validatebox">
			</div>
			<div class="fitem">
				<label><span class="style3">Nominal Kasbon</span></label>
				<input name="nominalkasbon" class="easyui-numberbox" value="0.00" data-options="precision:2,groupSeparator:',',decimalSeparator:'.'">
			</div>
		</form>
	</div>
	<div id="dlg-buttons">
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onClick="saveUser()">Save</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onClick="javascript:$('#dlg').dialog('close')">Cancel</a>
	</div>
	<div id="dtg" class="easyui-dialog" style="width:400px;height:380px;padding:10px 20px" closed="true" buttons="#dtg-buttons">
		<div class="ftitle">Edit Kasbon Driver</div>
		<form id="fr" method="post" novalidate>
        <div class="fitem">
				<label><span class="style3">ID Driver</span></label>
				<input name="iddriver" class="easyui-validatebox" disabled>
			</div>
			<div class="fitem">
				<label><span class="style3">Nama Driver</span></label>
				<input name="namadriver" class="easyui-validatebox">
			</div>
			<div class="fitem">
				<label><span class="style3">Nominal Kasbon</span></label>
				<input name="nominalkasbon" class="easyui-numberbox" value="0.00" data-options="precision:2,groupSeparator:',',decimalSeparator:'.'">
			</div>
		</form>
	</div>
	<div id="dtg-buttons">
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onClick="saveDetail()">Save</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onClick="javascript:$('#dtg').dialog('close')">Cancel</a>
	</div>
	<div id="dig" class="easyui-dialog" style="width:400px;height:380px;padding:10px 20px" closed="true" buttons="#dig-buttons">
		<div class="ftitle"><span class="style3">Driver Kasbon</span></div>
		<form id="fn" method="post" novalidate>
        <div class="fitem">
				<label><span class="style3">ID Driver</span></label>
				<input name="iddriver" class="easyui-validatebox">
			</div>
			<div class="fitem">
				<label><span class="style3">Nama Driver</span></label>
				<input name="namadriver" class="easyui-validatebox">
			</div>
			<div class="fitem">
				<label><span class="style3">Nominal Kasbon</span></label>
				<input name="nominalkasbon" class="easyui-numberbox" value="0.00" data-options="precision:2,groupSeparator:',',decimalSeparator:'.'">
			</div>
		</form>
	</div>
	<div id="dig-buttons">
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onClick="saveData()">Save</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onClick="javascript:$('#dig').dialog('close')">Cancel</a>
	</div>
</body>

</html>