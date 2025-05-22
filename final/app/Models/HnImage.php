<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HnImage extends Model
{
    protected $table = 'hn_images';
    protected $primaryKey = 'hn_img_id';
    public $timestamps = true;
    const CREATED_AT = 'hn_created_at';
    const UPDATED_AT = 'hn_updated_at';

    protected $fillable = ['hn_img_path'];
}
