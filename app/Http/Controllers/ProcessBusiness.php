<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Business;
use App\Branch;
use App\User;
class ProcessBusiness extends Controller
{
    // PROCESS MAIN SETTINGS
    public function businessSettings(Request $request)
    {
 
        $val = $request->validate([
            'name' => 'required|max:255',
            'cac' => 'required|numeric',
            'nature' => 'required',
            'website' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'logo' => 'required|image',
        ]);


        if ($logo = $request->file('logo')) {
            $fileName = $logo->getClientOriginalName();
            $logo->storeAs('public/site', $fileName);
        }

        $insert = Business::updateOrCreate(
            ['user_id' => auth()->user()->id],
            [
            'user_id'=> auth()->user()->id,
            'name' => $request->name,	
            'cac' => $request->cac,	
            'nature' => $request->nature,	
            'website'=> $request->website,
            'email' => $request->email,	
            'phone' => $request->phone,
            'logo' => $fileName
            ]
        );
        
        $business_id = Business::where('user_id', auth()->user()->id)->first()->id;
        
        $staff = User::find(auth()->user()->id);
        $staff->business_id = $business_id;
        $staff->save();

        if ($insert) {
            return redirect('Dashboard/businessSettings')->with('status', 'Company added successfully!');
        }
    }


    // PROCESS BRANCH SETTINGS
    public function branchSettings(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'address' => 'required',
            'phone' => 'required',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'commissionDate' => 'required',
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


    // PROCESS BRANCH SETTINGS
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
            'dob' => 'required',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:8',
            'phone' => 'required',
            'soo' => 'required',
            'lgoo' => 'required',
            'currentAddress' => 'required|max:255',
            'business_id' => 'required',
            'branch_id' => 'required',
            'role' => 'required'
        ]);

        // return $request->all();

        $insert = User::create([
            'firstname' => $request->firstname,
            'lastname' =>  $request->lastname,
            'gender' => $request->gender,
            'dob' => $request->dob,
            'email' =>  $request->email,
            'password' => Hash::make( $request->password),
            'phone' => $request->phone,
            'soo' => $request->soo,
            'lgoo' => $request->lgoo,
            'currentAddress' => $request->currentAddress,
            'business_id' => $request->business_id,
            'branch_id' => $request->branch_id,
            'role' => $request->role,
        ]);
        if ($insert) {
            return redirect('Dashboard/staffSettings')->with('status', 'Staff added successfully!');
        }

    }


}
