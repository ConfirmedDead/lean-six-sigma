<?php
    session_start();
    require_once('User.php');
    $user = new User(); 

    if(!isset($_SESSION['user_id'])){
        header("Location: loginPage.php");
        exit(); // VERY important after header redirect
    }

    //actions
    if($_SERVER['REQUEST_METHOD'] == "GET"){

        if(!empty($_GET['action']) && $_GET['action'] == "logout"){
            // Clear ALL global session data.
            $_SESSION = array();
            // Delete session cookie
            setcookie('PHPSESSID', '', time()-3600, '/');
            // Destroy ALL data associated w/current session.
            session_destroy();
            // Redirect to login page.
            header("Location: Index.php");
        }else if(!empty($_GET['action']) && $_GET['action'] == "update"){
            
            
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

    <div class = "usernameWelcome">
        <h3>Welcome <?=$user->username?> </h3>

    </div>



<a href="profile.php?action=logout" class="empty"><button> Logout </button></a> 
<a href="profile.php?action=update" class="empty"><button> Update User </button></a> 
<a href="profile.php?action=delete" class="empty"><button> Delete Account </button></a> 
<a href="index.php"><button>Home</button></a>
<a href="postProblemPage.php"><button>Post Problem</button></a>
<!-- footer -->
<footer class="footer">
    <div class="footer-content">
        <p>&copy; 2025 Jogablogwen Code Recovery. All rights reserved.</p>
        <div class="footer-links">
            <a href="postProblemPage.php">Got A Problem</a>
            <a href="problemPage.php">Problem</a>
            <a href="signupPage.php">Signup</a>
            <a href="loginPage.php">Login</a>
        </div>
    </div>
    </footer>
</body>
</html>