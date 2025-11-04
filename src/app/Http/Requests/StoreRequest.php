<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class StoreRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 日付: 必須、形式(Y-m-d)、今日以前
            'date' => ['required', 'date_format:Y-m-d', 'before_or_equal:' . Carbon::now()->format('Y-m-d')],
            // 体重: 必須、数値、1.0～999.9まで、小数点以下1桁まで許可
            'weight' => ['required', 'numeric', 'min:1', 'max:999.9', 'regex:/^\d{1,3}(\.\d{1})?$/'],
            // カロリー: 任意、整数、0～9999まで
            'calories' => ['required', 'integer', 'min:0', 'max:9999'],
            'exercise_time' => ['nullable', 'regex:/^\d{1,}:[0-5][0-9]$/'],
            // 運動内容: 任意、文字列、120文字まで
            'exercise_content' => ['nullable', 'string', 'max:120'],
        ];
    }




    /**
     * バリデーションエラーメッセージを日本語で定義する。
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'date.required' => '日付を入力してください。',
            'date.date_format' => '日付の形式が正しくありません。',
            'date.before_or_equal' => '未来の日付は登録できません。',

            'weight.required' => '体重を入力してください。',
            'weight.numeric' => '体重は数字で入力してください。',
            'weight.min' => '体重を正しく入力してください。',
            'weight.max' => '体重を正しく入力してください。',
            'weight.regex' => '小数点は1桁までで入力してください。',

            'calories.required' => '摂取カロリーを入力してください。',
            'calories.integer' => '摂取カロリーは整数で入力してください。',
            'calories.min' => '摂取カロリーを正しく入力してください。',
            'calories.max' => '摂取カロリーを正しく入力してください。',

            'exercise_time.regex' => '運動時間は正しい形式（例: 1:30, 30:00）で入力してください。',

            'exercise_content.max' => '運動内容は120文字以内で入力してください。',
        ];
    }
}