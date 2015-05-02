<?php namespace App\Modules\Admin\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Former;

class AuthController extends Controller
{
    protected $redirectRoute = 'admin.person.index';
    protected $redirectRouteAfterLogout = 'admin.get.login';

    public function __construct()
    {
        $this->setConfig('admin.auth');
        view()->share('auth', true);
    }

    protected function setConfig($module)
    {
        $this->config = config($module);
        view()->share('config', $this->config);
        $moduleConfig = config($module . '.module');
        if ($moduleConfig) {
            foreach ($moduleConfig as $key => $value) {
                $this->$key = $value;
                view()->share($key, $value);
            }
        }
    }

    /**
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogin()
    {
        $validationRules = array(
            'email' => 'required|email',
            'password' => 'required',
        );

        return view('admin::auth.login', compact('validationRules'));
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->has('remember'))) {
            msg('You have successfully logged in.');
            return redirect()->intended($this->redirectPath());
        }

        msg('These credentials do not match our records.', 'danger');
        return redirect()->route('admin.get.login')->withInput();
    }

    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {
        if (property_exists($this, 'redirectRoute')) {
            return route($this->redirectRoute);
        }

        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/home';
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogout()
    {
        Auth::logout();

        if (Auth::check()) {
            msg('Whoops, looks like something went wrong, you are still logged in.', 'danger');
        } else {
            msg('You have successfully logged out.');
        }

        return redirect(property_exists($this, 'redirectRouteAfterLogout') ? route($this->redirectRouteAfterLogout) : '/');
    }


}