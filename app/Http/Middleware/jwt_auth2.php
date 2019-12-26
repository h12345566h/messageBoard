<?php
namespace App\Http\Middleware;
use Auth;
use Closure;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
class jwt_auth2 extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $this->auth->parseToken()->authenticate();
            $user = Auth::guard()->user();
            if ($user == null) {
                unset($request['user']);
                unset($request['user_id']);
                unset($request['account']);
            } else {
                $request['user'] = $user;
                $request['user_id'] = $user->user_id;
                $request['account'] = $user->account;
            }
        } catch (JWTException $exception) {
            unset($request['user']);
            unset($request['user_id']);
            unset($request['account']);
        }
        return $next($request);
    }
}