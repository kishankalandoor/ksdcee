<?php
session_start();

// Check if user is logged in
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: joinus.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Dashboard - KSDC</title>
    <meta name="description" content="Welcome to KSDC Community Dashboard. Access events, courses, and career opportunities.">
    <meta name="keywords" content="KSDC, dashboard, community, software development, events, courses, careers">

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
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
  
  <!-- Custom CSS for navbar fixes -->
  <style>
    /* Fix navbar text colors */
    .navmenu ul li a {
      color: #333 !important;
      font-weight: 500;
      padding: 10px 15px;
    }
    
    .navmenu ul li a:hover {
      color: #007bff !important;
    }
    
    /* Fix dropdown styling */
    .navmenu .dropdown ul {
      background: white;
      border: 1px solid #eee;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .navmenu .dropdown ul li a {
      color: #333 !important;
      padding: 8px 15px;
    }
    
    .navmenu .dropdown ul li a:hover {
      background-color: #f8f9fa;
      color: #007bff !important;
    }
    
    /* Navigation layout */
    .navmenu ul {
      list-style: none;
      margin: 0;
      padding: 0;
      gap: 20px;
    }
    
    .navmenu ul li {
      position: relative;
    }
    
    /* Logo styling */
    .logo {
      text-decoration: none !important;
    }
    
    .logo img {
      max-height: 40px;
      width: auto;
    }
    
    /* Header layout fixes */
    .header {
      min-height: 70px;
      padding: 15px 0;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    /* Button styling like reference */
    .btn-danger {
      font-size: 13px;
      font-weight: 500;
      padding: 8px 20px;
    }
    
    /* Ensure proper spacing */
    .navbar-text {
      font-weight: 500;
      font-size: 14px;
      margin-right: 15px !important;
    }
    
    /* Mobile nav toggle */
    .mobile-nav-toggle {
      color: #333;
      font-size: 1.5rem;
    }
    
    /* Center the navigation */
    .container-fluid.container-xl {
      max-width: 1200px;
    }
    
    /* Responsive fixes */
    @media (max-width: 768px) {
      .navbar-text {
        font-size: 12px;
      }
      
      .btn-sm {
        font-size: 11px;
        padding: 6px 12px;
      }
      
      .navmenu ul {
        gap: 10px;
      }
    }
  </style>
</head>
<body>
<header id="header-wrap" class="header d-flex align-items-center sticky-top" style="background-color: white;">

    <a href="../ksdc2/indexdemo.php" class="logo d-flex align-items-center me-5" style="margin-left: 100px;">
        <img src="./assets/img/logo-small.png" alt="Kakunje Software Logo" style="height: 40px; width: auto; margin-right: 15px;">
    
     </a>
<div class="container-fluid container-xl position-relative d-flex align-items-center">


    <nav id="navmenu" class="navmenu flex-grow-1">
      <ul class="d-flex justify-content-center">
        <li class="dropdown"><a href="#"><span>About</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
          <ul>
            <li><a href="about.php">Team</a></li>
            <li><a href="https://kakunjesoftware.com/">Kakunje Software</a></li>
          </ul>
        </li>

        <li class="dropdown"><a href="#"><span>Events</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
          <ul>
            <li><a href="events.php#Hackathon">Hackathon</a></li>
            <li><a href="events.php#Ideathon">Ideathon</a></li>
            <li><a href="events.php#Sponcership">Sponsorship</a></li>
            <li><a href="events.php#Collaboration">Collaboration</a></li>
          </ul>
        </li>

        <li class="dropdown"><a href="#"><span>Certification</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
          <ul>
            <li><a href="courses.php">Courses</a></li>
          </ul>
        </li>

        <li class="dropdown"><a href="#"><span>Publications</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
          <ul>
            <li><a href="research.php#Articles">Articles</a></li>
            <li><a href="research.php#Journals">Journals</a></li>
            <li><a href="research.php#ResearchOpportunity">Research Opportunity</a></li>
          </ul>
        </li>

        <li class="dropdown"><a href="#"><span>Career</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
          <ul>
            <li><a href="internship.php">Internship</a></li>
            <li><a href="jobs.php">Jobs</a></li>
          </ul>
        </li>

        <li><a href="projects.php">Projects</a></li>
        <li><a href="contact.php">Contact Us</a></li>
      </ul>
      <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
    </nav>
    
    <!-- User Welcome and Logout Section -->
    <div class="d-flex align-items-center">
      <span class="navbar-text me-3" style="color: #333; white-space: nowrap; font-size: 14px;">Welcome, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</span>
      <a href="logout.php" class="btn btn-danger btn-sm px-3" style="background-color: #dc3545; border-color: #dc3545; border-radius: 20px;">Logout</a>
    </div>

  </div>
</header>
  <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Welcome to KSDC Community Dashboard</h3>
                    </div>
                    <div class="card-body">
                        <h5>Hello, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</h5>
                        <p>You have successfully logged into the Kakunje Software Developers Community platform.</p>
                        
                        <div class="row mt-4">
                            <div class="col-md-4 mb-3">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <i class="bi bi-calendar-event" style="font-size: 2rem; color: #0d6efd;"></i>
                                        <h5 class="card-title mt-2">Events</h5>
                                        <p class="card-text">Check out upcoming events and hackathons.</p>
                                        <a href="events.php" class="btn btn-primary">View Events</a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <i class="bi bi-book" style="font-size: 2rem; color: #198754;"></i>
                                        <h5 class="card-title mt-2">Courses</h5>
                                        <p class="card-text">Explore our certification courses.</p>
                                        <a href="courses.php" class="btn btn-success">Browse Courses</a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <i class="bi bi-briefcase" style="font-size: 2rem; color: #fd7e14;"></i>
                                        <h5 class="card-title mt-2">Career</h5>
                                        <p class="card-text">Find internship and job opportunities.</p>
                                        <a href="jobs.php" class="btn btn-warning">View Opportunities</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Project Management Section -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <h4 class="text-center mb-4" style="color: #333; font-weight: 600;">Project Management Hub</h4>
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <div class="card text-center h-100">
                                    <div class="card-body">
                                        <i class="bi bi-cloud-upload" style="font-size: 2rem; color: #6f42c1;"></i>
                                        <h5 class="card-title mt-2">Upload Project</h5>
                                        <p class="card-text">Share your projects with the community.</p>
                                        <a href="upload-project.php" class="btn btn-outline-primary">Upload Now</a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <div class="card text-center h-100">
                                    <div class="card-body">
                                        <i class="bi bi-folder-open" style="font-size: 2rem; color: #20c997;"></i>
                                        <h5 class="card-title mt-2">Browse Projects</h5>
                                        <p class="card-text">Explore community projects and get inspired.</p>
                                        <a href="projects.php" class="btn btn-outline-success">Browse All</a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <div class="card text-center h-100">
                                    <div class="card-body">
                                        <i class="bi bi-chat-square-text" style="font-size: 2rem; color: #dc3545;"></i>
                                        <h5 class="card-title mt-2">Project Comments</h5>
                                        <p class="card-text">Engage with projects through comments.</p>
                                        <a href="my-comments.php" class="btn btn-outline-danger">My Comments</a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <div class="card text-center h-100">
                                    <div class="card-body">
                                        <i class="bi bi-star" style="font-size: 2rem; color: #ffc107;"></i>
                                        <h5 class="card-title mt-2">Rate Projects</h5>
                                        <p class="card-text">Rate and review community projects.</p>
                                        <a href="my-ratings.php" class="btn btn-outline-warning">My Ratings</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- My Projects Section -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">My Projects Dashboard</h5>
                                        <a href="upload-project.php" class="btn btn-primary btn-sm">
                                            <i class="bi bi-plus-circle me-1"></i>New Project
                                        </a>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3 text-center">
                                                <div class="p-3 bg-light rounded">
                                                    <h3 class="text-primary mb-1">0</h3>
                                                    <small class="text-muted">Projects Uploaded</small>
                                                </div>
                                            </div>
                                            <div class="col-md-3 text-center">
                                                <div class="p-3 bg-light rounded">
                                                    <h3 class="text-success mb-1">0</h3>
                                                    <small class="text-muted">Total Views</small>
                                                </div>
                                            </div>
                                            <div class="col-md-3 text-center">
                                                <div class="p-3 bg-light rounded">
                                                    <h3 class="text-warning mb-1">0</h3>
                                                    <small class="text-muted">Average Rating</small>
                                                </div>
                                            </div>
                                            <div class="col-md-3 text-center">
                                                <div class="p-3 bg-light rounded">
                                                    <h3 class="text-info mb-1">0</h3>
                                                    <small class="text-muted">Comments Received</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-3 text-center">
                                            <p class="text-muted">Start sharing your projects with the KSDC community!</p>
                                            <a href="my-projects.php" class="btn btn-outline-primary">Manage My Projects</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    
    <!-- Vendor JS Files -->
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    
    <!-- Main JS File -->
    <script src="assets/js/main.js"></script>
</body>
</html>
