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

class StockController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    // STOCK PAGE
    public function stock(Request $request)
    {
        if (Gate::allows('isSalesRep')) {
            return redirect()->back()->with('accessError', 'You have no permission to access page');
        }
        $data = [
            'stockItem' => [],
            'stockDetails' => Branch::find(auth()->user()->branch_id)->stocks()->orderBy('created_at', 'DESC')->get(),
            'businessDetails' => User::find(auth()->user()->id)->business()->get(),
            'branchDetails' => Business::find(auth()->user()->business_id)->branch()->get()
        ];
        // dd($data)
        return view( 'dashboard.stock')->with('data', $data);
    }

    // STORE STOCK RECORDS
    public function storeStock(Request $request){

        $request->validate([
            'item' => 'required',
            'unitPrice' => 'required',
            'bulkUnit' => 'required',
            'bulkUnitPrice' => 'required',
            'availableUnits' => 'required',
        ]);

        if($request->has('type')){
            $request->request->set('type', 'product');
        }else{
            $request->request->add(['type' => 'service']);
        }

        $insert = Stock::create([
            'type' => $request->type,
            'user_id' => auth()->user()->id,
            'business_id' => auth()->user()->business_id,
            'branch_id' => auth()->user()->branch_id,
            'item' => $request->item,
            'unitPrice' => $request->unitPrice,
            'bulkUnit' => $request->bulkUnit,
            'bulkUnitPrice' => $request->bulkUnitPrice,
            'availableUnits' => $request->availableUnits
        ]);

        if($insert){
            return redirect()->back()->with('status', 'Item added to the stock list!');
        }
    }

    // DELETE STOCK ITEM
    public function deleteStock($data, Request $request){
        $item = Stock::find($data);
        if($request->method() == 'DELETE'){
            if($item->delete()){
                return redirect()->back()->with('status', 'Item record Deleted!');
            }
        }else{
            return 'You are not allowed here!';
        }
        
    }
}
