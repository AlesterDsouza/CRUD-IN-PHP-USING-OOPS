<?php

session_start();  // Start a session
$invalid = 0;

// if ($_SERVER['REQUEST_METHOD'] == 'POST') {

//     // Admin credentials (can be replaced by database later)
//     $adminUsername = 'admin';
//     $adminPassword = 'admin123';

//     // Get entered credentials from form
//     $username = $_POST['UserName'];
//     $password = $_POST['Password'];

//     // Check if credentials match the admin details
//     if ($username === $adminUsername && $password === $adminPassword) {
//         // Set session variable to mark user as logged in
//         $_SESSION['is_logged_in'] = true;
//         header('Location: User_list.php');  // Redirect to User_list.php
//         exit();
//     } else {
//         $invalid = 1;  // Invalid credentials flag
//     }
// }




const ADMIN_USERNAME = 'admin';
const ADMIN_PASSWORD = 'admin123'; 

$error = ""; // Initialize error variable

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the submitted username and password
    $UserName = $_POST['UserName'];
    $Password = $_POST['Password'];

   
    if ($UserName === ADMIN_USERNAME && $Password === ADMIN_PASSWORD) {
        $_SESSION['is_logged_in'] = true; // Set session variable
        header('Location: User_list.php'); //It redirects to User_list.php
        exit();
    } else {
        // $error = "Invalid Username or Password!";
        $invalid=1;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Admin Login</title>
</head>
<body>

<?php
if ($invalid) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error!</strong> Invalid admin credentials.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
    </div>';
}
?>

<div class="container">
    <div class="form-container">
        <h1 class="text-center">Admin Login</h1>
        <form action="index.php" method="POST" enctype="multipart/form-data" autocomplete="off">
            <div class="form-group">
                <label for="UserName">Admin Username</label>
                <input type="text" class="form-control" placeholder="Enter admin username" id="UserName" name="UserName" required>
            </div>

            <div class="form-group">
                <label for="Password">Password</label>
                <input type="password" class="form-control" id="Password" name="Password" required>
            </div>

            <button type="submit" name="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
