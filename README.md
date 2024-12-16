# FixFinder – A Web Application for Comparing Car Repair Services

**FixFinder** is a Laravel-based web application designed to help vehicle owners find the best automotive repair services by comparing workshops, pricing, availability, and customer reviews. By providing an organized and transparent overview of available options, FixFinder empowers users to make informed decisions about their car repair needs. Meanwhile, mechanics and administrators can showcase their services and efficiently manage incoming requests.

## Key Features

- **Workshops Management:**
    - Publicly accessible endpoints to list available workshops.
    - Role-based endpoints (mechanics, admins) to add or manage workshops.

- **Services Catalog:**
    - Public endpoints to retrieve service details.
    - Admin-only endpoints for adding new services.

- **User Authentication & Roles:**
    - Public registration and login endpoints.
    - Laravel Sanctum-based token authentication.
    - Role-based access control (admin, mechanic, customer) to protect certain routes.

- **Reviews & Ratings:**
    - Public endpoints for browsing reviews.
    - Authenticated users can post their own reviews.

- **Service Requests & Quotes:**
    - Customers can request services (e.g., repairs, towing).
    - Mechanics and admins can manage and respond to these requests.

## Technology Stack

- **Backend:** Laravel (PHP)
- **Database:** MySQL (or compatible SQL databases)
- **Authentication:** Laravel Sanctum
- **Authorization:** Middleware-based role checking

## API Structure

All API routes are defined in `routes/api.php` and are grouped and protected by middleware. Some key routes include:

- **Authentication (AuthController):**
    - `POST /api/auth/login`
    - `POST /api/auth/register`
    - `POST /api/auth/logout` (authenticated users only)

- **Users (UserController):**
    - `GET /api/users` (admins only)

- **Workshops (WorkshopController):**
    - `GET /api/workshops` (public)
    - `GET /api/workshops/{id}` (public)
    - `POST /api/workshops` (mechanics, admins)

- **Services (ServiceController):**
    - `GET /api/services` (public)
    - `GET /api/services/{id}` (public)
    - `POST /api/services` (admins only)

- **Reviews (ReviewController):**
    - `GET /api/reviews` (public)
    - `POST /api/reviews` (authenticated users)

- **Service Requests (ServiceRequestController):**
    - `GET /api/service-requests` (mechanics, admins)
    - `GET /api/service-requests/{id}` (mechanics, admins)
    - `POST /api/service-requests` (customers)
    - `PATCH /api/service-requests/{id}` (mechanics, admins)

## Getting Started

### Prerequisites
- PHP >= 8.0
- Composer
- Node.js & npm
- MySQL or another supported database

### Installation Steps

1. **Clone the Repository:**
   ```bash
   git clone https://github.com/your-username/fixfinder.git
   cd fixfinder

2. **Install PHP Dependencies:**
    ```bash
    composer install

3. **Install Frontend Dependencies:**
    ```bash
    npm install
    npm run dev

4. **Environment Setup: Copy the example environment file and configure it as needed:**
    ```bash
    cp .env.example .env
    php artisan key:generate

5. **Update .env with your database credentials and any other necessary configurations.**

6. **Database Migration & Seeding:**
    ```bash
    php artisan migrate --seed

7. **DRunning the Development Server:**
    ```bash
    php artisan serve
   
The application will be available at:
http://localhost:8000.
