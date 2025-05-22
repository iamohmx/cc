<?php
// app/Http/Controllers/ServiceAreaController.php
namespace App\Http\Controllers;

use App\Http\Requests\AreaRequest;
use App\Models\ServiceArea;
use Illuminate\Http\JsonResponse;

class ServiceAreaController extends Controller
{
    /** GET /api/areas */
    public function index(): JsonResponse
    {
        $areas = ServiceArea::all();
        return response()->json(['data' => $areas], 200);
    }

    /** POST /api/areas */
    public function store(AreaRequest $request): JsonResponse
    {
        $area = ServiceArea::create($request->validated());
        return response()->json([
            'message' => 'สร้างพื้นที่เรียบร้อยแล้ว',
            'data'    => $area
        ], 201);
    }

    /** GET /api/areas/{area} */
    public function show(ServiceArea $area): JsonResponse
    {
        return response()->json(['data' => $area], 200);
    }

    /** PUT /api/areas/{area} */
    public function update(AreaRequest $request, ServiceArea $area): JsonResponse
    {
        $area->update($request->validated());
        return response()->json([
            'message' => 'แก้ไขพื้นที่เรียบร้อยแล้ว',
            'data'    => $area
        ], 200);
    }

    /** DELETE /api/areas/{area} */
    public function destroy(ServiceArea $area): JsonResponse
    {
        $area->delete();
        return response()->json(null, 204);
    }
}
