<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Arr;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware(function($request,$next){
            if(Gate::allows('manage-users')) return $next($request);
            abort(403);
        });
    }

    public function index(Request $request)
    {
        $filterKeyword = $request->get('keyword');
        $filterlevel = $request->get('level');
        $data['users'] = User::paginate(5);
        if($filterKeyword)
        {
            $data['users'] = User::where('name','LIKE',"%$filterKeyword")->where('level',$filterlevel)->paginate(5);
        }
        return view('users.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
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
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
            'name' => 'required|max:255',
            'level' => 'required',
            'gender' => 'required',
            'phone' => 'required|digits_between:10,12',
            'address' => 'required|max:255',
            'avatar' => 'required|image|mimes:jpeg,jpg,png|max:2048'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $input = $request->all();
        if ($request->file('avatar')->isValid()) {
            $avatarFile = $request->file('avatar');
            $extention = $avatarFile->getClientOriginalExtension();
            $fileName = "user-avatar/" . date('YmdHis') . "." . $extention;
            $uploadPath = env("UPLOAD_PATH") . "/user-avatar";
            $request->file('avatar')->move($uploadPath, $fileName);
            $input['avatar'] = $fileName;
        }
        $input['password'] = \Hash::make($request->get('password'));
        User::create($input);
        return redirect()->route('users.index')->with('success', 'Users Successfully Created');
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
        $data['users'] = User::findOrFail($id);
        return view('users.edit', $data);
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
        $dataUser = User::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'level' => 'required',
            'gender' => 'required',
            'phone' => 'required|digits_between:10,12',
            'address' => 'required|max:255',
            'avatar' => 'sometimes|nullable|image|mimes:jpeg,jpg,png|max:2048'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $input = $request->all();
        if ($request->hasFile('avatar')) {
            if ($request->file('avatar')->isValid()) {
                Storage::disk('upload')->delete($dataUser->avatar);
                $avatarFile = $request->file('avatar');
                $extention = $avatarFile->getClientOriginalExtension();
                $fileName = "user-avatar/" . date('YmdHis') . "." . $extention;
                $uploadPath = env('UPLOAD_PATH') . "/user-avatar";
                $request->file('avatar')->move($uploadPath, $fileName);
                $input['avatar'] = $fileName;
            }
        }
        if ($request->input('password')) {
            $input['password'] = \Hash::make($input['password']);
        } else {
            $input = Arr::except($input, ['password']);
        }
        $dataUser->update($input);
        return redirect()->route('users.index')->with('success', 'Users Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dataUser = User::findOrFail($id);
        $dataUser->delete();
        Storage::disk('upload')->delete($dataUser->avatar);
        return redirect()->back()->with('success', 'Users Successfully Deleted');
    }
}
