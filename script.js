// Sidebar toggle functionality
document.addEventListener('DOMContentLoaded', function() {
    const toggleSidebar = document.querySelector('.toggle-sidebar');
    const sidebar = document.getElementById('sidebar');
    const content = document.getElementById('content');

    // Check localStorage for sidebar state
    const sidebarState = localStorage.getItem('sidebarCollapsed');
    if (sidebarState === 'true') {
        sidebar.classList.add('collapsed');
        content.classList.add('expanded');
    } else if (sidebarState === 'false') {
        sidebar.classList.remove('collapsed');
        content.classList.remove('expanded');
    }

    toggleSidebar.addEventListener('click', function() {
        sidebar.classList.toggle('collapsed');
        content.classList.toggle('expanded');
        // Save state to localStorage
        localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
    });

    // Highlight active menu item based on current page
    function setActiveMenuItem() {
        // Get current page URL
        const path = window.location.pathname;
        const currentPage = path.split('/').pop().split('.')[0];
        
        // Remove active class from all menu items
        document.querySelectorAll('.side-menu-top li, .side-menu-bottom li').forEach(item => {
            item.classList.remove('active');
        });
        
        // Determine which menu item to highlight
        let menuItemSelector = '';
        
        // Check if we're on edit-product.php (but want to highlight view-products)
        if (path.includes('edit-product.php')) {
            menuItemSelector = '.side-menu-top li:nth-child(3)'; // View Products
        } else {
            // Map page names to menu items
            const pageToMenuItem = {
                'dashboard': '.side-menu-top li:nth-child(1)',
                'users': '.side-menu-top li:nth-child(2)',
                'view-products': '.side-menu-top li:nth-child(3)',
                'add-products': '.side-menu-top li:nth-child(4)',
                'Messages': '.side-menu-top li:nth-child(5)',
                'orders': '.side-menu-top li:nth-child(6)',
                'archive': '.side-menu-bottom li:nth-child(1)',
                'logout': '.side-menu-bottom li:nth-child(2)'
            };
            
            menuItemSelector = pageToMenuItem[currentPage] || '';
        }
        
        // Add active class to the determined menu item
        if (menuItemSelector) {
            document.querySelector(menuItemSelector).classList.add('active');
        }
    }

    // Call the function
    setActiveMenuItem();

    // Initialize Chart.js (only if element exists)
    const chartElement = document.getElementById('myChart');
    if (chartElement) {
        const ctx = chartElement.getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Sales',
                    data: [1200, 1900, 1500, 2000, 2200, 3000, 2800, 2500, 3000, 3500, 4000, 4500],
                    backgroundColor: 'rgba(76, 175, 80, 0.2)',
                    borderColor: 'rgba(76, 175, 80, 1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    // Responsive behavior for mobile
    function handleResize() {
        if (window.innerWidth < 768) {
            sidebar.classList.add('collapsed');
            content.classList.add('expanded');
            localStorage.setItem('sidebarCollapsed', true);
        } else {
            // Only restore user preference if not on mobile
            const savedState = localStorage.getItem('sidebarCollapsed');
            if (savedState === 'true') {
                sidebar.classList.add('collapsed');
                content.classList.add('expanded');
            } else if (savedState === 'false') {
                sidebar.classList.remove('collapsed');
                content.classList.remove('expanded');
            }
        }
    }

    window.addEventListener('resize', handleResize);
    handleResize(); // Call once on load
});