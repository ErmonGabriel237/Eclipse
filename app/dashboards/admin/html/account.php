<?php
  // session_start();
  // if(!isset($_SESSION['success']) && ($_SESSION['userType']) != 'admin'){
  //   header('Location: ./authentication-login.php');
  // }

  // <?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['user_id']) && !isset($_SESSION['success']) && ($_SESSION['userType']) != 'admin') {
    // header('Location: login.php');
    header('Location: ./authentication-login.php');
    exit;
}

// Generate CSRF token if not exists
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!-- ?> -->
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="<?php echo $_SESSION['csrf_token']; ?>">
  <title>Modernize Free</title>
  <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="../assets/css/styles.min.css" />
</head>

<style>
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
        .table-container {
            position: relative;
            min-height: 400px;
        }
        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        .loading-spinner {
            width: 3rem;
            height: 3rem;
        }
        .hidden {
            display: none;
        }
    </style>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
    <aside class="left-sidebar">
      <!-- Sidebar scroll-->
      <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
          <a href="./index.html" class="text-nowrap logo-img">
            <img src="../assets/images/logos/dark-logo.svg" width="180" alt="" />
          </a>
          <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
            <i class="ti ti-x fs-8"></i>
          </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
        <ul id="sidebarnav">
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Home</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="./index.php" aria-expanded="false">
                <span>
                  <i class="ti ti-layout-dashboard"></i>
                </span>
                <span class="hide-menu">Dashboard</span>
              </a>
            </li>
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Management</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="./account.php" aria-expanded="false">
                <span>
                  <i class="ti ti-users"></i>
                </span>
                <span class="hide-menu">Accounts</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="../account.php" aria-expanded="false">
                <span>
                  <i class="ti ti-tag"></i>
                </span>
                <span class="hide-menu">Category</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="../account.php" aria-expanded="false">
                <span>
                  <i class="ti ti-book"></i>
                </span>
                <span class="hide-menu">Courses</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="../account.php" aria-expanded="false">
                <span>
                  <i class="ti ti-clipboard"></i>
                </span>
                <span class="hide-menu">Report</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="./message/chats.php" aria-expanded="false">
                <span>
                  <i class="ti ti-message"></i>
                </span>
                <span class="hide-menu">Discussion</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="../account.php" aria-expanded="false">
                <span>
                  <i class="ti ti-wrench"></i>
                </span>
                <span class="hide-menu">Setting</span>
              </a>
            </li>
          </ul>
        </nav>
        <!-- End Sidebar navigation -->
      </div>
      <!-- End Sidebar scroll-->
    </aside>
    <!--  Sidebar End -->
    <!--  Main wrapper -->
    <div class="body-wrapper">
      <!--  Header Start -->
      <header class="app-header">
        <nav class="navbar navbar-expand-lg navbar-light">
          <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
              <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                <i class="ti ti-menu-2"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-icon-hover" href="javascript:void(0)">
                <i class="ti ti-bell-ringing"></i>
                <div class="notification bg-primary rounded-circle"></div>
              </a>
            </li>
          </ul>
          <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
              <a href="" target="_blank" class="btn btn-primary"><?php echo $_SESSION['username'];?></a>
              <li class="nav-item dropdown">
                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <img src="../assets/images/profile/user-1.jpg" alt="" width="35" height="35" class="rounded-circle">
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                  <div class="message-body">
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-user fs-6"></i>
                      <p class="mb-0 fs-3">My Profile</p>
                    </a>
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-mail fs-6"></i>
                      <p class="mb-0 fs-3">My Account</p>
                    </a>
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-list-check fs-6"></i>
                      <p class="mb-0 fs-3">My Task</p>
                    </a>
                    <a href="../server/logout.php" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!--  Header End -->
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-4">
            <!-- <h5 class="card-title fw-semibold mb-4">Titles, text, and links</h5> -->
            <div class="card">
              <div class="card-body">
              <h5 class="card-title" id="userCount"></h5>
              <h5 class="card-title" id="errorUserMessage"></h5>
                <h6 class="card-subtitle mb-2 text-muted">Users</h6>
                <!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of
                          the
                          card's content.</p> -->
                <a href="#" class="btn btn-primary">Go somewhere</a>
                <!-- <a href="#" class="card-link">Card link</a>
                <a href="#" class="card-link">Another link</a> -->
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <!-- <h5 class="card-title fw-semibold mb-4">Titles, text, and links</h5> -->
            <div class="card">
              <div class="card-body">
              <h5 class="card-title" id="trainerCount"></h5>
              <h5 class="card-title" id="errorTrainerMessage"></h5>
                <h6 class="card-subtitle mb-2 text-muted">Trainers</h6>
                <!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of
                          the
                          card's content.</p> -->
                <a href="#" class="btn btn-primary">Go somewhere</a>
                <!-- <a href="#" class="card-link">Card link</a>
                <a href="#" class="card-link">Another link</a> -->
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <!-- <h5 class="card-title fw-semibold mb-4">Titles, text, and links</h5> -->
            <div class="card">
              <div class="card-body">
              <h5 class="card-title" id="clientCount"></h5>
              <h5 class="card-title" id="errorClientMessage"></h5>
                <h6 class="card-subtitle mb-2 text-muted">Clients</h6>
                <!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of
                          the
                          card's content.</p> -->
                <a href="#" class="btn btn-primary">Go somewhere</a>
                <!-- <a href="#" class="card-link">Another link</a> -->
              </div>
            </div>
          </div>
        </div>

        <div class="row mb-4">
            <div class="col">
                <h1>User Management</h1>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-3">
                <select id="roleFilter" class="form-select">
                    <option value="">All Roles</option>
                    <option value="trainer">Trainer</option>
                    <option value="client">Client</option>
                    <!-- <option value="user">User</option> -->
                </select>
            </div>
            <div class="col-md-3">
                <select id="statusFilter" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="online">Active</option>
                    <option value="offline">Inactive</option>
                </select>
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" id="searchInput" class="form-control" placeholder="Search users...">
                    <button class="btn btn-primary" id="searchBtn">
                        <i class="bi bi-search"></i> Search
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Users Table -->
        <div class="table-container">
            <div id="loadingOverlay" class="loading-overlay">
                <div class="spinner-border loading-spinner text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Avatar</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col">Status</th>
                        <th scope="col">Last Login</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody id="usersTableBody">
                    <!-- Table content will be loaded dynamically -->
                </tbody>
            </table>
            
            <!-- Pagination -->
            <nav aria-label="User pagination">
                <ul class="pagination justify-content-center" id="pagination">
                    <!-- Pagination will be loaded dynamically -->
                </ul>
            </nav>
            
            <!-- No results message -->
            <div id="noResults" class="alert alert-info text-center hidden">
                No users found matching your criteria.
            </div>
        </div>
    </div>

        <!-- <div class="card">
          <div class="card-body"> -->
          <!-- <div class="col">
            <div class="card w-100">
              <div class="card-body p-4">
                <h5 class="card-title fw-semibold mb-4">Recent Transactions</h5>
                <div class="table-responsive">
                  <table class="table text-nowrap mb-0 align-middle">
                    <thead class="text-dark fs-4">
                      <tr>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Id</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Username</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Email</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">UserType</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Status</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Edit</h6>
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td class="border-bottom-0"><h6 class="fw-semibold mb-0">1</h6></td>
                        <td class="border-bottom-0">
                            <h6 class="fw-semibold mb-1">Sunil Joshi</h6>
                             <span class="fw-normal">Web Designer</span>                           
                        </td>
                        <td class="border-bottom-0">
                          <p class="mb-0 fw-normal">Elite Admin</p>
                        </td>
                        <td class="border-bottom-0">
                          <div class="d-flex align-items-center gap-2">
                            <span class=" ">Admin</span>
                          </div>
                        </td>
                        <td class="border-bottom-0">
                          <h6 class=" rounded-3 badge bg-danger mb-0 fs-4">offline</h6>
                        </td>
                        <td class="border-bottom-0">
                          <a class="sidebar-link" href="./account.php" aria-expanded="false">
                            <span>
                              <i class="fs-6 text-black ti ti-edit"></i>
                            </span>
                          </a>
                        </td>
                      </tr> 
                      <tr>
                        <td class="border-bottom-0"><h6 class="fw-semibold mb-0">2</h6></td>
                        <td class="border-bottom-0">
                            <h6 class="fw-semibold mb-1">Andrew McDownland</h6>
                             <span class="fw-normal">Project Manager</span>                           
                        </td>
                        <td class="border-bottom-0">
                          <p class="mb-0 fw-normal">Real Homes WP Theme</p>
                        </td>
                        <td class="border-bottom-0">
                          <div class="d-flex align-items-center gap-2">
                            <span class="">Trainer</span>
                          </div>
                        </td>
                        <td class="border-bottom-0">
                          <h6 class="badge rounded-3 bg-danger mb-0 fs-4">offline</h6>
                        </td>
                        <td class="border-bottom-0">
                          <a class="sidebar-link" href="./account.php" aria-expanded="false">
                            <span>
                              <i class="fs-6 text-black ti ti-edit"></i>
                            </span>
                          </a>
                        </td>
                      </tr> 
                      <tr>
                        <td class="border-bottom-0"><h6 class="fw-semibold mb-0">3</h6></td>
                        <td class="border-bottom-0">
                            <h6 class="fw-semibold mb-1">Christopher Jamil</h6>
                             <span class="fw-normal">Project Manager</span>                           --
                        </td>
                        <td class="border-bottom-0">
                          <p class="mb-0 fw-normal">MedicalPro WP Theme</p>
                        </td>
                        <td class="border-bottom-0">
                          <div class="d-flex align-items-center gap-2">
                            <span class="">Trainer</span>
                          </div>
                        </td>
                        <td class="border-bottom-0">
                          <h6 class="badge rounded-3 bg-success mb-0 fs-4">online</h6>
                        </td>
                        <td class="border-bottom-0">
                          <a class="sidebar-link" href="./account.php" aria-expanded="false">
                            <span>
                              <i class="fs-6 text-black ti ti-edit"></i>
                            </span>
                          </a>
                        </td>
                      </tr>      
                      <tr>
                        <td class="border-bottom-0"><h6 class="fw-semibold mb-0">4</h6></td>
                        <td class="border-bottom-0">
                            <h6 class="fw-semibold mb-1">Nirav Joshi</h6>
                             <span class="fw-normal">Frontend Engineer</span>                           --
                        </td>
                        <td class="border-bottom-0">
                          <p class="mb-0 fw-normal">Hosting Press HTML</p>
                        </td>
                        <td class="border-bottom-0">
                          <div class="d-flex align-items-center gap-2">
                            <span class="">Client</span>
                          </div>
                        </td>
                        <td class="border-bottom-0">
                          <h6 class="bg-success rounded-3 badge mb-0 fs-4">online</h6>
                        </td>
                        <td class="border-bottom-0">
                          <a class="sidebar-link" href="./account.php" aria-expanded="false">
                            <span>
                              <i class="fs-6 text-black ti ti-edit"></i>
                            </span>
                          </a>
                        </td>
                      </tr>                       
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div> -->
            <!-- <h5 class="card-title fw-semibold mb-4">Sample Page</h5>
            <p class="mb-0">This is a sample page </p> -->
          <!-- </div>
        </div> -->
      </div>
    </div>
  </div>
  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/sidebarmenu.js"></script>
  <script src="../assets/js/app.min.js"></script>
  <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
  <script src="../assets/js/user/userManagement.js"></script>

  <script src="../assets/js/counts/clientCount.js"></script>
  <script src="../assets/js/counts/trainerCount.js"></script>
  <script src="../assets/js/counts/userCount.js"></script>
</body>

</html>