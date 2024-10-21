<?php
session_start();  // Start the session

// Check if the user is logged in; if not, redirect to login page
if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    header('Location: index.php');
    exit(); 
}

require_once 'User.php'; 

$userObj = new User();
$users = $userObj->read();

if (!is_array($users)) {
    $users = [];
}

// Logout logic (optional)
if (isset($_POST['logout'])) {
    session_destroy();  // Destroy the session
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Admins</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>List of Admins</h2>
        
        <a href="create.php" class="btn">Create User</a>
        <!-- <form method="POST">
            <button type="submit" name="logout" class="btn">Logout</button>
        </form> -->
        <a href="index.php" class="btn">Logout</a>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>UserName</th>
                    <th>Password</th>
                    <th class="actions-column">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($users) > 0): ?>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['ID']); ?></td>
                        <td><?php echo htmlspecialchars($user['UserName']); ?></td>
            
                        <td><?php echo htmlspecialchars(base64_decode($user['Password'])); ?></td>
                        <td class="actions-column">
                            <a href="edit.php?id=<?php echo $user['ID']; ?>" class="action-link" onclick="return confirm('Are you sure you want to edit this user?');">Edit</a>
                            <a href="delete.php?delete=<?php echo $user['ID']; ?>" class="action-link" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No users found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

