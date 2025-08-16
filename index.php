<?php
include('includes/config.php');
include('includes/auth.php'); // Optional - if you want to protect the home page
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Application</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <h1>My Blog</h1>
        <nav>
            <?php if(isLoggedIn()): ?>
                <a href="posts/create.php">Create Post</a>
                <a href="users/logout.php">Logout</a>
            <?php else: ?>
                <a href="users/login.php">Login</a>
                <a href="users/register.php">Register</a>
            <?php endif; ?>
        </nav>
    </header>

    <main>
        <h2>Recent Posts</h2>
        
        <?php
        try {
            // Get all posts
            $stmt = $pdo->query("SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id ORDER BY created_at DESC");
            $posts = $stmt->fetchAll();
            
            if(count($posts) > 0):
                foreach($posts as $post): ?>
                    <div class="post">
                        <h3><?= htmlspecialchars($post['title']) ?></h3>
                        <p><?= nl2br(htmlspecialchars(substr($post['content'], 0, 200))) ?>...</p>
                        <small>Posted by <?= htmlspecialchars($post['username']) ?> on <?= $post['created_at'] ?></small>
                        
                        <?php if(isLoggedIn() && isset($_SESSION['user_id']) && $_SESSION['user_id'] == $post['user_id']): ?>
                            <div class="post-actions">
                                <a href="posts/edit.php?id=<?= $post['id'] ?>">Edit</a>
                                <a href="posts/delete.php?id=<?= $post['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach;
            else: ?>
                <p>No posts yet. Be the first to create one!</p>
            <?php endif;
        } catch(PDOException $e) {
            echo "<p>Error loading posts: " . htmlspecialchars($e->getMessage()) . "</p>";
            echo "<p>Please ensure the database is set up correctly.</p>";
        }
        ?>
    </main>

    <footer>
        <p>&copy; 2024 My Blog. All rights reserved.</p>
    </footer>
</body>
</html>