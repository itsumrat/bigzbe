<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopSchedule extends Model
{
    use HasFactory;
    protected $table = 'shop_schedule';
    protected $casts = [
        'schedules' => 'array',
    ];
    
  public function shop()
  {
    return $this->belongsTo(Shop::class);
  }
  
}
