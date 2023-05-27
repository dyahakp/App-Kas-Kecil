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
			width: 120px;
		}
	</style>
	<script type="text/javascript" src="js/jquery-easyui-1.3.4/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery-easyui-1.3.4/jquery.easyui.min.js"></script>
	<script type="text/javascript">
		var url;

		function newUser() {
			$('#dlg').dialog('open').dialog('setTitle', 'Baru');
			$('#fm').form('clear');
			url = 'kk_pcmst2.php';
		}

		function editUser() {
			var row = $('#dg').datagrid('getSelected');
			if (row) {
				$('#dlg').dialog('open').dialog('setTitle', 'Koreksi');
				$('#fm').form('load', row);
				url = 'kk_pcmst4.php?id=' + row.pccode;
			}
		}

		function otorUser() {
			var row = $('#dg').datagrid('getSelected');
			if (row) {
				$('#dlg').dialog('open').dialog('setTitle', 'Otorisasi');
				$('#fm').form('load', row);
				url = 'kk_pcmst5.php';
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
				/* hapus dari grid :       			
				               var index = $('#dg').datagrid('getRowIndex', row);
				               $('#dg').datagrid('deleteRow', index);
				*/
				/* hapus dari database :
								$.messager.confirm('Konfirmasi','Anda Yakin ?',function(r){
									if (r)
									{
										$.post('kk_pcmst3.php',{id:row.pccode},function(result){
											if (result.success)
											{
												$('#dg').datagrid('reload');	                      // reload the user data
											} 
											else 
											{
												$.messager.show({title: 'Error',msg: result.msg});    // show error message
											}
										},'json');
									}
								});
				*/
				$('#dlg').dialog('open').dialog('setTitle', 'Hapus');
				$('#fm').form('load', row);
				url = 'kk_pcmst3.php';
			}
		}
	</script>
	<style type="text/css">
		.style3 {
			font-family: Georgia, "Times New Roman", Times, serif;
			font-size: 12px;
			font-weight: bold;
		}

		.style4 {
			font-family: Georgia, "Times New Roman", Times, serif
		}
	</style>
</head>

<body>
	<table id="dg" title="Master Table Kas Kecil" class="easyui-datagrid" style="width:700px;height:450px" url="kk_pcmst1.php" toolbar="#toolbar" rownumbers="true" fitColumns="true" singleSelect="true">
		<thead>
			<tr>
				<th field="pccode" width="75"><b>Kode</b></th>
				<th field="pcname" width="250"><b>Keterangan</b></th>
				<th field="pcbranch" width="75"><b>Cabang</b></th>
				<th field="pcabrev" width="75"><b>Sktn.</b></th>
				<th field="pcdept" width="50"><b>Dept.</b></th>
				<th field="pcregion" width="50"><b>Reg.</b></th>
				<th field="pcdate" width="100"><b>Tanggal</b></th>
				<th field="pcnosl" width="100"><b>No. Ledger</b></th>
				<th field="pckasbon" width="75"><b>Kasbon</b></th>
				<th field="pcvalid" width="50"><b>Valid</b></th>
			</tr>
		</thead>
	</table>


	<div id="dlg" class="easyui-dialog" style="width:450px;height:350px;padding:10px 20px" closed="true" buttons="#dlg-buttons">
		<div class="ftitle">Kas Kecil</div>
		<form id="fm" method="post" novalidate>
			<div class="fitem">
				<label><span class="style3">Kode Kas Kecil</span></label>
				<input name="pccode" class="easyui-validatebox" required="true">
			</div>
			<div class="fitem">
				<label><span class="style3">Keterangan</span></label>
				<input name="pcname" class="easyui-validatebox" required="true">
			</div>
			<div class="fitem">
				<label><span class="style3">Kode Cabang</span></label>
				<input name="pcbranch" class="easyui-validatebox" required="true">
			</div>
			<div class="fitem">
				<label><span class="style3">Singkatan</span></label>
				<input name="pcabrev" class="easyui-validatebox" required="true">
			</div>
			<div class="fitem">
				<label><span class="style3">Kode Dept.</span></label>
				<input name="pcdept" class="easyui-validatebox" required="true">
			</div>
			<div class="fitem">
				<label><span class="style3">Kode Regional</span></label>
				<input name="pcregion" class="easyui-validatebox" required="true">
			</div>
			<div class="fitem">
				<label><span class="style3">No. Ledger</span></label>
				<input name="pcnosl" class="easyui-validatebox" required="true">
			</div>
			<div class="fitem">
				<label><span class="style3">Kd.Trans.Kasbon</span></label>
				<input name="pckasbon" class="easyui-validatebox" required="true">
			</div>
		</form>
	</div>
	<div id="dlg-buttons">
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onClick="saveUser()">Save</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onClick="javascript:$('#dlg').dialog('close')">Cancel</a>
	</div>
</body>

</html>