<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class presence extends Model
{
    use HasFactory;

    protected $table = 'presences';
    protected $primaryKey = 'id';
    protected $fillable = [
                // 'pre_date',
                // 'pre_time',
                'personnel_id',
    ];
    public function personnels(){
        return $this->belongsTo(personnel::class);
    }
}
