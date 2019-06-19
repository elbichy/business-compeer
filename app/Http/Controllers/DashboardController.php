<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use App\Business;
use App\Branch;
use App\User;
use App\Sale;
use App\Stock;
use Carbon\Carbon;
use App\Notifications\salesApproval;
class DashboardController extends Controller
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

}
