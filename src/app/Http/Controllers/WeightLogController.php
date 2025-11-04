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
        // 1. 認証済みユーザーを取得
        $user = Auth::user();

        // 2. 目標体重を取得 (WeightTargetモデルから)
        // Userモデルに定義したリレーション (weightTarget) を使用
        $weightTarget = $user->weightTarget;
        $goalWeight = $weightTarget ? $weightTarget->target_weight : null;

        // 3. 最新の体重ログを取得 (WeightLogモデルから)
        // date カラムで降順ソートし、最新のログを1件取得
        $latestLog = $user->weightLogs()
                        ->orderBy('date', 'desc')
                        ->first();

        // 最新の体重値を取得。ログがない場合は null
        $latestWeight = $latestLog ? $latestLog->weight : null;

        // 4. 目標までの差を計算
        $difference = null;
        if ($goalWeight !== null && $latestWeight !== null) {
            // 差分 = 最新体重 - 目標体重
            // プラス値: 目標達成まであとこれだけ減らす必要がある
            // マイナス値: 目標をこれだけ超えて達成している
            $difference = $latestWeight - $goalWeight;
        }

        // ===============================================
        // 【修正点】検索ロジックの追加
        // ===============================================
        $query = $user->weightLogs();
        
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // 開始日が指定されている場合
        if ($startDate) {
            // Carbonで日付をパースし、その日の最初 (00:00:00) を検索条件とする
            $query->whereDate('date', '>=', $startDate);
        }

        // 終了日が指定されている場合
        if ($endDate) {
            // Carbonで日付をパースし、その日の最後 (23:59:59) を検索条件とする
            $query->whereDate('date', '<=', $endDate);
        }
        
        // 検索結果の取得とページネーション
        $weightLogs = $query->orderBy('date', 'desc')
                            ->orderBy('created_at', 'desc') // 日付が同じ場合は新しいものが上に
                            ->paginate(10);
        // ===============================================

        // 5. ビューにデータを渡す
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
            // 1. 運動時間（HH:MM形式）を秒数に変換
            $time_for_db = $validatedData['exercise_time'] . ':00';
            
            // 2. DBのTIME型 ('HH:MM:SS') に戻す
        // gmdate('H:i:s', ...) を使用して秒数をTIME形式の文字列に変換
        
        // 3. ログの保存
        WeightLog::create([
            'user_id' => Auth::id(),
            'date' => $request->date,
            'weight' => $request->weight,
            'calories' => $request->calories,
            'exercise_time' => $time_for_db, // TIME型として保存
            'exercise_content' => $request->exercise_content,
        ]);

        return redirect()->route('log');
    }


    public function detail($id)
    {
        // 1. 該当IDのWeightLogを取得。認証ユーザーのものでなければ404
        $log = WeightLog::where('user_id', Auth::id())->findOrFail($id);


        // 3. ビューにデータを渡す
        return view('detail', [
            'log' => $log,
        ]);
    }

    public function update(StoreRequest $request, $id)
    {
        // 1. 認証ユーザーのログを取得
        $log = WeightLog::where('user_id', Auth::id())
                        ->findOrFail($id);

        // 2. 運動時間（HH:MM形式）に ":00" を加えて DBのTIME型 ('HH:MM:SS') に整形
        // $request->exercise_time が null の場合は null を使用
        $time_for_db = $request->exercise_time ? $request->exercise_time . ':00' : null;

        // 4. ログのプロパティを更新
        $log->date = $request->date;
        $log->weight = $request->weight;
        $log->calories = $request->calories;
        $log->exercise_time = $time_for_db; // TIME型として保存
        $log->exercise_content = $request->exercise_content;

        // デバッグログ: 変更されたか確認
        if ($log->isDirty()) {
            $log->save();
            Log::info('WeightLog update: Dirty attributes found. Log ID: ' . $log->id);
            return redirect()->route('log');
        }
        
        Log::info('WeightLog update: No changes detected. Log ID: ' . $log->id);
        
        // 変更がない場合はリダイレクトのみ
        return redirect()->route('log');
    }


    public function destroy($id)
    {
        // 1. ログを取得し、認証ユーザーのものであることを確認して削除
        $log = WeightLog::where('user_id', Auth::id())->findOrFail($id);
        $log->delete();

        // 2. ログ一覧画面に戻る
        return redirect()->route('log');
    }

}