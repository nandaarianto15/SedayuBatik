<?php 
include '../koneksi/koneksi.php';
session_start(); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['register'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $passwordConfirm = $_POST['password_confirmation'];

        if ($password !== $passwordConfirm) {
            echo "Password confirmation does not match.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $role = 'user'; 

            $sql = "INSERT INTO users (email, password, role) VALUES ('$email', '$hashedPassword', '$role')";

            if (mysqli_query($conn, $sql)) {
                echo "Registration successful!";
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        }
    }

    if (isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "SELECT id, email, password, role FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $hashedPassword = $row['password'];

            if (password_verify($password, $hashedPassword)) {
                $_SESSION['id'] = $row['id'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['role'] = $row['role'];

                if ($row['role'] == 'admin') {
                    header('Location: ../admin/dashboard.php');
                } else {
                    header('Location: ../index.php');
                }
                exit();
            } else {
                echo "Incorrect password.";
            }
        } else {
            echo "No user found with that email address.";
        }
    }
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../assets/css/login.css">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Sedayu Batik</title>
</head>
<body>
    <div class="container" id="container">
        <!-- Sign Up Form -->
        <div class="form-container sign-up-container">
            <form method="POST" action="">
                <a href="../index.php" style="position: absolute; top: 2px; left: 25px; font-size: 20px;">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <h1>BUAT AKUN</h1>
                <label for="email">Alamat Email</label>
                <input id="email" type="email" name="email" required autocomplete="email">

                <label for="password">Kata Sandi</label>
                <input id="password" type="password" name="password" required autocomplete="new-password">

                <label for="password-confirm">Konfirmasi Kata Sandi</label>
                <input id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password">
                
                <button type="submit" name="register" class="btn">Daftar</button>
            </form>
        </div>

        <!-- Sign In Form -->
        <div class="form-container sign-in-container">
            <form method="POST" action="">
                <a href="../index.php" style="position: absolute; top: 2px; left: 25px; font-size: 20px;">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <h1>MASUK</h1>
                <label for="email">Alamat Email</label>
                <input id="email" type="email" name="email" required autocomplete="email">

                <label for="password">Kata Sandi</label>
                <input id="password" type="password" name="password" required autocomplete="current-password">
                
                <a href="#">Lupa Kata Sandi?</a>
                <button type="submit" name="login" class="btn">Masuk</button>
            </form>
        </div>

        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <img src="../assets/img/logo.png">
                    <button class="btn-overlay" id="signIn">Masuk</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <img src="../assets/img/logo.png">
                    <button class="btn-overlay" id="signUp">Daftar</button>
                </div>
            </div>
        </div>
    </div>
</body>
<script type="text/javascript">
    const signUpButton = document.getElementById('signUp');
    const signInButton = document.getElementById('signIn');
    const container = document.getElementById('container');

    signUpButton.addEventListener('click', () => {
        container.classList.add("right-panel-active");
    });

    signInButton.addEventListener('click', () => {
        container.classList.remove("right-panel-active");
    });
</script>
</html>
