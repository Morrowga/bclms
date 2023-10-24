<?php

namespace Src\BlendedConcept\StoryBook\Domain\Policies;

class BookPolicy
{
    public static function view()
    {
        return auth()->user()->hasPermission('access_book');
    }
    public static function show()
    {
        return auth()->user()->hasPermission('show_book');
    }
    public static function create()
    {
        return auth()->user()->hasPermission('create_book');
    }

    public static function store()
    {
        return auth()->user()->hasPermission('create_book');
    }

    public static function edit()
    {
        return auth()->user()->hasPermission('edit_book');
    }

    public static function update()
    {
        return auth()->user()->hasPermission('edit_book');
    }

    public static function destroy()
    {
        return auth()->user()->hasPermission('delete_book');
    }
}
