<?php

namespace App\Models\Trtr2;

use Illuminate\Database\Eloquent\Model;

class Status extends Model {

    protected $table = "trtr2__status";
    protected $fillable = ['id', 'name'];

    public static function get_status() {
        $res = (new static)::where('id', '>', 0)->orderBy('id', 'asc')->get(); 
        return $res->toArray();
    }
}
