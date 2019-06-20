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
use App\Transfer;
use App\Expense;
use App\Stock;
use Carbon\Carbon;
use App\Notifications\salesApproval;


class SaleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }



    // SALES PAGE - view
    public function sales()
    {
        
        $data = [
            'salesDetails' => Branch::find(auth()->user()->branch_id)->sales()->orderBy('created_at', 'DESC')->paginate(6),
            'stockDetails' => Branch::find(auth()->user()->branch_id)->stocks->toJson(),
            'businessDetails' => User::find(auth()->user()->id)->business()->get(),
            'branchDetails' => Business::find(auth()->user()->business_id)->branch()->get()
        ];
        // dd($data['stockDetails']);
        return view('dashboard.sales')->with('data', $data);
    }

    // STORE NEW SALE, TRANSFER AND UTILITY RECORDS
    public function storeSales(Request $request)
    {
        if($request->transactionForm == 'sales'){ //THIS PROCESSES SALES
            $val = $request->validate([
                'phone' => 'numeric',
                'location' => 'required',
                'productOrService' => 'required',
                'balance' => 'numeric',
                'change' => 'numeric',
            ]);
    
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
            $arr = array('msg' => 'Transaction added successfully!', 'from' => 'sales', 'row' => $insert, 'status' => true);
            }
            return Response()->json($arr);

        }elseif($request->transactionForm == 'transfer'){ //THIS PROCESSES TRANSFERS
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
                        'type' => 'transfer',
                        'msg' => 'Transfer request',
                        'Business' => auth()->user()->business_id,
                        'branch' => Branch::find(auth()->user()->branch_id)->name,
                        'staffId' => auth()->user()->id,
                        'staffName' => auth()->user()->firstname.' '.auth()->user()->lastname,
                        'depositor' => $request->firstname.' '.$request->lastname,
                        'reciepient' => $request->recievers_firstname.' '.$request->recievers_lastname,
                        'bankName' => $request->bankName,
                        'accountNumber' => $request->accountNumber,
                        'amount' => $request->amount,
                        'refNumver' => $refNumber,
                        'url' => url('/dashboard/sales/manage-transfers')
                    ];
                    $user->notify(new salesApproval($data));
                    $arr = array('msg' => 'Transaction added successfully!', 'from' => 'transfers', 'status' => true);
                }
                return Response()->json($arr);

            }
        }elseif($request->transactionForm == 'utility'){ //THIS PROCESSES TRANSFERS
            $val = $request->validate([
                'firstname' => 'required',
                'lastname' => 'required',
                'phone' => 'numeric',
                'location' => 'required',
                'utilityType' => 'required',
                'utilityOptions' => 'required',
                'utilityIDnumber' => 'required',
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
                'productOrService' => 'utility',
                'units'	=> 1,
                'amount' => $request->charge,
                'refNumber' => $refNumber
            ]);

            if($sale){
                // Insert to utility
                $theSale = Sale::where('refNumber', $refNumber)->first();
                $utility = $theSale->utility()->create([
                    'user_id' => auth()->user()->id,
                    'refNumber' => $refNumber,
                    'business_id' => auth()->user()->business_id,
                    'branch_id' => auth()->user()->branch_id,
                    'utilityType' => $request->utilityType,
                    'utilityOptions' => $request->utilityOptions,
                    'utilityIDnumber' => $request->utilityIDnumber,
                    'amount' => $request->amount,
                    'amountInWords' => \Terbilang::make($request->amount)
                ]);

                $arr = array('msg' => 'Something goes to wrong. Please try again lator', 'status' => false);
                if($utility){
                    $admin = Business::find(auth()->user()->business_id)->users()->orderBy('id', 'ASC')->first()['id'];
                    $user = User::find($admin);
                    $data = [
                        'type' => 'utility',
                        'msg' => 'Utility payment request',
                        'Business' => auth()->user()->business_id,
                        'branch' => auth()->user()->branch_id,
                        'user' => auth()->user()->id,
                        'refNumver' => $refNumber,
                        'url' => url('/dashboard/sales/manage-utility-bill-payment')
                    ];
                    $user->notify(new salesApproval($data));
                    $arr = array('msg' => 'Transaction added successfully!', 'from' => 'utility', 'status' => true, 'data' => $data);
                }
                return Response()->json($arr);

            }
        }
    }
    




    ////////////////////////////////////////// TRANSFER PROCESSING ///////////////////////////////////////////////

    // MOBILE MONEY TRANSFER PAGE - view
    public function transfers()
    {
        $data = [
            'salesDetails' => Branch::find(auth()->user()->branch_id)->sales()->with('transfer')->orderBy('created_at', 'DESC')->paginate(6),
            'businessDetails' => User::find(auth()->user()->id)->business()->get(),
            'branchDetails' => Business::find(auth()->user()->business_id)->branch()->get()
        ];
        // return auth()->user()->notifications->count();
        // foreach(auth()->user()->notifications as $notification){
        //     return $notification->data['data']['saleDetails']['business_id'];
        // }
        return view('dashboard.transfers')->with('data', $data);
    }

    // ADMIN PROCESS TRANSFER
    public function manageTransfers()
    {
        if(!Gate::allows('isOwner')){
            return redirect()->back()->with('accessError', 'You have no permission to access the page');
        }
        
        
        $data = [
            'salesDetails' => $user = User::find(auth()->user()->id)->unreadNotifications,
            'businessDetails' => User::find(auth()->user()->id)->business()->get(),
            'branchDetails' => Business::find(auth()->user()->business_id)->branch()->get()
        ];
        // return $data['salesDetails'];
        return view('dashboard.manageTransfers')->with('data', $data);
    }
    
    // ADMIN GET TRANSFER DETAIL
    public function getTransfer($id)
    {
        if(!Gate::allows('isOwner')){
            return redirect()->back()->with('accessError', 'You have no permission to access the page');
        }
        $record = Sale::where('refNumber', $id)->with('transfer', 'user', 'branch')->first();
        return response()->json($record);
    }
    
    
    // ADMIN TRANSFER APPROVAL
    public function transferApproval($id)
    {
        if(!Gate::allows('isOwner')){
            return redirect()->back()->with('accessError', 'You have no permission to access the page');
        }
        $record = Transfer::where('sale_id', $id)->first();
        $record->status = 2;
        $record->save();
        // return response()->json($record); continue from here
    }
    // ADMIN TRANSFER DECLINE
    public function transferDecline($id)
    {
        if(!Gate::allows('isOwner')){
            return redirect()->back()->with('accessError', 'You have no permission to access the page');
        }
        $record = Sale::where('id', $id)->with('transfer', 'user', 'branch')->first();
        return response()->json($record);
    }
    

    // TRANSFER AJAX LAST ADDED
    public function lastAddedTransfer(){
        $arr = array('msg' => 'Something goes to wrong. Please try again lator', 'status' => false);
        $record = Branch::find(auth()->user()->branch_id)->sales()->with('transfer')->orderBy('created_at', 'DESC')->latest()->first();
        if($record != NULL){ 
            return Response()->json($record);
        }else{
            return Response()->json($arr);
        }
    }

    
    



    ////////////////////////////////////////// UTILITY PROCESSING ///////////////////////////////////////////////

    // UTILITY PAGE - view
    public function utility(){
            $data = [
                'salesDetails' => Branch::find(auth()->user()->branch_id)->sales()->with('utility')->orderBy('created_at', 'DESC')->paginate(6),
                'businessDetails' => User::find(auth()->user()->id)->business()->get(),
                'branchDetails' => Business::find(auth()->user()->business_id)->branch()->get()
            ];
        
        return view('dashboard.utility')->with('data', $data);
    }

    // ADMIN PROCESS UTILITY
    public function manageUtility(){
        if(!Gate::allows('isOwner')){
            return redirect()->back()->with('accessError', 'You have no permission to access the page');
        }
        $data = [
            'salesDetails' => Business::find(auth()->user()->business_id)->sales()->with('utility', 'branch', 'user')
            ->orderBy('created_at', 'DESC')->paginate(6),
            'businessDetails' => User::find(auth()->user()->id)->business()->get(),
            'branchDetails' => Business::find(auth()->user()->business_id)->branch()->get()
        ];
        // dd($data);
        return view('dashboard.manageUtility')->with('data', $data);
    }

    // UTILITY AJAX LAST ADDED
    public function lastAddedUtility(){
        $arr = array('msg' => 'Something goes to wrong. Please try again lator', 'status' => false);
        $record = Branch::find(auth()->user()->branch_id)->sales()->with('utility')->orderBy('created_at', 'DESC')->latest()->first();
        if($record != NULL){ 
            return Response()->json($record);
        }else{
            return Response()->json($arr);
        }
    }

    
    

    ///////////////////////////////////////////// GENERAL FUNCTIONALITIES /////////////////////////////////////

    // CLEAR OUTSTANDING
    public function clearOutstanding(Request $request){
        
        // return response()->json($request);

        $item = Sale::find($request->salesId);
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
            return response()->json($item);
        }
    }

    // AJAX REQUEST TO GET RECIEPT
    public function getReciept($data){
        $reciept = Sale::with(['business', 'branch'])->where('id', $data)->first();
        return response()->json($reciept, 200);
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

    // LOAD NOTIFICATION
    public function loadNotification($count){
        if(auth()->user()->unreadNotifications->count() > 0){
            if(auth()->user()->unreadNotifications->count() > $count){
                return Response()->json(['newCount' => auth()->user()->unreadNotifications->count(), 'data' => auth()->user()->unreadNotifications->first(), 'greater' => true, 'less' => false]);
            }elseif(auth()->user()->notifications->count() < $count){
                return Response()->json(['newCount' => auth()->user()->unreadNotifications->count(), 'data' => auth()->user()->unreadNotifications->first(), 'greater' => false, 'less' => true]);
            }else{
                return Response()->json(['newCount' => auth()->user()->unreadNotifications->count(), 'data' => auth()->user()->unreadNotifications->first(), 'greater' => false, 'less' => false]);
            }
        }else{
            return Response()->json(['newCount' => 0, 'greater' => false, 'less' => false]);
        }
    }



}
