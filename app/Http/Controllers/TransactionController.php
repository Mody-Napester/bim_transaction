<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->user()->tokenCan('index.transaction')){
            return TransactionResource::collection(Transaction::all());
        }else{
            return response([
                'status' => false,
                'message' =>  'Not Allowed'
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransactionRequest $request)
    {
        if($request->user()->tokenCan('create.transaction')){
            if($request->validated()){
                // Check Category Exists
                if(!Category::where('id', $request->category_id)->first()){
                    return response([
                        'status' => false,
                        'message' =>  'Category Not Exists'
                    ]);
                }

                // Check Sub Category Exists
                if($request->has('sub_category_id') && !SubCategory::where('id', $request->sub_category_id)->first()){
                    return response([
                        'status' => false,
                        'message' =>  'Sub Category Not Exists'
                    ]);
                }

                // Check Customer (User) Exists
                if(!User::where('id', $request->customer_id)->first()){
                    return response([
                        'status' => false,
                        'message' =>  'Payer Not Exists'
                    ]);
                }

                // Create new sub_category
                $transaction = new Transaction();
                $transaction->category_id = $request->category_id;
                $transaction->sub_category_id = ($request->has('sub_category_id'))? $request->sub_category_id : null;
                $transaction->customer_id = $request->customer_id;
                $transaction->amount = $request->amount;
                $transaction->due_date = $request->due_date;
                $transaction->vat = $request->vat;
                $transaction->is_vat_inclusive = $request->is_vat_inclusive;
                $transaction->save();

                if($transaction){
                    return response([
                        'status' => true,
                        'message' =>  'Transaction Created Successfully',
                        'transaction' =>  new TransactionResource($transaction)
                    ], 200);
                }else{
                    return response([
                        'status' => false,
                        'message' =>  'Not Created'
                    ]);
                }
            }
        }else{
            return response([
                'status' => false,
                'message' =>  'Not Allowed'
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        $transaction = Transaction::where('id', $id)->first();

        if($request->user()->tokenCan('show.transaction')){
            if($transaction){
                return new TransactionResource($transaction);
            }else{
                return response([
                    'status' => false,
                    'message' =>  'Not Found'
                ]);
            }
        }else{
            return response([
                'status' => false,
                'message' =>  'Not Allowed'
            ]);
        }
    }
}
