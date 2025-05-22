<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RccRole extends Model
{
    protected $table = 'rcc_roles';
    protected $primaryKey = 'rcc_role_id';
    public $timestamps = false;

    protected $fillable = [
        'rcc_role_name',
        'rcc_created_at',
        'rcc_updated_at',
    ];

    // Relations
    public function users()
    {
        return $this->hasMany(RccUser::class, 'rcc_role_id');
    }

}
