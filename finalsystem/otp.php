<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'php/cdn.php'; ?>
    <link rel="stylesheet" href="css/styles.css">
</head>


<body>
    <div class="container-fluid verificationBody d-flex justify-content-center align-items-center min-vh-100">
        <div class="card login-container p-4 px-5 shadow">
            <div class="text-end mb-3">
                <p class="mb-0"><a href="index.php" class="text-decoration-none text-tertiary"><i class="fas fa-times"></i></a></p>
            </div>
            <h1 class="login-title text-quaternary text-center">DISH-COVERY</h1>
            <h2 class="text-center mb-4">Verify OTP</h2>
            <form class="login-form" action="php/verifyOTP.php" method="post">
                <div class="mb-3">
                    <input type="text" name="otp" class="form-control" placeholder="Enter OTP Code" required>
                </div>
                <div class="mb-3">
                    <input type="text" name="new_password" class="form-control" placeholder="New Password" required>
                </div>
                <div class="mb-3">
                    <input type="text" name="confirm_password" class="form-control" placeholder="Confirm New Password" required>
                </div>
                <button type="submit" class="btn dishbutton w-100 login-button">Verify & Update Password</button>
            </form>
            <div class="login-links mt-3 text-center">
                <p class="mb-2">Didn't receive the code? <a href="php/resendOTP.php" class="text-decoration-none">Resend OTP</a></p>
                <p class="mb-2"><a href="login.php" class="text-decoration-none">Back to Login</a></p>
            </div>
        </div>
    </div>
</body>

</html>