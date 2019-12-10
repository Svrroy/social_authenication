<?php

namespace App\Http\Controllers\Auth;
use Socialite;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\SocialMigration;
use App\User;
use Log;
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
    protected $redirectTo = '/home';

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
     * Redirect the user to the Facbook authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProviderFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallbackFacebook()
    {
        $user = Socialite::driver('facebook')->user();

        // $user->token;
    }

    /**
     * Redirect the user to the Google authentication page.
     *
     * //@return \Illuminate\Http\Response
     */
    public function redirectToProviderGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Facebook.
     *
     * //@return \Illuminate\Http\Response
      */
    public function handleProviderCallbackGoogle()
    {
        try
        {
            $socialUser = Socialite::driver('google')->user();
        }
        catch(\Exception $e)
        {
            return redirect('/home');
        }

        // $user->token;
        $socialMigration = SocialMigration::where('provider_id',$socialUser->getId())->first();
        if(!$socialMigration)
        {
                $user = User::firstorCreate(
                        ['email'=>$socialUser->getEmail()],
                        ['name'=> $socialUser->getName()]
                );

                $user->socialMigrations()->create(
                        ['provider_id' => $socialUser->getId(), 'provider'=>'google']
                );
        }
        else
            $user = $socialMigration->user;
        
        auth() ->login($user);
        return redirect('/home');
    }
}
