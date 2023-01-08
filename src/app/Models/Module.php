<?php


namespace App\Models;

use App\Models\Course;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $fillable = ["title", "descprtion", "img_url", "user_id"];
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
