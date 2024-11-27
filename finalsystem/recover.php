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
            <h2 class="text-center mb-4">Recover Password</h2>
            
            <p class="text-center mb-4">
                Enter the email address Registered to your account<br>
                we'll send you a link to reset your password
            </p>

            <form id="recoveryForm" action="php/processRecovery.php" method="POST">
                <div class="mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>
                <button type="submit" class="btn dishbutton w-100 login-button">Submit</button>
            </form>

            <div class="login-links mt-3 text-center">
                <p class="mb-2">Remember password? <a href="login.php" class="text-decoration-none">Login</a> here</p>
            </div>
        </div>
    </div>
    
    <script>
    $(document).ready(function() {
        $('#recoveryForm').on('submit', function(e) {
            e.preventDefault();
            
            $.ajax({
                type: 'POST',
                url: 'php/processRecovery.php',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Email Sent!',
                            text: response.message || 'Password recovery instructions have been sent to your email.',
                            confirmButtonColor: '#3085d6'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'login.php';
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: response.message || 'Something went wrong! Please try again.'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong! Please try again.'
                    });
                }
            });
        });
    });
    </script>
    
</body>

</html>