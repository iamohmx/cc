<?php
// app/Http/Requests/ReportIncidentRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ReportIncidentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // อนุญาตทุกคนเรียก endpoint นี้
    }

    public function rules(): array
    {
        return [
            'first_name'     => 'required|string|max:50',
            'last_name'      => 'required|string|max:50',
            'phone'          => 'required|string|max:10',
            'note'           => 'required|string',
            'location_link'  => 'required|url',
            'conscious'      => 'required|in:1,2,3',
            'breathing'      => 'required|boolean',
            'victims'        => 'required|integer|min:1',
            'symptoms'       => 'required|string',
            'status'         => 'required|in:1,2,3',
            'source'         => 'required|in:1,2',
            'images'         => 'nullable|array',
            'images.*'       => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required'    => 'กรุณาระบุชื่อ',
            'last_name.required'     => 'กรุณาระบุนามสกุล',
            'phone.required'         => 'กรุณาระบุเบอร์โทร',
            'phone.max'              => 'เบอร์โทรต้องไม่เกิน 10 ตัว',
            'location_link.url'      => 'ลิงก์พิกัดไม่ถูกต้อง',
            'breathing.boolean'      => 'ค่าการหายใจต้องเป็น true/false',
            'victims.min'            => 'จำนวนผู้ประสบเหตุต้องไม่น้อยกว่า 1',
            'images.array'           => 'Images ต้องเป็น array',
            'images.*.image'         => 'ไฟล์แต่ละไฟล์ต้องเป็นรูปภาพ',
            'images.*.mimes'         => 'ไฟล์รูปต้องเป็น jpeg,png,jpg,gif เท่านั้น',
            'images.*.max'           => 'ขนาดไฟล์แต่ละรูปห้ามเกิน 2MB',
        ];
    }

    /**
     * เมื่อ validation fail ให้ตอบ JSON พร้อม status code 422
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'The given data was invalid.',
            'errors'  => $validator->errors(),
        ], 422));
    }
}
