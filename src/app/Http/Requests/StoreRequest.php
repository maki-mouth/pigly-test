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
            'date' => ['required', 'date_format:Y-m-d', 'before_or_equal:' . Carbon::now()->format('Y-m-d')],
            'weight' => ['required', 'numeric', 'min:1', 'max:999.9', 'regex:/^\d{1,3}(\.\d{1})?$/'],
            'calories' => ['required', 'integer', 'min:0', 'max:9999'],
            'exercise_time' => ['nullable', 'regex:/^\d{1,}:[0-5][0-9]$/'],
            'exercise_content' => ['nullable', 'string', 'max:120'],
        ];
    }

    /**
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'date.required' => '日付を入力してください',
            'date.date_format' => '日付の形式が正しくありません',
            'date.before_or_equal' => '未来の日付は登録できません',

            'weight.required' => '体重を入力してください',
            'weight.numeric' => '4桁までの数字で入力してください',
            'weight.min' => '体重は1kg以上で入力してください',
            'weight.max' => '体重は999.9kg以下で入力してください',
            'weight.regex' => '小数点は1桁で入力してください',

            'calories.required' => '摂取カロリーを入力してください',
            'calories.integer' => '摂取カロリーは数字で入力してください',
            'calories.min' => '摂取カロリーを正しく入力してください',
            'calories.max' => '摂取カロリーを正しく入力してください',

            'exercise_time.regex' => '運動時間を入力してください',

            'exercise_content.max' => '120文字以内で入力してください',
        ];
    }
}