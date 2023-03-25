<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(function($request,$next){
            if(Gate::allows('manage-categories')) return $next($request);
            abort(403);
        });
    }

    public function index(Request $request)
    {
        $filterKeyword = $request->get('keyword');
        $data['category'] = Category::paginate(5);
        if($filterKeyword)
        {
            $data['category'] = Category::where('name','LIKE',"%$filterKeyword%")->paginate(5);
        }
        return view('category.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'=>'required|max:255',
            'thumbnail'=>'required|image|mimes:jpeg,jpg,png|max:2048'
        ]);
        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $input = $request->all();
        if($request->file('thumbnail')->isValid())
        {
            $thumbnailFile = $request->file('thumbnail');
            $extention = $thumbnailFile->getClientOriginalExtension();
            $fileName = "category/".date('YmdHis').".".$extention;
            $uploadPath = env('UPLOAD_PATH')."/category";
            $request->file('thumbnail')->move($uploadPath,$fileName);
            $input['thumbnail'] = $fileName;
        }
        Category::create($input);
        return redirect()->route('category.index')->with('success', 'Category Successfully Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['category'] = Category::findOrFail($id);
        return view('category.edit',$data);
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
        $dataCategory = Category::findOrFail($id);
        $validator = Validator::make($request->all(),[
            'name'=>'required|max:255',
            'thumbnail'=>'sometimes|nullable|image|mimes:jpeg,jpg,png|max:2048'
        ]);
        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator);
        }
        $input = $request->all();
        if($request->hasFile('thumbnail'))
        {
            if($request->file('thumbnail')->isValid())
            {
                Storage::disk('upload')->delete($dataCategory->thumbnail);
                $thumbnailFile = $request->file('thumbnail');
                $extention = $thumbnailFile->getClientOriginalExtension();
                $fileName = "category/".date('YmdHis').".".$extention;
                $uploadPath = env('UPLOAD_PATH')."/category";
                $request->file('thumbnail')->move($uploadPath,$fileName);
                $input['thumbnail'] = $fileName;
            }
        }
        $dataCategory->update($input);
        return redirect()->route('category.index')->with('success', 'Category Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dataCategory = Category::findOrFail($id);
        $dataCategory->delete();
        return redirect()->back()->with('success', 'Category Successfully Moved To Trash');
    }

    public function trash()
    {
        $data['category'] = Category::onlyTrashed()->paginate(5);
        return view('category.trash',$data);
    }

    public function restore($id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        if($category->trashed())
        {
            $category->restore();
        }
        else
        {
            return redirect()->route('category.index')->with('toast_error', 'Category is not in Trash');
        }
        return redirect()->route('category.index')->with('success', 'Category Successfully Restored');
    }

    public function deletePermanent($id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        if(!$category->trashed())
        {
            return redirect()->route('category.index')->with('toast_error', 'Category Can Not Delete Permanently');
        }
        else
        {
            $category->forceDelete();
            Storage::disk('upload')->delete($category->thumbnail);
            return redirect()->route('category.index')->with('success', 'Category Permanently Deleted');
        }
    }
}
