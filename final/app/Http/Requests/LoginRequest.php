<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use App\Models\RccUser;
use Illuminate\Support\Facades\Hash;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'usernameOrEmail'    => ['required','string'],    // จะเป็น username หรือ email
            'password' => ['required','string'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function($validator) {
            $login    = $this->input('usernameOrEmail');
            $password = $this->input('password');

            $user = RccUser::where('rcc_username', $login)
                           ->orWhere('rcc_email', $login)
                           ->first();

            if (! $user || ! Hash::check($password, $user->rcc_password)) {
                $validator->errors()->add('usernameOrEmail', 'ชื่อผู้ใช้/อีเมล หรือ รหัสผ่านไม่ถูกต้อง');
            }
        });
    }

    public function messages()
    {
        return [
            'usernameOrEmail.required'    => 'กรุณาระบุชื่อผู้ใช้หรืออีเมล',
            'password.required' => 'กรุณาระบุรหัสผ่าน',
        ];
    }
}
