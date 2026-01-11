<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Adicionado
use Illuminate\Support\Str;

class Store extends Model
{
    use SoftDeletes, HasFactory; // Adicionado HasFactory

    protected $fillable = [
        'name',
        'document',
        'email',
        'phone',
        'tenant_id', // Vínculo com o Tenant
    ];

    protected $keyType = 'string';
    public $incrementing = false;

    protected static function booted()
    {
        static::creating(function ($store) {
            if (empty($store->id)) {
                $store->id = (string) Str::uuid();
            }
        });
    }

    /**
     * Relacionamento com a Revenda.
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id')->withTrashed();
    }
}