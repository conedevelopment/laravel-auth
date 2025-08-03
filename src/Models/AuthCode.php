<?php

namespace Cone\Laravel\Auth\Models;

use Cone\Laravel\Auth\Interfaces\Models\AuthCode as Contract;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Date;

class AuthCode extends Model implements Contract
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'expires_at' => 'datetime',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'auth_codes';

    /**
     * Get the user for the model.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(Config::get('auth.providers.users.model'));
    }

    /**
     * Determine whether the code is active.
     */
    public function isActive(): bool
    {
        return $this->expires_at->gt(Date::now());
    }

    /**
     * Determine whether the code is expired.
     */
    public function isExpired(): bool
    {
        return ! $this->isActive();
    }

    /**
     * Scope the query only to include the active codes.
     */
    #[Scope]
    protected function active(Builder $query): Builder
    {
        return $query->where($query->qualifyColumn('expires_at'), '>', Date::now());
    }

    /**
     * Scope the query only to include the expired codes.
     */
    #[Scope]
    protected function expired(Builder $query): Builder
    {
        return $query->where($query->qualifyColumn('expires_at'), '<=', Date::now());
    }
}
