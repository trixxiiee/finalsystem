<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'php/cdn.php'; ?>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
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

    <div class="container-fluid verificationBody d-flex justify-content-center align-items-center min-vh-100">
        <div class="card login-container p-4 px-5 shadow">
            <div class="text-end mb-3">
                <p class="mb-0"><a href="index.php" class="text-decoration-none text-tertiary"><i class="fas fa-times"></i></a></p>
            </div>
            <h1 class="login-title text-quaternary text-center">DISH-COVERY</h1>
            <h2 class="text-center mb-4">Sign-up</h2>
            <form class="login-form" action="php/registerProcess.php" method="post">
                <div class="mb-3">
                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                </div>
                <div class="mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>
                <div class="mb-3">
                    <div class="input-group">
                        <div class="position-relative w-100">
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                            <button class="btn toggle-password position-absolute end-0 top-50 translate-middle-y" type="button">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="input-group">
                        <div class="position-relative w-100">
                            <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required>
                            <button class="btn toggle-password position-absolute end-0 top-50 translate-middle-y" type="button">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="termsCheck" required>
                    <label class="form-check-label" for="termsCheck">I agree to the <a href="#" class="text-decoration-none">Terms and Policies</a></label>
                </div>
                <div class="g-recaptcha mb-3" data-sitekey="your-recaptcha-site-key"></div>
                <button type="submit" class="btn dishbutton w-100 login-button">submit</button>
            </form>
            <div class="login-links mt-3 text-center">
                <p class="mb-2">Go to <a href="index.php" class="text-decoration-none">Home</a></p>
            </div>
        </div>
    </div>

    <script>
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.parentElement.querySelector('input');
            const icon = this.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });
    </script>
</body>

</html>