<?php

namespace Src\Auth\Application\Repositories\Eloquent;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Src\Auth\Application\Mails\EmailVerify;
use Src\Auth\Domain\Repositories\AuthRepositoryInterface;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\PlanEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\ParentEloquentModel;
use Src\BlendedConcept\Student\Infrastructure\EloquentModels\StudentEloquentModel;
use Src\BlendedConcept\Teacher\Infrastructure\EloquentModels\TeacherEloquentModel;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\SubscriptionEloquentModel;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\B2cSubscriptionEloquentModel;

class AuthRepository implements AuthRepositoryInterface
{
    //login
    public function login($request)
    {

        $user = UserEloquentModel::query()->where('email', $request->email)->first();

        return $user;
    }

    //  register b2c register
    public function b2cRegister($request)
    {

        $name = explode('@', $request->email);
        $user = UserEloquentModel::create([
            'name' => $name[0],
            'email' => $request->email,
            'password' => $request->password,
        ]);

        $user->roles()->sync([2]);

        return $user;
    }

    //verification email
    public function verification($id)
    {

        $decode_id = Crypt::decryptString($id);
        $user = UserEloquentModel::findOrFail($decode_id);
        $user->update([
            'email_verified_at' => Carbon::now(),
        ]);

        return $user;
    }

    public function chooseFreePlan($request)
    {
        DB::beginTransaction();
        try {
            $user_type = $request->user_type;
            $userEloquent = (new UserEloquentModel());
            $userEloquent->first_name = $request->first_name;
            $userEloquent->last_name = $request->last_name;
            $userEloquent->contact_number = $request->contact_number;
            $userEloquent->email = $request->email;
            $userEloquent->password = $request->password;
            $userEloquent->status = "PENDING";
            $userEloquent->role_id = $user_type == 'Teacher' ? 2 : 8;
            $userEloquent->save();

            $subscriptionEloquent = (new SubscriptionEloquentModel());
            $subscriptionEloquent->start_date = now();
            $subscriptionEloquent->payment_date = now();
            $subscriptionEloquent->payment_status = "PAID";
            $subscriptionEloquent->save();
            if ($user_type == 'Teacher') {
                $teacherEloquent = (new TeacherEloquentModel());
                $teacherEloquent->user_id = $userEloquent->id;
                $teacherEloquent->curr_subscription_id = $subscriptionEloquent->id;
                $teacherEloquent->save();

                $b2cSubEloquent = (new B2cSubscriptionEloquentModel());
                $b2cSubEloquent->subscription_id = $subscriptionEloquent->id;
                $b2cSubEloquent->teacher_id = $teacherEloquent->teacher_id;
                $b2cSubEloquent->plan_id = 1;
                $b2cSubEloquent->save();
            } else {
                $parentEloquent = (new ParentEloquentModel());
                $parentEloquent->user_id = $userEloquent->id;
                $parentEloquent->type = "B2C";
                $parentEloquent->curr_subscription_id = $subscriptionEloquent->id;
                $parentEloquent->save();

                $b2cSubEloquent = (new B2cSubscriptionEloquentModel());
                $b2cSubEloquent->subscription_id = $subscriptionEloquent->id;
                $b2cSubEloquent->parent_id = $parentEloquent->parent_id;
                $b2cSubEloquent->plan_id = 1;
                $b2cSubEloquent->save();
            }

            $bcstaff = UserEloquentModel::where('role_id', 3)->first();

            \Mail::to($userEloquent->email)->send(new EmailVerify($userEloquent->full_name, env('APP_URL') . '/verification?auth=' . Crypt::encrypt($userEloquent->email), $bcstaff->email, $bcstaff->contact_number));

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
        }
    }

    public function choosePaidPlan($request)
    {
        DB::beginTransaction();
        try {
            $user_type = $request->user_type;
            $userEloquent = (new UserEloquentModel());
            $userEloquent->first_name = $request->first_name;
            $userEloquent->last_name = $request->last_name;
            $userEloquent->contact_number = $request->contact_number;
            $userEloquent->email = $request->email;
            $userEloquent->password = $request->password;
            $userEloquent->status = "PENDING";
            $userEloquent->role_id = $user_type == 'Teacher' ? 2 : 8;
            $userEloquent->save();

            $plan = PlanEloquentModel::find($request->plan);
            $start_date = Carbon::now();
            $end_date_start = Carbon::now();
            $end_date = $plan->payment_period == 'MONTHLY' ? $end_date_start->addMonth(1) : $end_date_start->addYear(1);

            $subscriptionEloquent = (new SubscriptionEloquentModel());
            $subscriptionEloquent->start_date = $start_date;
            $subscriptionEloquent->end_date = $end_date;
            $subscriptionEloquent->payment_date = now();
            $subscriptionEloquent->stripe_status = 'ACTIVE';
            $subscriptionEloquent->stripe_price = $request->plan_price;
            $subscriptionEloquent->payment_status = "PAID";
            $subscriptionEloquent->save();

            if ($user_type == 'Teacher') {
                $teacherEloquent = (new TeacherEloquentModel());
                $teacherEloquent->user_id = $userEloquent->id;
                $teacherEloquent->curr_subscription_id = null;
                $teacherEloquent->save();

                $b2cSubEloquent = (new B2cSubscriptionEloquentModel());
                $b2cSubEloquent->subscription_id = $subscriptionEloquent->id;
                $b2cSubEloquent->teacher_id = $teacherEloquent->teacher_id;
                $b2cSubEloquent->plan_id = $request->plan;
                $b2cSubEloquent->save();
            } else {
                $parentEloquent = (new ParentEloquentModel());
                $parentEloquent->user_id = $userEloquent->id;
                $parentEloquent->type = "B2C";
                $parentEloquent->curr_subscription_id = null;
                $parentEloquent->save();

                $b2cSubEloquent = (new B2cSubscriptionEloquentModel());
                $b2cSubEloquent->subscription_id = $subscriptionEloquent->id;
                $b2cSubEloquent->parent_id = $parentEloquent->parent_id;
                $b2cSubEloquent->plan_id = $request->plan;
                $b2cSubEloquent->save();
            }

            $bcstaff = UserEloquentModel::where('role_id', 3)->first();

            \Mail::to($userEloquent->email)->send(new EmailVerify($userEloquent->full_name, env('APP_URL') . '/verification?auth=' . Crypt::encrypt($userEloquent->email), $bcstaff->email, $bcstaff->contact_number));

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
        }
    }

    public function verificationEmail($email)
    {
        $decryptedEmail = Crypt::decrypt($email);

        $userEloquent = UserEloquentModel::where('email', $decryptedEmail)->first();
        $userEloquent->update(['email_verification_send_on' => Carbon::now()]);
        $userEloquent->status = 'ACTIVE';
        $userEloquent->save();
    }

    public function searchStudentCode($studentCode)
    {
        $student = StudentEloquentModel::where('student_code', $studentCode)->first();

        if (!empty($student)) {
            return [
                "parent" => $student->parent,
                "exist" => true
            ];
        } else {
            return [
                "parent" => null,
                "exist" => false
            ];
        }
    }

    public function chooseBothPlan($request)
    {
        DB::beginTransaction();

        try {
            $student = StudentEloquentModel::where('student_code', $request->student_code)->first();

            if ($student) {
                $parent = $student->parent;
                $user = $parent->user;
                $user->update([
                    "role_id" => 9
                ]);
                $b2cSubEloquent = (new B2cSubscriptionEloquentModel());
                $b2cSubEloquent->subscription_id = $parent->subscription->id;
                $b2cSubEloquent->parent_id = $parent->parent_id;
                $b2cSubEloquent->plan_id = $request->plan;
                $b2cSubEloquent->save();
                $parent->update([
                    'type' => "BOTH"
                ]);
            }
            DB::commit();
        } catch (\Exception $ex) {
            dd($ex);
            DB::rollBack();
        }
    }
}
