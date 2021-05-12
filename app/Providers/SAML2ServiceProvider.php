<?php

namespace App\Providers;

use Aacotroneo\Saml2\Events\Saml2LogoutEvent;
use Aacotroneo\Saml2\Saml2Auth;
use OneLogin\Saml2\LogoutRequest;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;

class SAML2ServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //LOGOUTEVENT LISTENER
		Event::listen('Aacotroneo\Saml2\Events\Saml2LogoutEvent', function ($event) {
            $auth=Saml2Auth::loadOneLoginAuthFromIpdConfig($event->getSaml2Idp());
            $logoutRequest  = new LogoutRequest($auth->getSettings(), $_GET['SAMLRequest']);
            $lastRequest    = $logoutRequest->getXML();
            $sso_user_id    = $logoutRequest->getNameId($lastRequest,$auth->getSettings()->getSPkey());
            $user           = User::where('sso_user_id', $sso_user_id)->first();
            $user->logout   = true;
            $user->save();
            //Log::info('SAML2 LOGOUT EVENT');
            //Log::info('User loggedout '.$user->email);
        });
         //LOGINEVENT LISTENER
		Event::listen('Aacotroneo\Saml2\Events\Saml2LoginEvent', function (\Aacotroneo\Saml2\Events\Saml2LoginEvent $event) {
            $messageId = $event->getSaml2Auth()->getLastMessageId();
            $user = $event->getSaml2User();
            $userData = [
                'id' => $user->getUserId(),
                'attributes' => $user->getAttributes(),
                'assertion' => $user->getRawSamlAssertion()
            ];
            $inputs = [
                        'sso_user_id'  => $user->getUserId(),
                        'username'     => $user->getAttribute('http://schemas.xmlsoap.org/ws/2005/05/identity/claims/name'),
                        'email'        => $user->getAttribute('http://schemas.xmlsoap.org/ws/2005/05/identity/claims/name'),
                        'first_name'   => $user->getAttribute('http://schemas.microsoft.com/identity/claims/displayname'),
                        'last_name'    => $user->getAttribute('http://schemas.microsoft.com/identity/claims/displayname'),
                        'password'     => Hash::make('anything'),
                    ];
            $user = User::where('email', $inputs['email'][0])->first();//User::where('sso_user_id', $inputs['sso_user_id'])->where('email', $inputs['email'][0])->first();
            if(!$user){
                $user =  User::create([
                    'name' => $inputs['username'][0],
                    'sso_user_id'=>$inputs['sso_user_id'],
                    'email' => $inputs['email'][0],
                    'password' => $inputs['password'],
                ]);
                Auth::login($user);
                Log::info('SAML2 NEW USER WAS CREATED');
            }elseif($user->sso_user_id==null || $user->sso_user_id==''){
                $user->sso_user_id  =   $inputs['sso_user_id'];
                $user->save();
                Auth::login($user);
            }elseif(strcmp($user->sso_user_id,$inputs['sso_user_id'])===0){
                Auth::login($user);
            }
            if(Auth::check())
            {
                $user->logout=false;
                $user->save();
                Session::save();
                return Redirect::to('home');
            }
            return Redirect::to('login');
        });
    }
}
