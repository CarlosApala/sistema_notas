<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SetDbContext
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
{
    if (auth()->check()) {
        $usuario = auth()->user()->username;
        $ip = $request->ip();

        // Escapar para SQL
        $usuario = str_replace("'", "''", $usuario);
        $ip = str_replace("'", "''", $ip);

        DB::statement("SET app.current_user_id = '{$usuario}'");
        DB::statement("SET app.client_ip = '{$ip}'");
    }

    return $next($request);
}

}
