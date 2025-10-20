<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transformation extends Model
{
    use HasFactory;


    protected $table = 'transformations';

    protected $primaryKey = 'id';
    protected $fillable = [
        'tra_description',
        'tra_pic1',
        'tra_poid',
        'tra_duree',
        'coach_id',
        'personnel_id',
    ];
    public function personnel()
    {
        return $this->belongsTo(personnel::class);
    }
    public function coach(){
        return $this->belongsTo(coach::class);
    }
}
