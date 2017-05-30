<?php

namespace asies\Http\Controllers\Auth;


use asies\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    public function authenticate(Request $request)
    {
		$dataBody = $request->all();
		$email = $dataBody["email"];
		$password = $dataBody["password"];
        if (Auth::attempt(['email' => $email, 'password' => $password, 'active' => 1])) {
			Log::info('Inicio de Session',['email' => $email,'date' => date("Y-m-d H:i:s")]);

            return redirect()->intended('dashboard');
        }
        return redirect('login');

    }
    public function logout(Request $request)
    {
			$user = Auth::user();

		Log::info('Cierra de Session',['user' => $user,'date' => date("Y-m-d H:i:s")]);
		Auth::logout();
		return redirect('login');

    }
}
