<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudentResource;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function login(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input,[
            'email' => 'required',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'msg' => $validator->errors()
            ], 400);
        }
        $email = $request->input('email');
        $password = $request->input('password');
        
        $student = Student::where([
            ['email', $email],
            ['status', 'active']
        ])->first();

        if (is_null($student)) {
            return response()->json([
                'status' => FALSE,
                'msg' => 'Email & Password Tidak Sesuai'
            ], 200);
        } else {
            if (password_verify($password, $student->password)) {
                //jika password sesuai
                return response()->json([
                    'status' => TRUE,
                    'msg' => 'User ditemukan',
                    'data' => new StudentResource($student)
                ], 200);
            } else {
                //jika password tidak sesuai
                return response()->json([
                    'status' => FALSE,
                    'msg' => 'Email & Password Tidak Sesuai'
                ], 200);
            }
        }
    }
}
