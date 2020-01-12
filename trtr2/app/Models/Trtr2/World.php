<?php

namespace App\Models\Trtr2;

use Illuminate\Database\Eloquent\Model;



class World extends Model {
    protected $table = "trtr2__world";
    protected $fillable = ['steps', 'death', 'dust', 'build', 'status', 'dead'];
    public $timestamps = false;
}
