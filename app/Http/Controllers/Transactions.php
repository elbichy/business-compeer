<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Sale;
use App\Expense;
use App\Stock;
use App\Business;
use App\Branch;
use App\User;
use App\Notifications\salesApproval;
class Transactions extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

}
