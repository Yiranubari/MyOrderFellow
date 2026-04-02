# My Order Fellow

My Order Fellow is a custom PHP MVC application for company onboarding, order ingestion, manual order placement, admin operations, and shipment tracking.

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
- **Manual placement page:** `/orders/create`

Manual order form fields:

- `item_description`
- `quantity`
- `delivery_address`
- `status` (fixed/default `pending`)

### 4) Admin registration (secure OTP flow)

Admin signup no longer uses a hardcoded master key.

1. Open `/admin/register` and submit name, email, password.
2. System generates a secure 6-digit OTP and emails it.
3. Admin enters OTP at `/admin/verify`.
4. On successful verification, admin record is created permanently.

### 5) Tracking

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
- `admins`
- `orders` (includes `item_description`, `quantity`, `status`)
- `tracking_history`
- `rate_limits`
- `admin_registration_otps` (temporary admin OTP storage)

## Useful Endpoints

- Company: `/register`, `/verify`, `/login`, `/dashboard`, `/orders/create`
- Admin: `/admin/register`, `/admin/verify`, `/admin/login`, `/admin/dashboard`
- API: `/webhook`
- Tracking: `/track`, `/track/result`
