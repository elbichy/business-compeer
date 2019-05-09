<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Business;
use App\Branch;
class Profile extends Controller
{
    public function myProfile(){
        
        $data = [
            'profileDatails' => User::find(auth()->user()->id),
            'businessDetails' => User::find(auth()->user()->id)->business()->get(),
            'branchDetails' => Business::find(auth()->user()->business_id)->branch()->get()
        ];
        // dd($data);
        return view('dashboard.myProfile')->with('data', $data);
    }
    
    
    public function UserProfile($id){
        $data = [
            'profileDatails' => User::find($id),
            'businessDetails' => User::find(auth()->user()->id)->business()->get(),
            'branchDetails' => Business::find(auth()->user()->business_id)->branch()->get()
        ];
        // dd($data);
        return view('dashboard.userProfile')->with('data', $data);
    }
}
