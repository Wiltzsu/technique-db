<?php 
require "add_items.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>
<div class="container centered-container">
    
    <div class="card p-4">
        <h2 class="text-center mb-4">Grappling Technique Journal</h2>
        <p class="text-center"><?php echo $greeting; ?></p>


        <div id="accordion">
        <a href="../index.php" class="btn btn-primary btn1">Back to Home</a>

            <div class="card">
                <div class="card-header" id="headingOne">
                    <h5 class="mb-0">
                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Add a technique to the database.
                        </button>
                    </h5>
                </div>

                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">

                    <!-- Technique Form Column -->
                    <div class="col-md-4">
                        <form action="home_technique.php" method="POST">
                            <h4>Add a New Technique</h4>

                            <!-- Name -->
                            <div class="form-group">
                                <label for="techniqueName">Technique Name:</label>
                                <input type="text" class="form-control" id="techniqueName" name="techniqueName" required>
                            </div>

                            <!-- Description -->
                            <div class="form-group">
                                <label for="techniqueDescription">Description:</label>
                                <textarea class="form-control" id="techniqueDescription" name="techniqueDescription" required></textarea>
                            </div>

                            <!-- Category -->
                            <div class="form-group">
                                <label for="techniqueCategory">Category:</label>
                                <select class="form-control" id="categoryID" name="categoryID" required>
                                    <option value="">Select a Category</option>
                                    <?= $categoryOptions; ?>
                                </select>
                            </div>

                            <!-- Position -->
                            <div class="form-group">
                                <label for="techniquePosition">Position:</label>
                                <select class="form-control" id="positionID" name="positionID" required>
                                    <option value="">Select a Position</option>
                                    <?= $positionOptions; ?>
                                </select>
                            </div>

                            <!-- Difficulty -->
                            <div class="form-group">
                                <label for="techniqueDifficulty">Difficulty:</label>
                                <select class="form-control" id="difficultyID" name="difficultyID" required>
                                    <option value="">Select a Difficulty</option>
                                    <?= $difficultyOptions; ?>
                                </select>
                            </div>

                            <button type="submit" name="submitTechnique" class="btn btn-primary btn1">Add Technique</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <div class="card">
        <div class="card-header" id="headingTwo">
            <h5 class="mb-0">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                Add a category to the database.
                </button>
            </h5>
        </div>

        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
            <div class="card-body">
                <!-- Category Form Column -->
                <div class="col-md-4">
                    <form action="home_technique.php" method="POST">

                        <!-- Category name -->
                        <h4>Add a New Category</h4>
                        <div class="form-group">
                            <label for="categoryName">Category Name:</label>
                            <input type="text" class="form-control" id="categoryName" name="categoryName" required>
                        </div>

                        <div class="form-group">
                            <label for="categoryDescription">Category Name:</label>
                            <input type="text" class="form-control" id="categoryDescription" name="categoryDescription" required>
                        </div>
                        <button type="submit" name="submitCategory" class="btn btn-primary btn1">Add Category</button>
                    </form>
                </div>        
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="headingThree">
            <h5 class="mb-0">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                Add a position to the database.
                </button>
            </h5>
        </div>

        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
            <div class="card-body">
                <!-- Position Form Column -->
                <div class="col-md-4">
                    <form action="home_technique.php" method="POST">

                        <!-- Position name -->
                        <h4>Add a New Position</h4>
                        <div class="form-group">
                            <label for="positionName">Position Name:</label>
                            <input type="text" class="form-control" id="positionName" name="positionName" required>
                        </div>

                        <!-- Position description -->
                        <div class="form-group">
                            <label for="positionDescription">Position Name:</label>
                            <input type="text" class="form-control" id="positionDescription" name="positionDescription" required>
                        </div>
                        <button type="submit" name="submitPosition" class="btn btn-primary btn1">Add Position</button>
                    </form>
                </div>        
            </div>
        </div>
    </div>


        <?php
        if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {?>
                <div class="text-center mt-3">
            <a href="../users/logout.php" class="btn btn-primary btn1">Logout</a>
        </div><?php
        }?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
