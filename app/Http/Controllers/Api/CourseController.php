<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use App\Http\Resources\ModuleResource;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Module;

use function PHPUnit\Framework\isNull;

class CourseController extends Controller
{
    function getByCategory(Request $request)
    {
        $id = $request->input('category_id');
        $course = Course::where([
            ['category_id', $id]
        ])->get();
        if ($course->isEmpty()) {
            return response()->json([
                'status' => false,
                'msg' => 'kursus tidak ditemukan dengan kategori tersebut'
            ], 200);
        }

        return CourseResource::collection($course);
    }

    function getById(Request $request)
    {
        $id = $request->input('id');
        $course = Course::find($id);
        if(is_null($course))
        {
            return response()->json([
                'status'=>false,
                'msg'=>'Kursus tidak ditemukan'
            ],404);
        }
        $module = Module::where([
            ['course_id',$id],
            ['status','active']
        ])->get();

        return response()->json([
            'status'=>true,
            'data'=>[
                'course'=> new CourseResource($course),
                'detail'=> ModuleResource::collection($module)
            ]
        ]);
    }

    public function index(Request $request)
    {
        $filterKeyword = $request->input('keyword');
        $course = Course::all();
        if($filterKeyword)
        {
            $course = Course::where('title','LIKE',"%$filterKeyword%")->get();
        }
        return CourseResource::collection($course);
    }
}
