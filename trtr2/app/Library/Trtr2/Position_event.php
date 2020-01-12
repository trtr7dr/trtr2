<?php

    namespace App\Library\Trtr2;
    
    use App\Models\Trtr2\Position;

    class Position_event {
        
        public static $max_location = 4; //локкаций


        public static function add_rand_position($id){ //случайная позиция для персонажа по айди
            $position_model = new Position();
            $position_model->person = $id;
            $position_model->location = rand(1, self::$max_location);
            $position_model->save();
        }
        public static function delet_by_per($per){
            $del = Position::where('person', $per)->first();
            $del->delete();
        }
    }
