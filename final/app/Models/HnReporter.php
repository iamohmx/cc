<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HnReporter extends Model
{
    protected $table = 'hn_reporters';
    protected $primaryKey = 'hn_reporter_id';
    public $timestamps = false;

    protected $fillable = [
        'hn_firstName',
        'hn_lastName',
        'hn_telNo',
        'hn_created_at',
    ];
}
