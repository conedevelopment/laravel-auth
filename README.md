# Laravel Auth Package

```php
use App\Models\User;

class User extends Authenticatable implements MultiFactorAuthenticatable
{
    use HasAuthCodes;

    // ...
}
```
