<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceArea extends Model
{
    protected $table = 'rcc_service_area';

    // เพิ่มบรรทัดนี้ เพื่อบอกว่าคีย์หลักชื่อ rcc_area_id
    protected $primaryKey = 'rcc_area_id';

    public $timestamps = false;
    protected $fillable = ['rcc_area_name'];

    public function units()
    {
        return $this->belongsToMany(
            ServiceUnit::class,
            'rcc_service_unit_areas',
            'rcc_area_id',    // pivot.FK ของ ServiceArea
            'rcc_serv_id'     // pivot.FK ของ ServiceUnit
        );
    }
}
