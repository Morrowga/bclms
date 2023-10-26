<?php

namespace Src\BlendedConcept\Library\Presentation\HTTP;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Src\Common\Infrastructure\Laravel\Controller;
use Src\BlendedConcept\Library\Application\Requests\CheckStorageRequest;
use Src\BlendedConcept\Library\Application\Requests\StoreResourceRequest;
use Src\BlendedConcept\Library\Application\UseCases\Queries\GetResources;
use Src\BlendedConcept\Library\Application\Requests\UpdateResourceRequest;
use Src\BlendedConcept\Library\Application\UseCases\Queries\GetResourceStorage;
use Src\BlendedConcept\Library\Infrastructure\EloquentModels\MediaEloquentModel;
use Src\BlendedConcept\Library\Application\UseCases\Commands\StoreResourceCommand;
use Src\BlendedConcept\Library\Application\UseCases\Queries\GetRequestPublishData;
use Src\BlendedConcept\Library\Application\UseCases\Commands\DeleteResourceCommand;
use Src\BlendedConcept\Library\Application\UseCases\Commands\ResourceActionCommand;
use Src\BlendedConcept\Library\Application\UseCases\Commands\UpdateResourceCommand;
use Src\BlendedConcept\Library\Application\UseCases\Commands\RequestPublishResourceCommand;
use Src\BlendedConcept\Library\Application\Policies\ResourcePolicy;

class ResourceController extends Controller
{
    public function index()
    {
        abort_if(authorize('view', ResourcePolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {
            $resources = (new GetResources(auth()->user()))->handle();
            $resourceStorage = (new GetResourceStorage(auth()->user()))->handle();

            if (auth()->user()->organisation_id) {

                $requestPublishData = (new GetRequestPublishData(auth()->user()))->handle();
                return Inertia::render(config('route.resource.index'), [
                    "resources" => $resources,
                    "resourceStorage" => $resourceStorage,
                    "requestPublishData" => $requestPublishData
                ]);
            }

            return Inertia::render(config('route.resource.index'), [
                "resources" => $resources,
                "resourceStorage" => $resourceStorage,
            ]);
        } catch (\Exception $e) {
            dd($e);
            dd($e->getMessage());

            return redirect()->route('resource.index')->with('sytemErrorMessage', $e->getMessage());
        }
    }

    /**
     * This function stores a new resource.
     *
     * @param  StoreResourceRequest  $request The request object
     * @return \Illuminate\Http\RedirectResponse The redirect response
     */
    public function store(StoreResourceRequest $request)
    {
        abort_if(authorize('store', ResourcePolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {
            // Validate the request data
            $request->validated();

            $storeResourceCommand = (new StoreResourceCommand($request, auth()->user()));
            $storeResourceCommand->execute();

            return redirect()->route('resource.index')->with('successMessage', 'Resource Created Successfully!');
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
    public function update(UpdateResourceRequest $request, MediaEloquentModel $resource)
    {
        abort_if(authorize('update', ResourcePolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {
            // Validate the request data
            $request->validated();

            $updateResourceCommand = (new UpdateResourceCommand($request, auth()->user(), $resource));
            $updateResourceCommand->execute();

            return redirect()->route('resource.index')->with('successMessage', 'Resource Updated Successfully!');
        } catch (\Exception $error) {
            return redirect()
                ->route('resource.index')
                ->with([
                    'systemErrorMessage' => $error->getCode(),
                ]);
        }
    }

    /**
     * Delete an resource.
     *
     * @param  UserEloquentModel  $playlist The playlist to delete.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(MediaEloquentModel $resource)
    {
        abort_if(authorize('destroy', ResourcePolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        /**
         * Try to delete the playlist.
         */
        try {
            $resourceDestroy = new DeleteResourceCommand($resource);
            $resourceDestroy->execute();

            return redirect()->route('resource.index')->with('successMessage', 'Resource deleted Successfully!');
        } catch (\Exception $e) {
            /**
             * Catch any exceptions and display an error message.
             */
            return redirect()->route('resource.index')->with('systemErrorMessage', $e->getMessage());
        }
    }

    public function requestPublish(MediaEloquentModel $resource)
    {
        try {
            $resourcePublish = new RequestPublishResourceCommand($resource);
            $resourcePublish->execute();

            return redirect()->route('resource.index')->with('successMessage', 'Resource requested Successfully!');
        } catch (\Exception $e) {
            /**
             * Catch any exceptions and display an error message.
             */
            return redirect()->route('resource.index')->with('systemErrorMessage', $e->getMessage());
        }
    }

    //Apprve resource
    public function resourceApprove(CheckStorageRequest $request)
    {
        try {
            $resourceApprove = new ResourceActionCommand($request);
            $resourceApprove->execute();

            return redirect()->route('resource.index')->with('successMessage', 'Resource approved Successfully!');
        } catch (\Exception $e) {
            /**
             * Catch any exceptions and display an error message.
             */
            return redirect()->route('resource.index')->with('systemErrorMessage', $e->getMessage());
        }
    }

    //Decline resource
    public function resourceDecline(Request $request)
    {
        try {
            $resourceDecline = new ResourceActionCommand($request);
            $resourceDecline->execute();

            return redirect()->route('resource.index')->with('successMessage', 'Resource declined Successfully!');
        } catch (\Exception $e) {
            /**
             * Catch any exceptions and display an error message.
             */
            return redirect()->route('resource.index')->with('systemErrorMessage', $e->getMessage());
        }
    }

    //Decline resource
    public function resourceMultipleDelete(Request $request)
    {
        try {
            $resourceDecline = new ResourceActionCommand($request);
            $resourceDecline->execute();

            return redirect()->route('resource.index')->with('successMessage', 'Resource deleted Successfully!');
        } catch (\Exception $e) {
            /**
             * Catch any exceptions and display an error message.
             */
            return redirect()->route('resource.index')->with('systemErrorMessage', $e->getMessage());
        }
    }
}
