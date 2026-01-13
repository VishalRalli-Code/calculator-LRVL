## Purpose

This project is a small Laravel demo built to showcase:
- Basic Laravel routing (web & API)
- Controller-based request handling
- Blade templating
- Simple JSON API design

# Calculator-LRVL

A small Laravel-based calculator project demonstrating basic routing, controller logic, and a simple web UI for arithmetic operations.

## Features

- Web-based calculator UI (Blade view).
- Arithmetic API endpoints for add, subtract, multiply, divide.
- Simple controller logic in `CalculatorController`.

## Requirements

- PHP 8.0+ (or the version required by your Laravel installation)
- Composer
- Node.js & npm (for frontend assets, optional)
- XAMPP or another local web server (this repository is currently located under XAMPP `htdocs`)

## Installation

1. Install PHP dependencies:

```bash
composer install
```

2. Install frontend dependencies (optional):

```bash
npm install
npm run build   # or npm run dev for development
```

3. Copy `.env.example` to `.env` and adjust settings (database, app URL) if needed:

```bash
cp .env.example .env
php artisan key:generate
```

## Running the project

You can run the app using the built-in server or serve via XAMPP.

- Using Artisan (recommended for development):

```bash
php artisan serve
# then open http://localhost:8000
```

- Using XAMPP: place the project in `htdocs` (already in `c:\xampp\htdocs\calculator-LRVL`), then open:

http://localhost/calculator-LRVL/public

## Routes & Usage

- Web UI: visit the main page (likely `/` or `/calculator`) to use the calculator in a browser. See the view at [resources/views/calculator.blade.php](resources/views/calculator.blade.php).
- API endpoints (example formats):

- POST /api/calc with JSON body:

```json
{
	"operation": "add",
	"a": 2,
	"b": 3
}
```

Or call simple query routes if implemented (adjust based on the app's `routes/web.php` and `routes/api.php`):

```bash
curl -X POST http://localhost:8000/api/calc -H "Content-Type: application/json" -d '{"operation":"multiply","a":6,"b":7}'
```

Check the route definitions in [routes/web.php](routes/web.php) and [routes/api.php](routes/api.php).

Controller logic lives in [app/Http/Controllers/CalculatorController.php](app/Http/Controllers/CalculatorController.php).

## Tests

This repo includes a PHPUnit configuration. Run tests with:

```bash
vendor/bin/phpunit
```

## Contributing

- Fork the repository.
- Create a feature branch.
- Make changes and add tests where appropriate.
- Open a pull request describing your changes.

## Helpful Files

- Web routes: [routes/web.php](routes/web.php)
- API routes: [routes/api.php](routes/api.php)
- Calculator controller: [app/Http/Controllers/CalculatorController.php](app/Http/Controllers/CalculatorController.php)
- UI view: [resources/views/calculator.blade.php](resources/views/calculator.blade.php)

## License

This project uses the MIT license (see the `LICENSE` file if present).

---

If you want, I can also:

- Add example requests to the README based on the actual routes in `routes/api.php`.
- Create a tiny Postman collection or Swagger/OpenAPI spec for the endpoints.

Tell me which you'd prefer.
