<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicles extends Model
{
    use HasFactory;

    protected $table = 'vehicles';
    protected $fillable = [
        'name',
        'brand',
        'version',
        'cover',
        'year',
        'price',
        'description',
        'status',
    ];
}
