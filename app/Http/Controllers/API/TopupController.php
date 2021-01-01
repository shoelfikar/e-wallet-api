<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Mutation;
use App\Models\Topup;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\QueryException;

class TopupController extends Controller
{
    public function topupEwallet(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'=> ['required'],
            'amuont'=> ['required', 'numeric'],
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $fourRandomDigit = mt_rand(10000,99999);
            $date = date("d-m-Y");
            $user = User::where('id', $request->user_id)->first();
            if(!$user){
                return response()->json([
                    'message'=> 'User tidak ditemukan'
                ], Response::HTTP_NOT_FOUND);
            }
            $saldo = $user['saldo'] + $request->amuont;
            $topup = Topup::create([
                'amuont'=> $request->amuont,
                'status'=> 'TP',
                'topup_id'=> 'TP'. $fourRandomDigit
            ]);
            if($topup){

                $mutation = Mutation::create([
                    'user_id'=> $request->user_id,
                    'amuont'=> $topup['amuont'],
                    'status'=> 'IN',
                    'type'=> 'Topup',
                    'transaction_id'=> $topup->topup_id,
                    'saldo'=> $saldo,
                    'keterangan'=> 'TOPUP DANA TGL : '. $date
                ]);
                if($mutation){
                    User::where('id', $request->user_id)->update(['saldo'=> $saldo]);
                }
            }
            $response = [
                'message'=> 'Data Mutasi Rekening',
                'data'=> $mutation
            ];
            return response()->json($response, Response::HTTP_OK);

        }catch(QueryException $query){
            return response()->json([
                'message'=> $query->errorInfo
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
