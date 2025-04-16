<?php
// Database connection
$conn = new mysqli("localhost", "root", "password", "jogablogwen-code-recovery");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/index.css">
    <title>Problems</title>
</head>
<body>
    <!-- Existing content -->

    <!-- Problems Section -->
    <section class="problems-section">
        <h2>Community Problems</h2>
        <?php if ($problemsResult->num_rows > 0): ?>
            <?php while ($problem = $problemsResult->fetch_assoc()): ?>
                <div class="problem">
                    
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
                    <form method="POST" class="comment-form">
                        <input type="hidden" name="problem_id" value="<?php echo $problem['id']; ?>">
                        <textarea name="comment" placeholder="Write a comment..." required></textarea>
                        <button type="submit">Post Comment</button>
                    </form>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No problems posted yet.</p>
        <?php endif; ?>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <p>&copy; 2025 Jogablogwen Code Recovery. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>