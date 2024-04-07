<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdsImages extends Model
{
    use HasFactory;

    public function itemads(){
        return $this->belongsTo(ItemsAds::class);
    }

}
