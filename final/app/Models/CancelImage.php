<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CancelImage extends Model
{
    protected $table = 'fast_track_cancel_images';
    protected $primaryKey = 'fst_cancel_img_id';
    public $timestamps = false;
    protected $fillable = ['fst_mis_log_id','fst_cancel_img_path'];
}
