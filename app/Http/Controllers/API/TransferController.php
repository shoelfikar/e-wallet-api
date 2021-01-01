<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mutation;
use App\Models\Transfer;
use App\Models\Topup;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\QueryException;

class TransferController extends Controller
{
    public function transferEwallet(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_id'=> ['required'],
            'amuont'=> ['required', 'numeric'],
            'received_id'=> ['required']
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $transferId = mt_rand(10000,99999);
            $topupId = mt_rand(10000,99999);
            $date = date("d-m-Y");
            $user = User::where('id', $request->user_id)->first();
            $received = User::where('wallet_id', $request->received_id)->first();
            if(!$user || !$received){
                return response()->json([
                    'message'=> 'User tidak ditemukan'
                ], Response::HTTP_NOT_FOUND);
            }
            if($user['saldo'] < $request->amuont){
                $response = [
                    'message'=> 'Saldo Tidak cukup untuk melakukan Transfer',
                ];
                return response()->json($response, Response::HTTP_BAD_REQUEST);
            }
            $saldo = $user['saldo'] - $request->amuont;
            $saldoReceived = $received['saldo'] + $request->amuont;
            $transfer = Transfer::create([
                'amuont'=> $request->amuont,
                'transfer_id'=> 'TF'. $transferId,
                'received_id'=> $request->received_id
            ]);
            if($transfer){
                $topupReceived = Topup::create([
                    'amuont'=> $request->amuont,
                    'status'=> 'TF',
                    'topup_id'=> 'TP'. $topupId
                ]);
                $mutation = Mutation::create([
                    'user_id'=> $request->user_id,
                    'amuont'=> $transfer['amuont'],
                    'type'=> 'Transfer',
                    'status'=> 'OUT',
                    'saldo'=> $saldo,
                    'transaction_id'=> $transfer->transfer_id,
                    'keterangan'=> 'TRANSFER E-WALLER  KE : '. $received['name']. '-'. $received['wallet_id'] . ' '. 'TGL : ' . $date
                ]);
                Mutation::create([
                    'user_id'=> $received->id,
                    'amuont'=> $topupReceived['amuont'],
                    'type'=> 'Topup',
                    'status'=> 'IN',
                    'saldo'=> $saldoReceived,
                    'transaction_id'=> $topupReceived->topup_id,
                    'keterangan'=> 'TRANSFER E-WALLER  DARI : '. $user['name']. '-'. $user['wallet_id'] . ' '. 'TGL : ' . $date
                ]);
                if($mutation){
                    User::where('id', $request->user_id)->update(['saldo'=> $saldo]);
                    User::where('wallet_id', $request->received_id)->update(['saldo'=> $saldoReceived]);
                }

                $response = [
                    'message'=> 'Transfer Success',
                    'data'=> $mutation
                ];
                return response()->json($response, Response::HTTP_OK);

            }
        }catch(QueryException $query){
            return response()->json([
                'message'=> $query->errorInfo
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
