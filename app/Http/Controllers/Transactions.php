<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Sale;
use App\Expense;
use App\Stock;
use App\Business;
use App\Branch;
use App\User;
class Transactions extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    // STORE NEW SALE RECORDS
    public function storeSales(Request $request)
    {
        $val = $request->validate([
            'firstname' => 'required',
            'phone' => 'numeric',
            'location' => 'required',
            'productOrService' => 'required',
            'balance' => 'numeric',
            'change' => 'numeric',
        ]);

        if($request->has('type')){
            $request->request->set('type', 'product');
        }else{
            $request->request->add(['type' => 'service']);
        }

        if($request->has('amount')){
            $request->request->set('amount', $request->amount);
        }else{
            $item = Stock::where('item', $request->productOrService)->first();
            $unitPrice = $item->unitPrice;
            $bulkUnit = $item->bulkUnit;
            $bulkUnitPrice = $item->bulkUnitPrice;

            if($request->units >= $bulkUnit){
                $request->request->add(['amount' => $bulkUnitPrice*$request->units]);
            }else{
                $request->request->add(['amount' => $unitPrice*$request->units]);
            }
        }

        $insert = Sale::create([
            'type' => $request->type,
            'user_id' => auth()->user()->id,
            'business_id' => auth()->user()->business_id,
            'branch_id' => auth()->user()->branch_id,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'phone' => $request->phone,
            'location' => $request->location,
            'productOrService' => $request->productOrService,
            'units'	=> $request->units,
            'amount' => $request->amount,
            'balance' => $request->balance,
            'change' => $request->change
        ]);
        if ($insert) {
            return redirect()->back()->with('status', 'Transaction recorded successfully!');
        }
    }

    // AJAX REQUEST TO GET RECIEPT
    public function getReciept($data){
        $reciept = Sale::with(['business', 'branch'])->where('id', $data)->first();
        return response()->json($reciept, 200);
    }
    
    // CLEAR OUTSTANDING
    public function clearOutstanding($data){
        $item = Sale::find($data);
        if($item->change > 0){
            $result = $item->amount - $item->change;
            $item->amount = $result;
            $item->change = 0;
        }elseif($item->balance > 0){
            $result = $item->amount + $item->balance;
            $item->amount = $result;
            $item->balance = 0;
        }
        if($item->save()){
            return redirect()->back()->with('status', 'Transaction record Updated!');
        }
    }
    // DELETE SALE
    public function deleteSale($data){
        $item = Sale::find($data);

        if($item->delete()){
            return redirect()->back()->with('status', 'Transaction record Deleted!');
        }
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
