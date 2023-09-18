<?php

namespace Src\BlendedConcept\Disability\Presentation\HTTP;

use Illuminate\Http\Response;
use Inertia\Inertia;
use Src\BlendedConcept\Disability\Application\DTO\ThemeData;
use Src\BlendedConcept\Disability\Application\Mappers\ThemeMapper;
use Src\BlendedConcept\Disability\Application\Policies\ThemePolicy;
use Src\BlendedConcept\Disability\Application\Requests\StoreThemeRequest;
use Src\BlendedConcept\Disability\Application\Requests\UpdateThemeRequest;
use Src\BlendedConcept\Disability\Application\UseCases\Commands\Themes\DeleteThemeCommand;
use Src\BlendedConcept\Disability\Application\UseCases\Commands\Themes\StoreThemeCommand;
use Src\BlendedConcept\Disability\Application\UseCases\Commands\Themes\UpdateThemeCommand;
use Src\BlendedConcept\Disability\Application\UseCases\Queries\Themes\GetThemes;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\ThemeEloquentModel;

class ThemeController
{
    public function index()
    {
        $filters = request(['search', 'page', 'perPage']);
        $themes = (new GetThemes($filters))->handle();

        return Inertia::render(config('route.disability_type.index'), [
            'disabilityTypes' => $themes,
        ]);
    }

    public function store(StoreThemeRequest $request)
    {
        try {
            // Abort if the user is not authorized to create organizations
            // abort_if(authorize('create', ThemePolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

            // Validate the request data
            $request->validated();
            $themeRequest = ThemeMapper::fromRequest($request);
            $saveTheme = (new StoreThemeCommand($themeRequest));
            $saveTheme->execute();

            return redirect()->route('disability_themes.index')->with('successMessage', 'Organizations Created Successfully!');
        } catch (\Exception $error) {
            return redirect()
                ->route('disability_type.index')
                ->with([
                    'systemErrorMessage' => $error->getCode(),
                ]);
        }
    }

    public function show()
    {
        return Inertia::render(config('route.plans.show'));
    }

    public function update(UpdateThemeRequest $request, $id)
    {

        try {
            $theme = ThemeEloquentModel::findOrFail($id);
            $updateTheme = ThemeData::fromRequest($request, $theme);
            $updateThemecommand = (new UpdateThemeCommand($updateTheme));
            $updateThemecommand->execute();

            return redirect()->route('disability_themes.index')->with('successMessage', 'Organizations Created Successfully!');
        } catch (\Exception $error) {
            return redirect()
                ->route('disability_themes.index')
                ->with([
                    'systemErrorMessage' => $error->getCode(),
                ]);
        }
    }

    public function destroy($id)
    {
        try {
            $theme = ThemeEloquentModel::findOrFail($id);
            $deleteThemeCommand = (new DeleteThemeCommand($theme));
            $deleteThemeCommand->execute();

            return redirect()->route('disability_themes.index')->with('successMessage', 'Organizations Created Successfully!');
        } catch (\Exception $error) {
            return redirect()
                ->route('disability_themes.index')
                ->with([
                    'systemErrorMessage' => $error->getCode(),
                ]);
        }
    }
}
