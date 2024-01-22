<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;


   protected $fillable=[
    "title","description","duration","course_id","created_by"
   ];


    public function users(){
        return $this->belongsToMany(User::class)->withTimestamps();
    }
    public function questions(){
        return $this->hasMany(Question::class);
    }
    public function course(){
        return $this->belongsTo(Course::class);
    }
    public function quizUser(){
        return $this->hasOne(QuizUser::class);
    }



}
