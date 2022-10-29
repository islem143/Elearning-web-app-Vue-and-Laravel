<?php


namespace App\Models;

use App\Models\Course;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $fillable=["title","descprtion","img_url"];
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
    public function modules(){
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
