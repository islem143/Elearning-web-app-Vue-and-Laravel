<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;


    protected $fillable = ["name", "type", "url"];


    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
