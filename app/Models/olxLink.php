<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class olxLink extends Model
{
    use HasFactory;
    protected $fillable = [
        'url',
        'price'
    ];
}
