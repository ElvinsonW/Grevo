<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CarbonCalculatorController extends Controller
{
    public function index(){
        return view('User.carbon-calculator.carbon-calculator');
    }

    public function question(){
        return view('User.carbon-calculator.carbon-question');
    }

    public function result(Request $request){
        $carbon = $request->carbon;
        return view('User.carbon-calculator.carbon-result', ["carbon" => $carbon]);
    }
}
