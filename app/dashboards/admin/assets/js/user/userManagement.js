document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const usersTableBody = document.getElementById('usersTableBody');
    const searchInput = document.getElementById('searchInput');
    const searchBtn = document.getElementById('searchBtn');
    const roleFilter = document.getElementById('roleFilter');
    const statusFilter = document.getElementById('statusFilter');
    const pagination = document.getElementById('pagination');
    const loadingOverlay = document.getElementById('loadingOverlay');
    const noResults = document.getElementById('noResults');
    
    // Current page and search parameters
    let currentPage = 1;
    let searchTerm = '';
    let roleValue = '';
    let statusValue = '';
    
    // Load users on page load
    loadUsers();
    
    // Event listeners
    searchBtn.addEventListener('click', function() {
        searchTerm = searchInput.value.trim();
        currentPage = 1;
        loadUsers();
    });
    
    searchInput.addEventListener('keyup', function(event) {
        if (event.key === 'Enter') {
            searchTerm = searchInput.value.trim();
            currentPage = 1;
            loadUsers();
        }
    });
    
    roleFilter.addEventListener('change', function() {
        roleValue = this.value;
        currentPage = 1;
        loadUsers();
    });
    
    statusFilter.addEventListener('change', function() {
        statusValue = this.value;
        currentPage = 1;
        loadUsers();
    });
    
    // Function to load users
    function loadUsers() {
        // Show loading overlay
        loadingOverlay.classList.remove('hidden');
        noResults.classList.add('hidden');
        
        // Create form data for the request
        const formData = new FormData();
        formData.append('page', currentPage);
        formData.append('search', searchTerm);
        formData.append('role', roleValue);
        formData.append('status', statusValue);
        
        // Get CSRF token
        // const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Create and send AJAX request
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../server/user/userManagement.php', true);
        // xhr.setRequestHeader('X-CSRF-Token', csrfToken);
        
        xhr.onload = function() {
            // Hide loading overlay
            loadingOverlay.classList.add('hidden');
            
            if (xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    
                    if (response.status === 'success') {
                        // Render users
                        renderUsers(response.users);
                        
                        // Render pagination
                        renderPagination(response.totalPages);
                        
                        // Show/hide no results message
                        if (response.users.length === 0) {
                            noResults.classList.remove('hidden');
                        } else {
                            noResults.classList.add('hidden');
                        }
                    } else {
                        console.error('Error fetching users:', response.message);
                        alert('Error fetching users: ' + response.message);
                    }
                } catch (e) {
                    console.error('Error parsing response:', e);
                    alert('Error processing server response');
                }
            } else {
                console.error('Request failed with status:', xhr.status);
                alert('Error communicating with server');
            }
        };
        
        xhr.onerror = function() {
            loadingOverlay.classList.add('hidden');
            console.error('Request failed');
            alert('Network error occurred');
        };
        
        xhr.send(formData);
    }
    
    // Function to render users in the table
    function renderUsers(users) {
        usersTableBody.innerHTML = '';
        
        users.forEach(user => {
            const row = document.createElement('tr');
            
            const statusBadgeClass = user.status == 'online' ? 'bg-success' : 'bg-danger';
            const statusText = user.status == 'online' ? 'Active' : 'Inactive';
            
            row.innerHTML = `
                <td>${user.userId}</td>
                <td><img src="../assets/images/profile/${user.avatar || 'https://via.placeholder.com/40'}" class="user-avatar" alt="${user.username}"></td>
                <td>${user.username}</td>
                <td>${user.email}</td>
                <td><span class="badge bg-primary">${user.userType}</span></td>
                <td><span class="badge ${statusBadgeClass}">${statusText}</span></td>
                <td>${user.last_login || 'Never'}</td>
                <td>
                    <button class="btn btn-sm btn-outline-info" onclick="viewUser(${user.userId})">
                        <i class="ti ti-eye"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-primary" onclick="editUser(${user.userId})">
                        <i class="ti ti-pencil"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger" onclick="deleteUser(${user.userId})">
                        <i class="ti ti-trash"></i>
                    </button>
                </td>
            `;
            
            usersTableBody.appendChild(row);
        });
    }
    
    // Function to render pagination links
    function renderPagination(totalPages) {
        pagination.innerHTML = '';
        
        // Previous button
        const prevLi = document.createElement('li');
        prevLi.classList.add('page-item');
        if (currentPage === 1) prevLi.classList.add('disabled');
        prevLi.innerHTML = `<a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>`;
        prevLi.addEventListener('click', function(e) {
            e.preventDefault();
            if (currentPage > 1) {
                currentPage--;
                loadUsers();
            }
        });
        pagination.appendChild(prevLi);
        
        // Page numbers
        for (let i = 1; i <= totalPages; i++) {
            const pageLi = document.createElement('li');
            pageLi.classList.add('page-item');
            if (i === currentPage) pageLi.classList.add('active');
            pageLi.innerHTML = `<a class="page-link" href="#">${i}</a>`;
            pageLi.addEventListener('click', function(e) {
                e.preventDefault();
                currentPage = i;
                loadUsers();
            });
            pagination.appendChild(pageLi);
        }
        
        // Next button
        const nextLi = document.createElement('li');
        nextLi.classList.add('page-item');
        if (currentPage === totalPages) nextLi.classList.add('disabled');
        nextLi.innerHTML = `<a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a>`;
        nextLi.addEventListener('click', function(e) {
            e.preventDefault();
            if (currentPage < totalPages) {
                currentPage++;
                loadUsers();
            }
        });
        pagination.appendChild(nextLi);
    }
});

// These functions would be implemented elsewhere
function viewUser(id) {
    // alert('View user: ' + id);
    // Implement view user functionality
    window.location.href = './user/userDetails.php?id=' + id;
}

function editUser(id) {
    alert('Edit user: ' + id);
    // Implement edit user functionality
}

function deleteUser(id) {
    if (confirm('Are you sure you want to delete this user?')) {
        alert('Delete user: ' + id);
        // Implement delete user functionality
    }
}