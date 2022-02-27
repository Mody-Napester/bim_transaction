<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $transaction_id)
    {
        if($request->user()->tokenCan('index.payment')){
            $transaction = Transaction::with('payments')->where('id', $transaction_id)->first();
            if($transaction){
                return PaymentResource::collection($transaction->payments);
            }else{
                return response([
                    'status' => false,
                    'message' =>  'Transaction Not Exists'
                ]);
            }
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
    public function store(StorePaymentRequest $request)
    {
        if($request->user()->tokenCan('create.payment')){
            if($request->validated()){
                // Check Transaction Exists
                if(!Transaction::where('id', $request->transaction_id)->first()){
                    return response([
                        'status' => false,
                        'message' =>  'Transaction Not Exists'
                    ]);
                }

                // Create new sub_category
                $payment = new Payment();
                $payment->transaction_id = $request->transaction_id;
                $payment->amount = $request->amount;
                $payment->payment_method = ($request->has('payment_method'))? $request->payment_method : 'Cash';
                $payment->payment_date = $request->payment_date;
                $payment->details = ($request->has('details'))? $request->details : '';
                $payment->save();

                if($payment){
                    return response([
                        'status' => true,
                        'message' =>  'Payment Created Successfully',
                        'payment' =>  new PaymentResource($payment)
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
}
