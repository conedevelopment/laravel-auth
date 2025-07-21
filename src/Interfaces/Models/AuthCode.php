<?php

namespace Cone\Laravel\Auth\Interfaces\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface AuthCode
{
    /**
     * Get the user for the model.
     */
    public function user(): BelongsTo;

    /**
     * Determine whether the code is active.
     */
    public function isActive(): bool;

    /**
     * Determine whether the code is expired.
     */
    public function isExpired(): bool;
}
