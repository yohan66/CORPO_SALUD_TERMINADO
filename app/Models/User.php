<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'usuarios';

    const DELETED_AT = 'eliminado_el';
    const UPDATED_AT = null;

    protected $fillable = [
        'nombre',
        'email',
        'cedula',
        'password',
        'rol',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'two_factor_confirmed_at' => 'datetime',
    ];

    public function tieneRol(string ...$roles): bool
    {
        return in_array($this->rol, $roles);
    }

    public function hasVerifiedTwoFactor(): bool
    {
        return !is_null($this->two_factor_confirmed_at);
    }
}
