<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function attendances() {
        return $this->hasMany(Attendance::class);
    }

    public function getUserAttendanceTable() {

        return User::join('attendances', 'users.id', '=', 'attendances.user_id')
            ->leftJoin('rests', 'attendances.id', '=', 'rests.attendance_id')
            ->select(
                'name',
                'work_start',
                'work_end',
            )
            ->selectRaw(
                'SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(rest_end,rest_start)))) as total_rest'
            )
            ->selectRaw(
                    'TIMEDIFF(TIMEDIFF(work_end, work_start), SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(rest_end,rest_start))))) as total_work'
            )
            ->groupBy(
                'name',
                'work_start',
                'work_end',
            );
    }
}
