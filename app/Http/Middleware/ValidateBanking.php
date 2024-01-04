<?php

namespace App\Http\Middleware;

use App\Models\Contract;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ValidateBanking
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $contract = Contract::where("user_id", Auth::user()->id)->first() ;

        if(!$contract) {
            return redirect('/contract') ;
        } else {
            if($contract->status!='A') {
                return redirect('/contract') ;
            }
        }

        return $next($request);
    }
}
