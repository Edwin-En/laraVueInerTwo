<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo', 'cedula', 'total'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'codigo');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'cedula');
    }
}
