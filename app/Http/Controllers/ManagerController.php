<?php

namespace App\Http\Controllers;

use App\Http\Resources\ManagerResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ManagerController extends Controller
{
    public function apiLogin(Request $request)
    {

        // $credentials = $request->only('email', 'password');

        $rules = [
            'email' => 'required',
            'password' => 'required'
        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return response([
                'status' => false,
                'message' => $validation->messages()->first(),
            ]);
        }

        if (
            !Auth::attempt(['email' => $request->email, 'password' => $request->password, 'role' => 2])
            && !Auth::attempt(['phone' => $request->email, 'password' => $request->password, 'role' => 2])
        ) {

            return response([
                'status' => false,
                'message' => "Email or password dose not match.",
            ]);
        } else {
            $token = $request->user()->createToken('admin-access-token', ['manager'])->plainTextToken;
            return response()->json([
                'status' => true,
                'user' => new ManagerResource($request->user()),
                'token' => $token
            ]);
        }
    }
    public function profile(Request $request){
        return response()->json([
            'status' => true,
            'user' => new ManagerResource($request->user()),
            // 'token' => $token
        ]);
    }
}
