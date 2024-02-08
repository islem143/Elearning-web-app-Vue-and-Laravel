<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Module;
use Illuminate\Support\Facades\Auth;
class Course extends Model
{
    use HasFactory;
    protected $fillable = ["title", "description", "module_id", "order", "user_id"];
    public function module()
    {
        return $this->belongsTo(Module::class);
    }
    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }
    public function courseUsers()
    {
        return $this->hasMany(CourseUser::class);
    }
    public function courseUser()
    {
        return $this->hasOne(CourseUser::class)->where("user_id",Auth::user()->id);
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
