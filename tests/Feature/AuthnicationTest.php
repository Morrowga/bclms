<?php

namespace Tests\Feature\Authi;

use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Inertia\Testing\AssertableInertia;

test("correct email and password login as superadmin", function () {


    $response = $this->post("login", [
        "email" => "haroem284@gmail.com",
        "password" => "password"
    ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['errorMessage']);


});
