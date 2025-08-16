<?php
include('../includes/config.php');
include('../includes/auth.php');

requireAuth();

// Get post data
if(!isset($_GET['id'])) {
    $_SESSION['error'] = "Post ID is required";
    header("Location: ../index.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ? AND user_id = ?");
$stmt->execute([$_GET['id'], $_SESSION['user_id']]);
$post = $stmt->fetch();

if(!$post) {
    $_SESSION['error'] = "Post not found or you don't have permission";
    header("Location: ../index.php");
    exit;
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    
    if(empty($title) || empty($content)) {
        $_SESSION['error'] = "Title and content are required";
        header("Location: edit.php?id=".$_GET['id']);
        exit;
    }
    
    $stmt = $pdo->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ? AND user_id = ?");
    $stmt->execute([$title, $content, $_GET['id'], $_SESSION['user_id']]);
    
    $_SESSION['success'] = "Post updated successfully";
    header("Location: ../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post - Blog Application</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <header>
        <h1>Edit Post</h1>
        <nav>
            <a href="../index.php">Home</a>
            <a href="../users/logout.php">Logout</a>
        </nav>
    </header>

    <main>
        <h2>Edit Your Post</h2>
        
        <?php if(isset($_SESSION['error'])): ?>
            <div class="alert alert-error"><?= htmlspecialchars($_SESSION['error']) ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
        
        <form method="POST" action="edit.php?id=<?= htmlspecialchars($_GET['id']) ?>">
            <div>
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" value="<?= htmlspecialchars($post['title']) ?>" required>
            </div>
            
            <div>
                <label for="content">Content:</label>
                <textarea id="content" name="content" rows="10" required><?= htmlspecialchars($post['content']) ?></textarea>
            </div>
            
            <button type="submit">Update Post</button>
        </form>
        
        <p><a href="../index.php">← Back to Home</a></p>
    </main>
</body>
</html>