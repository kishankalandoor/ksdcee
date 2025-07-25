
<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: joinus.php");
    exit();
}
?>
 <?php echo $_SESSION['user']; ?>

 <!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Project</title>
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

<body class="news-details-page">

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

  <main class="main">

  
    

    <!-- Blog Details Section -->
    <section id="blog-details" class="blog-details section">
      <div class="container" data-aos="fade-up">

        <article class="article">
          <div class="article-header">
            <div class="meta-categories" data-aos="fade-up">
              <a href="#" class="category">Technology</a>
              <a href="#" class="category">Innovation</a>
            </div>

            <h1 class="title" data-aos="fade-up" data-aos-delay="100">The Evolution of User Interface Design: From Skeuomorphism to Neumorphism</h1>

            <div class="article-meta" data-aos="fade-up" data-aos-delay="200">
              <div class="author">
                <img src="assets/img/person/person-m-6.webp" alt="Author" class="author-img">
                <div class="author-info">
                  <h4>David Wilson</h4>
                  <span>UI/UX Design Lead</span>
                </div>
              </div>
              <div class="post-info">
                <span><i class="bi bi-calendar4-week"></i> April 15, 2025</span>
                <span><i class="bi bi-clock"></i> 10 min read</span>
                <span><i class="bi bi-chat-square-text"></i> 32 Comments</span>
              </div>
            </div>
          </div>

          <div class="article-featured-image" data-aos="zoom-in">
            <img src="assets/img/blog/blog-hero-1.webp" alt="UI Design Evolution" class="img-fluid">
          </div>

          <div class="article-wrapper">
            <aside class="table-of-contents" data-aos="fade-left">
              <h3>Table of Contents</h3>
              <nav>
                <ul>
                  <li><a href="#introduction" class="active">Introduction</a></li>
                  <li><a href="#skeuomorphism">The Skeuomorphic Era</a></li>
                  <li><a href="#flat-design">Flat Design Revolution</a></li>
                  <li><a href="#material-design">Material Design</a></li>
                  <li><a href="#neumorphism">Rise of Neumorphism</a></li>
                  <li><a href="#future">Future Trends</a></li>
                </ul>
              </nav>
            </aside>

            <div class="article-content">
              <div class="content-section" id="introduction" data-aos="fade-up">
                <p class="lead">
                  The journey of user interface design has been marked by significant shifts in aesthetic approaches, each era bringing its own unique perspective on how digital interfaces should look and feel.
                </p>

                <p>
                  From the early days of graphical user interfaces to today's sophisticated design systems, the evolution of UI design reflects not just technological advancement, but also changing user expectations and cultural shifts in how we interact with digital products.
                </p>

                <div class="highlight-quote">
                  <blockquote>
                    <p>Design is not just what it looks like and feels like. Design is how it works.</p>
                    <cite>Steve Jobs</cite>
                  </blockquote>
                </div>
              </div>

              <div class="content-section" id="skeuomorphism" data-aos="fade-up">
                <h2>The Skeuomorphic Era</h2>
                <div class="image-with-caption right">
                  <img src="assets/img/blog/blog-hero-2.webp" alt="Skeuomorphic Design Example" class="img-fluid" loading="lazy">
                  <figcaption>Early iOS design showcasing skeuomorphic elements</figcaption>
                </div>
                <p>
                  Skeuomorphic design dominated the early years of digital interfaces, attempting to mirror real-world objects in digital form. This approach helped users transition from physical to digital interactions through familiar visual metaphors.
                </p>

                <div class="feature-points">
                  <div class="point">
                    <i class="bi bi-layers"></i>
                    <div>
                      <h4>Realistic Textures</h4>
                      <p>Detailed representations of materials like leather, metal, and paper</p>
                    </div>
                  </div>
                  <div class="point">
                    <i class="bi bi-lightbulb"></i>
                    <div>
                      <h4>Familiar Metaphors</h4>
                      <p>Digital elements mimicking their physical counterparts</p>
                    </div>
                  </div>
                </div>
              </div>

              <div class="content-section" id="flat-design" data-aos="fade-up">
                <h2>The Flat Design Revolution</h2>
                <p>
                  As users became more comfortable with digital interfaces, design began moving towards simplification. Flat design emerged as a reaction to the ornate details of skeuomorphism, emphasizing clarity and efficiency.
                </p>

                <div class="comparison-grid">
                  <div class="row g-4">
                    <div class="col-md-6">
                      <div class="comparison-card">
                        <div class="icon"><i class="bi bi-check-circle"></i></div>
                        <h4>Advantages</h4>
                        <ul>
                          <li>Improved loading times</li>
                          <li>Better scalability</li>
                          <li>Cleaner visual hierarchy</li>
                        </ul>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="comparison-card">
                        <div class="icon"><i class="bi bi-exclamation-circle"></i></div>
                        <h4>Challenges</h4>
                        <ul>
                          <li>Reduced visual cues</li>
                          <li>Potential usability issues</li>
                          <li>Limited depth perception</li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="content-section" id="material-design" data-aos="fade-up">
                <h2>Material Design: Finding Balance</h2>
                <p>
                  Google's Material Design emerged as a comprehensive design system that combined the simplicity of flat design with subtle depth cues, creating a more intuitive user experience while maintaining modern aesthetics.
                </p>

                <div class="key-principles">
                  <div class="principle">
                    <span class="number">01</span>
                    <h4>Physical Properties</h4>
                    <p>Surfaces and edges provide meaningful interaction cues</p>
                  </div>
                  <div class="principle">
                    <span class="number">02</span>
                    <h4>Bold Graphics</h4>
                    <p>Deliberate color choices and intentional white space</p>
                  </div>
                  <div class="principle">
                    <span class="number">03</span>
                    <h4>Meaningful Motion</h4>
                    <p>Animation informs and reinforces user actions</p>
                  </div>
                </div>
              </div>

              <div class="content-section" id="neumorphism" data-aos="fade-up">
                <h2>The Rise of Neumorphism</h2>
                <p>
                  Neumorphism represents the latest evolution in UI design, combining aspects of skeuomorphism with modern minimal aesthetics. This style creates soft, extruded surfaces that appear to emerge from the background.
                </p>

                <div class="info-box">
                  <div class="icon">
                    <i class="bi bi-info-circle"></i>
                  </div>
                  <div class="content">
                    <h4>Key Characteristics</h4>
                    <p>Neumorphic design relies on subtle shadow work to create the illusion of elements either protruding from or being pressed into their background surface.</p>
                  </div>
                </div>
              </div>

              <div class="content-section" id="future" data-aos="fade-up">
                <h2>Looking to the Future</h2>
                <p>
                  As we look ahead, UI design continues to evolve with new technologies and user expectations. The future may bring more personalized, adaptive interfaces that respond to individual user preferences and contexts.
                </p>

                <div class="future-trends">
                  <div class="trend">
                    <i class="bi bi-phone"></i>
                    <h4>Adaptive Interfaces</h4>
                    <p>Interfaces that automatically adjust based on user behavior and preferences</p>
                  </div>
                  <div class="trend">
                    <i class="bi bi-eye"></i>
                    <h4>Immersive Experiences</h4>
                    <p>Integration of AR and VR elements in everyday interfaces</p>
                  </div>
                  <div class="trend">
                    <i class="bi bi-hand-index"></i>
                    <h4>Gesture Controls</h4>
                    <p>Advanced motion and gesture-based interactions</p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="article-footer" data-aos="fade-up">
            <div class="share-article">
              <h4>Share this article</h4>
              <div class="share-buttons">
                <a href="#" class="share-button twitter">
                  <i class="bi bi-twitter-x"></i>
                  <span>Share on X</span>
                </a>
                <a href="#" class="share-button facebook">
                  <i class="bi bi-facebook"></i>
                  <span>Share on Facebook</span>
                </a>
                <a href="#" class="share-button linkedin">
                  <i class="bi bi-linkedin"></i>
                  <span>Share on LinkedIn</span>
                </a>
              </div>
            </div>

            <div class="article-tags">
              <h4>Related Topics</h4>
              <div class="tags">
                <a href="#" class="tag">UI Design</a>
                <a href="#" class="tag">User Experience</a>
                <a href="#" class="tag">Design Trends</a>
                <a href="#" class="tag">Innovation</a>
                <a href="#" class="tag">Technology</a>
              </div>
            </div>
          </div>

        </article>

      </div>
    </section><!-- /Blog Details Section -->

  </main>



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



  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>