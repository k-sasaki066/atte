<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class RouteTest extends TestCase
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

    // 打刻ページに正常にアクセスできるか
    public function test_access_index(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user); //$userを認証済み状態に

        $this->assertAuthenticated(); //ログインしていることを確認

        $response = $this->get('/');
        $response->assertStatus(200);
    }

    // 未ログインでは打刻ページにアクセスできない
    public function test_cant_access_index(): void
    {
        $this->assertGuest(); //未ログイン状態であることをチェック

        $response = $this->get('/');
        $response->assertRedirect('/login');
    }

    // 日付別ページに正常にアクセスできるか
    public function test_access_date(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user); //$userを認証済み状態に

        $this->assertAuthenticated(); //ログインしていることを確認

        $response = $this->get('/attendance');
        $response->assertStatus(200);
    }

    // 未ログインでは日付別ページにアクセスできない
    public function test_cant_access_date(): void
    {
        $this->assertGuest(); //未ログイン状態であることをチェック

        $response = $this->get('/attendance');
        $response->assertRedirect('/login');
    }

    // ユーザー一覧ページに正常にアクセスできるか
    public function test_access_user(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user); //$userを認証済み状態に

        $this->assertAuthenticated(); //ログインしていることを確認

        $response = $this->get('/user');
        $response->assertStatus(200);
    }

    // 未ログインではユーザー一覧ページにアクセスできない
    public function test_cant_access_user(): void
    {
        $this->assertGuest(); //未ログイン状態であることをチェック

        $response = $this->get('/user');
        $response->assertRedirect('/login');
    }

    // 勤怠表ページに正常にアクセスできるか
    public function test_access_schedule(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user); //$userを認証済み状態に

        $this->assertAuthenticated(); //ログインしていることを確認

        $response = $this->get('/schedule');
        $response->assertStatus(200);
    }

    // 未ログインでは勤怠表ページにアクセスできない
    public function test_cant_access_schedule(): void
    {
        $this->assertGuest(); //未ログイン状態であることをチェック

        $response = $this->get('/schedule');
        $response->assertRedirect('/login');
    }
}
