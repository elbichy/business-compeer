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

class BranchSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    
    // BRANCH SETTINGS
    public function branchSettings(){

        if (Gate::allows('isSalesRep') || Gate::allows('isManager')) {
            return redirect()->back()->with('accessError', 'You have no permission to access page');
        }

        if(auth()->user()->business_id == 0){
            return redirect(route('businessSettings'))->with('noBusinessRecord', 'You need to Setup a Business first');
        }else{
            $data = [
                'businessDetails' => User::find(auth()->user()->id)->business()->get(),
                'branchDetails' => Business::find(auth()->user()->business_id)->branch()->get()
            ];
        }

        // dd($data);
        return view( 'dashboard.branchSettings')->with('data', $data);
    }

    // PROCESS BRANCH SETTINGS
    public function storeBranchSettings(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'address' => 'required',
            'openHour' => 'required',
            'closeHour' => 'required'
        ]);
        
        $insert = Branch::create($request->all());

        $branch_id = Business::find(auth()->user()->business_id)->branch()->latest('created_at')->first()->id;
        
        $staff = User::find(auth()->user()->id);
        $staff->branch_id = $branch_id;
        $staff->save();

        if ($insert) {
            return redirect(route('businessSettings'))->with('status', 'Branch added successfully!');
        }
    }

    // DELETE BRANCH
    public function deleteBranch($id){
        $branchUsers = User::where('branch_id', $id)->get();
        foreach($branchUsers as $user){
            if($user->role == 1){
                $user->branch_id = 0;
                $user->save();
            }else{
                $user->delete();
            }
        }
        
        if (Branch::find($id)->delete()) {
            return redirect(route('businessSettings'))->with('status', 'Branch and all related records deleted successfully!');
        }
    }

    // PROCESS BRANCH SWITCH
    public function switchBranch(Request $request)
    {
        $update = User::where('id', 1)
                        ->update (['branch_id' => $request->selectedBranch]);

        if ($update) {
            return redirect()->back()->with('status', 'Branch has been switched!');
        }

    }

    
}
