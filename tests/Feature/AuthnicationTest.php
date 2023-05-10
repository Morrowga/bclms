<?php
namespace Tests\Feature\Authi;
use Src\BlendedConcept\User\Domain\Model\User;
use Src\BlendedConcept\User\Domain\Model\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Inertia\Testing\AssertableInertia;


/**
 *  require
 *
 *  @return bool True if email is required
 */
test('blank_b2c_register_email',function(){

    $data = [
        'email' => "",
        "password" => 'password',
     ];
     $response = $this->post('/b2cstore', $data);
     $response->assertSessionHasErrors('email');
});

/**
 *
 *  without password check
 *
 *  @return  bool True
 */

test('blank_b2c_register_password',function(){
    $data = [
        'email' =>  "admin@com",
        'password' => ""
     ];
     $response = $this->post('/b2cstore', $data);
     $response->assertSessionHasErrors("password");
});

/**
 *  invalid email
 *
 *  @return bool True
 *
 */

test('invalid_b2c_register_email',function(){
    $data = [
        'email' => "testing.com",
        "password" => 'password',

     ];
     $response = $this->post('/b2cstore', $data);
     $response->assertSessionHasErrors("email");
});




/**
 *  check unique user for register
 *
 *  @return bool True
 */

test('unique_b2c_register_email',function(){
    $email = "superadmin@mail.com";
      $name = explode("@", $email);
      $data = [
         'name' => $name[0],
         "email" => $email,
         "password" => 'password',
      ];
      $existingUser = User::create($data);
      $response = $this->post('/b2cstore', [
         'name' => $existingUser->name,
         'email' => $existingUser->email,
         "password" => 'password',
      ]);

      $response->assertSessionHasErrors('email');
});


/**
 * check unverify email not to pass
 *
 *
 * @return bool True
 *
 */
test('before_verified_b2c_register',function(){

    Role::insert([
        "id" => 2,
        "name" => "BC Subscriber",
      ]);
      $email = "testing@mail.com";
      $name = explode("@", $email);
      $data = [
         'name' => $name[0],
         "email" => $email,
         "password" => 'password',
         "email_verified_at" => null
      ];

      $response = $this->post('/b2cstore', $data);

      $checkEmailVerify = $this->post("/login",[
        "email" => $data['email'],
        "password" => $data['password']
      ]);


      $checkEmailVerify->assertInertia(function (AssertableInertia $page) {
        $props = $page->toArray();
        expect($props['props']['errorMessage'])->toBe('Please Verify your email');
    });

});

/**
 *
 *  check after verify email
 *
 *  @return bool True
 *
 */

test('after_verified_b2c_register',function(){
    $email = "fakeemail@gmai.com";
    $name = explode("@", $email);
    $data = [
       'name' => $name[0],
       "email" => $email,
       "password" => 'password',
       "email_verified_at" => Carbon::now()
    ];
    $registerUser = User::create($data);
    $id = Crypt::encryptString($registerUser->id);
    $response = $this->get(route('verification', ['id' => $id]));

    $response->assertStatus(200);
});





/**
 *  check empty email on login
 *
 *  @return  bool True
 */
test('lankLoginEmail',function()
{
   $data = [
      "email" => "",
      "password" => 'password',
   ];
   $response = $this->post('login', $data);
   $response->assertSessionHasErrors("email");
});

/**
 *  check empty password
 *
 *  @return bool True
 */
test('blank_login_password',function()
{
   $data = [
      "email" => "testing@testing.com",
      "password" => "",
   ];
   $response = $this->post('login', $data);
   $response->assertSessionHasErrors('password');
});

/**
 *  check invalid email address
 *  @return bool True
 *
*/
test('invalid_login_email',function()
{
   $data = [
      'email' => "testing.com",
      "password" => Hash::make('password'),
   ];
   $response = $this->post('login', $data);
   $response->assertSessionHasErrors("email");
});

/**
 *  check email and password mismatch
 *
 *   @return  bool True
 *
*/
test('mismatch_login_password',function()
{
   $data = [
      'name' => "Admin",
      'email' => "admin@admin.com",
      "password" => "password",
      "email_verified_at" => Carbon::now()
   ];
   $existingUser = User::create($data);


   $response = $this->post('login', [
      "email" => $existingUser->email,
      "password" => Hash::make('passwords')
   ]);


   $response->assertInertia(function (AssertableInertia $page) {
    $props = $page->toArray();
    expect($props['props']['errorMessage'])->toBe('Invalid Creditional');
   });

});

/***
 *  check user for valid login and redirect to home page
 *
 *
 */
test('match_login_password',function()
{
   $data = [
      'name' => "Admin",
      'email' => "admin@testing.com",
      "password" => "password",
      "email_verified_at" => Carbon::now()

   ];
   $existingUser = User::create($data);
   $response = $this->post('login', [
      "email" => $existingUser->email,
      "password" => 'password'
   ]);
   $response->assertRedirect('/home');
});