<?php

namespace Src\BlendedConcept\Library\Presentation\HTTP;

use Inertia\Inertia;
use Src\Common\Infrastructure\Laravel\Controller;

class ResourceController extends Controller
{
    public function index()
    {

        // Check if the user is authorized to view classrooms

        // abort_if(authorize('view', ClassRoomPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {
            return Inertia::render(config('route.resource'));
        } catch (\Exception $e) {
            dd($e->getMessage());

            return redirect()->route('c.classrooms.index')->with('sytemErrorMessage', $e->getMessage());
        }
    }

}
