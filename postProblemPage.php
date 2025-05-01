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
    $title = $_POST['title'];
    $userId = $_SESSION['user_id']; // Get the logged-in user's ID

    // Check if the problem is not empty
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $problem = $_POST['problem'];
        $title = $_POST['title'];
        $userId = $_SESSION['user_id']; // Logged-in user's ID
    
        if (!empty($problem) && !empty($title)) {
            // Connect to DB
            $db = new DBConn();
            $db->open();
    
            // Insert both title and problem into the same row
            $stmt = $db->conn->prepare("INSERT INTO problems (title, description, user_id) VALUES (?, ?, ?)");
            $stmt->bind_param("ssi", $title, $problem, $userId);
    
            if ($stmt->execute()) {
                $success = "Problem posted successfully!";
            } else {
                $error = "Failed to post the problem. Please try again.";
            }
    
            $stmt->close();
            $db->close();
        } else {
            $error = "Please fill in both the title and problem description.";
        }
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
            <label for="title">Title:</label><br>
            <textarea class="title-textarea" name="title" id="title" rows="2" cols="50" placeholder="Write your title here..." required></textarea><br><br>

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