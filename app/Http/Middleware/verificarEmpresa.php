<?php

namespace asies\Http\Middleware;
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
    $http_host = str_replace("www.","",$_SERVER['HTTP_HOST']);
    $http_host = str_replace(".com","",$_SERVER['HTTP_HOST']);
    $http_host = str_replace(".co","",$_SERVER['HTTP_HOST']);
    $pos = mb_strpos($http_host, '.');
    $subdomain = '';

    if ($pos) {
        $subdomain = mb_substr($http_host, 0, $pos);
    }
    //var_dump($subdomain);exit();
    if( $subdomain ){
        if ( in_array( $subdomain, \Config::get("app.empresas") ) ){
            return $next($request);
        }else{
            return new Response(view('empresa_no_registrada'));
        }
        return $next($request);
    }
    return $next($request);
    return new Response(view('empresa_no_registrada'));
    }
}
