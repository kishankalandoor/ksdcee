
<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('dbconnection.php');

// Initialize variables
$username = $useremail = $pass = $confirm_pass = "";
$username_err = $email_err = $password_err = $confirm_password_err = "";
$success_msg = $error_msg = "";

if (isset($_POST['submit'])) {
    // For email as username, set username same as email
    if (!empty(trim($_POST['useremail']))) {
        $useremail = trim($_POST['useremail']);
        $username = $useremail; // Set username equal to email
    }
    
    // Validate email (now used as both email and username)
    if (empty($useremail)) {
        $email_err = "Please enter an email address.";
    } elseif (!filter_var($useremail, FILTER_VALIDATE_EMAIL)) {
        $email_err = "Please enter a valid email address.";
    } else {
        // Check if email already exists
        $check_email = mysqli_prepare($con, "SELECT id FROM tbl_login WHERE useremail = ?");
        mysqli_stmt_bind_param($check_email, "s", $useremail);
        mysqli_stmt_execute($check_email);
        $result = mysqli_stmt_get_result($check_email);
        
        if (mysqli_num_rows($result) > 0) {
            $email_err = "This email is already registered.";
        }
        mysqli_stmt_close($check_email);
    }
    
    // Validate password
    if (empty(trim($_POST['pass']))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST['pass'])) < 8) {
        $password_err = "Password must have at least 8 characters.";
    } elseif (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/", trim($_POST['pass']))) {
        $password_err = "Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.";
    } else {
        $pass = trim($_POST['pass']);
    }
    
    // Validate confirm password
    if (empty(trim($_POST['confirm_pass']))) {
        $confirm_password_err = "Please confirm your password.";
    } else {
        $confirm_pass = trim($_POST['confirm_pass']);
        if ($pass != $confirm_pass) {
            $confirm_password_err = "Passwords do not match.";
        }
    }
    
    // If no errors, proceed with registration
    if (empty($email_err) && empty($password_err) && empty($confirm_password_err)) {
        // Hash the password securely
        $hashedPass = password_hash($pass, PASSWORD_DEFAULT);
        
        // Insert user into database using prepared statement
        $insert_query = mysqli_prepare($con, "INSERT INTO tbl_login (username, useremail, pass) VALUES (?, ?, ?)");
        
        if ($insert_query) {
            mysqli_stmt_bind_param($insert_query, "sss", $username, $useremail, $hashedPass);
            
            if (mysqli_stmt_execute($insert_query)) {
                $success_msg = "Registration successful! You can now login.";
                // Clear form data
                $useremail = "";
                // Redirect after 2 seconds
                header("refresh:2;url=joinus.php");
            } else {
                $error_msg = "Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($insert_query);
        } else {
            $error_msg = "Database error. Please try again later.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Register - KSDC</title>
  <meta content="Join KSDC Community" name="description">
  <meta content="register, signup, KSDC, community" name="keywords">

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
      </div>
        <div class="container">
           
     
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">


              
              <div style="height: 20vh; display: flex; justify-content: center; align-items: center; flex-direction: column;">
                <a href="../ksdc2/indexdemo.php" style="display: flex; align-items: center; justify-content: center;"></a>
                   <img src="./assets/img/logo-small.png" alt="Kakunje Software Logo" style="transform: scale(0.1);">
                 </a>
          
                
               </div>
              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Create an Account</h5>
                    <p class="text-center small">Enter your personal details to create account</p>
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
                  if (!empty($success_msg)) {
                      echo '<div class="alert alert-success text-center">' . $success_msg . '</div>';
                  }
                  if (!empty($error_msg)) {
                      echo '<div class="alert alert-danger text-center">' . $error_msg . '</div>';
                  }
                  ?>

                  <form class="row g-3 needs-validation" method='POST' novalidate>
                    <div class="col-12">
                      <label for="yourEmail" class="form-label">Email (will be used as username)</label>
                      <input type="email" name="useremail" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" 
                             id="yourEmail" value="<?php echo htmlspecialchars($useremail); ?>" required>
                      <div class="invalid-feedback">
                        <?php echo !empty($email_err) ? $email_err : 'Please enter a valid email address.'; ?>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <input type="password" name="pass" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" 
                             id="yourPassword" required>
                      <div class="invalid-feedback">
                        <?php echo !empty($password_err) ? $password_err : 'Password must be at least 8 characters with uppercase, lowercase, number and special character.'; ?>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="confirmPassword" class="form-label">Confirm Password</label>
                      <input type="password" name="confirm_pass" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" 
                             id="confirmPassword" required>
                      <div class="invalid-feedback">
                        <?php echo !empty($confirm_password_err) ? $confirm_password_err : 'Please confirm your password.'; ?>
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input" name="terms" type="checkbox" value="" id="acceptTerms" required>
                        <label class="form-check-label" for="acceptTerms">
                          I agree and accept the <a href="#">terms and conditions</a>
                        </label>
                        <div class="invalid-feedback">You must agree before submitting.</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit" name="submit">Create Account</button>
                    </div>
                    
                    <div class="col-12">
                      <p class="small mb-0">Already have an account? <a href="joinus.php">Log in</a></p>
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
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/js/main.js"></script>

  <script>
  // Google OAuth configuration
  function loginWithGoogle() {
    // Initialize Google OAuth
    if (typeof google !== 'undefined') {
      google.accounts.oauth2.initTokenClient({
        client_id: 'YOUR_GOOGLE_CLIENT_ID.apps.googleusercontent.com',
        scope: 'email profile',
        callback: handleGoogleResponse
      }).requestAccessToken();
    } else {
      alert('Google OAuth is not loaded. Please refresh the page and try again.');
    }
  }

  function handleGoogleResponse(response) {
    if (response.access_token) {
      // Get user info from Google
      fetch('https://www.googleapis.com/oauth2/v2/userinfo', {
        headers: {
          'Authorization': 'Bearer ' + response.access_token
        }
      })
      .then(response => response.json())
      .then(data => {
        // Auto-fill the form with Google data
        document.getElementById('yourEmail').value = data.email;
        // Show success message
        alert('Google account connected! Please set a password to complete registration.');
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
    const redirectUri = encodeURIComponent(window.location.origin + '/ksdc22/github-callback.php');
    const scope = 'user:email';
    
    window.location.href = `https://github.com/login/oauth/authorize?client_id=${clientId}&redirect_uri=${redirectUri}&scope=${scope}`;
  }

  // Passkey (WebAuthn) implementation
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

      // Create credential options
      const createCredentialDefaultArgs = {
        publicKey: {
          rp: {
            name: "KSDC Community",
            id: window.location.hostname,
          },
          user: {
            id: new TextEncoder().encode("user123"),
            name: "user@example.com",
            displayName: "User",
          },
          pubKeyCredParams: [{alg: -7, type: "public-key"}],
          authenticatorSelection: {
            authenticatorAttachment: "platform",
            userVerification: "required"
          },
          timeout: 60000,
          attestation: "direct"
        }
      };

      // Generate random challenge
      createCredentialDefaultArgs.publicKey.challenge = new Uint8Array(32);
      crypto.getRandomValues(createCredentialDefaultArgs.publicKey.challenge);

      const credential = await navigator.credentials.create(createCredentialDefaultArgs);
      
      if (credential) {
        alert('Passkey created successfully! Please complete the registration form.');
        // You can process the credential here
        console.log('Passkey credential:', credential);
      }
      
    } catch (error) {
      console.error('Passkey error:', error);
      alert('Passkey authentication failed: ' + error.message);
    }
  }

  // Enhanced form validation
  (function() {
    'use strict';
    window.addEventListener('load', function() {
      var forms = document.getElementsByClassName('needs-validation');
      var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
          // Enhanced password validation
          var password = document.getElementById('yourPassword').value;
          var confirmPassword = document.getElementById('confirmPassword').value;
          
          // Check password strength
          var strongRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
          
          if (!strongRegex.test(password)) {
            document.getElementById('yourPassword').setCustomValidity('Password must contain at least 8 characters with uppercase, lowercase, number and special character');
          } else {
            document.getElementById('yourPassword').setCustomValidity('');
          }
          
          if (password !== confirmPassword) {
            document.getElementById('confirmPassword').setCustomValidity('Passwords do not match');
          } else {
            document.getElementById('confirmPassword').setCustomValidity('');
          }
          
          if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          form.classList.add('was-validated');
        }, false);
      });
    }, false);
  })();
  
  // Real-time password strength indicator
  document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('yourPassword');
    const confirmPasswordInput = document.getElementById('confirmPassword');
    
    // Create password strength indicator
    const strengthIndicator = document.createElement('div');
    strengthIndicator.className = 'password-strength-indicator mt-1';
    passwordInput.parentNode.appendChild(strengthIndicator);
    
    passwordInput.addEventListener('input', function() {
      const password = this.value;
      let strength = 0;
      let feedback = [];
      
      if (password.length >= 8) strength++;
      else feedback.push('At least 8 characters');
      
      if (/[a-z]/.test(password)) strength++;
      else feedback.push('One lowercase letter');
      
      if (/[A-Z]/.test(password)) strength++;
      else feedback.push('One uppercase letter');
      
      if (/\d/.test(password)) strength++;
      else feedback.push('One number');
      
      if (/[@$!%*?&]/.test(password)) strength++;
      else feedback.push('One special character');
      
      const colors = ['#dc3545', '#fd7e14', '#ffc107', '#28a745', '#20c997'];
      const labels = ['Very Weak', 'Weak', 'Fair', 'Good', 'Strong'];
      
      strengthIndicator.innerHTML = `
        <div class="progress" style="height: 5px;">
          <div class="progress-bar" style="width: ${strength * 20}%; background-color: ${colors[strength-1] || colors[0]};"></div>
        </div>
        <small class="text-muted">${labels[strength-1] || labels[0]} ${feedback.length > 0 ? '- Need: ' + feedback.join(', ') : ''}</small>
      `;
    });
    
    // Real-time password matching
    confirmPasswordInput.addEventListener('input', function() {
      const password = passwordInput.value;
      const confirmPassword = this.value;
      
      if (password !== confirmPassword) {
        this.setCustomValidity('Passwords do not match');
      } else {
        this.setCustomValidity('');
      }
    });
  });
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
       Want to stay update?<br>Subscribe to our Newsletter :)</h5>

        <p class="text-light mb-2" style="margin-top: 10px;">Subscribe to get latest updates.</p>
        <form class="d-flex mb-4">
          <input type="email" placeholder="Enter your email" class="form-control me-2" style="max-width: 280px; background-color: white; color: black; border: none;">
          <button type="submit" class="btn btn-danger">Submit</button>
        </form>
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
   