<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

<div class = "problem-page">
    <h1> Jogablogwen Problem Page </h1>
</div>
<tr>
        <h1 class="problem-page">Post Your Problem Here</h1>
        <textarea rows="45" cols="250"></textarea>
    
        <td>&nbsp;</td>
        <td><input type="submit" name="submit" value="submit"></td>
    </tr>
        
    <!-- footer -->
    <footer class="footer">
        <div class="footer-content">
            <p>&copy; 2025 Jogablogwen Code Recovery. All rights reserved.</p>
            <div class="footer-links">
                <a href="index.php">Home</a>
                <a href="problemPage.php">Problem</a>
                <a href="signupPage.php">Signup</a>
                <a href="loginPage.php">Login</a>
            </div>
        </div>
    
    </footer>
</body>
</html>