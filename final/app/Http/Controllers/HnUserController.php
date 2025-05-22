<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\HnUser;

class HnUserController extends Controller
{
    /**
     * GET /api/user/profile
     */
    public function profile(Request $request)
    {
        $user = $request->user()->load('personalInfo');

        return response()->json([
            'data' => [
                'user' => [
                    'id'       => $user->hn_user_id,
                    'phone'    => $user->hn_telNo,
                    'info_id'  => $user->hn_infoId,
                    'created'  => $user->hn_created_at,
                    'updated'  => $user->hn_updated_at,
                ],
                'personal_info' => [
                    'first_name' => $user->personalInfo->hn_firstName,
                    'last_name'  => $user->personalInfo->hn_lastName,
                    'gender'     => $user->personalInfo->hn_gender,
                    'blood'      => $user->personalInfo->hn_bloodGroup,
                    'address'    => $user->personalInfo->hn_address,
                ],
            ]
        ], 200);
    }

    /**
     * PUT /api/user/profile
     *
     * รับ JSON:
     * {
     *   "phone": "08xxxxxxx",
     *   "password": "newpass",           // (optional)
     *   "first_name": "ใหม่",
     *   "last_name": "สกุลใหม่",
     *   "gender": "Female",              // Male|Female
     *   "bloodGroup": "AB",              // A|B|AB|O
     *   "address": "ที่อยู่ใหม่"
     * }
     */
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'phone'       => 'required|string|max:10|unique:hn_users,hn_telNo,' . $user->hn_user_id . ',hn_user_id',
            'password'    => 'nullable|string|min:6',
            'first_name'  => 'required|string|max:50',
            'last_name'   => 'required|string|max:50',
            'gender'      => 'required|in:Male,Female',
            'bloodGroup'  => 'required|in:A,B,AB,O',
            'address'     => 'required|string',
        ]);

        // อัปเดตภายใน transaction
        \DB::transaction(function() use ($user, $data) {
            // 1) อัปเดต hn_users
            $user->hn_telNo = $data['phone'];
            if (! empty($data['password'])) {
                $user->hn_password = Hash::make($data['password']);
            }
            $user->save();

            // 2) อัปเดต hn_personal_info
            $pi = $user->personalInfo;
            $pi->hn_firstName  = $data['first_name'];
            $pi->hn_lastName   = $data['last_name'];
            $pi->hn_gender     = $data['gender'];
            $pi->hn_bloodGroup = $data['bloodGroup'];
            $pi->hn_address    = $data['address'];
            $pi->save();
        });

        // โหลดข้อมูลใหม่มาแสดง
        $user = $user->fresh()->load('personalInfo');

        return response()->json([
            'message' => 'Profile updated',
            'data'    => [
                'user' => [
                    'id'      => $user->hn_user_id,
                    'phone'   => $user->hn_telNo,
                    'updated' => $user->hn_updated_at,
                ],
                'personal_info' => [
                    'first_name' => $user->personalInfo->hn_firstName,
                    'last_name'  => $user->personalInfo->hn_lastName,
                    'gender'     => $user->personalInfo->hn_gender,
                    'blood'      => $user->personalInfo->hn_bloodGroup,
                    'address'    => $user->personalInfo->hn_address,
                ],
            ]
        ], 200);
    }
}
