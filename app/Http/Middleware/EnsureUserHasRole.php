<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class EnsureUserHasRole 
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {   
        $user = $request->user();
        abort_if(! $user, 401);
        abort_unless(in_array($user->role, $roles, true), 403, 'Akses ditolak.');

        return $next($request);
    }
}


?>