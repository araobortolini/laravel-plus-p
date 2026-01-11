<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessSegment extends Model
{
    use HasFactory;

    /**
     * O nome da tabela associada ao modelo.
     * (Opcional se seguir o padrão Laravel, mas seguro definir)
     */
    protected $table = 'business_segments';

    /**
     * Atributos que podem ser preenchidos em massa (Mass Assignment).
     * Isso resolve o erro MassAssignmentException.
     */
    protected $fillable = [
        'name',
        'slug',
        'behavior_base',
        'is_active',
    ];

    /**
     * Os atributos que devem ser convertidos para tipos nativos.
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];
}