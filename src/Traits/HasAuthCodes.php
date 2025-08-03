<?php

namespace Cone\Laravel\Auth\Traits;

use Cone\Laravel\Auth\Interfaces\Models\AuthCode as AuthCodeContract;
use Cone\Laravel\Auth\Models\AuthCode;
use Cone\Laravel\Auth\Notifications\AuthCodeNotification;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Date;

trait HasAuthCodes
{
    /**
     * Determine whether the user verifies auth codes.
     */
    public function verifiesAuthCodes(): bool
    {
        return true;
    }

    /**
     * Send the auth code notification to the user.
     */
    public function sendAuthCodeNotification(AuthCode $code): void
    {
        $this->notify(new AuthCodeNotification($code));
    }

    /**
     * Get the auth codes for the user.
     */
    public function authCodes(): HasMany
    {
        return $this->hasMany(get_class(App::make(AuthCodeContract::class)))->active();
    }

    /**
     * Generate a new auth code for the user.
     */
    public function generateAuthCode(): AuthCode
    {
        $this->authCodes()->delete();

        $code = $this->authCodes()->make()->forceFill([
            'code' => mt_rand(100000, 999999),
            'expires_at' => Date::now()->addMinutes(5),
        ]);

        $code->save();

        return $code;
    }
}
