<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Register2Request extends FormRequest
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
            'current_weight' => ['required', 'numeric', 'min:20', 'max:500'],
            'target_weight' => ['required', 'numeric', 'min:20', 'max:500'],
        ];
    }

    public function messages()
    {
        return [
            'current_weight.required' => '現在の体重は必須です。',
            'current_weight.numeric' => '現在の体重は数値で入力してください。',
            'current_weight.min' => '現在の体重は20kg以上で入力してください。',
            'current_weight.max' => '現在の体重は500kg以下で入力してください。',
            'target_weight.required' => '目標の体重は必須です。',
            'target_weight.numeric' => '目標の体重は数値で入力してください。',
            'target_weight.min' => '目標の体重は20kg以上で入力してください。',
            'target_weight.max' => '目標の体重は500kg以下で入力してください。',
        ];
    }
}
