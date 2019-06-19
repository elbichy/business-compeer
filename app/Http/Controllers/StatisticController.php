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

class StatisticController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    
     // STATISTICS PAGE
     public function statistics()
     {
         if (Gate::allows('isSalesRep')) {
             return redirect()->back()->with('accessError', 'You have no permission to access page');
         }
         
        $data = [
            'businessDetails' => User::find(auth()->user()->id)->business()->get(),
            'branchDetails' => Business::find(auth()->user()->business_id)->branch()->get()
        ];
         // dd($data);
         return view( 'dashboard.statistics')->with('data', $data);
     }

     
}
