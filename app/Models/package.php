<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class package extends Model
{
    use HasFactory;
    protected $table = 'packages';
    protected $primaryKey = 'id';
    protected $fillable = [
                    'pac_title',
                    'pac_description',
                    'pac_duree',
                    'pac_prix',
    ];

    public function personnels(){
        return $this->hasMany(personnel::class);
    }

}
