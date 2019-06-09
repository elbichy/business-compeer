<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Sale;
use App\Expense;
use App\Stock;
use App\Business;
use App\Branch;
use App\User;
use App\Notifications\salesApproval;
class Transactions extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    



///////////////////////////////////////////// SALES FUNCTIONALITIES //////////////////////////////////////////////
   
    // STORE NEW SALE AND TRANSFER RECORDS
    public function storeSales(Request $request)
    {
        if($request->has('salesTransaction')){ //THIS PROCESSES SALES
            $val = $request->validate([
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
            $arr = array('msg' => 'Something goes to wrong. Please try again lator', 'status' => false);
            if($insert){ 
            $arr = array('msg' => 'Successfully submit form using ajax', 'from' => 'sales', 'status' => true);
            }
            return Response()->json($arr);

        }elseif($request->has('transferTransaction')){ //THIS PROCESSES TRANSFERS
            $val = $request->validate([
                'firstname' => 'required',
                'lastname' => 'required',
                'phone' => 'numeric',
                'location' => 'required',
                'recievers_firstname' => 'required',
                'recievers_lastname' => 'required',
                'recievers_phone' => 'required',
                'bankName' => 'required',
                'accountType' => 'required',
                'accountNumber' => 'required|max:10',
                'amount' => 'required',
                'charge' => 'required'
            ]);

            $refNumber = Str::random(12);
            // Insert to sale
            $sale = Sale::create([
                'type' => 'service',
                'user_id' => auth()->user()->id,
                'business_id' => auth()->user()->business_id,
                'branch_id' => auth()->user()->branch_id,
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'phone' => $request->phone,
                'location' => $request->location,
                'productOrService' => 'transfer',
                'units'	=> 1,
                'amount' => $request->charge,
                'refNumber' => $refNumber
            ]);

            if($sale){
                // Insert to transfer
                $theSale = Sale::where('refNumber', $refNumber)->first();
                $transfer = $theSale->transfer()->create([
                    'user_id' => auth()->user()->id,
                    'refNumber' => $refNumber,
                    'business_id' => auth()->user()->business_id,
                    'branch_id' => auth()->user()->branch_id,
                    'recievers_firstname' => $request->recievers_firstname,
                    'recievers_lastname' => $request->recievers_lastname,
                    'recievers_phone' => $request->recievers_phone,
                    'bankName' => $request->bankName,
                    'accountType' => $request->accountType,
                    'accountNumber' => $request->accountNumber,
                    'amount' => $request->amount,
                    'amountInWords' => \Terbilang::make($request->amount)
                ]);

                $arr = array('msg' => 'Something goes to wrong. Please try again lator', 'status' => false);
                if($transfer){
                    $admin = Business::find(auth()->user()->business_id)->users()->orderBy('id', 'ASC')->first()['id'];
                    $user = User::find($admin);
                    $data = [
                        'saleDetails' => $sale,
                        'transferDetails' => $transfer
                    ];
                    $user->notify(new salesApproval($data));
                    $arr = array('msg' => 'Transaction added successfully!', 'from' => 'transfers', 'status' => true);
                }
                return Response()->json($arr);

            }
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
        $item->transfer ? $item->transfer()->delete() : ''; //deletes corresponding transaction if any
        $arr = array('msg' => 'Something goes to wrong. Please try again later', 'status' => false);
        if($item->delete()){
            $arr = array('msg' => 'Record deleted successfully!', 'status' => true);
        }
        return Response()->json($arr);
    }












////////////////////////////////////////// EXPENSES FUNCTIONALITIES //////////////////////////////////////////////

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












////////////////////////////////////////// STOCK FUNCTIONALITIES //////////////////////////////////////////////
    
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
