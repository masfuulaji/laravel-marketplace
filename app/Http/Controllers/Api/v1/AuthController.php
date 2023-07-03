<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse{
        $validatedData = $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $result = $this->userRepository->findWhere($validatedData['email']);
        if(!$result){
            return response()->json(['message' => 'Email or Password invalid'], 404);
        }

        if(!Hash::check($validatedData['password'], $result->password)){
            return response()->json(['message' => 'Email or Password invalid'], 404);
        }

        $token = $result->createToken('authToken')->plainTextToken;
        return response()->json(['token' => $token, 'user' => $result], 200);
    }

    public function logout(Request $request): JsonResponse{
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out'], 200);
    }
}
