<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BedPreparation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function tree()
    {
        return $this->belongsTo(Tree::class,'tree_id')->withDefault();
    }
}
