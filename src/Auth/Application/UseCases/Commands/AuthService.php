<?php

namespace Src\Auth\Application\UseCases\Commands;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Src\Auth\Application\Requests\StoreLoginRequest;
use Src\Auth\Domain\Mail\VerifyEmail;
use Src\Auth\Domain\Repositories\AuthRepositoryInterface;
use Src\BlendedConcept\Organisation\Infrastructure\EloquentModels\OrganisationEloquentModel;
use Src\Common\Infrastructure\Laravel\Notifications\BcNotification;

class AuthService
{
    private AuthRepositoryInterface $repository;

    public function __construct()
    {
        $this->repository = app()->make(AuthRepositoryInterface::class);
    }

    public function Login(StoreLoginRequest $request)
    {
        $user = $this->repository->login($request);

        /***
         *  first thing here check user exists or not
         *  then check email is verified or not if verified then go another step
         *  auth attempt if email verified then sent notification inside dashboard
         *  if incorrect email and password get invalid message
         */
        // setcookie('h5p_id', 111, time() + (86400 * 30), "/");


        if ($user) {
            setcookie("h5p_id", "", time() - 3600, "/");
            if ($user->organisation_id) {
                $organisation = OrganisationEloquentModel::find($user->organisation_id);
                if (!$organisation) {
                    $error = 'Organisation is deleted';
                    return ['errorMessage' => $error, 'isCheck' => false];
                }
                if ($organisation->status == 'INACTIVE') {
                    $error = 'Organisation is inactive';
                    return ['errorMessage' => $error, 'isCheck' => false];
                }
            }
            //this check verify email or not
            if ($user->role_id != 6) {
                if (!$user->email_verification_send_on) {
                    $error = 'Please Verify your email';

                    return ['errorMessage' => $error, 'isCheck' => false];
                }
            }



            if ($user->parents) {

                $login_user = $user->parents;
                if ($login_user->type == 'B2B') {
                    $error = 'Invalid Login Credential';

                    return ['errorMessage' => $error, 'isCheck' => false];
                }
            } elseif ($user->b2bUser) {
                $login_user = $user->b2bUser;
            } else {
                $login_user = null;
            }
            if ($login_user) {
                if ($login_user->subscription) {
                    if ($login_user->subscription->b2c_subscription) {
                        $plan = $login_user->subscription->b2c_subscription;
                        if ($plan->plan_id != 1) {
                            $start_date = Carbon::parse($login_user->subscription->start_date);
                            $end_date = Carbon::parse($login_user->subscription->end_date);
                            $current_date = Carbon::now();

                            if ($current_date->gt($end_date)) {
                                $error = 'Subscription is expired';
                                return ['errorMessage' => $error, 'isCheck' => false];
                            }
                        }
                    } elseif (!$login_user->subscription->stripe_status || $login_user->subscription->stripe_status == "INACTIVE") {
                        $error = 'Subscription is inactive';
                        return ['errorMessage' => $error, 'isCheck' => false];
                    }
                }
            }
            if (auth()->attempt([
                'email' => request('email'),
                'password' => request('password'),
            ])) {
                // $user->notify(new BcNotification(['message' => 'Welcome ' . $user->name . ' !', 'from' => '', 'to' => '', 'icon' =>  'mdi-human-greeting', 'type' => 'success']));

                return ['errorMessage' => 'Successfully', 'isCheck' => true];
            } elseif (auth()->attempt([
                'username' => request('email'),
                'password' => request('password')
            ])) {
                setcookie("kidmode", false, time() + (86400 * 30), "/");
                return ['errorMessage' => 'Successfully', 'isCheck' => true];
            } else {
                $error = 'Invalid Login Credential';

                return ['errorMessage' => $error, 'isCheck' => false];
            }
        }

        // if not fail log in
        else {

            $error = 'Invalid Login Credential';

            return ['errorMessage' => $error, 'isCheck' => false];
        }
    }

    /***i
     *  this is logout function that logout user and remove session
     *  from page builder for not accessiable for users
     *  @params null
     *  @return void
     */
    public function Logout()
    {
        // Logout the authenticated user
        Auth::logout();

        // Remove the 'phpb_logged_in' session to revoke page builder access
        session()->remove('phpb_logged_in');
    }

    public function registerB2CUser($register)
    {
        $user = $this->repository->b2cRegister($register);
        Mail::to(request('email'))->send(new VerifyEmail($user));
    }
}
