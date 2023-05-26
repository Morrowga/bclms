<?php

namespace Src\BlendedConcept\System\Domain\Policies;


class OrganizationPolicy
{
    public function view()
    {
        return auth()->user()->hasPermission('access_organization');
    }

    public function create()
    {
        return auth()->user()->hasPermission('create_organization');
    }
    public function store()
    {
        return auth()->user()->hasPermission('create_organization');
    }
    public function edit()
    {
        return auth()->user()->hasPermission('edit_organization');
    }

    public function update()
    {
        return auth()->user()->hasPermission('edit_organization');
    }

    public function destroy()
    {
        return auth()->user()->hasPermission('delete_organization');
    }
}
