<?php
session_start();

// Check if user is logged in
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: joinus.php");
    exit;
}

require_once "db.php";

// Get project ID from URL
$project_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($project_id <= 0) {
    header("location: projects.php");
    exit;
}

// Handle comment submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_comment'])) {
    $comment = trim($_POST['comment']);
    $user_id = $_SESSION["id"];
    $username = $_SESSION["username"];
    
    if (!empty($comment)) {
        $sql = "INSERT INTO project_comments (project_id, user_id, username, comment) VALUES (?, ?, ?, ?)";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "iiss", $project_id, $user_id, $username, $comment);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
    }
}

// Handle rating submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_rating'])) {
    $rating = intval($_POST['rating']);
    $review = trim($_POST['review']);
    $user_id = $_SESSION["id"];
    $username = $_SESSION["username"];
    
    if ($rating >= 1 && $rating <= 5) {
        // Check if user already rated this project
        $check_sql = "SELECT id FROM project_ratings WHERE project_id = ? AND user_id = ?";
        if ($stmt = mysqli_prepare($conn, $check_sql)) {
            mysqli_stmt_bind_param($stmt, "ii", $project_id, $user_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            if (mysqli_num_rows($result) > 0) {
                // Update existing rating
                $update_sql = "UPDATE project_ratings SET rating = ?, review = ?, updated_at = NOW() WHERE project_id = ? AND user_id = ?";
                if ($update_stmt = mysqli_prepare($conn, $update_sql)) {
                    mysqli_stmt_bind_param($update_stmt, "isii", $rating, $review, $project_id, $user_id);
                    mysqli_stmt_execute($update_stmt);
                    mysqli_stmt_close($update_stmt);
                }
            } else {
                // Insert new rating
                $insert_sql = "INSERT INTO project_ratings (project_id, user_id, username, rating, review) VALUES (?, ?, ?, ?, ?)";
                if ($insert_stmt = mysqli_prepare($conn, $insert_sql)) {
                    mysqli_stmt_bind_param($insert_stmt, "iisis", $project_id, $user_id, $username, $rating, $review);
                    mysqli_stmt_execute($insert_stmt);
                    mysqli_stmt_close($insert_stmt);
                }
            }
            mysqli_stmt_close($stmt);
        }
    }
}

// Track project view
$user_id = $_SESSION["id"];
$ip_address = $_SERVER['REMOTE_ADDR'];
$user_agent = $_SERVER['HTTP_USER_AGENT'];

// Check if this user/IP already viewed this project today
$view_check_sql = "SELECT id FROM project_views WHERE project_id = ? AND (user_id = ? OR ip_address = ?) AND DATE(viewed_at) = CURDATE()";
if ($stmt = mysqli_prepare($conn, $view_check_sql)) {
    mysqli_stmt_bind_param($stmt, "iis", $project_id, $user_id, $ip_address);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if (mysqli_num_rows($result) == 0) {
        // Add new view
        $view_sql = "INSERT INTO project_views (project_id, user_id, ip_address, user_agent) VALUES (?, ?, ?, ?)";
        if ($view_stmt = mysqli_prepare($conn, $view_sql)) {
            mysqli_stmt_bind_param($view_stmt, "iiss", $project_id, $user_id, $ip_address, $user_agent);
            mysqli_stmt_execute($view_stmt);
            mysqli_stmt_close($view_stmt);
            
            // Update project views count
            $update_views_sql = "UPDATE projects SET views = views + 1 WHERE id = ?";
            if ($update_stmt = mysqli_prepare($conn, $update_views_sql)) {
                mysqli_stmt_bind_param($update_stmt, "i", $project_id);
                mysqli_stmt_execute($update_stmt);
                mysqli_stmt_close($update_stmt);
            }
        }
    }
    mysqli_stmt_close($stmt);
}

// Get project details
$sql = "SELECT * FROM projects WHERE id = ? AND status = 'active'";
$project = null;

if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $project_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $project = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
}

if (!$project) {
    header("location: projects.php");
    exit;
}

// Get project comments
$comments_sql = "SELECT * FROM project_comments WHERE project_id = ? AND status = 'active' ORDER BY created_at DESC";
$comments = [];

if ($stmt = mysqli_prepare($conn, $comments_sql)) {
    mysqli_stmt_bind_param($stmt, "i", $project_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $comments = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
}

// Get project ratings
$ratings_sql = "SELECT * FROM project_ratings WHERE project_id = ? ORDER BY created_at DESC";
$ratings = [];

if ($stmt = mysqli_prepare($conn, $ratings_sql)) {
    mysqli_stmt_bind_param($stmt, "i", $project_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $ratings = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
}

// Check if current user has rated this project
$user_rating = null;
foreach ($ratings as $rating) {
    if ($rating['user_id'] == $_SESSION["id"]) {
        $user_rating = $rating;
        break;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($project['title']); ?> - KSDC</title>
    <meta name="description" content="<?php echo htmlspecialchars(substr($project['description'], 0, 160)); ?>">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="assets/css/main.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    
    <style>
        .project-hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 60px 0;
        }
        
        .project-image {
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            max-height: 400px;
            object-fit: cover;
        }
        
        .project-stats {
            background: rgba(255,255,255,0.1);
            border-radius: 10px;
            padding: 20px;
            margin-top: 30px;
        }
        
        .stat-item {
            text-align: center;
            padding: 10px;
        }
        
        .rating-stars {
            color: #ffc107;
            font-size: 1.2rem;
        }
        
        .badge-tech {
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.8rem;
            margin: 2px;
        }
        
        .comment-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .rating-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }
        
        .rating-input {
            display: none;
        }
        
        .rating-label {
            font-size: 2rem;
            color: #ddd;
            cursor: pointer;
            transition: color 0.3s ease;
        }
        
        .rating-label:hover,
        .rating-label.active {
            color: #ffc107;
        }
        
        .section-divider {
            height: 2px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            margin: 40px 0;
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
                </ul>
            </nav>
            
            <div class="d-flex align-items-center">
                <span class="navbar-text me-3" style="color: #333; white-space: nowrap; font-size: 14px;">Welcome, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</span>
                <a href="logout.php" class="btn btn-danger btn-sm px-3" style="background-color: #dc3545; border-color: #dc3545; border-radius: 20px;">Logout</a>
            </div>
        </div>
    </header>

    <!-- Project Hero Section -->
    <section class="project-hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb" style="background: none; padding: 0;">
                            <li class="breadcrumb-item"><a href="projects.php" style="color: rgba(255,255,255,0.8);">Projects</a></li>
                            <li class="breadcrumb-item active" style="color: white;"><?php echo htmlspecialchars($project['title']); ?></li>
                        </ol>
                    </nav>
                    
                    <h1 class="mb-3"><?php echo htmlspecialchars($project['title']); ?></h1>
                    <p class="lead"><?php echo htmlspecialchars($project['description']); ?></p>
                    
                    <div class="mb-3">
                        <span class="badge bg-light text-dark me-2"><?php echo htmlspecialchars($project['category']); ?></span>
                        <span class="text-light">by <strong><?php echo htmlspecialchars($project['username']); ?></strong></span>
                    </div>
                    
                    <?php if (!empty($project['technologies'])): ?>
                    <div class="mb-4">
                        <?php 
                        $techs = explode(',', $project['technologies']);
                        foreach ($techs as $tech): 
                        ?>
                            <span class="badge-tech"><?php echo htmlspecialchars(trim($tech)); ?></span>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    
                    <div class="d-flex gap-3">
                        <?php if (!empty($project['github_url'])): ?>
                        <a href="<?php echo htmlspecialchars($project['github_url']); ?>" target="_blank" class="btn btn-light">
                            <i class="bi bi-github me-2"></i>GitHub
                        </a>
                        <?php endif; ?>
                        
                        <?php if (!empty($project['demo_url'])): ?>
                        <a href="<?php echo htmlspecialchars($project['demo_url']); ?>" target="_blank" class="btn btn-success">
                            <i class="bi bi-play-circle me-2"></i>Live Demo
                        </a>
                        <?php endif; ?>
                    </div>
                    
                    <div class="project-stats">
                        <div class="row">
                            <div class="col-3 stat-item">
                                <div class="h4 mb-1"><?php echo number_format($project['views']); ?></div>
                                <small>Views</small>
                            </div>
                            <div class="col-3 stat-item">
                                <div class="rating-stars h4 mb-1">
                                    <?php 
                                    $rating = floatval($project['rating']);
                                    for ($i = 1; $i <= 5; $i++): 
                                        if ($i <= $rating): 
                                    ?>
                                        <i class="bi bi-star-fill"></i>
                                    <?php elseif ($i - 0.5 <= $rating): ?>
                                        <i class="bi bi-star-half"></i>
                                    <?php else: ?>
                                        <i class="bi bi-star"></i>
                                    <?php 
                                        endif;
                                    endfor; 
                                    ?>
                                </div>
                                <small><?php echo number_format($rating, 1); ?> Rating</small>
                            </div>
                            <div class="col-3 stat-item">
                                <div class="h4 mb-1"><?php echo count($comments); ?></div>
                                <small>Comments</small>
                            </div>
                            <div class="col-3 stat-item">
                                <div class="h4 mb-1"><?php echo count($ratings); ?></div>
                                <small>Ratings</small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <?php if (!empty($project['screenshot'])): ?>
                        <img src="uploads/projects/<?php echo htmlspecialchars($project['screenshot']); ?>" 
                             alt="<?php echo htmlspecialchars($project['title']); ?>" 
                             class="img-fluid project-image" 
                             data-glightbox="title: <?php echo htmlspecialchars($project['title']); ?>">
                    <?php else: ?>
                        <div class="project-image d-flex align-items-center justify-content-center" style="height: 300px; background: rgba(255,255,255,0.1);">
                            <i class="bi bi-image" style="font-size: 4rem;"></i>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <main class="main">
        <div class="container mt-5">
            <!-- Rating Section -->
            <section class="mb-5">
                <h3 class="mb-4">
                    <i class="bi bi-star me-2" style="color: #ffc107;"></i>Rate This Project
                </h3>
                
                <?php if ($user_rating): ?>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        You have already rated this project with <?php echo $user_rating['rating']; ?> stars. You can update your rating below.
                    </div>
                <?php endif; ?>
                
                <div class="card rating-card">
                    <div class="card-body">
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label class="form-label">Your Rating:</label>
                                <div class="rating-stars-input">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <input type="radio" id="star<?php echo $i; ?>" name="rating" value="<?php echo $i; ?>" class="rating-input" <?php echo ($user_rating && $user_rating['rating'] == $i) ? 'checked' : ''; ?>>
                                        <label for="star<?php echo $i; ?>" class="rating-label">★</label>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="review" class="form-label">Review (Optional):</label>
                                <textarea class="form-control" id="review" name="review" rows="3" placeholder="Share your thoughts about this project..."><?php echo $user_rating ? htmlspecialchars($user_rating['review']) : ''; ?></textarea>
                            </div>
                            
                            <button type="submit" name="submit_rating" class="btn btn-warning">
                                <i class="bi bi-star me-2"></i><?php echo $user_rating ? 'Update Rating' : 'Submit Rating'; ?>
                            </button>
                        </form>
                    </div>
                </div>
            </section>

            <hr class="section-divider">

            <!-- Comments Section -->
            <section class="mb-5">
                <h3 class="mb-4">
                    <i class="bi bi-chat-dots me-2" style="color: #667eea;"></i>Comments (<?php echo count($comments); ?>)
                </h3>
                
                <!-- Add Comment Form -->
                <div class="card comment-card">
                    <div class="card-body">
                        <h5 class="card-title">Add a Comment</h5>
                        <form method="POST" action="">
                            <div class="mb-3">
                                <textarea class="form-control" name="comment" rows="3" placeholder="Share your feedback, ask questions, or start a discussion..." required></textarea>
                            </div>
                            <button type="submit" name="submit_comment" class="btn btn-primary">
                                <i class="bi bi-send me-2"></i>Post Comment
                            </button>
                        </form>
                    </div>
                </div>
                
                <!-- Comments List -->
                <?php if (empty($comments)): ?>
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-chat-square-dots" style="font-size: 3rem;"></i>
                        <p class="mt-3">No comments yet. Be the first to share your thoughts!</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($comments as $comment): ?>
                        <div class="card comment-card" id="comment-<?php echo $comment['id']; ?>">
                            <div class="card-body">
                                <div class="d-flex align-items-start">
                                    <div class="user-avatar me-3">
                                        <?php echo strtoupper(substr($comment['username'], 0, 1)); ?>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="mb-0"><?php echo htmlspecialchars($comment['username']); ?></h6>
                                            <small class="text-muted">
                                                <i class="bi bi-clock me-1"></i>
                                                <?php echo date('M d, Y \a\t g:i A', strtotime($comment['created_at'])); ?>
                                            </small>
                                        </div>
                                        <p class="mb-0"><?php echo nl2br(htmlspecialchars($comment['comment'])); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </section>

            <hr class="section-divider">

            <!-- All Ratings Section -->
            <section class="mb-5">
                <h3 class="mb-4">
                    <i class="bi bi-star-half me-2" style="color: #ffc107;"></i>All Ratings (<?php echo count($ratings); ?>)
                </h3>
                
                <?php if (empty($ratings)): ?>
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-stars" style="font-size: 3rem;"></i>
                        <p class="mt-3">No ratings yet. Be the first to rate this project!</p>
                    </div>
                <?php else: ?>
                    <div class="row">
                        <?php foreach ($ratings as $rating): ?>
                            <div class="col-md-6">
                                <div class="card rating-card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-start">
                                            <div class="user-avatar me-3">
                                                <?php echo strtoupper(substr($rating['username'], 0, 1)); ?>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <h6 class="mb-0"><?php echo htmlspecialchars($rating['username']); ?></h6>
                                                    <div class="rating-stars">
                                                        <?php 
                                                        $user_rating_val = intval($rating['rating']);
                                                        for ($i = 1; $i <= 5; $i++): 
                                                            if ($i <= $user_rating_val): 
                                                        ?>
                                                            <i class="bi bi-star-fill"></i>
                                                        <?php else: ?>
                                                            <i class="bi bi-star"></i>
                                                        <?php 
                                                            endif;
                                                        endfor; 
                                                        ?>
                                                    </div>
                                                </div>
                                                <?php if (!empty($rating['review'])): ?>
                                                    <p class="mb-2"><?php echo nl2br(htmlspecialchars($rating['review'])); ?></p>
                                                <?php endif; ?>
                                                <small class="text-muted">
                                                    <i class="bi bi-clock me-1"></i>
                                                    <?php echo date('M d, Y', strtotime($rating['created_at'])); ?>
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/js/main.js"></script>
    
    <script>
        // Initialize GLightbox for image gallery
        const lightbox = GLightbox({
            selector: '[data-glightbox]'
        });
        
        // Rating stars interaction
        const ratingInputs = document.querySelectorAll('.rating-input');
        const ratingLabels = document.querySelectorAll('.rating-label');
        
        ratingLabels.forEach((label, index) => {
            label.addEventListener('mouseover', () => {
                for (let i = 0; i <= index; i++) {
                    ratingLabels[i].classList.add('active');
                }
                for (let i = index + 1; i < ratingLabels.length; i++) {
                    ratingLabels[i].classList.remove('active');
                }
            });
            
            label.addEventListener('click', () => {
                ratingInputs[index].checked = true;
            });
        });
        
        // Reset on mouse leave
        document.querySelector('.rating-stars-input').addEventListener('mouseleave', () => {
            ratingLabels.forEach((label, index) => {
                label.classList.remove('active');
                if (ratingInputs[index].checked) {
                    for (let i = 0; i <= index; i++) {
                        ratingLabels[i].classList.add('active');
                    }
                }
            });
        });
        
        // Set initial active states based on checked input
        ratingInputs.forEach((input, index) => {
            if (input.checked) {
                for (let i = 0; i <= index; i++) {
                    ratingLabels[i].classList.add('active');
                }
            }
        });
    </script>
</body>
</html>
