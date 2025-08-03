<?php

namespace Cone\Laravel\Auth\Interfaces;

use Cone\Laravel\Auth\Models\AuthCode;
use Illuminate\Database\Eloquent\Relations\HasMany;

interface VerifiesAuthCodes
{
    /**
     * Determine whether the user verifies auth codes.
     */
    public function verifiesAuthCodes(): bool;

    /**
     * Send the auth code notification to the user.
     */
    public function sendAuthCodeNotification(AuthCode $code): void;

    /**
     * Get the auth codes for the user.
     */
    public function authCodes(): HasMany;

    /**
     * Generate a new auth code for the user.
     */
    public function generateAuthCode(): AuthCode;
}
