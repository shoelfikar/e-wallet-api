<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Mutation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;

class MutationController extends Controller
{
    public function mutationEwallet(Request $request, $id)
    {
        if($request->start_date || $request->end_date){
            $validator = Validator::make($request->all(), [
               'start_date'=> ['required', 'date'],
               'end_date'=> ['required', 'date']
            ]);
            if($validator->fails()){
                return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            try {
                $start = Carbon::parse($request->start_date);
                $end = Carbon::parse($request->end_date);
                $diff=date_diff($start,$end);
                if($diff->format("%R%a") < 0){
                    $response = [
                        'message'=> 'End date tidak boleh lebih kecil date Start Date',
                    ];
                    return response()->json($response, Response::HTTP_BAD_REQUEST);
                }
                $mutation = Mutation::with(['User'])->where('user_id', $id)->whereBetween('time', [$start, $end])->orderBy('created_at', 'desc')->get();
                if(count($mutation) <= 0 || !$mutation){
                    $response = [
                        'message'=> 'Mutasi E-Wallet tidak ditemukan',
                    ];
                    return response()->json($response, Response::HTTP_NOT_FOUND);
                }
                $response = [
                    'message'=> 'Mutasi E-Wallet dari tanggal '. $request->start_date . ' - '. $request->end_date,
                    'data'=> $mutation
                ];
                return response()->json($response, Response::HTTP_OK);

            }catch(QueryException $query){
                return response()->json([
                    'message'=> $query->errorInfo
                ], Response::HTTP_BAD_REQUEST);
            }
        }

        try {
            $mutation = Mutation::with(['User'])->where('user_id', $id)->orderBy('created_at', 'desc')->get();
            if(count($mutation) <= 0 || !$mutation){
                $response = [
                    'message'=> 'Mutasi E-Wallet tidak ditemukan',
                ];
                return response()->json($response, Response::HTTP_NOT_FOUND);
            }
            $response = [
                'message'=> 'Mutasi E-Wallet All',
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
