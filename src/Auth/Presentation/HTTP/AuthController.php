<?php

namespace Src\Auth\Presentation\HTTP;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

use Src\BlendedConcept\User\Domain\Model\User;

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

    // login page render
    public function loginPage()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return Inertia::render('Auth/Presentation/Resources/Login');
    }

    //login
    public function login(StoreLoginRequest $request)
    {



        $request->session()->put('item',true);
        dd($request->session()->get('item'));
        $IsAuthnicated = $this->authInterface->login($request);

        // check if your correct creditional or not

        if ($IsAuthnicated['isCheck']) {
            return redirect()->route('dashboard');
        } else {
            return Inertia::render('Auth/Presentation/Resources/Login')->with("errorMessage", $IsAuthnicated['errorMessage']);
        }
    }

    public function logout()
    {
        Auth::logout();
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
        $this->authInterface->b2cRegister($request);
        return redirect()->route('verify');
    }
    // verifing email
    public function verification(Request $request)
    {
        $id = $request->id;
        $user = $this->authInterface->verification($id);
        return Inertia::render('Auth/Presentation/Resources/Verify', [
            "verified" => true
        ])->with("successMessage", "Email verify successfully!");
    }
}
