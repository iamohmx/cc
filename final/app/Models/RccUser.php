<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Auth\Passwords\CanResetPassword;      // << เพิ่ม
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
// use Illuminate\Auth\Notifications\ResetPassword;

class RccUser extends Authenticatable implements CanResetPasswordContract
{
    use HasApiTokens, Notifiable, CanResetPassword;   // << เพิ่ม CanResetPassword

    protected $table = 'rcc_users';
    protected $primaryKey = 'rcc_user_id';
    public $timestamps = false;

    protected $fillable = [
        'rcc_role_id',
        'rcc_username',
        'rcc_email',
        'rcc_password',
        'rcc_created_at',
        'rcc_updated_at',
    ];

    protected $hidden = [
        'rcc_password',
    ];

    /**
     * แจ้ง Laravel ให้ส่งเมลไปที่คอลัมน์ rcc_email
     */
    public function routeNotificationForMail($notification)
    {
        return $this->rcc_email;
    }


    // ให้ Password Broker ใช้ rcc_email แทน email ปกติ
    public function getEmailForPasswordReset(): string
    {
        return $this->rcc_email;
    }

    // (ถ้าต้องการแจ้งชื่อ attribute สำหรับ routing)
    public function getRouteKeyName()
    {
        return 'rcc_user_id';
    }

    public function role()
    {
        return $this->belongsTo(RccRole::class, 'rcc_role_id');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
