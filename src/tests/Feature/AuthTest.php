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
        $data = [
            'name' => 'test',
            'email' => 'test@email.com',
            'password'  => 'test1234',
            'password_confirmation' => 'test1234',
        ];

        $response = $this->post(('/register'), $data);

        // データベースに値が存在するか
        $this->assertDatabaseHas('users', [
            'name'    => 'test',
            'email'   => 'test@email.com',
            'email_verified_at' => null,
        ]);
        $this->assertDatabaseCount( 'users', 1 );

        $response->assertRedirect('/')->assertStatus(302);
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

        $response = $this->post(('/login'), ['email' => $user->email, 'password' => 'password']);
        $response->assertStatus(302);
        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($user);

        // ログインした状態で'/login'にアクセス
        $response = $this->get( '/login' );
        $response->assertStatus(302);
        $response->assertRedirect('/');
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

    // 誤ったメールアドレスを入力した場合エラーメッセージが出るか
    public function test_users_invalid_email(): void
    {
        $user = User::factory()->create();

        $this->assertGuest(); //未ログイン状態であることをチェック

        $response = $this->post('/login', [
            'email' => 'wrong@test.com',
            'password' => $user->password,
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
