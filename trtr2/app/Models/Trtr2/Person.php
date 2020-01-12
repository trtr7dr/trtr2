<?php

namespace App\Models\Trtr2;

use Illuminate\Database\Eloquent\Model;
use App\Models\Trtr2\Name;
use App\Models\Trtr2\Sub_name;
use App\Models\Trtr2\Nick_name;

class Person extends Model {

    protected $table = "trtr2__person";
    protected $fillable = ['name_id', 'sub_name_id', 'nick_name_id', 'king', 'sex', 'figure', 'type', 'death', 'old', 'father_id', 'mather_id', 'child', 'cash', 'powerless', 'temper', 'life', 'damage'];
    protected $appends = ['name_obj', 'sub_name_obj', 'nick_name_obj'];
    
    public static $LIM_LIFE = 10; //предел для совершения изменений
    public static $LIM_MAX = 90; //предел для совершения изменений
    
    public function getNameObjAttribute() {
        $hasOne = $this->hasOne(Name::class, 'id', 'name_id');
        $name_model = $hasOne->first();
        return $name_model;
    }

    public function getSubNameObjAttribute() {
        $hasOne = $this->hasOne(Sub_name::class, 'id', 'sub_name_id');
        $sub_name_model = $hasOne->first();
        return $sub_name_model;
    }

    public function getNickNameObjAttribute() {
        $hasOne = $this->hasOne(Nick_name::class, 'id', 'nick_name_id');
        $nick_name_model = $hasOne->first();
        return $nick_name_model;
    }

    public static function get_parent($parent) {
        $sex = 1;
        if ($parent['sex'] === 1)
            $sex = 2;
        return (new static)::where('sex', $sex)
                        ->where('type', 1)
                        ->where('death', 0)
                        ->first();
    }

    public static function dying($lim) {
        return (new static)::where('type', 1)
                    ->where('death', 0)
                    ->where(function($query){
		                $query->where('life', '<', self::$LIM_LIFE)
		                      ->orWhere('old', '>', self::$LIM_MAX)
		                      ->orWhere('cash', '<', self::$LIM_LIFE * (-1) )
		                      ->orWhere('powerless', '>', self::$LIM_MAX );
		            })
                    ->limit($lim)
                    ->inRandomOrder()
                    ->get();
    }

}
