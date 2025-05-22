<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HnPersonalInfo extends Model
{
    protected $table = 'hn_personal_info';
    protected $primaryKey = 'hn_infoId';
    public $timestamps = false;

    protected $fillable = [
        'hn_firstName',
        'hn_lastName',
        'hn_gender',
        'hn_bloodGroup',
        'hn_address',
        'hn_created_at',
        'hn_updated_at',
    ];
}
