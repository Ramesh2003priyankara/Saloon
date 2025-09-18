// DOM Content Loaded
document.addEventListener('DOMContentLoaded', function() {
    // Initialize the application
    initApp();
});

// Initialize Application
function initApp() {
    // Initialize navigation
    initNavigation();
    
    // Initialize modals
    initModals();
    
    // Initialize charts
    initCharts();
    
    // Initialize form handlers
    initFormHandlers();
    
    // Initialize search functionality
    initSearch();
    
    // Initialize settings tabs
    initSettingsTabs();
}

// Navigation Functionality
function initNavigation() {
    const navLinks = document.querySelectorAll('.sidebar a');
    const contentSections = document.querySelectorAll('.content-section');
    
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove active class from all links and sections
            navLinks.forEach(l => l.parentElement.classList.remove('active'));
            contentSections.forEach(section => section.classList.remove('active'));
            
            // Add active class to clicked link
            this.parentElement.classList.add('active');
            
            // Show corresponding section
            const targetSection = this.getAttribute('data-section');
            const section = document.getElementById(targetSection);
            if (section) {
                section.classList.add('active');
            }
        });
    });
}

// Modal Functionality
function initModals() {
    // Add Book Modal
    const addBookBtn = document.getElementById('addBookBtn');
    const addBookModal = document.getElementById('addBookModal');
    
    if (addBookBtn && addBookModal) {
        addBookBtn.addEventListener('click', () => {
            addBookModal.style.display = 'block';
        });
    }
    
    // New Sale Modal
    const newSaleBtn = document.getElementById('newSaleBtn');
    const newSaleModal = document.getElementById('newSaleModal');
    
    if (newSaleBtn && newSaleModal) {
        newSaleBtn.addEventListener('click', () => {
            newSaleModal.style.display = 'block';
        });
    }
    
    // Close modals
    const closeButtons = document.querySelectorAll('.close, .cancel-btn');
    closeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const modal = this.closest('.modal');
            if (modal) {
                modal.style.display = 'none';
            }
        });
    });
    
    // Close modal when clicking outside
    window.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal')) {
            e.target.style.display = 'none';
        }
    });
}

// Chart Initialization
function initCharts() {
    // Sales Chart
    const salesChartCtx = document.getElementById('salesChart');
    if (salesChartCtx) {
        new Chart(salesChartCtx, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Sales',
                    data: [12, 19, 15, 25, 22, 30, 28],
                    borderColor: '#3498db',
                    backgroundColor: 'rgba(52, 152, 219, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }
    
    // Category Chart
    const categoryChartCtx = document.getElementById('categoryChart');
    if (categoryChartCtx) {
        new Chart(categoryChartCtx, {
            type: 'doughnut',
            data: {
                labels: ['Fiction', 'Education', 'Non-Fiction', 'Children'],
                datasets: [{
                    data: [35, 25, 20, 20],
                    backgroundColor: [
                        '#3498db',
                        '#e74c3c',
                        '#f39c12',
                        '#27ae60'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }
    
    // Report Chart
    const reportChartCtx = document.getElementById('reportChart');
    if (reportChartCtx) {
        new Chart(reportChartCtx, {
            type: 'bar',
            data: {
                labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                datasets: [{
                    label: 'Sales',
                    data: [45000, 52000, 48000, 61000],
                    backgroundColor: 'rgba(102, 126, 234, 0.8)',
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }
}

// Form Handlers
function initFormHandlers() {
    // Add Book Form
    const addBookForm = document.getElementById('addBookForm');
    if (addBookForm) {
        addBookForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Show success message
            showMessage('Book added successfully!', 'success');
            
            // Close modal
            const modal = this.closest('.modal');
            if (modal) {
                modal.style.display = 'none';
            }
            
            // Reset form
            this.reset();
        });
    }
    
    // New Sale Form
    const newSaleForm = document.getElementById('newSaleForm');
    if (newSaleForm) {
        newSaleForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Show success message
            showMessage('Sale completed successfully!', 'success');
            
            // Close modal
            const modal = this.closest('.modal');
            if (modal) {
                modal.style.display = 'none';
            }
            
            // Reset form
            this.reset();
        });
    }
    
    // Settings Forms
    const settingsForms = document.querySelectorAll('.settings-panel form');
    settingsForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            showMessage('Settings saved successfully!', 'success');
        });
    });
}

// Search Functionality
function initSearch() {
    const searchInputs = document.querySelectorAll('.search-box input');
    
    searchInputs.forEach(input => {
        input.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const table = this.closest('.content-section').querySelector('.data-table');
            
            if (table) {
                const rows = table.querySelectorAll('tbody tr');
                
                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    if (text.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }
        });
    });
}

// Settings Tabs
function initSettingsTabs() {
    const tabButtons = document.querySelectorAll('.tab-btn');
    const settingsPanels = document.querySelectorAll('.settings-panel');
    
    tabButtons.forEach((button, index) => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons and panels
            tabButtons.forEach(btn => btn.classList.remove('active'));
            settingsPanels.forEach(panel => panel.classList.remove('active'));
            
            // Add active class to clicked button and corresponding panel
            this.classList.add('active');
            if (settingsPanels[index]) {
                settingsPanels[index].classList.add('active');
            }
        });
    });
}

// Report Options
function initReportOptions() {
    const reportOptions = document.querySelectorAll('.report-option');
    
    reportOptions.forEach(option => {
        option.addEventListener('click', function() {
            reportOptions.forEach(opt => opt.classList.remove('active'));
            this.classList.add('active');
        });
    });
}

// Quick Date Selection
function initQuickDateSelection() {
    const quickSelectButtons = document.querySelectorAll('.quick-select button');
    
    quickSelectButtons.forEach(button => {
        button.addEventListener('click', function() {
            const today = new Date();
            const fromDate = document.getElementById('fromDate');
            const toDate = document.getElementById('toDate');
            
            switch(this.textContent) {
                case 'Today':
                    fromDate.value = today.toISOString().split('T')[0];
                    toDate.value = today.toISOString().split('T')[0];
                    break;
                case 'This Week':
                    const weekStart = new Date(today.setDate(today.getDate() - today.getDay()));
                    const weekEnd = new Date(today.setDate(today.getDate() - today.getDay() + 6));
                    fromDate.value = weekStart.toISOString().split('T')[0];
                    toDate.value = weekEnd.toISOString().split('T')[0];
                    break;
                case 'This Month':
                    const monthStart = new Date(today.getFullYear(), today.getMonth(), 1);
                    const monthEnd = new Date(today.getFullYear(), today.getMonth() + 1, 0);
                    fromDate.value = monthStart.toISOString().split('T')[0];
                    toDate.value = monthEnd.toISOString().split('T')[0];
                    break;
                case 'This Year':
                    const yearStart = new Date(today.getFullYear(), 0, 1);
                    const yearEnd = new Date(today.getFullYear(), 11, 31);
                    fromDate.value = yearStart.toISOString().split('T')[0];
                    toDate.value = yearEnd.toISOString().split('T')[0];
                    break;
            }
        });
    });
}

// Table Row Actions
function initTableActions() {
    // Edit buttons
    const editButtons = document.querySelectorAll('.btn-icon.edit');
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const row = this.closest('tr');
            const title = row.cells[1]?.textContent || 'Item';
            showMessage(`Editing ${title}...`, 'info');
        });
    });
    
    // Delete buttons
    const deleteButtons = document.querySelectorAll('.btn-icon.delete');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const row = this.closest('tr');
            const title = row.cells[1]?.textContent || 'Item';
            
            if (confirm(`Are you sure you want to delete ${title}?`)) {
                row.remove();
                showMessage(`${title} deleted successfully!`, 'success');
            }
        });
    });
    
    // View buttons
    const viewButtons = document.querySelectorAll('.btn-icon.view');
    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            const row = this.closest('tr');
            const title = row.cells[0]?.textContent || 'Item';
            showMessage(`Viewing details for ${title}...`, 'info');
        });
    });
    
    // Print buttons
    const printButtons = document.querySelectorAll('.btn-icon.print');
    printButtons.forEach(button => {
        button.addEventListener('click', function() {
            showMessage('Printing...', 'info');
            setTimeout(() => {
                showMessage('Print job sent successfully!', 'success');
            }, 1000);
        });
    });
}

// Sale Form Calculations
function initSaleCalculations() {
    const saleItems = document.querySelectorAll('.sale-items-table input[type="number"]');
    
    saleItems.forEach(input => {
        input.addEventListener('input', calculateSaleTotal);
    });
    
    // Amount paid calculation
    const amountPaidInput = document.querySelector('input[type="number"][value="4320"]');
    if (amountPaidInput) {
        amountPaidInput.addEventListener('input', calculateChange);
    }
}

function calculateSaleTotal() {
    const rows = document.querySelectorAll('.sale-items-table tbody tr');
    let subtotal = 0;
    
    rows.forEach(row => {
        const priceCell = row.cells[1]?.textContent;
        const quantityInput = row.querySelector('input[type="number"]');
        const totalCell = row.cells[3];
        
        if (priceCell && quantityInput && totalCell) {
            const price = parseFloat(priceCell.replace(/[^\d.]/g, ''));
            const quantity = parseInt(quantityInput.value) || 0;
            const total = price * quantity;
            
            totalCell.textContent = `LKR ${total.toLocaleString()}`;
            subtotal += total;
        }
    });
    
    // Update summary
    const subtotalElement = document.querySelector('.summary-row:first-child span:last-child');
    if (subtotalElement) {
        subtotalElement.textContent = `LKR ${subtotal.toLocaleString()}`;
    }
    
    const tax = subtotal * 0.08;
    const total = subtotal + tax;
    
    const taxElement = document.querySelector('.summary-row:nth-child(2) span:last-child');
    const totalElement = document.querySelector('.summary-row.total span:last-child');
    
    if (taxElement) taxElement.textContent = `LKR ${tax.toLocaleString()}`;
    if (totalElement) totalElement.textContent = `LKR ${total.toLocaleString()}`;
    
    return total;
}

function calculateChange() {
    const total = calculateSaleTotal();
    const amountPaid = parseFloat(this.value) || 0;
    const change = amountPaid - total;
    
    const changeElement = document.querySelector('.change-amount span');
    if (changeElement) {
        changeElement.textContent = `Change: LKR ${change.toLocaleString()}`;
    }
}

// Message Display
function showMessage(message, type = 'info') {
    // Remove existing messages
    const existingMessages = document.querySelectorAll('.message');
    existingMessages.forEach(msg => msg.remove());
    
    // Create new message
    const messageElement = document.createElement('div');
    messageElement.className = `message ${type}`;
    messageElement.textContent = message;
    
    // Add to main content
    const mainContent = document.querySelector('.main-content');
    if (mainContent) {
        mainContent.insertBefore(messageElement, mainContent.firstChild);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            messageElement.remove();
        }, 5000);
    }
}

// Initialize additional functionality
document.addEventListener('DOMContentLoaded', function() {
    initReportOptions();
    initQuickDateSelection();
    initTableActions();
    initSaleCalculations();
});

// Export functions for global access
window.bookshopApp = {
    showMessage,
    calculateSaleTotal,
    calculateChange
}; 