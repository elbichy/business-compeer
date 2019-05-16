<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Business;
use App\Branch;
use App\User;
class ProcessBusinessSettings extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    
    // PROCESS MAIN SETTINGS
    public function businessSettings(Request $request)
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


    // PROCESS BRANCH SETTINGS
    public function branchSettings(Request $request)
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
            return redirect('Dashboard/branchSettings')->with('status', 'Branch added successfully!');
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
            return redirect('Dashboard/branchSettings')->with('status', 'Branch and all related records deleted successfully!');
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
    
    
    // PROCESS STAFF SETTINGS
    public function staffSettings(Request $request)
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
        
        if ($photo = $request->file('photo')) {
            $photoFileName = $photo->getClientOriginalName();
            $photo->storeAs('public/site/profile', $photoFileName);
        }
        if ($idCard = $request->file('idCard')) {
            $idCardFileName = $idCard->getClientOriginalName();
            $idCard->storeAs('public/site/idCards', $idCardFileName);
        }
        if ($signature = $request->file('signature')) {
            $signatureFileName = $signature->getClientOriginalName();
            $signature->storeAs('public/site/signatures', $signatureFileName);
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
            return redirect('Dashboard/staffSettings')->with('status', 'Staff added successfully!');
        }

    }


}
