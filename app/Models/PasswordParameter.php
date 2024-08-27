<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordParameter extends Model
{
    use HasFactory;

    protected $fillable = [
        'length',
        'uppercase',
        'lowercase',
        'digits',
        'special_characters',
    ];

    protected $casts = [
        'uppercase' => 'boolean',
        'lowercase' => 'boolean',
        'digits' => 'boolean',
        'special_characters' => 'boolean',
    ];
}
