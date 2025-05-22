<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\HnIncident;
use App\Models\HnImage;
use App\Models\HnIncidentImage;

class IncidentController extends Controller
{
    // GET /api/incidents
    public function index()
    {
        $incidents = HnIncident::with('images')->get()->map(function($inc) {
            return [
                'id'        => $inc->hn_incident_id,
                'caseNo'    => $inc->hn_caseNo,
                'note'      => $inc->hn_note,
                'location'  => $inc->hn_location_link,
                'status'    => $inc->hn_status,
                'created_at'=> $inc->hn_created_at,
                'images'    => $inc->images->map(fn($img)=> Storage::url($img->hn_img_path)),
            ];
        });

        return response()->json(['data'=>$incidents], 200);
    }

    // GET /api/incidents/{incident}
    public function show(HnIncident $incident)
    {
        try {
            // If using route model binding, the incident exists or 404 is thrown
            $incident->load('images');
            return response()->json([
            'data'=>[
                'id'        => $incident->hn_incident_id,
                'caseNo'    => $incident->hn_caseNo,
                'note'      => $incident->hn_note,
                'location'  => $incident->hn_location_link,
                'status'    => $incident->hn_status,
                'created_at'=> $incident->hn_created_at,
                'images'    => $incident->images->map(fn($img)=> Storage::url($img->hn_img_path)),
            ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Incident not found'], 404);
        }
    }

    // POST /api/incidents
    public function store(Request $request)
    {
        $data = $request->validate([
            'note'            => 'required|string',
            'location_link'   => 'required|url',
            // 'address'       => 'required|string',
            'conscious'       => 'required|in:1,2,3',
            'breathing'       => 'required|boolean',
            'victims'         => 'required|integer|min:1',
            'symptoms'        => 'required|string',
            'status'          => 'required|in:1,2,3',
            'source'          => 'required|in:1,2',
            'images'          => 'nullable|array',
            'images.*'        => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $incident = HnIncident::create([
                'hn_caseNo'                => HnIncident::generateCaseNo(),
                'hn_note'                  => $data['note'],
                'hn_location_link'         => $data['location_link'],
                // 'hn_address'               => $data['address'],
                'hn_Ispatient_conscious'   => $data['conscious'],
                'hn_Ispatient_breathing'   => $data['breathing'],
                'hn_num_victims'           => $data['victims'],
                'hn_symptoms'              => $data['symptoms'],
                'hn_status'                => $data['status'],
                'hn_source'                => $data['source'],
            ]);

            if (!empty($data['images'])) {
                foreach ($data['images'] as $file) {
                    $path = $file->store('incident_images','public');
                    $img  = HnImage::create(['hn_img_path'=>$path]);
                    HnIncidentImage::create([
                        'hn_incident_id'=> $incident->hn_incident_id,
                        'hn_img_id'     => $img->hn_img_id,
                    ]);
                }
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'message'=>'Error saving incident',
                'error'=>$e->getMessage(),
            ], 500);
        }

        return $this->show($incident);
    }

    // PUT /api/incidents/{incident}
    public function update(Request $request, HnIncident $incident)
    {
        $data = $request->validate([
            'note'          => 'sometimes|string',
            'location_link' => 'sometimes|url',
            'status'        => 'sometimes|in:1,2,3',
            'images'        => 'nullable|array',
            'images.*'      => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $incident->update([
                'hn_note'          => $data['note'] ?? $incident->hn_note,
                'hn_location_link' => $data['location_link'] ?? $incident->hn_location_link,
                'hn_status'        => $data['status'] ?? $incident->hn_status,
            ]);

            if (!empty($data['images'])) {
                foreach ($data['images'] as $file) {
                    $path = $file->store('incident_images','public');
                    $img  = HnImage::create(['hn_img_path'=>$path]);
                    HnIncidentImage::create([
                        'hn_incident_id'=> $incident->hn_incident_id,
                        'hn_img_id'     => $img->hn_img_id,
                    ]);
                }
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'message'=>'Error updating incident',
                'error'=>$e->getMessage(),
            ], 500);
        }

        return $this->show($incident);
    }

    // DELETE /api/incidents/{incident}
    public function destroy(HnIncident $incident)
    {
        // ลบไฟล์ใน storage ด้วย (ถ้าต้องการ)
        foreach ($incident->images as $img) {
            Storage::disk('public')->delete($img->hn_img_path);
        }

        $incident->images()->detach();
        $incident->delete();

        return response()->json(['message'=>'Incident deleted'], 200);
    }
}
