<?php
include '../controller/database.php';
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
     <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
     <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/login.css">

    <title>Halaman | Login</title>
</head>

<body>
    <div class="container">
        <div class="card login-form">
            <div class="card-body">
                <h2 class="card-title pt-3 fw-bold">Adz<span>Taskly.</span></h2>
                <h6 class="card-subtitle text-muted mb-5">Please Login to Use this Service!</h6>
                <form method="POST">
                    <?php
                    if (isset($_POST['login'])){
                        $cek = mysqli_query($conn, "SELECT * FROM users WHERE email =
                        '".$_POST['email']."' AND password = '".md5($_POST['password'])."'
                        ");
                        $hasil = mysqli_fetch_array($cek);
                        $masuk = mysqli_num_rows($cek);
                        if ($masuk > 0) {
                                session_start();
                                $_SESSION['id_user'] = $hasil['id_user'];
                                $_SESSION['name'] = $hasil['name'];
                                $_SESSION['email'] = $hasil['email'];
                                header('location:dashboard.php');
                        }else{
                            echo '<div class="alert alert-danger mb-2" role="alert">';
                            echo 'Email atau Password salah!!';
                            echo '</div>';
                            echo '<meta http-equiv="refresh" content="1;url=login.php">';
                        }
                    }

                    ?>
                    <div class="mb-4">
                        <label for="email" class="form-label">Email<span style="color: red;">*</span></label>
                        <input type="email" class="form-control fw-bold" id="email" name="email"
                            aria-describedby="emailHelp" placeholder="Masukkan email terdaftar!"
                            style="border-radius: 20px; height: 35px;" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password<span style="color: red;">*</span></label>
                        <input type="password" class="form-control fw-bold" id="password" name="password"
                            placeholder="Masukkan password anda!" style="border-radius: 20px; height: 35px;" required>
                    </div>
                    <div class="checkbox mb-4 d-flex justify-content-start">
                        <label>
                            <input type="checkbox" onclick="myFunction()"> Show Password
                        </label>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-login" name="login" value="login">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z" />
                                <path fill-rule="evenodd"
                                    d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z" />
                            </svg>
                            Login
                        </button>
                    </div>
                    <div class="mt-3">
                        <p>Tidak punya akun?<a href="register.php" style="text-decoration: none; color: #0d6efd;"> buat
                                akun</a>
                        </p>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <div class="footer mb-5">
        <p style="margin-left: 40%;">&copy; 2024 LATINA ARDELA {2301020041}</p>
    </div>

    <!-- Bootstrap JS-->
    <script src="../bootstrap/js/bootstrap.min.js"></script>

    <script>
        function myFunction() {
            var passwd = document.getElementById("password");
            if (passwd.type === "password") {
                passwd.type = "text";
            } else {
                passwd.type = "password";
            }
        }
    </script>
</body>

</html>
