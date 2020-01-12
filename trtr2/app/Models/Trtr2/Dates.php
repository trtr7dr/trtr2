<?php

namespace App\Models\Trtr2;

use Illuminate\Database\Eloquent\Model;

class Dates extends Model {

    protected $table = "trtr2__date";
    protected $fillable = ['id', 'name'];

    public static function get_date() {
	    $m = date('n');
        $res = (new static)::where('id', $m)->first();
        return $res->name;
    }
}
