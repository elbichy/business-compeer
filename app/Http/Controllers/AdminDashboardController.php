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
class AdminDashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    //  MAIN DASHBOARD PAGE
    public function index()
    {
        
        echo "You are logged as Admin!";
    }

}
