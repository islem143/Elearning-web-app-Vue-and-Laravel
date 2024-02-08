<?php

namespace App\Modules\Category;

use App\Models\Category;
use App\Models\Media;
use App\Models\Module;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoryService
{
    protected $validator;
    public function __construct(CategoryValidator $validator)
    {
        $this->validator = $validator;
    }
    public function getCategories(){
        return Category::all();
    }
    public function createCategory($name,$userId)
    {
        $category = Category::create(["name" => $name,"user_id"=>$userId]);
        return $category;
    }
    public function getCategory($id)
    {
        $category = Category::findOrFail($id);
        return $category;
    }
}
