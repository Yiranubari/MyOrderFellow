# My Order Fellow

My Order Fellow is a custom PHP MVC application for company onboarding, API/webhook order ingestion, public marketplace order placement, admin operations, and shipment tracking.

## Current Flow

### 1) Company registration and verification

1. Company registers at `/register`.
2. OTP is sent by email.
3. Company verifies OTP at `/verify` (with resend support via `/resend-otp`).
4. Company logs in at `/login` and lands on `/dashboard`.

### 2) KYC and API key activation

1. Company submits KYC from dashboard.
2. Admin reviews submission at `/admin/dashboard`.
3. On approval, company can generate/use API key from dashboard.

### 3) Order creation

Orders can now be created in two ways:

- **Webhook ingestion:** `POST /webhook` with `X-API-KEY`
- **Public marketplace form:** `GET /orders/create` and `POST /orders/store` (no user login required)

Public marketplace form fields:

- `company_id` (selected from approved logistics companies)
- `customer_name`
- `customer_email`
- `customer_phone`
- `item_description`
- `quantity`
- `pickup_address`
- `delivery_address`

Orders submitted through this form are linked to the selected company and stored with default status `pending`.

### 4) Admin registration (secure OTP flow)

Admin signup no longer uses a hardcoded master key.

1. Open `/admin/register` and submit name, email, password, and company.
2. System generates a secure 6-digit OTP and emails it.
3. Admin enters OTP at `/admin/verify`.
4. On successful verification, admin record is created permanently.

Each admin is tied to a specific logistics company.

### 5) Admin order visibility

- Admins can only view/manage orders that belong to their own `company_id`.
- Cross-company order visibility is restricted.

### 6) Tracking

- Public tracking page: `/track`
- Admin can update order status from admin order details, and tracking history is stored.

## Key Components

- **Controllers:** `AuthController`, `DashboardController`, `AdminController`, `OrderController`, `WebhookController`, `TrackingController`, `HomeController`
- **Models:** `User`, `Admin`, `AdminRegistrationOtp`, `Order`, `Tracking`
- **Services:** `MailService`, `OrderService`
- **Core:** `Database` (PDO + Postgres URL), `RateLimiter`
- **Routing:** centralized in `public/index.php`

## Setup

1. Install dependencies:

```bash
composer install
```

2. Create `.env` in project root:

```env
DB_URL=postgresql://USER:PASSWORD@HOST:5432/DB_NAME

SMTP_HOST=smtp.gmail.com
SMTP_PORT=587
SMTP_USERNAME=your_gmail_address@gmail.com
SMTP_PASSWORD=your_gmail_app_password
SMTP_ENCRYPTION=tls
SMTP_FROM_ADDRESS=your_gmail_address@gmail.com
```

3. Run database migration:

```bash
php migrate_database.php
```

4. Start local server:

```bash
php -S localhost:8000 -t public router.php
```

## Database Notes

Current schema includes:

- `companies`
- `admins` (includes `company_id`)
- `orders` (includes `customer_name`, `customer_phone`, `pickup_address`, `item_description`, `quantity`, `status`)
- `tracking_history`
- `rate_limits`
- `admin_registration_otps` (temporary admin OTP storage)

## Useful Endpoints

- Public: `/`, `/orders/create`, `/orders/store`, `/track`, `/track/result`
- Company: `/register`, `/verify`, `/login`, `/dashboard`
- Admin: `/admin/register`, `/admin/verify`, `/admin/login`, `/admin/dashboard`, `/admin/orders`
- API: `/webhook`
