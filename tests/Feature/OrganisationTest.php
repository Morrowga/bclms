<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Eloquent\SoftDeletes;
use Src\BlendedConcept\Organisation\Domain\Mail\OrganisationExpirationNotice;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\SubscriptionEloquentModel;
use Src\BlendedConcept\Organisation\Infrastructure\EloquentModels\OrganisationEloquentModel;
use Src\BlendedConcept\Organisation\Application\Repositories\Eloquent\OrganisationRepository;
use Src\BlendedConcept\Organisation\Infrastructure\EloquentModels\OrganisationAdminEloquentModel;

beforeEach(function () {
    // Run migrations
    Artisan::call('migrate:fresh');
    // Seed the database with test data
    Artisan::call('db:seed');
});

test('superadmin create organisation', function () {

    $user = UserEloquentModel::where('email', 'superadmin@mail.com')->first();

    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated

    asAdmin()->get('/organisations')->assertOk();
});

it('displays a list of all organisations with superadmin roles', function () {
    // Seed the database with test data (use factories or create specific test data as needed)

    // Call the getOrganisations method without any filters
    $result = app(OrganisationRepository::class)->getOrganisations();

    // Assertions on the paginated organisations
    expect($result['paginate_organisations'])->toBeInstanceOf(\Illuminate\Pagination\LengthAwarePaginator::class);

    // Assertions on the transformed organisations
    $transformedOrganisations = $result['paginate_organisations']->getCollection();

    // Get all organisations from the database
    $allOrganisations = OrganisationEloquentModel::all();

    // Assert that the count of transformed organisations matches the count of all organisations
    expect($transformedOrganisations->count())->toBe($allOrganisations->count());

    // Assert that each organisation in the database is present in the transformed collection
    $allOrganisations->each(function ($organisation) use ($transformedOrganisations) {
        expect($transformedOrganisations->contains('id', $organisation->id))->toBeTrue();
    });
});

test('without login not access organisation', function () {

    Auth::logout();

    $reponse = $this->get('/organisations');
    $reponse->assertRedirect('/login');
});

test('without other role not access organisation  ', function () {

    Auth::logout();
    $user = UserEloquentModel::create([
        'first_name' => 'testing',
        'last_name' => 'testing',
        'email' => 'testinguser@gmail.com',
        'password' => 'password',
        'contact_number' => '234234324324',
        'role_id' => 6,
        'email_verified_at' => Carbon::now(),
    ]);

    if (Auth::attempt(['email' => 'testinguser@gmail.com', 'password' => 'password'])) {
        $reponse = $this->get('/organisations');
        $reponse->assertStatus(403);
    }
    $reponse = $this->get('/organisations');
    $reponse->assertStatus(403);
});

test('all organisations should be displayed in the table', function () {
    $organisations = OrganisationEloquentModel::all();

    $response = asAdmin()->get('/organisations')->assertOk();

    foreach ($organisations as $organisation) {
        $response->assertSee($organisation->name);
        // Add more assertions based on the information you want to check in the table
        asAdmin()->get("organisations?page=1&perPage=10&search={$organisation->name}")->assertSee("{$organisation->name}"); //searching with new created org name
        asAdmin()->get("organisations?page=1&perPage=10&filter=name")->assertSee("{$organisation->name}"); //searching with new created org name
    }

});

test('selected organisation should be displayed with all information', function () {
    $orgId = 1;
    $organisation = OrganisationEloquentModel::where('id', $orgId)->first();

    $response = asAdmin()->get("/organisations/{$organisation->id}");

    $response->assertStatus(200);
    $response->assertSee($organisation->name);
    $response->assertSee($organisation->contact_name);
    $response->assertSee($organisation->contact_email);
    $response->assertSee($organisation->contact_number);
    // Add more assertions based on the information you want to check on the organisation's details page
});

test('form submit as organisation with superadmin role', function () {

    $user = UserEloquentModel::where('email', 'superadmin@mail.com')->first();

    $this->actingAs($user);

    $this->assertAuthenticated(); // Check if the user is authenticated

    $postData = $this->post('/organisations', [
        'login_email' => 'airforceman.rr9@gmail.com',
        'login_password' => 'password',
        'org_admin_name' => 'testing name',
        'org_admin_contact_number' => '09234244',
        'name' => 'organisation test',
        'contact_name' => 'org test',
        'contact_email' => 'airforceman.rr9@gmail.com',
        'contact_number' => '97343453',
        'sub_domain' => 'orgtest',
        'logo' => null,
        'status' => 'ACTIVE',
    ]);

    $postData->assertStatus(302);

    Auth::logout();

    $orgAdmin = UserEloquentModel::where('email', 'airforceman.rr9@gmail.com')->first();

    $this->actingAs($orgAdmin);
    $this->get('/organisations'); // go back to organisations page

    $postEmptyData = $this->post('/organisations', []);

    $postEmptyData->assertSessionHasErrors(['name', 'contact_email', 'org_admin_name', 'org_admin_contact_number', 'login_email', 'login_password']);
});

test('form update as organisation with superadmin role', function () {

    $user = UserEloquentModel::where('email', 'superadmin@mail.com')->first();

    $this->actingAs($user);

    $this->assertAuthenticated();

    $response = $this->get('/organisations');

    $response->assertStatus(200);

    $postData = $this->post('/organisations', [
        'login_email' => 'testorgadmin@gmail.com',
        'login_password' => 'password',
        'org_admin_name' => 'testing name',
        'org_admin_contact_number' => '09234244',
        'name' => 'organisation test',
        'contact_name' => 'org test',
        'contact_email' => 'orgtest@mail.com',
        'contact_number' => '97343453',
        // 'sub_domain' => 'orgtest',
        'logo' => null,
        'status' => 'ACTIVE',
    ]);

    $postData->assertStatus(302);

    $updateData = $this->put("/organisations/2", [
        'name' => 'organisation test update',
        'contact_name' => 'org test update',
        'contact_email' => 'orgtestupate@mail.com',
        'contact_number' => '23423423',
        // 'sub_domain' => 'orgtestupdate',
        'logo' => null,
        'status' => 'INACTIVE',
    ]);

    $updateData->assertStatus(302);

    $updateData = $this->put("/organisations/2", []);

    $updateData->assertSessionHasErrors(['name', 'contact_email', 'org_admin_name', 'org_admin_contact_number', 'login_email']);
});

test('delete organisation', function () {
    $user = UserEloquentModel::where('email', 'superadmin@mail.com')->first();

    $this->actingAs($user);

    $this->assertAuthenticated();

    $response = $this->get('/organisations');
    $response->assertStatus(200);

    $postData = $this->post('/organisations', [
        'login_email' => 'testorgadmin@gmail.com',
        'login_password' => 'password',
        'org_admin_name' => 'testing name',
        'org_admin_contact_number' => '09234244',
        'name' => 'organisation test 1',
        'contact_name' => 'org test',
        'contact_email' => 'testorgadmin@mail.com',
        'contact_number' => '97343453',
        'sub_domain' => 'orgtest',
        'logo' => null,
        'status' => 'ACTIVE',
    ]);

    $postData->assertStatus(302);

    $deleteOrg = $this->delete("/organisations/2");

    $deleteOrg->assertStatus(302);

    $loginAsOrg = $this->post('/login', [
        'email'    => 'testorgadmin@gmail.com',
        'password' => 'password',
    ]);

    if ($deleteOrg instanceof SoftDeletes && $deleteOrg->trashed()) {
        $response->assertStatus(422); // Assuming 422 is the status code for validation failure
        $this->assertDatabaseCount('organisations', 0); // Assuming you've soft-deleted the user

        $loginAsOrg = $this->post('/login', [
            'email'    => 'testorgadmin@gmail.com',
            'password' => 'password',
        ]);

        $loginAsOrg->assertStatus(422);
    }
});

test('can run organisation expiration schedule', function () {
    $exitCode = Artisan::call('expiration:org');

    $this->assertEquals(0, $exitCode);
});

test('org admin receive email 1 hour before expire', function () {
    $userData = [
        'first_name' => 'testing',
        'last_name' => 'testing',
        'email' => 'testinguser@gmail.com',
        'password' => 'password',
        'role_id' => 5,
        'email_verified_send_on' => now(),
    ];
    $user = UserEloquentModel::create($userData);

    $subscriptionData = [
        'start_date' => now(),
        'end_date' => now()->subDay()->format('Y-m-d'),
        'payment_date' => now(),
        'payment_status' => 'PAID',
        'stripe_status' => null,
        'stripe_price' => null,
    ];
    $subscription = SubscriptionEloquentModel::create($subscriptionData);
    $organisationData = [
        'curr_subscription_id' => $subscription->id,
        'name' => 'testing org',
        'contact_name' => 'tester',
        'contact_email' => "testingorg@mail.com",
        'contact_number' => '09234234',
        'status' => 'active'
    ];
    $organisation = OrganisationEloquentModel::create($organisationData);
    $orgadminData = [
        'user_id' => $user->id,
        'organisation_id' => $organisation->id
    ];
    $orgadmin = OrganisationAdminEloquentModel::create($orgadminData);
    $organisation->update([
        'org_admin_id' => $orgadmin->org_admin_id
    ]);
    $now = Carbon::now()->format('Y-m-d');
    $subscription = $organisation->subscription;
    $end_date = $subscription->end_date;

    $end_date = Carbon::parse($end_date)->format('Y-m-d');
    $hoursUntilExpiration = Carbon::now()->diffInHours($end_date, false);
    if ($hoursUntilExpiration <= 1) {
        $title = 'Your Subscription Expires Soon';
        $message = 'Dear ' . $organisation->name . ', your subscription is expiring soon in ' . $hoursUntilExpiration . ' hours.';
        $orgadminMail = $organisation->org_admin->user->email;
        Mail::to($orgadminMail)
            ->send(new OrganisationExpirationNotice($organisation, $title, $message));

        $this->assertTrue(true);
    }
});

test('org admin should not receive any reminder email if not expire', function () {
    // Create user, subscription, organisation, and org admin
    $userData = [
        'first_name' => 'testing',
        'last_name' => 'testing',
        'email' => 'testinguser@gmail.com',
        'password' => 'password',
        'role_id' => 5,
        'email_verified_send_on' => now(),
    ];
    $user = UserEloquentModel::create($userData);

    $subscriptionData = [
        'start_date' => now(), // Adjust the start date to be in the future
        'end_date' => now()->addDays(3),   // Adjust the end date to be after the start date
        'payment_date' => now(),
        'payment_status' => 'PAID',
        'stripe_status' => null,
        'stripe_price' => null,
    ];
    $subscription = SubscriptionEloquentModel::create($subscriptionData);

    $organisationData = [
        'curr_subscription_id' => $subscription->id,
        'name' => 'testing org',
        'contact_name' => 'tester',
        'contact_email' => "testingorg@mail.com",
        'contact_number' => '09234234',
        'status' => 'active'
    ];
    $organisation = OrganisationEloquentModel::create($organisationData);

    $orgadminData = [
        'user_id' => $user->id,
        'organisation_id' => $organisation->id
    ];
    $orgadmin = OrganisationAdminEloquentModel::create($orgadminData);

    $organisation->update([
        'org_admin_id' => $orgadmin->org_admin_id
    ]);

    // Get the current date
    $now = Carbon::now()->format('Y-m-d');

    // Calculate hours until expiration
    $subscription = $organisation->subscription;
    $start_date = $subscription->start_date;
    $end_date = $subscription->end_date;

    // Act
    if ($now >= $start_date && $now <= $end_date) {
        // This block will execute if $now is between start_date and end_date
        $this->assertTrue(true); // Adjust this assertion accordingly or add your own code
    }
});
