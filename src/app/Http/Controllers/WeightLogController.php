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
    public function register2()
    {
        return view('register2');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WeightLog  $weightLog
     * @return \Illuminate\Http\Response
     */
    public function show(WeightLog $weightLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WeightLog  $weightLog
     * @return \Illuminate\Http\Response
     */
    public function edit(WeightLog $weightLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WeightLog  $weightLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WeightLog $weightLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WeightLog  $weightLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(WeightLog $weightLog)
    {
        //
    }
}
