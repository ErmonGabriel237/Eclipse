document.addEventListener('DOMContentLoaded', function() {
    // Function to fetch user count
    function fetchCount() {
        const countDisplay = document.getElementById('clientCount');
        const errorElement = document.getElementById('errorClientMessage');
        
        // Create an XHR object
        // Fetch data using the modern fetch API
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        fetch('../server/count/clientCount.php', {
            method: 'GET',
            headers: csrfToken ? { 'X-CSRF-Token': csrfToken } : {}
        })
        .then(response => {
            if (response.ok) {
                countDisplay.textContent = response.count;
                return response.json();
            } else if (response.status === 401) {
                throw new Error('Please log in to view this information');
            } else if (response.status === 403) {
                throw new Error('You do not have permission to view this data');
            } else {
                throw new Error('Error fetching data');
            }
        })
        .then(data => {
            countDisplay.innerHTML = data.count;
            errorElement.textContent = '';
        })
        .catch(error => {
            errorElement.textContent = error.message;
            countDisplay.innerHTML = '-';
            console.error('Fetch error:', error);
        });
    }
    
    // Fetch data immediately when page loads
    fetchCount();
    
    // Optional: Set up an interval to refresh periodically (e.g., every 60 seconds)
    setInterval(fetchCount, 60000);
});