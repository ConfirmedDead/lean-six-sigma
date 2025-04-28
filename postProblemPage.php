<?php
// Include your database connection class
require_once 'DBConn.php';

// Makes it so you must be logged in to be on this page
session_start();

// Example: Check if the user is logged in
$isLoggedIn = isset($_SESSION['user_id']); // Assuming 'user_id' is set in the session when logged in

if (!$isLoggedIn) {
    header("Location: loginPage.php");
    exit(); // VERY important after header redirect
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the problem from the form
    $problem = $_POST['problem'];
    $userId = $_SESSION['user_id']; // Get the logged-in user's ID

    // Check if the problem is not empty
    if (!empty($problem)) {
        // Create a new database connection
        $db = new DBConn();
        $db->open();

        // Prepare the SQL query to insert the problem with the user_id
        $stmt = $db->conn->prepare("INSERT INTO problems (description, user_id) VALUES (?, ?)");
        $stmt->bind_param("si", $problem, $userId);

        // Execute the query and check for success
        if ($stmt->execute()) {
            echo "<p>Problem posted successfully!</p>";
        } else {
            echo "<p>Failed to post the problem. Please try again.</p>";
        }

        // Close the statement and database connection
        $stmt->close();
        $db->close();
    } else {
        echo "<p>Please enter a problem description.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Problems | Jogablogwen Code Recovery</title>
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

    <!-- Navbar Scroll Script -->
    <script>
        let prevScrollPos = window.pageYOffset;
        const header = document.querySelector(".main-header");

        window.onscroll = function () {
            let currentScrollPos = window.pageYOffset;

            if (prevScrollPos > currentScrollPos) {
                header.style.top = "0";
            } else {
                header.style.top = "-100px"; 
            }

            prevScrollPos = currentScrollPos;
        };
    </script>

    <!-- Post Problem Content -->
    <div class="profile-container">
        <h1 class="problem-page">Post Your Problem Here</h1>

        <?php if (isset($success)): ?>
            <p class="success-message"><?= htmlspecialchars($success) ?></p>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <p class="error-message"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="POST" action="postProblemPage.php" class="profile-form">
            <label for="problem">Describe Your Problem:</label><br>
            <textarea class="problem-textarea" name="problem" id="problem" rows="10" cols="50" placeholder="Write your problem here..." required></textarea><br><br>
            <input type="submit" name="submit" value="Submit">
        </form>
    </div>

  <!-- footer -->
 <footer class="footer">
    <div class="footer-content">
        <p>&copy; 2025 Jogablogwen Code Recovery. All rights reserved.</p>
        <div class="footer-links">
            <a href="index.php">Home</a>
            <a href="problemPage.php">Problem</a>
                <a href="profile.php">Profile</a>
                <a href="postProblemPage.php">Post a Problem</a>
        </div>
    </div>
    </footer>
</body>
</html>