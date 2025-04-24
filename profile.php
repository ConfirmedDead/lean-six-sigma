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
    

<h3>Welcome <?=$user->username?> </h3>


<a href="profile.php?action=logout" class="empty"><button> Logout </button></a> 
<a href="profile.php?action=update" class="empty"><button> Update User </button></a> 
<a href="profile.php?action=delete" class="empty"><button> Delete Account </button></a> 
<a href="index.php"><button>Home</button></a>
<a href="postProblemPage.php"><button>Post Problem</button></a>

</body>
</html>