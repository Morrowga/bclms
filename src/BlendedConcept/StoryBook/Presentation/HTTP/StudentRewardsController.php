<?php

namespace Src\BlendedConcept\StoryBook\Presentation\HTTP;

use Exception;
use Inertia\Inertia;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\RewardEloquentModel;
use Src\Common\Infrastructure\Laravel\Controller;

class StudentRewardsController extends Controller
{
    public function index()
    {
        try {
            return Inertia::render(config('route.student-rewards'));
        } catch (Exception $e) {
            dd($e);
            return redirect()->route($this->route_url . 'students.index')->with('sytemErrorMessage', $e->getMessage());
        }
    }

    public function store()
    {
        try {
            return Inertia::render(config('route.reward-store'));
        } catch (Exception $e) {
            dd($e);
            return redirect()->route($this->route_url . 'students.index')->with('sytemErrorMessage', $e->getMessage());
        }
    }

    public function beLucky()
    {
        try {
            return Inertia::render(config('route.be-lucky'));
        } catch (Exception $e) {
            dd($e);
            return redirect()->route($this->route_url . 'students.index')->with('sytemErrorMessage', $e->getMessage());
        }
    }

    public function buySticker()
    {
        try {
            $stickers = RewardEloquentModel::where('status', 'ACTIVE')->get();
            return Inertia::render(config('route.buy-sticker', [
                "stickers" => $stickers
            ]));
        } catch (Exception $e) {
            dd($e);
            return redirect()->route($this->route_url . 'students.index')->with('sytemErrorMessage', $e->getMessage());
        }
    }
}
