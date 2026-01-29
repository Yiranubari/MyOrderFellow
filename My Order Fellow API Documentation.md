# My Order Fellow API Documentation

Welcome to the My Order Fellow API!

---

## 1. Getting Started: Your API Key

Think of your **API Key** as your secret handshake. It tells our system who you are and that you're allowed to send us data.

You'll find your unique API Key in your Partner Dashboard after your KYC application has been approved by our admin team.

**How to use it:** You must include this key in a special header called `X-API-KEY` for every request you send to our Webhook.

---

## 2. Order Webhook API

This is the main way you'll tell us about a new order placed on your store.

### Endpoint Details

| Detail             | Value                                 |
| ------------------ | ------------------------------------- |
| **URL**            | `[Your Domain]/webhook`               |
| **Method**         | `POST`                                |
| **Authentication** | Required. Use the `X-API-KEY` header. |

### Request Body

You need to send a JSON payload with the details of the order. Here’s what we need:

| Field               | Type             | Description                                                                        | Example                                  |
| ------------------- | ---------------- | ---------------------------------------------------------------------------------- | ---------------------------------------- |
| `external_order_id` | String           | Your unique ID for this order. This is what your customer will use to track it.    | `ORD-9876-TEST`                          |
| `customer_email`    | String           | The customer's email address. We use this to send confirmation and status updates. | `customer@example.com`                   |
| `delivery_address`  | String           | The full address where the order is being shipped.                                 | `123 Fake Street, Lagos, Nigeria`        |
| `items`             | Array of Objects | A list of products in the order.                                                   | `[{"name": "Wireless Mouse", "qty": 1}]` |

**Example Request (JSON):**

```json
{
  "external_order_id": "ORD-1234-XYZ",
  "customer_email": "jane.doe@mail.com",
  "delivery_address": "456 Commerce Road, Akwa Ibom, Nigeria",
  "items": [
    {
      "name": "Flash Drive",
      "qty": 2
    },
    {
      "name": "Accessory Pack",
      "qty": 1
    }
  ]
}
```

### Response

If everything goes well, you'll get a `201 Created` status and a simple JSON response confirming the order was saved in our system.

```json
{
  "message": "Order created",
  "order_id": 42
}
```

### Error Responses

Sometimes things go wrong. If you get a response other than `201 Created`, here is what it means:

| HTTP Status Code         | Reason                                                 | Response Body Example                                   |
| :----------------------- | :----------------------------------------------------- | :------------------------------------------------------ |
| `401 Unauthorized`       | Your `X-API-KEY` is missing or invalid.                | `{"error": "Unauthorized"}`                             |
| `400 Bad Request`        | The request body you sent was not valid JSON.          | `{"error": "Invalid JSON payload"}`                     |
| `405 Method Not Allowed` | You used a method other than `POST` (e.g., `GET`).     | `Method Not Allowed` (Plain Text)                       |
| `429 Too Many Requests`  | You have exceeded the limit of 20 requests per minute. | `{"status": "error", "message": "Rate limit exceeded"}` |

### Important: Rate Limiting

To keep our system stable, we limit the number of requests. Please be mindful of this:

- **Limit:** You can send up to **20 requests per minute** from a single IP address.

- **What happens if you exceed it:** You will receive a `429 Too Many Requests` status. Just wait a minute and try again!

---

## 3. Public Tracking API

This is the simple way for anyone (especially your customers) to check the status of an order using the unique ID you provided.

### Endpoint Details

| Detail             | Value                                     |
| ------------------ | ----------------------------------------- |
| **URL**            | `[Your Domain]/track/result`              |
| **Method**         | `POST`                                    |
| **Authentication** | None required. This is a public endpoint. |

### Request Body

This endpoint expects a simple form submission (not JSON) with the tracking ID.

| Field         | Type   | Description                                          |
| ------------- | ------ | ---------------------------------------------------- |
| `tracking_id` | String | The `external_order_id` you sent us via the Webhook. |

**Example Request:**

If you were using a tool like `curl` or a programming library, you would send the data as `application/x-www-form-urlencoded`.

### Response

The system will render an HTML page showing the current status and the full history of the order.

### Error Responses

If the tracking ID is not found or if you make too many requests, the system will display an error message on the page instead of the tracking history.

| Error Message                              | Reason                                                         |
| :----------------------------------------- | :------------------------------------------------------------- |
| `Tracking ID not found.`                   | The tracking ID you entered does not exist in our system.      |
| `Please enter a tracking ID.`              | You submitted the form without entering a tracking ID.         |
| `Too many attempts. Please wait a minute.` | You have exceeded the limit of 5 tracking requests per minute. |

### Important: Rate Limiting

Even though this is a public endpoint, we have a limit to prevent abuse:

- **Limit:** You can check the status up to **5 times per minute** from a single IP address.

- **What happens if you exceed it:** The system will display an error message: "Too many attempts. Please wait a minute."

---
