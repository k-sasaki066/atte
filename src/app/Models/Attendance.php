<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'work_start',
        'work_end',
    ];

    public function rests() {
        return $this->hasMany(Rest::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function getMonthDate($month) {
        $year = Carbon::now()->format('Y');
        $date = 1;
        $carbon = Carbon::createFromDate($year, $month, $date);
        // dd($carbon);

        // 月初を取得
        $startOfMonth = $carbon->startOfMonth()->toDateString();
        // 月末を取得
        $endOfMonth = $carbon->endOfMonth()->toDateString();
        // 月初～月末の期間を取得
        $periods = CarbonPeriod::create($startOfMonth, $endOfMonth)->toArray();

        return $periods;
    }
}
