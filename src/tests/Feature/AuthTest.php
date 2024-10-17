<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Providers\RouteServiceProvider;
use App\Models\User;

class AuthTest extends TestCase
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

    // registerページに正常にアクセスできるか
    public function access_registration_screen(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    // 会員登録後ホーム画面に移遷するか
    // データベースに値が存在するか
    public function test_user_register()
    {
        // email_verified_at = nullで登録;
        $data = [
            'name' => 'test',
            'email' => 'test@email.com',
            'password'  => 'test1234',
            'password_confirmation' => 'test1234',
        ];

        $response = $this->post(('/register'), $data);

        // メール認証機能があるのでstatusが302になる
        $response->assertRedirect('/')->assertStatus(302);

        // データベースに値が存在するか
        $this->assertDatabaseHas('users', [
            'name'    => 'test',
            'email'   => 'test@email.com',
        ]);
    }

    // loginページに正常にアクセスできるか
    public function access_login_screen(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    // ログインが成功するか
    public function test_users_login(): void
    {
        // email_verified_at = now();
        $user = User::factory()->create();

        $this->assertGuest(); //未ログイン状態であることをチェック

        $response = $this->actingAs($user)
            ->get('/');

        $response->assertStatus(200)
            ->assertViewIs('index');


        $this->assertAuthenticated(); //ログインが成功したことをチェック

    }

    // 誤ったパスワードを入力した場合エラーメッセージが出るか
    public function test_users_invalid_password(): void
    {
        $user = User::factory()->create();

        $this->assertGuest(); //未ログイン状態であることをチェック

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors([
            'email' => '認証情報と一致するレコードがありません。'
        ]);

        $this->assertGuest();
    }



    // ログアウト後ログイン画面に移遷するか
    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user); //$userを認証済み状態に

        $this->assertAuthenticated(); //ログインしていることを確認

        $response = $this->post('/logout');

        $this->assertGuest(); //ログアウトしていることを確認

        $response->assertRedirect('/login');
    }

}
