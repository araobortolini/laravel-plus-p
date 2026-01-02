<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tenant extends Model
{
    /**
     * Define os campos que podem ser preenchidos em massa.
     * Devem ser exatamente os mesmos do seu formulário.
     */
    protected $fillable = [
        'seller_name', // Nome do Revendedor
        'name',        // Nome da Revenda
        'document',    // CPF/CNPJ
        'email',       // E-mail
        'phone',       // Telefone
    ];

    /**
     * Configuração para UUID (visto no pgAdmin).
     * Informa ao Laravel que o ID não é um número e não é autoincremento.
     */
    protected $keyType = 'string';
    public $incrementing = false;

    /**
     * Evento Booted: Gera o UUID automaticamente sempre que uma nova revenda for criada.
     */
    protected static function booted()
    {
        static::creating(function ($tenant) {
            if (empty($tenant->id)) {
                $tenant->id = (string) Str::uuid();
            }
        });
    }
}