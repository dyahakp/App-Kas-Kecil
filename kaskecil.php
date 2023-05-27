<?php
session_start();

if (isset($_SESSION['User'])) {
  session_destroy();
}
?>
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <title>Aplikasi Kas Kecil ver. 2.0</title>
  <style type="text/css">
    html,
    body {
      height: 100%;
      width: 100%;
      margin: 0;
      padding: 0;
      border: none;
    }

    frameset {
      height: 100%;
      width: 100%;
      margin: 0;
      padding: 0;
      border: none;
    }

    frame[cols="*,*"] {
      height: 100%;
      width: 100%;
      margin: 0;
      padding: 0;
      border: none;
    }

    frame[cols="259,*"] {
      height: 100%;
      width: auto;
      margin: 0;
      padding: 0;
      border: none;
    }
  </style>
</head>
<frameset cols="259,*" framespacing="0" frameborder="no" border="1">
  <!-- Hapus atau comment tag <frame> ini untuk menghilangkan top frame -->
  <!-- <frame src="kkframehead.php" name="topFrame" scrolling="No" noresize="noresize" id="topFrame" title="topFrame" /> -->

  <frame src="kkframemenu.php" name=" leftFrame" scrolling=1 noresize="noresize" id="leftFrame" title="leftFrame" />

  <frame src="kk_login.php" name="mainFrame" id=" mainFrame" title="mainFrame" />


</frameset>

<body>
</body>


</html>