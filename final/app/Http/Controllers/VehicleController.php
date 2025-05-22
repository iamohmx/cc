<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    public function index() { return Vehicle::with('type')->get(); }

    public function store(Request $r)
    {
        try {
            $r->validate([
               'rcc_veh_type_id' => 'required|exists:rcc_vehicle_types,rcc_veh_type_id',
               'rcc_plate_prefix'=>'required',
               'rcc_plate_number'=>'required',
               'rcc_province'=>'required',
               'rcc_standard_number'=>'required',
               'rcc_license_expiry_date'=>'required|date',
               'rcc_start_year'=>'required|date',
               'pdf'=>'nullable|mimes:pdf|max:61440',
            ]);

            $data = $r->except('pdf');
            if($r->hasFile('pdf')){
                $data['rcc_pdfFilePath'] = $r->file('pdf')->store('pdfs','public');
            }
            $veh = Vehicle::create($data);
            return response()->json($veh->load('type'), 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function show(Vehicle $vehicle)
    {
        return $vehicle->load('type');
    }

    public function update(Request $r, Vehicle $vehicle)
    {
        try {
            $r->validate([
                'rcc_veh_type_id' => 'sometimes|exists:rcc_vehicle_types,rcc_veh_type_id',
                'rcc_plate_prefix'=>'sometimes',
                'rcc_plate_number'=>'sometimes',
                'rcc_province'=>'sometimes',
                'rcc_standard_number'=>'sometimes',
                'rcc_license_expiry_date'=>'sometimes|date',
                'rcc_start_year'=>'sometimes|date',
                'pdf'=>'nullable|mimes:pdf|max:61440',
            ]);

            $data = $r->except('pdf');
            if($r->hasFile('pdf')){
                Storage::disk('public')->delete($vehicle->rcc_pdfFilePath);
                $data['rcc_pdfFilePath'] = $r->file('pdf')->store('pdfs','public');
            }
            $vehicle->update($data);
            return $vehicle->load('type');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update vehicle.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Vehicle $vehicle)
    {
        try {
            Storage::disk('public')->delete($vehicle->rcc_pdfFilePath);
            $vehicle->delete();
            return response()->noContent();
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete vehicle.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // อัพโหลดรูปเพิ่มเติม
    public function uploadImage(Request $r, Vehicle $vehicle)
    {
        try {
            $r->validate(['image'=>'required|image|max:2048']);
            $path = $r->file('image')->store('vehicles','public');
            $img  = \App\Models\RccVehicleImage::create([
                'rcc_emer_veh_img_id'=>$vehicle->rcc_emer_veh_id,
                'rcc_img_path'=>$path
            ]);
            return response()->json($img, 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to upload image.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
