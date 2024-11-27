<div class="container mt-4">
    <!-- Search and Filter Section -->
    <div class="row mb-4">
        <div class="col-md-5">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search recipes...">
                <button class="btn dishbutton" type="button">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
        <div class="col-md-5">
            <select class="form-select">
                <option selected>All Categories</option>
                <option>Breakfast</option>
                <option>Lunch</option>
                <option>Dinner</option>
                <option>Desserts</option>
                <option>Snacks</option>
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn dishbutton w-100" data-bs-toggle="modal" data-bs-target="#uploadRecipeModal">
                <i class="fas fa-plus me-2"></i>Upload Recipe
            </button>
        </div>
    </div>

    <!-- Upload Recipe Modal -->
    <div class="modal fade" id="uploadRecipeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">

                <div class="text-end">
                    <button type="button" class="btn-close mb-3" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                    <form id="recipeUploadForm" enctype="multipart/form-data">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="dishName" name="dish_name" placeholder="Dish Name" required>
                            <label for="dishName">Dish Name</label>
                        </div>
                        
                        <div class="form-floating mb-3">
                            <select class="form-select" id="category" name="category" required>
                                <option value="">Select Category</option>
                                <option value="Breakfast">Breakfast</option>
                                <option value="Lunch">Lunch</option>
                                <option value="Dinner">Dinner</option>
                                <option value="Desserts">Desserts</option>
                                <option value="Snacks">Snacks</option>
                            </select>
                            <label for="category">Category</label>
                        </div>

                        <div class="form-floating mb-3">
                            <textarea class="form-control" id="recipe" name="recipe" placeholder="Enter recipe instructions" style="height: 150px" required></textarea>
                            <label for="recipe">Recipe Instructions</label>
                        </div>

                        <div class="mb-3">
                            <label for="recipeImage" class="form-label">Recipe Image</label>
                            <input type="file" class="form-control" id="recipeImage" name="recipe_image" accept="image/*" required onchange="previewImage(this)">
                            <div id="imagePreview" class="mt-2" style="display: none;">
                                <img id="preview" src="#" alt="Recipe Preview" style="max-width: 100%; max-height: 200px; object-fit: contain;">
                            </div>
                        </div>
                    </form>
                    <div class="my-3 text-end">
                    <button type="button" class="btn dishbutton" onclick="uploadRecipe()">Upload Recipe</button>
                </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recipe Grid -->
    <div class="row g-4">
        <?php
        // Query to get approved recipes
        $query = "SELECT * FROM recipeee WHERE status = 'approved' ORDER BY id DESC";
        $result = mysqli_query($conn, $query);

        while ($recipe = mysqli_fetch_assoc($result)) {
            ?>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 shadow-sm recipe-card">
                    <img src="<?php echo htmlspecialchars($recipe['image_path']); ?>" 
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
                            <a href="view-recipe.php?id=<?php echo $recipe['id']; ?>" class="btn dishbutton-sm">
                                View Recipe
                            </a>
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
// Add search functionality
document.querySelector('input[type="text"]').addEventListener('keyup', function(e) {
    const searchText = e.target.value.toLowerCase();
    const recipeCards = document.querySelectorAll('.recipe-card');
    
    recipeCards.forEach(card => {
        const title = card.querySelector('.card-title').textContent.toLowerCase();
        const category = card.querySelector('.text-muted').textContent.toLowerCase();
        
        if (title.includes(searchText) || category.includes(searchText)) {
            card.closest('.col-12').style.display = '';
        } else {
            card.closest('.col-12').style.display = 'none';
        }
    });
});

// Add category filter functionality
document.querySelector('select').addEventListener('change', function(e) {
    const category = e.target.value.toLowerCase();
    const recipeCards = document.querySelectorAll('.recipe-card');
    
    recipeCards.forEach(card => {
        const cardCategory = card.querySelector('.text-muted').textContent.toLowerCase();
        
        if (category === 'all categories' || cardCategory.includes(category)) {
            card.closest('.col-12').style.display = '';
        } else {
            card.closest('.col-12').style.display = 'none';
        }
    });
});

function previewImage(input) {
    const preview = document.getElementById('preview');
    const previewDiv = document.getElementById('imagePreview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewDiv.style.display = 'block';
        }
        
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.src = '#';
        previewDiv.style.display = 'none';
    }
}

function uploadRecipe() {
    const form = document.getElementById('recipeUploadForm');
    const formData = new FormData(form);
    
    // Show loading state
    Swal.fire({
        title: 'Uploading Recipe...',
        text: 'Please wait',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    fetch('php/uploadrecipe.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('uploadRecipeModal'));
            modal.hide();
            
            // Reset form
            form.reset();
            document.getElementById('imagePreview').style.display = 'none';
            
            // Show success message
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Recipe uploaded successfully. It will be reviewed by an admin.',
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                // Optional: Refresh the page to show new recipe if approved
                // window.location.reload();
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Upload Failed',
                text: data.message || 'Something went wrong'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Upload Failed',
            text: 'An unexpected error occurred'
        });
    });
}
</script>
