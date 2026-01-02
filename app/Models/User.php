<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // Necessário para a API (App Windows)
use Illuminate\Database\Eloquent\Concerns\HasUuids; // Gerencia os UUIDs automaticamente

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    // inicio do bloco model_user ...
    protected $fillable = [
        'id',         // Permitir inserção manual de UUID (útil em seeders/migrações)
        'name',
        'email',
        'password',
        'is_master',  // Permissão do Super Admin
    ];
    // do bloco model_user.

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_master' => 'boolean', // Garante que venha como true/false do banco
        ];
    }
}