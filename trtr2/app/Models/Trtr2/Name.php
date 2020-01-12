<?php

    namespace App\Models\Trtr2;
	
    use Illuminate\Database\Eloquent\Model;

    class Name extends Model {

	protected $table = "trtr__name";
        protected $primaryKey = 'id';
	protected $fillable = ['id', 'name', 'sex'];
        
        
        
	
//	public function get_name_by_id($id){
//            return $this->where('id', $id)->pluck('name');
//	}
//        public function get_only_name_by_id($id){
//            $res = $this->where('id', $id)->pluck('name');
//            return $res[0];
//        }
//        public function get_only_sex_by_id($id){
//            $res = $this->where('id', $id)->pluck('sex');
//            return $res[0];
//        }

}