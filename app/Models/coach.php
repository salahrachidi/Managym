<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class coach extends Model
{
    use HasFactory;
    protected $table = 'coaches';
    protected $primaryKey = 'id';
    protected $fillable = [
        'coa_nom',
        'coa_prenom',
        'coa_email',
        'coa_tele',
        'coa_pic',
    ];

    public function personnels()
    {
        return $this->hasMany(personnel::class);
    }
    public function transformations()
    {
        return $this->hasMany(transformation::class);
    }
}
