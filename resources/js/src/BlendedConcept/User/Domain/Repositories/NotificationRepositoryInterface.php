<?php

namespace Src\BlendedConcept\User\Domain\Repositories;

interface NotificationRepositoryInterface
{
    // mark as read with id
    public function read($id);

    // mark as read all
    public function readAll();

    //get notification by user
    public function notifications();
}
