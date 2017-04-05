<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Planes;
use Illuminate\Support\Facades\Validator;

class PlanesController extends Controller
{
	public function create(Request $request)
	{

		$validator = Validator::make($request->all()["plan"],
		    [
		        'nplan' => 'required|unique:planes|max:255',
		    ]
		);

		if ($validator->fails())
		{
			$messages = $validator->messages();
			//dump($messages);
			//exit();
			return response()->json($messages,400);
		}

	    $input = $request->all();
	    /*dump($input);
	    exit();*/
		//Planes::create($input["plan"]);


	    //Task::create($input);

		return response()->json(array("text"=>"ok"));
	}
}
