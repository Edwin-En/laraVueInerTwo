<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $primaryKey = 'cedula';

    protected $fillable = [
        'nombre'
    ];

    public function sales()
    {
        return $this->hasMany(Sale::class, 'cedula');
    }
}
