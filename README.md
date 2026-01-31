# My Order Fellow

A professional, modular PHP application for order tracking, partner onboarding, and compliance. The system is engineered with a custom MVC framework, robust authentication, secure API gateway, and event-driven notifications.

## Key Features

### 1. Authentication & Compliance

- **Partner Onboarding Flow:**
  - New partners (companies) register and complete a KYC (Know Your Customer) workflow, including business registration number and address submission.
  - KYC submissions are reviewed by an admin for approval or rejection.
- **Admin Approval Logic:**
  - Admins can view pending KYC applications and approve or reject them via the dashboard.
  - **Admin Registration:** Requires a system-level secret key (`MOF-MASTER-KEY`) for secure onboarding of administrative staff.
- **OTP/Email Verification:**
  - User registration triggers an OTP sent via email. Registration is only completed after OTP verification, ensuring email authenticity.

### 2. API Gateway & Webhooks

- **Webhook Ingestion Point:**
  - Orders are ingested via a `/webhook` endpoint, protected by API key authentication.
- **Security Measures:**
  - **Custom Rate Limiter:** All sensitive endpoints are protected by a file-based rate limiter.
    - **Webhooks:** Limited to 20 requests per minute per IP.
    - **Tracking:** Limited to 5 requests per minute per IP.
  - **API Key Verification:** Each webhook request is authenticated using a unique API key issued to approved partners via the `X-API-KEY` header.
- **CLI Simulator:**
  - The `mock_store.php` script simulates external order creation by sending test payloads to the webhook endpoint for integration testing.

### 3. Core Tracking Engine

- **Order Status Lifecycle:**
  - Orders progress through statuses (e.g., Pending, Delivered), with each change recorded in a tracking history table.
- **Public Tracking Page:**
  - Anyone can retrieve order status/history using an external tracking ID, without authentication, via the `/track` endpoint.

### 4. Notifications

- **Event-Driven Email System:**
  - Email notifications are sent for OTP verification, order confirmation, and order status updates, using the `MailService` class (PHPMailer-based).
  - Supports SMTP configuration with fallback to Mailtrap for development.

### 5. Architecture

- **Custom PHP MVC Framework:**
  - **Router:** All HTTP requests are routed through `public/index.php`, which dispatches to controllers based on the request path.
  - **Controllers, Models, Views:** Clear separation of concerns for maintainability and testability.
  - **Service Layer:** Business logic (e.g., order status updates, email notifications) is encapsulated in service classes.
  - **Database Abstraction:** A dedicated `Database` class manages PDO connections and queries.
  - **Rate Limiter:** Implements a file-based singleton pattern to throttle requests per IP, storing state in the `cache/` directory.

## Technical Architecture

- **Controllers:** Handle HTTP requests, session management, and invoke business logic (e.g., `WebhookController`, `AuthController`, `AdminController`, `DashboardController`, `TrackingController`, `HomeController`).
- **Models:** Encapsulate database operations for users, admins, orders, and tracking history (e.g., `User`, `Admin`, `Order`, `Tracking`).
- **Views:** Render HTML for authentication, admin, dashboard, and tracking interfaces, organized in a modular structure with shared layouts.
- **Services:** Contain reusable business logic (e.g., `MailService`, `OrderService`).
- **Core:** Framework utilities (e.g., `Database`, `RateLimiter`).
- **Public:** Entry point (`index.php`) and static assets (CSS, etc.).
- **Router:** Custom router (`public/index.php`) for clean URL handling.

## Installation & Setup

1. **Clone the Repository:**
   ```bash
   git clone <repo-url>
   cd MyOrderFellow
   ```
2. **Install Dependencies:**
   ```bash
   composer install
   ```
3. **Environment Configuration:**
   - Create a `.env` file in the root directory with the following variables:

     ```env
     DB_HOST=localhost
     DB_PORT=5432
     DB_DATABASE=your_db
     DB_USERNAME=your_user
     DB_PASSWORD=your_password

     SMTP_HOST=sandbox.smtp.mailtrap.io
     SMTP_PORT=2525
     SMTP_USERNAME=your_smtp_user
     SMTP_PASSWORD=your_smtp_pass
     SMTP_FROM_EMAIL=noreply@orderfellow.com
     ```

4. **Database Setup:**
   - Create a PostgreSQL database.
   - Ensure tables for `companies`, `admins`, `orders`, and `tracking_history` are created (see `app/Models` for schema requirements).
5. **Start the Development Server:**
   ```bash
   php -S localhost:8000 -t public router.php
   ```

## Usage Guide

### Partner Onboarding & KYC

- Register as a company at `/register` and complete the KYC form in the dashboard.
- Await admin approval. Admins manage applications at `/admin/dashboard`.

### API/Webhook Integration

- After KYC approval, retrieve your API key from the dashboard.
- Send order payloads to `/webhook` using your API key in the `X-API-KEY` header.
- Use `mock_store.php` to simulate webhook requests:
  ```bash
  php mock_store.php
  ```

### Public Tracking

- Customers can track orders at `/track` using their external tracking ID (no login required).

### Admin Panel

- **Registration:** Access `/admin/register` and use the master key `MOF-MASTER-KEY` to create an account.
- **Management:** Admins can approve/reject KYC, view orders, and update order statuses at `/admin/dashboard`.

---
