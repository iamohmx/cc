<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFastTrackUserRequest;
use App\Models\FastTrackUser;
use App\Models\HnUser;
use App\Models\RccUser;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException as ValidationValidationException;

class AuthController extends Controller
{
    // Auth Controller
    // public function login(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'userOrEmail' => 'required|string', // login = email or username
    //         'password' => 'required|string|min:8',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => $validator->errors()->first(),
    //         ], 401);
    //     }

    //     $loginInput = $request->input('userOrEmail');
    //     $user = User::where('email', $loginInput)
    //         ->orWhere('username', $loginInput)
    //         ->first();

    //     if (!$user || !Hash::check($request->password, $user->password)) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Invalid credentials',
    //         ], 401);
    //     }

    //     $token = $user->createToken('auth_token')->plainTextToken;

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Login successful',
    //         'user' => [
    //             'id' => $user->id,
    //             'username' => $user->username,
    //             'email' => $user->email,
    //             'role' => $user->role->name,
    //         ],
    //         'access_token' => $token,
    //     ]);
    // }

    // 1. Register
    /**
     * POST /api/register
     * (Admin only)
     */
    public function register(Request $request)
    {
        // 0. ต้องล็อกอินและเป็น Admin เท่านั้น
        $auth = $request->user();
        if (! $auth || $auth->rcc_role_id !== 1) {
            return response()->json([
                'message' => 'Only administrators can register new users'
            ], 403);
        }

        // 1. Validate input
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|alpha_dash|min:3|max:30|unique:rcc_users,rcc_username',
            'email'    => 'required|email:rfc,dns|max:255|unique:rcc_users,rcc_email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation errors',
                'errors'  => $validator->errors(),
            ], 422);
        }

        // 2. Create user (default role = 2)
        try {
            $user = RccUser::create([
                'rcc_username' => $request->username,
                'rcc_email'    => $request->email,
                'rcc_password' => Hash::make($request->password),
                'rcc_role_id'  => 2,
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'User already exists',
            ], 409);
        }

        // 3. Return success
        return response()->json([
            'message' => 'Registered successfully',
            'data'    => ['user_id' => $user->rcc_user_id],
        ], 201);
    }

    /**
     * POST /api/login
     */
    public function login(Request $request)
    {
        // 1. Validate
        $validator = Validator::make($request->all(), [
            'usernameOrEmail' => 'required|string',
            'password'        => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation errors',
                'errors'  => $validator->errors(),
            ], 422);
        }

        // 2. หา user
        $user = RccUser::where('rcc_username', $request->usernameOrEmail)
            ->orWhere('rcc_email', $request->usernameOrEmail)
            ->first();

        if (! $user) {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }

        // 3. ตรวจสอบรหัสผ่าน
        if (! Hash::check($request->password, $user->rcc_password)) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }

        // 4. สร้าง token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'data'    => [
                'user_id' => $user->rcc_user_id,
                'token'   => $token,
            ],
        ], 200);
    }
    // 3. Logout
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out'], 200);
    }

    public function forgot(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:rcc_users,rcc_email'
        ]);

        // <-- วางตรงนี้ แทน sendResetLink เดิม
        $status = Password::broker('rcc_users')
            ->sendResetLink(['rcc_email' => $request->email]);

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['message' => __($status)], 200)
            : response()->json(['message' => __($status)], 400);
    }

    /**
     * รีเซ็ตรหัสผ่าน
     */
    public function reset(Request $request)
    {
        $request->validate([
            'email'                 => 'required|email|exists:rcc_users,rcc_email',
            'token'                 => 'required|string',
            'password'              => 'required|string|min:6|confirmed',
        ]);

        // แม็ป key ให้ตรงกับคอลัมน์
        $credentials = [
            'rcc_email'                 => $request->email,
            'password'                  => $request->password,
            'password_confirmation'     => $request->password_confirmation,
            'token'                     => $request->token,
        ];

        $status = Password::broker('rcc_users')->reset(
            $credentials,
            function ($user, $password) {
                // ปรับให้เขียนลงคอลัมน์ rcc_password
                $user->rcc_password = bcrypt($password);
                $user->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return response()->json(['message' => __($status)], 200);
        }

        return response()->json(['message' => __($status)], 400);
    }

    public function getUser(Request $request)
    {
        // โหลด relation role ด้วยเลย
        $user = $request->user()->load('role');

        return response()->json([
            'status'  => true,
            'message' => 'User retrieved successfully',
            'user'    => [
                'id'         => $user->rcc_user_id,
                'username'   => $user->rcc_username,
                'email'      => $user->rcc_email,
                'role'       => $user->role->rcc_role_name,
                'created_at' => $user->rcc_created_at,
                'updated_at' => $user->rcc_updated_at,
            ],
        ], 200);
    }


    public function forgotPassword(Request $request)
    {
        // Handle password reset logic
        return response()->json(['message' => 'Password reset link sent']);
    }

    public function resetPassword(Request $request)
    {
        // Handle password reset logic
        return response()->json(['message' => 'Password reset successful']);
    }

    public function verifyEmail(Request $request)
    {
        // Handle email verification logic
        return response()->json(['message' => 'Email verified successfully']);
    }


    // -------------------------hn_users-------------------------


    public function hn_login(Request $request)
    {
        $credentials = $request->validate([
            'phone'    => 'required|string|max:10',
            'password' => 'required|string',
        ]);

        $user = HnUser::where('hn_telNo', $credentials['phone'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->hn_password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // สร้าง token แบบ stateless
        $token = $user->createToken(Str::random(16))->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'data'    => [
                'user_id' => $user->hn_user_id,
                'token'   => $token,
            ],
        ], 200);
    }

    public function hn_logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out'], 200);
    }



    public function fst_register(StoreFastTrackUserRequest $request)
    {
        $data = $request->validated();

        // ถ้ามีไฟล์รูปโปรไฟล์ ให้เซฟลง storage/public/profiles
        if ($request->hasFile('profile_img')) {
            $path = $request->file('profile_img')->store('profiles', 'public');
            $data['profile_img_path'] = Storage::url($path);
        }

        // สร้าง user ใหม่ (รหัสผ่านจะถูก bcrypt อัตโนมัติใน Model)
        $user = FastTrackUser::create($data);

        // สร้าง token ให้ทันที
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'user'         => $user,
            'access_token' => $token,
            'token_type'   => 'Bearer',
        ], 201);
    }


    // POST /api/login
    public function fst_login(Request $req)
    {
        $req->validate([
            'fst_username' => 'required|string',
            'fst_password' => 'required|string',
        ]);

        $user = FastTrackUser::where('fst_username', $req->fst_username)->first();

        if (! $user || ! Hash::check($req->fst_password, $user->fst_password)) {
            throw ValidationValidationException::withMessages([
                'fst_username' => ['ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง'],
            ]);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type'   => 'Bearer',
        ]);
    }

    // POST /api/logout
    public function fst_logout(Request $req)
    {
        $req->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out']);
    }
}
