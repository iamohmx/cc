<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;   // <-- import

class HnUser extends Model
{
    use HasApiTokens;                // <-- trait

    protected $table = 'hn_users';
    protected $primaryKey = 'hn_user_id';
    public $timestamps = false;

    protected $fillable = [
        'hn_telNo',
        'hn_password',
        'hn_infoId',
        'hn_created_at',
        'hn_updated_at',
    ];

    protected $hidden = [
        'hn_password',
    ];

    public function personalInfo()
    {
        return $this->belongsTo(HnPersonalInfo::class, 'hn_infoId');
    }
}
