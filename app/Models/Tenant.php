<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 
use Illuminate\Database\Eloquent\Factories\HasFactory; // Adicionado
use Illuminate\Support\Str;

class Tenant extends Model
{
    use SoftDeletes, HasFactory; // Adicionado HasFactory

    /**
     * Define os campos que podem ser preenchidos em massa.
     */
    protected $fillable = [
        'seller_name', // Nome do Revendedor
        'name',        // Nome da Revenda
        'document',    // CPF/CNPJ
        'email',       // E-mail
        'phone',       // Telefone
        'is_active',   // Status de Bloqueio (True = Ativo, False = Bloqueado)
    ];

    /**
     * Configuração para UUID.
     */
    protected $keyType = 'string';
    public $incrementing = false;

    /**
     * Evento Booted: Gera o UUID automaticamente.
     */
    protected static function booted()
    {
        static::creating(function ($tenant) {
            if (empty($tenant->id)) {
                $tenant->id = (string) Str::uuid();
            }
        });
    }

    /**
     * Relacionamento: Uma Revenda (Tenant) possui um Usuário vinculado.
     */
    public function user()
    {
        return $this->hasOne(User::class);
    }

    /**
     * Relacionamento: Uma Revenda possui muitas Lojas.
     */
    public function stores()
    {
        return $this->hasMany(Store::class);
    }
}