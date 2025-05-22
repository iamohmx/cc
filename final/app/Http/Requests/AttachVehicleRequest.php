<?php

// app/Http/Requests/AttachVehicleRequest.php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class AttachVehicleRequest extends FormRequest
{
    public function authorize()
    {
        return true; // ปรับตาม policy ของคุณ
    }

    public function rules()
    {
        return [
            'rcc_serv_id'       => 'required|exists:rcc_service_units,rcc_serv_id',
            'rcc_emer_veh_id'   => 'required|exists:rcc_emergency_vehicles,rcc_emer_veh_id',
        ];
    }

    public function messages()
    {
        return [
            'rcc_serv_id.required'     => 'กรุณาระบุรหัสหน่วยบริการ',
            'rcc_serv_id.exists'       => 'หน่วยบริการนี้ไม่มีอยู่ในระบบ',
            'rcc_emer_veh_id.required' => 'กรุณาระบุรหัสรถฉุกเฉิน',
            'rcc_emer_veh_id.exists'   => 'รถฉุกเฉินนี้ไม่มีอยู่ในระบบ',
        ];
    }
}
