<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\RegisterRequest;
use App\Models\User;

class RegisterRequestTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    // public function test_example()
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }
    use RefreshDatabase;
    /**
     * RegisterRequestのバリデーションテスト
     *
     * @param array 項目名
     * @param array 値
     * @param boolean 期待値(true:バリデーションOK、false:バリデーションNG)
     * @dataProvider dataProviderExample
     */
    public function testExample(array $keys, array $values, bool $expect)
    {
        $user = User::factory()->create();
        //入力項目の配列（$keys）と値の配列($values)から、連想配列を生成する
        $dataList = array_combine($keys, $values);

        $request = new RegisterRequest();
        //フォームリクエストで定義したルールを取得
        $rules = $request->rules();
        //Validatorファサードでバリデーターのインスタンスを取得、その際に入力情報とバリデーションルールを引数で渡す
        $validator = Validator::make($dataList, $rules);
        //入力情報がバリデーショルールを満たしている場合はtrue、満たしていな場合はfalseが返る
        $result = $validator->passes();
        //期待値($expect)と結果($result)を比較
        $this->assertEquals($expect, $result);
    }

    public function dataProviderExample()
    {
        return [
            'OK' => [
                ['name', 'email', 'password', 'password_confirmation'],
                ['テスト', 'test@example.com', 'test1234', 'test1234'],
                true
            ],
            '名前必須エラー' => [
                ['name', 'email', 'password', 'password_confirmation'],
                [null, 'test@example.com', 'test1234', 'test1234'],
                false
            ],
            '名前形式エラー' => [
                ['name', 'email', 'password', 'password_confirmation'],
                [1, 'test@example.com', 'test1234', 'test1234'],
                false
            ],
            '名前最大文字数エラー' => [
                ['name', 'email', 'password', 'password_confirmation'],
                [str_repeat('a', 192), 'test@example.com', 'test1234', 'test1234'],
                false
            ],

            'メールアドレス必須エラー' => [
                ['name', 'email', 'password', 'password_confirmation'],
                ['テスト', null, 'test1234', 'test1234'],
                false
            ],
            'メールアドレス形式エラー1' => [
                ['name', 'email', 'password', 'password_confirmation'],
                ['テスト', examplecom, 'test1234', 'test1234'],
                false
            ],
            'メールアドレス形式エラー2' => [
                ['name', 'email', 'password', 'password_confirmation'],
                ['テスト', 'test <test@example.com>', 'test1234', 'test1234'],
                false
            ],
            'メールアドレス形式エラー3' => [
                ['name', 'email', 'password', 'password_confirmation'],
                ['テスト', 'test@', 'test1234', 'test1234'],
                false
            ],
            'メールアドレス形式エラー4' => [
                ['name', 'email', 'password', 'password_confirmation'],
                ['テスト', '@example.com', 'test1234', 'test1234'],
                false
            ],
            'メールアドレス重複エラー' => [
                ['name', 'email', 'password', 'password_confirmation'],
                ['テスト', $user->email, 'test1234', 'test1234'],
                false
            ],
            'メールアドレス最大文字数エラー' => [
                ['name', 'email', 'password', 'password_confirmation'],
                ['テスト', str_repeat('a', 180).'@example.com', 'test1234', 'test1234'],
                false
            ],

            'パスワード必須エラー' => [
                ['name', 'email', 'password', 'password_confirmation'],
                ['テスト', 'test@example.com', null, 'test1234'],
                false
            ],
            'パスワード最小文字数エラー' => [
                ['name', 'email', 'password', 'password_confirmation'],
                ['テスト', 'test@example.com', str_repeat('a', 7), 'test1234'],
                false
            ],
            'パスワード最大文字数エラー' => [
                ['name', 'email', 'password', 'password_confirmation'],
                ['テスト', 'test@example.com', str_repeat('a', 192), 'test1234'],
                false
            ],
        ];
    }

}
