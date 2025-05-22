<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\RccUser;

class RccUserController extends Controller
{
    // GET /api/users
    public function index()
    {
        // ดึง user พร้อม relation role
        $users = RccUser::with('role')->get();

        // แปลงผลลัพธ์ให้แสดง role name แทน role_id
        return response()->json([
            'data' => $users->map(function($u) {
                return [
                    'id'       => $u->rcc_user_id,
                    'username' => $u->rcc_username,
                    'email'    => $u->rcc_email,
                    'role'     => $u->role->rcc_role_name,  // ชื่อ role
                    'created'  => $u->rcc_created_at,
                    'updated'  => $u->rcc_updated_at,
                ];
            })
        ]);
    }

    // GET /api/users/{id}
    public function show(RccUser $user)
    {
        $user->load('role');
        return response()->json([
            'data' => [
                'id'       => $user->rcc_user_id,
                'username' => $user->rcc_username,
                'email'    => $user->rcc_email,
                'role'     => $user->role->rcc_role_name,
                'created'  => $user->rcc_created_at,
                'updated'  => $user->rcc_updated_at,
            ]
        ]);
    }

    // POST /api/users
    public function store(Request $r)
    {
        $data = $r->validate([
            'rcc_username' => 'required|string|unique:rcc_users,rcc_username',
            'rcc_email'    => 'required|email|unique:rcc_users,rcc_email',
            'rcc_password' => 'required|string|min:6',
            'rcc_role_id'  => 'required|exists:rcc_roles,rcc_role_id',
        ]);
        $data['rcc_password'] = Hash::make($data['rcc_password']);
        $user = RccUser::create($data);

        // โหลด role และตอบกลับเป็นชื่อ
        $user->load('role');
        return response()->json([
            'data' => [
                'id'       => $user->rcc_user_id,
                'username' => $user->rcc_username,
                'email'    => $user->rcc_email,
                'role'     => $user->role->rcc_role_name,
            ]
        ], 201);
    }

    // PUT /api/users/{id}
    public function update(Request $r, RccUser $user)
    {
        $data = $r->validate([
            'rcc_username' => 'required|string|unique:rcc_users,rcc_username,' . $user->rcc_user_id . ',rcc_user_id',
            'rcc_email'    => 'required|email|unique:rcc_users,rcc_email,'    . $user->rcc_user_id . ',rcc_user_id',
            'rcc_password' => 'nullable|string|min:6',
            'rcc_role_id'  => 'required|exists:rcc_roles,rcc_role_id',
        ]);

        if (! empty($data['rcc_password'])) {
            $data['rcc_password'] = Hash::make($data['rcc_password']);
        } else {
            unset($data['rcc_password']);
        }

        $user->update($data);
        $user->load('role');

        return response()->json([
            'data' => [
                'id'       => $user->rcc_user_id,
                'username' => $user->rcc_username,
                'email'    => $user->rcc_email,
                'role'     => $user->role->rcc_role_name,
                'updated'  => $user->rcc_updated_at,
            ]
        ]);
    }

    // DELETE /api/users/{id}
    public function destroy(RccUser $user)
    {
        $user->delete();
        return response()->json(null, 204);
    }
}
