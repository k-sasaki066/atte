<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\LoginRequest;
use App\Models\User;

class LoginRequestTest extends TestCase
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
     * LoginRequestのバリデーションテスト
     *
     * @param array 項目名
     * @param array 値
     * @param boolean 期待値(true:バリデーションOK、false:バリデーションNG)
     * @dataProvider dataProviderExample
     */
    public function testExample(array $keys, array $values, bool $expect)
    {
        // $user = User::factory()->create();
        $data = [
            'name' => 'test',
            'email' => 'test@email.com',
            'password'  => 'test1234',
            'password_confirmation' => 'test1234',
        ];
        //入力項目の配列（$keys）と値の配列($values)から、連想配列を生成する
        $dataList = array_combine($keys, $values);

        $request = new LoginRequest();
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
                ['email', 'password'],
                ['test@example.com', 'test1234'],
                true
            ],
            'メールアドレス形式エラー1' => [
                ['email', 'password'],
                ['testexample.com', 'test1234'],
                false
            ],
            'メールアドレス形式エラー2' => [
                ['email', 'password'],
                ['testexamplecom', 'test1234'],
                false
            ],
            'メールアドレス形式エラー3' => [
                ['email', 'password'],
                ['test@', 'test1234'],
                false
            ],
            'メールアドレス形式エラー4' => [
                ['email', 'password'],
                ['example.com', 'test1234'],
                false
            ],
            'メールアドレス必須エラー' => [
                ['email', 'password'],
                [null, 'test1234'],
                false
            ],

            'パスワード必須エラー' => [
                ['email', 'password'],
                ['test@email.com', null],
                false
            ],
        ];
    }
}
