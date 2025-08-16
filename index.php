<?php
include('includes/config.php');
<<<<<<< HEAD
include('includes/auth.php');
=======
include('includes/auth.php'); // Optional - if you want to protect the home page
>>>>>>> 599860d1e0550e0dadbb045dc55ec55b943bdacf
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<<<<<<< HEAD
    <title>My Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">My Blog</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if(isLoggedIn()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="posts/create.php"><i class="fas fa-plus-circle"></i> Create Post</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="users/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="users/login.php"><i class="fas fa-sign-in-alt"></i> Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="users/register.php"><i class="fas fa-user-plus"></i> Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8">
                <h2>Recent Posts</h2>
                <?php
                try {
                    $stmt = $pdo->query("SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id ORDER BY created_at DESC");
                    $posts = $stmt->fetchAll();

                    if(count($posts) > 0):
                        foreach($posts as $post): ?>
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h3 class="card-title"><?= htmlspecialchars($post['title']) ?></h3>
                                    <p class="card-text"><?= nl2br(htmlspecialchars(substr($post['content'], 0, 200))) ?>...</p>
                                    <p class="card-text"><small class="text-muted">Posted by <?= htmlspecialchars($post['username']) ?> on <?= date('F j, Y, g:i a', strtotime($post['created_at'])) ?></small></p>
                                    <?php if(isLoggedIn() && isset($_SESSION['user_id']) && $_SESSION['user_id'] == $post['user_id']): ?>
                                        <a href="posts/edit.php?id=<?= $post['id'] ?>" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                        <a href="posts/delete.php?id=<?= $post['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i> Delete</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach;
                    else:
                        echo "<p>No posts yet. Be the first to create one!</p>";
                    endif;
                } catch(PDOException $e) {
                    echo "<div class=\"alert alert-danger\">Error loading posts: " . htmlspecialchars($e->getMessage()) . "</div>";
                }
                ?>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white text-center p-3 mt-4">
        <p>&copy; 2024 My Blog. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
=======
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
>>>>>>> 599860d1e0550e0dadbb045dc55ec55b943bdacf
