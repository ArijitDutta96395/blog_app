<?php
include('../includes/config.php');
include('../includes/auth.php');

requireAuth();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $user_id = $_SESSION['user_id'];
    
    // Validate input
    if(empty($title) || empty($content)) {
        $_SESSION['error'] = "Title and content are required";
        header("Location: create.php");
        exit;
    }
    
    // Insert post into database
    $stmt = $pdo->prepare("INSERT INTO posts (title, content, user_id) VALUES (?, ?, ?)");
    
    if($stmt->execute([$title, $content, $user_id])) {
        $_SESSION['success'] = "Post created successfully";
        header("Location: ../index.php");
        exit;
    } else {
        $_SESSION['error'] = "Error creating post";
        header("Location: create.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post - Blog Application</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <header>
        <h1>Create New Post</h1>
        <nav>
            <a href="../index.php">Home</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <main>
        <h2>Write Your Post</h2>
        
        <?php if(isset($_SESSION['error'])): ?>
            <div class="alert alert-error"><?= htmlspecialchars($_SESSION['error']) ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
        
        <form method="POST" action="create.php">
            <div>
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required>
            </div>
            
            <div>
                <label for="content">Content:</label>
                <textarea id="content" name="content" rows="10" required></textarea>
            </div>
            
            <button type="submit">Create Post</button>
        </form>
        
        <p><a href="../index.php">← Back to Home</a></p>
    </main>
</body>
</html>
