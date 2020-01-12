<?php

    namespace App\Models\Trtr2;
	
    use Illuminate\Database\Eloquent\Model;

    class Location extends Model {

	protected $table = "trtr2__location";
        protected $primaryKey = 'id';
        protected $fillable = ['name', 'code'];


}