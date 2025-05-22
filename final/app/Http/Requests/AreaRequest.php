<?php
// app/Http/Requests/AreaRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AreaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'rcc_area_name' => 'required|string|max:100',
        ];
    }

    public function messages()
    {
        return [
            'rcc_area_name.required' => 'กรุณาระบุชื่อพื้นที่',
            'rcc_area_name.string'   => 'ชื่อพื้นที่ต้องเป็นอักษร',
            'rcc_area_name.max'      => 'ชื่อพื้นที่ยาวเกิน 100 ตัวอักษร',
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
