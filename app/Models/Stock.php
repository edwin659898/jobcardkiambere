<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class,'received_by')->withDefault();
    }

    public function issuedBy(){
        return $this->belongsTo(User::class,'issued_by')->withDefault();
    }

    public function fruit(){
        return $this->belongsTo(Fruit::class);
    }

    public function truck(){
        return $this->belongsTo(Truck::class,'truck_id')->withDefault();
    }

    public function activity(){
        return $this->belongsTo(ChildActivity::class,'child_activity_id');
    }

    public function jobCard(){
        return $this->belongsTo(JobCard::class,'job_card_id');
    }
}
