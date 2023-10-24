<?php

namespace Src\BlendedConcept\StoryBook\Domain\Policies;

class BookReviewPolicy
{
    public static function view()
    {
        return auth()->user()->hasPermission('access_bookReview');
    }
    public static function show()
    {
        return auth()->user()->hasPermission('show_bookReview');
    }
    public static function create()
    {
        return auth()->user()->hasPermission('create_bookReview');
    }

    public static function store()
    {
        return auth()->user()->hasPermission('create_bookReview');
    }

    public static function edit()
    {
        return auth()->user()->hasPermission('edit_bookReview');
    }

    public static function update()
    {
        return auth()->user()->hasPermission('edit_bookReview');
    }

    public static function destroy()
    {
        return auth()->user()->hasPermission('delete_bookReview');
    }
}
