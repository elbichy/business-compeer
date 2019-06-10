<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use App\Business;
use App\Branch;
use App\User;
use App\Sale;
use App\Expense;
use App\Stock;
use Carbon\Carbon;
use App\Notifications\salesApproval;

class ExpenseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    // EXPENSES PAGE
    public function expenses()
    {
        if(auth()->user()->business_id == 0){
            return redirect(route('businessSettings'))->with('noBusinessRecord', 'You need to Setup a Business first');
        }else if(auth()->user()->branch_id == 0){
            return redirect(route('branchSettings'))->with('noBusinessRecord', 'You have Setup Main Branch atleast');
        }else{
            $data = [
                'expensesDetails' => Branch::find(auth()->user()->branch_id)->expenses()->orderBy('created_at', 'DESC')->get(),
                'businessDetails' => User::find(auth()->user()->id)->business()->get(),
                'branchDetails' => Business::find(auth()->user()->business_id)->branch()->get()
            ];
        }
        // dd($data);
        return view('dashboard.expenses')->with('data', $data);
    }

    // STORE EXPENSE RECORDS
    public function storeExpenses(Request $request){
    
        $request->validate([
            'itemBought' => 'required',
            'boughtFrom' => 'required',
            'cost' => 'required'
        ]);

        if($request->has('type')){
            $request->request->set('type', 'product');
        }else{
            $request->request->add(['type' => 'service']);
        }

        $insert = Expense::create([
            'type' => $request->type,
            'user_id' => auth()->user()->id,
            'business_id' => auth()->user()->business_id,
            'branch_id' => auth()->user()->branch_id,
            'itemBought' => $request->itemBought,
            'boughtFrom' => $request->boughtFrom,
            'cost' => $request->cost
        ]);

        if($insert){
            return redirect()->back()->with('status', 'Transaction recorded successfully!');
        }
    }

    // DELETE EXPENSE
    public function deleteExpense($data){
        $item = Expense::find($data);

        if($item->delete()){
            return redirect()->back()->with('status', 'Transaction record Deleted!');
        }
    }


}
