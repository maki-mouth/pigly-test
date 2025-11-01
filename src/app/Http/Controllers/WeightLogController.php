<?php

namespace App\Http\Controllers;

use App\Models\WeightLog;
use Illuminate\Http\Request;

class WeightLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function register1()
    {
        return view('register1');
    }

    public function register2()
    {
        return view('register2');
    }

    public function login()
    {
        return view('login');
    }

    public function log()
    {
        return view('log');
    }

    public function detail()
    {
        return view('detail');
    }

    public function target()
    {
        return view('target');
    }

}