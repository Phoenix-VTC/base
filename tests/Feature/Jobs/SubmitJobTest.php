<?php

use App\Http\Livewire\Jobs\Submit\ShowSubmitPage;
use App\Models\Cargo;
use App\Models\City;
use App\Models\Company;
use App\Models\Job;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows the form', function () {
    $user = User::factory()->create()->assignRole('driver');
    $this->be($user);

    $this->get(route('jobs.submit', 1))
        ->assertSuccessful()
        ->assertSeeLivewire(ShowSubmitPage::class)
        ->assertSeeText('Submit New ETS2 Job');
});

it('is redirected if not logged in', function () {
    $this->get(route('jobs.submit', 1))
        ->assertRedirect(route('login'));
});

it('can submit jobs', function () {
    $user = User::factory()->create()->assignRole('driver');
    $this->actingAs($user);

    $response = Livewire::test(ShowSubmitPage::class, ['game_id' => 1])
        ->set('pickup_city', City::factory()->create()->id)
        ->set('destination_city', City::factory()->create()->id)
        ->set('pickup_company', Company::factory()->create()->id)
        ->set('destination_company', Company::factory()->create()->id)
        ->set('cargo', Cargo::factory()->create()->id)
        ->set('finished_at', Carbon::yesterday())
        ->set('distance', 1200)
        ->set('load_damage', 0)
        ->set('estimated_income', 5000)
        ->set('total_income', 5000)
        ->set('comments', 'Comment')
        ->call('submit');

    $this->assertTrue(($job = Job::query()->where('user_id', $user->id))->exists());

    $response->assertredirect(route('jobs.show', $job->firstOrFail()->id));
});

it('tests the validation rules', function ($field, $value, $rule) {
    Livewire::test(ShowSubmitPage::class, ['game_id' => 1])
        ->set($field, $value)
        ->call('submit')
        ->assertHasErrors([$field => $rule]);
})->with([
    'pickup city is null' => ['pickup_city', null, 'required'],
    'pickup city does not exist' => ['pickup_city', 999, 'exists'],

    'destination city is null' => ['destination_city', null, 'required'],
    'destination city does not exist' => ['destination_city', 999, 'exists'],

    'pickup company is null' => ['pickup_company', null, 'required'],
    'pickup company does not exist' => ['pickup_company', 999, 'exists'],

    'destination company is null' => ['destination_company', null, 'required'],
    'destination company does not exist' => ['destination_company', 999, 'exists'],

    'cargo is null' => ['destination_company', null, 'required'],
    'cargo does not exist' => ['destination_company', 999, 'exists'],

    'finished at is null' => ['finished_at', null, 'required'],
    'finished at is not a date' => ['finished_at', 'NotADate', 'date'],
    'finished at is more than 7 days ago' => ['finished_at', Carbon::now()->subWeeks(2), 'after_or_equal'],
    'finished at is in the future' => ['finished_at', Carbon::tomorrow(), 'before_or_equal'],

    'distance is null' => ['distance', null, 'required'],
    'distance is not numeric' => ['distance', 'NotNumeric', 'numeric'],
    'distance is less than one' => ['distance', 0, 'min'],
    'distance is more than 5000' => ['distance', 6000, 'max'],

    'load damage is null' => ['load_damage', null, 'required'],
    'load damage is not numeric' => ['load_damage', 'NotNumeric', 'numeric'],
    'load damage is less than zero' => ['load_damage', -1, 'min'],
    'load damage is more than 100' => ['load_damage', 101, 'max'],

    'estimated income is null' => ['estimated_income', null, 'required'],
    'estimated income is numeric' => ['estimated_income', 'NotNumeric', 'numeric'],
    'estimated income is less than 1' => ['estimated_income', 0, 'min'],
    'estimated income is more than 400000' => ['estimated_income', 500000, 'max'],

    'total income is null' => ['total_income', null, 'required'],
    'total income is numeric' => ['total_income', 'NotNumeric', 'numeric'],
    'total income is less than 1' => ['total_income', 0, 'min'],
]);

it('deposits the income after submitting a job', function () {
    $user = User::factory()->create()->assignRole('driver');
    $this->actingAs($user);

    Livewire::test(ShowSubmitPage::class, ['game_id' => 1])
        ->set('pickup_city', City::factory()->create()->id)
        ->set('destination_city', City::factory()->create()->id)
        ->set('pickup_company', Company::factory()->create()->id)
        ->set('destination_company', Company::factory()->create()->id)
        ->set('cargo', Cargo::factory()->create()->id)
        ->set('finished_at', Carbon::yesterday())
        ->set('distance', 1200)
        ->set('load_damage', 0)
        ->set('estimated_income', 5000)
        ->set('total_income', 5000)
        ->set('comments', 'Comment')
        ->call('submit');

    $this->assertEquals(5000, $user->default_wallet_balance);
});

it('converts the income to euros if game is ATS', function () {
    $user = User::factory()->create()->assignRole('driver');
    $this->actingAs($user);

    Livewire::test(ShowSubmitPage::class, ['game_id' => 2])
        ->set('pickup_city', City::factory()->create()->id)
        ->set('destination_city', City::factory()->create()->id)
        ->set('pickup_company', Company::factory()->create()->id)
        ->set('destination_company', Company::factory()->create()->id)
        ->set('cargo', Cargo::factory()->create()->id)
        ->set('finished_at', Carbon::yesterday())
        ->set('distance', 1200)
        ->set('load_damage', 0)
        ->set('estimated_income', 5000)
        ->set('total_income', 5000)
        ->set('comments', 'Comment')
        ->call('submit');

    $this->assertEquals(4150, $user->default_wallet_balance);
});

it('converts the distance to kilometres if game is ATS', function () {
    $user = User::factory()->create()->assignRole('driver');
    $this->actingAs($user);

    Livewire::test(ShowSubmitPage::class, ['game_id' => 2])
        ->set('pickup_city', City::factory()->create()->id)
        ->set('destination_city', City::factory()->create()->id)
        ->set('pickup_company', Company::factory()->create()->id)
        ->set('destination_company', Company::factory()->create()->id)
        ->set('cargo', Cargo::factory()->create()->id)
        ->set('finished_at', Carbon::yesterday())
        ->set('distance', 1200)
        ->set('load_damage', 0)
        ->set('estimated_income', 5000)
        ->set('total_income', 5000)
        ->set('comments', 'Comment')
        ->call('submit');

    $job = Job::query()->where('user_id', $user->id)->firstOrFail();

    $this->assertEquals(1931, $job->distance);
});
