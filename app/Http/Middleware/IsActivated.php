<?php

namespace App\Http\Middleware;
use App\User;
use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Response;

class IsActivated
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
        if ($request->user()->ativo == 1 ){
            return $next($request);
        }

        $error = "Conta não está activada!'";
        return Response::make(view('welcome', compact('error')), 403);
        //return redirect('/home');
        
    }
}
