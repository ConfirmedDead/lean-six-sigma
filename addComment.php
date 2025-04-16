<?php
require_once 'DBConn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $problem_id = $_POST['problem_id'];
    $content = $_POST['content'];

    if (!empty($problem_id) && !empty($content)) {
        try {
            $stmt = $conn->prepare("INSERT INTO comments (problem_id, content, created_at) VALUES (?, ?, NOW())");
            $stmt->execute([$problem_id, $content]);
            header("Location: problemPage.php?id=" . $problem_id); // Redirect back to the problem page
            exit;
        } catch (PDOException $e) {
            die("Error adding comment: " . $e->getMessage());
        }
    } else {
        die("Invalid input.");
    }
}
?>