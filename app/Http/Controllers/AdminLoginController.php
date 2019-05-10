<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Business;
use App\Branch;
use App\User;
use App\Sale;
use App\Stock;
use Carbon\Carbon;
class AdminLoginController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest:admin');
    }

    public function showLoginForm()
    {
        return view('auth.adminLogin');
    }
    
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if(Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])){
            return redirect()->route('admin.dashboard');
        }
        
        return redirect()->back();
        // return $request->all();
    }

}
