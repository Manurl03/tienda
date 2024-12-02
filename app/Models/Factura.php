<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    /** @use HasFactory<\Database\Factories\FacturaFactory> */
    use HasFactory;

    protected $fillable = [
        'numero',
        'user_id',
    ];

    protected static function boot()
    {
        parent::boot();


        static::creating(function ($model) {
            $model->fecha = now();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function articulos()
    {
        return $this->belongsToMany(Articulo::class);    
    }
}
