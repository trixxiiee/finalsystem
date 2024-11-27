<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'php/cdn.php'; ?>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>

    <?php
    $user_id = (int)$_SESSION['user_id'];
    $query = "SELECT * FROM users WHERE id = $user_id";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);
    ?>

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
                            <img src="<?php echo htmlspecialchars($user['profilepicture']); ?>" class="rounded profile-image" width="40" height="40">
                        </div>
                        <span class="ms-2 username-text"><?php echo htmlspecialchars($user['username']); ?></span>
                    </a>
                    <ul class="dropdown-menu userSetting dropdown-menu-end animated-dropdown">
                        <li><a class="dropdown-item" href="userdashboard.php"><i class="fas fa-bars menu-icon"></i> User Dashboard</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item logout-item" href="php/logout.php"><i class="fas fa-sign-out-alt menu-icon"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-5">

        <!-- Profile Section -->
        <div class="card">
            <div class="card-body p-5">
                <form method="POST" action="php/updateProfile.php" enctype="multipart/form-data">
                    <!-- Profile Header -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="position-relative">
                                <img id="profileImagePreview"
                                    src="<?php echo htmlspecialchars($user['profilepicture']); ?>"
                                    class=" img-fluid"
                                    style="width: 200px; height: 200px; object-fit: cover;">
                            </div>
                        </div>
                        <div class="col-md-9">
                            <h2 class="text-quaternary"><?php echo htmlspecialchars($user['username']); ?></h2>
                            <p class="text-tertiary mb-1"><?php echo htmlspecialchars($user['email']); ?> - <?php echo htmlspecialchars($user['usertype']); ?></p>
                            <small class="text-muted">Avatar by dischcovery.com. Or upload your own...</small>

                            <!-- File Upload Area -->
                            <div class="mt-3">
                                <div class="upload-area border rounded p-3 text-center text-muted"
                                    id="dropZone"
                                    ondrop="dropHandler(event)"
                                    ondragover="dragOverHandler(event)">
                                    <div class="upload-text">
                                        Drop your files here or
                                        <label for="fileInput" class="text-primary" style="cursor: pointer;">browse</label>
                                        <input type="file"
                                            id="fileInput"
                                            name="profileImage"
                                            accept="image/*"
                                            style="display: none;"
                                            onchange="handleFiles(this.files)">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Account Form -->
                    <h3 class="mb-4 text-quaternary">Account</h3>
                    <div class="row g-3">
                        <div class="col-md-6 mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text"
                                class="form-control"
                                id="username"
                                name="username"
                                value="<?php echo htmlspecialchars($user['username']); ?>">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email"
                                class="form-control"
                                id="email"
                                name="email"
                                value="<?php echo htmlspecialchars($user['email']); ?>">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password"
                                class="form-control"
                                id="password"
                                name="password"
                                placeholder="••••••••">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text"
                                class="form-control"
                                id="title"
                                name="title"
                                readonly
                                value="<?php echo htmlspecialchars($user['usertype']); ?>">
                        </div>

                    </div>

                    <!-- Moved save button here -->
                    <div class="mt-4 d-flex justify-content-end">
                        <button type="submit" class="btn dishbutton">
                            <i class="bi bi-check-lg"></i> Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add this before closing body tag -->

    <script>
        function dragOverHandler(ev) {
            ev.preventDefault();
            ev.stopPropagation();
            document.getElementById('dropZone').classList.add('dragover');
        }

        function dropHandler(ev) {
            ev.preventDefault();
            ev.stopPropagation();

            document.getElementById('dropZone').classList.remove('dragover');

            if (ev.dataTransfer.items) {
                const file = ev.dataTransfer.items[0].getAsFile();
                if (file.type.startsWith('image/')) {
                    handleFiles([file]);
                }
            }
        }

        function handleFiles(files) {
            const file = files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Update the profile image preview
                    document.getElementById('profileImagePreview').src = e.target.result;
                }
                reader.readAsDataURL(file);

                // Optional: Auto upload
                uploadFile(file);
            }
        }

        function uploadFile(file) {
            // Update the file input for form submission
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            document.getElementById('fileInput').files = dataTransfer.files;

            const formData = new FormData();
            formData.append('profileImage', file);

            // Preview update
            fetch('php/uploadProfilePicture.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update all profile pictures on page
                    document.querySelectorAll('img[src*="' + <?php echo json_encode($user['profilepicture']); ?> + '"]')
                        .forEach(img => img.src = data.newImageUrl + '?' + new Date().getTime());
                }
            })
            .catch(error => console.error('Error:', error));
        }
    </script>

</body>

</html>