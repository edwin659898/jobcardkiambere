<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildActivity extends Model
{
    use HasFactory;

    protected $fillable = ['parent_activity_id','child_title','child_number','slug'];

    public function jobcards(){
        return $this->hasMany(JobCard::class,'current_child_id');
    }

    public function parent(){
        return $this->belongsTo(ParentActivity::class,'parent_activity_id');
    }

    public function records(){
        return $this->hasMany(Record::class,'child_activity_id');
    }

    public function roles(){
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    public function bedPreparation()
    {
        return $this->hasMany(BedPreparation::class,'child_activity_id');
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class,'child_activity_id');
    }

    public function timelines()
    {
        return $this->hasMany(Timeline::class,'child_activity_id');
    }

    public function signatures()
    {
        return $this->hasMany(Signature::class,'child_activity_id');
    }

}
