<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceUnitRequest;
use App\Models\ServiceUnit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceUnitController extends Controller
{
     // ดูรายการทั้งหมด
    public function index(): JsonResponse
    {
        $units = ServiceUnit::with('areas')->get();
        return response()->json(['data' => $units], 200);
    }

    // ดูรายละเอียดหน่วยบริการตัวเดียว
    public function show(ServiceUnit $serviceUnit): JsonResponse
    {
        $unit = $serviceUnit->load('areas');
        return response()->json(['data' => $unit], 200);
    }

    // แก้ไข (ใช้ Request เดิม)
    public function update(StoreServiceUnitRequest $request, ServiceUnit $serviceUnit): JsonResponse
    {
        try {
           $data = $request->validated();
           if ($request->hasFile('rcc_serv_img_path')) {
              Storage::disk('public')->delete($serviceUnit->rcc_serv_img_path);
              $data['rcc_serv_img_path'] = $request->file('rcc_serv_img_path')->store('units','public');
           }
           $serviceUnit->update($data);
           if (isset($data['rcc_area_id'])) {
              $serviceUnit->areas()->sync($data['rcc_area_id']);
           }
           return response()->json([
              'message' => 'แก้ไขหน่วยบริการเรียบร้อย',
              'data'    => $serviceUnit->load('areas')
           ], 200);
        } catch (\Exception $e) {
           return response()->json(['error' => 'เกิดข้อผิดพลาดในการอัปเดต', 'message' => $e->getMessage()], 500);
        }
    }

    // ลบ
    public function destroy(ServiceUnit $serviceUnit): JsonResponse
    {
        try {
           // ลบรูป ถ้ามี
           Storage::disk('public')->delete($serviceUnit->rcc_serv_img_path);
           // ถอด pivot
           $serviceUnit->areas()->detach();
           // ลบ record
           $serviceUnit->delete();
           return response()->json(null, 204);
        } catch (\Exception $e) {
           return response()->json(['error' => 'เกิดข้อผิดพลาดในการลบ', 'message' => $e->getMessage()], 500);
        }
    }

    public function store(StoreServiceUnitRequest $request): JsonResponse
    {
        try {
           $data = $request->validated();

           if ($request->hasFile('rcc_serv_img_path')) {
              $data['rcc_serv_img_path'] = $request->file('rcc_serv_img_path')
                                         ->store('units','public');
           }

           $unit = ServiceUnit::create($data);

           // ใช้ sync() แทน attach()
           $unit->areas()->sync([$data['rcc_area_id']]);

           // โหลด relation ทันที
           $unit = $unit->load('areas');

           return response()->json([
              'message' => 'สร้างหน่วยบริการและผูกกับพื้นที่เรียบร้อยแล้ว',
              'data'    => $unit,
           ], 201);
        } catch (\Exception $e) {
           return response()->json(['error' => 'เกิดข้อผิดพลาดในการบันทึก', 'message' => $e->getMessage()], 500);
        }
    }

}
