<?php
session_start();

// Check if user is logged in
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: joinus.php");
    exit;
}

require_once "db.php";

// Get user's projects
$user_id = $_SESSION["id"];
$sql = "SELECT * FROM projects WHERE user_id = ? ORDER BY created_at DESC";
$projects = [];

if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $projects = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
}

// Get project statistics
$stats_sql = "SELECT 
    COUNT(*) as total_projects,
    COALESCE(SUM(views), 0) as total_views,
    COALESCE(AVG(rating), 0) as avg_rating,
    COALESCE(SUM(comments_count), 0) as total_comments
FROM projects WHERE user_id = ?";

$stats = ['total_projects' => 0, 'total_views' => 0, 'avg_rating' => 0, 'total_comments' => 0];

if ($stmt = mysqli_prepare($conn, $stats_sql)) {
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($result)) {
        $stats = $row;
    }
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Projects - KSDC</title>
    <meta name="description" content="Manage your projects in KSDC Community.">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="assets/css/main.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    
    <style>
        .project-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .project-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        }
        
        .project-image {
            height: 200px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
        }
        
        .project-stats {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
        }
        
        .stat-item {
            text-align: center;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .badge-category {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.8rem;
        }
        
        .rating-stars {
            color: #ffc107;
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
                    <li><a href="my-projects.php" class="active">My Projects</a></li>
                    <li><a href="upload-project.php">Upload Project</a></li>
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
                            <h2>My Projects</h2>
                            <p class="text-muted">Manage and track your project portfolio</p>
                        </div>
                        <a href="upload-project.php" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>Upload New Project
                        </a>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="project-stats">
                <div class="row">
                    <div class="col-md-3 stat-item">
                        <div class="stat-number text-primary"><?php echo $stats['total_projects']; ?></div>
                        <div class="text-muted">Total Projects</div>
                    </div>
                    <div class="col-md-3 stat-item">
                        <div class="stat-number text-success"><?php echo number_format($stats['total_views']); ?></div>
                        <div class="text-muted">Total Views</div>
                    </div>
                    <div class="col-md-3 stat-item">
                        <div class="stat-number text-warning"><?php echo number_format($stats['avg_rating'], 1); ?></div>
                        <div class="text-muted">Average Rating</div>
                    </div>
                    <div class="col-md-3 stat-item">
                        <div class="stat-number text-info"><?php echo $stats['total_comments']; ?></div>
                        <div class="text-muted">Total Comments</div>
                    </div>
                </div>
            </div>

            <!-- Projects Grid -->
            <?php if (empty($projects)): ?>
                <div class="empty-state">
                    <i class="bi bi-folder-x"></i>
                    <h3>No Projects Yet</h3>
                    <p>You haven't uploaded any projects yet. Start sharing your amazing work with the community!</p>
                    <a href="upload-project.php" class="btn btn-primary btn-lg">
                        <i class="bi bi-plus-circle me-2"></i>Upload Your First Project
                    </a>
                </div>
            <?php else: ?>
                <div class="row">
                    <?php foreach ($projects as $project): ?>
                        <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up">
                            <div class="card project-card h-100">
                                <div class="project-image">
                                    <?php if (!empty($project['screenshot'])): ?>
                                        <img src="uploads/projects/<?php echo htmlspecialchars($project['screenshot']); ?>" 
                                             alt="<?php echo htmlspecialchars($project['title']); ?>" 
                                             style="width: 100%; height: 100%; object-fit: cover;">
                                    <?php else: ?>
                                        <i class="bi bi-code-slash"></i>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <span class="badge-category"><?php echo htmlspecialchars($project['category']); ?></span>
                                        <div class="rating-stars">
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
                                            <small class="text-muted ms-1">(<?php echo number_format($rating, 1); ?>)</small>
                                        </div>
                                    </div>
                                    
                                    <h5 class="card-title"><?php echo htmlspecialchars($project['title']); ?></h5>
                                    <p class="card-text text-muted">
                                        <?php echo htmlspecialchars(substr($project['description'], 0, 100)); ?>...
                                    </p>
                                    
                                    <?php if (!empty($project['technologies'])): ?>
                                        <div class="mb-3">
                                            <small class="text-muted">
                                                <i class="bi bi-gear me-1"></i>
                                                <?php echo htmlspecialchars($project['technologies']); ?>
                                            </small>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="row text-center small text-muted mb-3">
                                        <div class="col-4">
                                            <i class="bi bi-eye"></i> <?php echo number_format($project['views']); ?>
                                        </div>
                                        <div class="col-4">
                                            <i class="bi bi-chat"></i> <?php echo $project['comments_count']; ?>
                                        </div>
                                        <div class="col-4">
                                            <i class="bi bi-calendar"></i> <?php echo date('M d, Y', strtotime($project['created_at'])); ?>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex gap-2">
                                        <a href="project-details.php?id=<?php echo $project['id']; ?>" class="btn btn-outline-primary btn-sm flex-fill">
                                            <i class="bi bi-eye me-1"></i>View
                                        </a>
                                        <a href="edit-project.php?id=<?php echo $project['id']; ?>" class="btn btn-outline-secondary btn-sm flex-fill">
                                            <i class="bi bi-pencil me-1"></i>Edit
                                        </a>
                                        <?php if (!empty($project['github_url'])): ?>
                                            <a href="<?php echo htmlspecialchars($project['github_url']); ?>" target="_blank" class="btn btn-outline-dark btn-sm">
                                                <i class="bi bi-github"></i>
                                            </a>
                                        <?php endif; ?>
                                        <?php if (!empty($project['demo_url'])): ?>
                                            <a href="<?php echo htmlspecialchars($project['demo_url']); ?>" target="_blank" class="btn btn-outline-success btn-sm">
                                                <i class="bi bi-link-45deg"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
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
