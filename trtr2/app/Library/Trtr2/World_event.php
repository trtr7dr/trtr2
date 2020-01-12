<?php

namespace App\Library\Trtr2;

use App\Models\Trtr2\Person;
use App\Models\Trtr2\World;
use App\Models\Trtr2\Position;
use App\Models\Trtr2\Monster;
use App\Library\Trtr2\Person_event;
use App\Library\Trtr2\News_event;
use App\Library\Trtr2\Specific_event;

class World_event {

    public static $build = 7; //шанс постройки (при наличии денег)
    public static $MAX_MONSTERS = 30;
    public static $CREATE_CODE = 1;
    public static $DESTR_CODE = 2;
    public static $BODY_CODE = 5;
    public static $WORK_LOC = 2;
    public static $MAX_LIVE_PERSON = 150; //максимум живых
    public static $DIVIDER_PARAM = 3; //делитель для уменьшение значений
    private $CURRENT_WORLD = 1;

    public function __construct() {
        $this->CURRENT_WORLD = World::orderBy('id', 'DESC')->first();
    }

    public function new_world() { //создать новый мир
        Person::truncate();
        Position::truncate();
        Monster::truncate();

        $world_model = new World();
        $world_model->save();

        $person_class = new Person_event();
        $rand = rand(10, 30);  // новых персонажей
        for ($i = 0; $i < $rand; $i++) {
            $person_class->new_person();
        }
        News_event::news_create(self::$CREATE_CODE, ($this->CURRENT_WORLD->id + 1));

        $this->CURRENT_WORLD = World::orderBy('id', 'DESC')->first();
    }

    public function step() {
        $this->CURRENT_WORLD->steps += 1;
        $person_class = new Person_event();
        $data = Position::where('location', '!=', 0)->get()->toArray();

        $this->CURRENT_WORLD->dust += Position::where('location', self::$WORK_LOC)->count(); //налоги
        $this->CURRENT_WORLD->dust -= (rand(1, count($data)) / self::$DIVIDER_PARAM); // минус за содержание королевства

        foreach ($data as $person) {
            $person_class->do_changes($person);
        }

        $spec_event = new Specific_event;
        $spec_event->step($this->CURRENT_WORLD);

        $this->empty_body();
        $this->end_check();

        $this->CURRENT_WORLD->save();
    }

    public function end_check() { //проверка на конец мира 
        $alive = Person::where('death', 0)->count();

        if ($alive > self::$MAX_LIVE_PERSON) {
            $this->new_world();
            News_event::news_create(self::$DESTR_CODE, ($this->CURRENT_WORLD->id - 1) . ' (ПЕРЕНАСЕЛЕНИЕ)');
        }
        if ($alive <= 0) {
            $this->new_world();
            News_event::news_create(self::$DESTR_CODE, ($this->CURRENT_WORLD->id - 1) . ' (НЕТ ЖИТЕЛЕЙ)');
        }
        if ($this->CURRENT_WORLD->dust < 0) {
            $this->new_world();
            News_event::news_create(self::$DESTR_CODE, ($this->CURRENT_WORLD->id - 1) . ' (НЕТ ПЫЛИ)');
        }
        if (count(Monster::all()) > self::$MAX_MONSTERS) {
            $this->new_world();
            News_event::news_create(self::$DESTR_CODE, ($this->CURRENT_WORLD->id - 1) . ' (МОНСТРЫ АТАКУЮТ)');
        }
    }

    public function empty_body() { //сожжение лишних трупов
        $dead = Person::where('death', 1)->count();

        if ($dead > self::$MAX_LIVE_PERSON) {
            $deleted = '| ';
            $data = Person::where('death', 1)
                    ->where('sex', '!=', 3)
                    ->inRandomOrder()
                    ->limit(rand(1, self::$MAX_LIVE_PERSON))
                    ->get();
            foreach ($data as $el) {
                $temp = $el->toArray();
                $deleted .= $temp['name_obj']['name'] . ' | ';
                Position_event::delet_by_per($el->id);
                $el->delete();
            }
            News_event::news_create(self::$BODY_CODE, $deleted);
        }
    }

}
