<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'fast_track_employees';
    protected $primaryKey = 'fst_emp_id';
    public $timestamps = false;
    protected $fillable = [
       'fst_user_id','fst_emp_username','fst_emp_password',
       'fst_emp_telNo','fst_emp_license_expiry_date'
    ];
}
