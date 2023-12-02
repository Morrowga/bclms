<?php

namespace Src\Common\Infrastructure\Laravel\Middleware;

use Inertia\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Src\BlendedConcept\Security\Domain\Resources\AuthResource;
use Src\BlendedConcept\System\Application\UseCases\Queries\GetUserSurveyByRole;
use Src\BlendedConcept\System\Infrastructure\EloquentModels\SiteSettingEloquentModel;
use Src\BlendedConcept\System\Infrastructure\EloquentModels\SystemThemeEloquentModel;

class HandleInertiaRequest extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'flash' => [
                'successMessage' => fn () => $request->session()->get('successMessage'),
                'errorMessage' => fn () => $request->session()->get('errorMessage'),
            ],
            'tenant' => tenant('id') ? 'c.' : '',
            'user_info' => [
                'user_detail' => Auth::check() == true ? Auth::user() : ' ',
                'user_role' => Auth::check() == true ? Auth::user()->role : ' ',
            ],
            'user_survey_logout' => Auth::check() == true ? (new GetUserSurveyByRole('LOG_OUT', null))->handle() : '',
            'notifications' => getNotifications() != null ? getNotifications()['notifications'] : null,
            'unreadNotificationsCount' => getNotifications() != null ? getNotifications()['unread'] : 0,
            'auth' => auth()->check() ? new AuthResource(auth()->user()) : '',
            'site_settings' => SiteSettingEloquentModel::find(1) ?? '',
            'system_themes' => SystemThemeEloquentModel::first() ?? '',
            'route_site_url' => env("APP_URL"),
            // 'site_logo' => SiteSettingEloquentModel::find(1)->getFirstMedia('site_logo')->original_url ?? '',
            // 'fav_icon' => SiteSettingEloquentModel::find(1)->getFirstMedia('fav_icon')->original_url ?? '',
            // import error handling as csv format
            'export_errors' => fn () => $request->session()->get('export_errors') ?? null,

        ]);
    }
}
