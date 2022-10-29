<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{


    public function saveModuleImage(Request $request, $moduleId)
    {

        $file = $request->file('image')->store("public/images");
        $module = Module::findOrFail($moduleId);
        
        if ($module->img_url) {
            Storage::delete($module->img_url);
        }
        $module->img_url = $file;

        $module->save();
        return response()->json(["image saved succefuly"], 201);
    }
}
