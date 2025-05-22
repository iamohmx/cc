<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreServiceUnitRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'rcc_serv_name'        => 'required|string|max:100',
            'rcc_location'         => 'required|string',
            'rcc_established_date' => 'required|date',
            'rcc_contact_name'     => 'required|string|max:100',
            'rcc_contact_tel'      => 'required|digits:10',
            'rcc_serv_img_path'    => 'nullable|image|max:2048',
            'rcc_area_id'          => 'required|exists:rcc_service_area,rcc_area_id',
        ];
    }

    public function messages()
    {
        return [
            'rcc_serv_name.required'        => 'กรุณาระบุชื่อหน่วยบริการ',
            'rcc_location.required'         => 'กรุณาระบุที่ตั้ง',
            'rcc_established_date.date'     => 'รูปแบบวันที่ไม่ถูกต้อง',
            'rcc_contact_tel.digits'        => 'เบอร์โทรต้องเป็นตัวเลข 10 หลัก',
            'rcc_area_id.exists'            => 'พื้นที่นี้ไม่มีในระบบ',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'The given data was invalid.',
            'errors'  => $validator->errors(),
        ], 422));
    }
}
