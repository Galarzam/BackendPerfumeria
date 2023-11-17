<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    //public function handle(Request $request, Closure $next): Response
    //{
    //    //Url a la que se le dará acceso en las peticiones
    //    ->header("Access-Control-Allow-Origin", "http://urlfronted.example")
    //    //Métodos que a los que se da acceso
    //    ->header("Access-Control-Allow-Methods", "GET, POST, PUT, DELETE")
    //    //Headers de la petición
    //    ->header("Access-Control-Allow-Headers", "X-Requested-With, Content-Type, X-Token-Auth, Authorization"); 
    //}


  //public function handle($request, Closure $next)
  //{
  //  return $next($request)
  //     //Url a la que se le dará acceso en las peticiones
  //    ->header("Access-Control-Allow-Origin", " *")
  //    //Métodos que a los que se da acceso
  //    ->header("Access-Control-Allow-Methods", "GET, POST, PUT, DELETE")
  //    //Headers de la petición
  //    ->header("Access-Control-Allow-Headers", "Accept, Authorization, Content-Type"); 
  //}

  public function handle($request, Closure $next)
    {
      //Basicamente con esto configura que origenes, y que peticiones son aceptadas
      
      return $next($request)
      //Url a la que se le dará acceso en las peticiones, puedes poner un  "*" para aceptar todas los origenes
      ->header("Access-Control-Allow-Origin", "*")
      //Métodos que a los que se da acceso, agregas los que necesites 
      ->header("Access-Control-Allow-Methods", "GET, POST, PUT, DELETE")
      //Headers de la petición
      ->header("Access-Control-Allow-Headers", "X-Requested-With, Content-Type, X-Token-Auth, Authorization"); 
    }
}
