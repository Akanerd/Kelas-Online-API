<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ModuleResource;
use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function ModuleById(Request $request)
    {
        $id = $request->input('id');
        $module = Module::find($id);
        if(is_null($module))
        {
            return response()->json([
                'status'=>false,
                'msg'=>'Data Module tidak ditemukan'
            ],404);
        }

        $view = $module->view + 1;
        $module->update(['view' => $view]);
        return new ModuleResource($module);
    }

   
}
