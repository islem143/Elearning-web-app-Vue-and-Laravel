<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Module;

class Course extends Model
{
    use HasFactory;
    protected $fillable = ["title", "description", "module_id", "order"];
    public function module()
    {
        return $this->belongsTo(Module::class);
    }
    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }
    public function coursesContent()
    {
        return $this->hasMany(CourseContent::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class, "course_users");
    }
    public function media()
    {
        return $this->hasMany(Media::class);
    }
}
