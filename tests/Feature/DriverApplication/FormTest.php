<?php

use App\Mail\DriverApplication\ApplicationReceived;
use App\Models\Application;
use App\Models\User;
use App\Rules\UsernameNotReserved;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

use App\Http\Livewire\DriverApplication\ShowForm;

uses(RefreshDatabase::class);

$steamUser = [
    "communityvisibilitystate" => 3,
    "profilestate" => 1,
    "personaname" => "Dot",
    "profileurl" => "https://steamcommunity.com/id/DoggoDot/",
    "avatar" => "https://steamcdn-a.akamaihd.net/steamcommunity/public/images,/avatars/19/19c01f1ad0c2d40ae82543247e06a1906e96fbcf.jpg",
    "avatarmedium" => "https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/19/19c01f1ad0c2d40ae82543247e06a1906e96fbcf_medium.jpg",
    "avatarfull" => "https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/19/19c01f1ad0c2d40ae82543247e06a1906e96fbcf_full.jpg",
    "avatarhash" => "19c01f1ad0c2d40ae82543247e06a1906e96fbcf",
    "lastlogoff" => 1634177511,
    "personastate" => 1,
    "realname" => "Diego",
    "primaryclanid" => "103582791468856849",
    "timecreated" => 1391349319,
    "personastateflags" => 0,
    "loccountrycode" => "NL",
    "steamID64" => "76561198125147009",
];
$truckersmpUser = [
    "id" => 3181778,
    "name" => "Doggo.",
    "avatar" => "https://static.truckersmp.com/avatarsN/3181778.1633185937.png",
    "smallAvatar" => "https://static.truckersmp.com/avatarsN/small/3181778.1633185937.png",
    "joinDate" => "2020-01-06 20:33:34",
    "steamID64" => 76561198125147009,
    "steamID" => "76561198125147009",
    "discordSnowflake" => "112928994340384768",
    "displayVTCHistory" => true,
    "groupName" => "Translator",
    "groupColor" => "#00e5ff",
    "groupID" => 25,
    "banned" => false,
    "bannedUntil" => null,
    "bansCount" => null,
    "displayBans" => false,
    "patreon" => [
        "isPatron" => true,
        "active" => true,
        "color" => "#DAA520",
        "tierId" => 3894844,
        "currentPledge" => 500,
        "lifetimePledge" => 8500,
        "nextPledge" => 500,
        "hidden" => false,
    ],
    "permissions" => [
        "isStaff" => true,
        "isUpperStaff" => false,
        "isGameAdmin" => false,
        "showDetailedOnWebMaps" => false,
    ],
    "vtc" => [
        "id" => 30294,
        "name" => "Phoenix",
        "tag" => "Phoenix |",
        "inVTC" => true,
        "memberID" => 116827,
    ]
];

it('shows the application form', function () use ($steamUser) {
    $this->withSession(['steam_user' => $steamUser])
        ->get(route('driver-application.apply'))
        ->assertSuccessful()
        ->assertSeeLivewire(ShowForm::class)
        ->assertSeeText('Personal Information')
        ->assertSeeText('Digital Interview');
});

it('is redirected if not logged in', function () {
    $this->get(route('driver-application.apply'))
        ->assertRedirect();
});

test('a user can apply', function () use ($steamUser, $truckersmpUser) {
    $this->withSession(['steam_user' => $steamUser, 'truckersmp_user' => collect($truckersmpUser)]);

    Mail::fake();

    $response = Livewire::test(ShowForm::class)
        ->set('discord_username', 'Phoenix#0001')
        ->set('username', 'AutomaticTest')
        ->set('email', 'automatictest@example.com')
        ->set('date_of_birth', Carbon::now()->subYears(18))
        ->set('country', 'NL')
        ->set('another_vtc', 0)
        ->set('games', 'both')
        ->set('fluent', 1)
        ->set('about', 'Beep boop')
        ->set('why_join', 'Boop beep')
        ->set('terms', 1)
        ->set('find_us', 'git clone git@github.com:Phoenix-VTC/base.git')
        ->call('submit');

    $this->assertTrue(($application = Application::query()->where('email', 'automatictest@example.com'))->exists());

    Mail::assertQueued(ApplicationReceived::class);

    $response->assertredirect(route('driver-application.status', ['uuid' => $application->firstOrFail()->uuid]));
});

test('all fields are required', function () {
    Livewire::test(ShowForm::class)
        ->call('submit')
        ->assertHasErrors([
            'discord_username' => 'required',
            'username' => 'required',
            'email' => 'required',
            'date_of_birth' => 'required',
            'country' => 'required',
            'another_vtc' => 'required',
            'games' => 'required',
            'fluent' => 'required',
            'about' => 'required',
            'why_join' => 'required',
            'terms' => 'required',
            'find_us' => 'required',
        ]);
});

test('discord username is valid discord username', function () {
    Livewire::test(ShowForm::class)
        ->set('discord_username', 'InvalidUsername')
        ->call('submit')
        ->assertHasErrors([
            'discord_username' => 'regex',
        ]);
});

test('username is minimum of three characters', function () {
    Livewire::test(ShowForm::class)
        ->set('username', 'u')
        ->call('submit')
        ->assertHasErrors([
            'username' => 'min',
        ]);
});

test('username cannot be reserved', function () {
    Livewire::test(ShowForm::class)
        ->set('username', 'admin')
        ->call('submit')
        ->assertHasErrors([
            'username' => UsernameNotReserved::class,
        ]);
});

test('username hasn\'t been taken already', function () {
    User::factory()->create(['username' => 'Diego']);

    Livewire::test(ShowForm::class)
        ->set('username', 'Diego')
        ->call('submit')
        ->assertHasErrors([
            'username' => 'unique'
        ]);
});

test('email is valid email', function () {
    Livewire::test(ShowForm::class)
        ->set('email', 'InvalidEmail')
        ->call('submit')
        ->assertHasErrors([
            'email' => 'email',
        ]);
});

test('email hasn\'t been taken already', function () {
    User::factory()->create(['email' => 'diego@phoenixvtc.com']);

    Livewire::test(ShowForm::class)
        ->set('email', 'diego@phoenixvtc.com')
        ->call('submit')
        ->assertHasErrors([
            'email' => 'unique'
        ]);
});

test('date of birth is valid date', function () {
    Livewire::test(ShowForm::class)
        ->set('date_of_birth', 'InvalidDate')
        ->call('submit')
        ->assertHasErrors([
            'date_of_birth' => 'date',
        ]);
});

test('date of birth cannot be after today', function () {
    Livewire::test(ShowForm::class)
        ->set('date_of_birth', '9999-12-01')
        ->call('submit')
        ->assertHasErrors([
            'date_of_birth' => 'before',
        ]);
});

test('user under 16 can apply', function () {
    Livewire::test(ShowForm::class)
        ->set('date_of_birth', Carbon::now()->subYears(13))
        ->call('submit')
        ->assertHasNoErrors('date_of_birth');
});

test('country is valid country', function () {
    Livewire::test(ShowForm::class)
        ->set('country', 'InvalidCountry')
        ->call('submit')
        ->assertHasErrors([
            'country' => 'in',
        ]);
});

test('another vtc is boolean', function () {
    Livewire::test(ShowForm::class)
        ->set('another_vtc', 'NotABoolean')
        ->call('submit')
        ->assertHasErrors([
            'another_vtc' => 'boolean',
        ]);
});

test('games is valid game', function () {
    Livewire::test(ShowForm::class)
        ->set('games', 'NotAGame')
        ->call('submit')
        ->assertHasErrors([
            'games' => 'in',
        ]);
});

test('fluent is boolean', function () {
    Livewire::test(ShowForm::class)
        ->set('fluent', 'NotABoolean')
        ->call('submit')
        ->assertHasErrors([
            'fluent' => 'boolean',
        ]);
});

test('terms is boolean', function () {
    Livewire::test(ShowForm::class)
        ->set('terms', 'NotABoolean')
        ->call('submit')
        ->assertHasErrors([
            'terms' => 'boolean',
        ]);
});
