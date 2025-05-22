<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class StoreFastTrackUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    // ก่อน validate ให้ strip_tags ทุก field ที่เป็น string
    protected function prepareForValidation()
    {
        $fields = ['fst_username', 'fst_email'];
        foreach ($fields as $f) {
            if ($this->has($f)) {
                $this->merge([$f => strip_tags($this->input($f))]);
            }
        }
    }

    public function rules()
    {
        return [
            'rcc_role_id'  => 'required|integer|exists:rcc_roles,rcc_role_id',
            'rcc_serv_id'  => 'required|integer|exists:rcc_service_units,rcc_serv_id',
            'fst_username' => 'required|string|max:100|unique:fast_track_users,fst_username',
            'fst_password' => 'required|string|min:6',
            'fst_email'    => 'required|email|max:100|unique:fast_track_users,fst_email',
            'fst_status'   => 'boolean',
            'profile_img'  => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ];
    }

    // เมื่อ validation ผิด ให้โยนออกเป็น JSON
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422)
        );
    }
}
