<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mutation;
use App\Models\Withdraw;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\QueryException;

class WithdrawController extends Controller
{
    public function withdrawEwallet(Request $request)
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
            if($user['saldo'] < $request->amuont){
                $response = [
                    'message'=> 'Saldo Tidak cukup untuk melakukan withdraw',
                ];
                return response()->json($response, Response::HTTP_BAD_REQUEST);
            }
            $saldo = $user['saldo'] - $request->amuont;
            $withdraw = Withdraw::create([
                'amuont'=> $request->amuont,
                'withdraw_id'=> 'WD'. $fourRandomDigit
            ]);
            if($withdraw){

                $mutation = Mutation::create([
                    'user_id'=> $request->user_id,
                    'amuont'=> $withdraw['amuont'],
                    'type'=> 'Withdraw',
                    'status'=> 'OUT',
                    'saldo'=> $saldo,
                    'transaction_id'=> $withdraw->withdraw_id,
                    'keterangan'=> 'WITHDRAW E-WALLER  TGL : '. $date
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
