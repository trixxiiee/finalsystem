<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'php/cdn.php'; ?>
    <link rel="stylesheet" href="css/styles.css">
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <!-- Google reCAPTCHA -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <!-- Add SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<?php
    if (isset($_SESSION['user_id'])) {
        if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin') {
            header("Location: admindashboard.php");
        } else {
            header("Location: userdashboard.php");
        }
        exit();
    }
?>

<body>
    <div class="container-fluid verificationBody d-flex justify-content-center align-items-center min-vh-100">
        <div class="card login-container p-4 px-5 shadow">
            <div class="text-end mb-3">
                <p class="mb-0"><a href="index.php" class="text-decoration-none text-tertiary"><i class="fas fa-times"></i></a></p>
            </div>
            <h1 class="login-title text-quaternary text-center">DISH-COVERY</h1>
            <h2 class="text-center mb-4">LOGIN</h2>
            <form class="login-form" action="php/loginProcess.php" method="post">
                <div class="mb-3">
                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                </div>
                <div class="mb-3 position-relative">
                    <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                    <span class="password-toggle position-absolute" style="top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;">
                        <i class="far fa-eye" id="togglePassword"></i>
                    </span>
                </div>
                <!-- Google reCAPTCHA Widget -->
                <div class="g-recaptcha mb-3" data-sitekey="6Lf7EmMqAAAAAHMqBjFN_tnKRfRihEqnWA8Hmitz"></div>
                <button type="submit" class="btn dishbutton w-100 login-button">Login</button>
            </form>
            <div class="login-links mt-3 text-center">
                <p class="mb-2"><a href="recover.php" class="text-decoration-none">Recover password</a></p>
                <p class="mb-2">Don't have an account? <a href="register.php" class="text-decoration-none">Sign-up</a> here</p>
            </div>
        </div>
    </div>

    <!-- Toggle Password Visibility Script -->
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const passwordField = document.querySelector('#password');

        togglePassword.addEventListener('click', function () {
            // Toggle the type attribute between password and text
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);

            // Toggle the eye icon
            this.classList.toggle('fa-eye-slash');
        });
    </script>

    <!-- Move the error handling code here -->
    <?php
    if (isset($_GET['error'])) {
        $error = $_GET['error'];
        if ($error === 'invalid') {
            echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Login Failed',
                    text: 'Invalid username or password',
                    confirmButtonColor: '#3085d6'
                });
            </script>";
        } else if ($error === 'recaptcha') {
            echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'reCAPTCHA Required',
                    text: 'Please complete the reCAPTCHA verification',
                    confirmButtonColor: '#3085d6'
                });
            </script>";
        }
    }
    ?>
</body>
</html>
