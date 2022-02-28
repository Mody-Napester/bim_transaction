<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaymentResource;
use App\Models\Transaction;
use Carbon\Carbon;
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

//            $starting_time=strtotime($request->starting_date);
//            $starting_month=date("m",$starting_time);
//            $starting_year=date("Y",$starting_time);
//
//            $ending_time=strtotime($request->ending_date);
//            $ending_month=date("m",$ending_time);
//            $ending_year=date("Y",$ending_time);

            $starting_date = Carbon::parse($request->starting_date);
            $starting_date2 = Carbon::parse($request->starting_date);
            $ending_date = Carbon::parse($request->ending_date);
            $diff = $ending_date->diffInMonths($starting_date);

            $data = [];

            for ($i = 0; $i <= $diff;$i++){

                $current_starting_date = $starting_date->addMonths($i) ;
                $current_ending_date = $starting_date2->addMonths($i+1);

                $paid = 0;
                $outstanding = 0;
                $overdue = 0;

                $transactions = Transaction::whereBetween('due_date', [$current_starting_date->toDateString(), $current_ending_date->toDateString()])->get();

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

                $data[] = [
                    'month' => $current_starting_date->month,
                    'year' => $current_starting_date->year,
                    'paid' =>  $paid,
                    'outstanding' =>  $outstanding,
                    'overdue' =>  $overdue,
                ];
            }

            return response($data);

        }else{
            return response([
                'status' => false,
                'message' =>  'Not Allowed'
            ]);
        }
    }
}
