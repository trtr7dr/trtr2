<?php

namespace App\Models\Trtr2;

use Illuminate\Database\Eloquent\Model;

class News extends Model {

    protected $table = "trtr2__news";
    protected $fillable = ['code', 'text'];
    
    public static function get_news($code){
	    $res = (new static)::where('code', $code)->inRandomOrder()->limit(1)->first();
	    return $res->text;
    }

}
