<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaymentResource;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display a listing of the transaction and payments.
     */
    public function transaction_payments(Request $request)
    {
        if($request->user()->tokenCan('generate.report')){

            $paid = 0;
            $outstanding = 0;
            $overdue = 0;

            $transactions = Transaction::all();
            foreach ($transactions as $transaction){
                $payments = $transaction->payments()->sum('amount');
                if($payments == $transaction->amount){
                    $paid += $payments;
                }
                elseif($payments < $transaction->amount && $transaction->due_date >= date('Y-m-d')){
                    $outstanding += $payments;
                }
                elseif($payments < $transaction->amount && $transaction->due_date < date('Y-m-d')){
                    $overdue += $payments;
                }
            }

            return response([
                'status' => true,
                'paid' =>  $paid,
                'outstanding' =>  $outstanding,
                'overdue' =>  $overdue,
            ]);

        }else{
            return response([
                'status' => false,
                'message' =>  'Not Allowed'
            ]);
        }
    }
}
