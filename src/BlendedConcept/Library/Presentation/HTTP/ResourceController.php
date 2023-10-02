<?php
namespace Src\BlendedConcept\Library\Presentation\HTTP;

use Inertia\Inertia;
use Src\Common\Infrastructure\Laravel\Controller;
use Src\BlendedConcept\Library\Application\Requests\StoreResourceRequest;
use Src\BlendedConcept\Library\Application\UseCases\Queries\GetResources;
use Src\BlendedConcept\Library\Application\UseCases\Commands\StoreResourceCommand;

class ResourceController extends Controller
{
    public function index(){
        try {
            $resources = (new GetResources(auth()->user()))->handle();
            return Inertia::render(config('route.resource.index'), [
                "resources" => $resources
            ]);
            // return Inertia::render(config('route.resource'));
        } catch (\Exception $e) {
            dd($e->getMessage());

            return redirect()->route('c.classrooms.index')->with('sytemErrorMessage', $e->getMessage());
        }
    }

    /**
     * This function stores a new resource.
     *
     * @param  StoreGameRequest  $request The request object
     * @return \Illuminate\Http\RedirectResponse The redirect response
     */
    public function store(StoreResourceRequest $request)
    {
        // abort_if(authorize('create', ResourcePolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {
            // Validate the request data
            $request->validated();

            $storeGameCommand = (new StoreResourceCommand($request, auth()->user()));
            $storeGameCommand->execute();

            return Inertia::render(config('route.resource.index'));

        } catch (\Exception $error) {
            return redirect()
                ->route('resource.index')
                ->with([
                    'systemErrorMessage' => $error->getCode(),
                ]);
        }
    }

    /**
     * This function stores a new resource.
     *
     * @param  UpdateResourceRequest  $request The request object
     * @return \Illuminate\Http\RedirectResponse The redirect response
     */
    public function update(StoreResourceRequest $request)
    {
        // abort_if(authorize('create', ResourcePolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {
            // Validate the request data
            $request->validated();

            $storeGameCommand = (new StoreResourceCommand($request, auth()->user()));
            $storeGameCommand->execute();

            return Inertia::render(config('route.resource.index'));

        } catch (\Exception $error) {
            return redirect()
                ->route('resource.index')
                ->with([
                    'systemErrorMessage' => $error->getCode(),
                ]);
        }
    }
}
