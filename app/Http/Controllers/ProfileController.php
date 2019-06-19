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

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    //  MAIN DASHBOARD PAGE
    public function index()
    {
        
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
    
    // STORE AND UPDATE MY PROFILE
    public function updateMyProfile(Request $request){

        $val = $request->validate([
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'gender' => 'required',
            'dob' => 'required',
            'phone' => 'required',
            'permanentAddress' => 'required',
            'identityType' => 'required',
            'identityNumber' => 'required'
        ]);

        $business_name = Business::find(auth()->user()->business_id)->name;

        $user = User::find(auth()->user()->id);
        $user->firstname = $request->firstname;
        $user->lastname =  $request->lastname;
        $user->gender = $request->gender;
        $user->dob = $request->dob;
        $user->phone = $request->phone;
        $user->permanentAddress = $request->permanentAddress;
        $user->currentAddress = $request->currentAddress;
        $user->identityType = $request->identityType;
        $user->identityNumber = $request->identityNumber;

        if($request->password){
            $user->password = Hash::make( $request->password);
        }
        if ($photo = $request->file('photo')) {
            $photoFileName = 'avater-'.$request->firstname.$request->lastname.$request->dob.'.'.$photo->getClientOriginalExtension();
            $photo->storeAs('public/site/'.$business_name.'/profile', $photoFileName);
            $user->image = $photoFileName;
        }
        if ($idCard = $request->file('idCard')) {
            $idCardFileName = 'idCard-'.$request->firstname.$request->lastname.$request->dob.'.'.$idCard->getClientOriginalExtension();
            $idCard->storeAs('public/site/'.$business_name.'/idCards', $idCardFileName);
            $user->idCard = $idCardFileName;
        }
        if ($signature = $request->file('signature')) {
            $signatureFileName = 'signature-'.$request->firstname.$request->lastname.$request->dob.'.'.$signature->getClientOriginalExtension();
            $signature->storeAs('public/site/'.$business_name.'/signatures', $signatureFileName);
            $user->signature = $signatureFileName;
        }

        if ($user->save()) {
            return redirect()->back()->with('status', 'Details updated successfully!');
        }
    }
    
    // USER PROFILE PAGE
    public function UserProfile($id){

        $userCompany = User::find($id)->business_id;
        $adminsCompany =  User::find(auth()->user()->id)->business_id;
        if($userCompany != $adminsCompany OR !Gate::allows('isOwner')){
            return redirect()->back()->with('accessError', 'You have no access permission');
        }

        $userBusinessId = User::find($id)->business_id;
        $userBranchId = User::find($id)->branch_id;
        $data = [
            'salesDetails' => User::find($id)->sales()->orderBy('created_at', 'DESC')->get(),
            'totalSales' => User::find($id)->sales()->sum('amount'),
            'totalSalesCount' => User::find($id)->sales()->count(),
            'profileDatails' => User::find($id),
            'userBusinessDetails' => Business::find($userBusinessId),
            'businessDetails' => User::find(auth()->user()->id)->business()->get(),
            'userBranchDetails' => Branch::find($userBranchId),
            'branchDetails' => Business::find(auth()->user()->business_id)->branch()->get()
        ];
        // dd($data);
        return view('dashboard.userProfile')->with('data', $data);
    }


}
