<?php
// require_once 'User.php';

// $user = new User();

// if (isset($_GET['id'])) {
//     $id = $_GET['id'];
//     $existingUser = $user->find($id);
// }

// // Check if the form is submitted
// if (isset($_POST['submit'])) {
//     $UserName = $_POST['UserName'];
//     $Password = $_POST['Password'];
//     $ConfirmPassword = $_POST['ConfirmPassword'];

//     // Check if password and confirm password match
//     if ($Password !== $ConfirmPassword) {
//         echo "<div class='alert alert-danger'>Passwords do not match.</div>";
//     } else{
      

//         // Update user information
//        if($user->update($id, $UserName, $Password))
//        {
//             header('Location: User_list.php');
//             exit();
//         } else {
//             echo "<div class='alert alert-danger'>Failed to update user.</div>";
//         }
//     }
// }


session_start(); // Start the session

// Check if user is logged in; redirect to login if not
if (!isset($_SESSION['is_logged_in'])) {
    header('Location: index.php');
    exit();
}



require_once 'User.php';

$user = new User();

// Fetch user by ID when page loads
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $existingUser = $user->find($id);
}

// Check if the form is submitted
if (isset($_POST['submit'])) {
    $id = $_POST['ID'];  // Fetch the ID from POST
    $UserName = $_POST['UserName'];
    $Password = $_POST['Password'];
    $ConfirmPassword = $_POST['ConfirmPassword'];

    // Check if password and confirm password match
    if ($Password !== $ConfirmPassword) {
        echo "<div class='alert alert-danger'>Passwords do not match.</div>";
    } else {
        // Update user information
        if ($user->update($id, $UserName, $Password)) {
            header('Location: User_list.php');  // Redirect after successful update
            exit();
        } else {
            echo "<div class='alert alert-danger'>Failed to update user.</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body onload="validateAllFields()">
    <div class="container">
        <div class="form-container">
            <h2 class="text-center">Edit User</h2>
            <form action="edit.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data" autocomplete="off" id="editUserForm">
                <!-- Hidden input for ID -->
                <input type="hidden" name="ID" value="<?php echo $existingUser['ID']; ?>">

                <div class="form-group">
                    <label for="UserName">UserName:</label>
                    <input type="text" class="form-control" id="UserName" name="UserName" 
                           value="<?php echo htmlspecialchars($existingUser['UserName']); ?>" 
                           required autocomplete="off" oninput="validateUsername()">
                    <div id="username-error" class="error-message"></div>
                </div>

                <div class="form-group">
                    <label for="Password">Password:</label>
                    <input type="password" class="form-control" id="Password" name="Password" 
                           required autocomplete="off" oninput="validatePassword()">
                    <div id="password-error" class="error-message"></div>
                </div>

                <div class="form-group">
                    <label for="ConfirmPassword">Confirm Password:</label>
                    <input type="password" class="form-control" id="ConfirmPassword" name="ConfirmPassword" 
                           required autocomplete="off" oninput="validateConfirmPassword()">
                    <div id="confirm-password-error" class="error-message"></div>
                </div>

                <div class="form-group">
                    <button type="submit" name="submit" class="btn btn-primary btn-block" id="submitBtn" disabled>Update User</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Client-side validation for Username, Password, and Confirm Password
        function validateUsername() {
            const username = document.getElementById('UserName').value;
            if (username === '') {
                document.getElementById('username-error').textContent = 'Username is required';
            } else {
                document.getElementById('username-error').textContent = '';
            }
            checkSubmitButton();
        }

        function validatePassword() {
            const password = document.getElementById('Password').value;
            if (password.length < 6) {
                document.getElementById('password-error').textContent = 'Password must be at least 6 characters long';
            } else {
                document.getElementById('password-error').textContent = '';
            }
            checkSubmitButton();
        }

        function validateConfirmPassword() {
            const password = document.getElementById('Password').value;
            const confirmPassword = document.getElementById('ConfirmPassword').value;
            if (password !== confirmPassword) {
                document.getElementById('confirm-password-error').textContent = 'Passwords do not match';
            } else {
                document.getElementById('confirm-password-error').textContent = '';
            }
            checkSubmitButton();
        }

        function checkSubmitButton() {
            const username = document.getElementById('UserName').value;
            const password = document.getElementById('Password').value;
            const confirmPassword = document.getElementById('ConfirmPassword').value;

            const submitBtn = document.getElementById('submitBtn');

            // Enable the button only if all fields are filled and passwords match
            submitBtn.disabled = !(username && password.length >= 6 && password === confirmPassword);
        }

        // Run all validations on page load
        function validateAllFields() {
            validateUsername();
            validatePassword();
            validateConfirmPassword();
        }
    </script>
</body>
</html>
