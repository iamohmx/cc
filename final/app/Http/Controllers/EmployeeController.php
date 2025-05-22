<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index()    { return Employee::all(); }
    public function store(Request $r)
    {
        $r->validate([
          'fst_user_id'=>'required|exists:rcc_users,rcc_user_id',
          'fst_emp_username'=>'required',
          'fst_emp_password'=>'required',
          'fst_emp_telNo'=>'required',
          'fst_emp_license_expiry_date'=>'required|date'
        ]);
        $data = $r->all();
        $data['fst_emp_password'] = Hash::make($r->fst_emp_password);
        return Employee::create($data);
    }
    public function show(Employee $employee) { return $employee; }
    public function update(Request $r, Employee $e)
    {
        $rules = [/* like store but sometimes */];
        $r->validate($rules);
        $data = $r->except('fst_emp_password');
        if($r->filled('fst_emp_password')){
            $data['fst_emp_password'] = Hash::make($r->fst_emp_password);
        }
        $e->update($data);
        return $e;
    }
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return response()->noContent();
    }
}
