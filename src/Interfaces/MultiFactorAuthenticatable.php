<?php

namespace Cone\Laravel\Auth\Interfaces;

use Cone\Laravel\Auth\Models\AuthCode;
use Illuminate\Database\Eloquent\Relations\HasMany;

interface MultiFactorAuthenticatable
{
    /**
     * Get the auth codes for the user.
     */
    public function authCodes(): HasMany;

    /**
     * Generate a new auth code for the user.
     */
    public function generateAuthCode(): AuthCode;
}
