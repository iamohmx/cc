<?php

namespace App\Http\Controllers;

use App\Models\Mission;
use App\Models\MissionCancellation;
use App\Models\CancelImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MissionController extends Controller
{
    /**
     * GET /api/missions
     * คืนค่า paginated list ของ mission พร้อม cancellations & images
     */
    public function index(Request $request)
    {
        // จำนวนต่อหน้า (default 15)
        $perPage = $request->query('per_page', 15);

        $missions = Mission::with(['cancellations.images'])
            ->orderBy('fst_command_time', 'desc')
            ->paginate($perPage);

        return response()->json($missions, 200);
    }

    /**
     * GET /api/missions/{mission}
     * คืนค่า mission 1 record พร้อม details
     */
    public function show(Mission $mission)
    {
        $mission->load(['cancellations.images']);
        return response()->json($mission, 200);
    }

    /**
     * POST /api/missions
     * รับภารกิจใหม่ (บันทึกครบทุกฟิลด์)
     */
    public function accept(Request $r)
    {
        $data = $r->validate([
            'vehicle_id'         => 'required|exists:rcc_emergency_vehicles,rcc_emer_veh_id',
            'incident_id'        => 'required|exists:hn_incidents,hn_incident_id',
            'hospital_id'        => 'required|exists:fast_track_hospitals,fst_hosp_id',
            'receive_time'       => 'required|date',
            'receive_mileage'    => 'required|integer',
            'incident_time'      => 'required|date',
            'incident_mileage'   => 'required|integer',
            'hospital_time'      => 'required|date',
            'hospital_mileage'   => 'required|integer',
        ]);

        $mission = Mission::create([
            'rcc_emer_veh_id'        => $data['vehicle_id'],
            'hn_incident_id'         => $data['incident_id'],
            'fst_hosp_id'            => $data['hospital_id'],
            'fst_command_time'       => now(),
            'fst_receive_time'       => $data['receive_time'],
            'fst_receive_mileage'    => $data['receive_mileage'],
            'fst_incident_time'      => $data['incident_time'],
            'fst_incident_mileage'   => $data['incident_mileage'],
            'fst_hospital_time'      => $data['hospital_time'],
            'fst_hospital_mileage'   => $data['hospital_mileage'],
            'fst_status'             => 1,
        ]);

        return response()->json($mission, 201);
    }

    /**
     * POST /api/missions/{mission}/cancel
     * ยกเลิกภารกิจ (พร้อมอัพโหลดรูปหลายไฟล์)
     */
    public function cancel(Request $r, Mission $mission)
    {
        $data = $r->validate([
            'reason'   => 'required|string',
            'images'   => 'nullable|array',
            'images.*' => 'image|max:2048',
        ]);

        DB::transaction(function() use ($mission, $data) {
            // สร้าง record ยกเลิก
            $cancel = MissionCancellation::create([
                'fst_mis_log_id'   => $mission->fst_mis_log_id,
                'fst_cancel_reason'=> $data['reason'],
            ]);

            // เก็บภาพยกเลิกแต่ละไฟล์
            if (! empty($data['images'])) {
                foreach ($data['images'] as $file) {
                    $path = $file->store('missions', 'public');
                    CancelImage::create([
                        'fst_mis_log_id'     => $mission->fst_mis_log_id,
                        'fst_cancel_img_path'=> $path,
                    ]);
                }
            }

            // อัปเดตสถานะ mission
            $mission->update(['fst_status' => 0]);
        });

        return response()->json(['message' => 'Mission cancelled'], 200);
    }
}
