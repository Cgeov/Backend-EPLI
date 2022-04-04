<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ValidateAction
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        $action = $request->route('detailaction');

        $detailservice = $request->route('detailservice');

        $category = $request->route('category');

        if(!is_null($action) && !is_null($detailservice)){
            switch ($action){
                case 'add':
                    return $next($request);
                    break;
                case 'list':
                    return $next($request);
                    break;
                case 'edit':
                    return $next($request);
                    break;
                default:
                    return redirect('/dashboard');
                    break;
            }
        }else {
            return redirect('/dashboard');
        }
    }
}
