<div class="container mt-4">
    <h2 class="mb-4 text-quaternary">Meal Planner</h2>
    
    <form id="mealPlanForm" method="post">
        <!-- Date Input -->
        <div class="form-floating mb-3">
            <input type="date" class="form-control" id="planDate" name="planDate" required>
            <label for="planDate">Select Date</label>
        </div>

        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs mb-3" id="mealTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active text-quaternary" id="breakfast-tab" data-bs-toggle="tab" 
                        data-bs-target="#breakfast" type="button" role="tab">Breakfast</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link text-quaternary" id="lunch-tab" data-bs-toggle="tab" 
                        data-bs-target="#lunch" type="button" role="tab">Lunch</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link text-quaternary" id="snack-tab" data-bs-toggle="tab" 
                        data-bs-target="#snack" type="button" role="tab">Snack</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link text-quaternary" id="dinner-tab" data-bs-toggle="tab" 
                        data-bs-target="#dinner" type="button" role="tab">Dinner</button>
            </li>
        </ul>

        <!-- Tabs Content -->
        <div class="tab-content" id="mealTabsContent">
            <!-- Breakfast Tab -->
            <div class="tab-pane fade show active" id="breakfast" role="tabpanel">
                <div class="form-floating mb-3">
                    <textarea class="form-control" id="breakfastDesc" name="breakfast" 
                              style="height: 100px"></textarea>
                    <label for="breakfastDesc">Breakfast Description</label>
                </div>
            </div>

            <!-- Lunch Tab -->
            <div class="tab-pane fade" id="lunch" role="tabpanel">
                <div class="form-floating mb-3">
                    <textarea class="form-control" id="lunchDesc" name="lunch" 
                              style="height: 100px"></textarea>
                    <label for="lunchDesc">Lunch Description</label>
                </div>
            </div>

            <!-- Snack Tab -->
            <div class="tab-pane fade" id="snack" role="tabpanel">
                <div class="form-floating mb-3">
                    <textarea class="form-control" id="snackDesc" name="snack" 
                              style="height: 100px"></textarea>
                    <label for="snackDesc">Snack Description</label>
                </div>
            </div>

            <!-- Dinner Tab -->
            <div class="tab-pane fade" id="dinner" role="tabpanel">
                <div class="form-floating mb-3">
                    <textarea class="form-control" id="dinnerDesc" name="dinner" 
                              style="height: 100px"></textarea>
                    <label for="dinnerDesc">Dinner Description</label>
                </div>
            </div>
        </div>

        <button type="submit" class="btn dishbutton" id="saveMealPlan">Save Meal Plan</button>
    </form>
</div>

<!-- Display Meal Plans Table -->
<div class="table-responsive mt-4">
    <table class="table table-bordered">
        <thead>
            <tr class="text-center">
                <th style="color: #169d60">Date</th>
                <th style="color: #169d60">Breakfast</th>
                <th style="color: #169d60">Lunch</th>
                <th style="color: #169d60">Snack</th>
                <th style="color: #169d60">Dinner</th>
                <th style="color: #169d60">Actions</th>
            </tr>
        </thead>
        <tbody id="mealPlansTableBody">
            <?php
            // Query to get meal plans for current user
            $user_id = $_SESSION['user_id'];
            $query = "SELECT * FROM meal_plans WHERE user_id = ? ORDER BY day DESC";
            
            if ($stmt = mysqli_prepare($conn, $query)) {
                mysqli_stmt_bind_param($stmt, "i", $user_id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                while ($row = mysqli_fetch_assoc($result)) {
                    echo generateTableRow($row);
                }

                mysqli_stmt_close($stmt);
            }

            // Add a function to generate the table row HTML
            function generateTableRow($row) {
                return "<tr data-meal-id='" . $row['id'] . "'>" .
                    "<td>" . date('F j, Y', strtotime($row['day'])) . "</td>" .
                    "<td>" . htmlspecialchars($row['breakfast']) . "</td>" .
                    "<td>" . htmlspecialchars($row['lunch']) . "</td>" .
                    "<td>" . htmlspecialchars($row['snack']) . "</td>" .
                    "<td>" . htmlspecialchars($row['dinner']) . "</td>" .
                    "<td class='d-flex gap-2'>" .
                    "<button onclick='markMealDone(" . $row['id'] . ")' class='btn dishbutton-sm btn-sm'><i class='fas fa-check'></i> Done</button>" .
                    "<button onclick='deleteMealPlan(" . $row['id'] . ")' class='btn dishbutton-sm btn-sm'><i class='fas fa-trash'></i> Delete</button>" .
                    "</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Add this JavaScript at the bottom of the file -->
<script>
// Function to update the table with new data
function updateTable(newRow) {
    const tableBody = document.getElementById('mealPlansTableBody');
    tableBody.insertAdjacentHTML('afterbegin', newRow);
}

// Update form submission handler
document.getElementById('mealPlanForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    
    fetch('php/addmeal.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Meal plan added successfully',
                timer: 1500
            }).then(() => {
                // Refresh the page after the success message
                window.location.reload();
            });
        } else {
            // Show error message
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: data.message || 'Failed to add meal plan'
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
});

function deleteMealPlan(mealId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#169d60',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            const formData = new FormData();
            formData.append('meal_id', mealId);
            
            fetch('php/deleteplan.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove the row from the table instead of reloading
                    document.querySelector(`tr[data-meal-id="${mealId}"]`).remove();
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: 'Your meal plan has been deleted.',
                        timer: 1500
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: data.message || 'Failed to delete meal plan'
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

function markMealDone(mealId) {
    // Prevent any default form submission
    event.preventDefault();
    
    const formData = new FormData();
    formData.append('meal_id', mealId);
    formData.append('action', 'done'); // Add action parameter to differentiate from delete
    
    fetch('php/deleteplan.php', {  // Use a separate endpoint for marking as done
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Remove the row from the table instead of reloading
            document.querySelector(`tr[data-meal-id="${mealId}"]`).remove();
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Meal marked as done',
                timer: 1500
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: data.message || 'Error marking meal as done'
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
</script>
