<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="/images/favicon-16x16.png">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/index.css">
    <title>Document</title>
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


    <!-- Post a Problem Intro -->
    <section class="post-intro">
        <h2>🛠 Post a Problem</h2>
        <p>
            Welcome to the heart of <strong>Jogablogwen Code Recovery</strong> — where problems meet solutions.
        </p>
        <p>
            Got a bug you can’t squash? A confusing error message? Or just code that won’t behave the way it should? You’re in the right place.
            Here, you can post your issue, share your code, and get real help from real developers who speak your language — 
            whether it’s <span class="highlight">C#</span>, <span class="highlight">JavaScript</span>, or <span class="highlight">PHP</span>.
        </p>
        <p>
            💡 <em>Be as detailed as you can — the more context you give, the faster we can help you fix it.</em>  
            Let’s get your code back on track.
        </p>
        <div class = "buttonHolder">
            <h3> Want To Post Your Own Problem?</h3>
            <a href="http://localhost/Lean-Six-Sigma/postProblemPage.php">
                <button>Click Here!</button>
            </a>
    </div>

    </section>



   
    <!-- Box that contain a problem  and a button to reply-->
    <div>

        
    </div>





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