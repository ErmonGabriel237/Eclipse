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
  header('Location: ../authentication-login.php');
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
  <link rel="shortcut icon" type="image/png" href="../../assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="../../assets/css/styles.min.css" />
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
                  <i class="ti ti-tag"></i>
                </span>
                <span class="hide-menu">Category</span>
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
            <li class="sidebar-item">
              <a class="sidebar-link" href="./account.php" aria-expanded="false">
                <span>
                  <i class="ti ti-clipboard"></i>
                </span>
                <span class="hide-menu">Report</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="./chats.php" aria-expanded="false">
                <span>
                  <i class="ti ti-message"></i>
                </span>
                <span class="hide-menu">Discussion</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="./account.php" aria-expanded="false">
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
              <a href="" target="_blank" class="btn btn-primary"><?php echo $_SESSION['username']; ?></a>
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
                    <a href="../../server/logout.php" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
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
          <div class="card-body">
            <div class="row">
              <!-- Users List -->
              <div class="col-md-4 border-end">
                <h4 class="mb-4">Conversations</h4>
                <div class="list-group" id="usersList">
                  <!-- Users will be loaded here -->
                </div>
              </div>
              <!-- Chat Messages -->
              <div class="col-md-8">
                <div id="chatHeader" class="mb-4 d-none">
                  <h4>Chat with <span id="selectedUserName"></span></h4>
                </div>
                <div id="messageContainer" class="overflow-auto" style="height: 400px;">
                  <!-- Messages will be loaded here -->
                </div>
                <div id="messageForm" class="mt-3 d-none">
                  <form id="sendMessageForm" method="POST">
                    <div class="input-group">
                      <input type="text" id="messageInput" class="form-control" placeholder="Type your message...">
                      <button class="btn btn-primary" type="submit" >Send</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
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
  $(document).ready(function() {
      loadUsers();
      
      // Handle message form submission
      $('#sendMessageForm').on('submit', function(e) {
          e.preventDefault();
          sendMessage();
      });
  });
  
  function loadUsers() {
      $.ajax({
          url: './get_users.php',
          method: 'GET',
          success: function(response) {
              $('#usersList').html(response);
          }
      });
  }
  
  function loadChat(userId, userName) {
      $('#selectedUserName').text(userName);
      $('#chatHeader, #messageForm').removeClass('d-none');
      
      $.ajax({
          url: './get_messages.php',
          method: 'GET',
          data: { user_id: userId },
          success: function(response) {
              $('#messageContainer').html(response);
              scrollToBottom();
          }
      });
  }
  
  function sendMessage() {
      const message = $('#messageInput').val();
      const recipientId = userId;
      console.log(recipientId);
            
      if (!message.trim()) return;
      
      $.ajax({
          url: './send_message.php',
          method: 'POST',
          data: {
              recipient_id: recipientId,
              message: message,
              csrf_token: $('meta[name="csrf-token"]').attr('content')
          },
          success: function(response) {
              $('#messageInput').val('');
              loadChat(recipientId, $('#selectedUserName').text());
          }
      });
  }
  
  function scrollToBottom() {
      const container = document.getElementById('messageContainer');
      container.scrollTop = container.scrollHeight;
  }
  </script>
</body>

</html>