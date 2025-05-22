<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    protected $table = 'fast_track_hospitals';
    protected $primaryKey = 'fst_hosp_id';
    public $timestamps = false;
    protected $fillable = ['fst_hosp_name'];
}
