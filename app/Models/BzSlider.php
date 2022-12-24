<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BzSlider extends Model
{
    use HasFactory;

    protected $table = "bzsliders";
      protected $fillable = ['link', 'image', 'status'];

}
