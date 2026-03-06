# TripExplorer — Trip.com API Integration (Laravel + Tailwind CSS)

A **production-ready Laravel application** that integrates with the Trip.com API for hotel & flight search, featuring a premium dark-mode Tailwind CSS UI. Ships with a **swappable mock data layer** so you can run the app immediately and swap to the real API once credentials are obtained.

---

## 🏗 Architecture

```
Browser → Laravel Routes → Controllers → TripComApiContract (Interface)
                                              ├── MockTripComApiService  (TRIPCOM_USE_MOCK=true)
                                              └── TripComApiService      (TRIPCOM_USE_MOCK=false → Trip.com REST API)
                                         ↓
                                   Blade Views + Tailwind CSS
```

### Key Design Patterns

- **Interface-based Service Layer** — `TripComApiContract` defines the API methods; two implementations can be swapped via `.env`
- **Data Transfer Objects (DTOs)** — `HotelDTO` and `FlightDTO` ensure type-safe data mapping from API responses
- **HMAC Authentication** — The real API service signs requests with `hash_hmac('sha256', ...)` for secure API communication
- **Laravel Service Provider** — `TripComServiceProvider` auto-resolves the correct implementation from the container

---

## 📁 Project Structure

```
app/
├── Contracts/
│   └── TripComApiContract.php          # Interface for API methods
├── Http/Controllers/
│   ├── HomeController.php              # Landing page with featured results
│   ├── HotelController.php             # Hotel search & detail
│   ├── FlightController.php            # Flight search & detail
│   └── BookingController.php           # Booking form & confirmation
├── Providers/
│   └── TripComServiceProvider.php      # Binds interface to implementation
└── Services/TripCom/
    ├── TripComApiService.php           # Real API client (HTTP + HMAC)
    ├── MockTripComApiService.php       # Mock data for development
    └── DTOs/
        ├── HotelDTO.php                # Hotel data transfer object
        └── FlightDTO.php               # Flight data transfer object

config/
└── tripcom.php                         # API configuration

routes/
└── web.php                             # All application routes

resources/views/
├── layouts/app.blade.php               # Main layout (nav, footer, Tailwind)
├── home.blade.php                      # Hero + tabbed search + featured
├── hotels/
│   ├── search.blade.php                # Hotel search results grid
│   └── show.blade.php                  # Hotel detail (rooms, amenities)
├── flights/
│   ├── search.blade.php                # Flight results (timeline cards)
│   └── show.blade.php                  # Flight detail (fare breakdown)
└── booking/
    ├── create.blade.php                # Booking form + summary sidebar
    └── success.blade.php               # Confirmation with reference number
```

---

## 🚀 Quick Start

### Prerequisites

- PHP 8.2+
- Composer

### Installation

```bash
# Clone the repository
git clone https://github.com/Echo-Scaler/ai-trip.com-api-test.git
cd ai-trip.com-api-test

# Install dependencies
composer install

# Setup environment
cp .env.example .env
php artisan key:generate

# Create SQLite database
touch database/database.sqlite

# Start the development server
php artisan serve
```

Visit **http://127.0.0.1:8000** — the app runs in mock mode by default.

---

## ⚙️ Configuration

### Environment Variables (`.env`)

```env
# Trip.com API Configuration
TRIPCOM_API_BASE_URL=https://api.trip.com/openapi
TRIPCOM_API_KEY=your-api-key-here
TRIPCOM_API_SECRET=your-api-secret-here
TRIPCOM_USE_MOCK=true          # Set to false for real API
TRIPCOM_TIMEOUT=30
TRIPCOM_CURRENCY=USD
TRIPCOM_LANGUAGE=en
```

### Switching to Real API

1. Apply for API access at [Trip.com Open Platform](https://www.trip.com/openplatform/)
2. Set `TRIPCOM_USE_MOCK=false` in `.env`
3. Add your real `TRIPCOM_API_KEY` and `TRIPCOM_API_SECRET`
4. Adjust API endpoints in `TripComApiService.php` to match Trip.com's official docs

---

## 🛣 Routes

| Method | URI               | Controller                 | Description                      |
| ------ | ----------------- | -------------------------- | -------------------------------- |
| GET    | `/`               | `HomeController@index`     | Home page with search & featured |
| GET    | `/hotels/search`  | `HotelController@search`   | Hotel search results             |
| GET    | `/hotels/{id}`    | `HotelController@show`     | Hotel detail page                |
| GET    | `/flights/search` | `FlightController@search`  | Flight search results            |
| GET    | `/flights/{id}`   | `FlightController@show`    | Flight detail page               |
| GET    | `/booking`        | `BookingController@create` | Booking form                     |
| POST   | `/booking`        | `BookingController@store`  | Process booking (demo)           |

---

## 🔌 API Service Layer

### Interface: `TripComApiContract`

```php
interface TripComApiContract
{
    public function searchHotels(array $params): array;
    public function getHotelDetail(string|int $hotelId): ?array;
    public function searchFlights(array $params): array;
    public function getFlightDetail(string|int $flightId): ?array;
}
```

### Real Service: `TripComApiService`

- Uses Laravel's `Http` facade for HTTP requests
- HMAC-SHA256 request signing with API key + timestamp
- Error handling with logging
- Configurable timeout and base URL

### Mock Service: `MockTripComApiService`

- Returns 6 realistic hotels (Tokyo, Singapore, Bangkok, Hanoi, Seoul, Bali)
- Returns 8 realistic flights (Singapore Airlines, ANA, Korean Air, etc.)
- Supports filtering by city (hotels) and origin/destination (flights)
- Includes detail views with room options, fare breakdowns, etc.

---

## 🎨 UI Features (Tailwind CSS)

- **Dark mode** — Deep gradient backgrounds with glassmorphism cards
- **Responsive** — Mobile-first design with breakpoints
- **Animations** — Floating elements, card hover effects, shine overlays, pulse indicators
- **Icons** — Lucide icons throughout
- **Typography** — Inter font from Google Fonts
- **Components** — Star ratings, discount badges, amenity tags, route timelines, fare breakdowns, progress steps

---

## 📝 Pages Overview

| Page                | Features                                                                                      |
| ------------------- | --------------------------------------------------------------------------------------------- |
| **Home**            | Animated hero, tabbed hotel/flight search, featured cards, architecture info                  |
| **Hotel Search**    | Search form, 3-column card grid, images, ratings, prices, amenity badges                      |
| **Hotel Detail**    | Hero image, description, amenities grid, room options with booking, policies, nearby, reviews |
| **Flight Search**   | Search form, timeline-style route cards, airline info, savings badges                         |
| **Flight Detail**   | Visual route timeline, flight details grid, baggage info, fare breakdown sidebar              |
| **Booking Form**    | Progress steps, traveller info, contact fields, price summary sidebar                         |
| **Booking Success** | Animated checkmark, booking reference, summary, navigation                                    |

---

## 🛠 Tech Stack

- **Backend** — Laravel 12 (PHP 8.2+)
- **Frontend** — Blade templates + Tailwind CSS (Play CDN)
- **Icons** — Lucide
- **Font** — Inter (Google Fonts)
- **Database** — SQLite (for sessions/cache)
- **API Client** — Laravel HTTP (Guzzle)

---

## 📚 Documentation

| Document                                    | Description                                                                                                 |
| ------------------------------------------- | ----------------------------------------------------------------------------------------------------------- |
| [System Architecture](docs/ARCHITECTURE.md) | Layered architecture design, component breakdown, request flow, auth flow, error handling, deployment notes |
| [API Documentation](docs/API.md)            | Full endpoint reference, request/response schemas, data models, error codes, mock data reference            |

---

