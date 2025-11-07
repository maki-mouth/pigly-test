<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WeightLog;
use App\Models\WeightTarget;
use App\Models\User;
use App\Http\Requests\StoreRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class WeightLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function log(Request $request)
    {
        $user = Auth::user();

        $weightTarget = $user->weightTarget;
        $goalWeight = $weightTarget ? $weightTarget->target_weight : null;

        $latestLog = $user->weightLogs()
                        ->orderBy('date', 'desc')
                        ->first();

        $latestWeight = $latestLog ? $latestLog->weight : null;

        $difference = null;
        if ($goalWeight !== null && $latestWeight !== null) {
            // 差分 = 最新体重 - 目標体重
            // プラス値: 目標達成まであとこれだけ減らす必要がある
            // マイナス値: 目標をこれだけ超えて達成している
            $difference = $latestWeight - $goalWeight;
        }

        // ===============================================
        // 検索ロジックの追加
        // ===============================================
        $query = $user->weightLogs();

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        if ($startDate) {
            $query->whereDate('date', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('date', '<=', $endDate);
        }

        $weightLogs = $query->orderBy('date', 'desc')
                            ->orderBy('created_at', 'desc')
                            ->paginate(8);
        // ===============================================

        return view('log', [
            'goalWeight' => $goalWeight,
            'latestWeight' => $latestWeight,
            'difference' => $difference,
            'weightLogs' => $weightLogs,
        ]);
    }

        public function store(StoreRequest $request)
        {
            $validatedData = $request->validated();
            $time_for_db = $validatedData['exercise_time'] . ':00';

        WeightLog::create([
            'user_id' => Auth::id(),
            'date' => $request->date,
            'weight' => $request->weight,
            'calories' => $request->calories,
            'exercise_time' => $time_for_db,
            'exercise_content' => $request->exercise_content,
        ]);

        return redirect()->route('log');
    }


    public function detail($id)
    {
        $log = WeightLog::where('user_id', Auth::id())->findOrFail($id);

        return view('detail', [
            'log' => $log,
        ]);
    }

    public function update(StoreRequest $request, $id)
    {
        $log = WeightLog::where('user_id', Auth::id())
                        ->findOrFail($id);

        $time_for_db = $request->exercise_time ? $request->exercise_time . ':00' : null;

        $log->date = $request->date;
        $log->weight = $request->weight;
        $log->calories = $request->calories;
        $log->exercise_time = $time_for_db;
        $log->exercise_content = $request->exercise_content;

        if ($log->isDirty()) {
            $log->save();
            Log::info('WeightLog update: Dirty attributes found. Log ID: ' . $log->id);
            return redirect()->route('log');
        }

        Log::info('WeightLog update: No changes detected. Log ID: ' . $log->id);

        return redirect()->route('log');
    }


    public function destroy($id)
    {
        $log = WeightLog::where('user_id', Auth::id())->findOrFail($id);
        $log->delete();

        return redirect()->route('log');
    }

}