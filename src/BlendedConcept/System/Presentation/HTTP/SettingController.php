<?php

namespace Src\BlendedConcept\System\Presentation\HTTP;

use Src\BlendedConcept\System\Application\UseCases\Queries\GetSiteSetting;
use Src\Common\Infrastructure\Laravel\Controller;
use Inertia\Inertia;
use Src\BlendedConcept\System\Infrastructure\EloquentModels\SiteSettingEloquentModel;
use Src\BlendedConcept\System\Application\DTO\SiteSettingData;
use Src\BlendedConcept\System\Application\Policies\SettingPolicy;
use Src\BlendedConcept\System\Application\UseCases\Commands\UpdateSiteSettingCommand;
use Src\BlendedConcept\System\Application\Requests\UpdateSettingRequest;
use Symfony\Component\HttpFoundation\Response;

class SettingController extends Controller
{



    /**
     * Display the site settings index page.
     *
     * @return \Illuminate\Http\RedirectResponse|\Inertia\Response
     */
    public function index()
    {
        // Authorize the user to view the site settings
        abort_if(authorize('view', SettingPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {


            // Retrieve the site setting
            $setting = (new GetSiteSetting())->handle();

            // Render the inertia view with the site setting data
            return Inertia::render(config('route.settings'), compact('setting'));
        } catch (\Exception $e) {
            // Handle any exceptions that occur during the execution of the code
            return Inertia::render(config('route.settings'))->with('systemErrorMessage', $e->getMessage());
        }
    }


    /**
     * Update the site setting.
     *
     * @param UpdateSettingRequest $request
     * @return
     */
    public function UpdateSetting(UpdateSettingRequest $request)
    {

        try {
            // Create a SiteSettingData instance from the request
            $site_setting = SiteSettingData::fromRequest($request);

            // Create an UpdateSiteSettingCommand instance with the site setting
            $update_setting = new UpdateSiteSettingCommand($site_setting);

            // Execute the update setting command
            $update_setting->execute();
        } catch (\Exception $e) {
            // Return a response indicating the error to the user
            dd($e->getMessage());
        }
    }
}