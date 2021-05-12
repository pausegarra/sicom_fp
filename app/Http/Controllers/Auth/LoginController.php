<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Aacotroneo\Saml2\Saml2Auth;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Adldap\Laravel\Facades\Adldap;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use App\Services\NavisionService;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * shows the login form depending on USER AGENT
     * 
     * src: https://stackoverflow.com/questions/6322112/check-if-php-page-is-accessed-from-an-ios-device
     *
     * @return void
     */
    public function showLoginForm()
    {
        //Detect special conditions devices
        $iPod    = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
        $macOS   = stripos($_SERVER['HTTP_USER_AGENT'],"Mac");
        $iPhone  = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
        $iPad    = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
        $Android = stripos($_SERVER['HTTP_USER_AGENT'],"Android");
        $webOS   = stripos($_SERVER['HTTP_USER_AGENT'],"webOS");
        $windows = stripos($_SERVER['HTTP_USER_AGENT'],"Windows");

        //do something with this information
        if( $iPod || $iPhone || $macOS || $iPad || $windows)
        {
            //browser reported as an Apple
            return view('auth.login');
        }
        $samlAuth   =   new Saml2Auth(Saml2Auth::loadOneLoginAuthFromIpdConfig('aad'));
        return  $samlAuth->login(config('saml2_settings.loginRoute'));
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        if ($request->has('email') && $request->has('password')) {
            $ldapUser = Adldap::search()
                ->where('mail',$request->email)
                ->first();
            if ($ldapUser) {
                $username = $ldapUser->getFirstAttribute('distinguishedname');
                if (Adldap::auth()->attempt($username,$request->password)) {
                    User::updateOrcreate([
                        'email' => $request->email,
                    ],[
                        'name'     => $ldapUser->getFirstAttribute('displayname'),
                        'email'    => $request->email,
                        'password' => Hash::make($request->password),
                    ]);
                    $user = User::where('email',$request->email)
                        ->first();
                    $this->setSalesCode($user);
                    Auth::login($user);
                    return redirect('/home');
                }
            }
        }
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function logout(Request $request)
    {
         //Detect special conditions devices
         $iPod    = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
         $macOS   = stripos($_SERVER['HTTP_USER_AGENT'],"Mac");
         $iPhone  = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
         $iPad    = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
         $Android = stripos($_SERVER['HTTP_USER_AGENT'],"Android");
         $webOS   = stripos($_SERVER['HTTP_USER_AGENT'],"webOS");
         $windows = stripos($_SERVER['HTTP_USER_AGENT'],"Windows");

         //do something with this information
         if( $iPod || $iPhone || $macOS || $iPad || $windows){
            Auth::logout();
            return Redirect::to('login');
         }else{
            $samlAuth=new Saml2Auth(Saml2Auth::loadOneLoginAuthFromIpdConfig('aad'));
            return $samlAuth->logout(config('saml2_settings.logoutRoute'));
         }
    }

    private function setSalesCode($user) {
        $navService = new NavisionService();
        $navService->url = env('NAV_BASE_URL') . "Comerciales?" . http_build_query([
            '$filter' => "E_Mail eq '" . $user->email . "' and Estado eq 'Alta'",
            '$count' => 'true',
        ]);
        $data = $navService->listAll();
        if ($data['@odata.count'] > 0) {
            $user->salespersonCode()->create([
                'code' => $data[0]['value']['Code'],
            ]);
        }    
    }
}
