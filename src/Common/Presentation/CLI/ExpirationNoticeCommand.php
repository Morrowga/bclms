<?php

namespace Src\Common\Presentation\CLI;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Src\BlendedConcept\Organisation\Domain\Mail\OrganisationExpirationNotice;
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

        foreach ($organisations as $organisation) {
            $subscription = $organisation->subscription;
            $end_date = $subscription->end_date;

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
}
