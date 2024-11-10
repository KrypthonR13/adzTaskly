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


    <title>Halaman | Register</title>
</head>

<body>
    <div class="container">
        <div class="card login-form" style="height: 500px;">
            <div class="card-body">
                <h2 class="card-title pt-3 fw-bold">Adz<span>Taskly.</span></h2>
                <h6 class="card-subtitle text-muted mb-5">Please Register to Use this Service!</h6>
                <form method="POST">
                    <?php
                        if(isset($_POST['daftar'])){
                            $name = $_POST['name'];
                            $email = $_POST['email'];
                            $password = md5($_POST['password']);


                            $cek_email = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'"));
                            
                            if ($cek_email > 0){
                                echo '<div class="alert alert-danger mb-1" role="alert">';
                                echo 'Email yang anda inputkan sudah terdaftar!!';
                                echo '</div>';
                                echo '<meta http-equiv="refresh" content="2;url=regis.php">';
                            } else{
                                $reg = mysqli_query($conn, "INSERT INTO users (id_user, name, email, password)
                                VALUES (NULL, '$name', '$email', '$password')");
                                if ($reg) {
                                    echo '<div class="alert alert-success mb-1" role="alert">';
                                    echo 'Daftar akun berhasil!!';
                                    echo '</div>';
                                    echo '<meta http-equiv="refresh" content="1;url=login.php">';
                                }
                            }

                        }

                    ?>
                    <div class="mb-4">
                        <label for="name" class="form-label">Name<span
                                style="color: red;">*</span></label>
                        <input type="text" class="form-control fw-bold" id="name" name="name"
                            placeholder="Masukkan nama anda!" style="border-radius: 20px; height: 35px;" required>
                    </div>
                    <div class="mb-4">
                        <label for="email" class="form-label">Email<span
                                style="color: red;">*</span></label>
                        <input type="email" class="form-control fw-bold" id="email" name="email"
                            aria-describedby="emailHelp" placeholder="Masukkan email anda!"
                            style="border-radius: 20px; height: 35px;" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password<span
                                style="color: red;">*</span></label>
                        <input type="password" class="form-control fw-bold" id="password" name="password"
                            placeholder="Buat password yang sulit di tebak!" style="border-radius: 20px; height: 35px;" required>
                    </div>
                    <div class="checkbox mb-4 d-flex justify-content-start">
                        <label>
                            <input type="checkbox" onclick="myFunction()"> Show Password
                        </label>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-login" name="daftar" value="daftar">
                            Daftar
                        </button>
                    </div>
                    <div class="mt-3">
                        <p>Sudah punya akun?<a href="login.php" style="text-decoration: none; color: #0d6efd;">
                                Login</a>
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