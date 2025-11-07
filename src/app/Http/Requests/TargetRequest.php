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
            'target_weight' => ['required', 'numeric', 'min:1', 'max:999.9', 'regex:/^\d{1,3}(\.\d{1})?$/'],
        ];
    }

    /**
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'target_weight.required' => '目標体重を入力してください',
            'target_weight.numeric' => '4桁までの数字で入力してください',
            'target_weight.min' => '目標体重は1kg以上で入力してください',
            'target_weight.max' => '目標体重は999.9kg以下で入力してください',
            'target_weight.regex' => '小数点は1桁で入力してください',
        ];
    }
}
