<?php

namespace App\Http\Controllers;

use App\Models\Short;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard(){
        $wallets = Short::all();
        return view('dashboard', compact('wallets'));
    }

}
