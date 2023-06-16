<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    public function handle(Request $request, Closure $next, $role)
    {
        $roles = is_array($role)
            ? $role
            : explode('|', $role);

        foreach ($roles as $a) {
            if(Session('pegawai') && Session('pegawai')->id_role == $a){
                return $next($request);
                // ->withToastSuccess('You have Successfully loggedin');
            }
        }
        return redirect()->route('login')->withToastError('Anda Harus Login Terlebih dahulu');
    }
         
}
