<?php

namespace App\Models\Trtr2;

use Illuminate\Database\Eloquent\Model;

class Nick_name extends Model {

    protected $table = "trtr2__nick_name";
    protected $fillable = ['id', 'type', 'name'];
    
//    public function get_random_name($type) {
//        $res = $this->where('type', $type)->inRandomOrder()->limit(1)->first(); //рандомное имя
//        return $res->name;
//    }
}
