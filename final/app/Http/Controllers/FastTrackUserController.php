<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFastTrackUserRequest;
use App\Http\Requests\UpdateFastTrackUserRequest;
use App\Models\FastTrackUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;

class FastTrackUserController extends Controller
{
    // GET /api/fast-track-users
    public function index()
    {
        return response()->json([
            'success' => true,
            'data'    => FastTrackUser::with(['rcc_roles','serviceUnit'])->get(),
        ]);
    }

    // POST /api/fast-track-users
    public function store(StoreFastTrackUserRequest $request)
    {
        try {
            $data = $request->validated();

            // อัปโหลดรูปถ้ามี
            if ($request->hasFile('profile_img')) {
                $path = $request->file('profile_img')->store('profiles','public');
                $data['profile_img_path'] = Storage::url($path);
            }

            $user = FastTrackUser::create($data);

            return response()->json([
                'success' => true,
                'data'    => $user,
            ], 201);

        } catch (QueryException $e) {
            // กรณี duplicate หรือข้อผิดพลาด DB อื่นๆ
            return response()->json([
                'success' => false,
                'message' => 'Database error: '.$e->getMessage(),
            ], 500);
        }
    }

    // GET /api/fast-track-users/{id}
    public function show(FastTrackUser $fastTrackUser)
    {
        return response()->json([
            'success' => true,
            'data'    => $fastTrackUser->load(['rcc_roles','serviceUnit']),
        ]);
    }

    // PUT/PATCH /api/fast-track-users/{id}
    public function update(UpdateFastTrackUserRequest $request, FastTrackUser $fastTrackUser)
    {
        try {
            $data = $request->validated();

            // ถ้าไม่มีรหัสผ่านใหม่ ให้ตัดออก
            if (! $request->filled('fst_password')) {
                unset($data['fst_password']);
            }

            // อัปโหลดรูปใหม่ ถ้ามี
            if ($request->hasFile('profile_img')) {
                if (! str_contains($fastTrackUser->profile_img_path, 'dummyimage.com')) {
                    $old = ltrim(parse_url($fastTrackUser->profile_img_path, PHP_URL_PATH), '/storage/');
                    Storage::disk('public')->delete($old);
                }
                $path = $request->file('profile_img')->store('profiles','public');
                $data['profile_img_path'] = Storage::url($path);
            }

            $fastTrackUser->update($data);

            return response()->json([
                'success' => true,
                'data'    => $fastTrackUser,
            ]);

        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Database error: '.$e->getMessage(),
            ], 500);
        }
    }

    // DELETE /api/fast-track-users/{id}
    public function destroy(FastTrackUser $fastTrackUser)
    {
        try {
            if (! str_contains($fastTrackUser->profile_img_path, 'dummyimage.com')) {
                $old = ltrim(parse_url($fastTrackUser->profile_img_path, PHP_URL_PATH), '/storage/');
                Storage::disk('public')->delete($old);
            }

            $fastTrackUser->delete();

            return response()->json([
                'success' => true,
                'message' => 'Deleted successfully',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: '.$e->getMessage(),
            ], 500);
        }
    }
}
