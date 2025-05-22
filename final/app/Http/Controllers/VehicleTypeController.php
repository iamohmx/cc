<?php

namespace App\Http\Controllers;

use App\Models\VehicleType;
use Illuminate\Http\Request;
class VehicleTypeController extends Controller
{
    public function index()    { return VehicleType::all(); }
    public function store(Request $r)
    {
        $r->validate(['rcc_veh_type_name'=>'required']);
        return VehicleType::create($r->only('rcc_veh_type_name'));
    }
    public function show(VehicleType $vehicleType) { return $vehicleType; }
    public function update(Request $r, VehicleType $vt)
    {
        $r->validate(['rcc_veh_type_name'=>'required']);
        $vt->update($r->only('rcc_veh_type_name'));
        return $vt;
    }
    public function destroy(VehicleType $vehicleType)
    {
        $vehicleType->delete();
        return response()->noContent();
    }
}
