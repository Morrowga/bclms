<?php

namespace Src\BlendedConcept\System\Domain\Policies;

class FileManagerPolicy
{

    public function view()
    {
        return auth()->user()->hasPermission('access_library');
    }

    public function create()
    {
        return auth()->user()->hasPermission('access_library');
    }
    public function store()
    {
        return auth()->user()->hasPermission('access_library');
    }
    public function edit()
    {
        return auth()->user()->hasPermission('access_library');
    }

    public function update()
    {
        return auth()->user()->hasPermission('access_library');
    }

    public function destroy()
    {
        return auth()->user()->hasPermission('access_library');
    }
}
