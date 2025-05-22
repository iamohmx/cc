<?php
namespace App\Http\Controllers;

use App\Http\Requests\ReportIncidentRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\HnPersonalInfo;
use App\Models\HnUser;
use App\Models\HnReporter;
use App\Models\HnIncident;
use App\Models\HnImage;
use App\Models\HnIncidentReporter;
use Illuminate\Http\JsonResponse;

class IncidentReportController extends Controller
{
    /**
     * POST /api/report-incident
     */
    public function report(ReportIncidentRequest $request): JsonResponse
    {
        $data = $request->validated();

        // ตรวจเบอร์ซ้ำ
        if (HnUser::where('hn_telNo', $data['phone'])->exists()) {
            return response()->json([
                'status'  => false,
                'message' => 'เบอร์โทรนี้เคยลงทะเบียนแล้ว กรุณาเข้าสู่ระบบเพื่อแจ้งเหตุใหม่',
            ], 409);
        }

        // สร้างข้อมูลทั้งหมดใน transaction
        $result = DB::transaction(function() use ($data) {
            $personal = HnPersonalInfo::create([
                'hn_firstName'  => $data['first_name'],
                'hn_lastName'   => $data['last_name'],
                'hn_gender'     => 'Male',
                'hn_bloodGroup' => 'O',
                'hn_address'    => $data['location_link'],
            ]);

            $user = HnUser::create([
                'hn_telNo'    => $data['phone'],
                'hn_password' => Hash::make($data['phone']),
                'hn_infoId'   => $personal->hn_infoId,
            ]);

            $reporter = HnReporter::create([
                'hn_firstName' => $data['first_name'],
                'hn_lastName'  => $data['last_name'],
                'hn_telNo'     => $data['phone'],
            ]);

            $incident = HnIncident::create([
                'hn_caseNo'                => HnIncident::generateCaseNo(),
                'hn_note'                  => $data['note'],
                'hn_location_link'         => $data['location_link'],
                'hn_Ispatient_conscious'   => $data['conscious'],
                'hn_Ispatient_breathing'   => $data['breathing'],
                'hn_num_victims'           => $data['victims'],
                'hn_symptoms'              => $data['symptoms'],
                'hn_status'                => $data['status'],
                'hn_source'                => $data['source'],
            ]);

            // อัพโหลดรูปภาพและผูกกับ incident
            if (! empty($data['images'])) {
                foreach ($data['images'] as $file) {
                    $path = $file->store('incident_images','public');
                    $img  = HnImage::create(['hn_img_path' => $path]);
                    $incident->images()->attach($img->hn_img_id, [
                        'hn_created_at' => now(),
                        'hn_updated_at' => now(),
                    ]);
                }
            }

            HnIncidentReporter::create([
                'hn_incident_id' => $incident->hn_incident_id,
                'hn_user_id'     => $user->hn_user_id,
                'hn_reporter_id' => $reporter->hn_reporter_id,
                'hn_reported_at' => now(),
            ]);

            return [
                'user_id'     => $user->hn_user_id,
                'reporter_id' => $reporter->hn_reporter_id,
                'incident_id' => $incident->hn_incident_id,
                // ส่ง URL รูปกลับด้วย
                'images'      => $incident->images->map(fn($i)=> Storage::url($i->hn_img_path)),
            ];
        });

        return response()->json([
            'status'  => true,
            'message' => 'Report created successfully.',
            'data'    => $result,
        ], 201);
    }
}
