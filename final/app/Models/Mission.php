<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{
    protected $table = 'fast_track_mission_logs';
    protected $primaryKey = 'fst_mis_log_id';
    public $timestamps = false;

    protected $fillable = [
        'rcc_emer_veh_id',
        'hn_incident_id',
        'fst_hosp_id',
        'fst_command_time',
        'fst_receive_time',
        'fst_receive_mileage',
        'fst_incident_time',
        'fst_incident_mileage',
        'fst_hospital_time',
        'fst_hospital_mileage',
        'fst_status',
    ];

    public function cancellations()
    {
        return $this->hasMany(MissionCancellation::class, 'fst_mis_log_id');
    }
}
