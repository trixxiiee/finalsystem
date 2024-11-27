<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'php/cdn.php'; ?>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <?php
    if (!isset($_SESSION['user_id']) || $_SESSION['usertype'] !== 'admin') {
        header("Location: login.php");
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $sql = "SELECT username, profilepicture FROM users WHERE id = '$user_id'";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();
    ?>

    <div class="container-fluid">
        <!-- Profile Section - Moved to top -->
        <div class="d-flex align-items-center justify-content-between bg-white shadow-sm p-3 mb-3">
            <img src="images/logo.png" alt="logo" style="max-height: 40px;">
            <div class="d-flex align-items-center gap-3">
                <div class="position-relative">
                    <div class="profile-image-wrapper" style="width: 40px; height: 40px;">
                        <img src="<?php echo htmlspecialchars($user['profilepicture']); ?>" alt="Admin Profile" 
                            class="rounded-circle profile-image border border-2 border-white shadow-sm" 
                            style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                </div>
                <div class="d-flex flex-column">
                    <h6 class="mb-0 text-quaternary"><?php echo htmlspecialchars($user['username']); ?></h6>
                    <span class="text-muted small">Administrator</span>
                </div>
                <a href="php/logout.php" class="btn btn-outline-danger btn-sm ms-3">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>

        <!-- Tab Navigation -->
        <ul class="nav nav-tabs mb-4" id="adminTabs">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#dashboard" title="View overall statistics and summary">
                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    <small class="d-block text-muted">Overview & Stats</small>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#users" title="Manage user accounts">
                    <i class="fas fa-users me-2"></i>Users
                    <small class="d-block text-muted">Manage Accounts</small>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#recipes" title="Manage recipe database">
                    <i class="fas fa-utensils me-2"></i>Recipes
                    <small class="d-block text-muted">Recipe Database</small>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#approval" title="Review pending approvals">
                    <i class="fas fa-chart-bar me-2"></i>Approval
                    <small class="d-block text-muted">Pending Reviews</small>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#profile" title="Edit your profile">
                    <i class="fas fa-user me-2"></i>Profile
                    <small class="d-block text-muted">Account Settings</small>
                </a>
            </li>
        </ul>

        <!-- Main Content -->
        <div class="container-fluid">
            <!-- Tab Content -->
            <div class="tab-content">
                <!-- Dashboard Tab -->
                <div class="tab-pane fade show active" id="dashboard">
                    <?php include 'admin/analytics.php'?>
                </div>

                <!-- Users Tab -->
                <div class="tab-pane fade" id="users">
                    <?php include 'admin/users-management.php'?>
                </div>

                <!-- Recipes Tab -->
                <div class="tab-pane fade" id="recipes">
                    <?php include 'recipes-management.php'?>
                </div>

                <!-- Approval Tab -->
                <div class="tab-pane fade" id="approval">
                    <?php include 'admin/approval-management.php'?>
                </div>

                <!-- Profile Tab -->
                <div class="tab-pane fade" id="profile">
                    <?php include 'admin/adminprofile.php'?>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
