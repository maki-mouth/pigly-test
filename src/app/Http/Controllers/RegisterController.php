<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\WeightTarget;
use App\Models\WeightLog;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Register1Request;
use App\Http\Requests\Register2Request;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    public function showRegister1()
    {
        return view('register1', [
            'data' => session('registration_data.step1', [])
    ]);
    }

    public function processRegister1(Register1Request $request)
    {
        session(['registration_data.step1' => $request->validated()]);

        return redirect()->route('register2');
    }

    public function showRegister2()
    {
        if (!session()->has('registration_data.step1')) {
            return redirect()->route('register1');
        }

        return view('register2');
    }

    public function processRegister2(Register2Request $request)
    {
        $step1Data = session('registration_data.step1');
        if (!$step1Data) {
            session()->flash('error', '登録情報が見つかりません。最初からやり直してください。');
            return redirect()->route('register1');
        }

        $validatedData = $request->validated();

        $user = null;

        try {

            DB::transaction(function () use ($step1Data, $validatedData, &$user) {

                $user = User::create([
                    'name' => $step1Data['name'],
                    'email' => $step1Data['email'],
                    'password' => Hash::make($step1Data['password']),
                ]);

                WeightTarget::create([
                    'user_id' => $user->id,
                    'target_weight' => $validatedData['target_weight'],
                ]);

                WeightLog::create([
                    'user_id' => $user->id,
                    'date' => now()->toDateString(),
                    'weight' => $validatedData['current_weight'],
                    'calories' => 0,
                    'exercise_time' => '00:00:00',
                    'exercise_content' => null,
                ]);
            });

            if ($user) {
                Auth::login($user);
            }

            session()->forget('registration_data');
            return redirect()->route('log');

        } catch (\Exception $e) {
            session()->flash('error', 'ユーザー登録に失敗しました。再度お試しください。');
            \Log::error('Registration failed: ' . $e->getMessage());
            return redirect()->route('register1')->withInput();
        }
    }
}