<?php

namespace App\Http\Livewire\Jobs;

use App\Enums\JobStatus;
use App\Models\Job;
use Livewire\Component;

class ShowEditPage extends Component
{
    public Job $job;
    // Form fields
    public string $pickup_city = '';
    public string $destination_city = '';
    public string $pickup_company = '';
    public string $destination_company = '';
    public string $cargo = '';
    public string $distance = '';
    public string $load_damage = '';
    public string $estimated_income = '';
    public string $total_income = '';
    public ?string $comments = '';

    public function mount(): void
    {
        if (!$this->job->canEdit) {
            abort(403, 'You don\'t have permission to edit this job.');
        }

        $this->fill([
            'pickup_city' => $this->job->pickup_city_id,
            'destination_city' => $this->job->destination_city_id,
            'pickup_company' => $this->job->pickup_company_id,
            'destination_company' => $this->job->destination_company_id,
            'cargo' => $this->job->cargo_id,
            'started_at' => $this->job->started_at,
            'distance' => $this->job->distance,
            'load_damage' => $this->job->load_damage,
            'estimated_income' => $this->job->estimated_income,
            'total_income' => $this->job->total_income,
            'comments' => $this->job->comments,
        ]);

        // If job is ATS
        if ($this->job->game_id === 2) {
            // Convert distance to miles
            $this->distance = round($this->job->distance / 1.609);

            // Convert incomes to dollars
            $this->estimated_income = round($this->job->estimated_income / 0.83);
            $this->total_income = round($this->job->total_income / 0.83);
        }
    }

    public function rules(): array
    {
        return [
            'pickup_city' => ['required', 'integer', 'exists:App\Models\City,id'],
            'destination_city' => ['required', 'integer', 'exists:App\Models\City,id'],
            'pickup_company' => ['required', 'integer', 'exists:App\Models\Company,id'],
            'destination_company' => ['required', 'integer', 'exists:App\Models\Company,id'],
            'cargo' => ['required', 'integer', 'exists:App\Models\Cargo,id'],
            'distance' => ['required', 'integer', 'min:1', 'max:5000'],
            'load_damage' => ['required', 'integer', 'min:0', 'max:100'],
            'estimated_income' => ['required', 'integer', 'min:1', 'max:400000'],
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
        return view('livewire.jobs.edit-page')->extends('layouts.app');
    }

    public function submit()
    {
        $validatedData = $this->validate();

        $this->job->update([
            'pickup_city_id' => $validatedData['pickup_city'],
            'destination_city_id' => $validatedData['destination_city'],
            'pickup_company_id' => $validatedData['pickup_company'],
            'destination_company_id' => $validatedData['destination_company'],
            'cargo_id' => $validatedData['cargo'],
            'distance' => $validatedData['distance'],
            'load_damage' => $validatedData['load_damage'],
            'total_income' => $validatedData['total_income'],
            'comments' => $validatedData['comments'],
        ]);

        session()->flash('alert', ['type' => 'success', 'message' => 'Job successfully edited!']);

        return redirect()->route('jobs.show', $this->job);
    }
}
