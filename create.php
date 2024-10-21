<?php

session_start(); // Start the session

// Check if user is logged in; redirect to login if not
if (!isset($_SESSION['is_logged_in'])) {
    header('Location: index.php');
    exit();
}

require_once 'User.php';

if (isset($_POST['submit'])) {

    $UserName = $_POST['UserName'];
    $Password = $_POST['Password'];
    $ConfirmPassword= $_POST['ConfirmPassword'];

    $user = new User();

    if ($Password!=$ConfirmPassword) {
        echo "<div class='alert alert-danger'>Password and Confirm Password in not same</div>";
    } 
    else {
        $user->create($UserName,$Password);
        echo "<div class='alert alert-success'>User created successfully!</div>";
        header('Location: User_list.php');
        exit();
    }

}
// $existingImage = false; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <div class="form-container">
        <h2 class="text-center">Create New Admin</h2>
        <form action="create.php" method="post" enctype="multipart/form-data" autocomplete="off">
            <div class="form-group">
                <label for="UserName">UserName</label>
                <input type="text" class="form-control" id="UserName" name="UserName" required>
                <div id="first-name-error" class="error-message"></div>
            </div>

            <div class="form-group">
                <label for="Password">Password</label>
                <input type="password" class="form-control" id="Password" name="Password" required>
                <div id="last-name-error" class="error-message"></div>
            </div>

            <div class="form-group">
                <label for="ConfirmPassword">ConfirmPassword</label>
                <input type="password" class="form-control" id="ConfirmPassword" name="ConfirmPassword" required>
                <div id="last-name-error" class="error-message"></div>
            </div>


            <button type="submit" name="submit" class="btn btn-primary w-100">Add User</button>

          
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="script.js" defer></script>
<!-- <script>
    // Call validateImage on page load to check the image validation state
    window.onload = validateImage;
</script> -->
</body>
</html>
