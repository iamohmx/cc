<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use Illuminate\Http\Request;

class HospitalController extends Controller
{
    public function index()    { return Hospital::all(); }
    public function store(Request $r)
    {
        $r->validate(['fst_hosp_name'=>'required']);
        return Hospital::create($r->only('fst_hosp_name'));
    }
    public function show(Hospital $hospital){ return $hospital; }
    public function update(Request $r, Hospital $h)
    {
        $r->validate(['fst_hosp_name'=>'required']);
        $h->update($r->only('fst_hosp_name'));
        return $h;
    }
    public function destroy(Hospital $hospital)
    {
        $hospital->delete();
        return response()->noContent();
    }
}
