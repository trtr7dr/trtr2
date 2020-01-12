<?php

namespace App\Library\Trtr2;

use App\Models\Trtr2\Person;
use App\Models\Trtr2\Position;
use App\Models\Trtr2\Name;
use App\Models\Trtr2\Sub_name;
use App\Library\Trtr2\Position_event;
use App\Library\Trtr2\News_event;

class Person_event {

    public static $MAX_FIGURE = 23; //число картинок для персонажей
    public static $HELL = 1; // код локации кутежа
    public static $WORK = 2; // код локации работы
    public static $HOME = 3; // код локации дома
    public static $SAD = 4; // код локации леса
    public static $LIM_LIFE = 10; //предел для совершения изменений
    public static $LIM_MAX = 90; //предел для совершения изменений
    public static $RAND = 10; //вероятность важных событий
    public static $DEAD_CODE = 3;
    public static $NEW_CODE = 4;

    public function new_person($mather = null, $father = null, $temper = null, $sub_name_id = null) {
        $model = new Person();
        $model->mather_id = $mather;
        $model->father_id = $father;
        $model->sex = rand(1, 2); //пол
        $model->figure = rand(1, self::$MAX_FIGURE); //внешность
        if (is_null($temper)) { //характер
            $model->temper = rand(1, 100);
        } else {
            $model->temper = $temper;
        }
        if (!is_null($sub_name_id)) {
            $model->sub_name_id = $sub_name_id;
        }
        $name_model = new Name();
        $name = $name_model->where('sex', $model->sex)->inRandomOrder()->pluck('id');
        $model->name_id = $name[0];
        $model->save();

        Position_event::add_rand_position($model->id); // добавляем для персонажа случайное положение

        return $model;
    }

    public function do_changes($elem) {
        if ($elem['person_obj']['death'] === 1)
            return 0;

        $this->changes_in_person($elem);
        $this->changes_position($elem['person_obj']);
        $this->dead_time();
    }

    public function changes_in_person($el) {
        $person_obj = $el['person_obj'];
        $person_model = Person::find($person_obj['id']); //поскольку $el содержит все связи для персонажа, создаем новую модель для обновления

        $person_model->old = $person_obj['old'] + 1;
        switch ($el['location']) {
            case (self::$HELL):
                $person_model->cash = $person_obj['cash'] - rand(1, 10) - rand(1, $person_obj['temper'] / 10);
                $person_model->powerless = $person_obj['powerless'] - rand(1, 10);
                break;
            case (self::$WORK):
                $person_model->cash = $person_obj['cash'] + rand(1, 10) + rand(1, $person_obj['temper'] / 10);
                $person_model->powerless = $person_obj['powerless'] + rand(1, 10);
                $person_model->life = $person_obj['life'] - rand(1, self::$LIM_LIFE);
                break;
            case (self::$HOME):
                $person_model->cash = $person_obj['cash'] - rand(1, 10);
                $person_model->powerless = $person_obj['powerless'] - rand(1, 10);
                $person_model->life = $person_obj['life'] + rand(1, 10);
                if (rand(0, ((self::$RAND * 2) * ($person_model->child + 1))) === 1) {
                    $this->new_child($el['person_obj']);
                }
                break;
            case (self::$SAD):
                $person_model->powerless = $person_obj['powerless'] + rand(1, 10);
                $person_model->life = $person_obj['life'] - rand(1, 10);
                break;
        }
        $person_model->save();
    }

    public function new_child($parent) {
	    
        $per2 = Person::get_parent($parent); //возможный родитель
     
        if (!is_null($per2)) {
            $child = $this->new_person($parent['id'], $per2->id, $parent['temper'], $this->get_sub($parent, $per2));
            $child_arr = $child->toArray();
            $per2_arr = $per2->toArray();
            News_event::news_create(self::$NEW_CODE, $per2_arr['name_obj']['name'] . ' + ' . $parent['name_obj']['name'] . ' = ' . $child_arr['name_obj']['name'] . ' ' . $child_arr['sub_name_obj']['name']);
               
        }
    }

    public function get_sub($per1, $p2) { //фамилия, постродовое состояние, число детей
        $p1 = Person::find($per1['id']);
        $p1->child = $p1->child + 1;
        $p2->child = $p2->child + 1;

        $res = NULL;
        if (!is_null($p1['sub_name_id'])) {
            $p2->sub_name_id = $p1['sub_name_id'];
            $res = $p1['sub_name_id'];
        } elseif (!is_null($p2->sub_name_id)) {
            $res = $p2->sub_name_id;
        }
        if (is_null($p1['sub_name_id']) && is_null($p2->sub_name_id)) {
            $sub_id = Sub_name::get_random_sub();

            $p1->sub_name_id = $sub_id;
            $p1->powerless = self::$LIM_MAX;

            $p2->sub_name_id = $sub_id;
            $p2->powerless = self::$LIM_MAX;

            $res = $sub_id;
        }

        $p1->save();
        $p2->save();
        return $res;
    }

    public function changes_position($person_obj) {
        $position_model = Position::where('person', $person_obj['id'])->first();
        $new_location = $this->test_person($person_obj);
        $position_model->location = $new_location;
        $position_model->save();
        return $new_location;
    }

    public function test_person($obj) {


        if (rand(1, 100) > $obj['temper']) {
            return rand(1, 4);
        }

        if ($obj['life'] < self::$LIM_LIFE || $obj['powerless'] > self::$LIM_MAX + $obj['temper']) {
            return self::$SAD;
        }

        if ($obj['cash'] < self::$LIM_LIFE || (rand(1, 100) + $obj['temper']) < self::$LIM_MAX || $obj['powerless'] < 0) {
            return self::$WORK;
        }

        if ($obj['cash'] > self::$LIM_MAX || $obj['life'] > self::$LIM_MAX) {
            return self::$HOME;
        }
        return rand(1, 4);
    }

    public function dead_time() {
        $dyings = Person::dying(rand(0, self::$RAND));
        foreach ($dyings as $el) {
            if (rand(0, self::$RAND) === 1 || rand(self::$LIM_MAX, self::$LIM_MAX * 2) < $el->old || $el->life <= 0) {
                $dying_arr = $el->toArray();
                News_event::news_create(self::$DEAD_CODE, $dying_arr['name_obj']['name']);
                $el->death = 1;
                $el->save();
                $position_model = Position::where('person', $el->id)->first();
                $position_model->location = 0;
                $position_model->save();
            }
        }
    }

    public function kill($elem) {
        $elem->death = 1;
        $elem->save();
    }

    public function set_pos_by_person($id) {
        $p = Position::where('person', $id)->first();
        $p->location = 4;
        $p->save();
    }

}
