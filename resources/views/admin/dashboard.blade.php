
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Car Rental Dashboard</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .modal {
            transition: opacity 0.25s ease;
        }
        body.modal-active {
            overflow-x: hidden;
            overflow-y: visible !important;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen bg-gray-100">
        <!-- Sidebar -->
        <div class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64">
                <div class="flex flex-col h-0 flex-1 bg-white border-r border-gray-200">
                    <div class="flex items-center h-16 flex-shrink-0 px-4 bg-white border-b border-gray-200">
                        <h1 class="text-xl font-bold text-gray-900 flex items-center">
                            <i class="fas fa-car mr-2"></i>
                            Car Rental Admin
                        </h1>
                    </div>
                    {{-- <div class="flex-1 flex flex-col overflow-y-auto">
                        <nav class="flex-1 px-2 py-4 bg-white space-y-1">
                            <a href="#" class="bg-gray-100 text-gray-900 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                                <i class="fas fa-tachometer-alt mr-3 text-gray-500"></i>
                                Dashboard
                            </a>
                            <a href="#" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                                <i class="fas fa-car mr-3 text-gray-500"></i>
                                Cars
                            </a>
                            <a href="#" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                                <i class="fas fa-key mr-3 text-gray-500"></i>
                                Rentals
                            </a>
                            <a href="#" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                                <i class="fas fa-users mr-3 text-gray-500"></i>
                                Customers
                            </a>
                        </nav>
                    </div> --}}
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="flex flex-col w-0 flex-1 overflow-hidden">
            <div class="relative z-10 flex-shrink-0 flex h-16 bg-white border-b border-gray-200">
                <button id="sidebar-toggle" type="button" class="px-4 border-r border-gray-200 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 md:hidden">
                    <span class="sr-only">Open sidebar</span>
                    <i class="fas fa-bars h-6 w-6"></i>
                </button>
                <div class="flex-1 px-4 flex justify-between">
                    <div class="flex-1 flex">
                        <form id="search-form" class="w-full flex md:ml-0">
                            <label for="search-field" class="sr-only">Search</label>
                            <div class="relative w-full text-gray-400 focus-within:text-gray-600">
                                <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none">
                                    <i class="fas fa-search h-5 w-5 ml-3"></i>
                                </div>
                                <input id="search-field" class="block w-full h-full pl-10 pr-3 py-2 border-transparent text-gray-900 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-0 focus:border-transparent sm:text-sm" placeholder="Search cars" type="search" name="search">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <main class="flex-1 relative overflow-y-auto focus:outline-none">
                <div class="py-6">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                        <div class="flex justify-between items-center mb-6">
                            <h1 class="text-2xl font-semibold text-gray-900">Cars</h1>
                            <button id="add-car-button" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <i class="fas fa-plus mr-2"></i> Add Car
                            </button>
                        </div>
                    </div>
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                        <!-- Loading state -->
                        <div id="loading-state" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <!-- Loading skeletons will be inserted here by JavaScript -->
                        </div>

                        <!-- Empty state -->
                        <div id="empty-state" class="text-center py-12 hidden">
                            <i class="fas fa-car text-gray-400 text-5xl mb-4"></i>
                            <h3 class="mt-2 text-lg font-medium text-gray-900">No cars found</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                Get started by adding a new car.
                            </p>
                            <div class="mt-6">
                                <button class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 add-car-button">
                                    <i class="fas fa-plus mr-2"></i> Add Car
                                </button>
                            </div>
                        </div>

                        <!-- Cars grid -->
                        <div id="cars-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 ">
                            <!-- Car cards will be inserted here by JavaScript -->
                        </div>

                        <!-- Pagination -->
                        <div id="pagination" class="flex items-center justify-between mt-6 ">
                            <div class="flex-1 flex justify-between sm:hidden">
                                <button id="prev-page-mobile" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    Previous
                                </button>
                                <button id="next-page-mobile" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    Next
                                </button>
                            </div>
                            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                                <div>
                                    <p id="pagination-info" class="text-sm text-gray-700">
                                        Showing <span class="font-medium">1</span> to <span class="font-medium">10</span> of <span class="font-medium">20</span> results
                                    </p>
                                </div>
                                <div>
                                    <nav id="pagination-nav" class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                        <!-- Pagination buttons will be inserted here by JavaScript -->
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Create/Edit Car Modal -->
    <div id="car-modal" class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center z-50">
        <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
        
        <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
            <div class="modal-content py-4 text-left px-6">
                <div class="flex justify-between items-center pb-3">
                    <p id="modal-title" class="text-xl font-bold">Add New Car</p>
                    <div class="modal-close cursor-pointer z-50">
                        <i class="fas fa-times"></i>
                    </div>
                </div>

                <form id="car-form">
                    <input type="hidden" id="car-id">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="model">
                            Car Model
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="model" type="text" placeholder="e.g. Toyota Camry" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="image_url">
                            Image URL
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="image_url" type="text" placeholder="https://example.com/car-image.jpg">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="daily_rate">
                            Daily Rate ($)
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="daily_rate" type="number" min="1" step="0.01" placeholder="99.99" required>
                    </div>
                    <div class="mb-6 flex items-center">
                        <input class="mr-2 leading-tight" type="checkbox" id="is_available" checked>
                        <label class="text-gray-700 text-sm font-bold" for="is_available">
                            Available for rent
                        </label>
                    </div>
                    <div class="flex justify-end pt-2">
                        <button type="button" class="modal-close px-4 bg-gray-200 p-3 rounded-lg text-black hover:bg-gray-300 mr-2">Cancel</button>
                        <button type="submit" id="save-car-button" class="px-4 bg-indigo-600 p-3 rounded-lg text-white hover:bg-indigo-700">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="delete-modal" class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center z-50">
        <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
        
        <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
            <div class="modal-content py-4 text-left px-6">
                <div class="flex justify-between items-center pb-3">
                    <p class="text-xl font-bold">Delete Car</p>
                    <div class="modal-close cursor-pointer z-50">
                        <i class="fas fa-times"></i>
                    </div>
                </div>

                <p class="text-gray-700 mb-6">Are you sure you want to delete <span id="delete-car-model"></span>? This action cannot be undone.</p>

                <div class="flex justify-end pt-2">
                    <button type="button" class="modal-close px-4 bg-gray-200 p-3 rounded-lg text-black hover:bg-gray-300 mr-2">Cancel</button>
                    <button type="button" id="confirm-delete-button" class="px-4 bg-red-600 p-3 rounded-lg text-white hover:bg-red-700">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="fixed right-0 top-0 m-4 p-4 rounded-lg shadow-lg transform transition-transform duration-300 ease-in-out translate-x-full flex items-center z-50">
        <div id="toast-icon" class="mr-2">
            <i class="fas fa-check-circle text-white"></i>
        </div>
        <div id="toast-message" class="text-white font-semibold"></div>
    </div>

    <script>
        // Global variables
        let currentPage = 1;
        let pagination = null;
        let currentCarId = null;
        let isEditing = false;

        // DOM Elements
        const loadingState = document.getElementById('loading-state');
        const emptyState = document.getElementById('empty-state');
        const carsGrid = document.getElementById('cars-grid');
        const paginationContainer = document.getElementById('pagination');
        const paginationInfo = document.getElementById('pagination-info');
        const paginationNav = document.getElementById('pagination-nav');
        const carModal = document.getElementById('car-modal');
        const deleteModal = document.getElementById('delete-modal');
        const toast = document.getElementById('toast');
        const carForm = document.getElementById('car-form');
        const searchForm = document.getElementById('search-form');
        const searchField = document.getElementById('search-field');

        // Initialize the dashboard
        document.addEventListener('DOMContentLoaded', function() {
            // Create loading skeletons
            createLoadingSkeletons();
            
            // Fetch cars on initial load
            fetchCars();

            // Event listeners
            document.getElementById('add-car-button').addEventListener('click', openCreateCarModal);
            document.querySelectorAll('.add-car-button').forEach(button => {
                button.addEventListener('click', openCreateCarModal);
            });
            
            document.getElementById('sidebar-toggle').addEventListener('click', toggleSidebar);
            
            document.querySelectorAll('.modal-close').forEach(element => {
                element.addEventListener('click', closeModals);
            });
            
            document.querySelectorAll('.modal-overlay').forEach(element => {
                element.addEventListener('click', closeModals);
            });
            
            document.getElementById('car-form').addEventListener('submit', saveCar);
            document.getElementById('confirm-delete-button').addEventListener('click', deleteCar);
            document.getElementById('search-form').addEventListener('submit', function(e) {
                e.preventDefault();
                fetchCars(1, searchField.value);
            });

            // Mobile pagination buttons
            document.getElementById('prev-page-mobile').addEventListener('click', function() {
                if (pagination && pagination.currentPage > 1) {
                    fetchCars(pagination.currentPage - 1, searchField.value);
                }
            });
            
            document.getElementById('next-page-mobile').addEventListener('click', function() {
                if (pagination && pagination.currentPage < pagination.lastPage) {
                    fetchCars(pagination.currentPage + 1, searchField.value);
                }
            });
        });

        // Create loading skeletons
        function createLoadingSkeletons() {
            loadingState.innerHTML = '';
            for (let i = 0; i < 6; i++) {
                loadingState.innerHTML += `
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="h-48 bg-gray-200 animate-pulse"></div>
                        <div class="p-4">
                            <div class="h-6 bg-gray-200 rounded w-3/4 mb-2 animate-pulse"></div>
                            <div class="h-4 bg-gray-200 rounded w-1/2 mb-2 animate-pulse"></div>
                            <div class="h-4 bg-gray-200 rounded w-1/4 animate-pulse"></div>
                        </div>
                    </div>
                `;
            }
        }

        // Fetch cars from API
        function fetchCars(page = 1, search = '') {
            // Show loading state
            loadingState.classList.remove('hidden');
            emptyState.classList.add('hidden');
            carsGrid.classList.add('hidden');
            paginationContainer.classList.add('hidden');
            
            // Build URL with query parameters
            let url = '/api/cars?page=' + page;
            if (search) {
                url += '&search=' + encodeURIComponent(search);
            }
            
            // Fetch data from API
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    // Hide loading state
                    loadingState.classList.add('hidden');
                    
                    if (data.status && data.data.cars.length > 0) {
                        // Show cars grid
                        carsGrid.classList.remove('hidden');
                        
                        // Update pagination
                        pagination = data.data.pagination;
                        currentPage = pagination.currentPage;
                        
                        // Render cars
                        renderCars(data.data.cars);
                        
                        // Render pagination if needed
                        if (pagination.lastPage > 1) {
                            renderPagination();
                            paginationContainer.classList.remove('hidden');
                        } else {
                            paginationContainer.classList.add('hidden');
                        }
                    } else {
                        // Show empty state
                        emptyState.classList.remove('hidden');
                        paginationContainer.classList.add('hidden');
                    }
                })
                .catch(error => {
                    console.error('Error fetching cars:', error);
                    loadingState.classList.add('hidden');
                    emptyState.classList.remove('hidden');
                    showToast('Error connecting to server', 'error');
                });
        }

        // Render cars in the grid
        function renderCars(cars) {
            carsGrid.innerHTML = '';
            
            cars.forEach(car => {
                const availabilityBadge = car.is_available 
                    ? '<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">Available</span>'
                    : '<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">Unavailable</span>';
                
                const imageContent = car.image_url 
                    ? `<img src="${car.image_url}" alt="${car.model}" class="w-full h-full object-cover">`
                    : `<div class="flex items-center justify-center h-full"><i class="fas fa-car text-gray-400 text-5xl"></i></div>`;
                
                carsGrid.innerHTML += `
                    <div class="bg-white overflow-hidden shadow rounded-lg" data-car-id="${car.id}">
                        <div class="h-48 bg-gray-200 relative">
                            ${imageContent}
                            <div class="absolute top-2 right-2">
                                ${availabilityBadge}
                            </div>
                        </div>
                        <div class="p-4">
                            <h3 class="text-lg font-medium text-gray-900">${car.model}</h3>
                            <div class="mt-2 flex items-center text-sm text-gray-500">
                                <i class="fas fa-dollar-sign mr-1.5 text-gray-400"></i>
                                <span>${parseFloat(car.daily_rate).toFixed(2)} / day</span>
                            </div>
                            <div class="mt-4 flex space-x-2">
                                <button class="edit-car-button inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" data-car-id="${car.id}">
                                    <i class="fas fa-edit mr-1"></i> Edit
                                </button>
                                <button class="delete-car-button inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded text-red-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" data-car-id="${car.id}" data-car-model="${car.model}">
                                    <i class="fas fa-trash-alt mr-1"></i> Delete
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            });
            
            // Add event listeners to edit and delete buttons
            document.querySelectorAll('.edit-car-button').forEach(button => {
                button.addEventListener('click', function() {
                    const carId = this.getAttribute('data-car-id');
                    openEditCarModal(carId);
                });
            });
            
            document.querySelectorAll('.delete-car-button').forEach(button => {
                button.addEventListener('click', function() {
                    const carId = this.getAttribute('data-car-id');
                    const carModel = this.getAttribute('data-car-model');
                    openDeleteModal(carId, carModel);
                });
            });
        }

        // Render pagination controls
        function renderPagination() {
            // Update pagination info text
            const start = (pagination.currentPage - 1) * pagination.perPage + 1;
            const end = Math.min(pagination.currentPage * pagination.perPage, pagination.total);
            paginationInfo.innerHTML = `
                Showing <span class="font-medium">${start}</span> to <span class="font-medium">${end}</span> of <span class="font-medium">${pagination.total}</span> results
            `;
            
            // Create pagination buttons
            paginationNav.innerHTML = '';
            
            // Previous button
            const prevButton = document.createElement('button');
            prevButton.className = 'relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50';
            prevButton.innerHTML = '<span class="sr-only">Previous</span><i class="fas fa-chevron-left"></i>';
            prevButton.disabled = !pagination.previousPageUrl;
            if (pagination.previousPageUrl) {
                prevButton.addEventListener('click', function() {
                    fetchCars(pagination.currentPage - 1, searchField.value);
                });
            } else {
                prevButton.classList.add('opacity-50', 'cursor-not-allowed');
            }
            paginationNav.appendChild(prevButton);
            
            // Page buttons
            for (let i = 1; i <= pagination.lastPage; i++) {
                const pageButton = document.createElement('button');
                if (i === pagination.currentPage) {
                    pageButton.className = 'relative inline-flex items-center px-4 py-2 border border-indigo-500 bg-indigo-50 text-sm font-medium text-indigo-600';
                } else {
                    pageButton.className = 'relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50';
                }
                pageButton.textContent = i;
                pageButton.addEventListener('click', function() {
                    fetchCars(i, searchField.value);
                });
                paginationNav.appendChild(pageButton);
            }
            
            // Next button
            const nextButton = document.createElement('button');
            nextButton.className = 'relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50';
            nextButton.innerHTML = '<span class="sr-only">Next</span><i class="fas fa-chevron-right"></i>';
            nextButton.disabled = !pagination.nextPageUrl;
            if (pagination.nextPageUrl) {
                nextButton.addEventListener('click', function() {
                    fetchCars(pagination.currentPage + 1, searchField.value);
                });
            } else {
                nextButton.classList.add('opacity-50', 'cursor-not-allowed');
            }
            paginationNav.appendChild(nextButton);
            
            // Update mobile pagination buttons
            document.getElementById('prev-page-mobile').disabled = !pagination.previousPageUrl;
            document.getElementById('next-page-mobile').disabled = !pagination.nextPageUrl;
            if (!pagination.previousPageUrl) {
                document.getElementById('prev-page-mobile').classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                document.getElementById('prev-page-mobile').classList.remove('opacity-50', 'cursor-not-allowed');
            }
            if (!pagination.nextPageUrl) {
                document.getElementById('next-page-mobile').classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                document.getElementById('next-page-mobile').classList.remove('opacity-50', 'cursor-not-allowed');
            }
        }

        // Open create car modal
        function openCreateCarModal() {
            // Reset form
            carForm.reset();
            document.getElementById('car-id').value = '';
            document.getElementById('is_available').checked = true;
            
            // Update modal title
            document.getElementById('modal-title').textContent = 'Add New Car';
            
            // Set flag
            isEditing = false;
            
            // Open modal
            openModal(carModal);
        }

        // Open edit car modal
        function openEditCarModal(carId) {
            // Show loading state
            showToast('Loading car details...', 'info');
            
            // Fetch car details
            fetch(`/api/cars/${carId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.status) {
                        const car = data.data;
                        
                        // Populate form
                        document.getElementById('car-id').value = car.id;
                        document.getElementById('model').value = car.model;
                        document.getElementById('image_url').value = car.image_url || '';
                        document.getElementById('daily_rate').value = car.daily_rate;
                        document.getElementById('is_available').checked = car.is_available;
                        
                        // Update modal title
                        document.getElementById('modal-title').textContent = 'Edit Car';
                        
                        // Set flag and current car ID
                        isEditing = true;
                        currentCarId = car.id;
                        
                        // Open modal
                        openModal(carModal);
                    } else {
                        showToast('Error loading car details', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error fetching car details:', error);
                    showToast('Error connecting to server', 'error');
                });
        }

        // Open delete confirmation modal
        function openDeleteModal(carId, carModel) {
            // Set current car ID
            currentCarId = carId;
            
            // Update modal content
            document.getElementById('delete-car-model').textContent = carModel;
            
            // Open modal
            openModal(deleteModal);
        }

        // Save car (create or update)
        function saveCar(e) {
            e.preventDefault();
            
            // Get form data
            const formData = {
                model: document.getElementById('model').value,
                image_url: document.getElementById('image_url').value || null,
                daily_rate: parseFloat(document.getElementById('daily_rate').value),
                is_available: document.getElementById('is_available').checked
            };
            
            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            // Determine URL and method based on whether we're creating or editing
            const url = isEditing ? `/api/cars/${currentCarId}` : '/api/cars';
            const method = isEditing ? 'PUT' : 'POST';
            
            // Send request to API
            fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    // Close modal
                    closeModals();
                    
                    // Show success message
                    showToast(isEditing ? 'Car updated successfully' : 'Car created successfully', 'success');
                    
                    // Refresh cars list
                    fetchCars(currentPage, searchField.value);
                } else {
                    // Show error message
                    showToast(data.message || 'Failed to save car', 'error');
                }
            })
            .catch(error => {
                console.error('Error saving car:', error);
                showToast('Error connecting to server', 'error');
            });
        }

        // Delete car
        function deleteCar() {
            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            // Send request to API
            fetch(`/api/cars/${currentCarId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    // Close modal
                    closeModals();
                    
                    // Show success message
                    showToast('Car deleted successfully', 'success');
                    
                    // Refresh cars list
                    fetchCars(currentPage, searchField.value);
                } else {
                    // Show error message
                    showToast(data.message || 'Failed to delete car', 'error');
                }
            })
            .catch(error => {
                console.error('Error deleting car:', error);
                showToast('Error connecting to server', 'error');
            });
        }

        // Open modal
        function openModal(modal) {
            modal.classList.remove('opacity-0', 'pointer-events-none');
            document.body.classList.add('modal-active');
        }

        // Close all modals
        function closeModals() {
            document.querySelectorAll('.modal').forEach(modal => {
                modal.classList.add('opacity-0', 'pointer-events-none');
            });
            document.body.classList.remove('modal-active');
        }

        // Show toast notification
        function showToast(message, type = 'success') {
            // Set toast content based on type
            if (type === 'success') {
                toast.className = 'fixed right-0 top-0 m-4 p-4 rounded-lg shadow-lg transform transition-transform duration-300 ease-in-out bg-green-500 flex items-center z-50';
                document.getElementById('toast-icon').innerHTML = '<i class="fas fa-check-circle text-white"></i>';
            } else if (type === 'error') {
                toast.className = 'fixed right-0 top-0 m-4 p-4 rounded-lg shadow-lg transform transition-transform duration-300 ease-in-out bg-red-500 flex items-center z-50';
                document.getElementById('toast-icon').innerHTML = '<i class="fas fa-exclamation-circle text-white"></i>';
            } else if (type === 'info') {
                toast.className = 'fixed right-0 top-0 m-4 p-4 rounded-lg shadow-lg transform transition-transform duration-300 ease-in-out bg-blue-500 flex items-center z-50';
                document.getElementById('toast-icon').innerHTML = '<i class="fas fa-info-circle text-white"></i>';
            }
            
            // Set message
            document.getElementById('toast-message').textContent = message;
            
            // Show toast
            toast.classList.remove('translate-x-full');
            
            // Hide toast after 3 seconds
            setTimeout(() => {
                toast.classList.add('translate-x-full');
            }, 3000);
        }

        // Toggle sidebar on mobile
        function toggleSidebar() {
            const sidebar = document.querySelector('.md\\:flex-shrink-0');
            sidebar.classList.toggle('hidden');
            sidebar.classList.toggle('fixed');
            sidebar.classList.toggle('inset-0');
            sidebar.classList.toggle('z-40');
        }
    </script>
</body>
</html>
