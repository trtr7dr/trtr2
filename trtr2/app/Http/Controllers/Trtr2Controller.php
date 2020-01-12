<?php

namespace App\Http\Controllers;
use App\Library\Trtr2\World_event;
use App\Models\Trtr2\Position;
use App\Models\Trtr2\World;
use App\Models\Trtr2\Chronicle;
use App\Models\Trtr2\Person;
use App\Models\Trtr2\Monster;
use App\Models\Trtr2\Dates;

class Trtr2Controller extends Controller {
    public function index(){
        $position_model = new Position();
		
        $data['person'] = $position_model->get()->toArray();
        $data['dead'] = Person::where('death', 1)->count();
        $data['world'] = World::orderBy('id', 'DESC')->first();
        $data['log'] = Chronicle::orderBy('id', 'DESC')->paginate(20);
        $data['status'] = ['жизнь', 'мор', 'праздник', 'война', 'развитие'];
        $data['monster'] = Monster::all();
        $data['date'] = Dates::get_date();
        return view('site.trtr2.trtr2', ['data' => $data]);
    }
    public function step(){  
       $world = new World_event();
       $world->step();
    }
}
