<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Category;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'car_make',
        'car_model',
        'car_year',
        'car_price',
        'car_status',
        'barcode',
        'category_id',
    ];

    protected $casts = [
        'car_price' => 'decimal:2',
        'car_year' => 'integer',
        'car_status' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
