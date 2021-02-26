<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;

class LandingController extends Controller
{
    public function index(){
        $companies = Company::with('admin')->paginate(5);
        return view('welcome', ['companies' => $companies]);
    }
}
