<?php

namespace asies\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $cparam
 * @property string $name
 * @property string $type
 * @property string $value_text
 * @property boolean $value_bool
 * @property integer $value_int
 */
class Parametros extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'type', 'value_text', 'value_bool', 'value_int'];

	static function get($cparam){
		$parametro = Parametros::where("cparam",$cparam)->first();
		if ( $parametro ){
			return $parametro;
		}
		return null;
	}
	public function set($cparam,$value){

	}

	public function val(){
		if ( $this->type == "INT" ){
			return (int)$this->value_int;
		} else if ( $this->type == "BOOL" ){
			if ( $this->value_bool == "1" ){
				return true;
			}
			return false;
		}else if ( $this->type == "JSON" ){
			return json_decode($this->value_text);
		}else if ( $this->type == "TEXT" ){
			return $this->value_text;
		}else if ( $this->type == "IMG" ){
			return $this->value_text;
		}else if ( $this->type == "PATH" ){
			return $this->value_text;
		}
	}

}
