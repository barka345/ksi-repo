<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<UserFactory> */
    use HasFactory;

    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public const ROLE_USER = 'user';
    public const ROLE_ADMIN = 'admin';
    public const ROLE_SUPER_ADMIN = 'super_admin';




    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address'
    ];

     /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];  


    public function outlet(): BelongsTo
    {
        return $this->belongsTo(Outlet::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }


    public function isUser(): bool {
        return $this->role === self::ROLE_USER;
    }

    public function isAdmin(): bool {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isSuperAdmin(): bool {
        return $this->role === self::ROLE_SUPER_ADMIN;
    }

    public function homeRoute(): string {
        return match($this->role) {
            self::ROLE_SUPER_ADMIN => route('super.dashboard'),
            self::ROLE_ADMIN => route('admin.dashboard'),
            default => route('user.dashboard'),
        };
    }

}
