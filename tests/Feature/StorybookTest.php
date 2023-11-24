<?php

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\LearningNeedEloquentModel;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\DisabilityTypeEloquentModel;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\SubLearningTypeEloquentModel;
use Illuminate\Support\Facades\File as FileCopy;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\ThemeEloquentModel;

beforeEach(function () {
    // Run migrations
    Artisan::call('migrate:fresh');
    // Seed the database with test data
    Artisan::call('db:seed');

    $this->post('/login', [
        'email' => 'bcstaff@mail.com',
        'password' => 'password',
    ]);

});

test('without login not access books', function() {
    Auth::logout();

    $this->get('/books')->assertRedirect('/login');
});

test('access books with bcstaff roles', function() {

    asBcStaff()->get('/books')->assertOk();

    $disabilityType = DisabilityTypeEloquentModel::create([
        'name' => 'Disability types name',
        'description' => 'Disability types description',
    ]);

    $theme = ThemeEloquentModel::create([
        'name' => 'Disability types name',
        'description' => 'Disability types description',
    ]);

    $learningNeed = LearningNeedEloquentModel::create([
        'name' => 'Learning Need name',
        'description' => 'Learning Need description',
    ]);

    $subLearningType = SubLearningTypeEloquentModel::create([
        'learning_needs_id' => $learningNeed->id,
        'name' => 'sub learning 1'
    ]);

    asBcStaff()->get("books?filterItems={'learningneed:[1],'themes':[1],'disability_types':[1],'devices':[]}")->assertOk(); //searching with new created game name

});

test('create storybook html_5 type with bcstaff roles', function () {
    $user = UserEloquentModel::where('email', 'bcstaff@mail.com')->first();
    $sourcePath = public_path('testcase/jolly-jumper-gh-pages.zip');
    $destinationPath = public_path('testcase/jolly-jumper-gh-pages1.zip');

    FileCopy::copy($sourcePath, $destinationPath);

    // Log in as the existing user
    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated

    $path = public_path('images/image1.png'); // Change 'test.jpg' to the desired file name and extension
    $copyPath = public_path('images/image101.png');

    FileCopy::copy($path, $copyPath);

    $thumbFile = new UploadedFile(
        public_path('images/image101.png'),
        'image1.png', // Rename the file if needed
        'application/png',
        null,
        true // Indicates that the file is a test file
    );

    $existingZipFilePath = public_path('testcase/jolly-jumper-gh-pages1.zip'); // Adjust the path and filename as needed

    $htmlFile = new UploadedFile(
        $existingZipFilePath,
        'file.zip', // Rename the file if needed
        'application/zip',
        null,
        true // Indicates that the file is a test file
    );

    $disabilityType = DisabilityTypeEloquentModel::create([
        'name' => 'Disability types name',
        'description' => 'Disability types description',
    ]);

    $theme = ThemeEloquentModel::create([
        'name' => 'Disability types name',
        'description' => 'Disability types description',
    ]);

    $learningNeed = LearningNeedEloquentModel::create([
        'name' => 'Learning Need name',
        'description' => 'Learning Need description',
    ]);

    $subLearningType = SubLearningTypeEloquentModel::create([
        'learning_needs_id' => $learningNeed->id,
        'name' => 'sub learning 1'
    ]);

    $response = $this->post('/books', [
        'name' => 'Example Storybook',
        'description' => 'Storybook Description',
        'thumbnail_img' => $thumbFile,
        'image' => $thumbFile,
        'html_files' => [['file' => $htmlFile, 'name' => 'version 1']],
        'disability_type' => [1],
        'sub_learning_needs' => [1],
        'themes' => [1],
        'devices' => [1],
        'num_gold_coins' => 0,
        'num_silver_coins' => 0,
        'tags' => ['example', 'example2'],
        'is_free' => 1,
        'type' => 'HTML5'
    ]);

    $response->assertStatus(302);

    $storeData = $this->post('/books', []);

    $storeData->assertSessionHasErrors(['name', 'num_gold_coins', 'num_silver_coins']);

    $response->assertRedirect('/books');
});

test('update storybook html_5 type with bcstaff roles', function () {
    $user = UserEloquentModel::where('email', 'bcstaff@mail.com')->first();
    $sourcePath = public_path('testcase/jolly-jumper-gh-pages.zip');
    $destinationPath = public_path('testcase/jolly-jumper-gh-pages1.zip');

    FileCopy::copy($sourcePath, $destinationPath);

    // Log in as the existing user
    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated

    $path = public_path('images/image2.png'); // Change 'test.jpg' to the desired file name and extension

    $copyPath = public_path('images/image101.png');

    FileCopy::copy($path, $copyPath);

    $thumbFile = new UploadedFile(
        public_path('images/image101.png'),
        'image2.png', // Rename the file if needed
        'application/png',
        null,
        true // Indicates that the file is a test file
    );

    $existingZipFilePath = public_path('testcase/jolly-jumper-gh-pages1.zip'); // Adjust the path and filename as needed

    $htmlFile = new UploadedFile(
        $existingZipFilePath,
        'file.zip', // Rename the file if needed
        'application/zip',
        null,
        true // Indicates that the file is a test file
    );

    $disabilityType = DisabilityTypeEloquentModel::create([
        'name' => 'Disability types name',
        'description' => 'Disability types description',
    ]);

    $theme = ThemeEloquentModel::create([
        'name' => 'Disability types name',
        'description' => 'Disability types description',
    ]);

    $learningNeed = LearningNeedEloquentModel::create([
        'name' => 'Learning Need name',
        'description' => 'Learning Need description',
    ]);

    $subLearningType = SubLearningTypeEloquentModel::create([
        'learning_needs_id' => $learningNeed->id,
        'name' => 'sub learning 1'
    ]);

    $response = $this->post('/books', [
        'name' => 'Example Storybook',
        'description' => 'Storybook Description',
        'thumbnail_img' => $thumbFile,
        'image' => $thumbFile,
        'html_files' => [['file' => $htmlFile, 'name' => 'version 1']],
        'disability_type' => [1],
        'sub_learning_needs' => [1],
        'themes' => [1],
        'devices' => [1],
        'num_gold_coins' => 0,
        'num_silver_coins' => 0,
        'tags' => ['example', 'example2'],
        'is_free' => 1,
        'type' => 'HTML5'
    ]);

    $response->assertStatus(302);

    $updatePath = public_path('images/image1.png'); // Change 'test.jpg' to the desired file name and extension

    $copyPath = public_path('images/image101.png');

    FileCopy::copy($updatePath, $copyPath);

    $updateThumbFile = new UploadedFile(
        public_path('images/image101.png'),
        'image1.png', // Rename the file if needed
        'application/png',
        null,
        true // Indicates that the file is a test file
    );

    $updateExistingZipFilePath = public_path('testcase/jolly-jumper-gh-pages1.zip'); // Adjust the path and filename as needed

    $updateHtmlFile = new UploadedFile(
        $updateExistingZipFilePath,
        'file.zip', // Rename the file if needed
        'application/zip',
        null,
        true // Indicates that the file is a test file
    );

    $bookId = 1;

    $updateResponse = $this->put("/books/{$bookId}", [
        'name' => 'Example Storybook testing',
        'description' => 'Storybook Description',
        'thumbnail_img' => $updateThumbFile,
        'image' => $updateThumbFile,
        'existing_files' => [['id' => 1, 'file' => $htmlFile, 'name' => 'version 1']],
        'html_files' => [['file' => $updateHtmlFile, 'name' => 'version 1']],
        'disability_type' => [1],
        'sub_learning_needs' => [1],
        'themes' => [1],
        'devices' => [1],
        'num_gold_coins' => 0,
        'num_silver_coins' => 0,
        'tags' => ['example3', 'example4'],
        'delete_tags' => ['example', 'example2'],
        'is_free' => 1,
        'type' => 'HTML5'
    ]);

    $updateEmptyData = $this->put("books/{$bookId}", []);

    $updateEmptyData->assertSessionHasErrors(['name']);

});

test('delete storybook html_5 type with bcstaff roles', function () {
    $user = UserEloquentModel::where('email', 'bcstaff@mail.com')->first();
    $sourcePath = public_path('testcase/jolly-jumper-gh-pages.zip');
    $destinationPath = public_path('testcase/jolly-jumper-gh-pages1.zip');

    FileCopy::copy($sourcePath, $destinationPath);

    // Log in as the existing user
    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated

    $path = public_path('images/image1.png'); // Change 'test.jpg' to the desired file name and extension
    $copyPath = public_path('images/image101.png');

    FileCopy::copy($path, $copyPath);

    $thumbFile = new UploadedFile(
        public_path('images/image101.png'),
        'image1.png', // Rename the file if needed
        'application/png',
        null,
        true // Indicates that the file is a test file
    );

    $existingZipFilePath = public_path('testcase/jolly-jumper-gh-pages1.zip'); // Adjust the path and filename as needed

    $htmlFile = new UploadedFile(
        $existingZipFilePath,
        'file.zip', // Rename the file if needed
        'application/zip',
        null,
        true // Indicates that the file is a test file
    );

    $disabilityType = DisabilityTypeEloquentModel::create([
        'name' => 'Disability types name',
        'description' => 'Disability types description',
    ]);

    $theme = ThemeEloquentModel::create([
        'name' => 'Disability types name',
        'description' => 'Disability types description',
    ]);

    $learningNeed = LearningNeedEloquentModel::create([
        'name' => 'Learning Need name',
        'description' => 'Learning Need description',
    ]);

    $subLearningType = SubLearningTypeEloquentModel::create([
        'learning_needs_id' => $learningNeed->id,
        'name' => 'sub learning 1'
    ]);

    $response = $this->post('/books', [
        'name' => 'Example Storybook',
        'description' => 'Storybook Description',
        'thumbnail_img' => $thumbFile,
        'image' => $thumbFile,
        'html_files' => [['file' => $htmlFile, 'name' => 'version 1']],
        'disability_type' => [1],
        'sub_learning_needs' => [1],
        'themes' => [1],
        'devices' => [1],
        'num_gold_coins' => 0,
        'num_silver_coins' => 0,
        'tags' => ['example', 'example2'],
        'is_free' => 1,
        'type' => 'HTML5'
    ]);

    $response->assertStatus(302);

    $bookId = 1;

    $deleteResponse = $this->delete("/books/{$bookId}");

    $deleteResponse->assertRedirect('/books');
});
