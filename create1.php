<?php
session_start(); // Start the session

require_once 'User1.php';

// Check if the user is logged in

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header('Location: login.php');
    exit;
}

if (isset($_POST['submit'])) {
    $firstName = $_POST['FirstName'];
    $lastName = $_POST['LastName'];
    $mobileNumber = $_POST['MobileNumber'];
    $email = $_POST['Email'];
    $address = $_POST['Address'];

    // Initialize profile picture variable
    $profilePic = null;

    // Move uploaded file to uploads directory
    if (!empty($_FILES['ProfilePic']['name'])) {
        $profilePic = time() . '_' . $_FILES['ProfilePic']['name'];
        if (!move_uploaded_file($_FILES['ProfilePic']['tmp_name'], 'uploads/' . $profilePic)) {
            echo "<div class='alert alert-danger'>Failed to upload file.</div>";
            die();
        }
    }

    $user = new User1();

    if ($user->mobileNumberExists($mobileNumber)) {
        echo "<div class='alert alert-danger'>Mobile number already exists. Please use a different one.</div>";
    } elseif ($user->emailExists($email)) {
        echo "<div class='alert alert-danger'>Email already exists. Please use a different one.</div>";
    } else {
        $user->create1($firstName, $lastName, $mobileNumber, $email, $address, $profilePic);
        echo "<div class='alert alert-success'>User created successfully!</div>";
        header('Location: User_list1.php');
        exit();
    }
}
$existingImage = false; 
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
<body onload="validateAllFields()">
<div class="container">
    <div class="form-container">
        <h2 class="text-center">Create New User</h2>
        <form action="create1.php" method="post" enctype="multipart/form-data" autocomplete="off">
            <div class="form-group">
                <label for="FirstName">First Name</label>
                <input type="text" class="form-control" id="FirstName" name="FirstName" required>
                <div id="first-name-error" class="error-message"></div>
            </div>

            <div class="form-group">
                <label for="LastName">Last Name</label>
                <input type="text" class="form-control" id="LastName" name="LastName" required>
                <div id="last-name-error" class="error-message"></div>
            </div>

            <div class="form-group">
                <label for="MobileNumber">Mobile Number</label>
                <input type="text" class="form-control" id="MobileNumber" name="MobileNumber" required>
                <div id="phone-error" class="error-message"></div>
            </div>

            <div class="form-group">
                <label for="Email">Email</label>
                <input type="email" class="form-control" id="Email" name="Email" required>
                <div id="email-error" class="error-message"></div>
            </div>

            <div class="form-group">
                <label for="Address">Address</label>
                <textarea class="form-control" id="Address" name="Address" rows="3" required></textarea>
                <div id="address-error" class="error-message"></div>
            </div>

            <div class="form-group">
                <label for="ProfilePic">Profile Picture</label>
                <input type="file" class="form-control-file" id="ProfilePic" name="ProfilePic" accept=".jpg, .png" onchange="validateImage()" required>
                <div id="image-error" class="error-message"></div>
            </div>

            <button type="submit" name="submit" class="btn btn-primary btn-block" id="submitBtn" disabled>Add User</button>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="script.js" defer></script>
<script>
        // Validate all fields when page loads
        function validateAllFields() {
            validateFirstName();
            validateLastName();
            validatePhone();
            validateEmail();
            validateAddress();
            validateImage();
            checkSubmitButton();
        }
</script>
</script>
</body>
</html>
