# Laravel Auth Package

```php
use App\Models\User;

class User extends Authenticatable implements VerifiesAuthCodes
{
    use HasAuthCodes;

    // ...
}
```
