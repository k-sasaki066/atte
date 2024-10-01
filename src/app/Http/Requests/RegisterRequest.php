<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name'=>['required', 'string', 'max:191'],
            'email'=>['required', 'email', 'string', 'max:191', 'unique:users,email'],
            'password'=>['required', 'min:8', 'max:191'],
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'お名前を入力してください',
            'name.string'=>'お名前を文字列で入力してください',
            'name.max'=>'お名前は191文字以下で入力してください',
            'email.required'=>'メールアドレスを入力してください',
            'email.email'=>'メールアドレスは「ユーザー名@ドメイン」形式で入力してください',
            'email.string'=>'メールアドレスは文字列で入力してください',
            'email.max'=>'メールアドレスは191文字以下で入力してください',
            'email.unique'=>'このメールアドレスは既に使用されています',
            'password.required'=>'パスワードを入力してください',
            'password.min'=>'パスワードは8文字以上で設定してください',
            'password.max'=>'パスワードは191文字以下で設定してください',
        ];
    }
}
