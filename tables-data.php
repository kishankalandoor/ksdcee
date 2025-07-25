<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Tables / Data </title>
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

     <link href="assets/css/main.css" rel="stylesheet">
</head>

<body>

  <header id="header-wrap" class="header d-flex align-items-center sticky-top" style="background-color: rgb(255, 255, 255); z-index: 999;">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
  
      <!-- Logo -->
      <a href="../ksdc2/indexdemo.php" class="logo d-flex align-items-center me-auto">
        <img src="./assets/img/logo-small.png" alt="Kakunje Software Logo">
      </a>
  
      <!-- Navbar -->
      <nav id="navmenu" class="navmenu">
        <ul class="d-flex align-items-center" style="margin-bottom: 0; gap: 10px; flex-wrap: wrap;">
  
          <!-- About -->
          <li class="dropdown">
            <br>
            <a href="#"><i class="bi bi-info-circle me-1"></i><span>About</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="about.php"style="color: black;">Team</a></li>
              <li><a href="https://kakunjesoftware.com/"style="color: black;">Kakunje Software</a></li>
            </ul>
          </li>
  
          <!-- Events -->
          <li class="dropdown">
            <br>
            <a href="#"><i class="bi bi-calendar-event me-1"></i><span>Events</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="events.php#Hackathon">Hackathon</a></li>
              <li><a href="events.php#Ideathon">Ideathon</a></li>
              <li><a href="events.php#Sponcership">Sponsorship</a></li>
              <li><a href="events.php#Collaboration">Collaboration</a></li>
            </ul>
          </li>
  
          <!-- Certification -->
          <li class="dropdown">
            <br>
            <a href="#"><i class="bi bi-award me-1"></i><span>Certification</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="courses.php">Courses</a></li>
            </ul>
          </li>
  
          <!-- Publications -->
          <li class="dropdown">
            <br>
            <a href="#"><i class="bi bi-journal-richtext me-1"></i><span>Publications</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="research.php#Articles">Articles</a></li>
              <li><a href="research.php#Journals">Journals</a></li>
              <li><a href="research.php#ResearchOpportunity">Research Opportunity</a></li>
            </ul>
          </li>
  
          <!-- Career -->
          <li class="dropdown">
            <br>
            <a href="#"><i class="bi bi-briefcase me-1"></i><span>Career</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="internship.php">Internship</a></li>
              <li><a href="jobs.php">Jobs</a></li>
            </ul>
          </li>
  
          <!-- Projects -->
          <li> <br><a href="projects.php"><i class="bi bi-code-slash me-1"></i>Projects</a></li>
  
          <!-- Contact -->
          <li> <br><a href="contact.php"><i class="bi bi-envelope me-1"></i>Contact Us</a></li>
  
          <!-- Dashboard -->
          <li> <br><a href="index.php"><i class="bi bi-grid me-1"></i>Dashboard</a></li>
          <!-- Join Us -->

       <div class="d-flex align-items-center">
        <br><br>
        <a href="joinus.php" class="btn-join-us d-none d-xl-inline-flex" style="margin-left: 25px; background: #ff5555; color: #fff; border-radius: 50px; padding: 8px 25px; font-size: 14px; font-weight: 600; transition: all 0.3s ease; text-decoration: none;" onmouseover="this.style.backgroundColor='#830000'; this.style.transform='translateY(-2px)'" onmouseout="this.style.backgroundColor=' #ff5555'; this.style.transform='translateY(0)'">Join Us</a>
        <i id="mobile-nav-toggle-icon" class="mobile-nav-toggle d-xl-none bi bi-list" style="color: #1d1d1f; font-size: 28px; line-height: 0; cursor: pointer; transition: color 0.3s;"></i>
        </div>
  
          <!-- Components -->
          <li class="dropdown">
            
            <a href="#"><i class="bi bi-menu-button-wide me-1"></i><span>Components</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="components-alerts.php">Alerts</a></li>
              <li><a href="components-accordion.php">Accordion</a></li>
              <li><a href="components-badges.php">Badges</a></li>
              <li><a href="components-breadcrumbs.php">Breadcrumbs</a></li>
              <li><a href="components-buttons.php">Buttons</a></li>
              <li><a href="components-cards.php">Cards</a></li>
              <li><a href="components-carousel.php">Carousel</a></li>
              <li><a href="components-list-group.php">List Group</a></li>
              <li><a href="components-modal.php">Modal</a></li>
              <li><a href="components-tabs.php">Tabs</a></li>
              <li><a href="components-pagination.php">Pagination</a></li>
              <li><a href="components-progress.php">Progress</a></li>
              <li><a href="components-spinners.php">Spinners</a></li>
              <li><a href="components-tooltips.php">Tooltips</a></li>
            </ul>
          </li>
  
          <!-- Forms -->
          <li class="dropdown">
            <a href="#"><i class="bi bi-journal-text me-1"></i><span>Forms</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="forms-elements.php">Form Elements</a></li>
              <li><a href="forms-layouts.php">Form Layouts</a></li>
              <li><a href="forms-editors.php">Form Editors</a></li>
              <li><a href="forms-validation.php">Form Validation</a></li>
            </ul>
          </li>
  
          <!-- Tables -->
          <li class="dropdown">
            <a href="#"><i class="bi bi-layout-text-window-reverse me-1"></i><span>Tables</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="tables-general.php">General Tables</a></li>
              <li><a href="tables-data.php">Data Tables</a></li>
            </ul>
          </li>
  
          <!-- Charts -->
          <li class="dropdown">
            <a href="#"><i class="bi bi-bar-chart me-1"></i><span>Charts</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="charts-chartjs.php">Chart.js</a></li>
              <li><a href="charts-apexcharts.php">ApexCharts</a></li>
              <li><a href="charts-echarts.php">ECharts</a></li>
            </ul>
          </li>
  
          <!-- Icons -->
          <li class="dropdown">
            <a href="#"><i class="bi bi-gem me-1"></i><span>Icons</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="icons-bootstrap.php">Bootstrap Icons</a></li>
              <li><a href="icons-remix.php">Remix Icons</a></li>
              <li><a href="icons-boxicons.php">Boxicons</a></li>
            </ul>
          </li>
  
          <!-- Pages -->
          <li class="dropdown">
            <a href="#"><i class="bi bi-files me-1"></i><span>Pages</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="users-profile.php">Profile</a></li>
              <li><a href="pages-faq.php">F.A.Q</a></li>
              <li><a href="pages-contact.php">Contact</a></li>
              <li><a href="pages-register.php">Register</a></li>
              <li><a href="pages-login.php">Login</a></li>
              <li><a href="pages-error-404.php">Error 404</a></li>
              <li><a href="pages-blank.php">Blank</a></li>
            </ul>
          </li>
  
          <!-- Join Us Button -->
          
        </ul>
  
        <!-- Mobile toggle -->
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
    </div>
  </header>
  
<!-- Bootstrap Icons CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Data Tables</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item">Tables</li>
          <li class="breadcrumb-item active">Data</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Datatables</h5>
              <p>Add lightweight datatables to your project with using the <a href="https://github.com/fiduswriter/Simple-DataTables" target="_blank">Simple DataTables</a> library. Just add <code>.datatable</code> class name to any table you wish to conver to a datatable. Check for <a href="https://fiduswriter.github.io/simple-datatables/demos/" target="_blank">more examples</a>.</p>

              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th>
                      <b>N</b>ame
                    </th>
                    <th>Ext.</th>
                    <th>City</th>
                    <th data-type="date" data-format="YYYY/DD/MM">Start Date</th>
                    <th>Completion</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Unity Pugh</td>
                    <td>9958</td>
                    <td>Curicó</td>
                    <td>2005/02/11</td>
                    <td>37%</td>
                  </tr>
                  <tr>
                    <td>Theodore Duran</td>
                    <td>8971</td>
                    <td>Dhanbad</td>
                    <td>1999/04/07</td>
                    <td>97%</td>
                  </tr>
                  <tr>
                    <td>Kylie Bishop</td>
                    <td>3147</td>
                    <td>Norman</td>
                    <td>2005/09/08</td>
                    <td>63%</td>
                  </tr>
                  <tr>
                    <td>Willow Gilliam</td>
                    <td>3497</td>
                    <td>Amqui</td>
                    <td>2009/29/11</td>
                    <td>30%</td>
                  </tr>
                  <tr>
                    <td>Blossom Dickerson</td>
                    <td>5018</td>
                    <td>Kempten</td>
                    <td>2006/11/09</td>
                    <td>17%</td>
                  </tr>
                  <tr>
                    <td>Elliott Snyder</td>
                    <td>3925</td>
                    <td>Enines</td>
                    <td>2006/03/08</td>
                    <td>57%</td>
                  </tr>
                  <tr>
                    <td>Castor Pugh</td>
                    <td>9488</td>
                    <td>Neath</td>
                    <td>2014/23/12</td>
                    <td>93%</td>
                  </tr>
                  <tr>
                    <td>Pearl Carlson</td>
                    <td>6231</td>
                    <td>Cobourg</td>
                    <td>2014/31/08</td>
                    <td>100%</td>
                  </tr>
                  <tr>
                    <td>Deirdre Bridges</td>
                    <td>1579</td>
                    <td>Eberswalde-Finow</td>
                    <td>2014/26/08</td>
                    <td>44%</td>
                  </tr>
                  <tr>
                    <td>Daniel Baldwin</td>
                    <td>6095</td>
                    <td>Moircy</td>
                    <td>2000/11/01</td>
                    <td>33%</td>
                  </tr>
                  <tr>
                    <td>Phelan Kane</td>
                    <td>9519</td>
                    <td>Germersheim</td>
                    <td>1999/16/04</td>
                    <td>77%</td>
                  </tr>
                  <tr>
                    <td>Quentin Salas</td>
                    <td>1339</td>
                    <td>Los Andes</td>
                    <td>2011/26/01</td>
                    <td>49%</td>
                  </tr>
                  <tr>
                    <td>Armand Suarez</td>
                    <td>6583</td>
                    <td>Funtua</td>
                    <td>1999/06/11</td>
                    <td>9%</td>
                  </tr>
                  <tr>
                    <td>Gretchen Rogers</td>
                    <td>5393</td>
                    <td>Moxhe</td>
                    <td>1998/26/10</td>
                    <td>24%</td>
                  </tr>
                  <tr>
                    <td>Harding Thompson</td>
                    <td>2824</td>
                    <td>Abeokuta</td>
                    <td>2008/06/08</td>
                    <td>10%</td>
                  </tr>
                  <tr>
                    <td>Mira Rocha</td>
                    <td>4393</td>
                    <td>Port Harcourt</td>
                    <td>2002/04/10</td>
                    <td>14%</td>
                  </tr>
                  <tr>
                    <td>Drew Phillips</td>
                    <td>2931</td>
                    <td>Goes</td>
                    <td>2011/18/10</td>
                    <td>58%</td>
                  </tr>
                  <tr>
                    <td>Emerald Warner</td>
                    <td>6205</td>
                    <td>Chiavari</td>
                    <td>2002/08/04</td>
                    <td>58%</td>
                  </tr>
                  <tr>
                    <td>Colin Burch</td>
                    <td>7457</td>
                    <td>Anamur</td>
                    <td>2004/02/01</td>
                    <td>34%</td>
                  </tr>
                  <tr>
                    <td>Russell Haynes</td>
                    <td>8916</td>
                    <td>Frascati</td>
                    <td>2015/28/04</td>
                    <td>18%</td>
                  </tr>
                  <tr>
                    <td>Brennan Brooks</td>
                    <td>9011</td>
                    <td>Olmué</td>
                    <td>2000/18/04</td>
                    <td>2%</td>
                  </tr>
                  <tr>
                    <td>Kane Anthony</td>
                    <td>8075</td>
                    <td>LaSalle</td>
                    <td>2006/21/05</td>
                    <td>93%</td>
                  </tr>
                  <tr>
                    <td>Scarlett Hurst</td>
                    <td>1019</td>
                    <td>Brampton</td>
                    <td>2015/07/01</td>
                    <td>94%</td>
                  </tr>
                  <tr>
                    <td>James Scott</td>
                    <td>3008</td>
                    <td>Meux</td>
                    <td>2007/30/05</td>
                    <td>55%</td>
                  </tr>
                  <tr>
                    <td>Desiree Ferguson</td>
                    <td>9054</td>
                    <td>Gojra</td>
                    <td>2009/15/02</td>
                    <td>81%</td>
                  </tr>
                  <tr>
                    <td>Elaine Bishop</td>
                    <td>9160</td>
                    <td>Petrópolis</td>
                    <td>2008/23/12</td>
                    <td>48%</td>
                  </tr>
                  <tr>
                    <td>Hilda Nelson</td>
                    <td>6307</td>
                    <td>Posina</td>
                    <td>2004/23/05</td>
                    <td>76%</td>
                  </tr>
                  <tr>
                    <td>Evangeline Beasley</td>
                    <td>3820</td>
                    <td>Caplan</td>
                    <td>2009/12/03</td>
                    <td>62%</td>
                  </tr>
                  <tr>
                    <td>Wyatt Riley</td>
                    <td>5694</td>
                    <td>Cavaion Veronese</td>
                    <td>2012/19/02</td>
                    <td>67%</td>
                  </tr>
                  <tr>
                    <td>Wyatt Mccarthy</td>
                    <td>3547</td>
                    <td>Patan</td>
                    <td>2014/23/06</td>
                    <td>9%</td>
                  </tr>
                  <tr>
                    <td>Cairo Rice</td>
                    <td>6273</td>
                    <td>Ostra Vetere</td>
                    <td>2016/27/02</td>
                    <td>13%</td>
                  </tr>
                  <tr>
                    <td>Sylvia Peters</td>
                    <td>6829</td>
                    <td>Arrah</td>
                    <td>2015/03/02</td>
                    <td>13%</td>
                  </tr>
                  <tr>
                    <td>Kasper Craig</td>
                    <td>5515</td>
                    <td>Firenze</td>
                    <td>2015/26/04</td>
                    <td>56%</td>
                  </tr>
                  <tr>
                    <td>Leigh Ruiz</td>
                    <td>5112</td>
                    <td>Lac Ste. Anne</td>
                    <td>2001/09/02</td>
                    <td>28%</td>
                  </tr>
                  <tr>
                    <td>Athena Aguirre</td>
                    <td>5741</td>
                    <td>Romeral</td>
                    <td>2010/24/03</td>
                    <td>15%</td>
                  </tr>
                  <tr>
                    <td>Riley Nunez</td>
                    <td>5533</td>
                    <td>Sart-Eustache</td>
                    <td>2003/26/02</td>
                    <td>30%</td>
                  </tr>
                  <tr>
                    <td>Lois Talley</td>
                    <td>9393</td>
                    <td>Dorchester</td>
                    <td>2014/05/01</td>
                    <td>51%</td>
                  </tr>
                  <tr>
                    <td>Hop Bass</td>
                    <td>1024</td>
                    <td>Westerlo</td>
                    <td>2012/25/09</td>
                    <td>85%</td>
                  </tr>
                  <tr>
                    <td>Kalia Diaz</td>
                    <td>9184</td>
                    <td>Ichalkaranji</td>
                    <td>2013/26/06</td>
                    <td>92%</td>
                  </tr>
                  <tr>
                    <td>Maia Pate</td>
                    <td>6682</td>
                    <td>Louvain-la-Neuve</td>
                    <td>2011/23/04</td>
                    <td>50%</td>
                  </tr>
                  <tr>
                    <td>Macaulay Pruitt</td>
                    <td>4457</td>
                    <td>Fraser-Fort George</td>
                    <td>2015/03/08</td>
                    <td>92%</td>
                  </tr>
                  <tr>
                    <td>Danielle Oconnor</td>
                    <td>9464</td>
                    <td>Neuwied</td>
                    <td>2001/05/10</td>
                    <td>17%</td>
                  </tr>
                  <tr>
                    <td>Kato Carr</td>
                    <td>4842</td>
                    <td>Faridabad</td>
                    <td>2012/11/05</td>
                    <td>96%</td>
                  </tr>
                  <tr>
                    <td>Malachi Mejia</td>
                    <td>7133</td>
                    <td>Vorst</td>
                    <td>2007/25/04</td>
                    <td>26%</td>
                  </tr>
                  <tr>
                    <td>Dominic Carver</td>
                    <td>3476</td>
                    <td>Pointe-aux-Trembles</td>
                    <td>2014/14/03</td>
                    <td>71%</td>
                  </tr>
                  <tr>
                    <td>Paki Santos</td>
                    <td>4424</td>
                    <td>Cache Creek</td>
                    <td>2001/18/11</td>
                    <td>82%</td>
                  </tr>
                  <tr>
                    <td>Ross Hodges</td>
                    <td>1862</td>
                    <td>Trazegnies</td>
                    <td>2010/19/09</td>
                    <td>87%</td>
                  </tr>
                  <tr>
                    <td>Hilda Whitley</td>
                    <td>3514</td>
                    <td>New Sarepta</td>
                    <td>2011/05/07</td>
                    <td>94%</td>
                  </tr>
                  <tr>
                    <td>Roth Cherry</td>
                    <td>4006</td>
                    <td>Flin Flon</td>
                    <td>2008/02/09</td>
                    <td>8%</td>
                  </tr>
                  <tr>
                    <td>Lareina Jones</td>
                    <td>8642</td>
                    <td>East Linton</td>
                    <td>2009/07/08</td>
                    <td>21%</td>
                  </tr>
                  <tr>
                    <td>Joshua Weiss</td>
                    <td>2289</td>
                    <td>Saint-Léonard</td>
                    <td>2010/15/01</td>
                    <td>52%</td>
                  </tr>
                  <tr>
                    <td>Kiona Lowery</td>
                    <td>5952</td>
                    <td>Inuvik</td>
                    <td>2002/17/12</td>
                    <td>72%</td>
                  </tr>
                  <tr>
                    <td>Nina Rush</td>
                    <td>7567</td>
                    <td>Bo‘lhe</td>
                    <td>2008/27/01</td>
                    <td>6%</td>
                  </tr>
                  <tr>
                    <td>Palmer Parker</td>
                    <td>2000</td>
                    <td>Stade</td>
                    <td>2012/24/07</td>
                    <td>58%</td>
                  </tr>
                  <tr>
                    <td>Vielka Olsen</td>
                    <td>3745</td>
                    <td>Vrasene</td>
                    <td>2016/08/01</td>
                    <td>70%</td>
                  </tr>
                  <tr>
                    <td>Meghan Cunningham</td>
                    <td>8604</td>
                    <td>Söke</td>
                    <td>2007/16/02</td>
                    <td>59%</td>
                  </tr>
                  <tr>
                    <td>Iola Shaw</td>
                    <td>6447</td>
                    <td>Albany</td>
                    <td>2014/05/03</td>
                    <td>88%</td>
                  </tr>
                  <tr>
                    <td>Imelda Cole</td>
                    <td>4564</td>
                    <td>Haasdonk</td>
                    <td>2007/16/11</td>
                    <td>79%</td>
                  </tr>
                  <tr>
                    <td>Jerry Beach</td>
                    <td>6801</td>
                    <td>Gattatico</td>
                    <td>1999/07/07</td>
                    <td>36%</td>
                  </tr>
                  <tr>
                    <td>Garrett Rocha</td>
                    <td>3938</td>
                    <td>Gavorrano</td>
                    <td>2000/06/08</td>
                    <td>71%</td>
                  </tr>
                  <tr>
                    <td>Derek Kerr</td>
                    <td>1724</td>
                    <td>Gualdo Cattaneo</td>
                    <td>2014/21/01</td>
                    <td>89%</td>
                  </tr>
                  <tr>
                    <td>Shad Hudson</td>
                    <td>5944</td>
                    <td>Salamanca</td>
                    <td>2014/10/12</td>
                    <td>98%</td>
                  </tr>
                  <tr>
                    <td>Daryl Ayers</td>
                    <td>8276</td>
                    <td>Barchi</td>
                    <td>2012/12/11</td>
                    <td>88%</td>
                  </tr>
                  <tr>
                    <td>Caleb Livingston</td>
                    <td>3094</td>
                    <td>Fatehpur</td>
                    <td>2014/13/02</td>
                    <td>8%</td>
                  </tr>
                  <tr>
                    <td>Sydney Meyer</td>
                    <td>4576</td>
                    <td>Neubrandenburg</td>
                    <td>2015/06/02</td>
                    <td>22%</td>
                  </tr>
                  <tr>
                    <td>Lani Lawrence</td>
                    <td>8501</td>
                    <td>Turnhout</td>
                    <td>2008/07/05</td>
                    <td>16%</td>
                  </tr>
                  <tr>
                    <td>Allegra Shepherd</td>
                    <td>2576</td>
                    <td>Meeuwen-Gruitrode</td>
                    <td>2004/19/04</td>
                    <td>41%</td>
                  </tr>
                  <tr>
                    <td>Fallon Reyes</td>
                    <td>3178</td>
                    <td>Monceau-sur-Sambre</td>
                    <td>2005/15/02</td>
                    <td>16%</td>
                  </tr>
                  <tr>
                    <td>Karen Whitley</td>
                    <td>4357</td>
                    <td>Sluis</td>
                    <td>2003/02/05</td>
                    <td>23%</td>
                  </tr>
                  <tr>
                    <td>Stewart Stephenson</td>
                    <td>5350</td>
                    <td>Villa Faraldi</td>
                    <td>2003/05/07</td>
                    <td>65%</td>
                  </tr>
                  <tr>
                    <td>Ursula Reynolds</td>
                    <td>7544</td>
                    <td>Southampton</td>
                    <td>1999/16/12</td>
                    <td>61%</td>
                  </tr>
                  <tr>
                    <td>Adrienne Winters</td>
                    <td>4425</td>
                    <td>Laguna Blanca</td>
                    <td>2014/15/09</td>
                    <td>24%</td>
                  </tr>
                  <tr>
                    <td>Francesca Brock</td>
                    <td>1337</td>
                    <td>Oban</td>
                    <td>2000/12/06</td>
                    <td>90%</td>
                  </tr>
                  <tr>
                    <td>Ursa Davenport</td>
                    <td>7629</td>
                    <td>New Plymouth</td>
                    <td>2013/27/06</td>
                    <td>37%</td>
                  </tr>
                  <tr>
                    <td>Mark Brock</td>
                    <td>3310</td>
                    <td>Veenendaal</td>
                    <td>2006/08/09</td>
                    <td>41%</td>
                  </tr>
                  <tr>
                    <td>Dale Rush</td>
                    <td>5050</td>
                    <td>Chicoutimi</td>
                    <td>2000/27/03</td>
                    <td>2%</td>
                  </tr>
                  <tr>
                    <td>Shellie Murphy</td>
                    <td>3845</td>
                    <td>Marlborough</td>
                    <td>2013/13/11</td>
                    <td>72%</td>
                  </tr>
                  <tr>
                    <td>Porter Nicholson</td>
                    <td>4539</td>
                    <td>Bismil</td>
                    <td>2012/22/10</td>
                    <td>23%</td>
                  </tr>
                  <tr>
                    <td>Oliver Huber</td>
                    <td>1265</td>
                    <td>Hannche</td>
                    <td>2002/11/01</td>
                    <td>94%</td>
                  </tr>
                  <tr>
                    <td>Calista Maynard</td>
                    <td>3315</td>
                    <td>Pozzuolo del Friuli</td>
                    <td>2006/23/03</td>
                    <td>5%</td>
                  </tr>
                  <tr>
                    <td>Lois Vargas</td>
                    <td>6825</td>
                    <td>Cumberland</td>
                    <td>1999/25/04</td>
                    <td>50%</td>
                  </tr>
                  <tr>
                    <td>Hermione Dickson</td>
                    <td>2785</td>
                    <td>Woodstock</td>
                    <td>2001/22/03</td>
                    <td>2%</td>
                  </tr>
                  <tr>
                    <td>Dalton Jennings</td>
                    <td>5416</td>
                    <td>Dudzele</td>
                    <td>2015/09/02</td>
                    <td>74%</td>
                  </tr>
                  <tr>
                    <td>Cathleen Kramer</td>
                    <td>3380</td>
                    <td>Crowsnest Pass</td>
                    <td>2012/27/07</td>
                    <td>53%</td>
                  </tr>
                  <tr>
                    <td>Zachery Morgan</td>
                    <td>6730</td>
                    <td>Collines-de-l'Outaouais</td>
                    <td>2006/04/09</td>
                    <td>51%</td>
                  </tr>
                  <tr>
                    <td>Yoko Freeman</td>
                    <td>4077</td>
                    <td>Lidköping</td>
                    <td>2002/27/12</td>
                    <td>48%</td>
                  </tr>
                  <tr>
                    <td>Chaim Waller</td>
                    <td>4240</td>
                    <td>North Shore</td>
                    <td>2010/25/07</td>
                    <td>25%</td>
                  </tr>
                  <tr>
                    <td>Berk Johnston</td>
                    <td>4532</td>
                    <td>Vergnies</td>
                    <td>2016/23/02</td>
                    <td>93%</td>
                  </tr>
                  <tr>
                    <td>Tad Munoz</td>
                    <td>2902</td>
                    <td>Saint-Nazaire</td>
                    <td>2010/09/05</td>
                    <td>65%</td>
                  </tr>
                  <tr>
                    <td>Vivien Dominguez</td>
                    <td>5653</td>
                    <td>Bargagli</td>
                    <td>2001/09/01</td>
                    <td>86%</td>
                  </tr>
                  <tr>
                    <td>Carissa Lara</td>
                    <td>3241</td>
                    <td>Sherborne</td>
                    <td>2015/07/12</td>
                    <td>72%</td>
                  </tr>
                  <tr>
                    <td>Hammett Gordon</td>
                    <td>8101</td>
                    <td>Wah</td>
                    <td>1998/06/09</td>
                    <td>20%</td>
                  </tr>
                  <tr>
                    <td>Walker Nixon</td>
                    <td>6901</td>
                    <td>Metz</td>
                    <td>2011/12/11</td>
                    <td>41%</td>
                  </tr>
                  <tr>
                    <td>Nathan Espinoza</td>
                    <td>5956</td>
                    <td>Strathcona County</td>
                    <td>2002/25/01</td>
                    <td>47%</td>
                  </tr>
                  <tr>
                    <td>Kelly Cameron</td>
                    <td>4836</td>
                    <td>Fontaine-Valmont</td>
                    <td>1999/02/07</td>
                    <td>24%</td>
                  </tr>
                  <tr>
                    <td>Kyra Moses</td>
                    <td>3796</td>
                    <td>Quenast</td>
                    <td>1998/07/07</td>
                    <td>68%</td>
                  </tr>
                  <tr>
                    <td>Grace Bishop</td>
                    <td>8340</td>
                    <td>Rodez</td>
                    <td>2012/02/10</td>
                    <td>4%</td>
                  </tr>
                  <tr>
                    <td>Haviva Hernandez</td>
                    <td>8136</td>
                    <td>Suwałki</td>
                    <td>2000/30/01</td>
                    <td>16%</td>
                  </tr>
                  <tr>
                    <td>Alisa Horn</td>
                    <td>9853</td>
                    <td>Ucluelet</td>
                    <td>2007/01/11</td>
                    <td>39%</td>
                  </tr>
                  <tr>
                    <td>Zelenia Roman</td>
                    <td>7516</td>
                    <td>Redwater</td>
                    <td>2012/03/03</td>
                    <td>31%</td>
                  </tr>
                </tbody>
              </table>
              <!-- End Table with stripped rows -->

            </div>
          </div>

        </div>
      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
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

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>