<?php

namespace App\Library\Trtr2;

use App\Models\Trtr2\Person;
use App\Library\Trtr2\News_event;

class King_event extends Specific_event {

    public static $GOOD_VAL = 70;
    public static $N_HEIR = 1; //айди наследников
    public static $N_KING = 2;
    public static $N_EX_KING = 3;
    public static $NEW_KING_CODE = 12;
    public static $REL_CODE = 13;
    public static $AXE_CODE = 14;
    public static $REVOL_CODE = 15;
    public static $RAND = 20;
    public static $RAND_STAT = 25; //вероятность смены статуса
    public static $N_KING_KILLER = 4; 
    public static $N_KILLED_KING = 5; 

    public function govern($steps, $w) {
        if (is_null($this->king_check()) || $steps % 100 === 0) { //нет короля!
            if ($steps % 100 === 0) {
                $k = $this->new_king();
                $this->rand_event($k, $w);
            }
        } else {
            if (rand(0, self::$RAND) === 0) {
                $this->axe_person();
            }
            if (rand(0, self::$RAND) === 0) {
                $this->heir();
            }
        }
    }

    public function king_check() {
        return Person::where('king', 1)->where('death', 0)->first();
        
    }

    public function new_king() {
        $old = Person::where('king', 1)->get();
        foreach ($old as $el) {
            $el->king = 0;
            $el->nick_name_id = self::$N_EX_KING;
            $el->save();
        }
        $new_king = Person::where('king', 0)->where('death', 0)->where('nick_name_id', self::$N_HEIR)->first();
        if (is_null($new_king)) {
            $new_king = Person::where('king', 0)->where('death', 0)->first();
        }
        if (!is_null($new_king)) {
            $new_king->king = 1;
            $new_king->figure = 100;
            $new_king->nick_name_id = self::$N_KING;
            $new_king->cash = self::$GOOD_VAL;
            $new_king->powerless = 0;
            $new_king->save();
            //
        }
        return $new_king->toArray();
    }

    public function rand_event($k, $w) {
        News_event::news_create(self::$NEW_KING_CODE, $k['name_obj']['name']);
        if (rand(0, self::$RAND_STAT) === 0) {
            News_event::news_create(self::$REL_CODE);
            $this->status($w);
        }
    }

    public function axe_person() {
        $aliver = Person::where('death', 0)->inRandomOrder()->first();
        if (!is_null($aliver)) {
            $aliver->death = 1;
            $k = $aliver->toArray();
            News_event::news_create(self::$AXE_CODE, $k['name_obj']['name']);
            $aliver->save();
        }
    }

    public function heir() {
        $aliver = Person::where('death', 0)->where('king', '!=', 1)->inRandomOrder()->first();
        if (!is_null($aliver)) {
            $aliver->nick_name_id = 1;
            
            $aliver->life = self::$GOOD_VAL;
            $aliver->cash = self::$GOOD_VAL;
            $aliver->save();
        }
    }

    public static function regicide($new_king, $old, $w) {
        $new_king->nick_name_id = self::$N_KING_KILLER;
        $new_king->save();
        $old->nick_name_id = self::$N_KING_KILLER;
        $w->status = self::$S_WAR;
        $w->save;
        News_event::news_create(self::$REVOL_CODE);
    }

}
