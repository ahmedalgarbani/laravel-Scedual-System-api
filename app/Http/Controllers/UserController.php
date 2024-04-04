<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Import your User model

class UserController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users', // Ensure unique email
            'password' => 'required|string|min:8|confirmed', // Enforce password complexity
            'user_type' => 'max:255', // Enforce password complexity
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'user_type' => $validated['user_type'],
        ]);


        return response()->json([
            'message' => 'User created successfully!',
        ], 201);
    }

    use ApiResponseTrait;
    public function index(){
        $users = User::all();
        if (!$users){
            return $this->apiResponseFormate(null,"there is no data to show",400);
        }
        $msg="the data is showing successfully";
        $status = 200;
        return $this->apiResponseFormate($users,$msg,$status);
    }


    public function show($id){
        $user = User::findOrFail($id);
        if ($user->exists()){
            return $this->apiResponseFormate($user,"ok",200);
        }

        return $this->apiResponseFormate(null,"the user is not found",401);

    }


    public function update(Request $request,$id){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users', // Ensure unique email
            'password' => 'required|string|min:8|confirmed', // Enforce password complexity
            'user_type' => 'max:255', // Enforce password complexity
        ]);
        $user=User::findOrFail($id);
            if (!$user){
              return  response()->json([
                    'message' => 'User is not found!',
                ], 400);
            }
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'user_type' => $validated['user_type'],
        ]);


        return response()->json([
            'message' => 'User updated successfully!',
        ], 202);
    }


    public function destroy($id){
        $user = User::findOrFail($id);

        if (!$user){
            return  response()->json([
                'message' => 'User is not found!',
            ], 400);
        }
        $user->delete($id);
        if ($user){
            return $this->apiResponseFormate($user,"the user is deleted successfully ",203);
        }
    }
}

