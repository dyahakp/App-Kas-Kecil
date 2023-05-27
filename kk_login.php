<!DOCTYPE html>
<html>

<head>
    <title> Login KasKecil </title>
    <link rel="stylesheet" href="css/bootstrap5/bootstrap.min.css" />
</head>

<body style="background: #F5F5F5;">
    <!-- <div class="modal-content rounded-4 shadow">
            <div class="form">
                <div class="login">
                    <div class="login-header">
                        <div class="img-logo">
                            <img src="assets/bcas.png" width="260" height="80" alt="logo">
                        </div>
                        <h3>APLIKASI KAS KECIL</h3>
                        <p>Masukan username & password anda untuk login.</p>
                    </div>
                </div>
                <form class="login-form" id="ff" method="post">
                    <input type="text" placeholder="username" name="textUserid" type="text" id="textUserid" />
                    <input type="password" placeholder="password" name="textPassword" type="password" id="textPassword" />
                    <button type="submit" name="buttLogin" value="Login" formaction="kk_koneks1.php">login</button>
                </form>
            </div>
        </div> -->
    <div class="modal-dialog" role="document">
        <div class="modal-content rounded-4 shadow">
            <div class="modal-header p-5 pb-4 border-bottom-0">
                <h1 class="fw-bold mb-0 fs-2">Aplikasi Kas Kecil</h1>
            </div>

            <div class="modal-body p-5 pt-0">
                <form id="ff" method="post">
                    <div class="form-floating mb-3">
                        <input name="textUserid" type="text" id="textUserid" size="12" maxlength="10" class="form-control rounded-3" placeholder="username">
                        <label for="floatingInput">Username</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input name="textPassword" class="form-control rounded-3" type="password" id="textPassword" size="12" placeholder="Password">
                        <label for="floatingPassword">Password</label>
                    </div>
                    <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit" name="buttLogin" value="Login" formaction="kk_koneks1.php">Login</button>

                    <hr class="my-4">

                </form>
            </div>
        </div>
    </div>

</body>

</html>