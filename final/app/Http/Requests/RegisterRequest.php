<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true; // ถ้าต้องมีเงื่อนไขอนุญาตให้ใครสมัคร ให้ปรับตรงนี้
    }

    public function rules()
    {
        return [
            'username'              => [
                'required',
                'string',
                'alpha_dash',
                'min:3',
                'max:30',
                'unique:rcc_users,rcc_username'
            ],
            'email'                 => [
                'required',
                'string',
                'email:rfc,dns',
                'max:255',
                'unique:rcc_users,rcc_email'
            ],
            'password'              => [
                'required',
                'string',
                'min:8',
                'confirmed'             // ต้องมี password_confirmation
            ],
            'password_confirmation' => [
                'required',
                'string'
            ],
        ];
    }

    public function messages()
    {
        return [
            'username.required'     => 'กรุณาระบุชื่อผู้ใช้',
            'username.alpha_dash'   => 'ชื่อผู้ใช้ต้องเป็นตัวอักษร ตัวเลข หรือ _- เท่านั้น',
            'email.email'           => 'รูปแบบอีเมลไม่ถูกต้อง',
            'password.confirmed'    => 'การยืนยันรหัสผ่านไม่ตรงกัน',
            'password.min'          => 'รหัสผ่านต้องไม่น้อยกว่า 8 ตัวอักษร',
        ];
    }
}
