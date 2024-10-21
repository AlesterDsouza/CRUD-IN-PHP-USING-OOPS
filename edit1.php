<?php

session_start();
require_once 'User1.php';

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    // exit;
}

$user = new User1();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $existingUser = $user->find1($id);
}

// Check if the form is submitted
if (isset($_POST['submit'])) {
    $firstName = $_POST['FirstName'];
    $lastName = $_POST['LastName'];
    $mobileNumber = $_POST['MobileNumber'];
    $email = $_POST['Email'];
    $address = $_POST['Address'];

    // Handle profile picture upload
    $profilePic = $existingUser['ProfilePic']; // Keep existing profile pic if no new one is uploaded
    if ($_FILES['ProfilePic']['name']) {
        $profilePic = time() . '_' . $_FILES['ProfilePic']['name'];
        move_uploaded_file($_FILES['ProfilePic']['tmp_name'], 'uploads/' . $profilePic);
    }

    // Update user information
    if ($user->update1($id, $firstName, $lastName, $mobileNumber, $email, $address, $profilePic)) {
        header('Location: User_list1.php');
        exit();
    } else {
        echo "<div class='alert alert-danger'>Failed to update user.</div>";
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
    <script src="script.js" defer></script>

    <script>
        var existingImage = <?php echo json_encode(!empty($existingUser['ProfilePic'])); ?>; // Set true if a profile picture exists
    </script>

    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
            max-width: 600px;
        }
        .form-container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .error-message {
            color: red;
        }
        .success-message {
            color: green;
        }

    </style>
</head>
<body onload="validateAllFields()">
    <div class="container">
        <div class="form-container">
            <h2 class="text-center">Edit User</h2>
            <form action="edit1.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data" autocomplete="off" id="editUserForm">
                <input type="hidden" name="ID" value="<?php echo $existingUser['ID']; ?>">

                <div class="form-group">
                    <label for="FirstName">First Name:</label>
                    <input type="text" class="form-control" id="FirstName" name="FirstName" 
                           value="<?php echo htmlspecialchars($existingUser['FirstName']); ?>" 
                           required autocomplete="off" oninput="restrictFirstNameInput()">
                    <div id="first-name-error" class="error-message"></div>
                </div>

                <div class="form-group">
                    <label for="LastName">Last Name:</label>
                    <input type="text" class="form-control" id="LastName" name="LastName" 
                           value="<?php echo htmlspecialchars($existingUser['LastName']); ?>" 
                           required autocomplete="off" oninput="restrictLastNameInput()">
                    <div id="last-name-error" class="error-message"></div>
                </div>

                <div class="form-group">
                    <label for="MobileNumber">Mobile Number:</label>
                    <input type="text" class="form-control" id="MobileNumber" name="MobileNumber" 
                           value="<?php echo htmlspecialchars($existingUser['MobileNumber']); ?>" 
                           required autocomplete="off" oninput="validatePhone()">
                    <div id="phone-error" class="error-message"></div>
                </div>

                <div class="form-group">
                    <label for="Email">Email:</label>
                    <input type="email" class="form-control" id="Email" name="Email" 
                           value="<?php echo htmlspecialchars($existingUser['Email']); ?>" 
                           required autocomplete="off" oninput="validateEmail()">
                    <div id="email-error" class="error-message"></div>
                </div>

                <div class="form-group">
                    <label for="Address">Address:</label>
                    <textarea class="form-control" id="Address" name="Address" required autocomplete="off" oninput="validateAddress()"><?php echo htmlspecialchars($existingUser['Address']); ?></textarea>
                    <div id="address-error" class="error-message"></div>
                </div>

                <div class="form-group">
                    <label for="ProfilePic">Profile Picture:</label>
                    <input type="file" class="form-control-file" id="ProfilePic" name="ProfilePic" accept="image/jpeg, image/png" onchange="validateImage()">
                    <?php if ($existingUser['ProfilePic']): ?>
                        <img src="uploads/<?php echo htmlspecialchars($existingUser['ProfilePic']); ?>" alt="Profile Picture" width="100" class="mt-2">
                    <?php else: ?>
                        <p>No profile picture available.</p>
                    <?php endif; ?>
                    <div id="image-error" class="error-message"></div>
                </div>

                <div class="form-group">
                    <button type="submit" name="submit" class="btn btn-primary btn-block" id="submitBtn" disabled>Update User</button>
                </div>
            </form>
        </div>
    </div>

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
</body>
</html>
