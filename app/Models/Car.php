<?php 
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Car extends Model{
    protected $tables = 'cars';

    protected $fillable = [
        'model',
        'brand',
        'fuel',
        'seat',
        'price',
        'gearbox',
        'color',
        'rent_period',
        'top_speed'
    ];

    public function images():HasMany
    {
        return $this->hasMany(CarImage::class, 'car_id');
    }
}