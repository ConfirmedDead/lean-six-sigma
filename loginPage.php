<?php
// Start the session
session_start();

// Include your database connection class
require_once 'DBConn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Check if fields are not empty
    if (!empty($username) && !empty($password)) {
        // Create a new database connection
        $db = new DBConn();
        $db->open();

        // Prepare the SQL query to fetch the user
        $stmt = $db->conn->prepare("SELECT id, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        // Check if the user exists
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $hashed_password);
            $stmt->fetch();

            // Verify the password
            if (password_verify($password, $hashed_password)) {
                // Set session variables
                $_SESSION['user_id'] = $id;
                $_SESSION['username'] = $username;

                // Redirect to a dashboard or home page
                header("Location: index.php");
                exit();
            } else {
                $error = "Invalid password.";
            }
        } else {
            $error = "User not found.";
        }

        // Close the statement and connection
        $stmt->close();
        $db->close();
    } else {
        $error = "Please fill in all fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
 <!-- navbar -->
 <header class="main-header">
        <div class="logo">
            <h1>Jogablogwen <span>Code Recovery</span></h1>
            <p class="tagline">Restoring code. Rebuilding confidence.</p>
        </div>
        <nav class="navbar">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="problemPage.php">Problem</a></li>
                <li><a href="signupPage.php">Signup</a></li>
                <li><a href="postProblemPage.php">Got A Problem</a></li> 
            </ul>
        </nav>
    </header>

       <!-- Login Form -->
       <div style="width:100%;text-align:center;">
        <h1>Log In</h1><br>
        <form method="POST" action="loginPage.php">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>
            <button type="submit">Login</button>
        </form>

        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
    </div>

    <!-- script to make nav bar reactive -->
    <script>
        let prevScrollPos = window.pageYOffset;
        const header = document.querySelector(".main-header");

        window.onscroll = function () {
            let currentScrollPos = window.pageYOffset;

            if (prevScrollPos > currentScrollPos) {
            header.style.top = "0";
            } else {
            header.style.top = "-100px"; // Adjust based on header height
            }

            prevScrollPos = currentScrollPos;
        };
    </script>


<div style="width:100%;text-align:center;">
    <h1>Log In</h1><br>
</div>


<!-- footer -->
<footer class="footer">
        <div class="footer-content">
            <p>&copy; 2025 Jogablogwen Code Recovery. All rights reserved.</p>
            <div class="footer-links">
                <a href="index.php">Home</a>
                <a href="problemPage.php">Problem</a>
                <a href="signupPage.php">Signup</a>
                <a href="postProblemPage.php">Got A Problem</a>
            </div>
        </div>
    </footer>
</body>
</html>
    