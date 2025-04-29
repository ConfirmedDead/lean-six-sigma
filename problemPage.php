<?php
session_start(); // Start the session
// Include your database connection class
require_once 'DBConn.php';
// Include your User class
require_once 'User.php';

// Create a new database connection
$db = new DBConn();
$db->open();
$conn = $db->conn;


// Fetch problems from the database
$problemsQuery = "SELECT * FROM problems ORDER BY created_at DESC";
$problemsResult = $conn->query($problemsQuery);

// Handle comment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'], $_POST['problem_id'])) {
    $problemId = intval($_POST['problem_id']);
    $comment = $conn->real_escape_string($_POST['comment']);
    $conn->query("INSERT INTO comments (problem_id, comment) VALUES ($problemId, '$comment')");
    header("Location: problemPage.php");
    exit;
}

// Handle problem deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_problem_id'])) {
    $problemId = intval($_POST['delete_problem_id']);
    $userId = $_SESSION['user_id']; // Assuming 'user_id' is stored in the session
    // Ensure the logged-in user is the owner of the post
    $deleteQuery = "DELETE FROM problems WHERE id = $problemId AND user_id = $userId";
    $conn->query($deleteQuery);
    header("Location: problemPage.php");
    exit;
}

// Pagination settings
$limit = 5; // Problems per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Get total number of problems
$totalResult = $conn->query("SELECT COUNT(*) AS total FROM problems");
$totalRow = $totalResult->fetch_assoc();
$totalProblems = $totalRow['total'];
$totalPages = ceil($totalProblems / $limit);

// Fetch paginated problems
$problemsQuery = "SELECT * FROM problems ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
$problemsResult = $conn->query($problemsQuery);

// Example: Check if the user is logged in
$isLoggedIn = isset($_SESSION['user_id']); // Assuming 'user_id' is set in the session when logged in
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
    <title>Problems | Jogablogwen Code Recovery</title>
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
                <?php if (!$isLoggedIn): // Show these links only if the user is not logged in ?>
                    <li><a href="signupPage.php">Signup</a></li>
                    <li><a href="loginPage.php">Login</a></li>
                <?php else: // Show a logout link if the user is logged in ?>
                    <li><a href="postProblemPage.php">Post a Problem</a></li>
                    <li><a href="profile.php">Profile</a></li>
                    <li><a href="logout.php">Logout</a></li>
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
        <!-- Post a Problem Intro -->
    <section class="post-intro">
        <h2>🛠 Post a Problem 🛠</h2>
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


          <!-- Problems Section -->
    <section class="problems-section">
        <h2>Community Problems</h2>
        <?php if ($problemsResult->num_rows > 0): ?>
            <?php while ($problem = $problemsResult->fetch_assoc()): ?>
                <div class="problem">
                        <h3><?php echo htmlspecialchars($problem['title']); ?></h3>
                        <p><?php echo nl2br(htmlspecialchars($problem['description'])); ?></p>

                    <h4>Comments:</h4>
                        <ul>
                            <?php
                            $commentsQuery = "SELECT * FROM comments WHERE problem_id = " . $problem['id'];
                            $commentsResult = $conn->query($commentsQuery);
                            if ($commentsResult->num_rows > 0):
                                while ($comment = $commentsResult->fetch_assoc()):
                            ?>
                                <li><?php echo htmlspecialchars($comment['comment']); ?></li>
                            <?php endwhile; else: ?>
                                <li>No comments yet.</li>
                            <?php endif; ?>
                        </ul>
                        <?php if (!$isLoggedIn): ?>
                            <h5>Must be logged in to comment</h5>
                        <?php else:?>
                            <form method="POST" class="comment-form">
                            <input type="hidden" name="problem_id" value="<?php echo $problem['id']; ?>">
                            <textarea name="comment" placeholder="Write a comment..." required></textarea>
                            <button type="submit">Post Comment</button>
                        </form>
                        <?php endif; ?>
                        

                    <!-- Delete Problem Button (Visible only to the owner) -->
                    <?php if ($isLoggedIn && $problem['user_id'] == $_SESSION['user_id']): ?>
                        <form method="POST" action="">
                            <input type="hidden" name="delete_problem_id" value="<?php echo $problem['id']; ?>">
                            <button type="submit" class="delete-button">Delete Post</button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No problems have been posted yet.</p>
        <?php endif; ?>

        </section>
        <?php if ($totalPages > 1): ?>
            <div class="pagination">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?page=<?php echo $i; ?>" 
                    class="<?php echo $i == $page ? 'active-page' : ''; ?>">
                    <?php echo $i; ?>
                    </a>
                <?php endfor; ?>
            </div>
        <?php endif; ?>

               
        <div class = "buttonHolder">
            <h3> Want To Post Your Own Problem?</h3>
            <a href="http://localhost/Lean-Six-Sigma/postProblemPage.php">
                <button>Click Here!</button>
            </a>
        </div>

    </section>
    



   

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
                <a href="postProblemPage.php">Post a Problem</a>
            <?php endif; ?>
        </div>
    </div>
    </footer>
</body>
</html>