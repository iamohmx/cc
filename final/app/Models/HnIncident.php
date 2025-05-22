<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HnIncident extends Model
{
    protected $table = 'hn_incidents';
    protected $primaryKey = 'hn_incident_id';
    public $timestamps = true;
    const CREATED_AT = 'hn_created_at';
    const UPDATED_AT = 'hn_updated_at';

    protected $fillable = [
        'hn_caseNo',
        'hn_note',
        'hn_location_link',
        'hn_Ispatient_conscious',
        'hn_Ispatient_breathing',
        'hn_num_victims',
        'hn_symptoms',
        'hn_status',
        'hn_source',
    ];

    // ความสัมพันธ์ไปยัง pivot table
    public function images()
    {
        return $this->belongsToMany(
            HnImage::class,
            'hn_incident_images',
            'hn_incident_id',
            'hn_img_id'
        )->withPivot('hn_created_at','hn_updated_at');
    }


    public static function generateCaseNo(): string
    {
        // หา id สูงสุดปัจจุบัน (ถ้ายังไม่มี ให้เป็น 0)
        $maxId = static::max('hn_incident_id') ?? 0;

        // ลำดับถัดไป
        $next = $maxId + 1;

        // เติม 0 ด้านหน้าให้เต็ม 8 หลัก
        return str_pad((string)$next, 8, '0', STR_PAD_LEFT);
    }
}
