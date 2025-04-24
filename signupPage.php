<?php
session_start();

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
    <title>Sign Up | Jogablogwen Code Recovery</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
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
                <li><a href="loginPage.php">Login</a></li>
            </ul>
        </nav>
    </header>



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

    

    <!-- Signup Form -->
    <div class="signupbox">
        <h2>Create Your Account</h2>
        <form method="POST" action="signupPage.php">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <label for="confirm_password">Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" required>

            <div class="toggle-password">
                <input type="checkbox" id="showPasswords" onclick="togglePasswords()">
                <label for="showPasswords">Show Passwords</label>
            </div>

            <button type="submit">Sign Up</button>

            <?php if (isset($error)): ?>
                <p class="error-message"><?php echo $error; ?></p>
            <?php endif; ?>

            <?php if (isset($success)): ?>
                <p class="success-message"><?php echo $success; ?></p>
            <?php endif; ?>
        </form>
        <h3 class = "loginTag">Already have an account? <a href="http://localhost/Lean-Six-Sigma/loginPage.php">Click here to Login.</a></h3>
    </div>
    
    <!-- script to hide and show password -->
    <script>
    function togglePasswords() {
        const password = document.getElementById("password");
        const confirm = document.getElementById("confirm_password");

        const type = password.type === "password" ? "text" : "password";
        password.type = type;
        confirm.type = type;
    }
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