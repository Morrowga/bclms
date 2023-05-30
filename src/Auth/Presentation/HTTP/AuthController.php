<?php

namespace Src\Auth\Presentation\HTTP;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Src\Common\Infrastructure\Laravel\Controller;
use Src\Auth\Application\Requests\StoreRegisterRequest;
use Src\Auth\Domain\Repositories\AuthRepositoryInterface;
use Src\Auth\Application\Requests\StoreLoginRequest;

class AuthController extends Controller
{
    protected $authInterface;
    public function __construct(AuthRepositoryInterface $authInterface)
    {
        $this->authInterface = $authInterface;
    }

    /**
     * Display the login page.
     *
     * This method is responsible for rendering the login page for users who are not authenticated.
     * If the user is already authenticated, they will be redirected to the dashboard page.
     *
     * @return \Illuminate\Http\RedirectResponse|\Inertia\Response
     */
    public function loginPage()
    {
        try {
            // Check if the user is already authenticated
            if (Auth::check()) {
                // Redirect the authenticated user to the dashboard page
                return redirect()->route('dashboard');
            }

            // Render the login page using the Inertia.js framework
            return Inertia::render('Auth/Presentation/Resources/Login');
        } catch (\Exception $exception) {
            return Inertia::render('Auth/Presentation/Resources/Login', [
                'sytemErrorMessage' => $exception->getMessage(),
            ]);
        }
    }

    /**
     * Handle the login request.
     *
     * This method is responsible for processing the login request and authenticating the user.
     * If the authentication is successful, the user will be redirected to the dashboard page.
     * If the authentication fails, the user will be shown the login page with an error message.
     *
     * @param  \Src\Auth\Domain\Requests\StoreRegisterRequest  $request  The incoming login request.
     * @return \Illuminate\Http\RedirectResponse|\Inertia\Response  A redirect response or an Inertia.js response.
     */
    public function login(StoreLoginRequest $request)
    {
        try {
            // Call the login method on the auth interface to authenticate the user
            $isAuthenticated = $this->authInterface->login($request);

            // Set the session for page builder access (requires 'phpb_logged_in' session)
            $request->session()->put('phpb_logged_in', true);

            // Check if the authentication was successful
            if ($isAuthenticated['isCheck']) {
                // Redirect the authenticated user to the dashboard page
                return redirect()->route('dashboard');
            } else {
                // Render the login page with an error message
                return Inertia::render('Auth/Presentation/Resources/Login')->with("errorMessage", $isAuthenticated['errorMessage']);
            }
        } catch (\Exception $e) {

            // Handle the exception gracefully, such as displaying a generic error message
            return Inertia::render('Auth/Presentation/Resources/Login')->with("sytemErrorMessage", $e->getMessage());
        }
    }

    /**
     * Log out the authenticated user.
     *
     * This route is responsible for logging out the currently authenticated user.
     * It clears the session for 'phpb_logged_in' to ensure page builder access is revoked.
     * After logging out, the user is redirected to the login page.
     *
     * @return \Illuminate\Http\RedirectResponse|string  A redirect response to the login page.
     */
    public function logout()
    {

        try {
            // Log out the authenticated user
            Auth::logout();

            // Remove the 'phpb_logged_in' session to revoke page builder access
            session()->remove('phpb_logged_in');

            // Redirect the user to the login page
            return redirect()->route('login');
        } catch (\Exception $error) {
            return $error->getMessage();
        }
    }



    /**
     * Render the verification page.
     *
     * This method is responsible for rendering the verification page.
     *
     * @return \Inertia\Response  An Inertia.js response containing the verification page.
     */
    public function verify()
    {
        try {
            return Inertia::render('Auth/Presentation/Resources/Verify');
        } catch (\Exception $e) {
            // Handle the exception gracefully, such as displaying a generic error page
            return Inertia::render('Auth/Presentation/Resources/Verify')
                ->with("sytemErrorMessage", $e->getMessage());
        }
    }

    /**
     * Render the registration page.
     *
     * This method is responsible for rendering the registration page.
     * If the user is already authenticated, they will be redirected to the dashboard page.
     *
     * @return \Illuminate\Http\RedirectResponse|\Inertia\Response  A redirect response to the dashboard or an Inertia.js response containing the registration page.
     */
    public function register()
    {
        try {
            // Check if the user is already authenticated
            if (Auth::check()) {
                // Redirect the authenticated user to the dashboard page
                return redirect()->route('dashboard');
            }

            // Render the registration page using the Inertia.js framework
            return Inertia::render('Auth/Presentation/Resources/Register');
        } catch (\Exception $e) {
            // Handle the exception gracefully, such as displaying a generic error page
            return Inertia::render('Auth/Presentation/Resources/Register')->with("sytemErrorMessage", $e->getMessage());
        }
    }

    // store b2c register user
    public function B2CStore(StoreRegisterRequest $request)
    {
        try {
            $this->authInterface->b2cRegister($request);
            return redirect()->route('verify');
        } catch (\Exception $errors) {


            return Inertia::render('Auth/Presentation/Resources/Register', [
                "sytemErrorMessage" => $errors->getMessage()
            ]);
        }
    }

    /**
     * Verify user email.
     *
     * This methods is responsible for verifying the user's email address based on the provided ID.
     * It retrieves the user from the authentication interface using the ID and renders the verification page with a success message if the verification is successful.
     * If the user is not found (indicating an unauthorized action, such as manually changing the token ID), it returns a 403 error.
     *
     * @param  \Illuminate\Http\Request  $request  The incoming request containing the verification ID.
     * @return \Inertia\Response|\Symfony\Component\HttpFoundation\Response  An Inertia.js response containing the verification page with a success message, or a 403 error response.
     */
    public function verification(Request $request)
    {
        try {
            // Get the verification ID from the request
            $id = $request->id;

            // Call the verification method on the auth interface to verify the user's email
            $user = $this->authInterface->verification($id);

            if ($user !== null) {
                // Render the verification page with a success message
                return Inertia::render('Auth/Presentation/Resources/Verify', [
                    "verified" => true
                ])->with("successMessage", "Email verified successfully!");
            } else {
                // User manually changed the token ID, return a 403 error
                return abort(403, 'Unauthorized action.');
            }
        } catch (\Exception $e) {
            // Handle the exception gracefully, such as displaying a generic error page
            return Inertia::render('Auth/Presentation/Resources/Verify')->with("sytemErrorMessage", $e->getMessage());
        }
    }

    /**
     * Render the user profile page.
     *
     * This method is responsible for rendering the user profile page.
     *
     * @return \Inertia\Response  An Inertia.js response containing the user profile page.
     */
    public function userProfile()
    {
        try {
            return Inertia::render('Auth/Presentation/Resources/UserProfile');
        } catch (\Exception $e) {


            // Handle the exception gracefully, such as displaying a generic error page
            return Inertia::render('BlendedConcept/Auth/Presentation/Resources/UserProfile')->with("sytemErrorMessage", $e->getMessage());
        }
    }
}
