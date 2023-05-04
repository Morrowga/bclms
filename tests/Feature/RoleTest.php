<?php

use Illuminate\Support\Facades\Artisan;
use Src\BlendedConcept\User\Domain\Factories\UserFactory;
use  Src\BlendedConcept\User\Domain\Model\User;
beforeEach(function () {
    // Run migrations
    Artisan::call('migrate:fresh');
    // Seed the database with test data
    Artisan::call('db:seed');
});

/**
 *  superadmin can only create roles and assign roles
 *
 */
test('super admin can only create roles', function () {

});
