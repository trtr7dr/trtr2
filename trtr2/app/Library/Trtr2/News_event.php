<?php

namespace App\Library\Trtr2;

use App\Models\Trtr2\News;
use App\Models\Trtr2\Chronicle;

class News_event {

    public static function news_create($code, $dop){
	    $chronicle = new Chronicle();
	    $chronicle->text = News::get_news($code) . ' ' . $dop;
	    $chronicle->save();
    }
    public static function news_create_format($code, $dop, $dop2){
	    $chronicle = new Chronicle();
	    $chronicle->text = $dop . ' ' . News::get_news($code) . ' ' . $dop2;
	    $chronicle->save();
    }

}
