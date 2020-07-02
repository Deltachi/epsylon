<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    public function users(){
        return $this->belongsToMany('App\User');
    }
    public function exams(){
        return $this->hasMany('App\Exam');
    }
}
