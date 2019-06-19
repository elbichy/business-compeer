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

class StaffSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // STAFF SETTINGS
    public function staffSettings(){

        if (Gate::allows('isSalesRep') || Gate::allows('isManager')) {
            return redirect()->back()->with('accessError', 'You have no permission to access page');
        }

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
        // dd($data);
        return view( 'dashboard.staffSettings')->with('data', $data);
    }

    // PROCESS STAFF SETTINGS
    public function storeStaffSettings(Request $request)
    {
        $val = $request->validate([
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'gender' => 'required',
            'email' => 'required|email|max:255|unique:users',
            'phone' => 'required',
            'business_id' => 'required',
            'branch_id' => 'required',
            'role' => 'required',
            'identityType' => 'required',
            'identityNumber' => 'required',
            'idCard' => 'required',
            'photo' => 'required',
            'signature' => 'required'
        ]);
        
        $business_name = Business::find($request->business_id)->name;

        if ($photo = $request->file('photo')) {
            $photoFileName = $photo->getClientOriginalName();
            $photo->storeAs('public/site/'.$business_name.'/profile', $photoFileName);
        }
        if ($idCard = $request->file('idCard')) {
            $idCardFileName = $idCard->getClientOriginalName();
            $idCard->storeAs('public/site/'.$business_name.'/idCards', $idCardFileName);
        }
        if ($signature = $request->file('signature')) {
            $signatureFileName = $signature->getClientOriginalName();
            $signature->storeAs('public/site/'.$business_name.'/signatures', $signatureFileName);
        }

        $insert = User::create([
            'firstname' => $request->firstname,
            'lastname' =>  $request->lastname,
            'gender' => $request->gender,
            'email' =>  $request->email,
            'password' => Hash::make( $request->phone),
            'phone' => $request->phone,
            'business_id' => $request->business_id,
            'branch_id' => $request->branch_id,
            'role' => $request->role,
            'identityType' => $request->identityType,
            'identityNumber' => $request->identityNumber,
            'idCard' => $idCardFileName,
            'image' => $photoFileName,
            'signature' => $signatureFileName,
        ]);
        if ($insert) {
            return redirect(route('staffSettings'))->with('status', 'Staff added successfully!');
        }

    }


}
