<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MissionCancellation extends Model
{
    protected $table = 'fast_track_mission_cancellations';
    protected $primaryKey = 'fst_mis_cancel_id';
    public $timestamps = false;
    protected $fillable = ['fst_mis_log_id','fst_cancel_reason'];

    public function images()
    {
        return $this->hasMany(CancelImage::class,'fst_mis_cancel_id');
    }
}
