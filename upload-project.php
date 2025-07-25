<?php
session_start();

// Check if user is logged in
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: joinus.php");
    exit;
}

$message = "";
$message_type = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database connection
    require_once "db.php";
    
    $title = trim($_POST["title"]);
    $description = trim($_POST["description"]);
    $category = trim($_POST["category"]);
    $technologies = trim($_POST["technologies"]);
    $github_url = trim($_POST["github_url"]);
    $demo_url = trim($_POST["demo_url"]);
    $user_id = $_SESSION["id"];
    $username = $_SESSION["username"];
    
    // Handle file upload
    $screenshot = "";
    if (isset($_FILES["screenshot"]) && $_FILES["screenshot"]["error"] == 0) {
        $target_dir = "uploads/projects/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $file_extension = pathinfo($_FILES["screenshot"]["name"], PATHINFO_EXTENSION);
        $screenshot = uniqid() . "." . $file_extension;
        $target_file = $target_dir . $screenshot;
        
        if (move_uploaded_file($_FILES["screenshot"]["tmp_name"], $target_file)) {
            // File uploaded successfully
        } else {
            $screenshot = "";
        }
    }
    
    if (!empty($title) && !empty($description) && !empty($category)) {
        $sql = "INSERT INTO projects (title, description, category, technologies, github_url, demo_url, screenshot, user_id, username, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "sssssssss", $title, $description, $category, $technologies, $github_url, $demo_url, $screenshot, $user_id, $username);
            
            if (mysqli_stmt_execute($stmt)) {
                $message = "Project uploaded successfully!";
                $message_type = "success";
            } else {
                $message = "Something went wrong. Please try again later.";
                $message_type = "danger";
            }
            mysqli_stmt_close($stmt);
        }
    } else {
        $message = "Please fill in all required fields.";
        $message_type = "danger";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Project - KSDC</title>
    <meta name="description" content="Upload your project to KSDC Community.">
    <meta name="keywords" content="KSDC, project upload, community, software development">

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
        /* Custom styles for upload form */
        .upload-container {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 60px 0;
        }
        
        .upload-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            padding: 40px;
            margin: 20px 0;
        }
        
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        
        .btn-upload {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            color: white;
            font-weight: 600;
        }
        
        .btn-upload:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }
        
        .file-upload-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
            width: 100%;
        }
        
        .file-upload-input {
            position: absolute;
            left: -9999px;
        }
        
        .file-upload-label {
            border: 2px dashed #ddd;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .file-upload-label:hover {
            border-color: #667eea;
            background-color: #f8f9ff;
        }
        
        .project-icon {
            font-size: 3rem;
            color: #667eea;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <!-- Header (same as welcome.php) -->
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
                    <li class="dropdown"><a href="#"><span>Community</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                        <ul>
                            <li><a href="events.php">Events</a></li>
                            <li><a href="courses.php">Courses</a></li>
                            <li><a href="jobs.php">Career</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
            
            <div class="d-flex align-items-center">
                <span class="navbar-text me-3" style="color: #333; white-space: nowrap; font-size: 14px;">Welcome, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</span>
                <a href="logout.php" class="btn btn-danger btn-sm px-3" style="background-color: #dc3545; border-color: #dc3545; border-radius: 20px;">Logout</a>
            </div>
        </div>
    </header>

    <div class="upload-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="upload-card">
                        <div class="text-center mb-4">
                            <i class="bi bi-cloud-upload project-icon"></i>
                            <h2 class="mb-2">Upload Your Project</h2>
                            <p class="text-muted">Share your amazing project with the KSDC community</p>
                        </div>

                        <?php if (!empty($message)): ?>
                            <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
                                <?php echo $message; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="title" class="form-label">Project Title *</label>
                                    <input type="text" class="form-control" id="title" name="title" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="category" class="form-label">Category *</label>
                                    <select class="form-control" id="category" name="category" required>
                                        <option value="">Select Category</option>
                                        <option value="Web Development">Web Development</option>
                                        <option value="Mobile App">Mobile App</option>
                                        <option value="Desktop Application">Desktop Application</option>
                                        <option value="Machine Learning">Machine Learning</option>
                                        <option value="Data Science">Data Science</option>
                                        <option value="Game Development">Game Development</option>
                                        <option value="IoT">IoT</option>
                                        <option value="Blockchain">Blockchain</option>
                                        <option value="DevOps">DevOps</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Project Description *</label>
                                <textarea class="form-control" id="description" name="description" rows="4" required placeholder="Describe your project, its features, and what makes it special..."></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="technologies" class="form-label">Technologies Used</label>
                                <input type="text" class="form-control" id="technologies" name="technologies" placeholder="e.g., PHP, JavaScript, MySQL, Bootstrap">
                                <small class="form-text text-muted">Separate multiple technologies with commas</small>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="github_url" class="form-label">GitHub URL</label>
                                    <input type="url" class="form-control" id="github_url" name="github_url" placeholder="https://github.com/username/project">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="demo_url" class="form-label">Live Demo URL</label>
                                    <input type="url" class="form-control" id="demo_url" name="demo_url" placeholder="https://your-project-demo.com">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Project Screenshot</label>
                                <div class="file-upload-wrapper">
                                    <input type="file" class="file-upload-input" id="screenshot" name="screenshot" accept="image/*">
                                    <label for="screenshot" class="file-upload-label">
                                        <i class="bi bi-image" style="font-size: 2rem; color: #667eea;"></i>
                                        <div class="mt-2">
                                            <strong>Click to upload screenshot</strong>
                                            <p class="mb-0 text-muted">PNG, JPG up to 5MB</p>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-upload btn-lg">
                                    <i class="bi bi-upload me-2"></i>Upload Project
                                </button>
                                <a href="welcome.php" class="btn btn-outline-secondary btn-lg ms-3">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/js/main.js"></script>

    <script>
        // File upload preview
        document.getElementById('screenshot').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const label = document.querySelector('.file-upload-label');
            
            if (file) {
                label.innerHTML = `
                    <i class="bi bi-check-circle" style="font-size: 2rem; color: #28a745;"></i>
                    <div class="mt-2">
                        <strong>${file.name}</strong>
                        <p class="mb-0 text-muted">File selected successfully</p>
                    </div>
                `;
            }
        });
    </script>
</body>
</html>
