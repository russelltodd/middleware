<?php namespace App\Http\Middleware;

use Closure;

class VerifyApiKey {

    /**
     * Handle an incoming request - verifies the API Key.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        \Log::debug(__METHOD__.'()');
        if (($key = $request->header('Authorization',false)) === false) {
            abort(403, 'Authorization header not set');
        }

        $apiKey = substr($key, strlen('apikey '));
        \Log::debug(__METHOD__.':: authorize the key '.$apiKey);
        // TODO - actually authorize it
        return $next($request);
    }

}
