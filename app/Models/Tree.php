<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tree extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function fruits(){
        return $this->hasMany(Fruit::class,'tree_id');
    }
}
