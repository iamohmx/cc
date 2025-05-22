<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleType extends Model
{
    protected $table = 'rcc_vehicle_types';
    public $timestamps = false;
    protected $fillable = ['rcc_veh_type_name'];

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'rcc_veh_type_id');
    }
}
