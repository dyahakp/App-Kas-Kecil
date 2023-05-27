<?php
include "kk_ceklogin.php";
?>
<html>

<head>
   <title>Basic CRUD Application - jQuery EasyUI CRUD Demo</title>
   <link rel="stylesheet" type="text/css" href="jquery-easyui-1.3.4/themes/default/easyui.css">
   <link rel="stylesheet" type="text/css" href="jquery-easyui-1.3.4/themes/icon.css">
   <link rel="stylesheet" type="text/css" href="jquery-easyui-1.3.4/demo.css">
   <script type="text/javascript" src="jquery-easyui-1.3.4/jquery.min.js"></script>
   <script type="text/javascript" src="jquery-easyui-1.3.4/jquery.easyui.min.js"></script>
   </script>
   <style type="text/css">
      #fm {
         margin: 0;
         padding: 10px 30px;
      }

      .ftitle {
         font-size: 14px;
         font-weight: bold;
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
</head>

<body>
   </div>
   <table class="easyui-datagrid" id="dg" title="Tabel General Ledger" style="width:700px;height:480px" url="kk_gltbl2.php" toolbar="#toolbar" rownumbers="true" fitColumns="true" singleSelect="true">
      <thead>
         <tr>
            <th field="glcode" width="150"><b>Nomor Ledger</b></th>
            <th field="glname" width="350"><b>Keterangan</b></th>
         </tr>
      </thead>
   </table>

   <div id="dlg" class="easyui-dialog" style="width:400px;height:280px;padding:10px 20px" closed="true" buttons="#dlg-buttons">
      <div class="ftitle">Ledger Account</div>
      <form id="fm" method="post" novalidate>
         <div class="fitem">
            <label>No. Ledger:</label>
            <input name="glcode" class="easyui-validatebox" required="true">
         </div>
         <div class="fitem">
            <label>Keterangan:</label>
            <input name="glname" class="easyui-validatebox" required="true">
         </div>
      </form>
   </div>
   <script type="text/javascript">
      var url;

      function newUser() {
         $('#dlg').dialog('open').dialog('setTitle', 'New User');
         $('#fm').form('clear');
         url = 'save_user.php';
      }

      function editUser() {
         var row = $('#dg').datagrid('getSelected');

         if (row) {
            $('#dlg').dialog('open').dialog('setTitle', 'Edit User');
            $('#fm').form('load', row);
            url = 'update_user.php?id=' + row.id;
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

               if (result.errorMsg) {
                  $.messager.show({
                     title: 'Error',
                     msg: result.errorMsg
                  });
               } else {
                  $('#dlg').dialog('close'); // close the dialog
                  $('#dg').datagrid('reload'); // reload the user data
               }
            }
         });
      }

      function destroyUser() {
         var row = $('#dg').datagrid('getSelected');

         if (row) {
            $.messager.confirm('Confirm', 'Are you sure you want to destroy this user?',
               function(r) {
                  if (r) {
                     $.post('destroy_user.php', {
                           id: row.id
                        },
                        function(result) {
                           if (result.success) {
                              $('#dg').datagrid('reload'); // reload the user data
                           } else {
                              $.messager.show({ // show error message
                                 title: 'Error',
                                 msg: result.errorMsg
                              });
                           }
                        }, 'json');
                  }
               });
         }
      }
   </script>
</body>

</html>