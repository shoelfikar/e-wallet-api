<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'=> ['required', 'email'],
            'password'=> ['required'],
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $user = User::where('email', $request->email)->first();
        if(!$user || !Hash::check($request->password, $user->password)){
            return response()->json([
                'message'=> 'Wrong email or Password'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $token = $user->createToken('transaction')->plainTextToken;
        $response = [
            'message'=> 'Login success',
            'data'=> $user,
            'token'=> $token
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=> ['required'],
            'email'=> ['required', 'email'],
            'phone'=> ['required'],
            'address'=> ['required'],
            'password'=> ['required'],
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $date = date('my');
            $fourRandomDigit = mt_rand(1000,9990);
            User::create([
                'name'=> $request->name,
                'email'=> $request->email,
                'password'=> bcrypt($request->password),
                'phone'=> $request->phone,
                'address'=> $request->address,
                'wallet_id'=>  $date. $fourRandomDigit,
                'saldo'=> 0
            ]);
            $response = [
                'message'=> 'Register success'
            ];
            return response()->json($response, Response::HTTP_CREATED);

        }catch(QueryException $query){
            return response()->json([
                'message'=> $query->errorInfo
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function getUserById($id)
    {
        try {
            $user = User::where('id', $id)->orWhere('wallet_id', $id)->first();
            if(!$user){
                $response = [
                    'message'=> 'User tidak ditemukan',
                ];
                return response()->json($response, Response::HTTP_NOT_FOUND);
            }
            $response = [
                'message'=> 'Data user berdasarkan ID',
                'data'=> $user
            ];
            return response()->json($response, Response::HTTP_OK);

        }catch(QueryException $query){
            return response()->json([
                'message'=> $query->errorInfo
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    public function logout(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();
        $response = [
            'message'=> 'Logout Success',
        ];
        return response()->json($response, Response::HTTP_OK);
    }
}
