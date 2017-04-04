<?php

namespace App\Http\Middleware;
use Illuminate\Http\Response;

use Closure;

class verificarEmpresa
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
    $pos = mb_strpos($_SERVER['HTTP_HOST'], '.');
    $subdomain = '';
    if ($pos) {
        $subdomain = mb_substr($_SERVER['HTTP_HOST'], 0, $pos);
    }
    if( $subdomain ){
        if ( in_array( $subdomain, \Config::get("app.empresas") ) ){
            return $next($request);
        }else{
            return new Response(view('empresa_no_registrada'));
        }
    }
    return $next($request);

    var_dump("No esta registrado");exit();

    }
}
