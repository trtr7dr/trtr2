<?php

namespace App\Models\Trtr2;

use Illuminate\Database\Eloquent\Model;
use App\Models\Trtr2\Monster_text;

class Monster extends Model {

    protected $table = "trtr2__monster";
    protected $fillable = ['figure', 'text'];
    public $timestamps = false;
    
    public function get_rand_text(){
	    return Monster_text::inRandomOrder()->first();
    }
    
}
