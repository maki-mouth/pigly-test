<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TargetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
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
            'target_weight' => 'required|numeric|min:30|max:300',
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
            'target_weight.required' => '目標体重を入力してください。',
            'target_weight.numeric' => '目標体重は数字で入力してください。',
            'target_weight.min' => '目標体重を正しく入力してください。',
            'target_weight.max' => '目標体重を正しく入力してください。',
        ];
    }
}
