<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WeightTarget;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\TargetRequest;

class TargetController extends Controller
{
    public function edit()
    {
        $goalWeight = Auth::user()->weightTarget->target_weight ?? null;
        return view('target', compact('goalWeight'));
    }

    public function update(TargetRequest $request)
    {
        $validatedData = $request->validated();

        $weightTarget = Auth::user()->weightTarget ?? new WeightTarget();
        $weightTarget->user_id = Auth::id();
        $weightTarget->target_weight = $validatedData['target_weight'];
        $weightTarget->save();

        return redirect()->route('log');
    }
}
