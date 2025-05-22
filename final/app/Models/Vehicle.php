<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;
    protected $table = 'rcc_emergency_vehicles';
    protected $primaryKey = 'rcc_emer_veh_id';
    public $timestamps = true;
    const CREATED_AT = 'rcc_created_at';
    const UPDATED_AT = 'rcc_updated_at';

    protected $fillable = [
        'rcc_veh_type_id',
        'rcc_plate_prefix',
        'rcc_plate_number',
        'rcc_province',
        'rcc_standard_number',
        'rcc_license_expiry_date',
        'rcc_start_year',
        'rcc_pdfFilePath'
    ];

    public function type()
    {
        return $this->belongsTo(VehicleType::class, 'rcc_veh_type_id', 'rcc_veh_type_id');
    }

    public function serviceUnits()
    {
        return $this->belongsToMany(
            ServiceUnit::class,
            'fast_track_service_unit_vehicles',  // ชื่อตาราง pivot ให้ตรงกัน
            'rcc_emer_veh_id',                   // foreign key ของ Vehicle
            'rcc_serv_id'                        // foreign key ของ ServiceUnit
        );
    }
}
