<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Rest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index() {
        $user_id = Auth::user()->id;
        $today = Carbon::now()->format('Y-m-d');

        $today_date = Attendance::where('user_id', $user_id)
        ->whereDate('created_at', $today)
        ->first();

        if(!$today_date) {
            $status = 0;
            User::find($user_id)->fill(['status'=>$status])->save();
        }else {
            $status = Auth::user()->status;
        }
        // dd( $status);

        return view('index')->with('status',$status);
    }

    public function create(Request $request) {
        // dd($request);
        $today = Carbon::now()->format('Y-m-d');
        $now_time = Carbon::now()->format('Y-m-d H:i:00');
        $user_id = Auth::user()->id;
        // dd($user_id);

        if($request->has('rest_start') || $request->has('rest_end')) {
            $attendance_id = Attendance::where('user_id', $user_id)
            ->whereDate('created_at', $today)
            ->first()->id;
        // dd($attendance_id);
        }

        // 勤務開始
        if($request->has('work_start')) {
            $attendance = new Attendance();
            $attendance->fill([
                'user_id'=>$user_id,
                'work_start'=>$now_time,
            ]);
            $status = 1;
            // dd($attendance);
        }

        // 勤務終了
        if($request->has('work_end')) {
            $attendance = Attendance::where('user_id',$user_id)
            ->whereDate('created_at', $today)
            ->first();
            $attendance->fill([
                'work_end'=>$now_time,
            ]);
            $status = 3;
            // dd($attendance);
        }

        // 休憩開始
        if($request->has('rest_start')) {
            $attendance = new Rest();
            $attendance->fill([
                'attendance_id'=>$attendance_id,
                'rest_start'=>$now_time,
            ]);
            $status = 2;
            // dd($attendance_id);
        }

        // 休憩終了
        if($request->has('rest_end')) {
            $attendance = Rest::where('attendance_id', $attendance_id)
            ->whereDate('created_at', $today)
            ->whereNotNull('rest_start')
            ->whereNull('rest_end')
            ->first();
            // dd($attendance);
            $attendance->fill([
                'rest_end'=>$now_time,
            ]);
            $status = 1;
            // dd($attendance);
        }

        $user = User::find($user_id);
        $user->fill(['status' => $status])->save();
        // dd($user);
        $attendance->save();

        return redirect('/')->with('status',$status);
    }

    // 日付別ページ表示（デフォルトで本日分）
    public function date() {
        $display = Carbon::now()->format('Y-m-d');

        $this->users = new User();
        $users = $this->users->getUserAttendanceTable()->whereDate('work_start', $display)
        ->Paginate(5);
        // dd($users);


        return view('attendance-date', compact('users','display'));
    }

    // 日付抽出処理
    public function search(Request $request) {
        $date = Carbon::parse($request->display);
        // dd($date);
        $display = $request->display;
        // dd($display);
        if($request->has('previous-day')) {
            $display = $date->copy()->subDay()->format('Y-m-d');
        }

        if($request->has('next-day')) {
            $display = $date->copy()->addDay()->format('Y-m-d');
        }

        $this->users = new User();
        $users = $this->users->getUserAttendanceTable()->whereDate('work_start', $display)
        ->Paginate(5);
        // dd($users);

        return view('attendance-date', compact('users','display'));
    }

    // user一覧表示
    public function indexUser() {
        $display = Carbon::now()->format('Y-m-d');
        $users = User::select('id', 'name', 'email', 'status', 'created_at')->paginate(5);
        // dd($users);

        return view('attendance-user', compact('display', 'users'));
    }
}
