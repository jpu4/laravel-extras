# Laravel Extras

**Supercharge Your Laravel Development with Advanced CRUD Generation**

`jpu4/laravel-extras` is a powerful Laravel package that provides artisan generators to accelerate your development workflow. It's designed for Laravel 11+ applications and offers a comprehensive set of tools to generate CRUD operations with a single command.

## ✨ Features

- **One-Command CRUD Generation**: Generate a complete set of CRUD operations with a single command
- **Modern Stubs**: Clean, well-documented, and production-ready code templates
- **Fully Customizable**: Publish and modify stubs to match your coding standards
- **Route Generation**: Automatic route registration for your resources
- **Validation & Security**: Built-in form request validation and security best practices
- **Responsive Views**: Clean, responsive Blade templates with Tailwind CSS
- **Type Safety**: Full PHP type hints and return types
- **Laravel Conventions**: Follows Laravel's conventions and best practices

## 📋 Requirements

- PHP 8.3 or higher
- Laravel 11.x or 12.x
- Composer

## ⚡ Quick Start

1. **Install the package**:

   ```bash
   composer require jpu4/laravel-extras
   ```

2. **Generate a complete CRUD** for your resource:

   ```bash
   php artisan make:crud Product
   ```

3. **Run migrations**:

   ```bash
   php artisan migrate
   ```

4. **Visit your new resource** at `/products`

## 🚀 Usage

### Basic CRUD Generation

```bash
php artisan make:crud Product
```

This will generate:

- **Model**: `app/Models/Product.php`
- **Controller**: `app/Http/Controllers/ProductController.php`
- **FormRequest**: `app/Http/Requests/ProductRequest.php`
- **Migration**: `database/migrations/YYYY_MM_DD_HHMMSS_create_products_table.php`
- **Views**:
  - `resources/views/products/index.blade.php`
  - `resources/views/products/create.blade.php`
  - `resources/views/products/edit.blade.php`
  - `resources/views/products/show.blade.php`
  - `resources/views/products/form.blade.php` (partial)
- **Routes**: Added to `routes/web.php`

### Advanced Options

```bash
# Generate only specific components
php artisan make:crud Product --controller --views

# Force overwrite existing files
php artisan make:crud Product --force

# Generate with all options
php artisan make:crud Product --all
```

## 🔧 Configuration

Publish the configuration file to customize paths, namespaces, and more:

```bash
php artisan vendor:publish --provider="Jpu4\LaravelExtras\Providers\ExtrasServiceProvider" --tag=laravel-extras-config
```

You can then modify `config/laravel-extras.php` to customize:

- File paths for generated components
- Namespaces
- Stub locations
- Default values

## 🎨 Customizing Stubs

Publish the stubs to customize the generated code:

```bash
php artisan vendor:publish --provider="Jpu4\LaravelExtras\Providers\ExtrasServiceProvider" --tag=laravel-extras-stubs
```

This will copy the stubs to `resources/stubs/vendor/laravel-extras/` where you can modify them to match your coding standards.

### Available Stubs

- `controller.stub` - Controller template
- `model.stub` - Model template with common traits
- `migration.stub` - Migration with common fields
- `request.stub` - Form request with validation rules
- `views/` - Blade templates for CRUD operations
- `routes.stub` - Route definitions

## 🛠️ Extending

### Using the LaravelExtras Facade

```php
use Jpu4\LaravelExtras\Facades\LaravelExtras;

// Generate CRUD files
$files = LaravelExtras::generateCrud('Product');
```

### Service Container

```php
$laravelExtras = app('laravel-extras');
// or
$laravelExtras = app(\Jpu4\LaravelExtras\LaravelExtras::class);
```

## 🧪 Testing

```bash
composer test
```

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📄 License

This package is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 🌟 Credits

- [James Ussery](https://github.com/jpu4)
- [All Contributors](../../contributors)

---

<p align="center">
    Made with ❤️ for the Laravel community
</p>

---

## 🎯 Roadmap

* [ ] Additional generators: `make:service`, `make:repository`, `make:resource-api`
* [ ] Publish to Packagist
* [ ] Test suite & GitHub Actions

---

## 📄 License

MIT © James Ussery

