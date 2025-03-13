<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Car Rental - Find and Reserve Cars</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Date picker -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
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
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <h1 class="text-xl font-bold text-indigo-600">
                            <i class="fas fa-car mr-2"></i> Car Rental
                        </h1>
                    </div>
                    <nav class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <a href="#" class="border-indigo-500 text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Home
                        </a>
                        <a href="#" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Cars
                        </a>
                        <a href="#" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Locations
                        </a>
                        <a href="#" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Contact
                        </a>
                    </nav>
                </div>
                <div class="hidden sm:ml-6 sm:flex sm:items-center">
                    <button class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        My Reservations
                    </button>
                </div>
                <div class="-mr-2 flex items-center sm:hidden">
                    <button id="mobile-menu-button" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                        <span class="sr-only">Open main menu</span>
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div id="mobile-menu" class="sm:hidden hidden">
            <div class="pt-2 pb-3 space-y-1">
                <a href="#" class="bg-indigo-50 border-indigo-500 text-indigo-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                    Home
                </a>
                <a href="#" class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                    Cars
                </a>
                <a href="#" class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                    Locations
                </a>
                <a href="#" class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                    Contact
                </a>
                <div class="pt-4 pb-3 border-t border-gray-200">
                    <a href="#" class="block px-4 py-2 text-base font-medium text-indigo-600 hover:text-indigo-800">
                        My Reservations
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <div class="bg-indigo-700">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8 lg:py-16">
            <div class="max-w-3xl mx-auto text-center">
                <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                    Find Your Perfect Rental Car
                </h2>
                <p class="mt-4 text-lg text-indigo-100">
                    Choose from our wide selection of vehicles for your next trip
                </p>
            </div>
            
            <!-- Search Form -->
            <div class="mt-10 max-w-xl mx-auto">
                <form id="search-form" class="sm:flex sm:gap-4">
                    <div class="flex-1">
                        <label for="search-field" class="sr-only">Search cars</label>
                        <input id="search-field" type="text" placeholder="Search by model, type..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3 px-4">
                    </div>
                    <div class="mt-4 sm:mt-0">
                        <button type="submit" class="w-full bg-white py-3 px-6 border border-transparent rounded-md shadow-sm text-base font-medium text-indigo-700 hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <i class="fas fa-search mr-2"></i> Search
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap items-center justify-between">
                <div class="flex flex-wrap items-center space-x-4">
                    <div class="mb-2 sm:mb-0">
                        <label for="sort-by" class="block text-sm font-medium text-gray-700">Sort by</label>
                        <select id="sort-by" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="price-asc">Price: Low to High</option>
                            <option value="price-desc">Price: High to Low</option>
                            <option value="name-asc">Name: A to Z</option>
                            <option value="name-desc">Name: Z to A</option>
                        </select>
                    </div>
                    <div class="mb-2 sm:mb-0">
                        <label for="price-range" class="block text-sm font-medium text-gray-700">Max Price</label>
                        <select id="price-range" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="all">All Prices</option>
                            <option value="50">Under $50/day</option>
                            <option value="100">Under $100/day</option>
                            <option value="150">Under $150/day</option>
                            <option value="200">Under $200/day</option>
                        </select>
                    </div>
                </div>
                <div class="mt-4 sm:mt-0">
                    <span id="cars-count" class="text-sm text-gray-500">Showing 0 cars</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Loading State -->
        <div id="loading-state" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 px-4 sm:px-0">
            <!-- Loading skeletons will be inserted here by JavaScript -->
        </div>

        <!-- Empty State -->
        <div id="empty-state" class="text-center py-12 hidden">
            <i class="fas fa-car text-gray-400 text-5xl mb-4"></i>
            <h3 class="mt-2 text-lg font-medium text-gray-900">No cars available</h3>
            <p class="mt-1 text-sm text-gray-500">
                Try adjusting your search or filters to find available cars.
            </p>
        </div>

        <!-- Cars Grid -->
        <div id="cars-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 px-4 sm:px-0 hidden">
            <!-- Car cards will be inserted here by JavaScript -->
        </div>

        <!-- Pagination -->
        <div id="pagination" class="flex items-center justify-between mt-6 px-4 sm:px-0 hidden">
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
    </main>

    <!-- Footer -->
    <footer class="bg-white">
        <div class="max-w-7xl mx-auto py-12 px-4 overflow-hidden sm:px-6 lg:px-8">
            <nav class="-mx-5 -my-2 flex flex-wrap justify-center" aria-label="Footer">
                <div class="px-5 py-2">
                    <a href="#" class="text-base text-gray-500 hover:text-gray-900">About</a>
                </div>
                <div class="px-5 py-2">
                    <a href="#" class="text-base text-gray-500 hover:text-gray-900">Blog</a>
                </div>
                <div class="px-5 py-2">
                    <a href="#" class="text-base text-gray-500 hover:text-gray-900">Jobs</a>
                </div>
                <div class="px-5 py-2">
                    <a href="#" class="text-base text-gray-500 hover:text-gray-900">Press</a>
                </div>
                <div class="px-5 py-2">
                    <a href="#" class="text-base text-gray-500 hover:text-gray-900">Privacy</a>
                </div>
                <div class="px-5 py-2">
                    <a href="#" class="text-base text-gray-500 hover:text-gray-900">Terms</a>
                </div>
                <div class="px-5 py-2">
                    <a href="#" class="text-base text-gray-500 hover:text-gray-900">Contact</a>
                </div>
            </nav>
            <div class="mt-8 flex justify-center space-x-6">
                <a href="#" class="text-gray-400 hover:text-gray-500">
                    <span class="sr-only">Facebook</span>
                    <i class="fab fa-facebook text-xl"></i>
                </a>
                <a href="#" class="text-gray-400 hover:text-gray-500">
                    <span class="sr-only">Instagram</span>
                    <i class="fab fa-instagram text-xl"></i>
                </a>
                <a href="#" class="text-gray-400 hover:text-gray-500">
                    <span class="sr-only">Twitter</span>
                    <i class="fab fa-twitter text-xl"></i>
                </a>
            </div>
            <p class="mt-8 text-center text-base text-gray-400">
                &copy; 2025 Car Rental, Inc. All rights reserved.
            </p>
        </div>
    </footer>

    <!-- Reservation Modal -->
    <div id="reservation-modal" class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center z-50">
        <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
        
        <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
            <div class="modal-content py-4 text-left px-6">
                <div class="flex justify-between items-center pb-3">
                    <p id="reservation-title" class="text-xl font-bold">Reserve a Car</p>
                    <div class="modal-close cursor-pointer z-50">
                        <i class="fas fa-times"></i>
                    </div>
                </div>

                <div id="reservation-car-details" class="mb-4">
                    <!-- Car details will be inserted here -->
                </div>

                <form id="reservation-form">
                    <input type="hidden" id="car-id">
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="pickup-date">
                            Pickup Date
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline datepicker" id="pickup-date" type="text" placeholder="Select date" required>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="return-date">
                            Return Date
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline datepicker" id="return-date" type="text" placeholder="Select date" required>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="full-name">
                            Full Name
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="full-name" type="text" placeholder="John Doe" required>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                            Email
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" type="email" placeholder="john@example.com" required>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="phone">
                            Phone
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="phone" type="tel" placeholder="(123) 456-7890" required>
                    </div>
                    
                    <div id="reservation-summary" class="mb-6 p-4 bg-gray-50 rounded-md">
                        <h3 class="font-bold text-gray-700 mb-2">Reservation Summary</h3>
                        <div id="reservation-details">
                            <!-- Reservation details will be calculated and inserted here -->
                            <p>Please select dates to see the total cost.</p>
                        </div>
                    </div>
                    
                    <div class="flex justify-end pt-2">
                        <button type="button" class="modal-close px-4 bg-gray-200 p-3 rounded-lg text-black hover:bg-gray-300 mr-2">Cancel</button>
                        <button type="submit" id="confirm-reservation-button" class="px-4 bg-indigo-600 p-3 rounded-lg text-white hover:bg-indigo-700">Confirm Reservation</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmation-modal" class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center z-50">
        <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
        
        <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
            <div class="modal-content py-4 text-left px-6">
                <div class="flex justify-between items-center pb-3">
                    <p class="text-xl font-bold text-green-600">Reservation Confirmed!</p>
                    <div class="modal-close cursor-pointer z-50">
                        <i class="fas fa-times"></i>
                    </div>
                </div>

                <div class="py-4">
                    <div class="flex justify-center mb-4">
                        <div class="rounded-full bg-green-100 p-3">
                            <i class="fas fa-check-circle text-green-600 text-3xl"></i>
                        </div>
                    </div>
                    
                    <p class="text-center text-gray-700 mb-4">
                        Your reservation has been confirmed. A confirmation email has been sent to your email address.
                    </p>
                    
                    <div id="confirmation-details" class="bg-gray-50 p-4 rounded-md">
                        <!-- Confirmation details will be inserted here -->
                    </div>
                </div>

                <div class="flex justify-center pt-2">
                    <button type="button" class="modal-close px-4 bg-indigo-600 p-3 rounded-lg text-white hover:bg-indigo-700">
                        Done
                    </button>
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
        let availableCars = [];
        let selectedCar = null;
        let reservationDates = {
            pickup: null,
            return: null
        };

        // DOM Elements
        const loadingState = document.getElementById('loading-state');
        const emptyState = document.getElementById('empty-state');
        const carsGrid = document.getElementById('cars-grid');
        const paginationContainer = document.getElementById('pagination');
        const paginationInfo = document.getElementById('pagination-info');
        const paginationNav = document.getElementById('pagination-nav');
        const reservationModal = document.getElementById('reservation-modal');
        const confirmationModal = document.getElementById('confirmation-modal');
        const toast = document.getElementById('toast');
        const searchForm = document.getElementById('search-form');
        const searchField = document.getElementById('search-field');
        const sortBySelect = document.getElementById('sort-by');
        const priceRangeSelect = document.getElementById('price-range');
        const carsCount = document.getElementById('cars-count');
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        const reservationForm = document.getElementById('reservation-form');

        // Initialize the page
        document.addEventListener('DOMContentLoaded', function() {
            // Create loading skeletons
            createLoadingSkeletons();
            
            // Fetch cars on initial load
            fetchCars();

            // Initialize date pickers
            initDatePickers();

            // Event listeners
            searchForm.addEventListener('submit', function(e) {
                e.preventDefault();
                fetchCars(1, searchField.value);
            });

            sortBySelect.addEventListener('change', function() {
                fetchCars(1, searchField.value);
            });

            priceRangeSelect.addEventListener('change', function() {
                fetchCars(1, searchField.value);
            });

            mobileMenuButton.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });
            
            document.querySelectorAll('.modal-close').forEach(element => {
                element.addEventListener('click', closeModals);
            });
            
            document.querySelectorAll('.modal-overlay').forEach(element => {
                element.addEventListener('click', closeModals);
            });
            
            reservationForm.addEventListener('submit', function(e) {
                e.preventDefault();
                submitReservation();
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

            // Date change listeners for calculating reservation cost
            document.getElementById('pickup-date').addEventListener('change', updateReservationSummary);
            document.getElementById('return-date').addEventListener('change', updateReservationSummary);
        });

        // Initialize date pickers
        function initDatePickers() {
            const today = new Date();
            const tomorrow = new Date();
            tomorrow.setDate(today.getDate() + 1);
            
            // Initialize pickup date picker
            const pickupDatePicker = flatpickr("#pickup-date", {
                minDate: "today",
                dateFormat: "Y-m-d",
                onChange: function(selectedDates, dateStr) {
                    // Update return date min date
                    returnDatePicker.set('minDate', dateStr);
                    
                    // If return date is before pickup date, reset it
                    if (returnDatePicker.selectedDates[0] < selectedDates[0]) {
                        const nextDay = new Date(selectedDates[0]);
                        nextDay.setDate(nextDay.getDate() + 1);
                        returnDatePicker.setDate(nextDay);
                    }
                    
                    reservationDates.pickup = dateStr;
                    updateReservationSummary();
                }
            });
            
            // Initialize return date picker
            const returnDatePicker = flatpickr("#return-date", {
                minDate: tomorrow,
                dateFormat: "Y-m-d",
                onChange: function(selectedDates, dateStr) {
                    reservationDates.return = dateStr;
                    updateReservationSummary();
                }
            });
        }

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
            let url = '/api/cars?page=' + page + '&available=true';
            
            if (search) {
                url += '&search=' + encodeURIComponent(search);
            }
            
            // Add sorting
            const sortBy = sortBySelect.value;
            if (sortBy) {
                url += '&sort=' + encodeURIComponent(sortBy);
            }
            
            // Add price filter
            const priceRange = priceRangeSelect.value;
            if (priceRange && priceRange !== 'all') {
                url += '&max_price=' + encodeURIComponent(priceRange);
            }
            
            // Fetch data from API
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    // Hide loading state
                    loadingState.classList.add('hidden');
                    
                    if (data.status && data.data.cars.length > 0) {
                        // Store available cars
                        availableCars = data.data.cars;
                        
                        // Show cars grid
                        carsGrid.classList.remove('hidden');
                        
                        // Update cars count
                        carsCount.textContent = `Showing ${data.data.cars.length} cars`;
                        
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
                        carsCount.textContent = 'Showing 0 cars';
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
                const imageContent = car.image_url 
                    ? `<img src="${car.image_url}" alt="${car.model}" class="w-full h-full object-cover">`
                    : `<div class="flex items-center justify-center h-full"><i class="fas fa-car text-gray-400 text-5xl"></i></div>`;
                
                carsGrid.innerHTML += `
                    <div class="bg-white overflow-hidden shadow rounded-lg" data-car-id="${car.id}">
                        <div class="h-48 bg-gray-200 relative">
                            ${imageContent}
                            <div class="absolute top-2 right-2">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">Available</span>
                            </div>
                        </div>
                        <div class="p-4">
                            <h3 class="text-lg font-medium text-gray-900">${car.model}</h3>
                            <div class="mt-2 flex items-center text-sm text-gray-500">
                                <i class="fas fa-dollar-sign mr-1.5 text-gray-400"></i>
                                <span>${parseFloat(car.daily_rate).toFixed(2)} / day</span>
                            </div>
                            <div class="mt-4">
                                <button class="reserve-car-button w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" data-car-id="${car.id}">
                                    <i class="fas fa-calendar-alt mr-2"></i> Reserve Now
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            });
            
            // Add event listeners to reserve buttons
            document.querySelectorAll('.reserve-car-button').forEach(button => {
                button.addEventListener('click', function() {
                    const carId = this.getAttribute('data-car-id');
                    openReservationModal(carId);
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

        // Open reservation modal
        function openReservationModal(carId) {
            // Find the car in available cars
            selectedCar = availableCars.find(car => car.id == carId);
            
            if (!selectedCar) {
                showToast('Car not found', 'error');
                return;
            }
            
            // Update car details in the modal
            const carDetailsContainer = document.getElementById('reservation-car-details');
            const imageContent = selectedCar.image_url 
                ? `<img src="${selectedCar.image_url}" alt="${selectedCar.model}" class="w-full h-32 object-cover rounded-md">`
                : `<div class="flex items-center justify-center h-32 bg-gray-200 rounded-md"><i class="fas fa-car text-gray-400 text-3xl"></i></div>`;
            
            carDetailsContainer.innerHTML = `
                <div class="bg-gray-50 p-4 rounded-md">
                    <div class="flex items-center">
                        <div class="w-1/3">
                            ${imageContent}
                        </div>
                        <div class="w-2/3 pl-4">
                            <h3 class="font-bold text-gray-900">${selectedCar.model}</h3>
                            <p class="text-sm text-gray-600">
                                <i class="fas fa-dollar-sign mr-1 text-gray-400"></i>
                                ${parseFloat(selectedCar.daily_rate).toFixed(2)} / day
                            </p>
                        </div>
                    </div>
                </div>
            `;
            
            // Set car ID in the form
            document.getElementById('car-id').value = selectedCar.id;
            
            // Reset form
            document.getElementById('reservation-form').reset();
            
            // Reset reservation dates
            reservationDates = {
                pickup: null,
                return: null
            };
            
            // Update reservation summary
            updateReservationSummary();
            
            // Open modal
            openModal(reservationModal);
        }

        // Update reservation summary
        function updateReservationSummary() {
            const summaryContainer = document.getElementById('reservation-details');
            
            if (!selectedCar || !reservationDates.pickup || !reservationDates.return) {
                summaryContainer.innerHTML = `<p>Please select dates to see the total cost.</p>`;
                return;
            }
            
            // Calculate number of days
            const pickupDate = new Date(reservationDates.pickup);
            const returnDate = new Date(reservationDates.return);
            const timeDiff = returnDate.getTime() - pickupDate.getTime();
            const days = Math.ceil(timeDiff / (1000 * 3600 * 24));
            
            // Calculate total cost
            const dailyRate = parseFloat(selectedCar.daily_rate);
            const totalCost = dailyRate * days;
            
            // Update summary
            summaryContainer.innerHTML = `
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span>Daily Rate:</span>
                        <span>$${dailyRate.toFixed(2)}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Number of Days:</span>
                        <span>${days}</span>
                    </div>
                    <div class="flex justify-between font-bold">
                        <span>Total Cost:</span>
                        <span>$${totalCost.toFixed(2)}</span>
                    </div>
                </div>
            `;
        }

        // Submit reservation
        function submitReservation() {
            // Get form data
            const formData = {
                car_id: document.getElementById('car-id').value,
                pickup_date: document.getElementById('pickup-date').value,
                return_date: document.getElementById('return-date').value,
                full_name: document.getElementById('full-name').value,
                email: document.getElementById('email').value,
                phone: document.getElementById('phone').value
            };
            
            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            // Show loading toast
            showToast('Processing your reservation...', 'info');
            
            // Send request to API
            fetch('/api/reservations', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    // Close reservation modal
                    closeModals();
                    
                    // Calculate reservation details for confirmation
                    const pickupDate = new Date(formData.pickup_date);
                    const returnDate = new Date(formData.return_date);
                    const timeDiff = returnDate.getTime() - pickupDate.getTime();
                    const days = Math.ceil(timeDiff / (1000 * 3600 * 24));
                    const totalCost = parseFloat(selectedCar.daily_rate) * days;
                    
                    // Format dates for display
                    const formattedPickupDate = pickupDate.toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
                    const formattedReturnDate = returnDate.toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
                    
                    // Update confirmation details
                    document.getElementById('confirmation-details').innerHTML = `
                        <div class="space-y-3">
                            <div>
                                <h4 class="font-bold text-gray-700">Reservation ID</h4>
                                <p>${data.data.reservation_id || 'N/A'}</p>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-700">Car</h4>
                                <p>${selectedCar.model}</p>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-700">Pickup Date</h4>
                                <p>${formattedPickupDate}</p>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-700">Return Date</h4>
                                <p>${formattedReturnDate}</p>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-700">Total Cost</h4>
                                <p>$${totalCost.toFixed(2)}</p>
                            </div>
                        </div>
                    `;
                    
                    // Show confirmation modal
                    openModal(confirmationModal);
                } else {
                    // Show error message
                    showToast(data.message || 'Failed to create reservation', 'error');
                }
            })
            .catch(error => {
                console.error('Error creating reservation:', error);
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
    </script>
</body>
</html>