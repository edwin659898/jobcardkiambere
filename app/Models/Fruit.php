<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fruit extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function truck(){
        return $this->belongsTo(Truck::class,'truck_id')->withDefault();
    }

    public function tree(){
        return $this->belongsTo(Tree::class);
    }  

    public function stocks(){
        return $this->hasMany(Stock::class);
    }
}
