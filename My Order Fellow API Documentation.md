# My Order Fellow API Documentation

This document reflects the current flow of the My Order Fellow platform.

---

## 1. Platform Flow (Quick Overview)

1. Company registers at `/register` and verifies OTP at `/verify`.
2. Company submits KYC from `/dashboard`.
3. Admin reviews and approves KYC from `/admin/dashboard`.
4. Company gets API key access on dashboard.
5. Orders are created either:
   - via API webhook `POST /webhook`, or
   - via manual UI form at `/orders/create`.
6. Customers track orders through `/track`.

---

## 2. Authentication for API Access

After KYC approval, a company can generate/retrieve its API key from the dashboard.

For webhook requests, include:

- Header: `X-API-KEY: <your_api_key>`

---

## 3. Order Webhook API

### Endpoint

| Detail       | Value                   |
| ------------ | ----------------------- |
| URL          | `[Your Domain]/webhook` |
| Method       | `POST`                  |
| Auth         | Required (`X-API-KEY`)  |
| Content Type | `application/json`      |

### Request Body

| Field               | Type          | Required | Description                      |
| ------------------- | ------------- | -------- | -------------------------------- |
| `external_order_id` | String        | Yes      | Merchant-side unique order ID    |
| `customer_email`    | String        | Yes      | Customer email for notifications |
| `delivery_address`  | String        | Yes      | Full delivery address            |
| `items`             | Array<Object> | Yes      | Product list (`name`, `qty`)     |

Example:

```json
{
  "external_order_id": "ORD-1234-XYZ",
  "customer_email": "jane.doe@mail.com",
  "delivery_address": "456 Commerce Road, Akwa Ibom, Nigeria",
  "items": [
    { "name": "Flash Drive", "qty": 2 },
    { "name": "Accessory Pack", "qty": 1 }
  ]
}
```

### Success Response

Status: `201 Created`

```json
{
  "message": "Order created",
  "order_id": 42
}
```

### Error Responses

| Status | Meaning                 | Example                                              |
| ------ | ----------------------- | ---------------------------------------------------- |
| `401`  | Missing/invalid API key | `{"error":"Unauthorized"}`                           |
| `400`  | Invalid JSON payload    | `{"error":"Invalid JSON payload"}`                   |
| `405`  | Wrong HTTP method       | `Method Not Allowed`                                 |
| `429`  | Rate limit exceeded     | `{"status":"error","message":"Rate limit exceeded"}` |

### Rate Limit

- `10 requests / minute / IP`

---

## 4. Manual Order Placement (UI)

For authenticated company users, orders can also be created from:

- `GET /orders/create` (form page)
- `POST /orders/create` (form submit)

Form fields:

- `item_description` (required)
- `quantity` (required, integer >= 1)
- `delivery_address` (required)
- `status` (defaults/fixed to `pending`)

This flow creates the order using existing MVC controllers/models and records tracking history.

---

## 5. Public Tracking Endpoint

### Endpoint

| Detail       | Value                               |
| ------------ | ----------------------------------- |
| URL          | `[Your Domain]/track/result`        |
| Method       | `POST`                              |
| Auth         | None                                |
| Content Type | `application/x-www-form-urlencoded` |

### Request Field

| Field         | Type   | Description                   |
| ------------- | ------ | ----------------------------- |
| `tracking_id` | String | The order `external_order_id` |

### Response

Returns an HTML tracking page with current status + status history.

### Common Errors (shown on page)

- `Please enter a tracking ID.`
- `Tracking ID not found.`
- `Rate limit exceeded. Please try again later.`

### Rate Limit

- `10 requests / minute / IP`

---

## 6. Admin Registration Flow (Security Update)

Admin registration now uses email OTP verification.

1. `POST /admin/register` → pending registration + OTP email
2. `POST /admin/verify` → OTP verification + permanent admin creation

No hardcoded master key is used in the current flow.

---
