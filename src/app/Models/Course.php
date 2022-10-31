<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Module;

class Course extends Model
{
    use HasFactory;
    protected $fillable=["title","description","module_id"];
    public function module()
    {
        return $this->belongsTo(Module::class);
    }
    public function quizzes(){
        return $this->hasMany(Quiz::class);
    }
    public function media(){
        return $this->hasMany(Media::class);
    }
    
}
