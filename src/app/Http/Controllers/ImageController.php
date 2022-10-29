<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;

class ImageController extends Controller
{


    public function saveModuleImage(Request $request, $moduleId)
    {

        $file = $request->file('image')->store("public/images");
        $module = Module::findOrFail($moduleId);
      
        $module->img_url = $file;
        $module->save();
        return response()->json(["image saved succefuly"], 201);
    }
}
