<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Attendance;
use Carbon\Carbon;

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
        $response->assertRedirect('/login')->assertStatus(302);
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
        $response->assertRedirect('/login')->assertStatus(302);
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
        $response->assertRedirect('/login')->assertStatus(302);
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
        $response->assertRedirect('/login')->assertStatus(302);
    }

    // 打刻時間がデータベースに保存されるか
    public function test_can_attendance_post()
    {
        $user = User::factory()->create();
        $today = Carbon::now()->format('Y-m-d');

        // 勤務開始
        $response = $this->actingAs($user)->post('/', [
            'work_start' => Carbon::now(),
        ]);
        $response->assertStatus(302);
        $this->assertDatabaseHas('attendances', [
            'user_id' => $user->id,
            'work_start' => Carbon::now()->format('Y-m-d H:i:00'),
        ]);

        // 勤務終了
        $response = $this->actingAs($user)->post('/', [
            'work_end' => Carbon::now(),
        ]);
        $response->assertStatus(302);
        $this->assertDatabaseHas('attendances', [
            'user_id' => $user->id,
            'work_start' => Carbon::now()->format('Y-m-d H:i:00'),
            'work_end' => Carbon::now()->format('Y-m-d H:i:00'),
        ]);

        // 休憩開始
        $response = $this->actingAs($user)->post('/', [
            'rest_start' => Carbon::now(),
        ]);
        $response->assertStatus(302);
        $this->assertDatabaseHas('rests', [
            'attendance_id' => Attendance::where('user_id', $user->id)->whereDate('created_at', $today)
            ->first()->id,
            'rest_start' => Carbon::now()->format('Y-m-d H:i:00'),
        ]);

        // 休憩終了
        $response = $this->actingAs($user)->post('/', [
            'rest_end' => Carbon::now(),
        ]);
        $response->assertStatus(302);
        $this->assertDatabaseHas('rests', [
            'attendance_id' => Attendance::where('user_id', $user->id)->whereDate('created_at', $today)
            ->first()->id,
            'rest_start' => Carbon::now()->format('Y-m-d H:i:00'),
            'rest_start' => Carbon::now()->format('Y-m-d H:i:00'),
        ]);
    }

    // user情報が更新できるか
    public function test_can_user_edit()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->patch('/user', [
            'id' => $user->id,
            'name' => $user->name,
            'email' => 'example@test.com'
        ]);
        $response->assertStatus(302);
        $this->assertDatabaseHas('users', [
            'name' => $user->name,
            'email' => 'example@test.com'
        ]);
    }

    // user情報が論理削除できるか
    public function test_can_user_delete()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->delete('/user/search', [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]);
        $response->assertStatus(302);
        $this->assertSoftDeleted($user);
    }
}
