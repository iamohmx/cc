<?php

// app/Http/Controllers/ServiceUnitVehicleController.php
namespace App\Http\Controllers;

use App\Http\Requests\AttachVehicleRequest;
use App\Models\ServiceUnit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServiceUnitVehicleController extends Controller
{
    public function store(AttachVehicleRequest $request): JsonResponse
    {
        $data = $request->validated();
        $serviceUnit = ServiceUnit::find($data['rcc_serv_id']);

        // ตรวจสอบการผูกรถซ้ำ ด้วย wherePivot
        if ($serviceUnit->vehicles()
            ->wherePivot('rcc_emer_veh_id', $data['rcc_emer_veh_id'])
            ->exists()
        ) {
            return response()->json([
                'message' => 'รถคันนี้ถูกผูกกับหน่วยบริการแล้ว'
            ], 409);
        }

        $serviceUnit->vehicles()->attach($data['rcc_emer_veh_id']);

        return response()->json([
            'message' => 'เพิ่มรถเข้าไปในหน่วยบริการเรียบร้อยแล้ว',
            'data'    => $data
        ], 201);
    }


    // เรียกดูรถทั้งหมดในหน่วยบริการ
    public function index($serv_id): JsonResponse
    {
        $serviceUnit = ServiceUnit::with('vehicles.type')->find($serv_id);
        if (! $serviceUnit) {
            return response()->json([
                'message' => 'หน่วยบริการไม่พบในระบบ'
            ], 404);
        }

        return response()->json([
            'data' => $serviceUnit->vehicles
        ], 200);
    }

    // app/Http/Controllers/ServiceUnitVehicleController.php

    public function show($serv_id, $veh_id): JsonResponse
    {
        $serviceUnit = ServiceUnit::find($serv_id);
        if (! $serviceUnit) {
            return response()->json(['message' => 'หน่วยบริการไม่พบในระบบ'], 404);
        }

        // ใช้ wherePivot เพื่อระบุคอลัมน์ใน pivot table
        $vehicle = $serviceUnit
            ->vehicles()               // BelongsToMany query
            ->with('type')             // eager load type
            ->wherePivot('rcc_emer_veh_id', $veh_id)
            ->first();

        if (! $vehicle) {
            return response()->json(['message' => 'รถคันนี้ไม่ถูกผูกกับหน่วยบริการ'], 404);
        }

        return response()->json(['data' => $vehicle], 200);
    }

    public function update(Request $request, $serv_id, $veh_id): JsonResponse
    {
        $request->validate([
            'new_serv_id' => 'required|exists:rcc_service_units,rcc_serv_id',
        ]);

        $old = ServiceUnit::find($serv_id);
        if (! $old) return response()->json(['message' => 'หน่วยบริการต้นทางไม่พบ'], 404);

        // ตรวจว่ารถคันนี้ผูกกับ pivot จริง
        if (! $old->vehicles()->wherePivot('rcc_emer_veh_id', $veh_id)->exists()) {
            return response()->json(['message' => 'รถคันนี้ไม่ถูกผูกกับหน่วยบริการต้นทาง'], 404);
        }

        // ถอดจากเดิม
        $old->vehicles()->detach($veh_id);

        // ผูกเข้ากับหน่วยใหม่
        $new = ServiceUnit::find($request->new_serv_id);
        $new->vehicles()->attach($veh_id);

        return response()->json([
            'message' => 'ย้ายรถไปยังหน่วยบริการใหม่เรียบร้อยแล้ว',
            'data' => [
                'old_serv_id' => $serv_id,
                'new_serv_id' => $request->new_serv_id,
                'rcc_emer_veh_id' => $veh_id,
            ]
        ], 200);
    }

    public function destroy($serv_id, $veh_id): JsonResponse
    {
        $unit = ServiceUnit::find($serv_id);
        if (! $unit) return response()->json(['message' => 'หน่วยบริการไม่พบ'], 404);

        if (! $unit->vehicles()->wherePivot('rcc_emer_veh_id', $veh_id)->exists()) {
            return response()->json(['message' => 'รถคันนี้ไม่ถูกผูกกับหน่วยบริการ'], 404);
        }

        $unit->vehicles()->detach($veh_id);

        return response()->json([
            'message' => 'ลบการผูกรถเรียบร้อยแล้ว',
            'data' => [
                'rcc_serv_id' => $serv_id,
                'rcc_emer_veh_id' => $veh_id
            ]
        ], 200);
    }
}
