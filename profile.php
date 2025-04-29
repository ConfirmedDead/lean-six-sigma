<?php
session_start();
require_once('User.php');
$user = new User();
// Example: Check if the user is logged in
$isLoggedIn = isset($_SESSION['user_id']); // Assuming 'user_id' is set in the session when logged in

if (!isset($_SESSION['user_id'])) {
    header("Location: loginPage.php");
    exit();
}

// Handle actions
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (!empty($_POST['action'])) {
        if ($_POST['action'] == "update") {

            $newUsername = trim($_POST['new_username']);

            if (empty($newUsername)) {
                $error = "Username cannot be empty.";
            } else {
                // Create a new database connection
                $db = new DBConn();
                $db->open();

                // Prepare the SQL query to check if username already exists
                $stmt = $db->conn->prepare("SELECT id FROM users WHERE username = ?");
                $stmt->bind_param("s", $newUsername);
                $stmt->execute();
                $stmt->store_result();

                if ($stmt->num_rows > 0) {
                    // Username already taken
                    $error = "Username taken.";
                } else {
                    // Username is available, proceed with update
                    if ($user->update($_SESSION['user_id'], $newUsername)) {
                        $_SESSION['username'] = $newUsername;
                        $success = "Username updated successfully!";
                    } else {
                        $error = "Failed to update username. Please try again.";
                    }
                }

                $stmt->close();
                $db->close();
            }
        }else if ($_POST['action'] == "delete") {
            if (User::delete($_SESSION['user_id'])) {  // <<< static call (User::delete)
                $_SESSION = array();
                session_destroy();
                header("Location: signupPage.php");
                exit();
            } else {
                $error = "Failed to delete account. Please try again.";
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile | Jogablogwen Code Recovery</title>
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <!-- Navbar -->
    <header class="main-header">
        <div class="logo">
            <h1>Jogablogwen <span>Code Recovery</span></h1>
            <p class="tagline">Restoring code. Rebuilding confidence.</p>
        </div>
        <nav class="navbar">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="problemPage.php">Problem</a></li>
                <li><a href="postProblemPage.php">Post a Problem</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <script>
        let prevScrollPos = window.pageYOffset;
        const header = document.querySelector(".main-header");
        window.onscroll = function () {
            let currentScrollPos = window.pageYOffset;
            header.style.top = (prevScrollPos > currentScrollPos) ? "0" : "-100px";
            prevScrollPos = currentScrollPos;
        };
    </script>

    <div class="profile-container">
        <h2>Welcome, <span class="highlight"><?= htmlspecialchars($_SESSION['username'] ?? $user->username) ?></span>!</h2>

        <?php if (isset($success)): ?>
            <p class="success-message"><?= htmlspecialchars($success) ?></p>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <p class="error-message"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="POST" class="profile-form">
            <input type="hidden" name="action" value="update">
            <label for="new_username">Update Username:</label>
            <input type="text" id="new_username" name="new_username" placeholder="Enter new username" required>
            <button type="submit">Update Username</button>
        </form>

        <form method="POST" class="profile-form delete-form">
            <input type="hidden" name="action" value="delete">
            <button type="submit" onclick="return confirm('Are you sure you want to delete your account?');">Delete Account</button>
        </form>
    </div>

    <!-- footer -->
    <footer class="footer">
    <div class="footer-content">
        <p>&copy; 2025 Jogablogwen Code Recovery. All rights reserved.</p>
        <div class="footer-links">
            <a href="index.php">Home</a>
            <a href="problemPage.php">Problem</a>
            <?php if (!$isLoggedIn): // Show these links only if the user is not logged in ?>
                <a href="signupPage.php">Signup</a>
                <a href="loginPage.php">Login</a>
            <?php else: // Show a logout link if the user is logged in ?>
                <a href="profile.php">Profile</a>
                <a href="postProblemPage.php">Post a Problem</a>
            <?php endif; ?>
        </div>
    </div>
    </footer>
</body>
</html>
