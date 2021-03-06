<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class AuthenticateAdmin
{

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        session_start();
        if ($this->auth->guest()) {
            $_SESSION['isAdmin'] = false;
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest(route('admin.get.login'));
            }
        }

        if ($this->auth->admin()) {
            $_SESSION['isAdmin'] = true;
            return $next($request);
        } else {
            msg('Unauthorized.', 'info');
            return redirect()->guest(route('admin.get.login'));
        }
    }

}
