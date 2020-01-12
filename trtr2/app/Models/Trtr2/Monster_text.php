<?php

namespace App\Models\Trtr2;

use Illuminate\Database\Eloquent\Model;
use App\Models\Trtr2\Monster_text;

class Monster_text extends Model {

    protected $table = "trtr2__monster_text";
    protected $fillable = ['text'];
    public $timestamps = false;
    
}
