<?php
// Include your database connection class
require_once 'DBConn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Validate form data
    if (!empty($username) && !empty($password) && !empty($confirm_password)) {
        if ($password === $confirm_password) {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Create a new database connection
            $db = new DBConn();
            $db->open();

            // Prepare the SQL query to insert the user
            $stmt = $db->conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $hashed_password);

            // Execute the query
            if ($stmt->execute()) {
                $success = "Signup successful! You can now <a href='loginPage.php'>log in</a>.";
            } else {
                $error = "Username already exists. Please choose a different one.";
            }

            // Close the statement and connection
            $stmt->close();
            $db->close();
        } else {
            $error = "Passwords do not match.";
        }
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
    <title>Document</title>
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
                <li><a href="postProblemPage.php">Got A Problem</a></li> 
                <li><a href="loginPage.php">Login</a></li>
            </ul>
        </nav>
    </header>
<!-- Signup Form -->
<div style="width:100%;text-align:center;">
        <h1>Sign Up</h1><br>
        <form method="POST" action="signupPage.php">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required><br><br>
            <button type="submit">Sign Up</button>
        </form>

        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>

        <?php if (isset($success)): ?>
            <p style="color: green;"><?php echo $success; ?></p>
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









    <!-- footer -->
    <footer class="footer">
        <div class="footer-content">
            <p>&copy; 2025 Jogablogwen Code Recovery. All rights reserved.</p>
            <div class="footer-links">
                <a href="index.php">Home</a>
                <a href="problemPage.php">Problem</a>
                <a href="postProblemPage.php">Got A Problem</a>
                <a href="loginPage.php">Login</a>
            </div>
        </div>
    </footer>
</body>
</html>