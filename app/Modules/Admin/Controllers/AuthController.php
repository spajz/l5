<?php namespace App\Modules\Admin\Controllers;

use Auth;
use Illuminate\Routing\Controller;

class AuthController extends Controller {

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

    public function index(){

        return view("admin::auth.login");

    }

    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    public function authenticate()
    {
        if (Auth::attempt(['email' => $email, 'password' => $password]))
        {
            return redirect()->intended('dashboard');
        }
    }

}