# API Documentation

## TripExplorer — Trip.com API Integration

**Base URL:** `https://api.trip.com/openapi` (configurable via `.env`)  
**Authentication:** HMAC-SHA256 signed requests  
**Response Format:** JSON

---

## Table of Contents

1. [Authentication](#1-authentication)
2. [Hotel Endpoints](#2-hotel-endpoints)
3. [Flight Endpoints](#3-flight-endpoints)
4. [Internal Routes](#4-internal-routes-laravel)
5. [Data Models](#5-data-models)
6. [Error Codes](#6-error-codes)
7. [Mock Data Reference](#7-mock-data-reference)

---

## 1. Authentication

All requests to the Trip.com API require the following headers:

| Header            | Value              | Description                                     |
| ----------------- | ------------------ | ----------------------------------------------- |
| `Authorization`   | `Bearer {API_KEY}` | API key for authentication                      |
| `X-Api-Key`       | `{API_KEY}`        | Duplicate key for legacy support                |
| `X-Timestamp`     | `{unix_timestamp}` | Current Unix timestamp                          |
| `X-Signature`     | `{hmac_signature}` | HMAC-SHA256 of `(key + timestamp)` using secret |
| `Content-Type`    | `application/json` | Request body format                             |
| `Accept`          | `application/json` | Expected response format                        |
| `Accept-Language` | `en`               | Language code                                   |

### Signature Generation (PHP)

```php
$timestamp = time();
$signature = hash_hmac('sha256', $apiKey . $timestamp, $apiSecret);
```

---

## 2. Hotel Endpoints

### 2.1 Search Hotels

**Trip.com API:**

```
POST /hotel/search
```

**Internal Laravel Route:**

```
GET /hotels/search
```

#### Request Parameters (Laravel)

| Parameter   | Type    | Required | Validation     | Description                 |
| ----------- | ------- | -------- | -------------- | --------------------------- |
| `city`      | string  | No       | max:100        | City name or keyword        |
| `check_in`  | date    | No       | valid date     | Check-in date (YYYY-MM-DD)  |
| `check_out` | date    | No       | after:check_in | Check-out date (YYYY-MM-DD) |
| `guests`    | integer | No       | min:1, max:10  | Number of guests            |
| `rooms`     | integer | No       | min:1, max:5   | Number of rooms             |

#### Trip.com API Request Body

```json
{
    "city": "Tokyo",
    "checkIn": "2026-04-01",
    "checkOut": "2026-04-05",
    "guests": 2,
    "rooms": 1,
    "currency": "USD",
    "language": "en"
}
```

#### Response (Array of Hotel Objects)

```json
[
    {
        "id": 1,
        "name": "The Grand Sakura Hotel",
        "address": "1-2-3 Marunouchi, Chiyoda-ku",
        "city": "Tokyo",
        "rating": 4.8,
        "stars": 5,
        "price_per_night": 285.0,
        "original_price": 350.0,
        "currency": "USD",
        "image_url": "https://images.unsplash.com/...",
        "amenities": ["Free WiFi", "Pool", "Spa", "Restaurant"],
        "description": "Experience luxury in the heart of Tokyo...",
        "latitude": 35.6812,
        "longitude": 139.7671,
        "review_count": 2847
    }
]
```

---

### 2.2 Get Hotel Detail

**Trip.com API:**

```
GET /hotel/{hotelId}?currency=USD&language=en
```

**Internal Laravel Route:**

```
GET /hotels/{id}
```

#### Response (Single Hotel Object + Detail Fields)

Same as search response plus:

```json
{
  "...base hotel fields...",
  "rooms": [
    {
      "name": "Deluxe Double Room",
      "price": 285.00,
      "max_guests": 2,
      "bed_type": "King Bed",
      "size": "35 m²",
      "includes": ["Breakfast", "Free Cancellation"]
    }
  ],
  "policies": {
    "check_in": "15:00",
    "check_out": "11:00",
    "cancellation": "Free cancellation up to 24 hours before check-in",
    "children": "Children of all ages are welcome",
    "pets": "Pets are not allowed"
  },
  "nearby": [
    "Airport — 45 min drive",
    "City Center — 10 min walk"
  ]
}
```

---

## 3. Flight Endpoints

### 3.1 Search Flights

**Trip.com API:**

```
POST /flight/search
```

**Internal Laravel Route:**

```
GET /flights/search
```

#### Request Parameters (Laravel)

| Parameter        | Type    | Required | Validation                    | Description                      |
| ---------------- | ------- | -------- | ----------------------------- | -------------------------------- |
| `origin`         | string  | No       | max:100                       | Origin airport code or city      |
| `destination`    | string  | No       | max:100                       | Destination airport code or city |
| `departure_date` | date    | No       | valid date                    | Departure date (YYYY-MM-DD)      |
| `return_date`    | date    | No       | after_or_equal:departure_date | Return date                      |
| `passengers`     | integer | No       | min:1, max:9                  | Number of passengers             |
| `cabin_class`    | string  | No       | in:Economy,Business,First     | Cabin class                      |

#### Trip.com API Request Body

```json
{
    "origin": "NRT",
    "destination": "SIN",
    "departureDate": "2026-04-01",
    "returnDate": null,
    "passengers": 1,
    "cabinClass": "Economy",
    "currency": "USD",
    "language": "en"
}
```

#### Response (Array of Flight Objects)

```json
[
    {
        "id": 1,
        "airline": "Singapore Airlines",
        "airline_logo": "https://...",
        "flight_number": "SQ 872",
        "origin": "NRT",
        "origin_city": "Tokyo (Narita)",
        "destination": "SIN",
        "destination_city": "Singapore (Changi)",
        "departure_time": "10:30",
        "arrival_time": "17:05",
        "duration": "7h 35m",
        "price": 489.0,
        "original_price": 620.0,
        "currency": "USD",
        "cabin_class": "Economy",
        "stops": 0,
        "aircraft": "Airbus A380-800",
        "baggage": "30kg checked + 7kg cabin"
    }
]
```

---

### 3.2 Get Flight Detail

**Trip.com API:**

```
GET /flight/{flightId}?currency=USD&language=en
```

**Internal Laravel Route:**

```
GET /flights/{id}
```

#### Response (Single Flight Object + Detail Fields)

Same as search response plus:

```json
{
  "...base flight fields...",
  "fare_breakdown": {
    "base_fare": 366.75,
    "taxes": 73.35,
    "surcharges": 34.23,
    "service_fee": 14.67
  },
  "flight_details": {
    "departure_terminal": "Terminal 2",
    "arrival_terminal": "Terminal 1",
    "meal": "Complimentary meals and beverages",
    "entertainment": "Personal in-flight entertainment system",
    "wifi": "Available (paid)",
    "power": "USB and AC power at every seat"
  }
}
```

---

## 4. Internal Routes (Laravel)

### Booking Routes

#### `GET /booking`

Shows the booking form pre-filled with selected item.

**Query Parameters:**

| Parameter   | Type   | Description                 |
| ----------- | ------ | --------------------------- |
| `type`      | string | `hotel` or `flight`         |
| `item_id`   | string | ID of the hotel/flight      |
| `item_name` | string | Display name                |
| `price`     | float  | Total price                 |
| `currency`  | string | 3-letter code (e.g., `USD`) |

#### `POST /booking`

Processes the booking (demo mode — generates reference number).

**Form Fields:**

| Field        | Type    | Required | Validation      |
| ------------ | ------- | -------- | --------------- |
| `type`       | string  | Yes      | in:hotel,flight |
| `item_id`    | string  | Yes      | —               |
| `item_name`  | string  | Yes      | —               |
| `price`      | numeric | Yes      | min:0           |
| `currency`   | string  | Yes      | size:3          |
| `first_name` | string  | Yes      | max:100         |
| `last_name`  | string  | Yes      | max:100         |
| `email`      | email   | Yes      | max:255         |
| `phone`      | string  | Yes      | max:20          |

**Response:** Redirects to booking confirmation page with reference number `TC{YYMMDD}{RAND}`.

---

## 5. Data Models

### HotelDTO

| Field           | Type        | Nullable | Description            |
| --------------- | ----------- | -------- | ---------------------- |
| `id`            | int\|string | No       | Unique identifier      |
| `name`          | string      | No       | Hotel name             |
| `address`       | string      | No       | Street address         |
| `city`          | string      | No       | City name              |
| `rating`        | float       | No       | Guest rating (0–5)     |
| `stars`         | int         | No       | Star category (1–5)    |
| `pricePerNight` | float       | No       | Price per night        |
| `currency`      | string      | No       | 3-letter currency code |
| `imageUrl`      | string      | No       | Cover image URL        |
| `amenities`     | array       | No       | List of amenity names  |
| `description`   | string      | No       | Full description       |
| `latitude`      | float       | Yes      | GPS latitude           |
| `longitude`     | float       | Yes      | GPS longitude          |
| `originalPrice` | float       | Yes      | Price before discount  |
| `reviewCount`   | int         | Yes      | Number of reviews      |

### FlightDTO

| Field             | Type        | Nullable | Description                   |
| ----------------- | ----------- | -------- | ----------------------------- |
| `id`              | int\|string | No       | Unique identifier             |
| `airline`         | string      | No       | Airline name                  |
| `airlineLogo`     | string      | No       | Airline logo URL              |
| `flightNumber`    | string      | No       | Flight number (e.g., SQ 872)  |
| `origin`          | string      | No       | Origin airport code           |
| `originCity`      | string      | No       | Origin city name              |
| `destination`     | string      | No       | Destination airport code      |
| `destinationCity` | string      | No       | Destination city name         |
| `departureTime`   | string      | No       | Departure time (HH:MM)        |
| `arrivalTime`     | string      | No       | Arrival time (HH:MM)          |
| `duration`        | string      | No       | Flight duration               |
| `price`           | float       | No       | Ticket price                  |
| `currency`        | string      | No       | 3-letter currency code        |
| `cabinClass`      | string      | No       | Economy / Business / First    |
| `stops`           | int         | No       | Number of stops (0 = direct)  |
| `aircraft`        | string      | Yes      | Aircraft type                 |
| `originalPrice`   | float       | Yes      | Price before discount         |
| `baggage`         | string      | Yes      | Baggage allowance description |

---

## 6. Error Codes

| HTTP Code | Description                          | Handling                     |
| --------- | ------------------------------------ | ---------------------------- |
| `200`     | Success                              | Parse response data          |
| `400`     | Bad request (invalid params)         | Return empty results + log   |
| `401`     | Unauthorized (invalid API key)       | Log error, return empty      |
| `403`     | Forbidden (insufficient permissions) | Log error, return empty      |
| `404`     | Resource not found                   | Return `null`, show 404 page |
| `422`     | Validation error (Laravel)           | Redirect back with errors    |
| `429`     | Rate limited                         | Log warning, return empty    |
| `500`     | Server error                         | Log error, return empty      |

All API errors are caught in `TripComApiService` and logged via `Log::error()`.

---

## 7. Mock Data Reference

### Available Hotels

| ID  | Name                      | City      | Stars      | Price/Night |
| --- | ------------------------- | --------- | ---------- | ----------- |
| 1   | The Grand Sakura Hotel    | Tokyo     | ⭐⭐⭐⭐⭐ | $285        |
| 2   | Marina Bay Sands          | Singapore | ⭐⭐⭐⭐⭐ | $420        |
| 3   | Riverside Boutique Resort | Bangkok   | ⭐⭐⭐⭐   | $145        |
| 4   | Hanoi Heritage Hotel      | Hanoi     | ⭐⭐⭐⭐   | $98         |
| 5   | Seoul Sky Tower Hotel     | Seoul     | ⭐⭐⭐⭐⭐ | $310        |
| 6   | Bali Serenity Villas      | Bali      | ⭐⭐⭐⭐⭐ | $195        |

### Available Flights

| ID  | Airline            | Route     | Duration | Price |
| --- | ------------------ | --------- | -------- | ----- |
| 1   | Singapore Airlines | NRT → SIN | 7h 35m   | $489  |
| 2   | ANA                | NRT → BKK | 6h 50m   | $385  |
| 3   | Korean Air         | ICN → NRT | 2h 15m   | $215  |
| 4   | Cathay Pacific     | HKG → DPS | 4h 35m   | $342  |
| 5   | Japan Airlines     | HND → HAN | 5h 20m   | $298  |
| 6   | Thai Airways       | BKK → SIN | 2h 25m   | $178  |
| 7   | Emirates           | NRT → DXB | 11h 45m  | $725  |
| 8   | Vietnam Airlines   | SGN → ICN | 5h 25m   | $265  |
