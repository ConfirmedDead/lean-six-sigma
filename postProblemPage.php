<?php
// Include your database connection class
require_once 'DBConn.php';

    //makes it so you must be logged in to be on this page
   
    session_start();

    if(!isset($_SESSION['user_id'])){
        header("Location: loginPage.php");
        exit(); // VERY important after header redirect
    }



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the problem from the form
    $problem = $_POST['problem'];

    // Check if the problem is not empty
    if (!empty($problem)) {
        // Create a new database connection
        $db = new DBConn();
        $db->open();

        // Prepare the SQL query to insert the problem
        $stmt = $db->conn->prepare("INSERT INTO problems (description) VALUES (?)");
        $stmt->bind_param("s", $problem);

        // Execute the query and check for success
        if ($stmt->execute()) {
            echo "<p>Problem posted successfully!</p>";
        } else {
            echo "<p>Error: " . $stmt->error . "</p>";
        }

        // Close the statement and connection
        $stmt->close();
        $db->close();
    } else {
        echo "<p>Please enter your problem.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
    <title>Post Problems | Jogablogwen Code Recovery</title>
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
                <li><a href="postProblemPage.php">Post a Problem</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
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

    <!-- Welcome -->
    <form method="POST" action="postProblemPage.php">
    <h1 class="problem-page">Post Your Problem Here</h1>
    <textarea name="problem" rows="10" cols="50"></textarea>
    <br>
    <input type="submit" name="submit" value="Submit">
    </form>
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
                <a href="postProblemPage.php">Got A Problem</a>
            <?php endif; ?>
        </div>
    </div>
    </footer>
</body>
</html>