<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;


    protected $fillable = ["name", "type", "url","course_id",'created_by'];


    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
