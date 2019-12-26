<?php
namespace App\Http\Middleware;
use Auth;
use Closure;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
class jwt_auth extends BaseMiddleware
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
            if ($user) {
                $request['user'] = $user;
                $request['user_id'] = $user->user_id;
                $request['account'] = $user->account;
                return $next($request);
            }
            return response()->json(['未登入'], 400, [], JSON_UNESCAPED_UNICODE);
        } catch (JWTException $exception) {
            return response()->json(['未登入'], 400, [], JSON_UNESCAPED_UNICODE);
        }
    }
}