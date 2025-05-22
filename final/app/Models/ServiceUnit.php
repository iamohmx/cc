<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceUnit extends Model
{
    protected $table = 'rcc_service_units';
    protected $primaryKey = 'rcc_serv_id';
    public $timestamps = false;
    protected $fillable = [
        'rcc_serv_name',
        'rcc_location',
        'rcc_established_date',
        'rcc_contact_name',
        'rcc_contact_tel',
        'rcc_serv_img_path'
    ];

    protected $with = ['areas'];

    public function areas()
    {
        return $this->belongsToMany(
            ServiceArea::class,
            'rcc_service_unit_areas',  // ชื่อตาราง pivot
            'rcc_serv_id',             // FK ของ ServiceUnit ใน pivot
            'rcc_area_id'              // FK ของ ServiceArea ใน pivot
        );
    }

    public function vehicles()
    {
        return $this->belongsToMany(
            Vehicle::class,
            'fast_track_service_unit_vehicles',  // ชื่อตาราง pivot ตาม migration
            'rcc_serv_id',                       // foreign key ของ ServiceUnit
            'rcc_emer_veh_id'                    // foreign key ของ Vehicle
        );
    }


}
