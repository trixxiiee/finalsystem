<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'php/cdn.php'; ?>
    <?php

    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $sql = "SELECT username, profilepicture FROM users WHERE id = '$user_id'";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();
    ?>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-quaternary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="fas fa-utensils me-2 brand-icon"></i>
                Recipe Hub
            </a>
            <div class="navbar-nav ms-auto">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center user-profile-link" href="#" role="button" data-bs-toggle="dropdown">
                        <div class="profile-image-wrapper">
                            <img src="<?php echo htmlspecialchars($user['profilepicture']); ?>" class="rounded-circle profile-image" width="40" height="40">
                        </div>
                        <span class="ms-2 username-text"><?php echo htmlspecialchars($user['username']); ?></span>
                    </a>
                    <ul class="dropdown-menu userSetting dropdown-menu-end animated-dropdown">
                        <li><a class="dropdown-item" href="profile.php"><i class="fas fa-user menu-icon"></i> Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item logout-item" href="php/logout.php"><i class="fas fa-sign-out-alt menu-icon"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid p-0">
        <!-- Tabs Navigation -->
        <ul class="userNav nav nav-tabs" id="dashboardTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="upload-tab" data-bs-toggle="tab" href="#upload" role="tab">Uploaded Recipe</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="nutrition-tab" data-bs-toggle="tab" href="#nutrition" role="tab">Nutrition Tracker</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="mealplanner-tab" data-bs-toggle="tab" href="#mealplanner" role="tab">Meal Planner</a>
            </li>
        </ul>

        <!-- Tabs Content -->
        <div class="tab-content" id="dashboardTabsContent">
            <!-- Upload Recipe Tab -->
            <div class="tab-pane fade show active" id="upload" role="tabpanel">
                <div class="container mt-4">
                    <?php include 'recipelist.php'?>
                </div>
            </div>

            <!-- Nutrition Tracker Tab -->
            <div class="tab-pane fade" id="nutrition" role="tabpanel">
                <div class="container mt-4">
                    <?php include 'nutritiontracker.php'?>
                </div>
            </div>

            <!-- Meal Planner Tab -->
            <div class="tab-pane fade" id="mealplanner" role="tabpanel">
                <div class="container mt-4">
                    <?php include 'mealplanner.php'?>
                </div>
            </div>
        </div>
    </div>

</body>

</html>