<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HnIncidentReporter extends Model
{
    protected $table = 'hn_incident_reporters';
    protected $primaryKey = 'hn_inc_rep_id';
    public $timestamps = false;

    protected $fillable = [
        'hn_incident_id',
        'hn_user_id',
        'hn_reporter_id',
        'hn_reported_at',
    ];
}
