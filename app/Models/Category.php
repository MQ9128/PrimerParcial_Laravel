<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Car;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'priority',
        'state',
    ];

    protected $casts = [
        'state' => 'boolean',
        'priority' => 'integer',
    ];

    public function cars()
    {
        return $this->hasMany(Car::class);
    }
}
