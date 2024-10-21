<?php
session_start();
require_once 'User.php';

$userObj = new User();


const ADMIN_USERNAME = 'admin';
const ADMIN_PASSWORD = 'admin123'; 

$error = ""; // Initialize error variable

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the submitted username and password
    $UserName = $_POST['UserName'];
    $Password = $_POST['Password'];

   
    if ($UserName === ADMIN_USERNAME && $Password === ADMIN_PASSWORD) {
        $_SESSION['loggedin'] = true; // Set session variable
        header('Location: User_list.php'); //It redirects to User_list2.php
        exit();
    } else {
        $error = "Invalid Username or Password!";
    }
}


// Check if the form is submitted
if (isset($_POST['login'])) {
    $UserName = $_POST['UserName'];
    $Password = $_POST['Password'];

    // Fetch all users from the database
    $users = $userObj->read();

    $authenticated = false;
    // $adminUsername = 'admin';
    // $adminPassword = 'admin123';

    // Loop through users to check if credentials match
    foreach ($users as $user) {
        // Compare the base64-encoded entered password with the stored one
        if ($user['UserName'] === $UserName && $user['Password'] === base64_encode($Password)) {
            $_SESSION['loggedin'] = true;
            $_SESSION['UserName'] = $UserName;
            $authenticated = true;
            break;
        }
    }

    if ($authenticated) {
        header('Location: User_list1.php');  // Redirect to User_list.php on successful login
        exit();
    } else {
        $error = "Invalid Username or Password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2 class="text-center">Login</h2>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="UserName">Username:</label>
                <input type="text" name="UserName" class="form-control"  autocomplete="off" required>
            </div>

            <div class="form-group">
                <label for="Password">Password:</label>
                <input type="password" name="Password" class="form-control" autocomplete="off" required>
            </div>

            <div class="form-group">
                <button type="submit" name="login" class="btn btn-primary">Login</button>
            </div>
        </form>
    </div>
</body>
</html>



