<?php

namespace App\Models\Trtr2;

use Illuminate\Database\Eloquent\Model;

class Sub_name extends Model {

    protected $table = "trtr2__sub_name";
    protected $fillable = ['id', 'name'];

    public static function get_random_sub() {
        $res = (new static)::inRandomOrder()->limit(1)->first(); //рандомное имя
        return $res->id;
    }

}
