<?php
session_start(); // Start the session to track login status

// Example: Check if the user is logged in
$isLoggedIn = isset($_SESSION['user_id']); // Assuming 'user_id' is set in the session when logged in
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/index.css">
    <title>Home | Jogablogwen Code Recovery</title>
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
            <li><a href="postProblemPage.php">Got A Problem</a></li>
                <li><a href="problemPage.php">Problem</a></li>
                <?php if (!$isLoggedIn): // Show these links only if the user is not logged in ?>
                    <li><a href="signupPage.php">Signup</a></li>
                    <li><a href="loginPage.php">Login</a></li>
                <?php else: // Show a logout link if the user is logged in ?>
                    <li><a href="logout.php">Logout</a></li>
                    <li><a href="profile.php">Profile</a></li>
                <?php endif; ?>
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
    <div class="welcome">
    Welcome to <span style="color:#1CD8D2;">Jogablogwen Code Recovery</span>
    </div>

    <!-- Logo -->
    <img src="images/logoideaNoBackground.jpeg" alt="Logo"  class = "imageLogo" >

    <!-- General description of website -->
    <div class = "desc">
        <h5> 
            Welcome to Jogablogwen Code Recovery – Your C#, JavaScript, and PHP Problem Solver 
        </h5>

        <h5>
            At Jogablogwen Code Recovery, we know the frustration of debugging, fixing broken code, and hunting down elusive errors. 
            That’s why we’ve built a focused, developer-friendly community dedicated to solving issues in C#, JavaScript, and PHP.
            Whether you're struggling with a C# runtime error, a tricky JavaScript bug, 
            or a PHP database issue, our platform is designed to help you get clear, 
            fast, and effective solutions from fellow developers who specialize in these languages.
        </h5>
        
        <h5> 
            Got a coding issue? Post your question and let the community help you fix your code!
        </h5>
    </div>

    <!-- Why us? -->
    <div class = "whyUs">

        <h1>
            Why Us?
        </h1>

        <h3>
            Targeted Expertise:
        </h3>

        <h5>
            No noise, just C#, JavaScript, and PHP discussions.
        </h5>

        <h3>
            Community-Powered:
        </h3>

        <h5>
            Learn, share, and grow with other developers.
        </h5>

        <h3>
        Quick Fixes & Deep Dives:
        </h3>

        <h5>
        From simple syntax errors to advanced debugging.
        </h5>

    </div>

    <div class = "buttonHolder">
        <h3> Dont Have an account?</h3>
        <a href="http://localhost/Lean-Six-Sigma/signupPage.php">
        <button>Signup</button>
        </a>
    </div>

    <!-- footer -->
    <footer class="footer">
    <div class="footer-content">
        <p>&copy; 2025 Jogablogwen Code Recovery. All rights reserved.</p>
        <div class="footer-links">
            <a href="postProblemPage.php">Got A Problem</a>
            <a href="problemPage.php">Problem</a>
            <?php if (!$isLoggedIn): // Show these links only if the user is not logged in ?>
                <a href="signupPage.php">Signup</a>
                <a href="loginPage.php">Login</a>
            <?php else: // Show a logout link if the user is logged in ?>
                <a href="logout.php">Logout</a>
                <a href="profile.php">Profile</a>
            <?php endif; ?>
        </div>
    </div>
    </footer>


</body>
</html>
