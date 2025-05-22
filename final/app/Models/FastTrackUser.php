<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class FastTrackUser extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $table = 'fast_track_users';
    protected $primaryKey = 'fst_user_id';
    public $timestamps = false;

    protected $fillable = [
        'rcc_role_id',
        'rcc_serv_id',
        'fst_username',
        'fst_password',
        'fst_email',
        'fst_status',
        'profile_img_path',
    ];

    protected $hidden = [
        'fst_password',
    ];

    // แฮชพาสเวิร์ดก่อนบันทึก
    public function setFstPasswordAttribute($value)
    {
        $this->attributes['fst_password'] = bcrypt($value);
    }

    // ความสัมพันธ์ (เหมือนเดิม)
    // app/Models/FastTrackUser.php
    public function rcc_roles()
{
    return $this->belongsTo(RccRole::class, 'rcc_role_id', 'rcc_role_id');
}

public function serviceUnit()
{
    return $this->belongsTo(ServiceUnit::class, 'rcc_serv_id', 'rcc_serv_id');
}

}
