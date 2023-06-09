<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Category;
use App\Models\Module;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(function($request,$next){
            if(Gate::allows('manage-courses')) return $next($request);
            abort(403);
        });
    }

    public function index(Request $request)
    {
        $filterKeyword = $request->get('keyword');
        $data['course'] = Course::paginate(5);
        if($filterKeyword)
        {
            $data['course'] = Course::where('title','LIKE',"%$filterKeyword%")->paginate(5);
        }
        return view('course.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['category'] = Category::all();
        $data['users'] = User::where('level', 'mentor')->get();
        return view('course.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'description' => 'required',
            'group' => 'required|max:255',
            'thumbnail' => 'required|image|mimes:jpeg,jpg,png|max:2048'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        };
        $input = $request->all();
        if ($request->file('thumbnail')->isValid()) {
            $thumbnailFile = $request->file('thumbnail');
            $extention = $thumbnailFile->getClientOriginalExtension();
            $fileName = "course-thumbnail/" . date('YmdHis') . "." . $extention;
            $uploadPath = env('UPLOAD_PATH') . "/course-thumbnail";
            $request->file('thumbnail')->move($uploadPath, $fileName);
            $input['thumbnail'] = $fileName;
        };
        Course::create($input);
        return redirect()->route('course.index')->with('success', 'Course Successfully Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['course'] = Course::findOrFail($id);
        $data['module'] = Module::where('course_id',$id)->orderBy('order','asc')->get();
        return view('course.show',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['course']  = Course::findOrfail($id);
        $data['category']  = Category::all();
        $data['users']  = User::where('level', 'mentor')->get();
        return view('course.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $dataCourse = Course::findOrfail($id);
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'description' => 'required',
            'group' => 'required|max:255',
            'thumbnail' => 'required|image|mimes:jpeg,jpg,png|max:2048'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        };
        $input = $request->all();
        if ($request->hasFile('thumbnail')) {
            if ($request->file('thumbnail')->isValid()) {
                Storage::disk('upload')->delete($dataCourse->thumbnail);
                $thumbnailFile = $request->file('thumbnail');
                $extention = $thumbnailFile->getClientOriginalExtension();
                $fileName = "course-thumbnail/".date('YmdHis').".".$extention;
                $uploadPath = env('UPLOAD_PATH')."/course-thumbnail";
                $request->file('thumbnail')->move($uploadPath,$fileName);
                $input['thumbnail'] = $fileName;
            }
        }
        $dataCourse->update($input);
        return redirect()->route('course.index')->with('success','Course Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dataCourse = Course::findOrFail($id);
        $dataCourse->delete();
        return redirect()->route('course.index')->with('success','Course Successfully Deleted');
    }

    public function trash()
    {
        $data['course'] = Course::onlyTrashed()->paginate(5);
        return view('course.trash',$data);
    }

    public function restore($id)
    {
        $course = Course::withTrashed()->findOrFail($id);
        if($course->trashed())
        {
            $course->restore();
        }
        else
        {
            return redirect()->route('course.index')->with('toast_error', 'Category is not in Trash');
        }
        return redirect()->route('course.index')->with('success', 'Category Successfully Restored');
    }

    public function deletePermanent($id)
    {
        $course = Course::withTrashed()->findOrFail($id);
        if(!$course->trashed())
        {
            return redirect()->route('course.index')->with('toast_error', 'Category Can Not Delete Permanently');
        }
        else
        {
            $course->forceDelete();
            Storage::disk('upload')->delete($course->thumbnail);
            return redirect()->route('course.index')->with('success', 'Category Permanently Deleted');  
        }
    }

    public function download($id)
    {
        $module = Module::findOrFail($id);
        $filePath = env('UPLOAD_PATH').'/'.$module->document;
        return response()->download($filePath);
    }
}
