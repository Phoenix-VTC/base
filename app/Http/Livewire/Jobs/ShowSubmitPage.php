<?php

namespace App\Http\Livewire\Jobs;

use App\Enums\JobStatus;
use App\Models\Cargo;
use App\Models\City;
use App\Models\Company;
use App\Models\Game;
use App\Models\Job;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ShowSubmitPage extends Component
{
    // Game data
    public array $cities;
    public array $games;
    public array $companies;
    public array $cargos;
    // Form fields
    public string $game = '';
    public string $pickup_city = '';
    public string $destination_city = '';
    public string $pickup_company = '';
    public string $destination_company = '';
    public string $cargo = '';
    public string $finished_at = '';
    public string $distance = '';
    public string $load_damage = '';
    public string $estimated_income = '';
    public string $total_income = '';
    public string $comments = '';

    public function mount(): void
    {
        $this->games = Game::GAMES;

        $cities = collect();
        $query = City::all();
        foreach ($query as $city) {
            $cities->put(
                $city->id,
                (ucwords($city->real_name) . ($city->mod ? " ($city->mod)" : ''))
            );
        }
        $this->cities = $cities->toArray();

        $companies = collect();
        $query = Company::all();
        foreach ($query as $company) {
            $companies->put(
                $company->id,
                (ucwords($company->name) . ($company->mod ? " ($company->mod)" : ''))
            );
        }
        $this->companies = $companies->toArray();

        $cargos = collect();
        $query = Cargo::all();
        foreach ($query as $cargo) {
            $cargos->put(
                $cargo->id,
                (ucwords($cargo->name) . ($cargo->mod ? " ($cargo->mod)" : ''))
            );
        }
        $this->cargos = $cargos->toArray();

        $this->finished_at = Carbon::now()->format('Y-m-d');
    }

    public function rules(): array
    {
        return [
            'game' => ['required', 'integer'],
            'pickup_city' => ['required', 'integer', 'exists:App\Models\City,id'],
            'destination_city' => ['required', 'integer', 'exists:App\Models\City,id'],
            'pickup_company' => ['required', 'integer', 'exists:App\Models\Company,id'],
            'destination_company' => ['required', 'integer', 'exists:App\Models\Company,id'],
            'cargo' => ['required', 'integer', 'exists:App\Models\Cargo,id'],
            'finished_at' => ['required', 'date', 'after_or_equal:' . date('Y-m-d', strtotime('-7 days'))],
            'distance' => ['required', 'integer', 'min:1'],
            'load_damage' => ['required', 'integer', 'min:0', 'max:100'],
            'estimated_income' => ['required', 'integer', 'min:1'],
            'total_income' => ['required', 'integer', 'min:1', 'max:' . $this->estimated_income],
            'comments' => ['sometimes', 'string'],
        ];
    }

    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.jobs.submit-page')->extends('layouts.app');
    }

    public function submit()
    {
        $validatedData = $this->validate();

        $job = Job::create([
            'user_id' => Auth::id(),
            'game_id' => $validatedData['game'],
            'pickup_city_id' => $validatedData['pickup_city'],
            'destination_city_id' => $validatedData['destination_city'],
            'pickup_company_id' => $validatedData['pickup_company'],
            'destination_company_id' => $validatedData['destination_company'],
            'cargo_id' => $validatedData['cargo'],
            'finished_at' => $validatedData['finished_at'],
            'distance' => $validatedData['distance'],
            'load_damage' => $validatedData['load_damage'],
            'estimated_income' => $validatedData['estimated_income'],
            'total_income' => $validatedData['total_income'],
            'comments' => $validatedData['comments'],
            'status' => JobStatus::Complete,
        ]);

        session()->flash('alert', ['type' => 'success', 'message' => 'Job successfully submitted!']);

        return redirect()->route('jobs.overview');
    }
}