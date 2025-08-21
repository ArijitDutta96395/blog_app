<?php
include('../includes/config.php');
include('../includes/auth.php');

if(!isset($_GET['id'])) {
    $_SESSION['error'] = "Post ID is required";
    header("Location: ../index.php");
    exit;
}

$stmt = $pdo->prepare("SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id WHERE posts.id = ?");
$stmt->execute([$_GET['id']]);
$post = $stmt->fetch();

if(!$post) {
    $_SESSION['error'] = "Post not found";
    header("Location: ../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($post['title']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="../index.php">My Blog</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if(isLoggedIn()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="create.php"><i class="fas fa-plus-circle"></i> Create Post</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../users/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="../users/login.php"><i class="fas fa-sign-in-alt"></i> Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../users/register.php"><i class="fas fa-user-plus"></i> Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title"><?= htmlspecialchars($post['title']) ?></h1>
                <p class="card-text"><small class="text-muted">Posted by <?= htmlspecialchars($post['username']) ?> on <?= date('F j, Y, g:i a', strtotime($post['created_at'])) ?></small></p>
                <hr>
                <div class="card-text"><?= nl2br(htmlspecialchars($post['content'])) ?></div>
            </div>
            <div class="card-footer">
                <a href="../index.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to Home</a>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white text-center p-3 mt-4">
        <p>&copy; 2024 My Blog. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
