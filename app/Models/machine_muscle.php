<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class machine_muscle extends Model
{
    use HasFactory;

    protected $table = 'machine_muscles';
    protected $primaryKey = 'id';
    protected $fillable = ['machine_id','muscle_id'];
    
}
