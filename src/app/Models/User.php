<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, softDeletes;

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
                    'TIMEDIFF(work_end, work_start) as total_work'
            )
            ->selectRaw(
                    'TIMEDIFF(TIMEDIFF(work_end, work_start), SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(rest_end,rest_start))))) as actual_work'
            )
            ->groupBy(
                'name',
                'work_start',
                'work_end',
            );
    }

    public function scopeIdSearch($query, $user_id) {
        if(!empty($user_id)) {
            $query->where('id', $user_id);
        }
    }

    public function scopeTextSearch($query, $keyword) {
        if(!empty($keyword)) {
            $query->Where('name', 'LIKE', '%' .$keyword .'%')
            ->orWhere('email', 'LIKE', '%' .$keyword .'%');
        }
    }

    public function scopeStatusSearch($query, $status) {
        if(!empty($status)) {
            $query->where('status', '=',$status);
        }
    }
}
