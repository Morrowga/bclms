<?php

namespace Src\BlendedConcept\System\Application\Policies;




class AnnouncementPolicy
{

    public function view()
    {
        return auth()->user()->hasPermission('access_announcement');
    }

    public function create()
    {
        return auth()->user()->hasPermission('create_announcement');
    }
    public function store()
    {
        return auth()->user()->hasPermission('create_announcement');
    }
    public function edit()
    {
        return auth()->user()->hasPermission('edit_announcement');
    }

    public function update()
    {
        return auth()->user()->hasPermission('edit_announcement');
    }

    public function destroy()
    {
        return auth()->user()->hasPermission('delete_announcement');
    }
}
