<?php


namespace App\Modules\Category;

use InvalidArgumentException;

class CategoryValidator
{

    public function validateCreate($data)
    {
        $validator = validator($data, [
            "name" => "required",
            
        ]);
        if ($validator->fails()()) {
            throw new InvalidArgumentException(json_encode($validator->errors()->all()));
        }
    }
}
