# System Architecture Design

## TripExplorer — Trip.com API Integration

**Version:** 1.0  
**Date:** 2026-03-06  
**Stack:** Laravel 12 · PHP 8.2+ · Tailwind CSS · SQLite

---

## 1. System Overview

TripExplorer is a server-rendered Laravel application that integrates with Trip.com's Partner API to provide hotel and flight search/booking capabilities. It follows a **layered architecture** with clear separation of concerns.

```
┌─────────────────────────────────────────────────────────────────┐
│                        CLIENT (Browser)                         │
│                  HTML + Tailwind CSS + Lucide                   │
└─────────────────────┬───────────────────────────────────────────┘
                      │ HTTP (GET/POST)
┌─────────────────────▼───────────────────────────────────────────┐
│                     PRESENTATION LAYER                          │
│  ┌──────────┐  ┌─────────────┐  ┌────────────┐  ┌───────────┐  │
│  │  Routes   │→│ Controllers  │→│ Blade Views │→│  Response  │  │
│  │ (web.php) │  │ (Validated)  │  │ (Tailwind)  │  │  (HTML)   │  │
│  └──────────┘  └──────┬──────┘  └────────────┘  └───────────┘  │
└─────────────────────────┼───────────────────────────────────────┘
                          │ Dependency Injection
┌─────────────────────────▼───────────────────────────────────────┐
│                      SERVICE LAYER                              │
│                                                                 │
│  ┌───────────────────────────────────────────────────────────┐  │
│  │              TripComApiContract (Interface)                │  │
│  │  searchHotels() · getHotelDetail()                        │  │
│  │  searchFlights() · getFlightDetail()                      │  │
│  └──────────┬────────────────────────────────┬───────────────┘  │
│             │                                │                  │
│  ┌──────────▼──────────┐      ┌──────────────▼──────────────┐  │
│  │ MockTripComApiService│      │    TripComApiService         │  │
│  │ (Static sample data) │      │ (HTTP + HMAC-SHA256 auth)   │  │
│  │ TRIPCOM_USE_MOCK=true│      │ TRIPCOM_USE_MOCK=false      │  │
│  └─────────────────────┘      └──────────────┬──────────────┘  │
│                                              │                  │
└──────────────────────────────────────────────┼──────────────────┘
                                               │ HTTPS
┌──────────────────────────────────────────────▼──────────────────┐
│                     EXTERNAL API LAYER                          │
│                   Trip.com REST API                             │
│              (api.trip.com/openapi/*)                           │
└────────────────────────────────────────────────────────────────┘
```

---

## 2. Component Architecture

### 2.1 Presentation Layer

```
┌─────────────────────────────────────────────────────────┐
│                    Blade Templates                       │
│                                                         │
│  layouts/app.blade.php ─── Base layout (nav, footer)    │
│       │                                                 │
│       ├── home.blade.php                                │
│       ├── hotels/search.blade.php                       │
│       ├── hotels/show.blade.php                         │
│       ├── flights/search.blade.php                      │
│       ├── flights/show.blade.php                        │
│       ├── booking/create.blade.php                      │
│       └── booking/success.blade.php                     │
│                                                         │
│  Styling: Tailwind CSS (CDN) + Custom CSS               │
│  Icons: Lucide Icons                                    │
│  Font: Inter (Google Fonts)                             │
└─────────────────────────────────────────────────────────┘
```

### 2.2 Controller Layer

| Controller          | Methods               | Responsibility                                         |
| ------------------- | --------------------- | ------------------------------------------------------ |
| `HomeController`    | `index()`             | Render landing page with featured hotels/flights       |
| `HotelController`   | `search()`, `show()`  | Validate search input, call API, render results/detail |
| `FlightController`  | `search()`, `show()`  | Validate search input, call API, render results/detail |
| `BookingController` | `create()`, `store()` | Display booking form, process & confirm booking        |

All controllers use **constructor dependency injection** to receive `TripComApiContract`.

### 2.3 Service Layer

```
TripComApiContract (Interface)
├── searchHotels(array $params): array
├── getHotelDetail(string|int $id): ?array
├── searchFlights(array $params): array
└── getFlightDetail(string|int $id): ?array

Implementations:
├── MockTripComApiService   → Static data, filtering by city/origin/destination
└── TripComApiService       → HTTP client with HMAC-SHA256 request signing
```

**Service Provider:** `TripComServiceProvider` reads `config('tripcom.use_mock')` and binds the appropriate implementation as a **singleton** in the IoC container.

### 2.4 Data Transfer Objects

```php
HotelDTO {
    id, name, address, city, rating, stars,
    pricePerNight, currency, imageUrl,
    amenities[], description,
    latitude?, longitude?, originalPrice?, reviewCount?
}

FlightDTO {
    id, airline, airlineLogo, flightNumber,
    origin, originCity, destination, destinationCity,
    departureTime, arrivalTime, duration,
    price, currency, cabinClass, stops,
    aircraft?, originalPrice?, baggage?
}
```

Both DTOs provide `fromArray()` (factory) and `toArray()` (serialization) methods.

---

## 3. Request Flow

```
1. User submits hotel search form
       │
2. GET /hotels/search?city=Tokyo&check_in=...&check_out=...
       │
3. Laravel Router → HotelController@search
       │
4. Request validation (city, check_in, check_out, guests, rooms)
       │
5. $this->tripComApi->searchHotels($params)
       │
       ├── [MOCK]  Filter static hotel array by city name
       │
       └── [REAL]  POST api.trip.com/openapi/hotel/search
                   Headers: Authorization, X-Api-Key, X-Timestamp, X-Signature
                   Body: { city, checkIn, checkOut, guests, rooms, currency }
                   Response → map each hotel through HotelDTO::fromArray()
       │
6. Return hotels array to Blade view
       │
7. Render hotels/search.blade.php with Tailwind CSS cards
       │
8. HTML response to browser
```

---

## 4. Authentication Flow (Real API)

```
┌─────────────────────────────────────────┐
│           Request Signing               │
│                                         │
│  timestamp = time()                     │
│  signature = HMAC-SHA256(               │
│      key + timestamp,                   │
│      secret                             │
│  )                                      │
│                                         │
│  Headers:                               │
│    Authorization: Bearer {api_key}      │
│    X-Api-Key: {api_key}                 │
│    X-Timestamp: {timestamp}             │
│    X-Signature: {signature}             │
│    Content-Type: application/json       │
│    Accept-Language: {language}           │
└─────────────────────────────────────────┘
```

---

## 5. Configuration Management

```
.env                          config/tripcom.php
──────────────────────        ──────────────────────
TRIPCOM_API_BASE_URL    →     'base_url'
TRIPCOM_API_KEY         →     'api_key'
TRIPCOM_API_SECRET      →     'api_secret'
TRIPCOM_USE_MOCK        →     'use_mock'
TRIPCOM_TIMEOUT         →     'timeout'
TRIPCOM_CURRENCY        →     'currency'
TRIPCOM_LANGUAGE        →     'language'
```

---

## 6. Error Handling Strategy

| Layer              | Strategy                                                                       |
| ------------------ | ------------------------------------------------------------------------------ |
| **Controller**     | Laravel validation (`$request->validate()`) with auto-redirect on failure      |
| **Service (Real)** | Try-catch around HTTP calls; log errors via `Log::error()`; return `null`/`[]` |
| **Service (Mock)** | No external calls; always returns data                                         |
| **View**           | 404 abort page when hotel/flight not found; empty state UI for no results      |

---

## 7. Security Considerations

- **Input validation** on all controller methods (type, size, format)
- **CSRF protection** on POST routes (Laravel default)
- **HMAC request signing** prevents API key interception
- **Environment variables** for secrets (never committed to git)
- **Rate limiting** — inherits Laravel's default throttle middleware

---

## 8. Deployment Notes

| Environment     | Tailwind CSS | Session        | Cache | Mock    |
| --------------- | ------------ | -------------- | ----- | ------- |
| **Development** | CDN (Play)   | File           | File  | `true`  |
| **Production**  | npm build    | Redis/Database | Redis | `false` |

For production, install Tailwind via npm and run `npm run build` to produce optimized CSS.
