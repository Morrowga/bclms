<?php

namespace Src\Auth\Presentation\HTTP;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use PhpParser\Node\Stmt\TryCatch;
use Src\Common\Infrastructure\Laravel\Controller;
use Src\Auth\Domain\Requests\StoreRegisterRequest;
use Src\Auth\Domain\Repositories\AuthRepositoryInterface;
use Src\Auth\Domain\Requests\StoreLoginRequest;

class AuthController extends Controller
{
    protected $authInterface;
    public function __construct(AuthRepositoryInterface $authInterface)
    {
        $this->authInterface = $authInterface;
    }

    // login page view

    public function loginPage()
    {

        if (Auth::check()) {

            return redirect()->route('dashboard');
        }
        return Inertia::render('Auth/Presentation/Resources/Login');
    }

    public function login(StoreLoginRequest $request)
    {

        $IsAuthnicated = $this->authInterface->login($request);

        /**
         *  this below line set session for pagebuilder access that need
         *  phpb_logged_in session to access pagebuilder
         */

        $request->session()->put('phpb_logged_in', true);
        if ($IsAuthnicated['isCheck']) {
            return redirect()->route('dashboard');
        } else {
            return Inertia::render('Auth/Presentation/Resources/Login')->with("errorMessage", $IsAuthnicated['errorMessage']);
        }
    }

    public function logout()
    {
        /**
         *  if you logout you must need to clear session of
         *  phpb_logged_in thus why we set it here
         */
        Auth::logout();
        session()->remove('phpb_logged_in');
        return redirect()->route('login');
    }

    public function verify()
    {
        return Inertia::render('Auth/Presentation/Resources/Verify');
    }

    //register page render
    public function register()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return Inertia::render('Auth/Presentation/Resources/Register');
    }

    // store b2c register user
    public function B2CStore(StoreRegisterRequest $request)
    {
        try {
            $this->authInterface->b2cRegister($request);
        } catch (\Exception $errors) {


        return Inertia::render('Auth/Presentation/Resources/Register',[
            "ErrorMessage" => $errors->getCode()
        ]);

        }

        return redirect()->route('verify');
    }
    // verifing email
    public function verification(Request $request)
    {

        $id = $request->id;
        $user = $this->authInterface->verification($id);

        if($user !== null)
        {
            return Inertia::render('Auth/Presentation/Resources/Verify', [
                "verified" => true
            ])->with("successMessage", "Email verify successfully!");
        }

        else
        {
           //user manually change token id
           return abort(403, 'Unauthorized action.');
        }

    }
}
