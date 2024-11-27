<?php
include 'php/cdn.php';

if (!isset($_GET['id'])) {
    header("Location: userdash.php");
    exit();
}

$recipeId = $_GET['id'];
$userId = $_SESSION['user_id'] ?? null;

// Fetch current user's information
$stmt = $conn->prepare("SELECT id, username, profilepicture, usertype FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// Fetch recipe details
$sql = "SELECT * FROM recipeee WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $recipeId);
$stmt->execute();
$recipe = $stmt->get_result()->fetch_assoc();

if (!$recipe) {
    header("Location: userdash.php");
    exit();
}

// Handle rating submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['rating'])) {
    $rating = (int)$_POST['rating'];
    $stmt = $conn->prepare("INSERT INTO ratings (recipe_id, rating) VALUES (?, ?)");
    $stmt->bind_param("ii", $recipeId, $rating);
    $stmt->execute();
}

// Handle comment submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['comment'])) {
    $comment = $_POST['comment'];
    $stmt = $conn->prepare("INSERT INTO comments (user_id, recipe_id, comment) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $userId, $recipeId, $comment);
    $stmt->execute();
}

// Fetch average rating
$stmt = $conn->prepare("SELECT AVG(rating) as average_rating FROM ratings WHERE recipe_id = ?");
$stmt->bind_param("i", $recipeId);
$stmt->execute();
$averageRating = $stmt->get_result()->fetch_assoc()['average_rating'];

// Fetch comments with user information
$stmt = $conn->prepare("
    SELECT c.*, u.username, u.profilepicture 
    FROM comments c 
    LEFT JOIN users u ON c.user_id = u.id 
    WHERE c.recipe_id = ? 
    ORDER BY c.created_at DESC
");
$stmt->bind_param("i", $recipeId);
$stmt->execute();
$comments = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .recipe-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .recipe-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .rating-stars {
            color: #ffc107;
            font-size: 24px;
        }

        .comment-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .comment-box {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-quaternary">
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
                        <li><a class="dropdown-item" href="<?php echo ($user['usertype'] === 'admin') ? 'admindashboard.php' : 'userdashboard.php'; ?>">
                            <i class="fas fa-bars menu-icon"></i> Dashboard</a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item logout-item" href="php/logout.php"><i class="fas fa-sign-out-alt menu-icon"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="recipe-container">

        <h1 class="mb-4"><?= htmlspecialchars($recipe['dish_name']) ?></h1>

        <img src="<?= htmlspecialchars($recipe['image_path']) ?>"
            alt="<?= htmlspecialchars($recipe['dish_name']) ?>"
            class="recipe-image shadow">

        <div class="mb-4">
            <span class="badge bg-quaternary"><?= htmlspecialchars($recipe['category']) ?></span>
            <div class="mt-2">
                <div class="rating-stars">
                    <?php
                    $rating = round($averageRating);
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $rating) {
                            echo '<i class="fas fa-star"></i>';
                        } else {
                            echo '<i class="far fa-star"></i>';
                        }
                    }
                    echo " <small class='text-muted'>(" . number_format($averageRating, 1) . ")</small>";
                    ?>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Recipe Instructions</h5>
                <p class="card-text"><?= nl2br(htmlspecialchars($recipe['recipe'])) ?></p>
            </div>
        </div>

        <!-- Rating Form -->
        <?php if ($userId): ?>
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Rate this Recipe</h5>
                    <form method="POST" class="mb-3">
                        <div class="rating-stars mb-3">
                            <?php for ($i = 5; $i >= 1; $i--): ?>
                                <input type="radio" name="rating" value="<?= $i ?>" id="star<?= $i ?>" class="d-none">
                                <label for="star<?= $i ?>" class="me-1">
                                    <i class="far fa-star"></i>
                                </label>
                            <?php endfor; ?>
                        </div>
                        <button type="submit" class="btn dishbutton">Submit Rating</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>

        <!-- Comments Section -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Comments</h5>

                <?php if ($userId): ?>
                    <form method="POST" class="mb-4">
                        <div class="form-floating mb-3">
                            <textarea class="form-control" name="comment" id="comment" style="height: 100px" required></textarea>
                            <label for="comment">Write a comment</label>
                        </div>
                        <button type="submit" class="btn dishbutton">Post Comment</button>
                    </form>
                <?php endif; ?>

                <div class="comments-container">
                    <?php while ($comment = $comments->fetch_assoc()): ?>
                        <div class="comment-box">
                            <div class="d-flex align-items-center mb-2">
                                <img src="<?= $comment['profilepicture'] ? htmlspecialchars($comment['profilepicture']) : 'images/default-avatar.png' ?>"
                                    class="comment-avatar me-2">
                                <div>
                                    <strong><?= htmlspecialchars($comment['username']) ?></strong>
                                    <small class="text-muted d-block">
                                        <?= date('M d, Y h:i A', strtotime($comment['created_at'])) ?>
                                    </small>
                                </div>
                            </div>
                            <p class="mb-0"><?= htmlspecialchars($comment['comment']) ?></p>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Star rating interaction
        document.querySelectorAll('.rating-stars label').forEach(label => {
            label.addEventListener('mouseover', function() {
                const rating = this.getAttribute('for').replace('star', '');
                document.querySelectorAll('.rating-stars label').forEach((l, index) => {
                    if (index < rating) {
                        l.querySelector('i').classList.replace('far', 'fas');
                    } else {
                        l.querySelector('i').classList.replace('fas', 'far');
                    }
                });
            });
        });

        // Reset stars when mouse leaves the container
        document.querySelector('.rating-stars').addEventListener('mouseleave', function() {
            const selectedRating = this.querySelector('input:checked');
            document.querySelectorAll('.rating-stars label i').forEach(star => {
                star.classList.replace('fas', 'far');
            });
            if (selectedRating) {
                const rating = selectedRating.value;
                document.querySelectorAll('.rating-stars label').forEach((label, index) => {
                    if (index < rating) {
                        label.querySelector('i').classList.replace('far', 'fas');
                    }
                });
            }
        });
    </script>
</body>

</html>