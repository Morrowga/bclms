<?php

namespace Src\Auth\Presentation\HTTP;

use Stripe\Stripe;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Src\Auth\Application\Mails\EmailVerify;
use Src\Common\Infrastructure\Laravel\Controller;
use Src\Auth\Application\Requests\StoreLoginRequest;
use Src\Auth\Application\Requests\StoreRegisterRequest;
use Src\Auth\Application\UseCases\Commands\AuthService;
use Src\Auth\Domain\Repositories\AuthRepositoryInterface;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\PlanEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;

class AuthController extends Controller
{
    protected $authInterface;

    protected $authservices;

    public function __construct(AuthRepositoryInterface $authInterface)
    {
        $this->authInterface = $authInterface;
        $this->authservices = app()->make(AuthService::class);
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
            $tenant = tenant('id') ? 'c.' : '';
            // dd($tenant);
            // Check if the user is already authenticated
            if (Auth::check()) {
                // Redirect the authenticated user to the dashboard page
                if (tenant('id')) {
                    return redirect()->route('c.organisationaadmin');
                }

                return redirect()->route('dashboard');
            }

            // Render the login page using the Inertia.js framework
            return Inertia::render(config('route.login'), compact('tenant'));
        } catch (\Exception $exception) {
            return redirect()->route('login')->with([
                'sytemErrorMessage' => $exception->getMessage(),
            ]);
        }
    }

    public function planPage(Request $request)
    {
        try {

            // Render the login page using the Inertia.js framework
            return Inertia::render(config('route.registerplan'), [
                "sign_up_data" => $request->all()
            ]);
        } catch (\Exception $exception) {
            return redirect()->route('login')->with([
                'sytemErrorMessage' => $exception->getMessage(),
            ]);
        }
    }

    public function searchStudentCode(Request $request)
    {
        try {
           $exist = $this->authInterface->searchStudentCode($request->query('student_code'));
            return response()->json($exist);
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    public function stripePaymentInialize(Request $request)
    {
        try {
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

            $jsonObj = json_decode($request->body, true);

            // Create a PaymentIntent with amount and currency
            $paymentIntent = $stripe->paymentIntents->create([
                'amount' => 1400,
                'currency' => 'sgd',
                // In the latest version of the API, specifying the `automatic_payment_methods` parameter is optional because Stripe enables its functionality by default.
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
            ]);

            $output = [
                'clientSecret' => $paymentIntent->client_secret,
            ];

            return json_encode($output);
        } catch (Error $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
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
            /***
             *  Call the login method on the auth service to authenticate the user
             *  where we implement business logic inside this methods and we used
             *  repository that handle db data and other business logic implement
             *  inside this method
             *
             *  */

            // dd($request->all());
            $isAuthenticated = $this->authservices->login($request);

            /***
             * Set session variable to indicate page builder login status
             *
             * Replace 'phpb_logged_in' with the appropriate session variable for your page builder
             *
             */

            $request->session()->put('phpb_logged_in', true);

            // Check if the authentication was successful
            if ($isAuthenticated['isCheck']) {

                // Redirect the authenticated user to the dashboard page
                if (tenant('id')) {
                    return redirect()->route('c.organisationaadmin');
                }
                $student = json_encode(auth()->user()->student);
                setcookie('student', $student, time() + (86400 * 30), "/");
                return redirect()->route('dashboard');
            } else {
                // Render the login page with an error message
                return Inertia::render(config('route.login'), [
                    'errorMessage' => $isAuthenticated['errorMessage'],
                ]);
            }
        } catch (\Exception $e) {
            // Handle the exception gracefully, such as displaying a generic error message
            return redirect()->route('login')->with('sytemErrorMessage', $e->getMessage());
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

            $this->authservices->Logout();

            // Redirect the user to the login page
            if (tenant('id')) {
                return redirect()->route('c.login');
            }

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
    public function verify(Request $request)
    {
        try {
            $email = $request->query('auth');

            $this->authInterface->verificationEmail($email);

            return Inertia::render(config('route.verify'));
        } catch (\Exception $e) {

            // Handle the exception gracefully, such as displaying a generic error page
            return Inertia::render(config('route.verify'))
                ->with('sytemErrorMessage', $e->getMessage());
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

            $plans = PlanEloquentModel::limit(4)->get();
            // Render the registration page using the Inertia.js framework
            return Inertia::render(config('route.register'), compact('plans'));
        } catch (\Exception $e) {
            // Handle the exception gracefully, such as displaying a generic error page
            return Inertia::render(config('route.register'))->with('sytemErrorMessage', $e->getMessage());
        }
    }

    // store b2c register user
    public function B2CStore(StoreRegisterRequest $request)
    {
        try {

            // service that handle registraction
            $this->authservices->registerB2CUser($request);

            return redirect()->route('verify');
        } catch (\Exception $e) {
            dd($e->getMessage(), $e->getFile());

            return redirect()->route('register')->with('sytemErrorMessage', 'Mail configuration is wrong');
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
                return Inertia::render(config('route.verify'), [
                    'verified' => true,
                ])->with('successMessage', 'Email verified successfully!');
            } else {
                // User manually changed the token ID, return a 403 error
                return abort(403, 'Unauthorized action.');
            }
        } catch (\Exception $e) {
            // Handle the exception gracefully, such as displaying a generic error page
            return Inertia::render(config('route.verify'))->with('sytemErrorMessage', $e->getMessage());
        }
    }

    public function resend(Request $request){

        $userEloquentModel = UserEloquentModel::where('email', $request->email)->first();

        $bcstaff = UserEloquentModel::where('role_id', 3)->first();

        \Mail::to($userEloquentModel->email)->send(new EmailVerify($userEloquentModel->full_name, env('APP_URL') . '/verification?auth=' . Crypt::encrypt($userEloquentModel->email), $bcstaff->email, $bcstaff->contact_number));

        return redirect()->route('login');
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
            return Inertia::render(config('route.userprofile'));
        } catch (\Exception $e) {
            // Handle the exception gracefully, such as displaying a generic error page
            return Inertia::render(route('route.userprofile'))->with('sytemErrorMessage', $e->getMessage());
        }
    }

    public function chooseFreePlan(StoreRegisterRequest $request)
    {
        try {
            $this->authInterface->chooseFreePlan($request);
        } catch (\Exception $e) {
            return redirect()->back()->with('errorMessage', $e->getMessage());
        }
    }

    public function choosePaidPlan(StoreRegisterRequest $request)
    {
        try {
            $this->authInterface->choosePaidPlan($request);
        } catch (\Exception $e) {
            return redirect()->back()->with('errorMessage', $e->getMessage());
        }
    }

public function chooseBothPlan(Request $request)
    {
        try {
            $this->authInterface->chooseBothPlan($request->student_code);
        } catch (\Exception $e) {
            return redirect()->back()->with('errorMessage', $e->getMessage());
        }
    }
}
