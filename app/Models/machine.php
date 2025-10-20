<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class machine extends Model
{
    use HasFactory;

    protected $table = 'machines';
    protected $primaryKey = 'id';
    protected $fillable = [
        'mac_label',
        'mac_description',
        'mac_pic',
        'mac_matricule',
    ];
    public function muscles(){
        return $this->belongsToMany(muscle::class);
    }
}
