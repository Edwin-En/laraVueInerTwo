<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'codigo';

    protected $fillable = [
        'descripcion', 'stock', 'precio_unitario'
    ];

    public function sales()
    {
        return $this->hasMany(Sale::class, 'codigo');
    }
}
