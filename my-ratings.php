<?php
session_start();

// Check if user is logged in
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: joinus.php");
    exit;
}

require_once "db.php";

// Get user's ratings
$user_id = $_SESSION["id"];
$sql = "SELECT r.*, p.title as project_title, p.id as project_id, p.username as project_author 
        FROM project_ratings r 
        JOIN projects p ON r.project_id = p.id 
        WHERE r.user_id = ? 
        ORDER BY r.created_at DESC";
$ratings = [];

if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $ratings = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
}

// Get rating statistics
$avg_rating_given = 0;
if (!empty($ratings)) {
    $total_rating = array_sum(array_column($ratings, 'rating'));
    $avg_rating_given = $total_rating / count($ratings);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Ratings - KSDC</title>
    <meta name="description" content="View and manage your project ratings.">

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
        .rating-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            margin-bottom: 20px;
        }
        
        .rating-card:hover {
            transform: translateY(-2px);
        }
        
        .rating-header {
            background: linear-gradient(135deg, #ffc107 0%, #ff8c00 100%);
            color: white;
            border-radius: 15px 15px 0 0;
            padding: 15px 20px;
        }
        
        .rating-content {
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
        
        .rating-stars {
            color: #ffc107;
            font-size: 1.2rem;
        }
        
        .rating-stars-large {
            color: #ffc107;
            font-size: 2rem;
        }
        
        .rating-date {
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            margin-bottom: 30px;
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
        
        .rating-distribution {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
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
                    <li><a href="my-comments.php">My Comments</a></li>
                    <li><a href="my-ratings.php" class="active">My Ratings</a></li>
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
                            <h2>My Ratings</h2>
                            <p class="text-muted">All the ratings you've given to community projects</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <?php if (!empty($ratings)): ?>
            <div class="row">
                <div class="col-md-4">
                    <div class="stats-card">
                        <h3><?php echo count($ratings); ?></h3>
                        <p class="mb-0">Projects Rated</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card">
                        <h3><?php echo number_format($avg_rating_given, 1); ?></h3>
                        <p class="mb-0">Average Rating Given</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="rating-stars-large">
                            <?php 
                            for ($i = 1; $i <= 5; $i++): 
                                if ($i <= $avg_rating_given): 
                            ?>
                                <i class="bi bi-star-fill"></i>
                            <?php elseif ($i - 0.5 <= $avg_rating_given): ?>
                                <i class="bi bi-star-half"></i>
                            <?php else: ?>
                                <i class="bi bi-star"></i>
                            <?php 
                                endif;
                            endfor; 
                            ?>
                        </div>
                        <p class="mb-0">Your Rating Trend</p>
                    </div>
                </div>
            </div>

            <!-- Rating Distribution -->
            <div class="rating-distribution">
                <h5 class="mb-3">Your Rating Distribution</h5>
                <?php
                $rating_counts = array_count_values(array_column($ratings, 'rating'));
                for ($star = 5; $star >= 1; $star--):
                    $count = isset($rating_counts[$star]) ? $rating_counts[$star] : 0;
                    $percentage = count($ratings) > 0 ? ($count / count($ratings)) * 100 : 0;
                ?>
                <div class="d-flex align-items-center mb-2">
                    <div class="me-2" style="width: 60px;">
                        <?php for ($i = 0; $i < $star; $i++): ?>
                            <i class="bi bi-star-fill" style="color: #ffc107; font-size: 0.8rem;"></i>
                        <?php endfor; ?>
                    </div>
                    <div class="progress flex-fill me-2" style="height: 10px;">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $percentage; ?>%"></div>
                    </div>
                    <small class="text-muted" style="width: 40px;"><?php echo $count; ?></small>
                </div>
                <?php endfor; ?>
            </div>
            <?php endif; ?>

            <!-- Ratings List -->
            <?php if (empty($ratings)): ?>
                <div class="empty-state">
                    <i class="bi bi-stars"></i>
                    <h3>No Ratings Yet</h3>
                    <p>You haven't rated any projects yet. Start discovering and rating amazing community projects!</p>
                    <a href="projects.php" class="btn btn-primary btn-lg">
                        <i class="bi bi-search me-2"></i>Browse Projects
                    </a>
                </div>
            <?php else: ?>
                <div class="row">
                    <?php foreach ($ratings as $rating): ?>
                        <div class="col-lg-6 col-12" data-aos="fade-up">
                            <div class="card rating-card">
                                <div class="rating-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">
                                                <i class="bi bi-folder me-2"></i>
                                                <a href="project-details.php?id=<?php echo $rating['project_id']; ?>" class="project-link">
                                                    <?php echo htmlspecialchars($rating['project_title']); ?>
                                                </a>
                                            </h6>
                                            <small class="rating-date">
                                                by <?php echo htmlspecialchars($rating['project_author']); ?> • 
                                                Rated on <?php echo date('M d, Y', strtotime($rating['created_at'])); ?>
                                            </small>
                                        </div>
                                        <div>
                                            <a href="project-details.php?id=<?php echo $rating['project_id']; ?>" 
                                               class="btn btn-light btn-sm">
                                                <i class="bi bi-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="rating-content">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="rating-stars">
                                            <?php 
                                            $user_rating = intval($rating['rating']);
                                            for ($i = 1; $i <= 5; $i++): 
                                                if ($i <= $user_rating): 
                                            ?>
                                                <i class="bi bi-star-fill"></i>
                                            <?php else: ?>
                                                <i class="bi bi-star"></i>
                                            <?php 
                                                endif;
                                            endfor; 
                                            ?>
                                            <span class="ms-2 fw-bold"><?php echo $user_rating; ?>/5</span>
                                        </div>
                                        
                                        <div>
                                            <a href="project-details.php?id=<?php echo $rating['project_id']; ?>" class="btn btn-outline-primary btn-sm">
                                                <i class="bi bi-eye me-1"></i>View Project
                                            </a>
                                        </div>
                                    </div>
                                    
                                    <?php if (!empty($rating['review'])): ?>
                                    <div class="mt-3">
                                        <h6>Your Review:</h6>
                                        <p class="text-muted mb-0">
                                            <i class="bi bi-quote" style="color: #ffc107;"></i>
                                            <em><?php echo nl2br(htmlspecialchars($rating['review'])); ?></em>
                                        </p>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
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
