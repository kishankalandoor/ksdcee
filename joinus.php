<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once "dbconnection.php"; // Use the correct database connection file

// Check if database connection is successful
if (!$con) {
    die("Database connection failed. Please try again later.");
}

// If user is already logged in, redirect to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}

// Define variables and initialize with empty values
$login_input = $password = "";
$login_input_err = $password_err = $login_err = "";

// Process form data when submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate login input (email only)
    if (empty(trim($_POST["login_input"]))) {
        $login_input_err = "Please enter your email.";
    } elseif (!filter_var(trim($_POST["login_input"]), FILTER_VALIDATE_EMAIL)) {
        $login_input_err = "Please enter a valid email address.";
    } else {
        $login_input = trim($_POST["login_input"]);
    }
    
    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password!";
    } else {
        $password = trim($_POST["password"]);
    }
    
    // If no errors, check the database
    if (empty($login_input_err) && empty($password_err)) {
        // Login with email (since username = email now)
        $sql = "SELECT id, username, useremail, pass FROM tbl_login WHERE useremail = ?";
        
        if ($stmt = $con->prepare($sql)) {
            $stmt->bind_param("s", $param_login_input);
            $param_login_input = $login_input;
            
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                
                if ($result->num_rows == 1) {
                    $row = $result->fetch_assoc();
                    $id = $row['id'];
                    $username_db = $row['username'];
                    $email_db = $row['useremail'];
                    $hashed_password = $row['pass'];
                    
                    // Verify password (handles both hashed and plain text for backward compatibility)
                    if (password_verify($password, $hashed_password) || $password == $hashed_password) {
                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $id;
                        $_SESSION["username"] = $username_db;
                        $_SESSION["email"] = $email_db;                          
                        header("location: welcome.php"); // Redirect to welcome page
                        exit;
                    } else {
                        $login_err = "Invalid login credentials.";
                    }
                } else {
                    $login_err = "Invalid login credentials.";
                }
            } else {
                $login_err = "Oops! Something went wrong. Please try again later.";
            }
            $stmt->close();
        } else {
            $login_err = "Database error. Please try again later.";
        }
    }
    $con->close();
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">


  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Jobs</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
  
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
  
  
  </head>
  
  <body class="events-page">
  
  
    <header id="header-wrap" class="header d-flex align-items-center sticky-top"style="background-color: white;">
      <div class="container-fluid container-xl position-relative d-flex align-items-center">
    
        <a href="../ksdc2/indexdemo.php" class="logo d-flex align-items-center me-auto">
          <img src="./assets/img/logo-small.png" alt="Kakunje Software Logo">
          <!-- You could also add a sitename if desired, like the reference -->
          <!-- <h1 class="sitename">Kakunje Software</h1> -->
        </a>
    
        <nav id="navmenu" class="navmenu" >
          <ul>
           <pre>                            </pre>
           
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
         <!-- Join Us -->
  
         <div class="d-flex align-items-center">
          <a href="joinus.php" class="btn-join-us d-none d-xl-inline-flex" style="margin-left: 25px; background: #ff5555; color: #fff; border-radius: 50px; padding: 8px 25px; font-size: 14px; font-weight: 600; transition: all 0.3s ease; text-decoration: none;" onmouseover="this.style.backgroundColor='#830000'; this.style.transform='translateY(-2px)'" onmouseout="this.style.backgroundColor=' #ff5555'; this.style.transform='translateY(0)'">Join Us</a>
          <i id="mobile-nav-toggle-icon" class="mobile-nav-toggle d-xl-none bi bi-list" style="color: #1d1d1f; font-size: 28px; line-height: 0; cursor: pointer; transition: color 0.3s;"></i>
          </div>
      
           
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
             
         
        </nav>
     
        <!-- This "Join Us" button is placed outside the main nav for prominence, similar to how many templates handle a call-to-action button. -->
   
       
      </div>
    </header>
  
  <main>
    <div class="container">
    <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
      <div class="container">

        <div class="row justify-content-center">
      <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
        <div style="height: 20vh; display: flex; justify-content: center; align-items: center; flex-direction: column;">
          <a href="../ksdc2/indexdemo.php" style="display: flex; align-items: center; justify-content: center;">
         <img src="./assets/img/logo-small.png" alt="Kakunje Software Logo" style="transform: scale(0.1);">
           </a>
        </div>

        <div class="card mb-3">

          <div class="card-body">

        <div class="pt-4 pb-2">
          <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
          <p class="text-center small">Choose your preferred login method</p>
        </div>

        <!-- Social Login Options -->
        <div class="d-grid gap-2 mb-3">
          <button type="button" class="btn btn-outline-danger" onclick="loginWithGoogle()">
            <i class="bi bi-google me-2"></i>Continue with Google
          </button>
          <button type="button" class="btn btn-outline-dark" onclick="loginWithGithub()">
            <i class="bi bi-github me-2"></i>Continue with GitHub
          </button>
          <button type="button" class="btn btn-outline-primary" onclick="loginWithPasskey()">
            <i class="bi bi-fingerprint me-2"></i>Continue with Passkey
          </button>
        </div>

        <div class="text-center mb-3">
          <small class="text-muted">
            <hr class="hr-text" data-content="OR">
          </small>
        </div>

        <style>
          .hr-text {
            line-height: 1em;
            position: relative;
            outline: 0;
            border: 0;
            color: black;
            text-align: center;
            height: 1.5em;
            opacity: .5;
          }
          .hr-text:before {
            content: '';
            background: linear-gradient(to right, transparent, #818078, transparent);
            position: absolute;
            left: 0;
            top: 50%;
            width: 100%;
            height: 1px;
          }
          .hr-text:after {
            content: attr(data-content);
            position: relative;
            display: inline-block;
            color: black;
            padding: 0 .5em;
            line-height: 1.5em;
            background-color: white;
          }
        </style>

        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>
          
        <form class="row g-3 needs-validation" method="post" novalidate>

          <div class="col-12">
            <label for="yourUsername" class="form-label">Email</label>
            <div class="input-group has-validation">
              <span class="input-group-text" id="inputGroupPrepend"><i class="bi bi-envelope"></i></span>
              <input type="email" name="login_input" class="form-control <?php echo (!empty($login_input_err)) ? 'is-invalid' : ''; ?>" 
                     id="yourUsername" value="<?php echo htmlspecialchars($login_input); ?>" 
                     placeholder="Enter your email" required>
              <div class="invalid-feedback"><?php echo empty($login_input_err) ? 'Please enter your email.' : $login_input_err; ?></div>
            </div>
          </div>

          <div class="col-12">
            <label for="yourPassword" class="form-label">Password</label>
            <div class="input-group">
              <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" id="yourPassword" required>
              <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                <i class="bi bi-eye"></i>
              </button>
              <div class="invalid-feedback"><?php echo empty($password_err) ? 'Please enter your password!' : $password_err; ?></div>
            </div>
          </div>

          <div class="col-12">
            <div class="form-check">
          <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
          <label class="form-check-label" for="rememberMe">Remember me</label>
            </div>
          </div>
         
          <div class="col-12">
            <button class="btn btn-primary w-100" type="submit">Login</button>
          </div>
          <div class="col-12">
            <p class="small mb-0">Don't have an account? <a href="register.php">Create an account</a></p>
          </div>
        </form>

          </div>
        </div>

      </div>
        </div>
      </div>

    </section>

    </div>
  </main><!-- End #main -->


  

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/html-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

  <script>
  // Password toggle functionality
  document.addEventListener('DOMContentLoaded', function() {
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('yourPassword');
    
    if (togglePassword && password) {
      togglePassword.addEventListener('click', function() {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        
        const icon = this.querySelector('i');
        icon.classList.toggle('bi-eye');
        icon.classList.toggle('bi-eye-slash');
      });
    }
  });

  // Google OAuth configuration
  function loginWithGoogle() {
    // Initialize Google OAuth
    if (typeof google !== 'undefined') {
      google.accounts.oauth2.initTokenClient({
        client_id: 'YOUR_GOOGLE_CLIENT_ID.apps.googleusercontent.com',
        scope: 'email profile',
        callback: handleGoogleLoginResponse
      }).requestAccessToken();
    } else {
      alert('Google OAuth is not loaded. Please refresh the page and try again.');
    }
  }

  function handleGoogleLoginResponse(response) {
    if (response.access_token) {
      // Get user info from Google
      fetch('https://www.googleapis.com/oauth2/v2/userinfo', {
        headers: {
          'Authorization': 'Bearer ' + response.access_token
        }
      })
      .then(response => response.json())
      .then(data => {
        // Send data to server for login
        fetch('google-login.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            email: data.email,
            name: data.name,
            google_id: data.id,
            access_token: response.access_token
          })
        })
        .then(response => response.json())
        .then(result => {
          if (result.success) {
            window.location.href = 'welcome.php';
          } else {
            alert('Login failed: ' + result.message);
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Login failed. Please try again.');
        });
      })
      .catch(error => {
        console.error('Error:', error);
        alert('Failed to get user information from Google.');
      });
    }
  }

  // GitHub OAuth
  function loginWithGithub() {
    // Redirect to GitHub OAuth
    const clientId = 'YOUR_GITHUB_CLIENT_ID';
    const redirectUri = encodeURIComponent(window.location.origin + '/ksdc22/github-login-callback.php');
    const scope = 'user:email';
    
    window.location.href = `https://github.com/login/oauth/authorize?client_id=${clientId}&redirect_uri=${redirectUri}&scope=${scope}`;
  }

  // Passkey (WebAuthn) implementation for login
  async function loginWithPasskey() {
    if (!window.PublicKeyCredential) {
      alert('WebAuthn is not supported in this browser.');
      return;
    }

    try {
      // Check if passkey is available
      const available = await PublicKeyCredential.isUserVerifyingPlatformAuthenticatorAvailable();
      
      if (!available) {
        alert('Passkey authentication is not available on this device.');
        return;
      }

      // Get authentication options from server
      const response = await fetch('passkey-login-options.php');
      const options = await response.json();
      
      if (!options.success) {
        alert('Failed to get authentication options: ' + options.message);
        return;
      }

      // Convert challenge from base64
      options.challenge = Uint8Array.from(atob(options.challenge), c => c.charCodeAt(0));
      
      // Convert allowCredentials if present
      if (options.allowCredentials) {
        options.allowCredentials = options.allowCredentials.map(cred => ({
          ...cred,
          id: Uint8Array.from(atob(cred.id), c => c.charCodeAt(0))
        }));
      }

      const credential = await navigator.credentials.get({
        publicKey: options
      });
      
      if (credential) {
        // Send credential to server for verification
        const loginResponse = await fetch('passkey-login-verify.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            id: credential.id,
            rawId: btoa(String.fromCharCode(...new Uint8Array(credential.rawId))),
            response: {
              authenticatorData: btoa(String.fromCharCode(...new Uint8Array(credential.response.authenticatorData))),
              clientDataJSON: btoa(String.fromCharCode(...new Uint8Array(credential.response.clientDataJSON))),
              signature: btoa(String.fromCharCode(...new Uint8Array(credential.response.signature))),
              userHandle: credential.response.userHandle ? btoa(String.fromCharCode(...new Uint8Array(credential.response.userHandle))) : null
            }
          })
        });
        
        const result = await loginResponse.json();
        
        if (result.success) {
          window.location.href = 'welcome.php';
        } else {
          alert('Passkey login failed: ' + result.message);
        }
      }
      
    } catch (error) {
      console.error('Passkey error:', error);
      alert('Passkey authentication failed: ' + error.message);
    }
  }
  // Client-side form validation
  (function() {
    'use strict';
    window.addEventListener('load', function() {
      var forms = document.getElementsByClassName('needs-validation');
      var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
          if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          form.classList.add('was-validated');
        }, false);
      });
    }, false);
  })();
  </script>

</body>
}
  }

  // Client-side form validation
  (function() {
    'use strict';
    window.addEventListener('load', function() {
      var forms = document.getElementsByClassName('needs-validation');
      var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
          if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          form.classList.add('was-validated');
        }, false);
      });
    }, false);
  })();
  </script>

  <!-- Google OAuth Script -->
  <script src="https://accounts.google.com/gsi/client" async defer></script>

</body>
<footer id="footer" style="background-color: #000; color: white; padding: 60px 0;">
  <div class="container">
    <div class="row">

      <!-- Left Info Column -->
      <div class="col-lg-3 col-md-6 mb-4">
        <h3 style="font-weight: 800; font-size: 28px; line-height: 1.4; color: white;">
          Kakunje<br>Software<br>Developers<br>Community
        </h3>
        
        <p style="margin-top: 10px; font-size: 15px; color: #ddd;">
          Kakunje Software Developers Community is the Community of Coding Enthusiasts on Discord. Together We aim to explore the untouched world of technology and tremendous growth-making fields.
        </p>
      </div>

      <!-- Quick Links -->
      <div class="col-lg-2 col-md-6 mb-4">
        <h5 style="font-weight: 700; font-size: 28px; line-height: 1.4; color: white;">
         Quick Links
        </h5>
        <ul class="list-unstyled mt-3" style="line-height: 2;">
          <li><a href="#hero-area" style="color: white; text-decoration: none;">Home</a></li>
          <li><a href="#about" style="color: white; text-decoration: none;">About</a></li>
          <li><a href="#testimonials" style="color: white; text-decoration: none;">Team</a></li>
          <li><a href="#events" style="color: white; text-decoration: none;">Events</a></li>
          <li><a href="#testimonial1" style="color: white; text-decoration: none;">Testimonials</a></li>
          <li><a href="#opportunity" style="color: white; text-decoration: none;">Opportunity</a></li>
        </ul>
      </div>

      <!-- Join Us Links -->
      <div class="col-lg-2 col-md-6 mb-4">
        <h5 style="font-weight: 700; font-size: 28px; line-height: 1.4; color: white;">
         Join Us
         </h5>
        <ul class="list-unstyled mt-3" style="line-height: 2;">
          <li><a href="#events" style="color: white; text-decoration: none;">Events</a></li>
          <li><a href="#volunteer" style="color: white; text-decoration: none;">Volunteer Group</a></li>
          <li><a href="#community" style="color: white; text-decoration: none;">Community</a></li>
        </ul>
      </div>

      <!-- Newsletter & Contact -->
      <div class="col-lg-5 col-md-6">
   
       
 <h5 style="font-weight: 700; font-size: 28px; line-height: 1.4; color: white;">
  Contact
        </h5>
        
        <p style="color: #ccc; font-size: 15px;">
          Kakunje Software Private Limited<br>
          Door No:15-7-336/17, #205, 2nd Floor,<br>
          Abhiman Plaza, Bunts Hostel Circle,<br>
          Mangaluru - 575003<br>
          Dakshina Kannada, Karnataka, India
        </p>
        <p><i class="fas fa-envelope"></i> <a href="mailto:kakunjesoftware@gmail.com" style="color: white; text-decoration: none;">kakunjesoftware@gmail.com</a></p>
        <p><i class="fas fa-phone"></i> <a href="tel:+918892882988" style="color: white; text-decoration: none;">+91 8892882988</a></p>
      </div>
    </div>

    <!-- Social Icons -->
    <div class="text-center mt-4">
      <a href="https://www.linkedin.com/company/kakunje+software+private+limited" target="_blank" class="me-3">
        <i class="fab fa-linkedin" style="font-size: 24px; color: #0A66C2;"></i>
      </a>
      <a href="https://www.youtube.com/results?search_query=kakunje+software" target="_blank">
        <i class="fab fa-youtube" style="font-size: 24px; color: #FF0000;"></i>
      </a>
    </div>
  </div>

  <!-- Copyright -->
  <div style="border-top: 1px solid #333; margin-top: 40px; padding: 20px 0; text-align: center;">
    <p style="margin: 0; color: #bbb;">Copyright © 2025 
      <span style="color: #ffffff;">Kakunje Software Developers Community</span> All Right Reserved
    </p>
  </div>

</footer>

</html>

