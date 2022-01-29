<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TodoRequest extends FormRequest
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
            'title' => 'required|max:30',
            'description' => 'required|max:100',
            'expiration_date' => 'required|date',
            'completion_date' => 'nullable|date',
        ];
    }

    /**
    * バリデーションエラーのメッセージ
    *
    * @return array
    */
    public function messages()
    {
        return [
            'title.required' => '「タイトル」は必須です。',
            'title.max' => '「タイトル」は30文字以内で入力してください。',
            'description.required' =>'「説明」は必須です。',
            'description.max' => '「説明」は100文字以内で入力してください。',
            'expiration_date.required' => '「期限日」は必須です。',
            'expiration_date.date' => '期限日は正しい日付形式で入力してください。',
            'completion_date.date' => '完了日は正しい日付形式で入力してください。',
        ];
    }
}
