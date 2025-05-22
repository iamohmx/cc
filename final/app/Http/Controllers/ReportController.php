<?php

namespace App\Http\Controllers;

use App\Models\HnIncident;
use App\Models\FastTrackMissionLog;
use App\Models\RccEmergencyVehicle;
use App\Models\FastTrackUser;
use App\Models\Mission;
use App\Models\Vehicle;
use Illuminate\Http\JsonResponse;

class ReportController extends Controller
{
    /**
     * GET /api/reports/summary
     */
    public function summary(): JsonResponse
    {
        // INCIDENTS
        $totalIncidents = HnIncident::count();
        $callIncidents  = HnIncident::where('hn_source', '1')->count();
        $appIncidents   = HnIncident::where('hn_source', '2')->count();

        // MISSIONS
        $missionsTotal     = Mission::count();
        $missionsPending   = Mission::where('fst_status', 0)->count(); // รอดำเนินการ
        $missionsCompleted = Mission::where('fst_status', 1)->count(); // เสร็จภารกิจ
        // สมมติ ongoing = ทั้งหมด - pending - completed
        $missionsOngoing   = $missionsTotal - $missionsPending - $missionsCompleted;

        // VEHICLES
        $totalVehicles     = Vehicle::count();
        // รถที่กำลังปฏิบัติงาน — นับ distinct vehicle ที่ปรากฏใน mission logs
        $inOperation       = Mission::distinct('rcc_emer_veh_id')
                                              ->count('rcc_emer_veh_id');
        $availableVehicles = $totalVehicles - $inOperation;

        // FAST-TRACK APP USERS
        $totalUsers    = FastTrackUser::count();
        $readyUsers    = FastTrackUser::where('fst_status', 1)->count();
        $notReadyUsers = FastTrackUser::where('fst_status', 0)->count();

        return response()->json([
            'incidents' => [
                'total' => $totalIncidents,
                'call'  => $callIncidents,
                'app'   => $appIncidents,
            ],
            'missions' => [
                'pending'   => $missionsPending,
                'ongoing'   => $missionsOngoing,
                'completed'=> $missionsCompleted,
            ],
            'vehicles' => [
                'total'         => $totalVehicles,
                'in_operation'  => $inOperation,
                'available'     => $availableVehicles,
            ],
            'users' => [
                'total'     => $totalUsers,
                'ready'     => $readyUsers,
                'not_ready' => $notReadyUsers,
            ],
        ]);
    }
}
