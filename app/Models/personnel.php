<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class personnel extends Model
{
    use HasFactory;
    protected $table = 'personnels';
    protected $primaryKey = 'id';
    protected $fillable = [
            'per_role',
            'per_nom',
            'per_prenom',
            'per_tel',
            'per_pic',
            'per_sexe',
            'per_email',
            'per_password',
            'per_status',
            'package_id',
            'coach_id',
            
    ];

    public function package(){
        return $this->belongsTo(package::class);
    }
    public function coach(){
        return $this->belongsTo(coach::class);
    }
    public function fingerprint(){
        return $this->hasOne(fingerprint::class);
    }
    public function payments(){
        return $this->hasMany(payment::class);
    }
    public function presences(){
        return $this->hasMany(presence::class);
    }
    public function transformations(){
        return $this->hasMany(transformation::class);
    }
}   
