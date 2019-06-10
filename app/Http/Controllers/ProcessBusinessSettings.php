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


}
