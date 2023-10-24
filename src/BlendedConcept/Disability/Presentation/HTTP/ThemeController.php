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
        abort_if(authorize('view', ThemePolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $filters = request(['search', 'page', 'perPage']);
        $themes = (new GetThemes($filters))->handle();

        return Inertia::render(config('route.disability_type.index'), [
            'disabilityTypes' => $themes,
        ]);
    }

    public function store(StoreThemeRequest $request)
    {
        try {
            // Abort if the user is not authorized to create organisations
            abort_if(authorize('create', ThemePolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

            // Validate the request data
            $request->validated();
            $themeRequest = ThemeMapper::fromRequest($request);
            $saveTheme = (new StoreThemeCommand($themeRequest));
            $saveTheme->execute();

            return redirect()->route('disability_themes.index')->with('successMessage', 'Theme Created Successfully!');
        } catch (\Exception $error) {
            return redirect()->back()->with('errorMessage', $error->getMessage());
        }
    }

    public function show()
    {
        return Inertia::render(config('route.plans.show'));
    }

    public function update(UpdateThemeRequest $request, $id)
    {

        abort_if(authorize('update', ThemePolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {
            $theme = ThemeEloquentModel::findOrFail($id);
            $updateTheme = ThemeData::fromRequest($request, $theme);
            $updateThemecommand = (new UpdateThemeCommand($updateTheme));
            $updateThemecommand->execute();

            return redirect()->route('disability_themes.index')->with('successMessage', 'Theme Updated Successfully!');
        } catch (\Exception $error) {
            return redirect()
                ->back()
                ->with([
                    'errorMessage' => $error->getMessage(),
                ]);
        }
    }

    public function destroy($id)
    {
        abort_if(authorize('destroy', ThemePolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {
            $theme = ThemeEloquentModel::findOrFail($id);
            $deleteThemeCommand = (new DeleteThemeCommand($theme));
            $deleteThemeCommand->execute();

            return redirect()->route('disability_themes.index')->with('successMessage', 'Theme Deleted Successfully!');
        } catch (\Exception $error) {
            return redirect()
                ->back()
                ->with([
                    'errorMessage' => $error->getMessage(),
                ]);
        }
    }
}
