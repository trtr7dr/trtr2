<?php

namespace App\Models\Trtr2;

use Illuminate\Database\Eloquent\Model;
use App\Models\Trtr2\Person;
use App\Models\Trtr2\Location;

class Position extends Model {

    protected $table = "trtr2__position";
    protected $fillable = ['person', 'location'];
    protected $appends = ['person_obj', 'location_obj'];
    public $timestamps = false;

    public function getPersonObjAttribute() {
        $hasOne = $this->hasOne(Person::class, 'id', 'person');
        $person_model = $hasOne->first();
        return $person_model;
    }

    public function getLocationObjAttribute() {
        $hasOne = $this->hasOne(Location::class, 'id', 'location');
        $location_model = $hasOne->first();
        return $location_model;
    }
    
}
