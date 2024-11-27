<?php
if (!isset($_SESSION['user_id']) || $_SESSION['usertype'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>

<div class="container-fluid mt-4">
    <!-- Search and Filter Section -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="input-group">
                <input type="text" class="form-control" id="searchInput" placeholder="Search recipes...">
                <button class="btn dishbutton" type="button" onclick="searchRecipes()">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
        <div class="col-md-6">
            <select class="form-select" id="categoryFilter">
                <option value="" selected>All Categories</option>
                <option value="Breakfast">Breakfast</option>
                <option value="Lunch">Lunch</option>
                <option value="Dinner">Dinner</option>
                <option value="Desserts">Desserts</option>
                <option value="Snacks">Snacks</option>
            </select>
        </div>
    </div>

    <!-- Recipe Grid -->
    <div class="row g-4">
        <?php
        // Query to get all recipes
        $query = "SELECT * FROM recipeee WHERE status = 'approved' ORDER BY id DESC";
        $result = mysqli_query($conn, $query);

        while ($recipe = mysqli_fetch_assoc($result)) {
            ?>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 shadow-sm recipe-card">
                    <img src="../<?php echo htmlspecialchars($recipe['image_path']); ?>" 
                         class="card-img-top" 
                         alt="<?php echo htmlspecialchars($recipe['dish_name']); ?>"
                         style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title text-quaternary"><?php echo htmlspecialchars($recipe['dish_name']); ?></h5>
                        <p class="card-text">
                            <small class="text-muted">
                                <i class="fas fa-utensils me-2"></i><?php echo htmlspecialchars($recipe['category']); ?>
                            </small>
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="rating">
                                <?php
                                // Get average rating
                                $rating_query = "SELECT AVG(rating) as avg_rating FROM ratings WHERE recipe_id = " . $recipe['id'];
                                $rating_result = mysqli_query($conn, $rating_query);
                                $rating_data = mysqli_fetch_assoc($rating_result);
                                $avg_rating = round($rating_data['avg_rating'] ?? 0);

                                // Display stars
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($i <= $avg_rating) {
                                        echo '<i class="fas fa-star text-warning"></i>';
                                    } else {
                                        echo '<i class="far fa-star text-warning"></i>';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <div class="mt-3 d-flex justify-content-between">
                            <a href="../view-recipe.php?id=<?php echo $recipe['id']; ?>" class="btn dishbutton-sm">
                                View Recipe
                            </a>
                            <button class="btn text-white border btn-sm" onclick="deleteRecipe(<?php echo $recipe['id']; ?>)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>

<script>

function deleteRecipe(recipeId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "This recipe will be permanently deleted!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('php/archiveRecipe.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `recipe_id=${recipeId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: 'Recipe has been deleted.',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: data.message || 'Something went wrong'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'An unexpected error occurred'
                });
            });
        }
    });
}

// Update search functionality
function searchRecipes() {
    const searchText = document.getElementById('searchInput').value.toLowerCase();
    const recipeCards = document.querySelectorAll('.recipe-card');
    
    recipeCards.forEach(card => {
        const title = card.querySelector('.card-title').textContent.toLowerCase();
        const category = card.querySelector('.text-muted').textContent.toLowerCase();
        const parent = card.closest('.col-12');
        
        if (title.includes(searchText) || category.includes(searchText)) {
            parent.style.display = '';
        } else {
            parent.style.display = 'none';
        }
    });
}

// Update the existing keyup event listener
document.getElementById('searchInput').addEventListener('keyup', searchRecipes);

// Add category filter functionality
document.querySelector('#categoryFilter').addEventListener('change', function(e) {
    const selectedCategory = e.target.value.toLowerCase();
    const recipeCards = document.querySelectorAll('.recipe-card');
    
    recipeCards.forEach(card => {
        const cardCategory = card.querySelector('.text-muted i').nextSibling.textContent.trim().toLowerCase();
        
        if (selectedCategory === '' || cardCategory === selectedCategory) {
            card.closest('.col-12').style.display = '';
        } else {
            card.closest('.col-12').style.display = 'none';
        }
    });
});
</script>
