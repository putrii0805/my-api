<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class CarImage extends Model
{
  protected $table = 'car_images';
  protected $primaryKey = 'id';
  protected $guarded = [
    'id'
  ];

  public function car():BelongsTo
  {
    return $this->belongsTo(Car::class, 'car_id');
  }
}
