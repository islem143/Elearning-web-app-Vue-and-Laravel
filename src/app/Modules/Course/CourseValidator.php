<?php


namespace App\Modules\Course;

use InvalidArgumentException;

class CourseValidator
{

    public function validateCreate($data)
    {
        $validator = validator($data, [
            "title" => "required",
            "description" => "required"

        ]);
        if ($validator->fails()()) {
            throw new InvalidArgumentException(json_encode($validator->errors()->all()));
        }
    }
}
