<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemfreeAds extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user(){

        return $this->belongsTo(User::class);
    }

    
    public function adsimages(){
        return $this->hasMany(AdsImages::class);
    }
}
