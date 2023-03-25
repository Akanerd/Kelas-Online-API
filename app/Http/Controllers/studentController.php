<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Arr;

class studentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(function($request,$next){
            if(Gate::allows('manage-students')) return $next($request);
            abort(403);
        });
    }

    public function index(Request $request)
    {
        $filterKeyword = $request->get('keyword');
        $data['student'] = Student::paginate(5);
        if($filterKeyword)
        {
            $data['student'] = Student::where('name','LIKE',"%$filterKeyword%")->paginate(5);
        }
        return view('student.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('student.create');
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
            'email'=>'required|email|max:255|unique:students',
            'name'=>'required|max:255',
            'gender'=>'required',
            'phone'=>'required|digits_between:10,12',
            'avatar'=>'required|image|mimes:jpeg,jpg,png|max:2048'
        ]);
        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $input = $request->all();
        if($request->file('avatar')->isValid())
        {
            $avatarFile = $request->file('avatar');
            $extention = $avatarFile->getClientOriginalExtension();
            $fileName = "student-avatar/".date('YmdHis').".".$extention;
            $uploadPath = env("UPLOAD_PATH")."/student-avatar";
            $request->file('avatar')->move($uploadPath,$fileName);
            $input['avatar'] = $fileName;
        }
        $input['password'] = password_hash($request->get('email'),PASSWORD_BCRYPT);
        Student::create($input);
        return redirect()->route('student.index')->with('success','Students Successfully Created');
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
       $data['student'] = Student::findOrFail($id);
       return view('student.edit',$data);
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
        $dataStudent = Student::findOrFail($id);
        $validator = Validator::make($request->all(),[
            'name'=>'required|max:255',
            'gender'=>'required',
            'phone'=>'required|digits_between:10,12',
            'avatar'=>'sometimes|image|mimes:jpeg,jpg,png|max:2048'
        ]);
        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator);
        }
        $input = $request->all();
        if($request->hasFile('avatar'))
        {
            if($request->file('avatar')->isValid())
            {
                Storage::disk('upload')->delete($dataStudent->avatar);
                $avatarFile = $request->file('avatar');
                $extention = $avatarFile->getClientOriginalExtension();
                $fileName = "student-avatar/".date("YmdHis").".".$extention;
                $uploadPath = env('UPLOAD_PATH')."/student-avatar";
                $request->file('avatar')->move($uploadPath,$fileName);
                $input['avatar'] = $fileName;
            }
        }
        if($request->input('password')){
            $input['password'] = \Hash::make($input['password']);
        }
        else{
            $input = Arr::except($input, ['password']);
        }
        $dataStudent->update($input);
        return redirect()->route('student.index')->with('success','Student Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dataStudent = Student::findOrFail($id);
        $dataStudent->delete();
        Storage::disk('upload')->delete($dataStudent->avatar);
        return redirect()->back()->with('success','Student Successfully Deleted');
    }

    public function resetPassword($id)
    {
        $dataStudent = Student::findOrFail($id);
        $dataStudent->update(['password'=>password_hash($dataStudent->email,PASSWORD_BCRYPT)]);
        return redirect()->back()->with('success','Student Password Has Been Reset');
    }
}
