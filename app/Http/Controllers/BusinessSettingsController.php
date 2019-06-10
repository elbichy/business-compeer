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

class BusinessSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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

    // PROCESS BUSINESS SETTINGS
    public function storeBusinessSettings(Request $request)
    {
 
        $val = $request->validate([
            'name' => 'required|max:255',
            'cac' => 'numeric',
            'nature' => 'required',
            'email' => 'required'
        ]);

        if ($logo = $request->file('logo')) {
            $logoName = 'logo_'.$request->name.$request->cac.'.'.$logo->getClientOriginalExtension();
            $logo->storeAs('public/site/'.$request->name, $logoName);
        }
 
        if(auth()->user()->business_id == 0){
            $business = new Business;
        }else {
            $business = Business::find(auth()->user()->business_id);
        }

        $business->user_id = auth()->user()->id;
        $business->name = $request->name;
        $business->cac = $request->cac;
        $business->nature = $request->nature;
        $business->website = $request->website;
        $business->email = $request->email;
        $business->phone = $request->phone;
        $request->file('logo') ? $business->logo = $logoName : '';
    
        if($business->save()){
            $business_id = Business::where('user_id', auth()->user()->id)->first()->id;
            
            $staff = User::find(auth()->user()->id);
            $staff->business_id = $business_id;
            if ($staff->save()) {
                return redirect(route('branchSettings'))->with('status', 'Company added successfully! Now set up a branch');
            }
        }
        
    }

    
}
