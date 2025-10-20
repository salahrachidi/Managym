<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class muscle extends Model
{
    use HasFactory;
        protected $table = 'muscles';
        protected $primaryKey = 'id';
        protected $fillable = [
            'mus_label',
            'mus_pic',
        ];
        public function machines(){
            return $this->belongsToMany(machine::class);
        }
}
