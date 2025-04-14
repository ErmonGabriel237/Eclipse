<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in and has admin privileges
if (!isset($_SESSION['user_id']) || $_SESSION['userType'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Generate CSRF token if not exists
// if (!isset($_SESSION['csrf_token'])) {
//     $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
// }

// Check if user ID is provided in the URL
$user_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($user_id <= 0) {
    header('Location: users.php');
    exit;
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Fitness - #<?php echo $user_id;?> User Profile</title>
  <link rel="shortcut icon" type="image/png" href="../../assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="../../assets/css/styles.min.css" />
</head>

<style>
  .profile-header {
    background-color: #f8f9fa;
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 20px;
  }

  .user-avatar {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
    border: 5px solid #fff;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  }

  .profile-section {
    background-color: #fff;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
  }

  .section-title {
    border-bottom: 2px solid #f1f1f1;
    padding-bottom: 10px;
    margin-bottom: 20px;
  }

  .loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.8);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
  }

  .stat-card {
    border-left: 5px solid #007bff;
    background-color: #f8f9fa;
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
            <img src="../../assets/images/logos/dark-logo.svg" width="180" alt="" />
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
              <a class="sidebar-link" href="../index.php" aria-expanded="false">
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
              <a class="sidebar-link" href="../account.php" aria-expanded="false">
                <span>
                  <i class="ti ti-users"></i>
                </span>
                <span class="hide-menu">Accounts</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="./account.php" aria-expanded="false">
                <span>
                  <i class="ti ti-book"></i>
                </span>
                <span class="hide-menu">Courses</span>
              </a>
            </li>
            <!-- <li class="sidebar-item">
              <a class="sidebar-link" href="./ui-buttons.html" aria-expanded="false">
                <span>
                  <i class="ti ti-article"></i>
                </span>
                <span class="hide-menu">Buttons</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="./ui-alerts.html" aria-expanded="false">
                <span>
                  <i class="ti ti-alert-circle"></i>
                </span>
                <span class="hide-menu">Alerts</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="./ui-card.html" aria-expanded="false">
                <span>
                  <i class="ti ti-cards"></i>
                </span>
                <span class="hide-menu">Card</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="./ui-forms.html" aria-expanded="false">
                <span>
                  <i class="ti ti-file-description"></i>
                </span>
                <span class="hide-menu">Forms</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="./ui-typography.html" aria-expanded="false">
                <span>
                  <i class="ti ti-typography"></i>
                </span>
                <span class="hide-menu">Typography</span>
              </a>
            </li>
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">AUTH</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="./authentication-login.html" aria-expanded="false">
                <span>
                  <i class="ti ti-login"></i>
                </span>
                <span class="hide-menu">Login</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="./authentication-register.html" aria-expanded="false">
                <span>
                  <i class="ti ti-user-plus"></i>
                </span>
                <span class="hide-menu">Register</span>
              </a>
            </li>
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">EXTRA</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="./icon-tabler.html" aria-expanded="false">
                <span>
                  <i class="ti ti-mood-happy"></i>
                </span>
                <span class="hide-menu">Icons</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="./sample-page.html" aria-expanded="false">
                <span>
                  <i class="ti ti-aperture"></i>
                </span>
                <span class="hide-menu">Sample Page</span>
              </a>
            </li> -->
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
              <a href="" class="btn btn-primary"><?php echo $_SESSION['username']; ?></a>
              <li class="nav-item dropdown">
                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <img src="../../assets/images/profile/user-1.jpg" alt="" width="35" height="35" class="rounded-circle">
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
        <div class="card">
          <div id="loadingOverlay" class="loading-overlay">
            <div class="spinner-border text-primary" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
          </div>

          <div class="container mt-4">
            <!-- Navigation breadcrumb -->
            <!-- <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="users.php">Users</a></li>
                <li class="breadcrumb-item active" aria-current="page">User Profile</li>
              </ol>
            </nav> -->

            <!-- Back button -->
            <div class="mb-4">
              <a href="../account.php" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back to Users
              </a>
            </div>

            <!-- User profile information will be loaded here -->
            <div id="userProfileContainer">
              <!-- Content will be loaded via AJAX -->
            </div>

            <!-- Action buttons -->
            <div class="row mb-4">
              <div class="col-12">
                <button id="editUserBtn" class="btn btn-primary me-2">
                  <i class="bi bi-pencil"></i> Edit User
                </button>
                <button id="resetPasswordBtn" class="btn btn-warning me-2">
                  <i class="bi bi-key"></i> Reset Password
                </button>
                <button id="toggleStatusBtn" class="btn btn-info me-2">
                  <i class="bi bi-toggle-on"></i> <span id="toggleStatusText">Change Status</span>
                </button>
                <button id="deleteUserBtn" class="btn btn-danger">
                  <i class="bi bi-trash"></i> Delete User
                </button>
              </div>
            </div>
          </div>

          <!-- Bootstrap JS Bundle with Popper -->
          <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        </div>
      </div>
    </div>
  </div>
  <script src="../../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/js/sidebarmenu.js"></script>
  <script src="../../assets/js/app.min.js"></script>
  <script src="../../assets/libs/simplebar/dist/simplebar.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Get user ID from URL
      const user_Id = <?php echo $user_id; ?>;
      console.log(user_Id);

      const userProfileContainer = document.getElementById('userProfileContainer');
      const loadingOverlay = document.getElementById('loadingOverlay');
      const editUserBtn = document.getElementById('editUserBtn');
      const resetPasswordBtn = document.getElementById('resetPasswordBtn');
      const toggleStatusBtn = document.getElementById('toggleStatusBtn');
      const toggleStatusText = document.getElementById('toggleStatusText');
      const deleteUserBtn = document.getElementById('deleteUserBtn');

      // Store user data globally
      let userData = null;

      // Load user data
      loadUserProfile(user_Id);

      // Function to load user profile
      function loadUserProfile(user_Id) {
        // Show loading overlay
        loadingOverlay.style.display = 'flex';

        // Create form data
        const formData = new FormData();
        formData.append('user_id', user_Id);

        // Get CSRF token
        // const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Create and send AJAX request
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../../server/user/getUser.php', true);
        // xhr.setRequestHeader('X-CSRF-Token', csrfToken);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

        xhr.onload = function() {
          // Hide loading overlay
          loadingOverlay.style.display = 'none';

          if (xhr.status === 200) {
            try {
              let response;
              try {
                response = JSON.parse(xhr.responseText);
              } catch (e) {
                console.error('Invalid JSON response:', e);
                userProfileContainer.innerHTML = `
                                <div class="alert alert-danger">
                                    <i class="ti ti-exclamation-triangle"></i> 
                                    Error: Invalid server response format
                                </div>
                            `;
                return;
              }

              if (response.status === 'success') {
                // Store user data
                userData = response.user;

                // Render user profile
                renderUserProfile(userData);

                // Update button states
                updateButtonStates(userData);
              } else {
                console.error('Error fetching user profile:', response.message);
                userProfileContainer.innerHTML = `
                                <div class="alert alert-danger">
                                    <i class="bi bi-exclamation-triangle"></i> 
                                    Error: ${response.message || 'Could not load user profile'}
                                </div>
                            `;
              }
            } catch (e) {
              console.error('Error parsing response:', e);
              userProfileContainer.innerHTML = `
                            <div class="alert alert-danger">
                                <i class="bi bi-exclamation-triangle"></i> 
                                Error processing server response
                            </div>
                        `;
            }
          } else {
            console.error('Request failed with status:', xhr.status);
            userProfileContainer.innerHTML = `
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-triangle"></i> 
                            Error communicating with server
                        </div>
                    `;
          }
        };

        xhr.onerror = function() {
          loadingOverlay.style.display = 'none';
          console.error('Request failed');
          userProfileContainer.innerHTML = `
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle"></i> 
                        Network error occurred
                    </div>
                `;
        };

        xhr.send(formData);
      }

      // Function to render user profile
      function renderUserProfile(user) {
        // Format dates
        const createdDate = new Date(user.created_at).toLocaleDateString('en-US', {
          year: 'numeric',
          month: 'long',
          day: 'numeric',
          hour: '2-digit',
          minute: '2-digit'
        });

        const lastLoginDate = user.last_login ? new Date(user.last_login).toLocaleDateString('en-US', {
          year: 'numeric',
          month: 'long',
          day: 'numeric',
          hour: '2-digit',
          minute: '2-digit'
        }) : 'Never';

        // Create user profile HTML
        const html = `
                <div class="profile-header">
                    <div class="row align-items-center">
                        <div class="col-md-2 text-center">
                            <img src="../../assets/images/profile/${user.avatar || 'https://via.placeholder.com/150'}" class="user-avatar" alt="${user.username}">
                        </div>
                        <div class="col-md-10">
                            <h1>${user.username}</h1>
                            <p class="lead">${user.email}</p>
                            <div class="d-flex">
                                <span class="badge bg-${user.status == 'online' ? 'success' : 'danger'} me-2">
                                    ${user.status == 'online' ? 'Active' : 'Inactive'}
                                </span>
                                <span class="badge bg-primary">${user.userType.charAt(0).toUpperCase() + user.userType.slice(1)}</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card stat-card">
                            <div class="card-body">
                                <h5 class="card-title">User ID</h5>
                                <p class="card-text">#${user.userId}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card">
                            <div class="card-body">
                                <h5 class="card-title">Last Login</h5>
                                <p class="card-text">${lastLoginDate}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card">
                            <div class="card-body">
                                <h5 class="card-title">Account Created</h5>
                                <p class="card-text">${createdDate}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card">
                            <div class="card-body">
                                <h5 class="card-title">Login Count</h5>
                                <p class="card-text">${user.login_count || 0}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="profile-section">
                            <h3 class="section-title">Account Information</h3>
                            <div class="mb-3 row">
                                <label class="col-sm-4 col-form-label fw-bold">Full Name</label>
                                <div class="col-sm-8">
                                    <p class="form-control-plaintext">${user.username}</p>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-4 col-form-label fw-bold">Email</label>
                                <div class="col-sm-8">
                                    <p class="form-control-plaintext">${user.email}</p>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-4 col-form-label fw-bold">Role</label>
                                <div class="col-sm-8">
                                    <p class="form-control-plaintext">${user.userType.charAt(0).toUpperCase() + user.userType.slice(1)}</p>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-4 col-form-label fw-bold">Status</label>
                                <div class="col-sm-8">
                                    <p class="form-control-plaintext">${user.status == 'online' ? 'Active' : 'Inactive'}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="profile-section">
                            <h3 class="section-title">Activity Information</h3>
                            <div class="mb-3 row">
                                <label class="col-sm-4 col-form-label fw-bold">Account Created</label>
                                <div class="col-sm-8">
                                    <p class="form-control-plaintext">${createdDate}</p>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-4 col-form-label fw-bold">Last Login</label>
                                <div class="col-sm-8">
                                    <p class="form-control-plaintext">${lastLoginDate}</p>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-4 col-form-label fw-bold">Last IP Address</label>
                                <div class="col-sm-8">
                                    <p class="form-control-plaintext">${user.last_ip || 'N/A'}</p>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-4 col-form-label fw-bold">Login Count</label>
                                <div class="col-sm-8">
                                    <p class="form-control-plaintext">${user.login_count || 0}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="profile-section">
                    <h3 class="section-title">Additional Information</h3>
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label fw-bold">Notes</label>
                        <div class="col-sm-10">
                            <p class="form-control-plaintext">${user.notes || 'No notes available for this user.'}</p>
                        </div>
                    </div>
                </div>
            `;

        userProfileContainer.innerHTML = html;
      }

      // Function to update button states based on user data
      function updateButtonStates(user) {
        // Update toggle status button
        if (user.active == 1) {
          toggleStatusText.textContent = 'Deactivate User';
          toggleStatusBtn.classList.remove('btn-success');
          toggleStatusBtn.classList.add('btn-warning');
        } else {
          toggleStatusText.textContent = 'Activate User';
          toggleStatusBtn.classList.remove('btn-warning');
          toggleStatusBtn.classList.add('btn-success');
        }

        // Set up button click handlers
        editUserBtn.onclick = function() {
          window.location.href = './userUpdates.php?id=' + user.userId;
        };

        resetPasswordBtn.onclick = function() {
          if (confirm(`Are you sure you want to reset the password for ${user.username}?`)) {
            resetUserPassword(user.userId);
          }
        };

        toggleStatusBtn.onclick = function() {
          const newStatus = user.status == 'online' ? 'offline' : 'online';
          const statusText = newStatus == 'online' ? 'activate' : 'deactivate';
          if (confirm(`Are you sure you want to ${statusText} ${user.username}?`)) {
            toggleUserStatus(user.userId, newStatus);
          }
        };

        deleteUserBtn.onclick = function() {
          if (confirm(`Are you sure you want to delete ${user.username}? This action cannot be undone.`)) {
            deleteUser(user.userId);
          }
        };
      }

      // Function to reset user password
      function resetUserPassword(user_Id) {
        // Implement password reset functionality
        alert('Password reset functionality would go here');
      }

      // Function to toggle user status
      function toggleUserStatus(user_Id, newStatus) {
        // Implement status toggle functionality
        alert('Status toggle functionality would go here');
      }

      // Function to delete user
      function deleteUser(user_Id) {
        // Implement delete user functionality
        alert('Delete user functionality would go here');
      }
    });
  </script>
</body>

</html>