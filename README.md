# Laravel Auth Package

## Requirements

- PHP 8.4
- MySQL 8+
- Laravel 12+

## Installation

```sh
composer require conedevelopment/laravel-auth
```

## Config

```php
use App\Models\User;

class User extends Authenticatable implements VerifiesAuthCodes
{
    use HasAuthCodes;

    // ...
}
```

## Commands

```sh
php artisan auth:clear-expired-auth-codes
```
