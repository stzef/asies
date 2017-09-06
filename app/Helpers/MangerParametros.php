<?php

namespace asies\Helpers;

use asies\Models\Parametros;

class MangerParametros
{
	public static function canGoBackQuestion()
	{
		$can = true;
		$parametros = Parametros::where("cparam","QUESTIONS__CAN_GO_BACK")->first();
		if ( $parametros ){
			$can = $parametros->val();;
		}
		// dump($can);exit();
		return $can;
	}
}
