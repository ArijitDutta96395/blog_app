<?php
include('includes/config.php');
include('includes/auth.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Recent Posts</h2>
                    <form class="d-flex" action="index.php" method="GET">
                        <input class="form-control me-2" type="search" name="search" placeholder="Search by title or content" aria-label="Search" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                        <button class="btn btn-outline-primary" type="submit"><i class="fas fa-search"></i></button>
                    </form>
                </div>
                <?php
                try {
                    // Pagination settings
                    $posts_per_page = 5;
                    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
                    $offset = ($page - 1) * $posts_per_page;

                    // Search term
                    $search = isset($_GET['search']) ? trim($_GET['search']) : '';

                    // Base query
                    $sql = "SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id";
                    $count_sql = "SELECT COUNT(*) FROM posts JOIN users ON posts.user_id = users.id";

                    // Apply search filter
                    if (!empty($search)) {
                        $sql .= " WHERE posts.title LIKE :search OR posts.content LIKE :search";
                        $count_sql .= " WHERE posts.title LIKE :search OR posts.content LIKE :search";
                    }

                    // Order by
                    $sql .= " ORDER BY created_at DESC";

                    // Get total number of posts for pagination
                    $count_stmt = $pdo->prepare($count_sql);
                    if (!empty($search)) {
                        $count_stmt->bindValue(':search', '%' . $search . '%');
                    }
                    $count_stmt->execute();
                    $total_posts = $count_stmt->fetchColumn();
                    $total_pages = ceil($total_posts / $posts_per_page);

                    // Add limit for pagination
                    $sql .= " LIMIT :limit OFFSET :offset";

                    $stmt = $pdo->prepare($sql);

                    if (!empty($search)) {
                        $stmt->bindValue(':search', '%' . $search . '%');
                    }

                    $stmt->bindValue(':limit', $posts_per_page, PDO::PARAM_INT);
                    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
                    $stmt->execute();

                    $posts = $stmt->fetchAll();

                    if (count($posts) > 0):
                        foreach ($posts as $post): ?>
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h3 class="card-title"><?= htmlspecialchars($post['title']) ?></h3>
                                    <p class="card-text"><?= nl2br(htmlspecialchars(substr($post['content'], 0, 200))) ?>...</p>
                                    <p class="card-text"><small class="text-muted">Posted by <?= htmlspecialchars($post['username']) ?> on <?= date('F j, Y, g:i a', strtotime($post['created_at'])) ?></small></p>
                                    <?php if (isLoggedIn() && isset($_SESSION['user_id']) && $_SESSION['user_id'] == $post['user_id']): ?>
                                        <a href="posts/edit.php?id=<?= $post['id'] ?>" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                        <a href="posts/delete.php?id=<?= $post['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i> Delete</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach;
                    else:
                        echo "<p>No posts found.</p>";
                    endif;

                } catch (PDOException $e) {
                    echo "<div class=\"alert alert-danger\">Error loading posts: " . htmlspecialchars($e->getMessage()) . "</div>";
                }
                ?>

                <?php if ($total_pages > 1): ?>
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <?php if ($page > 1):
                            $previous_page = $page - 1;
                            $search_param = urlencode($search);
                            echo "<li class=\"page-item\"><a class=\"page-link\" href=\" ?page=$previous_page&search=$search_param\">Previous</a></li>";
                        endif; ?>

                        <?php for ($i = 1; $i <= $total_pages; $i++):
                            $active_class = ($i == $page) ? ' active' : '';
                            $search_param = urlencode($search);
                            echo "<li class=\"page-item$active_class\"><a class=\"page-link\" href=\" ?page=$i&search=$search_param\">$i</a></li>";
                        endfor; ?>

                        <?php if ($page < $total_pages):
                            $next_page = $page + 1;
                            $search_param = urlencode($search);
                            echo "<li class=\"page-item\"><a class=\"page-link\" href=\" ?page=$next_page&search=$search_param\">Next</a></li>";
                        endif; ?>
                    </ul>
                </nav>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white text-center p-3 mt-4">
        <p>&copy; 2024 My Blog. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
