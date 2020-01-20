<?php

namespace App\Library\Trtr2;

use App\Models\Trtr2\Person;
use App\Models\Sacri;
use App\Models\Trtr2\Status;
use App\Models\Trtr2\Monster;
use App\Library\Trtr2\Person_event;
use App\Library\Trtr2\King_event;
use App\Library\Trtr2\News_event;

class Specific_event extends Person_event {

    public static $MAX_CHANCE = 25; //вероятность стороннего события
    public static $DAMEGE = 50; //максимальный урон 
    public static $DEAD = 15; //максимально смертей 
    public static $KILL_CODE = 6;
    public static $TRY_KILL_CODE = 7;
    public static $CATA_CODE = 8;
    public static $GRO_CODE = 9;
    public static $STAT_CODE = 10;
    public static $STAT_END_CODE = 11;
    public static $GOD_RES = 16;
    public static $GOD_MAD = 17;
    public static $MONSTER_CODE = 18;
    public static $MAX_STATUS = 5; //2 мор | 3 праздник | 4 война | 5 экономический подъем
    public static $S_MOR = 2;
    public static $S_GRAZ = 3;
    public static $S_WAR = 4;
    public static $S_ECO = 5;
    public static $MONSTER_TYPE = 3;
    public static $MONSTER_FIG = 5;
    public static $N_KING = 2;

    public function step(object $world) : void {
        if (rand(0, self::$MAX_CHANCE) === 0) {
            $this->kill_event($world);
        }
        if (rand(0, self::$MAX_CHANCE) === 0) {
            $this->cataclism();
        }
        if (rand(0, self::$MAX_CHANCE) === 0) {
            $this->growth();
        }
        if (rand(0, self::$MAX_CHANCE * 2) === 0 || $world->status !== 1) {
            $this->status($world);
        }
        if (rand(0, self::$MAX_CHANCE * 2) === 0) {
            $this->god_event();
        }
        if (rand(0, self::$MAX_CHANCE * 2) === 0) {
            $this->monster_add();
        }
        $king_event = new King_event();
        $king_event->govern($world->steps, $world);
    }

    public function kill_event(object $world) : void {
        $alivers = Person::where('death', 0)->inRandomOrder()->limit(2)->get();
        if (count($alivers) === 2) {
            $killer = $alivers[0]->toArray();
            $deads = $alivers[1]->toArray();
            if (rand(0, 3) === 1) {
                $alivers[1]->life = $alivers[1]->life - rand(1, self::$DAMEGE);
                $alivers[1]->damage += 1;
                $alivers[1]->save();
                News_event::news_create(self::$TRY_KILL_CODE, $killer['name_obj']['name'] . '->' . $deads['name_obj']['name']);
            } else {
                if ($alivers[1]->nick_name_id === self::$N_KING) {
                    King_event::regicide($alivers[0], $alivers[1], $world);
                }
                $this->kill($alivers[1]);
                News_event::news_create(self::$KILL_CODE, $killer['name_obj']['name'] . '->' . $deads['name_obj']['name']);
            }
        }
    }

    public function cataclism() : void {
        $deads = Person::where('death', 0)->inRandomOrder()->limit(rand(1, self::$DEAD))->get();
        $list = '| ';
        foreach ($deads as $el) {
            $el->death = 1;
            $el->save();
            $temp = $el->toArray();
            $list .= $temp['name_obj']['name'] . ' | ';
        }
        News_event::news_create(self::$CATA_CODE, $list);
    }

    public function growth() : void {
	    $list = '| ';
        for ($i = 0; $i < rand(1, self::$DEAD); $i++) {
            $el = $this->new_person();
            $temp = $el->toArray();
            $list .= $temp['name_obj']['name'] . ' | ';
        }
        News_event::news_create(self::$GRO_CODE, $list);
    }

    public function status(object $w) : void {
        if ($w->status === 1) {
            $w->status = rand(2, self::$MAX_STATUS);
            $stat = Status::get_status();
            News_event::news_create(self::$STAT_CODE, $stat[$w->status - 1]['name']);
        } elseif (rand(0, 5) === 5) {
            $stat = Status::get_status();
            News_event::news_create(self::$STAT_END_CODE, $stat[$w->status - 1]['name']);
            $w->status = 1;
        }
        switch ($w->status) {
            case (self::$S_MOR):
                $this->mor_do();
                break;
            case (self::$S_GRAZ):
                $this->graz_do();
                break;
            case (self::$S_WAR):
                $this->war_do();
                $w->dust -= rand(0, self::$MAX_CHANCE);
                break;
            case (self::$S_ECO):
                $this->eco_do();
                $w->dust += rand(0, self::$MAX_CHANCE);
                break;
        }
        $w->save();
    }

    public function mor_do() : void {
        $deads = Person::where('death', 0)->inRandomOrder()->limit(rand(0, self::$DEAD))->get();
        foreach ($deads as $el) {
            $el->life -= rand(1, self::$DAMEGE / 3);
            $el->save();
        }
    }

    public function graz_do() : void {
        $deads = Person::where('death', 0)->inRandomOrder()->limit(rand(0, self::$DEAD))->get();
        foreach ($deads as $el) {
            $el->life += rand(1, self::$DAMEGE / 3);
            $el->save();
        }
    }

    public function war_do() : void {
        $deads = Person::where('death', 0)->where('old', '>', 14)->inRandomOrder()->limit(rand(0, self::$DEAD / 2))->get();
        foreach ($deads as $el) {
            $el->death = 1;
            $el->save();
        }
    }

    public function eco_do() : void {
        for ($i = 0; $i < rand(1, self::$DEAD / 2); $i++) {
            $this->new_person();
        }
    }

    public function god_event() : void {
        $god = Sacri::get_rand_god();

        if (rand(0, 1) === 1) {
            $per = Person::where('death', 1)->inRandomOrder()->first();
            if (!is_null($per)) {
                $per->death = 0;
                $per->save();
                $this->set_pos_by_person($per->id);
                $p = $per->toArray();
                News_event::news_create_format(self::$GOD_RES, $god->name, $p['name_obj']['name']);
            }
        } else {
            $per = Person::where('death', 0)->inRandomOrder()->first();
            if (!is_null($per)) {
                $per->temper = 0;
                $per->save();
                $p = $per->toArray();
                News_event::news_create_format(self::$GOD_MAD, $god->name, $p['name_obj']['name']);
            }
        }
    }

    public function monster_add() : void {
        $p = Person::where('death', 0)->inRandomOrder()->first();
        $p->type = 3;
        $p->death = 1;
        $p->save();
        $m = new Monster();
        $m->figure = rand(1, self::$MONSTER_FIG);
        $text = $m->get_rand_text();
        $m->text = $text->text;
        $m->save();
        $p_arr = $p->toArray();
        News_event::news_create(self::$MONSTER_CODE, $p_arr['name_obj']['name']);
    }

}
