<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Planes;


class APIController extends Controller
{
    public function planes()
    {
        $planes = Planes::getArbolPlanes(true);
		return response()->json($planes);
    }
}
