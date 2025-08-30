# Laravel Okta Plugin

A Laravel package to integrate **Okta Authentication** with both **API** and **Web routes**.

---

## 📦 Installation

### 1. Install via Composer
If package is on Packagist:
```bash
composer require kalyanakrishnakondapalli/laravel-okta-plugin
```

If using GitHub directly:
```json
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/kalyanakrishnakondapalli/laravel-okta-plugin.git"
    }
]
```

then run:
```bash
composer require kalyanakrishnakondapalli/laravel-okta-plugin:dev-main
```

---

### 2. Publish Config
Run the following command to publish the package configuration:

```bash
php artisan vendor:publish --provider="LaravelOktaPlugin\OktaServiceProvider" --tag="config"
```

This will create `config/okta.php` in your Laravel app.

---

### 3. Configure `.env`
Add your Okta credentials to `.env`:

```env
OKTA_DOMAIN=dev-xxxxxx.okta.com
OKTA_CLIENT_ID=your_client_id
OKTA_CLIENT_SECRET=your_client_secret
OKTA_REDIRECT_URI=http://localhost:8000/callback
```

---

## 🚀 Usage

### ✅ Web Authentication

Add login and dashboard routes in `routes/web.php`:

```php
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return redirect()->route('okta.login');
});

Route::get('/callback', [\LaravelOktaPlugin\Http\Controllers\OktaController::class, 'callback'])
    ->name('okta.callback');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('okta.web');
```

When a user visits `/login`, they will be redirected to Okta for authentication.  
After successful login, Okta redirects back to `/callback` and stores the user in session.  
The `/dashboard` route is protected by the `okta.web` middleware.

---

### ✅ API Authentication

Protect your API routes in `routes/api.php`:

```php
use Illuminate\Support\Facades\Route;

Route::middleware(['okta.api'])->group(function () {
    Route::get('/user', function () {
        return response()->json(auth()->user());
    });

    Route::get('/secure-data', function () {
        return response()->json([
            'message' => 'This is protected by Okta API authentication.'
        ]);
    });
});
```

Here:
- `okta.api` middleware validates the **JWT access token** from Okta.  
- Clients must pass a valid token in the `Authorization: Bearer <token>` header.  

Example API call with cURL:
```bash
curl -H "Authorization: Bearer <your_token>" http://localhost:8000/api/user
```

---

## 🔐 Middleware

The package provides two middlewares:

- `okta.web` → Protects web routes using Okta OAuth login flow.  
- `okta.api` → Protects API routes by validating Okta JWT tokens.  

Register them automatically via the service provider.

---

## 🛠 Development Setup

If you want to clone and develop this package locally:

```bash
git clone https://github.com/kalyanakrishnakondapalli/laravel-okta-plugin.git
cd laravel-okta-plugin
composer install
```

---

## 📤 Publishing to GitHub & Packagist

### 1. Initialize Git
```bash
git init
git add .
git commit -m "Initial commit - Laravel Okta Plugin"
```

### 2. Create GitHub Repo
Go to [GitHub → New Repository](https://github.com/new)  
Example name: **laravel-okta-plugin**

### 3. Connect Local Repo
```bash
git branch -M main
git remote add origin https://github.com/kalyanakrishnakondapalli/laravel-okta-plugin.git
git push -u origin main
```

### 4. Tag a Release
Packagist requires version tags:
```bash
git tag v1.0.0
git push origin v1.0.0
```

### 5. Submit to Packagist
- Go to [Packagist.org](https://packagist.org/packages/submit)  
- Submit: `https://github.com/kalyanakrishnakondapalli/laravel-okta-plugin`

Now others can install via:
```bash
composer require kalyanakrishnakondapalli/laravel-okta-plugin
```

---

## 👤 Author
**Kalyana Krishna Kondapalli**  
📧 [kalyanakrishnakondapalli@gmail.com](mailto:kalyanakrishnakondapalli@gmail.com)

---

## 📄 License
MIT
