<?php
include('../includes/config.php');
include('../includes/auth.php');

requireAuth();

// Check if post ID is provided
if(!isset($_GET['id'])) {
    $_SESSION['error'] = "Post ID is required";
    header("Location: ../index.php");
    exit;
}

// Get post data and verify ownership
$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ? AND user_id = ?");
$stmt->execute([$_GET['id'], $_SESSION['user_id']]);
$post = $stmt->fetch();

if(!$post) {
    $_SESSION['error'] = "Post not found or you don't have permission";
    header("Location: ../index.php");
    exit;
}

// Delete the post
$stmt = $pdo->prepare("DELETE FROM posts WHERE id = ? AND user_id = ?");

if($stmt->execute([$_GET['id'], $_SESSION['user_id']])) {
    $_SESSION['success'] = "Post deleted successfully";
} else {
    $_SESSION['error'] = "Error deleting post";
}

header("Location: ../index.php");
exit;
?>