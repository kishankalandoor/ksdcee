<?php
session_start();

// Check if user is logged in
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: joinus.php");
    exit;
}

require_once "db.php";

// Get user's comments
$user_id = $_SESSION["id"];
$sql = "SELECT c.*, p.title as project_title, p.id as project_id 
        FROM project_comments c 
        JOIN projects p ON c.project_id = p.id 
        WHERE c.user_id = ? 
        ORDER BY c.created_at DESC";
$comments = [];

if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $comments = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Comments - KSDC</title>
    <meta name="description" content="View and manage your project comments.">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="assets/css/main.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    
    <style>
        .comment-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            margin-bottom: 20px;
        }
        
        .comment-card:hover {
            transform: translateY(-2px);
        }
        
        .comment-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px 15px 0 0;
            padding: 15px 20px;
        }
        
        .comment-content {
            padding: 20px;
        }
        
        .project-link {
            color: white;
            text-decoration: none;
            font-weight: 600;
        }
        
        .project-link:hover {
            color: #f8f9fa;
            text-decoration: underline;
        }
        
        .comment-date {
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }
        
        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            color: #dee2e6;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header id="header-wrap" class="header d-flex align-items-center sticky-top" style="background-color: white;">
        <a href="../ksdc2/indexdemo.php" class="logo d-flex align-items-center me-5" style="margin-left: 100px;">
            <img src="./assets/img/logo-small.png" alt="Kakunje Software Logo" style="height: 40px; width: auto; margin-right: 15px;">
        </a>
        <div class="container-fluid container-xl position-relative d-flex align-items-center">
            <nav id="navmenu" class="navmenu flex-grow-1">
                <ul class="d-flex justify-content-center">
                    <li><a href="welcome.php">Dashboard</a></li>
                    <li><a href="projects.php">Browse Projects</a></li>
                    <li><a href="my-projects.php">My Projects</a></li>
                    <li><a href="my-comments.php" class="active">My Comments</a></li>
                    <li><a href="my-ratings.php">My Ratings</a></li>
                </ul>
            </nav>
            
            <div class="d-flex align-items-center">
                <span class="navbar-text me-3" style="color: #333; white-space: nowrap; font-size: 14px;">Welcome, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</span>
                <a href="logout.php" class="btn btn-danger btn-sm px-3" style="background-color: #dc3545; border-color: #dc3545; border-radius: 20px;">Logout</a>
            </div>
        </div>
    </header>

    <main class="main">
        <div class="container mt-5">
            <!-- Page Header -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2>My Comments</h2>
                            <p class="text-muted">All the comments you've made on community projects</p>
                        </div>
                        <div class="text-muted">
                            <i class="bi bi-chat-square-text me-2"></i>
                            Total Comments: <strong><?php echo count($comments); ?></strong>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Comments List -->
            <?php if (empty($comments)): ?>
                <div class="empty-state">
                    <i class="bi bi-chat-square-dots"></i>
                    <h3>No Comments Yet</h3>
                    <p>You haven't commented on any projects yet. Start engaging with the community!</p>
                    <a href="projects.php" class="btn btn-primary btn-lg">
                        <i class="bi bi-search me-2"></i>Browse Projects
                    </a>
                </div>
            <?php else: ?>
                <div class="row">
                    <?php foreach ($comments as $comment): ?>
                        <div class="col-12" data-aos="fade-up">
                            <div class="card comment-card">
                                <div class="comment-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">
                                                <i class="bi bi-folder me-2"></i>
                                                <a href="project-details.php?id=<?php echo $comment['project_id']; ?>" class="project-link">
                                                    <?php echo htmlspecialchars($comment['project_title']); ?>
                                                </a>
                                            </h6>
                                            <div class="comment-date">
                                                <i class="bi bi-clock me-1"></i>
                                                Commented on <?php echo date('M d, Y \a\t g:i A', strtotime($comment['created_at'])); ?>
                                            </div>
                                        </div>
                                        <div>
                                            <a href="project-details.php?id=<?php echo $comment['project_id']; ?>#comment-<?php echo $comment['id']; ?>" 
                                               class="btn btn-light btn-sm">
                                                <i class="bi bi-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="comment-content">
                                    <div class="comment-text">
                                        <i class="bi bi-quote" style="color: #667eea; font-size: 1.2rem;"></i>
                                        <em><?php echo nl2br(htmlspecialchars($comment['comment'])); ?></em>
                                    </div>
                                    
                                    <div class="mt-3 d-flex justify-content-end">
                                        <a href="project-details.php?id=<?php echo $comment['project_id']; ?>" class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-eye me-1"></i>View Project
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <!-- Pagination could be added here for large numbers of comments -->
                <?php if (count($comments) > 10): ?>
                <nav class="mt-4" aria-label="Comments pagination">
                    <ul class="pagination justify-content-center">
                        <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                    </ul>
                </nav>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/js/main.js"></script>
    
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            once: true
        });
    </script>
</body>
</html>
