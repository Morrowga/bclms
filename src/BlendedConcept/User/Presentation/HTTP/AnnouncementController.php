<?php

namespace Src\BlendedConcept\User\Presentation\HTTP;

use Inertia\Inertia;
use Src\BlendedConcept\User\Domain\Repositories\AnnouncementRepositoryInterface;
use Src\Common\Infrastructure\Laravel\Controller;


class AnnouncementController extends Controller
{
     private $announcementInterface;

     public function __construct(AnnouncementRepositoryInterface $announcementInterface)
     {
          $this->announcementInterface = $announcementInterface;
     }
     public function index()
     {
          $testing = $this->announcementInterface->test();
          return $testing;
     }
}
