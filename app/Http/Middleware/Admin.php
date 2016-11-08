<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class Admin
{
    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->auth->check()) {
            if ($this->auth->user()->role == config('user.role.admin')) {
                return $next($request);
            } else {
                $this->auth->logout();

                return redirect()
                    ->route('admin.getLogin')
                    ->withErrors(trans('admin.not_the_admin'));
            }
        } else {
            return redirect()->route('admin.getLogin');
        }

        return $next($request);
    }
}
