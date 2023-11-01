<?php

namespace Src\Common\Presentation\CLI;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Src\BlendedConcept\Organisation\Domain\Mail\ParentExpirationNotice;
use Src\BlendedConcept\Organisation\Domain\Mail\TeacherExpirationNotice;
use Src\BlendedConcept\Organisation\Domain\Mail\OrganisationExpirationNotice;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\ParentUserEloquentModel;
use Src\BlendedConcept\Organisation\Infrastructure\EloquentModels\OrganisationEloquentModel;

class ExpirationNoticeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expiration:org';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $organisations = OrganisationEloquentModel::where('curr_subscription_id', '!=', null)->get();

        $now = Carbon::now()->format('Y-m-d');

        foreach ($organisations as $organisation) {
            $subscription = $organisation->subscription;
            $end_date = $subscription->end_date;

            $end_date = Carbon::parse($end_date)->format('Y-m-d');

            if ($now >= $end_date) {

                $subscription->status = 'INACTIVE';
                $subscription->save();

                Log::info("Subscription has expired for organization: {$organisation->name}");
            } else {
                $hoursUntilExpiration = Carbon::now()->diffInHours($end_date, false);


                if ($hoursUntilExpiration <= 2) {
                    $title = 'Your Subscription Expires Soon';
                    $message = 'Dear ' . $organisation->name . ', your subscription is expiring soon in ' . $hoursUntilExpiration . ' hours.';

                    Mail::to($organisation->contact_email)
                        ->send(new OrganisationExpirationNotice($organisation, $title, $message));

                    Log::info("Expiration notice sent to organization: {$organisation->name}");
                } else {
                    Log::info("Checking Expiration to : {$organisation->name}");
                }
            }
        }

        $parents = ParentUserEloquentModel::where('curr_subscription_id', '!=', null)->with(['user', 'subscription'])->get();

        foreach ($parents as $parent) {
            $subscription = $parent->subscription;
            $end_date = $subscription->end_date;

            $end_date = Carbon::parse($end_date)->format('Y-m-d');

            if ($now >= $end_date) {


                $subscription->status = 'INACTIVE';
                $subscription->save();

                Log::info("Subscription has expired for parent: {$parent->user->full_name}");
            } else {
                $hoursUntilExpiration = Carbon::now()->diffInHours($end_date, false);


                if ($hoursUntilExpiration <= 2) {
                    $title = 'Your Subscription Expires Soon';
                    $message = 'Dear ' . $parent->user->full_name . ', your subscription is expiring soon in ' . $hoursUntilExpiration . ' hours.';

                    Mail::to($parent->user->email)
                        ->send(new ParentExpirationNotice($parent, $title, $message));

                    Log::info("Expiration notice sent to parent: {$parent->user->full_name}");
                } else {
                    Log::info("Checking Expiration to : {$parent->user->full_name}");
                }
            }
        }

        $teachers = TeacherEloquentModel::where('curr_subscription_id', '!=', null)->with(['user', 'subscription'])->get();

        foreach ($teachers as $teacher) {
            $subscription = $teacher->subscription;
            $end_date = $subscription->end_date;

            $end_date = Carbon::parse($end_date)->format('Y-m-d');

            if ($now >= $end_date) {

                $subscription->status = 'INACTIVE';
                $subscription->save();

                Log::info("Subscription has expired for teacher: {$teacher->user->full_name}");
            } else {
                $hoursUntilExpiration = Carbon::now()->diffInHours($end_date, false);


                if ($hoursUntilExpiration <= 2) {
                    $title = 'Your Subscription Expires Soon';
                    $message = 'Dear ' . $teacher->user->full_name . ', your subscription is expiring soon in ' . $hoursUntilExpiration . ' hours.';

                    Mail::to($teacher->user->email)
                        ->send(new TeacherExpirationNotice($teacher, $title, $message));

                    Log::info("Expiration notice sent to teacher: {$teacher->user->full_name}");
                } else {
                    Log::info("Checking Expiration to : {$teacher->user->full_name}");
                }
            }
        }
    }
}
