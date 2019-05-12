<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use App\Business;
use App\Branch;
use App\User;
use App\Sale;
use App\Stock;
use Carbon\Carbon;
class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    //  MAIN DASHBOARD PAGE
    public function index()
    {
        if(auth()->user()->business_id == 0){
            return redirect('/Dashboard/businessSettings')->with('noBusinessRecord', 'You need to Setup a Business first');
        }else if(auth()->user()->branch_id == 0){
            return redirect('/Dashboard/branchSettings')->with('noBusinessRecord', 'You have Setup a Branch atleast');
        }else{

            $todaysSales = Branch::find(auth()->user()->branch_id)
                                    ->sales()
                                    ->whereDate('created_at', '=', Carbon::today()->toDateString())
                                    ->orderBy('created_at', 'DESC')
                                    ->get();
            $todaysExpnses = Branch::find(auth()->user()->branch_id)
                                    ->expenses()
                                    ->whereDate('created_at', '=', Carbon::today()->toDateString())
                                    ->orderBy('created_at', 'DESC')
                                    ->get();
            $todaysTransactions = [
                'todaysSales'=>$todaysSales,
                'todaysExpenses'=>$todaysExpnses
            ];

            $data = [
                'todaysTransactions' => $todaysTransactions,
                'businessDetails' => User::find(auth()->user()->id)->business()->get(),
                'branchDetails' => Business::find(auth()->user()->business_id)->branch()->get()
            ];
         }

        // return $data['todaysTransactions']['todaysSales'];
        return view('dashboard.dashboard')->with('data', $data);
    }


    // MY PROFILE PAGE
    public function myProfile(){
        
        $data = [
            'salesDetails' => User::find(auth()->user()->id)->sales()->orderBy('created_at', 'DESC')->get(),
            'totalSales' => User::find(auth()->user()->id)->sales()->sum('amount'),
            'totalSalesCount' => User::find(auth()->user()->id)->sales()->count(),
            'profileDatails' => User::find(auth()->user()->id),
            'businessDetails' => User::find(auth()->user()->id)->business()->get(),
            'branchDetails' => Business::find(auth()->user()->business_id)->branch()->get()
        ];
        // dd($data);
        return view('dashboard.myProfile')->with('data', $data);
    }
    
    
    // USER PROFILE PAGE
    public function UserProfile($id){
        $data = [
            'profileDatails' => User::find($id),
            'businessDetails' => User::find(auth()->user()->id)->business()->get(),
            'branchDetails' => Business::find(auth()->user()->business_id)->branch()->get()
        ];
        // dd($data);
        return view('dashboard.userProfile')->with('data', $data);
    }



    // SALES PAGE
    public function sales()
    {
        if(auth()->user()->business_id == 0){
            return redirect('/Dashboard/businessSettings')->with('noBusinessRecord', 'You need to Setup a Business first');
        }else if(auth()->user()->branch_id == 0){
            return redirect('/Dashboard/branchSettings')->with('noBusinessRecord', 'You have Setup a Branch atleast');
        }else{
            $data = [
                'salesDetails' => Branch::find(auth()->user()->branch_id)->sales()->orderBy('created_at', 'DESC')->get(),
                'stockDetails' => Branch::find(auth()->user()->branch_id)->stocks->toJson(),
                'businessDetails' => User::find(auth()->user()->id)->business()->get(),
                'branchDetails' => Business::find(auth()->user()->business_id)->branch()->get()
            ];
        }
        // dd($data['stockDetails']);
        return view('dashboard.sales')->with('data', $data);
    }


    
    // EXPENSES PAGE
    public function expenses()
    {
        if(auth()->user()->business_id == 0){
            return redirect('/Dashboard/businessSettings')->with('noBusinessRecord', 'You need to Setup a Business first');
        }else if(auth()->user()->branch_id == 0){
            return redirect('/Dashboard/branchSettings')->with('noBusinessRecord', 'You have Setup a Branch atleast');
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


    // STOCK PAGE
    public function stock(Request $request)
    {
        if (Gate::allows('isSalesRep')) {
            return redirect()->back()->with('accessError', 'You have no permission to access page');
        }
        
        if(auth()->user()->business_id == 0){
            return redirect('/Dashboard/businessSettings')->with('noBusinessRecord', 'You need to Setup a Business first');
        }else if(auth()->user()->branch_id == 0){
            return redirect('/Dashboard/branchSettings')->with('noBusinessRecord', 'You have Setup a Branch atleast');
        }else{
            $data = [
                'stockItem' => [],
                'stockDetails' => Branch::find(auth()->user()->branch_id)->stocks()->orderBy('created_at', 'DESC')->get(),
                'businessDetails' => User::find(auth()->user()->id)->business()->get(),
                'branchDetails' => Business::find(auth()->user()->business_id)->branch()->get()
            ];
        }
        // dd($data)
        return view( 'dashboard.stock')->with('data', $data);
    }


    // STATISTICS PAGE
    public function statistics()
    {
        if (Gate::allows('isSalesRep')) {
            return redirect()->back()->with('accessError', 'You have no permission to access page');
        }
        if(auth()->user()->business_id == 0){
            return redirect('/Dashboard/businessSettings')->with('noBusinessRecord', 'You need to Setup a Business first');
        }else if(auth()->user()->branch_id == 0){
            return redirect('/Dashboard/branchSettings')->with('noBusinessRecord', 'You have Setup a Branch atleast');
        }else{
            $data = [
                'businessDetails' => User::find(auth()->user()->id)->business()->get(),
                'branchDetails' => Business::find(auth()->user()->business_id)->branch()->get()
            ];
        }
        // dd($data);
        return view( 'dashboard.statistics')->with('data', $data);
    }


    // CUSTOMERS BASE PAGE
    public function customers()
    {
        if (Gate::allows('isSalesRep')) {
            return redirect()->back()->with('accessError', 'You have no permission to access page');
        }
        if(auth()->user()->business_id == 0){
            return redirect('/Dashboard/businessSettings')->with('noBusinessRecord', 'You need to Setup a Business first');
        }else if(auth()->user()->branch_id == 0){
            return redirect('/Dashboard/branchSettings')->with('noBusinessRecord', 'You have Setup a Branch atleast');
        }else{
            $data = [
                'salesDetails' => Branch::find(auth()->user()->branch_id)->sales()->orderBy('created_at', 'DESC')->get(),
                'businessDetails' => User::find(auth()->user()->id)->business()->get(),
                'branchDetails' => Business::find(auth()->user()->business_id)->branch()->get()
            ];
        }
        // dd($data);
        return view( 'dashboard.customers')->with('data', $data);
    }


    // BUSINESS SETTINGS
    public function businessSettings(){

        if (Gate::allows('isSalesRep') || Gate::allows('isManager')) {
            return redirect()->back()->with('accessError', 'You have no permission to access page');
        }

        if(auth()->user()->business_id == 0 and auth()->user()->branch_id == 0){
            $data = [
                'businessDetails' => [],
                'branchDetails' => []
            ];
        }else{
            $data = [
                'businessDetails' => User::find(auth()->user()->id)->business()->get(),
                'branchDetails' => Business::find(auth()->user()->business_id)->branch()->get()
            ];
        }
        // dd($data);
        return view( 'dashboard.businessSettings')->with('data', $data);
    }


    // BRANCH SETTINGS
    public function branchSettings(){

        if (Gate::allows('isSalesRep') || Gate::allows('isManager')) {
            return redirect()->back()->with('accessError', 'You have no permission to access page');
        }

        if(auth()->user()->business_id == 0){
            return redirect('/Dashboard/businessSettings')->with('noBusinessRecord', 'You need to Setup a Business first');
        }else{
            $data = [
                'businessDetails' => User::find(auth()->user()->id)->business()->get(),
                'branchDetails' => Business::find(auth()->user()->business_id)->branch()->get()
            ];
        }

        // dd($data);
        return view( 'dashboard.branchSettings')->with('data', $data);
    }


    // STAFF SETTINGS
    public function staffSettings(){

        if (Gate::allows('isSalesRep') || Gate::allows('isManager')) {
            return redirect()->back()->with('accessError', 'You have no permission to access page');
        }


        if(auth()->user()->business_id == 0){
            return redirect('/Dashboard/businessSettings')->with('noBusinessRecord', 'You need to Setup a Business first');
        }else if(auth()->user()->branch_id == 0){
            return redirect('/Dashboard/branchSettings')->with('noBusinessRecord', 'You have Setup a Branch atleast');
        }else{
            $data = [
                'businessDetails' => User::find(auth()->user()->id)->business()->get(),
                'branchDetails' => Business::find(auth()->user()->business_id)->branch()->get(),
                'staffDetails' => DB::table('users')
                                        ->select('users.*', 'branches.name as branchName', 'businesses.name as businessName')
                                        ->leftJoin('businesses', 'users.business_id', '=', 'businesses.id')
                                        ->leftJoin('branches', 'users.branch_id', '=', 'branches.id')
                                        ->where('businesses.id', auth()->user()->business_id)
                                        ->orderBy('created_at', 'DESC')
                                        ->get()
            ];
        }
        // dd($data);
        return view( 'dashboard.staffSettings')->with('data', $data);
    }
}
